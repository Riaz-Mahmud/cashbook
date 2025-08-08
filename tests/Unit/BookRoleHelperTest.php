<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\Business;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookRoleHelperTest extends TestCase
{
    use RefreshDatabase;

    protected $business;
    protected $book;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->business = Business::factory()->create();
        $this->book = Book::factory()->create(['business_id' => $this->business->id]);
        $this->user = User::factory()->create();

        $this->business->users()->attach($this->user->id, ['role' => 'staff']);
    }

    /** @test */
    public function user_book_role_returns_correct_role()
    {
        // Attach user to book as manager
        $this->book->users()->attach($this->user->id, ['role' => 'manager']);

        $role = $this->user->getBookRole($this->book);

        $this->assertEquals('manager', $role);
    }

    /** @test */
    public function user_book_role_returns_null_when_no_access()
    {
        // User not attached to book
        $role = $this->user->getBookRole($this->book);

        $this->assertNull($role);
    }

    /** @test */
    public function business_owner_has_manager_access_to_all_books()
    {
        // Make user business owner
        $this->business->users()->updateExistingPivot($this->user->id, ['role' => 'owner']);

        $role = $this->user->getBookRole($this->book);

        $this->assertEquals('manager', $role);
    }

    /** @test */
    public function business_admin_has_manager_access_to_all_books()
    {
        // Make user business admin
        $this->business->users()->updateExistingPivot($this->user->id, ['role' => 'admin']);

        $role = $this->user->getBookRole($this->book);

        $this->assertEquals('manager', $role);
    }

    /** @test */
    public function user_can_check_specific_book_permissions()
    {
        // Test manager permissions
        $this->book->users()->attach($this->user->id, ['role' => 'manager']);

        $this->assertTrue($this->user->canManageBook($this->book));
        $this->assertTrue($this->user->canEditBook($this->book));
        $this->assertTrue($this->user->canViewBook($this->book));

        // Test editor permissions
        $this->book->users()->updateExistingPivot($this->user->id, ['role' => 'editor']);

        $this->assertFalse($this->user->canManageBook($this->book));
        $this->assertTrue($this->user->canEditBook($this->book));
        $this->assertTrue($this->user->canViewBook($this->book));

        // Test viewer permissions
        $this->book->users()->updateExistingPivot($this->user->id, ['role' => 'viewer']);

        $this->assertFalse($this->user->canManageBook($this->book));
        $this->assertFalse($this->user->canEditBook($this->book));
        $this->assertTrue($this->user->canViewBook($this->book));

        // Test no access
        $this->book->users()->detach($this->user->id);

        $this->assertFalse($this->user->canManageBook($this->book));
        $this->assertFalse($this->user->canEditBook($this->book));
        $this->assertFalse($this->user->canViewBook($this->book));
    }

    /** @test */
    public function book_can_check_user_permissions()
    {
        $this->book->users()->attach($this->user->id, ['role' => 'editor']);

        $this->assertTrue($this->book->userHasAccess($this->user));
        $this->assertTrue($this->book->userCanEdit($this->user));
        $this->assertFalse($this->book->userCanManage($this->user));

        // Test with different user
        $otherUser = User::factory()->create();
        $this->business->users()->attach($otherUser->id, ['role' => 'staff']);

        $this->assertFalse($this->book->userHasAccess($otherUser));
        $this->assertFalse($this->book->userCanEdit($otherUser));
        $this->assertFalse($this->book->userCanManage($otherUser));
    }

    /** @test */
    public function accessible_books_query_works_correctly()
    {
        // Create additional books
        $book2 = Book::factory()->create(['business_id' => $this->business->id]);
        $book3 = Book::factory()->create(['business_id' => $this->business->id]);

        // Give user access to book1 and book2 only
        $this->book->users()->attach($this->user->id, ['role' => 'viewer']);
        $book2->users()->attach($this->user->id, ['role' => 'editor']);

        $accessibleBooks = $this->user->accessibleBooks($this->business);

        $this->assertCount(2, $accessibleBooks);
        $this->assertTrue($accessibleBooks->contains($this->book));
        $this->assertTrue($accessibleBooks->contains($book2));
        $this->assertFalse($accessibleBooks->contains($book3));
    }

    /** @test */
    public function business_owner_sees_all_books_as_accessible()
    {
        // Make user business owner
        $this->business->users()->updateExistingPivot($this->user->id, ['role' => 'owner']);

        // Create additional books
        $book2 = Book::factory()->create(['business_id' => $this->business->id]);
        $book3 = Book::factory()->create(['business_id' => $this->business->id]);

        $accessibleBooks = $this->user->accessibleBooks($this->business);

        $this->assertCount(3, $accessibleBooks);
        $this->assertTrue($accessibleBooks->contains($this->book));
        $this->assertTrue($accessibleBooks->contains($book2));
        $this->assertTrue($accessibleBooks->contains($book3));
    }
}
