<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->foreignId('divisi_id')
                ->nullable()
                ->after('user_id') 
                ->constrained('divisis') 
                ->onDelete('set null'); 

            $table->text('feedback')
                ->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('divisi_id');
            $table->dropColumn('feedback');
        });
    }
};
