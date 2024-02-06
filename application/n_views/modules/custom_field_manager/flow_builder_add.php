<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 1;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;
?>

<style type="text/css" media="screen">
    .first_row {
        margin-bottom: 5px !important;
    }

    .right_column_button {
        background-color: #EBF4FA;
        padding: 10px;
        color: black;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 5px;
    }

    .waiting_reply_content {
        padding: 10px;
        text-align: center;
        color: #bbb;
    }

    #left_header {
        padding: 10px;
        text-align: center;
        border-radius: 5px;
    }

    .waiting_reply_content hr, .waiting_reply_content p {
        display: inline-block;
        vertical-align: middle;
    }

    .appended_icon {
        cursor: pointer;
    }

    .popover-header {
        width: 350px;
    }

    .custom_items {
        border: dashed 0.5px #aaa;
        display: inline-block;
        text-align: center;
        padding: 5px 10px;
        border-radius: 10px;
        margin: 5px;
        cursor: pointer;
    }

    .custom_items .custom_item_icon i {
        font-size: 14px;
    }

    .custom_items .custom_item_info {
        font-size: 13px;
    }

    .custom_items.active {
        background: #6777ef;
        border: 0;
        color: #ffffff;
    }

    .select2-dropdown {
        z-index: 9001;
    }

    .free_input_label {
        border: 1px dashed #ccc;
        padding: 5px 15px;
        border-radius: 15px 20px 0px 15px;
    }

    .edit_input_parent_card {
        margin: 0 0px 0 20px;
        box-shadow: 0 3px 10px 5px #bbb6b6;
        background: #f7f7f7;
    }


    .edit_input_parent_card:before {
        content: "\ed59";
        font-family: 'boxicons' !important;
        font-weight: 900;
        font-size: 40px;
        position: absolute;
        left: -13px;
        top: -10px;
        color: #f7f7f7;
    }

    .multiple_input_more_parent {
        align-items: center;
        justify-content: center;
    }

    .multiple_input_more {
        width: 22% !important;
        border-radius: 20px !important;
        border: dashed 0.5px #aaa;
        height: 30px !important;
        font-size: 12px !important;
        margin-right: 20px;
        text-align: center;
    }

    .multiple_input_more:last-child {
        margin-right: 0;
    }

    .right_column {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 99;
    }

    @media (min-width: 768px) and (max-width: 1024px) {

        div.single {
            display: block !important;
        }

        .input_section, .edit_input_section {
            width: 100% !important;
        }

        .edit_input_parent_card:before {
            content: '';
        }

        .multiple_input_more {
            width: 100% !important;
            border-radius: 20px !important;
            border: dashed 0.5px #aaa;
            height: 30px !important;
            font-size: 12px !important;
            margin-right: 0;
        }

    }

    @media (max-width: 480px) {

        div.single {
            display: block !important;
        }

        .input_section, .edit_input_section {
            width: 100% !important;
        }

        .edit_input_parent_card:before {
            content: '';
        }

        .multiple_input_more {
            width: 100% !important;
            border-radius: 20px !important;
            border: dashed 0.5px #aaa;
            height: 30px !important;
            font-size: 12px !important;
            margin-right: 0;
        }

    }

    .variables {
        cursor: pointer;
    }

</style>


<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <?php if ($media_type == 'ig') {
                        ?>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("bot_instagram"); ?>"><?php echo $this->lang->line("Instagram Bot"); ?></a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("messenger_bot/bot_menu_section"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                        </li>
                        <?php
                    } ?>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('custom_field_manager/campaign_list/' . $media_type); ?>"><?php echo $this->lang->line("Flow Campaigns"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <form action="#" enctype="multipart/form-data" id="flowbuilder_form">
        <input type="hidden" id="media_type" name="media_type" value="<?php echo $media_type; ?>">
        <div class="row">
            <div class="col-12 order-1 order-lg-2">
                <div class="card main_card first_row">
                    <div class="card-header">
                        <h4 class="full_width">
                            <a class="float-right icon-left text-primary variables"><i
                                        class="bx bx-plus"></i> <?php echo $this->lang->line('Variables'); ?></a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><?php echo $this->lang->line("Campaign Name"); ?> </label>
                                    <input name="Campaign_name" id="Campaign_name" value="" class="form-control"
                                           type="text">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 d-none">
                                <div class="form-group">
                                    <label for=""><?php echo $this->lang->line("Choose a page"); ?> </label>
                                    <?php
                                    $page_list[''] = $this->lang->line('Select a Page');
                                    echo form_dropdown('page_table_id', $page_list, $page_id, 'class="form-control select2" id="page_table_id"');
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-8 left_column ">
                                <div id="left_header" class="mb-2 alert alert-light">
                                    <?php echo $this->lang->line('User Input Flow Start'); ?>
                                </div>
                                <div class="total_question_container">

                                </div>

                                <div class="form-group postback_div" style="display: none;">
                                    <label for=""><?php echo $this->lang->line("Select final reply template"); ?> </label>
                                    <select class="form-control select2" id="postback_id" name="postback_id"
                                            style="width: 100%;">
                                        <option value=""><?php echo $this->lang->line('Please select a page first'); ?></option>
                                    </select>

                                    <a href="" class="add_template float-left" page_id_add_postback=""><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right" page_id_ref_postback=""><i
                                                class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?></a>
                                </div>

                            </div>

                            <div class="col-12 col-sm-12 col-md-4 right_column">
                                <div class="right_column_button">
                                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Free Keyboard Input'); ?>
                                </div>

                                <div class="custom_links text-center">
                                    <?php foreach ($reply_types as $key => $value) { ?>
                                        <div class="custom_items add_question" id="keyboard_input"
                                             reply_type="<?php echo $key; ?>">
                                            <div class="custom_item_icon">
                                                <span><i class="ml-0 <?php echo $value; ?>"></i></span>
                                            </div>
                                            <div class="custom_item_info"><i
                                                        class="bx bx-plus"></i> <?php echo $this->lang->line($key); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <div class="right_column_button add_question btn btn-light w-100 border-0 text-left"
                                     id="multiple_choice" data-toggle="tooltip" title="Click to Add">
                                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Multiple Choice'); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-footer">
                        <button class="btn btn-primary" id="submit_flowbuilder" name="submit_flowbuilder" type="button">
                            <i class="bx bx-send"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span>
                        </button>
                        <button class="btn btn-light float-right" onclick="goBack('custom_field_manager/campaign_list')"
                                type="button"><i class="bx bx-time"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>


<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title full_width">
                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?>
                </h3>
                <button type="button" class="close red" data-dismiss="modal" aria-hidden="true">&times;</button>
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

<div class="modal fade" id="variable_data_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-notepad"></i> <?php echo $this->lang->line("All Variables you currently have"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body" data-backdrop="static" data-keyboard="false">
                <div class="row">
                    <div class="col-12">
                        <div class="section">
                            <div class="section-title"><?php echo $this->lang->line('Variable'); ?></div>
                            <p><?php echo $this->lang->line('After you have saved a response in Custom Field, you can use it as a variable in your message reply to subscriber.'); ?></p>
                        </div>
                        <div class="section">
                            <div class="section-title"><?php echo $this->lang->line('How to use Variable?'); ?></div>
                            <p><?php echo $this->lang->line('To use variable for Custom Field, write the variable surrounding by #  like') . "<b> #Custom Field#</b>"; ?></p>
                        </div>
                        <div class="section" id="variable_display_section">
                            <!-- content goes here -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
            </div>

        </div>
    </div>
</div>
