<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_colorpicker = 1;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;
?>

<style>
    .add_template, .ref_template {
        font-size: 10px;
        margin-top: 5px
    }
</style>
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
                                href="<?php echo base_url("messenger_bot"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot_enhancers/send_to_messenger_list"); ?>"><?php echo $this->lang->line("Send to Messenger Plugin"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card main_card">

                <div class="card-body">
                    <form action="#" enctype="multipart/form-data" id="plugin_form">
                        <input type="hidden" name="hidden_id" id="hidden_id" value="<?php echo $xdata['id']; ?>">
                        <div class="row">
                            <div class="form-group col-12 col-md-3 d-none">
                                <label>
                                    <?php echo $this->lang->line("Select Page"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("select page") ?>"
                                       data-content='<?php echo $this->lang->line("Select your Facebook page for which you want to generate the plugin.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <?php $page_info[''] = $this->lang->line("select page"); ?>
                                <?php echo form_dropdown('page', $page_info, '', 'class="form-control select2" id="page" style="width:100%;"'); ?>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label>
                                    <?php echo $this->lang->line("Domain"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("domain") ?>"
                                       data-content='<?php echo $this->lang->line("Domain where you want to embed this plugin. Domain must have https.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <input type="text" name="domain_name" autocomplete="off" id="domain_name"
                                       class="form-control" placeholder="https://example.com">
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label>
                                    <?php echo $this->lang->line("Language"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("language") ?>"
                                       data-content='<?php echo $this->lang->line("plugin will be loaded in this language.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <?php echo form_dropdown('language', $sdk_list, 'en_US', 'class="form-control select2" id="language" style="width:100%;"'); ?>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label>
                                    <?php echo $this->lang->line("CTA button text"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("CTA button text") ?>"
                                       data-content='<?php echo $this->lang->line("you can choose CTA button text from this CTA list.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <?php $cta_options[''] = $this->lang->line("default"); ?>
                                <?php echo form_dropdown('cta_text_option', $cta_options, '', 'class="form-control select2" id="cta_text_option" style="width:100%;"'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Plugin Skin"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("plugin skin") ?>"
                                       data-content='<?php echo $this->lang->line("light skin is suitable for pages with dark background and dark skin is suitable for pages with light background.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="skin" value="white" id="white"
                                                       class="selectgroup-input">
                                                <span class="selectgroup-button"> <?php echo $this->lang->line("White") ?></span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="skin" value="blue" id="blue"
                                                       class="selectgroup-input">
                                                <span class="selectgroup-button"> <?php echo $this->lang->line("Blue") ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Plugin Size"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("plugin size") ?>"
                                       data-content='<?php echo $this->lang->line("overall plugin size.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="selectgroup selectgroup-pills">
                                    <?php
                                    $i = 0;
                                    foreach ($btn_sizes as $key => $value) {
                                        $i++;
                                        $checked = $selected = '';
                                        if ($value == 'standard') {
                                            $selected = 'default-label';
                                            $checked = 'checked';
                                        }
                                        $val_print = $value;
                                        if ($val_print == "xlarge") $val_print = "Extra Large";

                                        echo '<label class="selectgroup-item">
									                    <input type="radio" name="btn_size" value="' . $value . '" id="btn_size' . $i . '" ' . $checked . ' class="selectgroup-input">
									                    <span class="selectgroup-button">' . $this->lang->line($val_print) . '</span>
									                  </label>';
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="custom-switch mt-2">

                                        <input type="checkbox" name="redirect" id="redirect_or_not"
                                               class="custom-control-input">
                                        <label class="custom-control-label mr-1" for="redirect_or_not"></label>
                                        <span><?php echo $this->lang->line("Redirect to a webpage on successful OPT-IN") ?></span>

                                    </label>
                                </div>
                            </div>

                            <div class="form-group col-12 col-md-6 display_messsage_block">
                                <label>
                                    <?php echo $this->lang->line("OPT-IN success message in website"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("OPT-IN success message") ?>"
                                       data-content='<?php echo $this->lang->line("this message will be displayed after successful OPT-IN.") ?> <?php echo $this->lang->line('Keep it blank if you do not want.'); ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <textarea class="form-control"
                                          placeholder="<?php echo $this->lang->line('Keep it blank if you do not want.'); ?>"
                                          name="button_click_success_message" id="button_click_success_message"
                                          style="width: 100%;"><?php echo 'You have been subscribed successfully, thank you.'; ?></textarea>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" value="1" class="custom-control-input"
                                           name="add_button_with_message" id="add_button_with_message">
                                    <label class="custom-control-label"
                                           for="add_button_with_message"><?php echo $this->lang->line("I want to add a button in success message"); ?></label>
                                </div>

                            </div>


                        </div>


                        <div class="row display_messsage_block display_button_block">
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("button text"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button text") ?>"
                                       data-content='<?php echo $this->lang->line("This button will be embeded with OPT-IN successful message.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="success_button" id="success_button" class="form-control"
                                       value="Send Message">
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Button URL"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Button URL") ?>"
                                       data-content='<?php echo $this->lang->line("Button click action URL") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="success_url" id="success_url" class="form-control" value="">
                            </div>
                        </div>

                        <div class="row display_messsage_block display_button_block">


                            <div class="form-group col-12 col-md-3">
                                <label>
                                    <?php echo $this->lang->line("Button background"); ?> *

                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="success_button_bg_color"
                                           id="success_button_bg_color">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Button text color"); ?> *

                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="success_button_color"
                                           id="success_button_color">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Button hover background"); ?> *

                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="success_button_bg_color_hover"
                                           id="success_button_bg_color_hover">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Button text hover color"); ?> *

                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="success_button_color_hover"
                                           id="success_button_color_hover">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row redirect_block">
                            <div class="form-group col-12">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("OPT-IN success redirect URL"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("OPT-IN success redirect URL") ?>"
                                       data-content='<?php echo $this->lang->line("Visitors will be redirected to this URL after successful OPT-IN.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="success_redirect_url" id="success_redirect_url"
                                       class="form-control" value="">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12 <?php if (!$this->is_broadcaster_exist) echo 'col-md-6'; else echo 'col-md-5'; ?>">
                                <label>
                                    <?php echo $this->lang->line("OPT-IN inbox confirmation message template"); ?> *
                                    <a href="#" data-html="true" data-placement="top" data-toggle="popover"
                                       data-trigger="focus"
                                       title="<?php echo $this->lang->line("OPT-IN inbox confirmation message template") ?>"
                                       data-content='<?php echo $this->lang->line("This content will be sent to messenger inbox on OPT-IN.") ?> <?php echo $this->lang->line("You must select page to fill this list with data."); ?> <?php echo $this->lang->line("You can create template from ") . ' <a href="' . base_url("messenger_bot/create_new_template") . '">' . $this->lang->line("here.") ?></a>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <?php echo form_dropdown('template_id', array(), '', 'class="select2 form-control" id="template_id" style="width:100%;"'); ?>
                                <a href="#" class="add_template float-left"
                                   page_id_add_postback="<?php echo $xdata['page_id']; ?>"><i
                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Template"); ?>
                                </a>
                                <a href="#" class="ref_template float-right"
                                   page_id_refresh_postback="<?php echo $xdata['page_id']; ?>"><i
                                            class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?></a>
                            </div>
                            <div class="form-group col-12 <?php if (!$this->is_broadcaster_exist) echo 'col-md-6'; else echo 'col-md-3'; ?>">
                                <label>
                                    <?php echo $this->lang->line("reference"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("reference") ?>"
                                       data-content='<?php echo $this->lang->line("put a unique reference to track this plugin later.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="reference" id="reference" class="form-control" value="">
                            </div>
                            <div class="form-group col-12 col-md-4 <?php if (!$this->is_broadcaster_exist) echo 'hidden'; ?>">
                                <label class="d-block">
                                    <?php echo $this->lang->line("select label"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("select label") ?>"
                                       data-content='<?php echo $this->lang->line("subscriber obtained from this plugin will be enrolled in these labels.") ?> <?php echo $this->lang->line("You must select page to fill this list with data."); ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                    <a class="blue float-right pointer"
                                       page_id_for_label="<?php echo $xdata["page_id"]; ?>"
                                       id="create_label_sendmessenger"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create Label"); ?>
                                    </a>
                                </label>
                                <?php echo form_dropdown('label_ids[]', array(), '', 'style="height:45px;overflow:hidden;width:100%;" multiple="multiple" class="select2 form-control" id="label_ids"'); ?>
                            </div>
                        </div>

                        <button class="btn btn-primary" id="get_button" name="get_button" type="button"><i
                                    class="bx bxs-save"></i> <?php echo $this->lang->line("Update Plugin"); ?></button>

                        <a href="<?php echo base_url('messenger_bot_enhancers/send_to_messenger_list'); ?>"
                           class="btn btn-secondary float-right"><i
                                    class="bx bx-time"></i> <?php echo $this->lang->line("Cancel"); ?></a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- postback template add modal -->
<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i class="bx bx-sync"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("Close & Refresh List"); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>


<?php
$button_with_message_content = json_decode($xdata['button_with_message_content'], true);
$success_button = isset($button_with_message_content['success_button']) ? $button_with_message_content['success_button'] : "";
$success_url = isset($button_with_message_content['success_url']) ? $button_with_message_content['success_url'] : "";
$success_button_bg_color = isset($button_with_message_content['success_button_bg_color']) ? $button_with_message_content['success_button_bg_color'] : "";
$success_button_color = isset($button_with_message_content['success_button_color']) ? $button_with_message_content['success_button_color'] : "";
$success_button_bg_color_hover = isset($button_with_message_content['success_button_bg_color_hover']) ? $button_with_message_content['success_button_bg_color_hover'] : "";
$success_button_color_hover = isset($button_with_message_content['success_button_color_hover']) ? $button_with_message_content['success_button_color_hover'] : "";

if ($success_button_bg_color == '') $success_button_bg_color = '#5CB85C';
if ($success_button_color == '') $success_button_color = '#FFFFFF';
if ($success_button_bg_color_hover == '') $success_button_bg_color_hover = '#339966';
if ($success_button_color_hover == '') $success_button_color_hover = '#FFFDDD';
?>






