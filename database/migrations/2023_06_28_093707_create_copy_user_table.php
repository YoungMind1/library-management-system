<?php

use App\Models\Copy;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('copy_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable(false)->constrained();
            $table->foreignIdFor(Copy::class)->nullable(false)->constrained();
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copy_user');
    }
};
