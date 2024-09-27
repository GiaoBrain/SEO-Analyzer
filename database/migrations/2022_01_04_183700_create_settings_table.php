<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('name', 128)->primary();
            $table->text('value')->nullable();
        });

        DB::table('settings')->insert(
            [
                ['name' => 'announcement_guest', 'value' => NULL],
                ['name' => 'announcement_guest_id', 'value' => 'PORn7QrVMarbZGmr'],
                ['name' => 'announcement_guest_type', 'value' => 'primary'],
                ['name' => 'announcement_user', 'value' => NULL],
                ['name' => 'announcement_user_id', 'value' => 'Wu5yiu5Vj1cjmJvy'],
                ['name' => 'announcement_user_type', 'value' => 'danger'],
                ['name' => 'bank', 'value' => '0'],
                ['name' => 'bank_account_number', 'value' => NULL],
                ['name' => 'bank_account_owner', 'value' => NULL],
                ['name' => 'bank_bic_swift', 'value' => NULL],
                ['name' => 'bank_iban', 'value' => NULL],
                ['name' => 'bank_name', 'value' => NULL],
                ['name' => 'bank_routing_number', 'value' => NULL],
                ['name' => 'billing_address', 'value' => ''],
                ['name' => 'billing_city', 'value' => ''],
                ['name' => 'billing_country', 'value' => ''],
                ['name' => 'billing_invoice_prefix', 'value' => ''],
                ['name' => 'billing_phone', 'value' => ''],
                ['name' => 'billing_postal_code', 'value' => ''],
                ['name' => 'billing_state', 'value' => ''],
                ['name' => 'billing_vat_number', 'value' => ''],
                ['name' => 'billing_vendor', 'value' => ''],
                ['name' => 'captcha_contact', 'value' => '0'],
                ['name' => 'captcha_registration', 'value' => '0'],
                ['name' => 'captcha_secret_key', 'value' => NULL],
                ['name' => 'captcha_site_key', 'value' => NULL],
                ['name' => 'coinbase', 'value' => '0'],
                ['name' => 'coinbase_key', 'value' => NULL],
                ['name' => 'coinbase_wh_secret', 'value' => NULL],
                ['name' => 'contact_email', 'value' => NULL],
                ['name' => 'cronjob_key', 'value' => Str::random(60)],
                ['name' => 'custom_css', 'value' => '@import url("https://rsms.me/inter/inter.css");'],
                ['name' => 'demo_url', 'value' => ''],
                ['name' => 'email_address', 'value' => NULL],
                ['name' => 'email_driver', 'value' => 'log'],
                ['name' => 'email_encryption', 'value' => 'log'],
                ['name' => 'email_host', 'value' => NULL],
                ['name' => 'email_password', 'value' => NULL],
                ['name' => 'email_port', 'value' => NULL],
                ['name' => 'email_username', 'value' => NULL],
                ['name' => 'favicon', 'value' => 'favicon.png'],
                ['name' => 'index', 'value' => NULL],
                ['name' => 'legal_cookie_url', 'value' => NULL],
                ['name' => 'legal_privacy_url', 'value' => NULL],
                ['name' => 'legal_terms_url', 'value' => NULL],
                ['name' => 'license_key', 'value' => NULL],
                ['name' => 'license_type', 'value' => NULL],
                ['name' => 'locale', 'value' => 'en'],
                ['name' => 'logo', 'value' => 'logo.svg'],
                ['name' => 'paginate', 'value' => '10'],
                ['name' => 'paypal', 'value' => '0'],
                ['name' => 'paypal_client_id', 'value' => NULL],
                ['name' => 'paypal_mode', 'value' => 'sandbox'],
                ['name' => 'paypal_secret', 'value' => NULL],
                ['name' => 'paypal_webhook_id', 'value' => NULL],
                ['name' => 'registration', 'value' => '1'],
                ['name' => 'registration_verification', 'value' => '1'],
                ['name' => 'report_bad_words', 'value' => NULL],
                ['name' => 'report_connection_timeout', 'value' => '5'],
                ['name' => 'report_gsb', 'value' => '0'],
                ['name' => 'report_gsb_key', 'value' => NULL],
                ['name' => 'report_limit_deprecated_html_tags', 'value' => 'acronym
applet
basefont
big
center
dir
font
frame
frameset
isindex
noframes
s
strike
tt
u'],
                ['name' => 'report_limit_http_requests', 'value' => '50'],
                ['name' => 'report_limit_image_formats', 'value' => 'AVIF
WebP'],
                ['name' => 'report_limit_load_time', 'value' => '2'],
                ['name' => 'report_limit_max_dom_nodes', 'value' => '1500'],
                ['name' => 'report_limit_max_links', 'value' => '150'],
                ['name' => 'report_limit_max_title', 'value' => '60'],
                ['name' => 'report_limit_min_text_ratio', 'value' => '10'],
                ['name' => 'report_limit_min_title', 'value' => '1'],
                ['name' => 'report_limit_min_words', 'value' => '500'],
                ['name' => 'report_limit_page_size', 'value' => '330000'],
                ['name' => 'report_score_high', 'value' => '10'],
                ['name' => 'report_score_low', 'value' => '0'],
                ['name' => 'report_score_medium', 'value' => '5'],
                ['name' => 'report_screenshot', 'value' => '0'],
                ['name' => 'report_screenshot_key', 'value' => NULL],
                ['name' => 'social_facebook', 'value' => NULL],
                ['name' => 'social_instagram', 'value' => NULL],
                ['name' => 'social_twitter', 'value' => NULL],
                ['name' => 'social_youtube', 'value' => NULL],
                ['name' => 'stripe', 'value' => '0'],
                ['name' => 'stripe_key', 'value' => NULL],
                ['name' => 'stripe_secret', 'value' => NULL],
                ['name' => 'stripe_wh_secret', 'value' => NULL],
                ['name' => 'tagline', 'value' => 'Insightful and concise SEO reports'],
                ['name' => 'theme', 'value' => '0'],
                ['name' => 'timezone', 'value' => 'UTC'],
                ['name' => 'title', 'value' => 'phpRank'],
                ['name' => 'tracking_code', 'value' => NULL]
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
        Schema::dropIfExists('settings');
    }
}
