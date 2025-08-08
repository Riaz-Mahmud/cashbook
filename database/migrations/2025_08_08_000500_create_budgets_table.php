<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->date('month'); // store as first day of month
            $table->decimal('amount', 15, 2);
            $table->timestamps();
            $table->unique(['business_id','category_id','month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
