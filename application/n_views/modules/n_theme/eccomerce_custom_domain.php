<style>
    #pwa_splash label{text-wrap:wrap;}
</style>
<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("ecommerce"); ?>"><?php echo $this->lang->line("E-commerce"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message');
$include_prism = 1;
include(APPPATH . 'n_views/default_ecommerce_builder.php');
if (file_exists(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $custom_id . '.php')) {
    include(APPPATH . '/n_eco_user/builder/ecommerce_builder_' . $custom_id . '.php');
}

$imagecheck = function($part) use ($shop_id) {
    if (file_exists(FCPATH . 'upload/ecommerce/'.$shop_id.'_'.$part.'.png')) {
        echo '<a href="' . base_url() . 'upload/ecommerce/'.$shop_id.'_'.$part.'.png" target="_BLANK"><i class="text-success bx bxs-check-circle"></i></a>';
    }
};

?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">

                <div class="accordion" id="accordionWrapa1">
                    <div class="card collapse-header">
                        <div id="heading1" class="card-header" role="tablist" data-toggle="collapse"
                             data-target="#accordion1"
                             aria-expanded="false" aria-controls="accordion1">
                            <span class="collapse-title"><?php echo $this->lang->line("Custom Domain Settings"); ?></span>
                        </div>
                        <div id="accordion1" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading1"
                             class="collapse">
                            <div class="card-body p-0">
                                <div class="card">
                                    <div class="card-footer p-2" style="border:1px solid #e4e6fc">
                                        <?php if ($no_access) { ?>

                                            <div class="card-body p-0">
                                                <h4 class="card-title"><?php echo $this->lang->line('Permission denied'); ?></h4>
                                            </div>

                                        <?php } else { ?>

                                            <div class="card-body p-0">

                                                <form class="form-horizontal text-c"
                                                      action="<?php echo site_url() . 'n_theme/custom_domain_save'; ?>"
                                                      method="POST">
                                                    <input type="hidden" name="csrf_token" id="csrf_token"
                                                           value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                                                    <input type="hidden" name="custom_id" id="custom_id"
                                                           value="<?php echo $shop_id; ?>">
                                                    <input type="hidden" name="eco_custom_domain_current"
                                                           id="eco_custom_domain_current"
                                                           value="<?php echo $host_url; ?>">

                                                    <p><?php echo $this->lang->line("You can connect your own domain to an ecommerce store. Enter the domain name below without http, www."); ?></p>

                                                    <p><?php echo $this->lang->line("After changes domain please wait for action from administration. We need manually activate your domain."); ?></p>

                                                    <p><?php echo $this->lang->line("If you want delete existing custom domain, write DELETE to field new domain."); ?></p>

                                                    <fieldset class="form-group">
                                                        <?php
                                                        $new_cust_type = 'hidden';
                                                        if (!empty($host_url)) {
                                                            echo '<label for="eco_custom_domain_new">New custom domain:</label>';
                                                            $new_cust_type = 'text';
                                                        }
                                                        ?>
                                                        <input type="<?php echo $new_cust_type; ?>" class="form-control"
                                                               id="eco_custom_domain_new" name="eco_custom_domain_new"
                                                               value="">
                                                    </fieldset>


                                                    <fieldset class="form-group">
                                                        <?php if (!empty($host_url)) {
                                                            echo '<label for="eco_custom_domain">Current custom domain:</label>';
                                                        } ?>
                                                        <input type="text" class="form-control" id="eco_custom_domain"
                                                               name="eco_custom_domain"
                                                               value="<?php echo $host_url; ?>" <?php if (!empty($host_url)) {
                                                            echo 'disabled';
                                                        }; ?>>
                                                    </fieldset>
                                                    <span class="text-danger"><?php echo form_error('eco_custom_domain'); ?></span>

                                                    <div class="card-footer p-0">
                                                        <button class="btn btn-primary" id="save-btn" type="submit"><i
                                                                    class="bx bx-save"></i> <span
                                                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $pwa_disable = '';
                    if ($n_config['pwa_disable'] == 'true') {
                        $pwa_disable = 'd-none';
                    }
                    ?>


                    <div class="card collapse-header <?php echo $pwa_disable; ?>">
                        <div id="heading2" class="card-header" data-toggle="collapse" role="button"
                             data-target="#accordion2"
                             aria-expanded="false" aria-controls="accordion2">
                            <span class="collapse-title"><?php echo $this->lang->line("PWA"); ?></span>
                        </div>
                        <div id="accordion2" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading2"
                             class="collapse"
                             aria-expanded="false">
                            <div class="card-body p-0">
                                <div class="card" id="payment_options">
                                    <div class="card-footer p-2" style="border:1px solid #e4e6fc;">

                                        <div class="row">
                                            <div class="alert alert-warning mb-2 col-12" role="alert">
                                                <span><?php echo $this->lang->line('This options not work without custom domain'); ?></span>
                                            </div>
                                        </div>

                                        <form class="form-horizontal text-c" enctype="multipart/form-data"
                                              action="<?php echo site_url() . 'n_theme/custom_domain_pwa_save'; ?>"
                                              method="POST">
                                            <input type="hidden" name="csrf_token" id="csrf_token"
                                                   value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                                            <input type="hidden" name="custom_id" id="custom_id"
                                                   value="<?php echo $custom_id; ?>">
                                            <div class="pwa_settings">
                                                <div class="row">

                                                    <div class="col-12 col-md-6 mb-1">
                                                        <h6><?php echo $this->lang->line("PWA On / Off"); ?></h6>
                                                        <div class="form-group">
                                                            <?php
                                                            $select_lan = false;
                                                            if (isset($n_eco_builder_config['pwa_on'])) {
                                                                $select_lan = $n_eco_builder_config['pwa_on'];
                                                            }
                                                            $options = array();
                                                            $options['true'] = 'On';
                                                            $options['false'] = 'Off';

                                                            echo form_dropdown('pwa_on', $options, $select_lan, 'class="select2 form-control" id="pwa_on"'); ?>
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('pwa_on'); ?></span>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-1">
                                                        <fieldset>
                                                            <label for="pwa_name">PWA app name (used in the
                                                                banner)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                                class='bx bx-mobile-alt'></i></span>
                                                                </div>
                                                                <input type="text" id="pwa_name" name="pwa_name"
                                                                       class="form-control"
                                                                       value="<?php echo $n_eco_builder_config['pwa_name']; ?>">
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('pwa_name'); ?></span>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-1">
                                                        <fieldset>
                                                            <label for="pwa_short_name">PWA app short name (used on the
                                                                home screen)</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                                class='bx bx-mobile-alt'></i></span>
                                                                </div>
                                                                <input type="text" id="pwa_short_name"
                                                                       name="pwa_short_name" class="form-control"
                                                                       value="<?php echo $n_eco_builder_config['pwa_short_name']; ?>">
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('pwa_short_name'); ?></span>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-1">
                                                        <fieldset>
                                                            <label for="pwa_description">PWA app description</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                                class='bx bx-mobile-alt'></i></span>
                                                                </div>
                                                                <textarea type="text" id="pwa_description"
                                                                          name="pwa_description"
                                                                          class="form-control"><?php echo $n_eco_builder_config['pwa_description']; ?></textarea>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('pwa_description'); ?></span>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-1">
                                                        <fieldset>
                                                            <label for="pwa_theme_color">PWA theme color</label>
                                                            <div class="input-group">
                                                                <input type="text" id="pwa_theme_color"
                                                                       name="pwa_theme_color"
                                                                       class="form-control spectrum"
                                                                       value="<?php echo $n_eco_builder_config['pwa_theme_color']; ?>">
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('pwa_theme_color'); ?></span>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-1">
                                                        <fieldset>
                                                            <label for="pwa_background_color">PWA background
                                                                color</label>
                                                            <div class="input-group">
                                                                <input type="text" id="pwa_background_color"
                                                                       name="pwa_background_color"
                                                                       class="form-control spectrum"
                                                                       value="<?php echo $n_eco_builder_config['pwa_background_color']; ?>">
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('pwa_background_color'); ?></span>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-1">
                                                        <fieldset>
                                                            <label for="pwa_icon_512">PWA Icon PNG: 512x512 px</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Upload</span>
                                                                </div>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input"
                                                                           id="pwa_icon_512" name="pwa_icon_512">
                                                                    <label class="custom-file-label" for="pwa_icon_512">Choose
                                                                        file</label>
                                                                </div>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error('pwa_icon_512'); ?></span>
                                                        </fieldset>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-1">
                                                        <h6><?php echo $this->lang->line("apple-mobile-web-app-status-bar-style"); ?></h6>
                                                        <div class="form-group">
                                                            <?php
                                                            $select_lan = false;
                                                            if (isset($n_eco_builder_config['pwa_apple_status_bar'])) {
                                                                $select_lan = $n_eco_builder_config['pwa_apple_status_bar'];
                                                            }
                                                            $options = array();
                                                            $options['default'] = 'default';
                                                            $options['black'] = 'black';
                                                            $options['black-translucent'] = 'black-translucent';

                                                            echo form_dropdown('pwa_apple_status_bar', $options, $select_lan, 'class="select2 form-control" id="pwa_apple_status_bar"'); ?>
                                                        </div>
                                                        <span class="text-danger"><?php echo form_error('pwa_apple_status_bar'); ?></span>
                                                    </div>

                                                </div>

                                                <hr class="mb-3"/>

                                                <div class="row" id="pwa_splash">
                                                    <div class="col-12">
                                                        <h4 class="card-title">IOS Splash Screen</h4>

                                                    </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="ipad_splash"><?php $imagecheck('ipad_splash'); ?> ipad_splash png iPad Mini, Air (9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad_portrait) (1536px x
                                                                    2048px)</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="ipad_splash"
                                                                               name="ipad_splash">
                                                                        <label class="custom-file-label" for="ipad_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('ipad_splash'); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="ipadpro1_splash"><?php $imagecheck('ipadpro1_splash'); ?> ipadpro1_splash png (10.5__iPad_Air_portrait) iPad Pro 10.5" (1668px x
                                                                    2224px)</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="ipadpro1_splash"
                                                                               name="ipadpro1_splash">
                                                                        <label class="custom-file-label" for="ipadpro1_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('ipadpro1_splash'); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="ipadpro2_splash"><?php $imagecheck('ipadpro2_splash'); ?> ipadpro2_splash png iPad Pro 12.9" (12.9__iPad_Pro_portrait) (2048px x
                                                                    2732px)</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="ipadpro2_splash"
                                                                               name="ipadpro2_splash">
                                                                        <label class="custom-file-label" for="ipadpro2_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('ipadpro2_splash'); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="ipadpro3_splash"><?php $imagecheck('ipadpro3_splash'); ?> ipadpro3_splash png (11__iPad_Pro__10.5__iPad_Pro_portrait) 1668x2388</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="ipadpro3_splash"
                                                                               name="ipadpro3_splash">
                                                                        <label class="custom-file-label" for="ipadpro3_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('ipadpro3_splash'); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="iphone5_splash"><?php $imagecheck('iphone5_splash'); ?> iphone5_splash png iPhone 5 (4__iPhone_SE__iPod_touch_5th_generation_and_later_portrait) (640px x
                                                                    1136px)</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="iphone5_splash"
                                                                               name="iphone5_splash">
                                                                        <label class="custom-file-label" for="iphone5_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('iphone5_splash'); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="iphone6_splash"><?php $imagecheck('iphone6_splash'); ?> iphone6_splash png iPhone 8, 7, 6s, 6 (iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE_portrait) (750px x
                                                                    1334px)</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="iphone6_splash"
                                                                               name="iphone6_splash">
                                                                        <label class="custom-file-label" for="iphone6_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('iphone6_splash'); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="iphoneplus_splash"><?php $imagecheck('iphoneplus_splash'); ?> iphoneplus_splash png iPhone 8 Plus, 7 Plus,
                                                                    6s Plus, 6 Plus (iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_portrait) (1242px x 2208px)</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="iphoneplus_splash"
                                                                               name="iphoneplus_splash">
                                                                        <label class="custom-file-label" for="iphoneplus_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('iphoneplus_splash'); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="iphonex_splash"><?php $imagecheck('iphonex_splash'); ?> iphonex_splash png iPhone X (iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_portrait) (1125px x
                                                                    2436px)</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="iphonex_splash"
                                                                               name="iphonex_splash">
                                                                        <label class="custom-file-label" for="iphonex_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('iphonex_splash'); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="iphonexr_splash"><?php $imagecheck('iphonexr_splash'); ?> iphonexr_splash png (iPhone_11__iPhone_XR_portrait) 828x1792px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="iphonexr_splash"
                                                                               name="iphonexr_splash">
                                                                        <label class="custom-file-label" for="iphonexr_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('iphonexr_splash'); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="iphonexsmax_splash">
                                                                    <?php $imagecheck('iphonexsmax_splash'); ?>
                                                                    iphonexsmax_splash png (iPhone_11_Pro_Max__iPhone_XS_Max_portrait) 1242x2688px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="iphonexsmax_splash"
                                                                               name="iphonexsmax_splash">
                                                                        <label class="custom-file-label" for="iphonexsmax_splash">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error('iphonexsmax_splash'); ?></span>
                                                            </fieldset>
                                                        </div>




                                                        <?php
                                                        $n_ios_splash_name = '8_3__iPad_Mini_portrait';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); ?>
                                                                    8_3__iPad_Mini_portrait png 1488x2266px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = '10_2__iPad_portrait';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 1620x2160 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = '10_9__iPad_Air_portrait';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 1640x2360 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                    <?php
                                                    $n_ios_splash_name = 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_portrait';
                                                    ?>
                                                    <div class="col-12 col-md-6 mb-1">
                                                        <fieldset>
                                                            <label for="<?php echo $n_ios_splash_name; ?>">
                                                                <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                png 1284x2778 px</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Upload</span>
                                                                </div>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                           name="<?php echo $n_ios_splash_name; ?>">
                                                                    <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                        file</label>
                                                                </div>
                                                            </div>
                                                            <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                        </fieldset>
                                                    </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_portrait';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 1170x2532 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_portrait';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 1179x2556 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_portrait';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 1290x2796 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>


                                                        <?php
                                                        $n_ios_splash_name = '8_3__iPad_Mini_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2266x1488 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = '9_7__iPad_Pro__7_9__iPad_mini__9_7__iPad_Air__9_7__iPad_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2048x1536 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = '10_2__iPad_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2160x1620 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = '10_5__iPad_Air_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2224x1668 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = '10_9__iPad_Air_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2224x1668 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = '11__iPad_Pro__10_5__iPad_Pro_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2388x1668 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>


                                                        <?php
                                                        $n_ios_splash_name = '12_9__iPad_Pro_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2388x1668 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = '4__iPhone_SE__iPod_touch_5th_generation_and_later_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 1136x640 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>


                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4_7__iPhone_SE_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 1334x750 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2208x1242 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_11__iPhone_XR_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 1792x828  px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_11_Pro_Max__iPhone_XS_Max_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2688x1242 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2436x1125 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2532x1170 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2778x1284 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_15_Pro__iPhone_15__iPhone_14_Pro_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2557x1179 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>

                                                        <?php
                                                        $n_ios_splash_name = 'iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max_landscape';
                                                        ?>
                                                        <div class="col-12 col-md-6 mb-1">
                                                            <fieldset>
                                                                <label for="<?php echo $n_ios_splash_name; ?>">
                                                                    <?php $imagecheck($n_ios_splash_name); echo ' '.$n_ios_splash_name?>
                                                                    png 2796x1290 px</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Upload</span>
                                                                    </div>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="<?php echo $n_ios_splash_name; ?>"
                                                                               name="<?php echo $n_ios_splash_name; ?>">
                                                                        <label class="custom-file-label" for="<?php echo $n_ios_splash_name; ?>">Choose
                                                                            file</label>
                                                                    </div>
                                                                </div>
                                                                <span class="text-danger"><?php echo form_error($n_ios_splash_name); ?></span>
                                                            </fieldset>
                                                        </div>





                                                </div>


                                            </div>
                                            <div>
                                                <button class="btn btn-primary" id="save-btn" type="submit"><i
                                                            class="bx bx-save"></i> <span
                                                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span>
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $sitemap_disable = '';
                    if ($n_config['sitemap_disable'] == 'true') {
                        $sitemap_disable = 'd-none';
                    }
                    ?>

                    <div class="card collapse-header <?php echo $sitemap_disable; ?>">
                        <div id="heading3" class="card-header" data-toggle="collapse" role="button"
                             data-target="#accordion3"
                             aria-expanded="false" aria-controls="accordion3">
                            <span class="collapse-title"><?php echo $this->lang->line("Sitemap"); ?></span>
                        </div>
                        <div id="accordion3" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading3"
                             class="collapse"
                             aria-expanded="false">
                            <div class="card-body p-0">
                                <div class="card">
                                    <div class="card-footer p-2" style="border:1px solid #e4e6fc;">

                                        <div class="row">
                                            <div class="alert alert-warning mb-2 col-12" role="alert">
                                                <span><?php echo $this->lang->line('This options not work without custom domain'); ?></span>
                                            </div>
                                        </div>
                                        <?php
                                        var_dump($host_url);

                                        if (!empty($host_url)) { ?>
                                            <h4><i class='bx bx-sitemap'></i>
                                                <?php echo $this->lang->line("Sitemap"); ?>
                                            </h4>

                                            <pre class="language-javascript"><code class="dlanguage-javascript"><span
                                                            class="token keyword">https://<?php echo $host_url; ?>/sitemap.txt</span></code></pre>

                                            <h4><i class='bx bx-sitemap'></i>
                                                <?php echo $this->lang->line("Robots"); ?>
                                            </h4>

                                            <pre class="language-javascript"><code class="dlanguage-javascript"><span
                                                            class="token keyword">https://<?php echo $host_url; ?>/robots.txt</span></code></pre>

                                        <?php } ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $webhook_disable = '';
                    if ($n_config['webhook_disable'] == 'true') {
                        $webhook_disable = 'd-none';
                    }
                    ?>

                    <div class="card collapse-header <?php echo $webhook_disable; ?>">
                        <div id="heading4" class="card-header" data-toggle="collapse" role="button"
                             data-target="#accordion4"
                             aria-expanded="false" aria-controls="accordion4">
                            <span class="collapse-title"><?php echo $this->lang->line("Webhook"); ?></span>
                        </div>
                        <div id="accordion4" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading4"
                             class="collapse"
                             aria-expanded="false">
                            <div class="card-body p-0">
                                <div class="card">
                                    <div class="card-footer p-2" style="border:1px solid #e4e6fc;">
                                        <form class="form-horizontal text-c" enctype="multipart/form-data"
                                              action="<?php echo site_url() . 'n_theme/custom_domain_webhook_save'; ?>"
                                              method="POST">
                                            <input type="hidden" name="csrf_token" id="csrf_token"
                                                   value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                                            <input type="hidden" name="custom_id" id="custom_id"
                                                   value="<?php echo $custom_id; ?>">
                                            <div class="webhook_settings">
                                                <div class="row">

                                                    <div class="col-12 mb-1">
                                                        <h6><?php echo $this->lang->line('Domains to receive webhook (include http:// or https://). For disable webhook - remove all domains.'); ?></h6>
                                                        <div class="form-group">
                                                            <select class="select2_token form-control"
                                                                    multiple="multiple" name="wh_domain[]">
                                                                <?php
                                                                if (!empty($wh_domains) and is_array($wh_domains)) {
                                                                    foreach ($wh_domains as $whk => $whv) {
                                                                        echo '<option value="' . $whv . '" selected>' . $whv . '</option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-1">
                                                        <div class="form-group">
                                                            <label class="custom-switch mt-2">
                                                                <input type="checkbox" name="send_all_orders"
                                                                       id="send_all_orders" value="1"
                                                                       class="custom-control-input">
                                                                <label class="custom-control-label mr-1"
                                                                       for="send_all_orders"></label>
                                                                <span><?php echo $this->lang->line('Send all history orders'); ?></span>
                                                                <span class="text-danger"><?php echo form_error('send_all_orders'); ?></span>
                                                            </label>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="custom-switch mt-2">
                                                                <input type="checkbox" name="send_all_products"
                                                                       id="send_all_products" value="1"
                                                                       class="custom-control-input">
                                                                <label class="custom-control-label mr-1"
                                                                       for="send_all_products"></label>
                                                                <span><?php echo $this->lang->line('Send all current products'); ?></span>
                                                                <span class="text-danger"><?php echo form_error('send_all_products'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-6 mb-1">

                                                    </div>


                                                </div>
                                            </div>

                                            <div>
                                                <button class="btn btn-primary" id="save-btn" type="submit"><i
                                                            class="bx bx-save"></i> <span
                                                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span>
                                                </button>
                                            </div>
                                        </form>


                                        <div class="wh_error_log mt-5">
                                            <?php echo $this->lang->line("Last 10 errors"); ?>
                                            <?php
                                            if (!empty($wh_error_log) and is_array($wh_error_log)) {
                                                foreach ($wh_error_log as $wek => $wev) {
                                                    ?>
                                                    <pre class="language-javascript"><code class="dlanguage-javascript"><span
                                                                    class="token keyword"> <?php echo $wek; ?>: <?php echo $wev; ?></span></code></pre>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <pre class="language-javascript"><code
                                                            class="dlanguage-javascript"><span
                                                                class="token keyword"> <?php echo $this->lang->line("Not found errors. This list show only HTTP error code other than 200."); ?></span></code></pre>
                                                <?php
                                            }

                                            ?>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--                    <div class="card collapse-header">-->
                    <!--                        <div id="heading4" class="card-header" data-toggle="collapse" role="button" data-target="#accordion4"-->
                    <!--                             aria-expanded="false" aria-controls="accordion4">-->
                    <!--                            <span class="collapse-title">-->
                    <?php //echo $this->lang->line("XML Feed"); ?><!--</span>-->
                    <!--                        </div>-->
                    <!--                        <div id="accordion4" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading4" class="collapse"-->
                    <!--                             aria-expanded="false">-->
                    <!--                            <div class="card-body p-0">-->
                    <!--                                <div class="card">-->
                    <!--                                    <div class="card-footer p-2" style="border:1px solid #e4e6fc;">-->
                    <!---->
                    <!--                                    </div>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->

                </div>


            </div>
        </div>
    </div>
</div>