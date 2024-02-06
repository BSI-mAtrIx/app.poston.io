<style>
    .add_template, .ref_template {
        font-size: 10px;
        margin-top: 5px
    }
</style>
<link rel="stylesheet"
      href="<?php echo base_url('n_assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css?ver=' . $n_config['theme_version']) ?>">
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
                                href="<?php echo base_url("messenger_bot_enhancers/customer_chat_plugin_list"); ?>"><?php echo $this->lang->line("Customer Chat Plugin"); ?></a>
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
                        <div class="row">
                            <div class="form-group col-12 col-md-6 d-none">
                                <label>
                                    <?php echo $this->lang->line("Select Page"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("select page") ?>"
                                       data-content='<?php echo $this->lang->line("Select your Facebook page for which you want to generate the plugin.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>
                                <?php $page_info[''] = $this->lang->line("Select Page"); ?>
                                <?php echo form_dropdown('page', $page_info, $page_id, 'class="form-control select2" id="page" style="width:100%;"'); ?>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Domain"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Domain") ?>"
                                       data-content='<?php echo $this->lang->line("Domain where you want to embed this plugin. Domain must have https.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="domain_name" id="domain_name" class="form-control"
                                       placeholder="https://example.com">
                            </div>


                        </div>

                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Language"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("language") ?>"
                                       data-content='<?php echo $this->lang->line("Chat plugin will display various elements using this language.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <?php echo form_dropdown('language', $sdk_locale, 'en_US', 'class="form-control select2" id="language" style="width:100%;"'); ?>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Chat Plugin Loading"); ?>
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Chat Plugin Loading") ?>"
                                       data-content='<?php echo $this->lang->line("Choose how chat plugin will be loaded") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="selectgroup selectgroup-pills">
                                    <?php
                                    $i = 0;
                                    foreach ($load_chatbox as $key => $value) {
                                        $i++;
                                        $checked = $selected = '';
                                        if ($key == 'show') {
                                            $selected = 'default-label';
                                            $checked = 'checked';
                                        }
                                        $val_print = $value;

                                        echo '<label class="selectgroup-item"><input class="selectgroup-input" type="radio" name="minimized" value="' . $key . '" id="minimized' . $i . '" ' . $checked . '> 
										<span class="selectgroup-button">' . $this->lang->line($val_print) . '</span>
							         </label>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-12 col-md-4">
                                <label>
                                    <?php echo $this->lang->line("Loading delay"); ?>
                                    (<?php echo $this->lang->line("Seconds"); ?>)
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("loading delay") ?>"
                                       data-content='<?php echo $this->lang->line("plugin will be loaded after few seconds.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="number" name="delay" id="delay" value="0" class="form-control" min="0"
                                       step="1">
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class="margin-bottom-label">
                                    <?php echo $this->lang->line("Theme color"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("theme color") ?>"
                                       data-content='<?php echo $this->lang->line("The color to use as a theme for the plugin. Supports any color except white. We highly recommend you choose a color that has a high contrast to white. Keep it blank if you want default theme.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="color" id="color" value="#FFFFFF">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label>
                                    <?php echo $this->lang->line("Do not show if not logged in?"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Do not show if not logged in?") ?>"
                                       data-content='<?php echo $this->lang->line("chat plugin will not be loaded if visitor is not logged in to Facebook.") ?>'><i
                                                class='bx bxs-help-circle'></i> </a>
                                </label>

                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="donot_show_if_not_login" value="1"
                                               id="donot_show_if_not_login1" class="selectgroup-input">
                                        <span class="selectgroup-button"> <?php echo $this->lang->line("Yes"); ?></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="donot_show_if_not_login" value="0"
                                               id="donot_show_if_not_login2" class="selectgroup-input" checked>
                                        <span class="selectgroup-button"> <?php echo $this->lang->line("No"); ?></span>
                                    </label>
                                </div>


                            </div>


                        </div>

                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Greeting text if logged in to facebook"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Greeting text if logged in") ?>"
                                       data-content='<?php echo $this->lang->line("The greeting text that will be displayed if the user is currently logged in to Facebook. Maximum 80 characters.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="logged_in" id="logged_in" class="form-control"
                                       placeholder="<?php echo $this->lang->line('maximum 80 characters'); ?>">
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Greeting text if not logged in to facebook"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("Greeting text if not logged in") ?>"
                                       data-content='<?php echo $this->lang->line("The greeting text that will be displayed if the user is not logged in to Facebook. Maximum 80 characters.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="logged_out" id="logged_out" class="form-control"
                                       placeholder="<?php echo $this->lang->line('maximum 80 characters'); ?>">
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
                                <a href="" class="add_template float-left" page_id_add_postback=""><i
                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Template"); ?>
                                </a>
                                <a href="" class="ref_template float-right" page_id_refresh_postback=""><i
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
                                    <a class="blue float-right pointer" page_id_for_label=""
                                       id="create_label_custom_plugin"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create Label"); ?>
                                    </a>
                                </label>
                                <?php echo form_dropdown('label_ids[]', array(), '', 'style="height:45px;overflow:hidden;width:100%;" multiple="multiple" class="select2 form-control" id="label_ids"'); ?>
                            </div>
                        </div>

                        <button class="btn btn-primary" id="get_button" name="get_button" type="button"><i
                                    class="bx bx-code"></i> <?php echo $this->lang->line("Generate Embed code"); ?>
                        </button>

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


<div class="modal fade" role="dialog" id="get_plugin_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-code"></i> <?php echo $this->lang->line('Chat plugin embed code'); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div id="response"></div>
                        <div class="form-group js_code_con">
                            <label for="description"> <?php echo $this->lang->line("Copy the code below and paste inside body tag or at the very last of your webpage.") ?> </label>

                            <pre class="language-javascript"><code id="test"
                                                                   class="dlanguage-javascript description"></code></pre>

                            <br>
                            <div class="text-center">
                                <a href="" target="_BLANK" id="wp_plugin" class="btn btn-warning"><i
                                            class="bx bx-wordpress"></i> <?php echo $this->lang->line("Download WordPress Plugin to Easy Embed"); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>
    </div>
</div>

