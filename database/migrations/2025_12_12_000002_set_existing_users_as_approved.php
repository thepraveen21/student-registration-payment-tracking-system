<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mark all existing users as approved (they existed before the approval system)
        DB::table('users')->update(['approved' => true]);
    }

    public function down(): void
    {
        DB::table('users')->update(['approved' => false]);
    }
};
