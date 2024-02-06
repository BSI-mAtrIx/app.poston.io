<?php
$user_type = $this->session->userdata('user_type');
$license_type = $this->session->userdata('license_type');
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-1 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="section section_custom mt-2">
    <div class="section-body">


        <div class="row">
            <div class="col-12">
                <div class="make-nav-stick">
                    <div class="list-group d-block" id="list-tab">
                        <?php if ($user_type == 'Admin' && $license_type == 'double') : ?>
                            <a class="btn btn-outline-primary"
                               href="#list-payment-list"><?php echo $this->lang->line('Payment APIs'); ?></a>
                        <?php endif; ?>

                        <?php if ($user_type == "Admin") { ?>
                            <a class="btn btn-outline-primary"
                               href="#list-media-list"><?php echo $this->lang->line('Social Medias'); ?></a>
                        <?php } ?>

                        <?php if ($has_autoresponder_access) : ?>
                            <a class="btn btn-outline-primary"
                               href="#list-autoresponder-list"><?php echo $this->lang->line('Email Autoresponder'); ?></a>
                        <?php endif; ?>

                        <?php if ($has_json_access) : ?>
                            <a class="btn btn-outline-primary"
                               href="#list-json-list"><?php echo $this->lang->line('JSON API'); ?></a>
                        <?php endif; ?>

                        <?php if ($user_type == 'Admin' || in_array(264, $this->module_access)) { ?>
                            <a class="btn btn-outline-primary"
                               href="#list-sms-list"><?php echo $this->lang->line('SMS API'); ?></a>
                        <?php } ?>

                        <?php if ($user_type == 'Admin' || in_array(263, $this->module_access)) { ?>
                            <a class="btn btn-outline-primary"
                               href="#list-email-list"><?php echo $this->lang->line('Email API'); ?></a>
                        <?php } ?>

                        <?php if ($this->basic->is_exist("modules", array("id" => 266)) || $this->basic->is_exist("modules", array("id" => 293))) { ?>
                            <a class="btn btn-outline-primary"
                               href="#list-woocommerce-list"><?php echo $this->lang->line('WooCommerce'); ?></a>
                        <?php } ?>

                        <?php if(ai_reply_exist()) { ?>
                            <a class="btn btn-outline-primary"
                               href="#list-openai-list"><?php echo $this->lang->line('Open AI'); ?></a>
                        <?php } ?>


                    </div>
                </div>
            </div>
        </div>
        <br>


        <?php if ($user_type == 'Admin' && $license_type == 'double') : ?>
            <div class="card">
                <div class="card-header">
                    <div class="row" id="list-payment-list">
                        <div class="col-12">
                            <h2 class="card-title"><?php echo $this->lang->line('Payment Account APIs'); ?></h2>
                            <p class="section-lead text-muted">
                                <?php echo $this->lang->line('Set up payment gateway to receive payments from subscribed users for using this platform.'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <?php foreach ($payment_apis as $single_api) : ?>
                        <div class="col-lg-2 col-sm-6 col-xs-6 col-md-2 col-6">
                            <a href="<?php echo $payment_gateway_url; ?>" class="text-dark action_tag">
                                <div class="wizard-steps mb-1">
                                    <div class="wizard-step mx-1 my-0 text-center">
                                        <div class="wizard-step-icon">
                                            <img class="img-fluid" style="max-width:80px;"
                                                 src="<?php echo $single_api['img_path']; ?>" alt="">
                                        </div>
                                        <div class="wizard-step-label font-small-3"><?php echo $single_api['title']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <div class="row" id="list-media-list">
                    <div class="col-12">
                        <h2 class="card-title"><?php echo $this->lang->line('Social Media'); ?></h2>
                        <p class="section-lead text-muted">
                            <?php echo $this->lang->line('Integrate different social media accounts to use bot, auto reply, social posting etc features.'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body row">

                <?php
                $i = 0;
                foreach ($social_medias as $social_media) :

                    if (!$social_media['has_access']) continue;

                    ?>
                    <div class="col-lg-2 col-sm-6 col-xs-6 col-md-2 col-6 social_media_tag"
                         div_count='<?php echo $i; ?>'>
                        <a href="<?php echo $social_media['account_import_url']; ?>" class="text-dark action_tag">
                            <div class="wizard-steps mb-1">
                                <div class="wizard-step mx-1 my-0 text-center">
                                    <div class="wizard-step-icon">
                                        <img class="img-fluid" style="max-width:80px;"
                                             src="<?php echo $social_media['img_path']; ?>" alt="">
                                    </div>
                                    <div class="wizard-step-label font-small-3"><?php echo $social_media['title']; ?></div>

                                    <?php if ($user_type == "Admin") : ?>
                                        <div class="wizard-step-label font-small-3 wizard-icons actions<?php echo $i; ?>"
                                             style="display: none;">
                                            <?php if ($social_media['action_url'] != '') : ?>
                                                <a href="<?php echo $social_media['action_url']; ?>"
                                                   class="btn btn-circle btn-outline-primary"
                                                   title="<?php echo $this->lang->line('API settings'); ?>"><i
                                                            class="bx bx-plug"></i></a>
                                            <?php endif; ?>
                                            <a href="<?php echo $social_media['account_import_url']; ?>"
                                               class="btn btn-circle btn-outline-warning"
                                               title="<?php echo $this->lang->line('Import Account'); ?>"><i
                                                        class="bx bx-cloud-download"></i></a>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </a>
                    </div>
                    <?php $i++; endforeach; ?>
            </div>
        </div>


        <?php if ($has_autoresponder_access) : ?>
            <div class="card">
                <div class="card-header">
                    <div class="row" id="list-autoresponder-list">
                        <div class="col-12">
                            <h2 class="card-title"><?php echo $this->lang->line('Email Autoresponder APIs'); ?></h2>
                            <p class="section-lead text-muted">
                                <?php
                                echo $this->lang->line('If you integrate email autoresponder and apply in bot manager then, email address will be forwared to auto responder account when a bot subscriber OPT-IN using email.');
                                if ($user_type == "Admin") {
                                    echo ' ' . $this->lang->line('As a admin you can use autoresponder integration when a new user sign-up to the system.');
                                }
                                ?>

                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <?php foreach ($email_autoresponder_apis as $api) : ?>
                        <div class="col-lg-2 col-sm-6 col-xs-6 col-md-2 col-6">
                            <a href="<?php echo $api['action_url'] ?>" class="text-dark action_tag">
                                <div class="wizard-steps mb-1">
                                    <div class="wizard-step mx-1 my-0 text-center">
                                        <div class="wizard-step-icon">
                                            <img class="img-fluid" style="max-width:80px;"
                                                 src="<?php echo $api['img_path']; ?>" alt="">
                                        </div>
                                        <div class="wizard-step-label font-small-3"><?php echo $api['title']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>


        <?php if ($has_json_access) : ?>
            <div class="card">
                <div class="card-header">
                    <div class="row" id="list-json-list">
                        <div class="col-12">
                            <h2 class="card-title"><?php echo $this->lang->line('JSON API Connector'); ?></h2>
                            <p class="section-lead text-muted">
                                <?php echo $this->lang->line('JSON API Connector for Messenger bot to share collected data accross different platforms. We send data via POST method only.'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <div class="col-12 col-lg-2">
                        <a href="<?php echo base_url('messenger_bot_connectivity/json_api_connector'); ?>"
                           class="text-dark action_tag">
                            <div class="wizard-steps mb-1">
                                <div class="wizard-step mx-1 my-0 text-center">
                                    <div class="wizard-step-icon">
                                        <img class="img-fluid" style="max-width:80px;"
                                             src="<?php echo base_url('assets/img/api_channel_icon/auto_responder/json_api.png'); ?>"
                                             alt="">
                                    </div>
                                    <div class="wizard-step-label font-small-3"><?php echo $this->lang->line('JSON API Connector'); ?></div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($has_sms_access) { ?>
            <div class="card">
                <div class="card-header">
                    <div class="row" id="list-sms-list">
                        <div class="col-12">
                            <h2 class="card-title"><?php echo $this->lang->line('SMS APIs'); ?></h2>
                            <p class="section-lead text-muted">
                                <?php echo $this->lang->line('Integrate SMS APIs to broadcast SMS and send SMS notification.'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <?php foreach ($sms_email_apis['sms'] as $sms_api) : ?>
                        <div class="col-lg-2 col-sm-6 col-xs-6 col-md-2 col-6">
                            <a href="<?php echo $sms_api['action_url']; ?>" class="text-dark action_tag">
                                <div class="wizard-steps mb-1">
                                    <div class="wizard-step mx-1 my-0 text-center">
                                        <div class="wizard-step-icon">
                                            <img class="img-fluid" style="max-width:80px;"
                                                 src="<?php echo $sms_api['img_path']; ?>" alt="">
                                        </div>
                                        <div class="wizard-step-label font-small-3"><?php echo $sms_api['title']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php } ?>

        <?php if ($has_email_access) { ?>
            <div class="card">
                <div class="card-header">
                    <div class="row" id="list-email-list">
                        <div class="col-12">
                            <h2 class="card-title"><?php echo $this->lang->line('Email APIs'); ?></h2>
                            <p class="section-lead text-muted">
                                <?php echo $this->lang->line('Integrate email APIs to broadcast SMS and send email notification.'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <?php foreach ($sms_email_apis['email'] as $email_api) : ?>
                        <div class="col-lg-2 col-sm-6 col-xs-6 col-md-2 col-6">
                            <a href="<?php echo $email_api['action_url']; ?>" class="text-dark action_tag">
                                <div class="wizard-steps mb-1">
                                    <div class="wizard-step mx-1 my-0 text-center">
                                        <div class="wizard-step-icon">
                                            <img class="img-fluid" style="max-width:80px;"
                                                 src="<?php echo $email_api['img_path']; ?>" alt="">
                                        </div>
                                        <div class="wizard-step-label font-small-3"><?php echo $email_api['title']; ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php } ?>

        <?php
        if ($this->basic->is_exist("modules", array("id" => 266)) || $this->basic->is_exist("modules", array("id" => 293))) : ?>
            <div class="card">
                <div class="card-header">
                    <div class="row" id="list-woocommerce-list">
                        <div class="col-12">
                            <h2 class="card-title"><?php echo $this->lang->line('WooCommerce'); ?></h2>
                            <p class="section-lead text-muted">
                                <?php echo $this->lang->line('WooCommerce abandoned cart recovery plugin & import WooCommerce product data.'); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body row">
                    <?php if ($user_type == 'Admin' || in_array(266, $this->module_access)) : ?>
                        <div class="col-12 col-lg-2">
                            <a href="<?php echo base_url('woocommerce_abandoned_cart'); ?>"
                               class="text-dark action_tag">
                                <div class="wizard-steps mb-1">
                                    <div class="wizard-step mx-1 my-0 text-center">
                                        <div class="wizard-step-icon">
                                            <img class="img-fluid" style="max-width:80px;"
                                                 src="<?php echo base_url('assets/img/api_channel_icon/social_media/woocommerce.png'); ?>"
                                                 alt="">
                                        </div>
                                        <div class="wizard-step-label font-small-3"><?php echo $this->lang->line('WC Abandoned Cart Recovery'); ?></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if ($user_type == 'Admin' || in_array(293, $this->module_access)) : ?>
                        <div class="col-12 col-lg-2">
                            <a href="<?php echo base_url('woocommerce_integration'); ?>" class="text-dark action_tag">
                                <div class="wizard-steps mb-1">
                                    <div class="wizard-step mx-1 my-0 text-center">
                                        <div class="wizard-step-icon">
                                            <img class="img-fluid" style="max-width:80px;"
                                                 src="<?php echo base_url('assets/img/api_channel_icon/social_media/woocommerce.png'); ?>"
                                                 alt="">
                                        </div>
                                        <div class="wizard-step-label font-small-3"><?php echo $this->lang->line('WC Product Import'); ?>
                                            <br><br></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>



        <?php
        if(ai_reply_exist()) : ?>
        <div class="card">
            <div class="card-header">
                <div class="row" id="list-openai-list">
                    <div class="col-12">
                        <h2 class="card-title"><?php echo $this->lang->line('Open AI'); ?></h2>
                        <p class="section-lead text-muted">
                            <?php echo $this->lang->line('Open AI Is for training data of using AI.'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body row">
                <div class="col-12 col-lg-2" id="list-openAI-list">
                    <a href="<?php echo base_url('integration/open_ai_api_credentials'); ?>" class="text-dark action_tag">
                        <div class="wizard-steps mb-1">
                            <div class="wizard-step mx-1 my-0 text-center">
                                <div class="wizard-step-icon">

                                    <img class="img-fluid" style="max-width:80px;" src="<?php echo base_url('assets/img/api_channel_icon/social_media/ai.png'); ?>" alt="">
                                </div>
                                <div class="wizard-step-label font-small-3"><?php echo $this->lang->line('Open AI api '); ?>
                                    <br><br></div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<style>
    .action_tag {
        text-decoration: none !important;
    }

    .action_tag:hover .wizard-step-label font-small-3 {
        color: var(--blue) !important;
    }

    .wizard-steps .wizard-step {
        padding: 20px;
    }

    .wizard-steps .wizard-step:before {
        content: none !important;
    }

    .wizard-steps .wizard-step .wizard-step-label font-small-3 {
        font-size: 12px;
        text-transform: capitalize;
        letter-spacing: 0;
        margin-top: 10px;
    }

    .social_media_tag:hover .wizard-icons {
        display: block ! importan;
    }

    @media (max-width: 575.98px) {
        .list-group {
            display: grid !important;
        }
    }

    /*.wizard-icons { display: none; }*/
</style>


