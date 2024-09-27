<?php

/*
|--------------------------------------------------------------------------
| Web routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth routes
Auth::routes(['verify' => true]);
Route::post('login/tfa/validate', 'Auth\LoginController@validateTfaCode')->name('login.tfa.validate');
Route::post('login/tfa/resend', 'Auth\LoginController@resendTfaCode')->name('login.tfa.resend');

// Install routes
Route::prefix('install')->group(function () {
    Route::middleware('install')->group(function () {
        Route::get('/', 'InstallController@index')->name('install');
        Route::get('/requirements', 'InstallController@requirements')->name('install.requirements');
        Route::get('/permissions', 'InstallController@permissions')->name('install.permissions');
        Route::get('/database', 'InstallController@database')->name('install.database');
        Route::get('/account', 'InstallController@account')->name('install.account');

        Route::post('/database', 'InstallController@storeConfig');
        Route::post('/account', 'InstallController@storeDatabase');
    });

    Route::get('/complete', 'InstallController@complete')->name('install.complete');
});

// Update routes
Route::prefix('update')->group(function () {
    Route::middleware('installed')->group(function () {
        Route::get('/', 'UpdateController@index')->name('update');
        Route::get('/overview', 'UpdateController@overview')->name('update.overview');
        Route::get('/complete', 'UpdateController@complete')->name('update.complete');

        Route::post('/overview', 'UpdateController@updateDatabase');
    });
});

// Locale routes
Route::post('/locale', 'LocaleController@updateLocale')->name('locale');

// Home routes
Route::get('/', 'HomeController@index')->middleware('installed')->name('home');

// Contact routes
Route::get('/contact', 'ContactController@index')->name('contact');
Route::post('/contact', 'ContactController@send')->middleware('throttle:5,10');

// Pages routes
Route::get('/pages/{id}', 'PageController@show')->name('pages.show');

// Dashboard routes
Route::get('/dashboard', 'DashboardController@index')->middleware('verified')->name('dashboard');

//donate on the left sidebar
Route::get('/pages/business-model', 'DashboardController@index')->middleware('verified')->name('donate');

// Report routes
Route::get('/reports', 'ReportController@index')->middleware('verified')->name('reports');
Route::get('/reports/export', 'ReportController@export')->middleware('verified')->name('reports.export');
Route::get('/reports/{id}', 'ReportController@show')->name('reports.show');
Route::get('/reports/{id}/edit', 'ReportController@edit')->middleware('verified')->name('reports.edit');
Route::post('/reports/new', 'ReportController@store')->name('reports.new');
Route::post('/reports/{id}/edit', 'ReportController@update');
Route::post('/reports/{id}/destroy', 'ReportController@destroy')->name('reports.destroy');
Route::post('/reports/{id}/password', 'ReportController@validatePassword')->name('reports.password');

// Project routes
Route::get('/projects', 'ProjectController@index')->middleware('verified')->name('projects');
Route::get('/projects/export', 'ProjectController@export')->middleware('verified')->name('projects.export');
Route::post('/projects/{project}/destroy', 'ProjectController@destroy')->middleware('verified')->name('projects.destroy');

// Tool routes
Route::prefix('tools')->middleware('verified')->group(function () {
    Route::get('/', 'ToolController@index')->name('tools');

    Route::get('/serp-checker', 'ToolController@serpChecker')->name('tools.serp_checker');
    Route::post('/serp-checker', 'ToolController@processSerpChecker')->middleware('throttle:200,1440');

    Route::get('/indexed-pages-checker', 'ToolController@indexedPagesChecker')->name('tools.indexed_pages_checker');
    Route::post('/indexed-pages-checker', 'ToolController@processIndexedPagesChecker')->middleware('throttle:200,1440');

    Route::get('/keyword-research', 'ToolController@keywordResearch')->name('tools.keyword_research');
    Route::post('/keyword-research', 'ToolController@processKeywordResearch')->middleware('throttle:200,1440');

    Route::get('/website-status-checker', 'ToolController@websiteStatusChecker')->name('tools.website_status_checker');
    Route::post('/website-status-checker', 'ToolController@processWebsiteStatusChecker');

    Route::get('/ssl-checker', 'ToolController@sslChecker')->name('tools.ssl_checker');
    Route::post('/ssl-checker', 'ToolController@processSslChecker');

    Route::get('/whois-lookup', 'ToolController@whoisLookup')->name('tools.whois_lookup');
    Route::post('/whois-lookup', 'ToolController@processWhoisLookup');

    Route::get('/dns-lookup', 'ToolController@dnsLookup')->name('tools.dns_lookup');
    Route::post('/dns-lookup', 'ToolController@processDnsLookup');

    Route::get('/ip-lookup', 'ToolController@ipLookup')->name('tools.ip_lookup');
    Route::post('/ip-lookup', 'ToolController@processIpLookup');

    Route::get('/password-generator', 'ToolController@passwordGenerator')->name('tools.password_generator');
    Route::post('/password-generator', 'ToolController@processPasswordGenerator');

    Route::get('/js-minifier', 'ToolController@jsMinifier')->name('tools.js_minifier');
    Route::post('/js-minifier', 'ToolController@processJsMinifier');

    Route::get('/css-minifier', 'ToolController@cssMinifier')->name('tools.css_minifier');
    Route::post('/css-minifier', 'ToolController@processCssMinifier');

    Route::get('/html-minifier', 'ToolController@htmlMinifier')->name('tools.html_minifier');
    Route::post('/html-minifier', 'ToolController@processHtmlMinifier');

    Route::get('/qr-generator', 'ToolController@qrGenerator')->name('tools.qr_generator');
    Route::post('/qr-generator', 'ToolController@processQrGenerator');

    Route::get('/user-agent-parser', 'ToolController@userAgentParser')->name('tools.user_agent_parser');
    Route::post('/user-agent-parser', 'ToolController@processUserAgentParser');

    Route::get('/md5-generator', 'ToolController@md5Generator')->name('tools.md5_generator');
    Route::post('/md5-generator', 'ToolController@processMd5Generator');

    Route::get('/color-converter', 'ToolController@colorConverter')->name('tools.color_converter');
    Route::post('/color-converter', 'ToolController@processColorConverter');

    Route::get('/url-parser', 'ToolController@urlParser')->name('tools.url_parser');
    Route::post('/url-parser', 'ToolController@processUrlParser');

    Route::get('/uuid-generator', 'ToolController@uuidGenerator')->name('tools.uuid_generator');
    Route::post('/uuid-generator', 'ToolController@processUuidGenerator');

    Route::get('/lorem-ipsum-generator', 'ToolController@loremIpsumGenerator')->name('tools.lorem_ipsum_generator');
    Route::post('/lorem-ipsum-generator', 'ToolController@processLoremIpsumGenerator');

    Route::get('/word-counter', 'ToolController@wordCounter')->name('tools.word_counter');
    Route::post('/word-counter', 'ToolController@processWordCounter');

    Route::get('/case-converter', 'ToolController@caseConverter')->name('tools.case_converter');
    Route::post('/case-converter', 'ToolController@processCaseConverter');

    Route::get('/text-to-slug', 'ToolController@textToSlug')->name('tools.text_to_slug');
    Route::post('/text-to-slug', 'ToolController@processTextToSlug');

    Route::get('/url-converter', 'ToolController@urlConverter')->name('tools.url_converter');
    Route::post('/url-converter', 'ToolController@processUrlConverter');

    Route::get('/base64-converter', 'ToolController@base64Converter')->name('tools.base64_converter');
    Route::post('/base64-converter', 'ToolController@processBase64Converter');
});

// Account routes
Route::prefix('account')->middleware('verified')->group(function () {
    Route::get('/', 'AccountController@index')->name('account');

    Route::get('/profile', 'AccountController@profile')->name('account.profile');
    Route::post('/profile', 'AccountController@updateProfile')->name('account.profile.update');
    Route::post('/profile/resend', 'AccountController@resendAccountEmailConfirmation')->name('account.profile.resend');
    Route::post('/profile/cancel', 'AccountController@cancelAccountEmailConfirmation')->name('account.profile.cancel');

    Route::get('/security', 'AccountController@security')->name('account.security');
    Route::post('/security', 'AccountController@updateSecurity');

    Route::get('/preferences', 'AccountController@preferences')->name('account.preferences');
    Route::post('/preferences', 'AccountController@updatePreferences');

    Route::get('/plan', 'AccountController@plan')->middleware('payment')->name('account.plan');
    Route::post('/plan', 'AccountController@updatePlan')->middleware('payment');

    Route::get('/payments', 'AccountController@indexPayments')->middleware('payment')->name('account.payments');
    Route::get('/payments/{id}/edit', 'AccountController@editPayment')->middleware('payment')->name('account.payments.edit');
    Route::post('/payments/{id}/cancel', 'AccountController@cancelPayment')->name('account.payments.cancel');

    Route::get('/invoices/{id}', 'AccountController@showInvoice')->middleware('payment')->name('account.invoices.show');
	// deactivate api with #
    Route::get('#/api', 'AccountController@api')->name('account.api');
    Route::post('#/api', 'AccountController@updateApi');

    Route::get('/delete', 'AccountController@delete')->name('account.delete');
    Route::post('/destroy', 'AccountController@destroyUser')->name('account.destroy');
});

// Admin routes
Route::prefix('admin')->middleware('admin', 'license')->group(function () {
    Route::redirect('/', 'admin/dashboard');

    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/settings/{id}', 'AdminController@settings')->name('admin.settings');
    Route::post('/settings/{id}', 'AdminController@updateSetting');

    Route::get('/users', 'AdminController@indexUsers')->name('admin.users');
    Route::get('/users/new', 'AdminController@createUser')->name('admin.users.new');
    Route::get('/users/{id}/edit', 'AdminController@editUser')->name('admin.users.edit');
    Route::post('/users/new', 'AdminController@storeUser');
    Route::post('/users/{id}/edit', 'AdminController@updateUser');
    Route::post('/users/{id}/destroy', 'AdminController@destroyUser')->name('admin.users.destroy');
    Route::post('/users/{id}/disable', 'AdminController@disableUser')->name('admin.users.disable');
    Route::post('/users/{id}/restore', 'AdminController@restoreUser')->name('admin.users.restore');

    Route::get('/plans', 'AdminController@indexPlans')->name('admin.plans');
    Route::get('/plans/new', 'AdminController@createPlan')->name('admin.plans.new');
    Route::get('/plans/{id}/edit', 'AdminController@editPlan')->name('admin.plans.edit');
    Route::post('/plans/new', 'AdminController@storePlan');
    Route::post('/plans/{id}/edit', 'AdminController@updatePlan');
    Route::post('/plans/{id}/disable', 'AdminController@disablePlan')->name('admin.plans.disable');
    Route::post('/plans/{id}/restore', 'AdminController@restorePlan')->name('admin.plans.restore');

    Route::get('/tax-rates', 'AdminController@indexTaxRates')->name('admin.tax_rates');
    Route::get('/tax-rates/new', 'AdminController@createTaxRate')->name('admin.tax_rates.new');
    Route::get('/tax-rates/{id}/edit', 'AdminController@editTaxRate')->name('admin.tax_rates.edit');
    Route::post('/tax-rates/new', 'AdminController@storeTaxRate');
    Route::post('/tax-rates/{id}/edit', 'AdminController@updateTaxRate');
    Route::post('/tax-rates/{id}/disable', 'AdminController@disableTaxRate')->name('admin.tax_rates.disable');
    Route::post('/tax-rates/{id}/restore', 'AdminController@restoreTaxRate')->name('admin.tax_rates.restore');

    Route::get('/coupons', 'AdminController@indexCoupons')->name('admin.coupons');
    Route::get('/coupons/new', 'AdminController@createCoupon')->name('admin.coupons.new');
    Route::get('/coupons/{id}/edit', 'AdminController@editCoupon')->name('admin.coupons.edit');
    Route::post('/coupons/new', 'AdminController@storeCoupon');
    Route::post('/coupons/{id}/edit', 'AdminController@updateCoupon');
    Route::post('/coupons/{id}/disable', 'AdminController@disableCoupon')->name('admin.coupons.disable');
    Route::post('/coupons/{id}/restore', 'AdminController@restoreCoupon')->name('admin.coupons.restore');

    Route::get('/payments', 'AdminController@indexPayments')->name('admin.payments');
    Route::get('/payments/{id}/edit', 'AdminController@editPayment')->name('admin.payments.edit');
    Route::post('/payments/{id}/approve', 'AdminController@approvePayment')->name('admin.payments.approve');
    Route::post('/payments/{id}/cancel', 'AdminController@cancelPayment')->name('admin.payments.cancel');

    Route::get('/invoices/{id}', 'AdminController@showInvoice')->name('admin.invoices.show');

    Route::get('/pages', 'AdminController@indexPages')->name('admin.pages');
    Route::get('/pages/new', 'AdminController@createPage')->name('admin.pages.new');
    Route::get('/pages/{id}/edit', 'AdminController@editPage')->name('admin.pages.edit');
    Route::post('/pages/new', 'AdminController@storePage');
    Route::post('/pages/{id}/edit', 'AdminController@updatePage');
    Route::post('/pages/{id}/destroy', 'AdminController@destroyPage')->name('admin.pages.destroy');

    Route::get('/reports', 'AdminController@indexReports')->name('admin.reports');
    Route::get('/reports/{id}/edit', 'AdminController@editReport')->name('admin.reports.edit');
    Route::post('/reports/{id}/edit', 'AdminController@updateReport');
    Route::post('/reports/{id}/destroy', 'AdminController@destroyReport')->name('admin.reports.destroy');
});

// Pricing routes
Route::prefix('pricing')->middleware('payment')->group(function () {
    Route::get('/', 'PricingController@index')->name('pricing');
});

// Checkout routes
Route::prefix('checkout')->middleware('verified', 'payment')->group(function () {
    Route::get('/cancelled', 'CheckoutController@cancelled')->name('checkout.cancelled');
    Route::get('/pending', 'CheckoutController@pending')->name('checkout.pending');
    Route::get('/complete', 'CheckoutController@complete')->name('checkout.complete');

    Route::get('/{id}', 'CheckoutController@index')->name('checkout.index');
    Route::post('/{id}', 'CheckoutController@process');
});

// Cronjob routes
Route::prefix('cronjobs')->middleware('cronjob')->group(function () {
    Route::get('cache', 'CronjobController@cache')->name('cronjobs.cache');
    Route::get('clean', 'CronjobController@clean')->name('cronjobs.clean');
});

// Webhook routes
Route::post('webhooks/paypal', 'WebhookController@paypal')->name('webhooks.paypal');
Route::post('webhooks/stripe', 'WebhookController@stripe')->name('webhooks.stripe');
Route::post('webhooks/razorpay', 'WebhookController@razorpay')->name('webhooks.razorpay');
Route::post('webhooks/paystack', 'WebhookController@paystack')->name('webhooks.paystack');
Route::post('webhooks/cryptocom', 'WebhookController@cryptocom')->name('webhooks.cryptocom');
Route::post('webhooks/coinbase', 'WebhookController@coinbase')->name('webhooks.coinbase');

// Developer routes
/*Route::prefix('/developers')->group(function () {
    Route::get('/', 'DeveloperController@index')->name('developers');
    Route::get('/projects', 'DeveloperController@projects')->name('developers.projects');
    Route::get('/reports', 'DeveloperController@reports')->name('developers.reports');
    Route::get('/account', 'DeveloperController@account')->name('developers.account');
});*/

//deactivate dev functionality

Route::prefix('/developers')->group(function () {
    Route::get('#', 'DeveloperController@index')->name('developers');
    Route::get('#projects', 'DeveloperController@projects')->name('developers.projects');
    Route::get('#reports', 'DeveloperController@reports')->name('developers.reports');
    Route::get('#account', 'DeveloperController@account')->name('developers.account');
});