<?php

namespace Tests\Feature;

use App\Console\Commands\ProcessRecurringTransactions;
use App\Models\Business;
use App\Models\Book;
use App\Models\Category;
use App\Models\RecurringTransaction;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\RecurringExecuted;
use App\Notifications\TransactionApproved;
use App\Notifications\TransactionRejected;
use App\Notifications\TransactionSubmitted;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_submission_sends_notification_to_admins(): void
    {
        Notification::fake();

    /** @var User $owner */
    $owner = User::factory()->create();
    /** @var User $staff */
    $staff = User::factory()->create();

        $business = Business::create(['name' => 'Acme', 'currency' => 'USD']);
        $business->users()->attach($owner->id, ['role' => 'owner']);
        $business->users()->attach($staff->id, ['role' => 'staff']);

        $book = Book::create(['name' => 'Main', 'business_id' => $business->id]);
        // Assign staff to the book
        DB::table('book_user')->insert([
            'book_id' => $book->id,
            'user_id' => $staff->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $category = Category::create(['name' => 'Sales', 'type' => 'income', 'business_id' => $business->id]);

        $this->actingAs($staff)
            ->withSession(['active_business_id' => $business->id])
            ->post(route('transactions.store'), [
                'book_id' => $book->id,
                'category_id' => $category->id,
                'amount' => 100,
                'type' => 'income',
                'transaction_date' => Carbon::today()->toDateString(),
                'description' => 'Test submission',
            ])->assertRedirect(route('transactions.index'));

        Notification::assertSentTo($owner, TransactionSubmitted::class);

        $this->assertDatabaseHas('transactions', [
            'business_id' => $business->id,
            'user_id' => $staff->id,
            'status' => 'pending',
            'amount' => 100,
        ]);
    }

    public function test_admin_approving_sends_notification_to_creator(): void
    {
        Notification::fake();

    /** @var User $owner */
    $owner = User::factory()->create();
    /** @var User $staff */
    $staff = User::factory()->create();
        $business = Business::create(['name' => 'Acme', 'currency' => 'USD']);
        $business->users()->attach($owner->id, ['role' => 'owner']);
        $business->users()->attach($staff->id, ['role' => 'staff']);
        $book = Book::create(['name' => 'Main', 'business_id' => $business->id]);
        $category = Category::create(['name' => 'Ops', 'type' => 'expense', 'business_id' => $business->id]);

        $tx = Transaction::create([
            'business_id' => $business->id,
            'book_id' => $book->id,
            'category_id' => $category->id,
            'user_id' => $staff->id,
            'amount' => 50,
            'type' => 'expense',
            'status' => 'pending',
            'transaction_date' => Carbon::today(),
        ]);

        $this->actingAs($owner)
            ->withSession(['active_business_id' => $business->id])
            ->post(route('transactions.approve', $tx))
            ->assertRedirect();

        Notification::assertSentTo($staff, TransactionApproved::class);

        $this->assertDatabaseHas('transactions', [
            'id' => $tx->id,
            'status' => 'approved',
        ]);
    }

    public function test_admin_rejecting_sends_notification_to_creator(): void
    {
        Notification::fake();

    /** @var User $owner */
    $owner = User::factory()->create();
    /** @var User $staff */
    $staff = User::factory()->create();
        $business = Business::create(['name' => 'Acme', 'currency' => 'USD']);
        $business->users()->attach($owner->id, ['role' => 'owner']);
        $business->users()->attach($staff->id, ['role' => 'staff']);
        $book = Book::create(['name' => 'Main', 'business_id' => $business->id]);
        $category = Category::create(['name' => 'Ops', 'type' => 'expense', 'business_id' => $business->id]);

        $tx = Transaction::create([
            'business_id' => $business->id,
            'book_id' => $book->id,
            'category_id' => $category->id,
            'user_id' => $staff->id,
            'amount' => 75,
            'type' => 'expense',
            'status' => 'pending',
            'transaction_date' => Carbon::today(),
        ]);

        $this->actingAs($owner)
            ->withSession(['active_business_id' => $business->id])
            ->post(route('transactions.reject', $tx))
            ->assertRedirect();

        Notification::assertSentTo($staff, TransactionRejected::class);

        $this->assertDatabaseHas('transactions', [
            'id' => $tx->id,
            'status' => 'rejected',
        ]);
    }

    public function test_recurring_command_sends_notifications(): void
    {
        Notification::fake();

    /** @var User $owner */
    $owner = User::factory()->create();
        $business = Business::create(['name' => 'Acme', 'currency' => 'USD']);
        $business->users()->attach($owner->id, ['role' => 'owner']);
        $book = Book::create(['name' => 'Main', 'business_id' => $business->id]);
        $category = Category::create(['name' => 'Rent', 'type' => 'expense', 'business_id' => $business->id]);

        $rec = RecurringTransaction::create([
            'business_id' => $business->id,
            'book_id' => $book->id,
            'category_id' => $category->id,
            'user_id' => $owner->id,
            'amount' => 1000,
            'type' => 'expense',
            'frequency' => 'monthly',
            'next_due_date' => Carbon::today()->subDay(),
            'description' => 'Office rent',
        ]);

        $this->artisan('cashbook:recurring:process')->assertExitCode(0);

        Notification::assertSentTo($owner, RecurringExecuted::class);

        $this->assertDatabaseHas('transactions', [
            'business_id' => $business->id,
            'book_id' => $book->id,
            'amount' => 1000,
            'status' => 'approved',
        ]);

        $rec->refresh();
        $this->assertTrue($rec->next_due_date->greaterThan(Carbon::today()));
    }
}
