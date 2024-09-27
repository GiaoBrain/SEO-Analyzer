<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class V140 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->unsignedInteger('position')->after('visibility')->nullable()->default(0);
        });

        Schema::table('users', function ($table) {
            $table->smallInteger('default_export_detailed')->after('default_privacy')->default(0)->nullable();
        });

        DB::table('settings')->insert([
            ['name' => 'ke', 'value' => 0],
            ['name' => 'ke_key', 'value' => ''],
            ['name' => 'ke_keywords', 'value' => 10]
        ]);

        $settings = array_combine(['request_timeout', 'captcha_keyword_research', 'ti', 'ti_key'], ['request_connection_timeout', 'captcha_keyword_generator', 'screenshot', 'screenshot_key']);

        $sqlQuery = null;
        foreach($settings as $new => $old) {
            $sqlQuery .= "WHEN `name` = '" . $old . "' THEN '" . $new . "' ";
        }

        DB::update("UPDATE `settings` SET `name` = CASE " . $sqlQuery . " END WHERE `name` IN ('" . implode("', '", $settings) . "')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
