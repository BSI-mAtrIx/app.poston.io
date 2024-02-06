<?php
/*
Addon Name: NVX Theme Dashboard Dynamic Price Helper
Unique Name: price
Addon URI: https:/nvxgroup.com
Author: Mario Devado
Author URI: https:/nvxgroup.com
Version: 1.0
Description: NVX Theme Dashboard helper
*/
require_once("application/controllers/Home.php"); // loading home controller
include("application/libraries/Facebook/autoload.php");


class Price extends Home
{
    public $key = "70591F6C003CF201";
    private $product_id = 7;
    private $product_base = "price_dynamic";
    private $server_host = "https://nvxgroup.com/wp-json/licensor/";
    private $nvx_version = 1.0;
    /* @var self */
    private static $selfobj = null;
    public $fb;


    public $addon_data = array();

    public function __construct()
    {
        parent::__construct();
        //$this->load->config('instagram_reply_config');// config
        // getting addon information in array and storing to public variable
        // addon_name,unique_name,module_id,addon_uri,author,author_uri,version,description,controller_name,installed
        //------------------------------------------------------------------------------------------
        $addon_path = APPPATH . "modules/" . strtolower($this->router->fetch_class()) . "/controllers/" . ucfirst($this->router->fetch_class()) . ".php"; // path of addon controller
        $addondata = $this->get_addon_data($addon_path);
        $this->addon_data = $addondata;
        $this->user_id = $this->session->userdata('user_id'); // user_id of logged in user, we may need it

        $function_name = $this->uri->segment(2);
        if ($function_name != "webhook_callback")  //todo: cronjob
        {
            // all addon must be login protected
            //------------------------------------------------------------------------------------------
            if ($this->session->userdata('logged_in') != 1) redirect('home/login', 'location');
            // if you want the addon to be accessed by admin and member who has permission to this addon
            //-------------------------------------------------------------------------------------------

            switch ($function_name) {
                case 'plan_list';
                case 'save_plan';
                case 'edit_plan';
                    if ($this->session->userdata('user_type') != 'Admin') {
                        redirect('home/login_page', 'location');
                        exit();
                    }
                    break;
            }


        }

        $this->load->library('encryption');

        $addon_lang = 'n_theme';
        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_lang.php')) {
            $this->lang->load($addon_lang, $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        } else {
            $this->lang->load($addon_lang, 'english', FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/english');
        }


        if (file_exists(APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language . '/' . $addon_lang . '_custom_lang.php')) {
            $this->lang->load($addon_lang . '_custom', $this->language, FALSE, TRUE, APPPATH . 'modules/' . $addon_lang . '/language/' . $this->language);
        }

    }


    public function index()
    {
        if ($this->session->userdata('logged_in') != 1) exit();

        if ($this->session->userdata('user_type') != 'Admin')
            redirect('home/login_page', 'location');

        exit;

//        $data['title'] = $this->lang->line('Instagram accounts');
//        $data['body'] = 'account_import';
//        $data['page_title'] = $data['title'];
//
//        $this->_viewcontroller($data);
    }

    public function plan_list(){
        $data = array();
        $data['body'] = 'n_addon_loader';
        $data['addon_page'] = 'view_plan_list';
        $data['page_title'] = $this->lang->line('Dynamic Price Plan Configuration');
        $data['csrf_token'] = $this->session->userdata('csrf_token_session');


        $this->_viewcontroller($data);
    }

    public function edit_plan($id=0){

    }

    public function save_plan(){
        if ($this->is_demo == '1') {
            echo "<h2 style='text-align:center;color:red;border:1px solid red; padding: 10px'>This feature is disabled in this demo.</h2>";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        if ($_POST) {

            $this->csrf_token_check();

            // validation
            $this->form_validation->set_rules('use_nviews_login_page', '<b>' . $this->lang->line("Use NVX theme login page style?") . '</b>', 'trim');
            $this->form_validation->set_rules('rtl_langs', '<b>' . $this->lang->line("RTL languages, use comma for seperate language") . '</b>', 'trim');
            $this->form_validation->set_rules('current_theme', '<b>' . $this->lang->line("Default color scheme") . '</b>', 'trim');
            $this->form_validation->set_rules('recommend_photoswipe_resolution', '<b>' . $this->lang->line("Photoswipe (full view photo) recommend photo resolution. 0x0 is auto") . '</b>', 'trim');
            $this->form_validation->set_rules('hide_login_via_email', '<b>' . $this->lang->line("Hide login via email on login page") . '</b>', 'trim');
            $this->form_validation->set_rules('show_renew_button', '<b>' . $this->lang->line("Show renew button for trial package and before expire X days") . '</b>', 'trim');
            $this->form_validation->set_rules('show_renew_button_days', '<b>' . $this->lang->line("Before X days show renew button (disabled if renew button hidden)") . '</b>', 'trim');
            $this->form_validation->set_rules('livicon_icon_style', '<b>' . $this->lang->line("Sidebar icon style") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_icons', '<b>' . $this->lang->line("Sidebar icon Family") . '</b>', 'trim');

            $this->form_validation->set_rules('dashboard_section_1_on', '<b>' . $this->lang->line("Custom dashboard section (view for all)") . '</b>', 'trim');
            $this->form_validation->set_rules('dashboard_section_1_only_admin', '<b>' . $this->lang->line("Custom dashboard section (view for admin)") . '</b>', 'trim');
            $this->form_validation->set_rules('dashboard_section_1_default', '<b>' . $this->lang->line("Default display if not found translation (empty for no display)") . '</b>', 'trim');

            $this->form_validation->set_rules('page_help_view', '<b>' . $this->lang->line("Help page editor (BETA)") . '</b>', 'trim');
            $this->form_validation->set_rules('page_help_only_admin', '<b>' . $this->lang->line("Help page (only view for admin)") . '</b>', 'trim');
            $this->form_validation->set_rules('page_help_default', '<b>' . $this->lang->line("Default display if not found translation (empty for no display)") . '</b>', 'trim');

            $this->form_validation->set_rules('page_faq_view', '<b>' . $this->lang->line("FAQ page editor (BETA)") . '</b>', 'trim');
            $this->form_validation->set_rules('page_faq_only_admin', '<b>' . $this->lang->line("FAQ page (only view for admin)") . '</b>', 'trim');
            $this->form_validation->set_rules('page_faq_default', '<b>' . $this->lang->line("Default display if not found translation (empty for no display)") . '</b>', 'trim');

            $this->form_validation->set_rules('greetings_on', '<b>' . $this->lang->line("Show greetings") . '</b>', 'trim');
            $this->form_validation->set_rules('greetings_random', '<b>' . $this->lang->line("Type greetings") . '</b>', 'trim');

            $this->form_validation->set_rules('start_modal_show', '<b>' . $this->lang->line("Welcome modal (view for all)") . '</b>', 'trim');
            $this->form_validation->set_rules('start_modal_only_admin', '<b>' . $this->lang->line("Welcome modal (only view for admin)") . '</b>', 'trim');
            $this->form_validation->set_rules('start_modal_default', '<b>' . $this->lang->line("Default welcome modal (empty for no display)") . '</b>', 'trim');
            $this->form_validation->set_rules('start_modal_always_show', '<b>' . $this->lang->line("Welcome modal always show on start dashboard") . '</b>', 'trim');
            $this->form_validation->set_rules('login_page_text_show', '<b>' . $this->lang->line("Login page text (replace image)") . '</b>', 'trim');
            $this->form_validation->set_rules('login_page_text_default', '<b>' . $this->lang->line("Default display if not found translation (empty for no display)") . '</b>', 'trim');

            $this->form_validation->set_rules('disable_example_dashboard', '<b>' . $this->lang->line("Show example dashboard button") . '</b>', 'trim');

            $this->form_validation->set_rules('ecommerce_product_gallery', '<b>' . $this->lang->line("Max photos in product gallery") . '</b>', 'trim');

            $this->form_validation->set_rules('default_lang_flowbuilder', '<b>' . $this->lang->line("Default language flow builder") . '</b>', 'trim');
            $this->form_validation->set_rules('default_flowbuilder', '<b>' . $this->lang->line("Version flow builder") . '</b>', 'trim');
            $this->form_validation->set_rules('show_lang_selector', '<b>' . $this->lang->line("Hide language selector") . '</b>', 'trim');


            $this->form_validation->set_rules('is_external_off', '<b>' . $this->lang->line("Menu manager is_external open in new cart?") . '</b>', 'trim');
            $this->form_validation->set_rules('payment_text_header_sidebar', '<b>' . $this->lang->line("Sidebar menu: Payment header text") . '</b>', 'trim');
            $this->form_validation->set_rules('payment_text_sidebar', '<b>' . $this->lang->line("Sidebar menu: Payment link tex") . '</b>', 'trim');


            $this->form_validation->set_rules('pwa_on', '<b>' . $this->lang->line("PWA On / Off") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_name', '<b>' . $this->lang->line("PWA app name") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_short_name', '<b>' . $this->lang->line("PWA app short name") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_description', '<b>' . $this->lang->line("PWA app description") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_theme_color', '<b>' . $this->lang->line("PWA theme color") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_background_color', '<b>' . $this->lang->line("PWA background color") . '</b>', 'trim');

            $this->form_validation->set_rules('pwa_apple_status_bar', '<b>' . $this->lang->line("apple-mobile-web-app-status-bar-style") . '</b>', 'trim');

            $this->form_validation->set_rules('eco_custom_domain', '<b>' . $this->lang->line("Custom domain") . '</b>', 'trim');
            $this->form_validation->set_rules('custom_domain_host', '<b>' . $this->lang->line("Main URL host (your app)") . '</b>', 'trim');

            $this->form_validation->set_rules('wildcard_domain', '<b>' . $this->lang->line("Wildcard Domain for ecommerce / landing page builder without http") . '</b>', 'trim');


            $this->form_validation->set_rules('theme_appeareance_on', '<b>' . $this->lang->line("theme_appeareance_on") . '</b>', 'trim');
            $this->form_validation->set_rules('theme_sidebar_color', '<b>' . $this->lang->line("theme_sidebar_color") . '</b>', 'trim');
            $this->form_validation->set_rules('dark_icon_color', '<b>' . $this->lang->line("dark_icon_color") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_text_color', '<b>' . $this->lang->line("sidebar_text_color") . '</b>', 'trim');
            $this->form_validation->set_rules('primary_color', '<b>' . $this->lang->line("primary_color") . '</b>', 'trim');
            $this->form_validation->set_rules('btn_primary_color_hover', '<b>' . $this->lang->line("Button primary hover color") . '</b>', 'trim');
            $this->form_validation->set_rules('dashboard_background', '<b>' . $this->lang->line("dashboard_background") . '</b>', 'trim');

            $this->form_validation->set_rules('light_primary_color', '<b>' . $this->lang->line("light_primary_color") . '</b>', 'trim');

            $this->form_validation->set_rules('danger_color', '<b>' . $this->lang->line("danger_color") . '</b>', 'trim');

            $this->form_validation->set_rules('success_color', '<b>' . $this->lang->line("success_color") . '</b>', 'trim');
            $this->form_validation->set_rules('warning_color', '<b>' . $this->lang->line("warning_color") . '</b>', 'trim');

            $this->form_validation->set_rules('nav_font', '<b>' . $this->lang->line("nav_font") . '</b>', 'trim');

            $this->form_validation->set_rules('body_font', '<b>' . $this->lang->line("body_font") . '</b>', 'trim');

            $this->form_validation->set_rules('nav_font_rtl', '<b>' . $this->lang->line("nav_font_rtl") . '</b>', 'trim');
            $this->form_validation->set_rules('body_font_rtl', '<b>' . $this->lang->line("body_font_rtl") . '</b>', 'trim');
            $this->form_validation->set_rules('primary_color_hover', '<b>' . $this->lang->line("primary_color_hover") . '</b>', 'trim');
            $this->form_validation->set_rules('primary_outline_color', '<b>' . $this->lang->line("primary_outline_color") . '</b>', 'trim');

            $this->form_validation->set_rules('body_font_font_size', '<b>' . $this->lang->line("body_font_font_size") . '</b>', 'trim');
            $this->form_validation->set_rules('card_title_font_size', '<b>' . $this->lang->line("card_title_font_size") . '</b>', 'trim');
            $this->form_validation->set_rules('body_font_font_size_rtl', '<b>' . $this->lang->line("body_font_font_size_rtl") . '</b>', 'trim');
            $this->form_validation->set_rules('card_title_font_size_rtl', '<b>' . $this->lang->line("card_title_font_size_rtl") . '</b>', 'trim');

            $this->form_validation->set_rules('signup_page_view', '<b>' . $this->lang->line("signup_page_view") . '</b>', 'trim');
            $this->form_validation->set_rules('signup_page_default_view', '<b>' . $this->lang->line("signup_page_default_view") . '</b>', 'trim');
            $this->form_validation->set_rules('helper_default_lang', '<b>' . $this->lang->line("helper_default_lang") . '</b>', 'trim');
            $this->form_validation->set_rules('helper_animation', '<b>' . $this->lang->line("helper_animation") . '</b>', 'trim');

            $this->form_validation->set_rules('package_qa_show', '<b>' . $this->lang->line("package_qa_show") . '</b>', 'trim');
            $this->form_validation->set_rules('package_qa_only_admin', '<b>' . $this->lang->line("package_qa_only_admin") . '</b>', 'trim');
            $this->form_validation->set_rules('package_qa_default', '<b>' . $this->lang->line("package_qa_default") . '</b>', 'trim');

            $this->form_validation->set_rules('spain_lang_icon', '<b>' . $this->lang->line("spain_lang_icon") . '</b>', 'trim');

            $this->form_validation->set_rules('welcome_modal_button_text_arabic', '<b>' . $this->lang->line("welcome_modal_button_text_arabic") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_english', '<b>' . $this->lang->line("welcome_modal_button_text_english") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_bengali', '<b>' . $this->lang->line("welcome_modal_button_text_bengali") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_dutch', '<b>' . $this->lang->line("welcome_modal_button_text_dutch") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_english', '<b>' . $this->lang->line("welcome_modal_button_text_english") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_french', '<b>' . $this->lang->line("welcome_modal_button_text_french") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_german', '<b>' . $this->lang->line("welcome_modal_button_text_german") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_greek', '<b>' . $this->lang->line("welcome_modal_button_text_greek") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_italian', '<b>' . $this->lang->line("welcome_modal_button_text_italian") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_polish', '<b>' . $this->lang->line("welcome_modal_button_text_polish") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_portuguese', '<b>' . $this->lang->line("welcome_modal_button_text_portuguese") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_russian', '<b>' . $this->lang->line("welcome_modal_button_text_russian") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_spanish', '<b>' . $this->lang->line("welcome_modal_button_text_spanish") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_turkish', '<b>' . $this->lang->line("welcome_modal_button_text_turkish") . '</b>', 'trim');
            $this->form_validation->set_rules('welcome_modal_button_text_vietnamese', '<b>' . $this->lang->line("welcome_modal_button_text_vietnamese") . '</b>', 'trim');


            $this->form_validation->set_rules('sidebar_icon_help_bx', '<b>' . $this->lang->line("sidebar_icon_help_bx") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_icon_help_livicons', '<b>' . $this->lang->line("sidebar_icon_help_livicons") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_icon_faq_bx', '<b>' . $this->lang->line("sidebar_icon_faq_bx") . '</b>', 'trim');
            $this->form_validation->set_rules('sidebar_icon_faq_livicons', '<b>' . $this->lang->line("sidebar_icon_faq_livicons") . '</b>', 'trim');


            $this->form_validation->set_rules('n_paymongo_gateway_enabled', '<b>' . $this->lang->line("n_paymongo_gateway_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_gateway_gcash_enabled', '<b>' . $this->lang->line("n_paymongo_gateway_gcash_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_gateway_paymaya_enabled', '<b>' . $this->lang->line("n_paymongo_gateway_paymaya_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_gateway_grab_enabled', '<b>' . $this->lang->line("n_paymongo_gateway_grab_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_sec', '<b>' . $this->lang->line("n_paymongo_sec") . '</b>', 'trim');
            $this->form_validation->set_rules('n_paymongo_pub', '<b>' . $this->lang->line("n_paymongo_pub") . '</b>', 'trim');

            $this->form_validation->set_rules('theme_mobile_full_width', '<b>' . $this->lang->line("theme_mobile_full_width") . '</b>', 'trim');
            $this->form_validation->set_rules('import_account_fb_alert', '<b>' . $this->lang->line("import_account_fb_alert") . '</b>', 'trim');

            $this->form_validation->set_rules('account_activation_view', '<b>' . $this->lang->line("account_activation_view") . '</b>', 'trim');
            $this->form_validation->set_rules('account_activation_default_view', '<b>' . $this->lang->line("account_activation_default_view") . '</b>', 'trim');
            $this->form_validation->set_rules('forgot_password_view', '<b>' . $this->lang->line("forgot_password_view") . '</b>', 'trim');
            $this->form_validation->set_rules('forgot_password_default_view', '<b>' . $this->lang->line("forgot_password_default_view") . '</b>', 'trim');

            $this->form_validation->set_rules('current_sidebar', '<b>' . $this->lang->line("current_sidebar") . '</b>', 'trim');


            $this->form_validation->set_rules('n_payu_latam_sandbox', '<b>' . $this->lang->line("n_payu_latam_sandbox") . '</b>', 'trim');
            $this->form_validation->set_rules('n_payu_latam_enabled', '<b>' . $this->lang->line("n_payu_latam_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_payu_latam_merchantid', '<b>' . $this->lang->line("n_payu_latam_merchantid") . '</b>', 'trim');
            $this->form_validation->set_rules('n_payu_latam_accountid', '<b>' . $this->lang->line("n_payu_latam_accountid") . '</b>', 'trim');
            $this->form_validation->set_rules('n_payu_latam_api_key', '<b>' . $this->lang->line("n_payu_latam_api_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_coinbase_enabled', '<b>' . $this->lang->line("n_coinbase_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_coinbase_shared_secret', '<b>' . $this->lang->line("n_coinbase_shared_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_coinbase_api_key', '<b>' . $this->lang->line("n_coinbase_api_key") . '</b>', 'trim');
            $this->form_validation->set_rules('dashboard_section_init', '<b>' . $this->lang->line("dashboard_section_init") . '</b>', 'trim');

            $this->form_validation->set_rules('login_change_language', '<b>' . $this->lang->line("login_change_language") . '</b>', 'trim');

            $this->form_validation->set_rules('n_moamalat_enabled', '<b>' . $this->lang->line("n_moamalat_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_testmode', '<b>' . $this->lang->line("n_moamalat_testmode") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_merchant_id', '<b>' . $this->lang->line("n_moamalat_merchant_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_terminal_id', '<b>' . $this->lang->line("n_moamalat_terminal_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_moamalat_secret_key', '<b>' . $this->lang->line("n_moamalat_secret_key") . '</b>', 'trim');

            $this->form_validation->set_rules('n_sadad_enabled', '<b>' . $this->lang->line("n_sadad_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sadad_testmode', '<b>' . $this->lang->line("n_sadad_testmode") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sadad_secret_key', '<b>' . $this->lang->line("n_sadad_secret_key") . '</b>', 'trim');

            $this->form_validation->set_rules('sitemap_disable', '<b>' . $this->lang->line("sitemap_disable") . '</b>', 'trim');
            $this->form_validation->set_rules('webhook_disable', '<b>' . $this->lang->line("webhook_disable") . '</b>', 'trim');
            $this->form_validation->set_rules('pwa_disable', '<b>' . $this->lang->line("pwa_disable") . '</b>', 'trim');

            $this->form_validation->set_rules('n_tdsp_auth_key', '<b>' . $this->lang->line("n_tdsp_auth_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tdsp_store_id', '<b>' . $this->lang->line("n_tdsp_store_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tdsp_sandbox', '<b>' . $this->lang->line("n_tdsp_sandbox") . '</b>', 'trim');
            $this->form_validation->set_rules('n_tdsp_enabled', '<b>' . $this->lang->line("n_tdsp_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('n_stripe_product_image', '<b>' . $this->lang->line("n_stripe_product_image") . '</b>', 'trim');
            $this->form_validation->set_rules('n_stripe_secret_key', '<b>' . $this->lang->line("n_stripe_secret_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_stripe_enabled', '<b>' . $this->lang->line("n_stripe_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_stripe_subscription_enabled', '<b>' . $this->lang->line("n_stripe_subscription_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('onesignal_enabled', '<b>' . $this->lang->line("onesignal_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('onesignal_app_key', '<b>' . $this->lang->line("onesignal_app_key") . '</b>', 'trim');
            $this->form_validation->set_rules('saved_template_hide_save_btn', '<b>' . $this->lang->line("saved_template_hide_save_btn") . '</b>', 'trim');

            $this->form_validation->set_rules('n_mastercard_merchant_id', '<b>' . $this->lang->line("n_mastercard_merchant_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_mastercard_api_pass', '<b>' . $this->lang->line("n_mastercard_api_pass") . '</b>', 'trim');
            $this->form_validation->set_rules('n_mastercard_enabled', '<b>' . $this->lang->line("n_mastercard_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_mastercard_testmode', '<b>' . $this->lang->line("n_mastercard_testmode") . '</b>', 'trim');

            $this->form_validation->set_rules('n_epayco_pkey', '<b>' . $this->lang->line("n_epayco_pkey") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_api_private_key', '<b>' . $this->lang->line("n_epayco_api_private_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_enabled', '<b>' . $this->lang->line("n_epayco_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_testmode', '<b>' . $this->lang->line("n_epayco_testmode") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_checkout', '<b>' . $this->lang->line("n_epayco_checkout") . '</b>', 'trim');
            $this->form_validation->set_rules('n_epayco_subs_enabled', '<b>' . $this->lang->line("n_epayco_subs_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('n_sellix_api_key', '<b>' . $this->lang->line("n_sellix_api_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_webhook_secret', '<b>' . $this->lang->line("n_sellix_webhook_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_merchant', '<b>' . $this->lang->line("n_sellix_merchant") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_enabled', '<b>' . $this->lang->line("n_sellix_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_sellix_subs_enabled', '<b>' . $this->lang->line("n_sellix_subs_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_credits_on', '<b>' . $this->lang->line("n_credits_on") . '</b>', 'trim');

            $this->form_validation->set_rules('n_chapa_secret_key', '<b>' . $this->lang->line("n_chapa_secret_key") . '</b>', 'trim');
            $this->form_validation->set_rules('n_chapa_enabled', '<b>' . $this->lang->line("n_chapa_enabled") . '</b>', 'trim');

            $this->form_validation->set_rules('n_zaincash_enabled', '<b>' . $this->lang->line("n_zaincash_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_testmode_enabled', '<b>' . $this->lang->line("n_zaincash_testmode_enabled") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_merchant_secret', '<b>' . $this->lang->line("n_zaincash_merchant_secret") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_MSISDN', '<b>' . $this->lang->line("n_zaincash_MSISDN") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_merchant_id', '<b>' . $this->lang->line("n_zaincash_merchant_id") . '</b>', 'trim');
            $this->form_validation->set_rules('n_zaincash_convert_price', '<b>' . $this->lang->line("n_zaincash_convert_price") . '</b>', 'trim');

            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->settings();
            } else {
                // assign
                $use_nviews_login_page = addslashes(strip_tags($this->input->post('use_nviews_login_page', true)));
                $rtl_langs = addslashes(strip_tags($this->input->post('rtl_langs', true)));
                $current_theme = addslashes(strip_tags($this->input->post('current_theme', true)));
                $recommend_photoswipe_resolution = addslashes(strip_tags($this->input->post('recommend_photoswipe_resolution', true)));
                $hide_login_via_email = addslashes(strip_tags($this->input->post('hide_login_via_email', true)));
                $show_renew_button = addslashes(strip_tags($this->input->post('show_renew_button', true)));
                $show_renew_button_days = addslashes(strip_tags($this->input->post('show_renew_button_days', true)));
                $livicon_icon_style = addslashes(strip_tags($this->input->post('livicon_icon_style', true)));
                $sidebar_icons = addslashes(strip_tags($this->input->post('sidebar_icons', true)));
                $arabic_lang_icon = addslashes(strip_tags($this->input->post('arabic_lang_icon', true)));
                $hebrew_lang_icon = addslashes(strip_tags($this->input->post('hebrew_lang_icon', true)));
                $dashboard_section_1_on = addslashes(strip_tags($this->input->post('dashboard_section_1_on', true)));
                $dashboard_section_1_only_admin = addslashes(strip_tags($this->input->post('dashboard_section_1_only_admin', true)));
                $dashboard_section_1_default = addslashes(strip_tags($this->input->post('dashboard_section_1_default', true)));
                $page_help_view = addslashes(strip_tags($this->input->post('page_help_view', true)));
                $page_help_only_admin = addslashes(strip_tags($this->input->post('page_help_only_admin', true)));
                $page_help_default = addslashes(strip_tags($this->input->post('page_help_default', true)));

                $page_faq_view = addslashes(strip_tags($this->input->post('page_faq_view', true)));
                $page_faq_only_admin = addslashes(strip_tags($this->input->post('page_faq_only_admin', true)));
                $page_faq_default = addslashes(strip_tags($this->input->post('page_faq_default', true)));

                $greetings_on = addslashes(strip_tags($this->input->post('greetings_on', true)));
                $greetings_random = addslashes(strip_tags($this->input->post('greetings_random', true)));

                $start_modal_show = addslashes(strip_tags($this->input->post('start_modal_show', true)));
                $start_modal_only_admin = addslashes(strip_tags($this->input->post('start_modal_only_admin', true)));
                $start_modal_default = addslashes(strip_tags($this->input->post('start_modal_default', true)));
                $start_modal_always_show = addslashes(strip_tags($this->input->post('start_modal_always_show', true)));

                $login_page_text_show = addslashes(strip_tags($this->input->post('login_page_text_show', true)));
                $login_page_text_default = addslashes(strip_tags($this->input->post('login_page_text_default', true)));
                $disable_example_dashboard = addslashes(strip_tags($this->input->post('disable_example_dashboard', true)));
                $ecommerce_product_gallery = addslashes(strip_tags($this->input->post('ecommerce_product_gallery', true)));

                $default_lang_flowbuilder = addslashes(strip_tags($this->input->post('default_lang_flowbuilder', true)));
                $default_flowbuilder = addslashes(strip_tags($this->input->post('default_flowbuilder', true)));
                $show_lang_selector = addslashes(strip_tags($this->input->post('show_lang_selector', true)));

                $is_external_off = addslashes(strip_tags($this->input->post('is_external_off', true)));
                $payment_text_header_sidebar = addslashes(strip_tags($this->input->post('payment_text_header_sidebar', true)));
                $payment_text_sidebar = addslashes(strip_tags($this->input->post('payment_text_sidebar', true)));

                $pwa_on = addslashes(strip_tags($this->input->post('pwa_on', true)));
                $pwa_name = addslashes(strip_tags($this->input->post('pwa_name', true)));
                $pwa_short_name = addslashes(strip_tags($this->input->post('pwa_short_name', true)));
                $pwa_description = addslashes(strip_tags($this->input->post('pwa_description', true)));

                $pwa_theme_color = addslashes(strip_tags($this->input->post('pwa_theme_color', true)));
                $pwa_background_color = addslashes(strip_tags($this->input->post('pwa_background_color', true)));

                $pwa_apple_status_bar = addslashes(strip_tags($this->input->post('pwa_apple_status_bar', true)));

                $base_path = realpath(APPPATH . '../assets/img');

                $eco_custom_domain = addslashes(strip_tags($this->input->post('eco_custom_domain', true)));
                $custom_domain_host = addslashes(strip_tags($this->input->post('custom_domain_host', true)));

                $wildcard_domain = addslashes(strip_tags($this->input->post('wildcard_domain', true)));

                $theme_appeareance_on = addslashes(strip_tags($this->input->post('theme_appeareance_on', true)));
                $theme_sidebar_color = addslashes(strip_tags($this->input->post('theme_sidebar_color', true)));
                $dark_icon_color = addslashes(strip_tags($this->input->post('dark_icon_color', true)));
                $sidebar_text_color = addslashes(strip_tags($this->input->post('sidebar_text_color', true)));

                $primary_color = addslashes(strip_tags($this->input->post('primary_color', true)));
                $btn_primary_color_hover = addslashes(strip_tags($this->input->post('btn_primary_color_hover', true)));
                $dashboard_background = addslashes(strip_tags($this->input->post('dashboard_background', true)));
                $light_primary_color = addslashes(strip_tags($this->input->post('light_primary_color', true)));
                $danger_color = addslashes(strip_tags($this->input->post('danger_color', true)));
                $success_color = addslashes(strip_tags($this->input->post('success_color', true)));

                $warning_color = addslashes(strip_tags($this->input->post('warning_color', true)));
                $nav_font = addslashes(strip_tags($this->input->post('nav_font', true)));
                $body_font = addslashes(strip_tags($this->input->post('body_font', true)));
                $nav_font_rtl = addslashes(strip_tags($this->input->post('nav_font_rtl', true)));
                $body_font_rtl = addslashes(strip_tags($this->input->post('body_font_rtl', true)));

                $primary_color_hover = addslashes(strip_tags($this->input->post('primary_color_hover', true)));

                $primary_outline_color = addslashes(strip_tags($this->input->post('primary_outline_color', true)));

                $body_font_font_size = addslashes(strip_tags($this->input->post('body_font_font_size', true)));
                $card_title_font_size = addslashes(strip_tags($this->input->post('card_title_font_size', true)));

                $body_font_font_size_rtl = addslashes(strip_tags($this->input->post('body_font_font_size_rtl', true)));
                $card_title_font_size_rtl = addslashes(strip_tags($this->input->post('card_title_font_size_rtl', true)));

                $signup_page_view = addslashes(strip_tags($this->input->post('signup_page_view', true)));
                $signup_page_default_view = addslashes(strip_tags($this->input->post('signup_page_default_view', true)));

                $helper_default_lang = addslashes(strip_tags($this->input->post('helper_default_lang', true)));
                $helper_animation = addslashes(strip_tags($this->input->post('helper_animation', true)));

                $package_qa_show = addslashes(strip_tags($this->input->post('package_qa_show', true)));

                $package_qa_only_admin = addslashes(strip_tags($this->input->post('package_qa_only_admin', true)));
                $package_qa_default = addslashes(strip_tags($this->input->post('package_qa_default', true)));

                $spain_lang_icon = addslashes(strip_tags($this->input->post('spain_lang_icon', true)));

                $welcome_modal_button_text_arabic = addslashes(strip_tags($this->input->post('welcome_modal_button_text_arabic', true)));
                $welcome_modal_button_text_english = addslashes(strip_tags($this->input->post('welcome_modal_button_text_english', true)));
                $welcome_modal_button_text_bengali = addslashes(strip_tags($this->input->post('welcome_modal_button_text_bengali', true)));
                $welcome_modal_button_text_dutch = addslashes(strip_tags($this->input->post('welcome_modal_button_text_dutch', true)));
                $welcome_modal_button_text_english = addslashes(strip_tags($this->input->post('welcome_modal_button_text_english', true)));
                $welcome_modal_button_text_french = addslashes(strip_tags($this->input->post('welcome_modal_button_text_french', true)));
                $welcome_modal_button_text_german = addslashes(strip_tags($this->input->post('welcome_modal_button_text_german', true)));
                $welcome_modal_button_text_greek = addslashes(strip_tags($this->input->post('welcome_modal_button_text_greek', true)));
                $welcome_modal_button_text_italian = addslashes(strip_tags($this->input->post('welcome_modal_button_text_italian', true)));
                $welcome_modal_button_text_polish = addslashes(strip_tags($this->input->post('welcome_modal_button_text_polish', true)));
                $welcome_modal_button_text_portuguese = addslashes(strip_tags($this->input->post('welcome_modal_button_text_portuguese', true)));
                $welcome_modal_button_text_russian = addslashes(strip_tags($this->input->post('welcome_modal_button_text_russian', true)));
                $welcome_modal_button_text_spanish = addslashes(strip_tags($this->input->post('welcome_modal_button_text_spanish', true)));
                $welcome_modal_button_text_turkish = addslashes(strip_tags($this->input->post('welcome_modal_button_text_turkish', true)));
                $welcome_modal_button_text_vietnamese = addslashes(strip_tags($this->input->post('welcome_modal_button_text_vietnamese', true)));

                $sidebar_icon_help_bx = addslashes(strip_tags($this->input->post('sidebar_icon_help_bx', true)));
                $sidebar_icon_help_livicons = addslashes(strip_tags($this->input->post('sidebar_icon_help_livicons', true)));
                $sidebar_icon_faq_bx = addslashes(strip_tags($this->input->post('sidebar_icon_faq_bx', true)));
                $sidebar_icon_faq_livicons = addslashes(strip_tags($this->input->post('sidebar_icon_faq_livicons', true)));

                $n_paymongo_gateway_enabled = addslashes(strip_tags($this->input->post('n_paymongo_gateway_enabled', true)));
                $n_paymongo_gateway_gcash_enabled = addslashes(strip_tags($this->input->post('n_paymongo_gateway_gcash_enabled', true)));
                $n_paymongo_gateway_paymaya_enabled = addslashes(strip_tags($this->input->post('n_paymongo_gateway_paymaya_enabled', true)));
                $n_paymongo_gateway_grab_enabled = addslashes(strip_tags($this->input->post('n_paymongo_gateway_grab_enabled', true)));
                $n_paymongo_sec = addslashes(strip_tags($this->input->post('n_paymongo_sec', true)));
                $n_paymongo_pub = addslashes(strip_tags($this->input->post('n_paymongo_pub', true)));

                $theme_mobile_full_width = addslashes(strip_tags($this->input->post('theme_mobile_full_width', true)));
                $import_account_fb_alert = addslashes(strip_tags($this->input->post('import_account_fb_alert', true)));

                $account_activation_view = addslashes(strip_tags($this->input->post('account_activation_view', true)));
                $account_activation_default_view = addslashes(strip_tags($this->input->post('account_activation_default_view', true)));
                $forgot_password_view = addslashes(strip_tags($this->input->post('forgot_password_view', true)));
                $forgot_password_default_view = addslashes(strip_tags($this->input->post('forgot_password_default_view', true)));

                $current_sidebar = addslashes(strip_tags($this->input->post('current_sidebar', true)));

                $n_payu_latam_sandbox = addslashes(strip_tags($this->input->post('n_payu_latam_sandbox', true)));
                $n_payu_latam_enabled = addslashes(strip_tags($this->input->post('n_payu_latam_enabled', true)));
                $n_payu_latam_merchantid = addslashes(strip_tags($this->input->post('n_payu_latam_merchantid', true)));
                $n_payu_latam_accountid = addslashes(strip_tags($this->input->post('n_payu_latam_accountid', true)));
                $n_payu_latam_api_key = addslashes(strip_tags($this->input->post('n_payu_latam_api_key', true)));
                $n_coinbase_enabled = addslashes(strip_tags($this->input->post('n_coinbase_enabled', true)));
                $n_coinbase_shared_secret = addslashes(strip_tags($this->input->post('n_coinbase_shared_secret', true)));
                $n_coinbase_api_key = addslashes(strip_tags($this->input->post('n_coinbase_api_key', true)));
                $dashboard_section_init = addslashes(strip_tags($this->input->post('dashboard_section_init', true)));

                $login_change_language = addslashes(strip_tags($this->input->post('login_change_language', true)));

                $n_moamalat_enabled = addslashes(strip_tags($this->input->post('n_moamalat_enabled', true)));
                $n_moamalat_testmode = addslashes(strip_tags($this->input->post('n_moamalat_testmode', true)));
                $n_moamalat_merchant_id = addslashes(strip_tags($this->input->post('n_moamalat_merchant_id', true)));
                $n_moamalat_terminal_id = addslashes(strip_tags($this->input->post('n_moamalat_terminal_id', true)));
                $n_moamalat_secret_key = addslashes(strip_tags($this->input->post('n_moamalat_secret_key', true)));

                $n_sadad_enabled = addslashes(strip_tags($this->input->post('n_sadad_enabled', true)));
                $n_sadad_testmode = addslashes(strip_tags($this->input->post('n_sadad_testmode', true)));
                $n_sadad_secret_key = addslashes(strip_tags($this->input->post('n_sadad_secret_key', true)));

                $sitemap_disable = addslashes(strip_tags($this->input->post('sitemap_disable', true)));
                $webhook_disable = addslashes(strip_tags($this->input->post('webhook_disable', true)));
                $pwa_disable = addslashes(strip_tags($this->input->post('pwa_disable', true)));

                $n_tdsp_auth_key = addslashes(strip_tags($this->input->post('n_tdsp_auth_key', true)));
                $n_tdsp_store_id = addslashes(strip_tags($this->input->post('n_tdsp_store_id', true)));
                $n_tdsp_sandbox = addslashes(strip_tags($this->input->post('n_tdsp_sandbox', true)));
                $n_tdsp_enabled = addslashes(strip_tags($this->input->post('n_tdsp_enabled', true)));

                $n_stripe_product_image = addslashes(strip_tags($this->input->post('n_stripe_product_image', true)));
                $n_stripe_secret_key = addslashes(strip_tags($this->input->post('n_stripe_secret_key', true)));
                $n_stripe_enabled = addslashes(strip_tags($this->input->post('n_stripe_enabled', true)));
                $n_stripe_subscription_enabled = addslashes(strip_tags($this->input->post('n_stripe_subscription_enabled', true)));

                $onesignal_enabled = addslashes(strip_tags($this->input->post('onesignal_enabled', true)));
                $onesignal_app_key = addslashes(strip_tags($this->input->post('onesignal_app_key', true)));
                $saved_template_hide_save_btn = addslashes(strip_tags($this->input->post('saved_template_hide_save_btn', true)));

                $n_mastercard_merchant_id = addslashes(strip_tags($this->input->post('n_mastercard_merchant_id', true)));
                $n_mastercard_api_pass = addslashes(strip_tags($this->input->post('n_mastercard_api_pass', true)));
                $n_mastercard_enabled = addslashes(strip_tags($this->input->post('n_mastercard_enabled', true)));
                $n_mastercard_testmode = addslashes(strip_tags($this->input->post('n_mastercard_testmode', true)));

                $n_epayco_pkey = addslashes(strip_tags($this->input->post('n_epayco_pkey', true)));
                $n_epayco_enabled = addslashes(strip_tags($this->input->post('n_epayco_enabled', true)));
                $n_epayco_testmode = addslashes(strip_tags($this->input->post('n_epayco_testmode', true)));
                $n_epayco_checkout = addslashes(strip_tags($this->input->post('n_epayco_checkout', true)));
                $n_epayco_api_private_key = addslashes(strip_tags($this->input->post('n_epayco_api_private_key', true)));
                $n_epayco_subs_enabled = addslashes(strip_tags($this->input->post('n_epayco_subs_enabled', true)));

                $n_sellix_api_key = addslashes(strip_tags($this->input->post('n_sellix_api_key', true)));
                $n_sellix_webhook_secret = addslashes(strip_tags($this->input->post('n_sellix_webhook_secret', true)));
                $n_sellix_merchant = addslashes(strip_tags($this->input->post('n_sellix_merchant', true)));
                $n_sellix_enabled = addslashes(strip_tags($this->input->post('n_sellix_enabled', true)));
                $n_sellix_subs_enabled = addslashes(strip_tags($this->input->post('n_sellix_subs_enabled', true)));

                $n_credits_on = addslashes(strip_tags($this->input->post('n_credits_on', true)));

                $n_chapa_secret_key = addslashes(strip_tags($this->input->post('n_chapa_secret_key', true)));
                $n_chapa_enabled = addslashes(strip_tags($this->input->post('n_chapa_enabled', true)));

                $n_zaincash_enabled = addslashes(strip_tags($this->input->post('n_zaincash_enabled', true)));
                $n_zaincash_testmode_enabled = addslashes(strip_tags($this->input->post('n_zaincash_testmode_enabled', true)));
                $n_zaincash_merchant_secret = addslashes(strip_tags($this->input->post('n_zaincash_merchant_secret', true)));
                $n_zaincash_MSISDN = addslashes(strip_tags($this->input->post('n_zaincash_MSISDN', true)));
                $n_zaincash_merchant_id = addslashes(strip_tags($this->input->post('n_zaincash_merchant_id', true)));
                $n_zaincash_convert_price = addslashes(strip_tags($this->input->post('n_zaincash_convert_price', true)));

            }

            $this->load->library('upload');
            include(FCPATH . 'application/n_views/config.php');

            if ($n_moamalat_secret_key != '*****') {
                $n_moamalat_secret_key = openssl_encrypt($n_moamalat_secret_key, "AES-128-ECB", $n_config['cipher']);
            }


            $ios_splash = array('ipad_splash', 'ipadpro1_splash', 'ipadpro2_splash', 'ipadpro3_splash', 'iphone5_splash', 'iphone6_splash', 'iphoneplus_splash', 'iphonex_splash', 'iphonexr_splash', 'iphonexsmax_splash');
            $splash = array();
            foreach ($ios_splash as $k) {
                $splash[$k] = '';
                if (!empty($n_config[$k])) {
                    $splash[$k] = $n_config[$k];
                }
                if ($_FILES[$k]['size'] != 0) {
                    $photo = $k . ".png";
                    $config = array(
                        "allowed_types" => "png",
                        "upload_path" => $base_path,
                        "overwrite" => true,
                        "file_name" => $photo,
                        'max_size' => 5 * 1024 * 1024,
                        'max_width' => '3000',
                        'max_height' => '3000'
                    );
                    $this->upload->initialize($config);
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload($k)) {
                        $this->session->set_userdata($k, $this->upload->display_errors());
                        return $this->settings();
                    }
                    $splash[$k] = '/assets/img/' . $k . '.png';
                }
            }

            $pwa_icon_512 = '';
            if (!empty($n_config['pwa_icon_512'])) {
                $pwa_icon_512 = $n_config['pwa_icon_512'];
            }
            if ($_FILES['pwa_icon_512']['size'] != 0) {
                $photo = "pwa_icon_512.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '512',
                    'max_height' => '512'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('pwa_icon_512')) {
                    $this->session->set_userdata('pwa_icon_512', $this->upload->display_errors());
                    return $this->settings();
                }
                $pwa_icon_512 = '/assets/img/pwa_icon_512.png';
            }

            $dark_logo_path = '';
            if (!empty($n_config['dark_logo'])) {
                $dark_logo_path = $n_config['dark_logo'];
            }
            if ($_FILES['dark_logo']['size'] != 0) {
                $photo = "dark_logo.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dark_logo')) {
                    $this->session->set_userdata('dark_logo_error', $this->upload->display_errors());
                    return $this->settings();
                }
                $dark_logo_path = '/assets/img/dark_logo.png';
            }

            $light_icon_path = '';
            if (!empty($n_config['light_icon'])) {
                $light_icon_path = $n_config['light_icon'];
            }
            if ($_FILES['light_icon']['size'] != 0) {
                $photo = "light_icon.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('light_icon')) {
                    $this->session->set_userdata('light_icon', $this->upload->display_errors());
                    return $this->settings();
                }
                $light_icon_path = '/assets/img/light_icon.png';
            }

            $dark_icon_path = '';
            if (!empty($n_config['dark_icon'])) {
                $dark_icon_path = $n_config['dark_icon'];
            }
            if ($_FILES['dark_icon']['size'] != 0) {
                $photo = "dark_icon.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dark_icon')) {
                    $this->session->set_userdata('dark_icon', $this->upload->display_errors());
                    return $this->settings();
                }
                $dark_icon_path = '/assets/img/dark_icon.png';
            }

            $light_icon_rtl = '';
            if (!empty($n_config['light_icon_rtl'])) {
                $light_icon_rtl = $n_config['light_icon_rtl'];
            }
            if ($_FILES['light_icon_rtl']['size'] != 0) {
                $photo = "light_icon_rtl.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('light_icon_rtl')) {
                    $this->session->set_userdata('light_icon_rtl', $this->upload->display_errors());
                    return $this->settings();
                }
                $light_icon_rtl = '/assets/img/light_icon_rtl.png';
            }

            $dark_icon_rtl = '';
            if (!empty($n_config['dark_icon_rtl'])) {
                $dark_icon_rtl = $n_config['dark_icon_rtl'];
            }
            if ($_FILES['dark_icon_rtl']['size'] != 0) {
                $photo = "dark_icon_rtl.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dark_icon_rtl')) {
                    $this->session->set_userdata('dark_icon_rtl', $this->upload->display_errors());
                    return $this->settings();
                }
                $dark_icon_rtl = '/assets/img/dark_icon_rtl.png';
            }

            $dark_logo_rtl = '';
            if (!empty($n_config['dark_logo_rtl'])) {
                $dark_logo_rtl = $n_config['dark_logo_rtl'];
            }
            if ($_FILES['dark_logo_rtl']['size'] != 0) {
                $photo = "dark_logo_rtl.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('dark_logo_rtl')) {
                    $this->session->set_userdata('dark_logo_rtl', $this->upload->display_errors());
                    return $this->settings();
                }
                $dark_logo_rtl = '/assets/img/dark_logo_rtl.png';
            }

            $light_logo_rtl = '';
            if (!empty($n_config['light_logo_rtl'])) {
                $light_logo_rtl = $n_config['light_logo_rtl'];
            }
            if ($_FILES['light_logo_rtl']['size'] != 0) {
                $photo = "light_logo_rtl.png";
                $config = array(
                    "allowed_types" => "png",
                    "upload_path" => $base_path,
                    "overwrite" => true,
                    "file_name" => $photo,
                    'max_size' => 5 * 1024 * 1024,
                    'max_width' => '700',
                    'max_height' => '700'
                );
                $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('light_logo_rtl')) {
                    $this->session->set_userdata('light_logo_rtl', $this->upload->display_errors());
                    return $this->settings();
                }
                $light_logo_rtl = '/assets/img/light_logo_rtl.png';
            }


            $app_my_config_data = "<?php \n";
            $app_my_config_data .= "\$n_config['dev_mode'] = false;\n";
            $app_my_config_data .= "\$n_config['extra_function'] = false;\n";

            $app_my_config_data .= "\$n_config['dark_logo'] = '$dark_logo_path';\n";
            $app_my_config_data .= "\$n_config['light_icon'] = '$light_icon_path';\n";
            $app_my_config_data .= "\$n_config['dark_icon'] = '$dark_icon_path';\n";

            $app_my_config_data .= "\$n_config['use_nviews_login_page'] = '$use_nviews_login_page';\n";
            $app_my_config_data .= "\$n_config['rtl_langs'] = '$rtl_langs';\n";
            $app_my_config_data .= "\$n_config['current_theme'] = '$current_theme';\n";
            $app_my_config_data .= "\$n_config['recommend_photoswipe_resolution'] = '$recommend_photoswipe_resolution';\n";
            $app_my_config_data .= "\$n_config['hide_login_via_email'] = '$hide_login_via_email';\n";
            $app_my_config_data .= "\$n_config['show_renew_button'] = '$show_renew_button';\n";
            $app_my_config_data .= "\$n_config['show_renew_button_days'] = '$show_renew_button_days';\n";
            $app_my_config_data .= "\$n_config['livicon_icon_style'] = '$livicon_icon_style';\n";
            $app_my_config_data .= "\$n_config['sidebar_icons'] = '$sidebar_icons';\n";
            $app_my_config_data .= "\$n_config['arabic_lang_icon'] = '$arabic_lang_icon';\n";
            $app_my_config_data .= "\$n_config['hebrew_lang_icon'] = '$hebrew_lang_icon';\n";
            $app_my_config_data .= "\$n_config['dashboard_section_1_on'] = '$dashboard_section_1_on';\n";
            $app_my_config_data .= "\$n_config['dashboard_section_1_only_admin'] = '$dashboard_section_1_only_admin';\n";
            $app_my_config_data .= "\$n_config['dashboard_section_1_default'] = '$dashboard_section_1_default';\n";
            $app_my_config_data .= "\$n_config['page_help_default'] = '$page_help_default';\n";
            $app_my_config_data .= "\$n_config['page_help_only_admin'] = '$page_help_only_admin';\n";
            $app_my_config_data .= "\$n_config['page_help_view'] = '$page_help_view';\n";
            $app_my_config_data .= "\$n_config['page_faq_view'] = '$page_faq_view';\n";
            $app_my_config_data .= "\$n_config['page_faq_only_admin'] = '$page_faq_only_admin';\n";
            $app_my_config_data .= "\$n_config['page_faq_default'] = '$page_faq_default';\n";
            $app_my_config_data .= "\$n_config['greetings_on'] = '$greetings_on';\n";
            $app_my_config_data .= "\$n_config['greetings_random'] = '$greetings_random';\n";
            $app_my_config_data .= "\$n_config['start_modal_show'] = '$start_modal_show';\n";
            $app_my_config_data .= "\$n_config['start_modal_only_admin'] = '$start_modal_only_admin';\n";
            $app_my_config_data .= "\$n_config['start_modal_default'] = '$start_modal_default';\n";
            $app_my_config_data .= "\$n_config['start_modal_always_show'] = '$start_modal_always_show';\n";
            $app_my_config_data .= "\$n_config['login_page_text_show'] = '$login_page_text_show';\n";
            $app_my_config_data .= "\$n_config['login_page_text_default'] = '$login_page_text_default';\n";
            $app_my_config_data .= "\$n_config['disable_example_dashboard'] = '$disable_example_dashboard';\n";
            $app_my_config_data .= "\$n_config['ecommerce_product_gallery'] = '$ecommerce_product_gallery';\n";
            $app_my_config_data .= "\$n_config['default_lang_flowbuilder'] = '$default_lang_flowbuilder';\n";
            $app_my_config_data .= "\$n_config['default_flowbuilder'] = '$default_flowbuilder';\n";
            $app_my_config_data .= "\$n_config['show_lang_selector'] = '$show_lang_selector';\n";
            $app_my_config_data .= "\$n_config['is_external_off'] = '$is_external_off';\n";
            $app_my_config_data .= "\$n_config['payment_text_header_sidebar'] = '$payment_text_header_sidebar';\n";
            $app_my_config_data .= "\$n_config['payment_text_sidebar'] = '$payment_text_sidebar';\n";

            $app_my_config_data .= "\$n_config['pwa_on'] = '$pwa_on';\n";
            $app_my_config_data .= "\$n_config['pwa_name'] = '$pwa_name';\n";
            $app_my_config_data .= "\$n_config['pwa_short_name'] = '$pwa_short_name';\n";
            $app_my_config_data .= "\$n_config['pwa_description'] = '$pwa_description';\n";
            $app_my_config_data .= "\$n_config['pwa_theme_color'] = '$pwa_theme_color';\n";
            $app_my_config_data .= "\$n_config['pwa_background_color'] = '$pwa_background_color';\n";
            $app_my_config_data .= "\$n_config['pwa_icon_512'] = '$pwa_icon_512';\n";
            $app_my_config_data .= "\$n_config['pwa_apple_status_bar'] = '$pwa_apple_status_bar';\n";

            $app_my_config_data .= "\$n_config['eco_custom_domain'] = '$eco_custom_domain';\n";
            $app_my_config_data .= "\$n_config['custom_domain_host'] = '$custom_domain_host';\n";
            $app_my_config_data .= "\$n_config['wildcard_domain'] = '$wildcard_domain';\n";

            $app_my_config_data .= "\$n_config['theme_appeareance_on'] = '$theme_appeareance_on';\n";
            $app_my_config_data .= "\$n_config['theme_sidebar_color'] = '$theme_sidebar_color';\n";
            $app_my_config_data .= "\$n_config['dark_icon_color'] = '$dark_icon_color';\n";
            $app_my_config_data .= "\$n_config['sidebar_text_color'] = '$sidebar_text_color';\n";
            $app_my_config_data .= "\$n_config['primary_color'] = '$primary_color';\n";
            $app_my_config_data .= "\$n_config['light_primary_color'] = '$light_primary_color';\n";
            $app_my_config_data .= "\$n_config['danger_color'] = '$danger_color';\n";
            $app_my_config_data .= "\$n_config['success_color'] = '$success_color';\n";

            $app_my_config_data .= "\$n_config['warning_color'] = '$warning_color';\n";
            $app_my_config_data .= "\$n_config['nav_font'] = '$nav_font';\n";
            $app_my_config_data .= "\$n_config['body_font'] = '$body_font';\n";
            $app_my_config_data .= "\$n_config['nav_font_rtl'] = '$nav_font_rtl';\n";
            $app_my_config_data .= "\$n_config['body_font_rtl'] = '$body_font_rtl';\n";
            $app_my_config_data .= "\$n_config['light_icon_rtl'] = '$light_icon_rtl';\n";
            $app_my_config_data .= "\$n_config['dark_icon_rtl'] = '$dark_icon_rtl';\n";
            $app_my_config_data .= "\$n_config['dark_logo_rtl'] = '$dark_logo_rtl';\n";
            $app_my_config_data .= "\$n_config['light_logo_rtl'] = '$light_logo_rtl';\n";
            $app_my_config_data .= "\$n_config['primary_color_hover'] = '$primary_color_hover';\n";
            $app_my_config_data .= "\$n_config['primary_outline_color'] = '$primary_outline_color';\n";

            $app_my_config_data .= "\$n_config['body_font_font_size'] = '$body_font_font_size';\n";
            $app_my_config_data .= "\$n_config['card_title_font_size'] = '$card_title_font_size';\n";
            $app_my_config_data .= "\$n_config['body_font_font_size_rtl'] = '$body_font_font_size_rtl';\n";
            $app_my_config_data .= "\$n_config['card_title_font_size_rtl'] = '$card_title_font_size_rtl';\n";

            $app_my_config_data .= "\$n_config['signup_page_view'] = '$signup_page_view';\n";
            $app_my_config_data .= "\$n_config['signup_page_default_view'] = '$signup_page_default_view';\n";

            $app_my_config_data .= "\$n_config['helper_default_lang'] = '$helper_default_lang';\n";
            $app_my_config_data .= "\$n_config['helper_animation'] = '$helper_animation';\n";
            $app_my_config_data .= "\$n_config['package_qa_show'] = '$package_qa_show';\n";
            $app_my_config_data .= "\$n_config['package_qa_only_admin'] = '$package_qa_only_admin';\n";
            $app_my_config_data .= "\$n_config['package_qa_default'] = '$package_qa_default';\n";

            $app_my_config_data .= "\$n_config['welcome_modal_button_text_arabic'] = '$welcome_modal_button_text_arabic';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_english'] = '$welcome_modal_button_text_english';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_bengali'] = '$welcome_modal_button_text_bengali';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_dutch'] = '$welcome_modal_button_text_dutch';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_english'] = '$welcome_modal_button_text_english';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_french'] = '$welcome_modal_button_text_french';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_german'] = '$welcome_modal_button_text_german';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_greek'] = '$welcome_modal_button_text_greek';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_italian'] = '$welcome_modal_button_text_italian';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_polish'] = '$welcome_modal_button_text_polish';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_portuguese'] = '$welcome_modal_button_text_portuguese';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_russian'] = '$welcome_modal_button_text_russian';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_spanish'] = '$welcome_modal_button_text_spanish';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_turkish'] = '$welcome_modal_button_text_turkish';\n";
            $app_my_config_data .= "\$n_config['welcome_modal_button_text_vietnamese'] = '$welcome_modal_button_text_vietnamese';\n";

            $app_my_config_data .= "\$n_config['sidebar_icon_help_bx'] = '$sidebar_icon_help_bx';\n";
            $app_my_config_data .= "\$n_config['sidebar_icon_help_livicons'] = '$sidebar_icon_help_livicons';\n";
            $app_my_config_data .= "\$n_config['sidebar_icon_faq_bx'] = '$sidebar_icon_faq_bx';\n";
            $app_my_config_data .= "\$n_config['sidebar_icon_faq_livicons'] = '$sidebar_icon_faq_livicons';\n";

            $app_my_config_data .= "\$n_config['btn_primary_color_hover'] = '$btn_primary_color_hover';\n";
            $app_my_config_data .= "\$n_config['dashboard_background'] = '$dashboard_background';\n";

            $app_my_config_data .= "\$n_config['spain_lang_icon'] = '$spain_lang_icon';\n";

            $app_my_config_data .= "\$n_config['n_paymongo_gateway_enabled'] = '$n_paymongo_gateway_enabled';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_gateway_gcash_enabled'] = '$n_paymongo_gateway_gcash_enabled';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_gateway_paymaya_enabled'] = '$n_paymongo_gateway_paymaya_enabled';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_gateway_grab_enabled'] = '$n_paymongo_gateway_grab_enabled';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_sec'] = '$n_paymongo_sec';\n";
            $app_my_config_data .= "\$n_config['n_paymongo_pub'] = '$n_paymongo_pub';\n";

            $app_my_config_data .= "\$n_config['theme_mobile_full_width'] = '$theme_mobile_full_width';\n";
            $app_my_config_data .= "\$n_config['import_account_fb_alert'] = '$import_account_fb_alert';\n";

            $app_my_config_data .= "\$n_config['account_activation_view'] = '$account_activation_view';\n";
            $app_my_config_data .= "\$n_config['account_activation_default_view'] = '$account_activation_default_view';\n";
            $app_my_config_data .= "\$n_config['forgot_password_view'] = '$forgot_password_view';\n";
            $app_my_config_data .= "\$n_config['forgot_password_default_view'] = '$forgot_password_default_view';\n";
            $app_my_config_data .= "\$n_config['current_sidebar'] = '$current_sidebar';\n";

            $app_my_config_data .= "\$n_config['n_payu_latam_sandbox'] = '$n_payu_latam_sandbox';\n";
            $app_my_config_data .= "\$n_config['n_payu_latam_enabled'] = '$n_payu_latam_enabled';\n";
            $app_my_config_data .= "\$n_config['n_payu_latam_merchantid'] = '$n_payu_latam_merchantid';\n";
            $app_my_config_data .= "\$n_config['n_payu_latam_accountid'] = '$n_payu_latam_accountid';\n";
            $app_my_config_data .= "\$n_config['n_payu_latam_api_key'] = '$n_payu_latam_api_key';\n";
            $app_my_config_data .= "\$n_config['n_coinbase_enabled'] = '$n_coinbase_enabled';\n";
            $app_my_config_data .= "\$n_config['n_coinbase_shared_secret'] = '$n_coinbase_shared_secret';\n";
            $app_my_config_data .= "\$n_config['n_coinbase_api_key'] = '$n_coinbase_api_key';\n";
            $app_my_config_data .= "\$n_config['dashboard_section_init'] = '$dashboard_section_init';\n";

            $app_my_config_data .= "\$n_config['n_moamalat_enabled'] = '$n_moamalat_enabled';\n";
            $app_my_config_data .= "\$n_config['n_moamalat_testmode'] = '$n_moamalat_testmode';\n";
            $app_my_config_data .= "\$n_config['n_moamalat_merchant_id'] = '$n_moamalat_merchant_id';\n";
            $app_my_config_data .= "\$n_config['n_moamalat_terminal_id'] = '$n_moamalat_terminal_id';\n";

            $app_my_config_data .= "\$n_config['n_sadad_enabled'] = '$n_sadad_enabled';\n";
            $app_my_config_data .= "\$n_config['n_sadad_testmode'] = '$n_sadad_testmode';\n";
            $app_my_config_data .= "\$n_config['n_sadad_secret_key'] = '$n_sadad_secret_key';\n";

            $app_my_config_data .= "\$n_config['sitemap_disable'] = '$sitemap_disable';\n";
            $app_my_config_data .= "\$n_config['webhook_disable'] = '$webhook_disable';\n";
            $app_my_config_data .= "\$n_config['pwa_disable'] = '$pwa_disable';\n";

            $app_my_config_data .= "\$n_config['n_tdsp_auth_key'] = '$n_tdsp_auth_key';\n";
            $app_my_config_data .= "\$n_config['n_tdsp_store_id'] = '$n_tdsp_store_id';\n";
            $app_my_config_data .= "\$n_config['n_tdsp_sandbox'] = '$n_tdsp_sandbox';\n";
            $app_my_config_data .= "\$n_config['n_tdsp_enabled'] = '$n_tdsp_enabled';\n";

            $app_my_config_data .= "\$n_config['n_stripe_product_image'] = '$n_stripe_product_image';\n";
            $app_my_config_data .= "\$n_config['n_stripe_secret_key'] = '$n_stripe_secret_key';\n";
            $app_my_config_data .= "\$n_config['n_stripe_enabled'] = '$n_stripe_enabled';\n";
            $app_my_config_data .= "\$n_config['n_stripe_subscription_enabled'] = '$n_stripe_subscription_enabled';\n";

            $app_my_config_data .= "\$n_config['onesignal_enabled'] = '$onesignal_enabled';\n";
            $app_my_config_data .= "\$n_config['onesignal_app_key'] = '$onesignal_app_key';\n";
            $app_my_config_data .= "\$n_config['saved_template_hide_save_btn'] = '$saved_template_hide_save_btn';\n";

            $app_my_config_data .= "\$n_config['n_mastercard_merchant_id'] = '$n_mastercard_merchant_id';\n";
            $app_my_config_data .= "\$n_config['n_mastercard_api_pass'] = '$n_mastercard_api_pass';\n";
            $app_my_config_data .= "\$n_config['n_mastercard_enabled'] = '$n_mastercard_enabled';\n";
            $app_my_config_data .= "\$n_config['n_mastercard_testmode'] = '$n_mastercard_testmode';\n";

            $app_my_config_data .= "\$n_config['n_epayco_pkey'] = '$n_epayco_pkey';\n";
            $app_my_config_data .= "\$n_config['n_epayco_enabled'] = '$n_epayco_enabled';\n";
            $app_my_config_data .= "\$n_config['n_epayco_testmode'] = '$n_epayco_testmode';\n";
            $app_my_config_data .= "\$n_config['n_epayco_checkout'] = '$n_epayco_checkout';\n";
            $app_my_config_data .= "\$n_config['n_epayco_api_private_key'] = '$n_epayco_api_private_key';\n";
            $app_my_config_data .= "\$n_config['n_epayco_subs_enabled'] = '$n_epayco_subs_enabled';\n";

            if ($n_moamalat_secret_key != '*****') {
                $app_my_config_data .= "\$n_config['n_moamalat_secret_key'] = '$n_moamalat_secret_key';\n";
            }


            $app_my_config_data .= "\$n_config['login_change_language'] = '$login_change_language';\n";

            $app_my_config_data .= "\$n_config['n_sellix_api_key'] = '$n_sellix_api_key';\n";
            $app_my_config_data .= "\$n_config['n_sellix_webhook_secret'] = '$n_sellix_webhook_secret';\n";
            $app_my_config_data .= "\$n_config['n_sellix_merchant'] = '$n_sellix_merchant';\n";
            $app_my_config_data .= "\$n_config['n_sellix_enabled'] = '$n_sellix_enabled';\n";
            $app_my_config_data .= "\$n_config['n_sellix_subs_enabled'] = '$n_sellix_subs_enabled';\n";

            $app_my_config_data .= "\$n_config['n_credits_on'] = '$n_credits_on';\n";

            $app_my_config_data .= "\$n_config['n_chapa_secret_key'] = '$n_chapa_secret_key';\n";
            $app_my_config_data .= "\$n_config['n_chapa_enabled'] = '$n_chapa_enabled';\n";

            $app_my_config_data .= "\$n_config['n_zaincash_enabled'] = '$n_zaincash_enabled';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_testmode_enabled'] = '$n_zaincash_testmode_enabled';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_merchant_secret'] = '$n_zaincash_merchant_secret';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_MSISDN'] = '$n_zaincash_MSISDN';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_merchant_id'] = '$n_zaincash_merchant_id';\n";
            $app_my_config_data .= "\$n_config['n_zaincash_convert_price'] = '$n_zaincash_convert_price';\n";


            if(empty($n_config['new_cipher'])){
                $new_cipher = md5('e0c206d1376c35a2dc973cccb25c3155' . time() . base_url(''));
            }else{
                $new_cipher = $n_config['new_cipher'];
            }

            $app_my_config_data .= "\$n_config['new_cipher'] = '$new_cipher';\n";



            foreach ($splash as $k => $v) {
                $app_my_config_data .= "\$n_config['" . $k . "'] = '$v';\n";
            }

            file_put_contents(APPPATH . 'n_views/config_user.php', $app_my_config_data, LOCK_EX); //writting  application/config/my_config

            $eco_cd = "<?php \n";
            $eco_cd .= "\$ncd_config['eco_custom_domain'] = '$eco_custom_domain';\n";
            $eco_cd .= "\$ncd_config['custom_domain_host'] = '$custom_domain_host';\n";
            $eco_cd .= "\$ncd_config['wildcard_domain'] = '$wildcard_domain';\n";

            file_put_contents(APPPATH . 'custom_domain.php', $eco_cd, LOCK_EX); //writting  application/config/my_config

            if ($pwa_on == 'true') {
                $json_icons_arr = '';
                $size = array(384, 192, 180, 152, 144, 128, 120, 96, 76, 72);
                if (file_exists(FCPATH . '/assets/img/pwa_icon_512.png')) {
                    foreach ($size as $k) {
                        $img = $this->resize_image(FCPATH . '/assets/img/pwa_icon_512.png', $k, $k);
                        imagepng($img, FCPATH . '/assets/img/pwa_icon_' . $k . '.png');
                        $json_icons_arr .= ',
                            {
                                "src": "/assets/img/pwa_icon_' . $k . '.png",
                                "sizes": "' . $k . 'x' . $k . '",
                                "type": "image/png"
                            }';
                    }
                } else {
                    $pwa_icon_512 = '';
                }

                $simple_manifest_json = '{
                    "name": "' . $pwa_name . '",
                    "short_name": "' . $pwa_short_name . '",
                    "description": "' . $pwa_description . '",
                    "orientation": "portrait",
                    "start_url": "/?utm_source=pwa_homescreen",
                    "display": "standalone",
                    "theme_color": "' . $pwa_theme_color . '",
                    "background_color": "' . $pwa_background_color . '",
                    "related_applications": [{
						"platform": "webapp",
						"url": "' . base_url() . '/manifest.json"
					}],
                    "icons": [
                        {
                            "src": "' . $pwa_icon_512 . '",
                            "sizes": "512x512",
                            "type": "image/png"
                        }' . $json_icons_arr . '
                    ]
                }';

                file_put_contents(FCPATH . 'manifest.json', $simple_manifest_json, LOCK_EX);

                $serviceworker = "self.addEventListener('install', event => {

});

self.addEventListener('activate', event => {

});

self.addEventListener('fetch', event => {

});";


                file_put_contents(FCPATH . 'serviceworker.js', $serviceworker, LOCK_EX);


            } else {
                if (file_exists(FCPATH . 'manifest.json')) {
                    @unlink(FCPATH . 'manifest.json');
                    @unlink(FCPATH . 'serviceworker.json');
                }
            }

            $this->session->set_flashdata('success_message', 1);
            redirect('n_theme/settings', 'location');


        }


    }

}