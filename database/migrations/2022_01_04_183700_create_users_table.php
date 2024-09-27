<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token', 80)->nullable()->unique();
            $table->string('locale', 64)->nullable();
            $table->string('timezone', 64)->nullable();
            $table->rememberToken();
            $table->integer('role')->default(0);
            $table->unsignedInteger('plan_id')->default(1)->index('plan_id');
            $table->string('plan_amount', 32)->nullable();
            $table->string('plan_currency', 12)->nullable();
            $table->string('plan_interval', 16)->nullable();
            $table->string('plan_payment_processor', 32)->nullable();
            $table->string('plan_subscription_id', 128)->nullable();
            $table->string('plan_subscription_status', 32)->nullable();
            $table->timestamp('plan_created_at')->nullable();
            $table->timestamp('plan_recurring_at')->nullable();
            $table->timestamp('plan_trial_ends_at')->nullable();
            $table->timestamp('plan_ends_at')->nullable();
            $table->text('billing_information')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
