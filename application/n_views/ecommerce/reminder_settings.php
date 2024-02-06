<?php include(APPPATH . 'n_views/ecommerce/store_style.php'); ?>
<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 1;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$jodit = 1;
?>
<div id="put_script"></div>

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

<div class="section-body">
    <?php
    $messenger_content = !empty($xdata['messenger_content']) ? json_decode($xdata['messenger_content'], true) : array();
    $sms_content = !empty($xdata['sms_content']) ? json_decode($xdata['sms_content'], true) : array();
    $email_content = !empty($xdata['email_content']) ? json_decode($xdata['email_content'], true) : array();
    ?>
    <form action="#" enctype="multipart/form-data" id="plugin_form">
        <input type="hidden" name="hidden_id" value="<?php echo $xdata['id']; ?>">
        <div class="row">

            <div class="col-12">
                <div class="card main_card shadow-none">
                    <div class="card-header p-0 mb-3" style="border:none;min-height: 0;">
                        <h6 class="width-95-per">
                            <a id="variables" class="float-left text-warning cursor-pointer"><i
                                        class="bx bx-circle"></i> <?php echo $this->lang->line("Variables"); ?></a>
                            <a onclick="reset_values()" class="float-right text-danger cursor-pointer"><i
                                        class="bx bx-undo"></i> <?php echo $this->lang->line("Reset"); ?></a>
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-tabs" id="sequence_tab" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" id="messenger_link" data-toggle="tab" href="#messenger_tab"
                                   role="tab" aria-controls="profile"
                                   aria-selected="false"> <?php echo $this->lang->line("Messenger"); ?></a>
                            </li>

                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(264, $this->module_access)) : ?>
                                <li class="nav-item">
                                    <a class="nav-link" id="sms_link" data-toggle="tab" href="#sms_tab" role="tab"
                                       aria-controls="profile"
                                       aria-selected="false"><?php echo $this->lang->line("SMS"); ?></a>
                                </li>
                            <?php endif; ?>

                            <?php
                            if ($this->basic->is_exist("modules", array("id" => 263))) :
                                if ($this->session->userdata('user_type') == 'Admin' || in_array(263, $this->module_access)) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="email_link" data-toggle="tab" href="#email_tab"
                                           role="tab" aria-controls="profile"
                                           aria-selected="false"><?php echo $this->lang->line("Email"); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                        </ul>
                        <div class="tab-content tab-bordered">

                            <div class="tab-pane fade show active" id="messenger_tab" role="tabpanel"
                                 aria-labelledby="messenger_link">

                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-7">
                                        <?php echo $this->lang->line("Messenger Content"); ?>
                                        <div class="tab-content" id="MsgReminderTabContent">
                                            <?php
                                            for ($i = 1; $i <= $how_many_reminder; $i++) { ?>
                                                <div class="reminder_badge_warpper tab-pane fade"
                                                     id="msg_reminder<?php echo $i; ?>" role="tabpanel"
                                                     aria-labelledby="msg_reminder_link>">
                                                    <span class="reminder_badge" data-toggle="tooltip"
                                                          title="<?php echo $this->lang->line('Messenger Reminder') . ' #' . $i; ?>"><i
                                                                class="bx bx-bell"></i> <?php echo $i; ?></span>
                                                    <div class="reminder_block">
                                        <span class="block1">
                                          <textarea autofocus data-toggle="tooltip"
                                                    title="<?php echo $this->lang->line('Intro message will be displayed here, click to edit text.'); ?>"
                                                    name="msg_reminder_text[]"
                                                    id="msg_reminder_text<?php echo $i; ?>"><?php echo isset($messenger_content['reminder'][$i]['reminder_text']) ? $messenger_content['reminder'][$i]['reminder_text'] : $reminder_default['messenger']['reminder']['reminder_text']; ?></textarea>
                                        </span>
                                                        <span class="block2 ">
                                          <img data-toggle="tooltip"
                                               title="<?php echo $this->lang->line('Item preview will be displayed here as carousel.'); ?>"
                                               src="<?php echo base_url('assets/img/products/product-6.jpg') ?>">
                                        </span>
                                                        <span class="block3">
                                          <h6 data-toggle="tooltip"
                                              title="<?php echo $this->lang->line('Item name will be displayed here.'); ?>"><?php echo "Cart item title"; ?></h6>
                                          <span data-toggle="tooltip"
                                                title="<?php echo $this->lang->line('Item quantity & price will be displayed here.'); ?>"
                                                class="text-muted"><?php echo "Quantity & price"; ?> </span>
                                          <span class="text-muted website" data-toggle="tooltip"
                                                title="<?php echo $this->lang->line('Store name will be displayed here.'); ?>">example.com</span>
                                          <p>
                                          <input data-toggle="tooltip"
                                                 title="<?php echo $this->lang->line('Item link will be embedded here, click to edit button name.'); ?>"
                                                 value="<?php echo isset($messenger_content['reminder'][$i]['reminder_btn_details']) ? $messenger_content['reminder'][$i]['reminder_btn_details'] : 'View Details'; ?>"
                                                 class="btn btn-block bg-white" name="msg_reminder_btn_details[]"
                                                 id="msg_reminder_btn_details<?php echo $i; ?>"/>
                                          </p>
                                        </span>
                                                        <span class="block4">
                                          <textarea data-toggle="tooltip"
                                                    title="<?php echo $this->lang->line('Additonal information like coupon can be displayed here, click to edit text.'); ?>"
                                                    name="msg_reminder_text_checkout[]"
                                                    id="msg_reminder_text_checkout<?php echo $i; ?>"><?php echo isset($messenger_content['reminder'][$i]['reminder_text_checkout']) ? $messenger_content['reminder'][$i]['reminder_text_checkout'] : $reminder_default['messenger']['reminder']['reminder_text_checkout']; ?></textarea>
                                          <p>
                                          <input data-toggle="tooltip"
                                                 title="<?php echo $this->lang->line('Checkout link will be embedded here, click to edit button name.'); ?>"
                                                 value="<?php echo isset($messenger_content['reminder'][$i]['reminder_btn_checkout']) ? $messenger_content['reminder'][$i]['reminder_btn_checkout'] : 'Checkout Now'; ?>"
                                                 class="btn btn-block bg-white" name="msg_reminder_btn_checkout[]"
                                                 id="msg_reminder_btn_checkout<?php echo $i; ?>"/>
                                          </p>
                                        </span>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="reminder_badge_warpper tab-pane fade active show"
                                                 id="msg_checkout" role="tabpanel" aria-labelledby="msg_checkout_link>">
                                                <span class="reminder_badge" data-toggle="tooltip"
                                                      title="<?php echo $this->lang->line('Messenger Checkout'); ?>"><i
                                                            class="bx bx-shopping-bag"></i></span>
                                                <div class="reminder_block">
                                      <span class="block1">
                                        <textarea autofocus data-toggle="tooltip"
                                                  title="<?php echo $this->lang->line('Intro message will be displayed here, click to edit text.'); ?>"
                                                  name="msg_checkout_text"
                                                  id="msg_checkout_text"><?php echo isset($messenger_content['checkout']['checkout_text']) ? $messenger_content['checkout']['checkout_text'] : $reminder_default['messenger']['checkout']['checkout_text']; ?></textarea>
                                      </span>
                                                    <span class="block5">

                                        <ul class="list-group list-group-flush">
                                          <li class="list-group-item"><span class="text-muted">Order confirmation</span></li>

                                          <li class="list-group-item">
                                            <div class="media">
                                              <img class="align-self-start mr-3"
                                                   src="<?php echo base_url('assets/img/products/product-6.jpg') ?>">
                                              <div class="media-body">
                                                <h6 class="mt-0">Cart item title</h6>
                                                <p class="text-muted">Price : XX</p>
                                                <p class="text-muted">Qty : XX</p>
                                              </div>
                                            </div>
                                          </li>

                                          <li class="list-group-item payment_info">
                                            <p class="text-muted">Paid with</p>
                                            <h6>Payment method</h6>
                                            <br>
                                            <p class="text-muted">Deliver to</p>
                                            <h6>Delivery address...</h6>
                                          </li>

                                          <li class="list-group-item">
                                            <span class="text-muted float-left">Total</span>
                                            <b class="float-right">$xx.xx</b>
                                          </li>
                                        </ul>
                                      </span>
                                                    <span class="block4">
                                        <textarea data-toggle="tooltip"
                                                  title="<?php echo $this->lang->line('Additonal information about next purchase like coupon can be displayed here, click to edit text.'); ?>"
                                                  name="msg_reminder_text_checkout_next"
                                                  id="msg_reminder_text_checkout_next"><?php echo isset($messenger_content['checkout']['checkout_text_next']) ? $messenger_content['checkout']['checkout_text_next'] : $reminder_default['messenger']['checkout']['checkout_text_next']; ?></textarea>
                                        <p>
                                        <input data-toggle="tooltip"
                                               title="<?php echo $this->lang->line('Buyer order page link will be embedded here, click to edit button name.'); ?>"
                                               value="<?php echo isset($messenger_content['checkout']['checkout_btn_next']) ? $messenger_content['checkout']['checkout_btn_next'] : 'My Orders'; ?>"
                                               class="btn btn-block bg-white" name="msg_checkout_btn_website"
                                               id="msg_checkout_btn_website"/>
                                        </p>
                                      </span>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <?php
                                            for ($i = 1; $i <= $how_many_reminder; $i++) { ?>
                                                <li class="nav-item">
                                                    <a href="#msg_reminder<?php echo $i; ?>"
                                                       id="msg_reminder_link<?php echo $i; ?>" class="nav-link"
                                                       data-toggle="pill" role="tab"
                                                       aria-controls="msg_reminder<?php echo $i; ?>"
                                                       aria-selected="true"><i
                                                                class="bx bx-bell"></i> <?php echo $this->lang->line("Messenger Reminder"); ?>
                                                        #<?php echo $i; ?></a>

                                                    <?php
                                                    $tmp_name = 'msg_reminder_time[]';
                                                    $tmp_id = 'msg_reminder_time_' . $i;
                                                    $tmp_select = isset($messenger_content['reminder'][$i]['hour']) ? $messenger_content['reminder'][$i]['hour'] : '';
                                                    echo form_dropdown($tmp_name, $hours, $tmp_select, 'id="' . $tmp_id . '" class="form-control" style="width: 100% !important;"');
                                                    ?>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                            <li class="nav-item">
                                                <a href="#msg_checkout" id="msg_checkout_link"
                                                   class="nav-link nav_cart active" data-toggle="pill" role="tab"
                                                   aria-controls="msg_checkout" aria-selected="true"><i
                                                            class="bx bx-shopping-bag"></i> <?php echo $this->lang->line("Checkout Messenger"); ?>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>


                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(264, $this->module_access)) : ?>
                                <div class="tab-pane fade" id="sms_tab" role="tabpanel" aria-labelledby="sms_link">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-7">
                                            <?php echo $this->lang->line("SMS Content"); ?>
                                            <div class="tab-content" id="SmsReminderTabContent">
                                                <?php
                                                for ($i = 1; $i <= $how_many_reminder; $i++) { ?>
                                                    <div class="reminder_badge_warpper tab-pane fade"
                                                         id="sms_reminder<?php echo $i; ?>" role="tabpanel"
                                                         aria-labelledby="sms_reminder_link>">
                                                        <span class="reminder_badge" data-toggle="tooltip"
                                                              title="<?php echo $this->lang->line('SMS Reminder') . ' #' . $i; ?>"><i
                                                                    class="bx bx-bell"></i> <?php echo $i; ?></span>
                                                        <div class="reminder_block">
                                        <span class="block4">
                                          <textarea data-toggle="tooltip"
                                                    title="<?php echo $this->lang->line('SMS content goes here.'); ?>"
                                                    name="sms_reminder_text_checkout[]"
                                                    id="sms_reminder_text_checkout<?php echo $i; ?>"><?php echo isset($sms_content['reminder'][$i]['reminder_text']) ? $sms_content['reminder'][$i]['reminder_text'] : $reminder_default['sms']['reminder']['reminder_text']; ?></textarea>
                                        </span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <div class="reminder_badge_warpper tab-pane fade active show"
                                                     id="sms_checkout" role="tabpanel"
                                                     aria-labelledby="sms_checkout_link>">
                                                    <span class="reminder_badge" data-toggle="tooltip"
                                                          title="<?php echo $this->lang->line('SMS Checkout'); ?>"><i
                                                                class="bx bx-shopping-bag"></i></span>
                                                    <div class="reminder_block">
                                      <span class="block4">
                                        <textarea data-toggle="tooltip"
                                                  title="<?php echo $this->lang->line('SMS content goes here.'); ?>"
                                                  class="form-control" name="sms_reminder_text_checkout_next"
                                                  id="sms_reminder_text_checkout_next"><?php echo isset($sms_content['checkout']['checkout_text']) ? $sms_content['checkout']['checkout_text'] : $reminder_default['sms']['checkout']['checkout_text']; ?></textarea>
                                      </span>
                                                    </div>
                                                </div>

                                            </div>

                                            <br>
                                            <div class="form-group">
                                                <div class="label"><?php echo $this->lang->line("SMS Sender"); ?></div>
                                                <?php echo form_dropdown('sms_api_id', $sms_option, $xdata['sms_api_id'], 'class="select2 form-control" id="sms_api_id" style="width:100%"'); ?>
                                            </div>

                                        </div>


                                        <div class="col-12 col-sm-12 col-md-5">
                                            <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                                aria-orientation="vertical">
                                                <?php
                                                for ($i = 1; $i <= $how_many_reminder; $i++) { ?>
                                                    <li class="nav-item">
                                                        <a href="#sms_reminder<?php echo $i; ?>"
                                                           id="sms_reminder_link<?php echo $i; ?>" class="nav-link"
                                                           data-toggle="pill" role="tab"
                                                           aria-controls="sms_reminder<?php echo $i; ?>"
                                                           aria-selected="true"><i
                                                                    class="bx bx-bell"></i> <?php echo $this->lang->line("SMS Reminder"); ?>
                                                            #<?php echo $i; ?></a>

                                                        <?php
                                                        $tmp_name = 'sms_reminder_time[]';
                                                        $tmp_id = 'sms_reminder_time_' . $i;
                                                        $tmp_select = isset($sms_content['reminder'][$i]['hour']) ? $sms_content['reminder'][$i]['hour'] : '';
                                                        echo form_dropdown($tmp_name, $hours, $tmp_select, 'id="' . $tmp_id . '" class="form-control" style="width: 100% !important;"');
                                                        ?>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                                <li class="nav-item">
                                                    <a href="#sms_checkout" id="sms_checkout_link"
                                                       class="nav-link nav_cart active" data-toggle="pill" role="tab"
                                                       aria-controls="msg_checkout" aria-selected="true"><i
                                                                class="bx bx-shopping-bag"></i> <?php echo $this->lang->line("Checkout SMS"); ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>



                            <?php if ($this->session->userdata('user_type') == 'Admin' || in_array(263, $this->module_access)) : ?>
                                <div class="tab-pane fade" id="email_tab" role="tabpanel" aria-labelledby="email_link">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-7">
                                            <?php echo $this->lang->line("Email Content"); ?>
                                            <div class="tab-content" id="EmailReminderTabContent">
                                                <?php
                                                for ($i = 1; $i <= $how_many_reminder; $i++) { ?>
                                                    <div class="reminder_badge_warpper tab-pane fade"
                                                         style="border:none;padding: 0"
                                                         id="email_reminder<?php echo $i; ?>" role="tabpanel"
                                                         aria-labelledby="email_reminder_link>">
                                                        <span class="reminder_badge" data-toggle="tooltip"
                                                              title="<?php echo $this->lang->line('Email Reminder') . ' #' . $i; ?>"><i
                                                                    class="bx bx-bell"></i> <?php echo $i; ?></span>
                                                        <textarea class="jodit" data-toggle="tooltip"
                                                                  title="<?php echo $this->lang->line('Email content goes here.'); ?>"
                                                                  name="email_reminder_text_checkout[]"
                                                                  id="email_reminder_text_checkout<?php echo $i; ?>"><?php echo isset($email_content['reminder'][$i]['reminder_text']) ? $email_content['reminder'][$i]['reminder_text'] : $reminder_default['email']['reminder']['reminder_text']; ?></textarea>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                                <div class="reminder_badge_warpper tab-pane fade active show"
                                                     style="border:none;padding: 0" id="email_checkout" role="tabpanel"
                                                     aria-labelledby="email_checkout_link>">
                                                    <span class="reminder_badge" data-toggle="tooltip"
                                                          title="<?php echo $this->lang->line('Email Checkout'); ?>"><i
                                                                class="bx bx-shopping-bag"></i></span>
                                                    <textarea class="jodit" data-toggle="tooltip"
                                                              title="<?php echo $this->lang->line('Email content goes here.'); ?>"
                                                              name="email_reminder_text_checkout_next"
                                                              id="email_reminder_text_checkout_next"><?php echo isset($email_content['checkout']['checkout_text']) ? $email_content['checkout']['checkout_text'] : $reminder_default['email']['checkout']['checkout_text']; ?></textarea>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="label"><?php echo $this->lang->line("Email Sender"); ?></div>
                                                <?php
                                                $email_api_id = 0;
                                                if (isset($xdata['email_api_id']) && $xdata['email_api_id'] > 0)
                                                    $email_api_id = $xdata['configure_email_table'] . '-' . $xdata['email_api_id'];
                                                ?>
                                                <?php echo form_dropdown('email_api_id', $email_option, $email_api_id, 'class="select2 form-control" id="email_api_id" style="width:100%"'); ?>
                                            </div>
                                            <div class="form-group">
                                                <div class="label"><?php echo $this->lang->line("Email Subject"); ?></div>
                                                <input name="email_subject" id="email_subject" class="form-control"
                                                       value="<?php echo (isset($xdata['email_subject']) && $xdata['email_subject'] != "") ? $xdata['email_subject'] : "{{store_name}} | Order Update"; ?>">
                                            </div>

                                        </div>

                                        <div class="col-12 col-sm-12 col-md-5">
                                            <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                                aria-orientation="vertical">
                                                <?php
                                                for ($i = 1; $i <= $how_many_reminder; $i++) { ?>
                                                    <li class="nav-item">
                                                        <a href="#email_reminder<?php echo $i; ?>"
                                                           id="email_reminder_link<?php echo $i; ?>" class="nav-link"
                                                           data-toggle="pill" role="tab"
                                                           aria-controls="email_reminder<?php echo $i; ?>"
                                                           aria-selected="true"><i
                                                                    class="bx bx-bell"></i> <?php echo $this->lang->line("Email Reminder"); ?>
                                                            #<?php echo $i; ?></a>

                                                        <?php
                                                        $tmp_name = 'email_reminder_time[]';
                                                        $tmp_id = 'email_reminder_time_' . $i;
                                                        $tmp_select = isset($email_content['reminder'][$i]['hour']) ? $email_content['reminder'][$i]['hour'] : '';
                                                        echo form_dropdown($tmp_name, $hours, $tmp_select, 'id="' . $tmp_id . '" class="form-control" style="width: 100% !important;"');
                                                        ?>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                                <li class="nav-item">
                                                    <a href="#email_checkout" id="email_checkout_link"
                                                       class="nav-link nav_cart active" data-toggle="pill" role="tab"
                                                       aria-controls="msg_checkout" aria-selected="true"><i
                                                                class="bx bx-shopping-bag"></i> <?php echo $this->lang->line("Checkout Email"); ?>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-none">
                    <div class="card-footer p-0">
                        <button class="btn btn-primary" id="get_button2" name="get_button2" type="button"><i
                                    class="bx bxs-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <button class="btn btn-light float-right" onclick="ecommerceGoBack()" type="button"><i
                                    class="bx bx-time"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>


<?php include(APPPATH . 'n_views/ecommerce/store_style.php'); ?>

