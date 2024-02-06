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
                                href="<?php echo base_url("messenger_bot_enhancers/mme_link_list"); ?>"><?php echo $this->lang->line("M.me link"); ?></a>
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
                                    <?php echo $this->lang->line("button text"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button text") ?>"
                                       data-content='<?php echo $this->lang->line("System will create a new button that will take visitors to m.me link") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <input type="text" name="new_button_display" id="new_button_display"
                                       class="form-control" value="Send us Message">
                            </div>


                        </div>

                        <div class="row">
                            <div class="form-group col-12 col-md-3">
                                <label>
                                    <?php echo $this->lang->line("Button background"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button background") ?>"
                                       data-content='<?php echo $this->lang->line("new button background color") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="new_button_bg_color"
                                           id="new_button_bg_color" value="#0084FF">
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
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button background") ?>"
                                       data-content='<?php echo $this->lang->line("new button text color") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="new_button_color"
                                           id="new_button_color" value="#FFFFFF">
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
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button background") ?>"
                                       data-content='<?php echo $this->lang->line("New button background color on mouse over") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="new_button_bg_color_hover"
                                           id="new_button_bg_color_hover" value="#367FA9">
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
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("button background") ?>"
                                       data-content='<?php echo $this->lang->line("New button text color on mouse over") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="input-group colorpicker-component color-picker-rgb">
                                    <input type="text" class="form-control" name="new_button_color_hover"
                                           id="new_button_color_hover" value="#FFFDDD">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="input-group-addon"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label>
                                    <?php echo $this->lang->line("Button Size"); ?> *
                                    <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                       title="<?php echo $this->lang->line("plugin size") ?>"
                                       data-content='<?php echo $this->lang->line("choose how big you want the button to be.") ?>'><i
                                                class='bx bx-info-circle'></i> </a>
                                </label>
                                <div class="selectgroup selectgroup-pills">

                                    <?php
                                    $i = 0;
                                    foreach ($btn_sizes as $key => $value) {
                                        $i++;
                                        $checked = $selected = '';
                                        if ($value == 'medium') {
                                            $selected = 'default-label';
                                            $checked = 'checked';
                                        }
                                        $val_print = $value;
                                        if ($val_print == "xlarge") $val_print = "Extra Large";

                                        echo '<label class="selectgroup-item"><input class="selectgroup-input" type="radio" name="btn_size" value="' . $value . '" id="btn_size' . $i . '" ' . $checked . '> 
							        		<span class="selectgroup-button">' . $this->lang->line($val_print) . '</span> 
							        	</label>';
                                    }
                                    ?>
                                </div>
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
                                       id="create_label_me_link"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create Label"); ?>
                                    </a>
                                </label>
                                <?php echo form_dropdown('label_ids[]', array(), '', 'style="height:45px;overflow:hidden;width:100%;" multiple="multiple" class="form-control select2" id="label_ids"'); ?>
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
                            class="bx bx-code"></i> <?php echo $this->lang->line('M.me Plugin Embed Code'); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div id="response"></div>
                        <div class="form-group js_code_con">
                            <label for="description"> <?php echo $this->lang->line("copy the code below and paste inside the html element of your webpage where you want to display this plugin.") ?> </label>
                            <pre class="language-javascript"><code id="test"
                                                                   class="dlanguage-javascript description"></code></pre>
                            <br>
                            <label for="js_code2"> <?php echo $this->lang->line("M.me Link") ?> </label>
                            <pre class="language-javascript"><code id="js_code2"
                                                                   class="dlanguage-javascript"></code></pre>
                            <!-- <input type="text" id="js_code2" class="form-control"> -->
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

