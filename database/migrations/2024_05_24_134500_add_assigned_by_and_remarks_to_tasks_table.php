<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedByAndRemarksToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('assigned_user_id')->nullable()->after('description');
            $table->unsignedBigInteger('assigned_by_id')->nullable()->after('assigned_user_id');
            $table->text('remarks')->nullable()->after('description'); // Adjust the column order as needed

            // Foreign key constraints (assuming users table exists)
            $table->foreign('assigned_user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assigned_by_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['assigned_user_id']);
            $table->dropForeign(['assigned_by_id']);
            $table->dropColumn('assigned_user_id');
            $table->dropColumn('assigned_by_id');
            $table->dropColumn('remarks');
        });
    }
}
