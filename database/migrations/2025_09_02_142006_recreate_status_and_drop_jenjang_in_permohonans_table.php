<?php

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
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['status', 'jenjang']);
        });

        Schema::table('permohonans', function (Blueprint $table) {
            $statuses = [
                'DRAFT',
                'SUBMITTED',
                'APPROVED_ADMINISTRATION',
                'REJECTED',
                'DIVISION_REVIEW',
                'PENDING_LETTER',
                'ACCEPTED',
                'CANCELLED'
            ];

            $table->enum('status', $statuses)->default('DRAFT')->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('permohonans', function (Blueprint $table) {
            $table->string('status')->default('draft');
            $table->unsignedTinyInteger('jenjang')->default(2)->after('status');
        });
    }
};
