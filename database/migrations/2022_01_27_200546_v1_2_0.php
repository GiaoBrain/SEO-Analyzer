<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class V120 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settings = array_combine(['custom_js', 'bad_words', 'request_connection_timeout', 'gsb', 'gsb_key', 'screenshot', 'screenshot_key'], ['tracking_code', 'report_bad_words', 'report_connection_timeout', 'report_gsb', 'report_gsb_key', 'report_screenshot', 'report_screenshot_key']);

        $sqlQuery = null;
        foreach($settings as $new => $old) {
            $sqlQuery .= "WHEN `name` = '" . $old . "' THEN '" . $new . "' ";
        }

        DB::update("UPDATE `settings` SET `name` = CASE " . $sqlQuery . " END WHERE `name` IN ('" . implode("', '", $settings) . "')");

        DB::table('settings')->insert(
            [
                ['name' => 'captcha_keyword_generator', 'value' => NULL],
                ['name' => 'captcha_serp_checker', 'value' => NULL],
                ['name' => 'captcha_indexed_pages_checker', 'value' => NULL],
                ['name' => 'request_user_agent', 'value' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36'],
                ['name' => 'gcs', 'value' => NULL],
                ['name' => 'gcs_key', 'value' => NULL],
                ['name' => 'gcs_id', 'value' => NULL]
            ]
        );
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
