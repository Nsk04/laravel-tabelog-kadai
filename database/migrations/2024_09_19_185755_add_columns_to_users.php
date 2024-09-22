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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number');
            $table->string('post_code');
            $table->text('address');
            $table->boolean('premium_member');
            $table->date('premium_member_expiration')->nullable();
            $table->date('cancellation_date')->nullable()->after('premium_member_expiration');
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
            $table->dropColumn('phone_number');
            $table->dropColumn('posta_code');
            $table->dropColumn('address');
            $table->dropColumn('premium_member');
            $table->dropColumn('premium_member_expiration');
            $table->dropColumn('cancellation_date');
        });
    }
};
