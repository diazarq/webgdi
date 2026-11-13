<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVolunteerAndAffiliateSupport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role_type')) {
                $table->string('role_type', 30)->default('admin')->after('level');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'volunteer_type')) {
                $table->string('volunteer_type', 100)->nullable()->after('role_type');
            }
            if (!Schema::hasColumn('users', 'organisasi')) {
                $table->text('organisasi')->nullable()->after('volunteer_type');
            }
            if (!Schema::hasColumn('users', 'instansi')) {
                $table->string('instansi', 150)->nullable()->after('organisasi');
            }
            if (!Schema::hasColumn('users', 'domisili')) {
                $table->string('domisili', 100)->nullable()->after('instansi');
            }
            if (!Schema::hasColumn('users', 'status_approval')) {
                $table->string('status_approval', 20)->default('approved')->after('status');
            }
            if (!Schema::hasColumn('users', 'rejection_note')) {
                $table->text('rejection_note')->nullable()->after('status_approval');
            }
            if (!Schema::hasColumn('users', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('rejection_note');
            }
        });

        Schema::table('blogs', function (Blueprint $table) {
            if (!Schema::hasColumn('blogs', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('blogs', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('user_verify');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'role_type', 'phone', 'volunteer_type', 'organisasi', 
                'instansi', 'domisili', 'status_approval', 'rejection_note', 'approved_at'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'user_id')) {
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('blogs', 'admin_notes')) {
                $table->dropColumn('admin_notes');
            }
        });
    }
}

