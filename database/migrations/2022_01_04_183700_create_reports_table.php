<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index('user_id');
            $table->string('url', 2048);
            $table->string('domain', 255)->nullable()->index('domain');
            $table->tinyInteger('privacy')->nullable()->default(0);
            $table->text('password')->nullable();
            $table->mediumText('results')->nullable();
            $table->tinyInteger('result')->nullable()->index('result');
            $table->timestamp('generated_at')->nullable()->index('generated_at');
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
        Schema::dropIfExists('reports');
    }
}
