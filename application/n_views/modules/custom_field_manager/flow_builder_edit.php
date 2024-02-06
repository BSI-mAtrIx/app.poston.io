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

<?php
$hide_quick_reply_checkbox_for_ig = '';
if ($media_type == 'ig') $hide_quick_reply_checkbox_for_ig = 'hidden';
?>


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
        <input type="hidden" name="flow_campaign_id" id="flow_campaign_id" value="<?php echo $flow_campaign_id; ?>">
        <input type="hidden" name="media_type" id="media_type" value="<?php echo $media_type; ?>">
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
                                    <input name="Campaign_name" id="Campaign_name"
                                           value="<?php echo isset($question_info[0]['flow_name']) ? $question_info[0]['flow_name'] : ''; ?>"
                                           class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><?php echo $this->lang->line("Choose a page"); ?> </label>
                                    <?php
                                    $selected_page_id = isset($question_info[0]['page_table_id']) ? $question_info[0]['page_table_id'] : 0;
                                    $page_list[''] = $this->lang->line('Select a Page');
                                    echo form_dropdown('page_table_id', $page_list, $selected_page_id, 'class="form-control select2" id="page_table_id"');
                                    ?>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-8 left_column">
                                <div id="left_header" class="mb-2 alert alert-light">
                                    <?php echo $this->lang->line('User Input Flow Start'); ?>
                                </div>

                                <div class="total_question_container">

                                    <?php foreach ($question_info as $key => $value) : ?>
                                        <div class="single_question_container">
                                            <input type="hidden" name="question_type[<?php echo $key; ?>]"
                                                   id="question_type[<?php echo $key; ?>]"
                                                   value="<?php echo $value['type']; ?>"/>
                                            <input type="hidden" name="question_table_id[<?php echo $key; ?>]"
                                                   id="question_table_id[<?php echo $key; ?>]"
                                                   value="<?php echo $value['q_table_id']; ?>"/>
                                            <div class="single d-flex mb-5" id="block_<?php echo $key; ?>">

                                                <?php if ($value['type'] == 'keyboard input') : ?>
                                                    <div class="input_section" style="width:100%"
                                                         id="input_section_<?php echo $key; ?>">
                                                        <div class="form-group">
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control type_questions"
                                                                       name="question[<?php echo $key; ?>]"
                                                                       placeholder="<?php echo $this->lang->line('Put your question here'); ?>"
                                                                       value="<?php echo $value['question']; ?>">
                                                                <div class="input-group-append append_icon pointer"
                                                                     id="<?php echo $key; ?>">
                                                                    <div class="input-group-text"
                                                                         id="append_icon_body_<?php echo $key; ?>"><i
                                                                                class="bx bx-cog"></i></div>
                                                                </div>
                                                            </div>
                                                            <div class="float-right free_input_label"><?php echo $this->lang->line('Free keyboard input'); ?></div>
                                                        </div>
                                                        <br>
                                                        <div class="waiting_reply_content">
                                                            <span>..... <?php echo $this->lang->line('Waiting for a reply from the user'); ?> ....</span>
                                                        </div>
                                                    </div>
                                                <?php else : ?>
                                                    <div class="input_section" style="width:100%"
                                                         id="input_section_<?php echo $key; ?>">
                                                        <div class="form-group mb-2">
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control type_questions"
                                                                       name="question[<?php echo $key; ?>]"
                                                                       placeholder="<?php echo $this->lang->line('Put your question here'); ?>"
                                                                       value="<?php echo $value['question']; ?>">
                                                                <div class="input-group-append append_icon pointer"
                                                                     id="<?php echo $key; ?>">
                                                                    <div class="input-group-text"
                                                                         id="append_icon_body_<?php echo $key; ?>"><i
                                                                                class="bx bx-cog"></i></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-inline multiple_input_more_parent">
                                                                <div class="multiple_input_item"
                                                                     id="multiple_choice_buttons_<?php echo $key; ?>">
                                                                    <?php $multiple_choice_array = explode(',', $value['multiple_choice_options']); ?>
                                                                    <?php foreach ($multiple_choice_array as $single_choice_key => $single_choice_value) : ?>
                                                                        <input type="text"
                                                                               class="form-control mb-2 multiple_input_more"
                                                                               name="multiple_choice[<?php echo $key; ?>][]"
                                                                               id="multiple_choice[<?php echo $key; ?>][]"
                                                                               value="<?php echo $single_choice_value; ?>">
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mr-2">
                                                            <button type=""
                                                                    class="btn btn-sm btn-outline-primary float-right add_more_button"
                                                                    div_id="multiple_choice_buttons_<?php echo $key; ?>">
                                                                <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add more'); ?>
                                                            </button>
                                                        </div>
                                                        <br>
                                                        <div class="waiting_reply_content">
                                                            <span>..... <?php echo $this->lang->line('Waiting for a reply from the user'); ?> ....</span>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <div class="edit_input_section" style="width:70%; display:none;"
                                                     id="edit_input_section_<?php echo $key; ?>">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card edit_input_parent_card">
                                                                <div class="card-body p-3">
                                                                    <div class="form-group mb-1"
                                                                         id="selected_reply_type_<?php echo $key; ?>">
                                                                        <label><?php echo $this->lang->line('Reply type'); ?></label>
                                                                        <select name="reply_type[<?php echo $key; ?>][]"
                                                                                id="reply_type_<?php echo $key; ?>"
                                                                                class="form-control selected_reply_type select2"
                                                                                div_id="selected_reply_type_<?php echo $key; ?>"
                                                                                checkbox_div_id="email_quickreply_checkbox_<?php echo $key; ?>"
                                                                                phone_checkbox_div_id="phone_quickreply_checkbox_<?php echo $key; ?>"
                                                                                style="width:100%;">
                                                                            <option value=""><?php echo $this->lang->line('Please select'); ?></option>
                                                                            <?php
                                                                            foreach ($reply_types_array as $reply_type_value) :
                                                                                $reply_type_key = $reply_type_value;
                                                                                ?>
                                                                                <option value='<?php echo $reply_type_key; ?>' <?php if ($reply_type_value == $value['reply_type']) echo 'selected'; ?> >
                                                                                    <?php
                                                                                    if ($reply_type_value == 'Date') $reply_type_value = "Date (YYYY-MM-DD)";
                                                                                    if ($reply_type_value == 'Time') $reply_type_value = "Time (HH:MM)";
                                                                                    echo $reply_type_value;
                                                                                    ?>

                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>

                                                                    <div id="email_quickreply_checkbox_<?php echo $key; ?>"
                                                                         class="<?php if ($value['reply_type'] != 'Email') echo 'd-none'; ?> mb-1 <?php echo $hide_quick_reply_checkbox_for_ig; ?>">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="yes"
                                                                                   id="quickreply_checkbox[<?php echo $key; ?>][]"
                                                                                   name="quickreply_checkbox[<?php echo $key; ?>][]"
                                                                                   class="custom-control-input" <?php if ($value['quick_reply_email'] == 'yes') echo 'checked'; ?> >
                                                                            <label class="custom-control-label"
                                                                                   for="quickreply_checkbox[<?php echo $key; ?>][]"><?php echo $this->lang->line("Attach Email Quick-reply"); ?></label>
                                                                        </div>
                                                                    </div>

                                                                    <div id="phone_quickreply_checkbox_<?php echo $key; ?>"
                                                                         class="<?php if ($value['reply_type'] != 'Phone') echo 'd-none'; ?> mb-1 <?php echo $hide_quick_reply_checkbox_for_ig; ?>">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" value="yes"
                                                                                   id="phone_quickreply_checkbox[<?php echo $key; ?>][]"
                                                                                   name="phone_quickreply_checkbox[<?php echo $key; ?>][]"
                                                                                   class="custom-control-input" <?php if ($value['quick_reply_phone'] == 'yes') echo 'checked'; ?> >
                                                                            <label class="custom-control-label"
                                                                                   for="phone_quickreply_checkbox[<?php echo $key; ?>][]"><?php echo $this->lang->line("Attach Phone Quick-reply"); ?></label>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group mb-1"
                                                                         div_id="selected_custom_field_<?php echo $key; ?>">
                                                                        <label><?php echo $this->lang->line('Save to Custom Field'); ?></label>
                                                                        <select name="custom_field[<?php echo $key; ?>][]"
                                                                                id="selected_custom_field_<?php echo $key; ?>"
                                                                                reply_type_id="reply_type_<?php echo $key; ?>"
                                                                                class="form-control selected_custom_field select2"
                                                                                style="width:100%;">
                                                                            <?php
                                                                            $custom_field_array = isset($custom_fields[$value['reply_type']]) ? $custom_fields[$value['reply_type']] : [];
                                                                            if (empty($custom_field_array))
                                                                                echo "<option value=''>" . $this->lang->line('No custom field found') . "</option>";
                                                                            else {
                                                                                echo "<option value=''>" . $this->lang->line('Please select') . "</option>";
                                                                                foreach ($custom_field_array as $custom_field_key => $custom_field_value) :

                                                                                    ?>
                                                                                    <option value='<?php echo $custom_field_key; ?>' <?php if ($custom_field_key == $value['custom_field_id']) echo 'selected'; ?> ><?php echo $custom_field_value; ?></option>
                                                                                <?php endforeach;
                                                                            } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mb-1"
                                                                         id="selected_system_field_<?php echo $key; ?>">
                                                                        <label><?php echo $this->lang->line('Save to System Field'); ?></label>
                                                                        <select name="system_field[<?php echo $key; ?>][]"
                                                                                div_id="selected_system_field_<?php echo $key; ?>"
                                                                                class="form-control selected_system_field select2"
                                                                                style="width:100%;">
                                                                            <option value=""><?php echo $this->lang->line('Please select one'); ?></option>
                                                                            <?php foreach ($system_fields_array as $single_system_field) : ?>
                                                                                <option value="<?php echo $single_system_field; ?>" <?php if ($single_system_field == $value['system_field']) echo 'selected'; ?> > <?php echo ucfirst($single_system_field); ?> </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group mb-1"
                                                                         id="assign_to_labels_<?php echo $key; ?>">
                                                                        <label><?php echo $this->lang->line("Assign to labels"); ?></label>
                                                                        <select multiple
                                                                                class="form-control assign_to_labels select2"
                                                                                name="label_assigned[<?php echo $key; ?>][]"
                                                                                div_id="assign_to_labels_<?php echo $key; ?>"
                                                                                style="width:100%;">
                                                                            <?php
                                                                            $selected_user_labels_array = explode(',', $value['label_ids']);
                                                                            if (empty($user_label_info))
                                                                                echo "<option value=''>" . $this->lang->line('No label found') . "</option>";
                                                                            else {
                                                                                echo "<option value=''>" . $this->lang->line('Please select') . "</option>";
                                                                                foreach ($user_label_info as $single_label_info) :

                                                                                    ?>
                                                                                    <option value='<?php echo $single_label_info['id']; ?>' <?php if (in_array($single_label_info['id'], $selected_user_labels_array)) echo 'selected'; ?> > <?php echo $single_label_info['group_name']; ?> </option>
                                                                                <?php endforeach;
                                                                            } ?>
                                                                        </select>
                                                                    </div>

                                                                    <?php if ($messenger_sequence_exist == 'yes') { ?>
                                                                        <div class="form-group mb-1"
                                                                             id="assign_to_messenger_sequence_<?php echo $key; ?>">
                                                                            <label><?php echo $this->lang->line("Assign to a Messenger Sequence"); ?></label>
                                                                            <select class="form-control assign_to_messenger_sequence select2"
                                                                                    name="messenger_sequence_assigned[<?php echo $key; ?>][]"
                                                                                    div_id="assign_to_messenger_sequence_<?php echo $key; ?>"
                                                                                    style="width:100%;">
                                                                                <?php
                                                                                if (empty($messenger_sequence_info))
                                                                                    echo "<option value=''>" . $this->lang->line('No sequence campaign found') . "</option>";
                                                                                else {
                                                                                    echo "<option value=''>" . $this->lang->line('Please select') . "</option>";
                                                                                    foreach ($messenger_sequence_info as $single_messenger_sequence_info) :

                                                                                        ?>
                                                                                        <option value='<?php echo $single_messenger_sequence_info['id']; ?>' <?php if ($single_messenger_sequence_info['id'] == $value['messenger_sequence_id']) echo 'selected'; ?> > <?php echo $single_messenger_sequence_info['campaign_name']; ?> </option>
                                                                                    <?php endforeach;
                                                                                } ?>
                                                                            </select>
                                                                        </div>
                                                                    <?php } ?>


                                                                    <?php if ($sms_email_sequence_exist == 'yes') { ?>
                                                                        <div class="form-group mb-1"
                                                                             id="assign_to_email_phone_sequence_<?php echo $key; ?>">
                                                                            <label><?php echo $this->lang->line('Assign to a Email/Phone Sequence'); ?></label>
                                                                            <select class="form-control assign_to_email_phone_sequence select2"
                                                                                    name="email_phone_sequence_assigned[<?php echo $key; ?>][]"
                                                                                    div_id="assign_to_email_phone_sequence_<?php echo $key; ?>"
                                                                                    style="width:100%;">
                                                                                <?php
                                                                                if (empty($email_phone_sequence_info))
                                                                                    echo "<option value=''>" . $this->lang->line('No sequence campaign found') . "</option>";
                                                                                else {
                                                                                    echo "<option value=''>" . $this->lang->line('Please select') . "</option>";
                                                                                    foreach ($email_phone_sequence_info as $single_email_phone_sequence) :

                                                                                        ?>
                                                                                        <option value='<?php echo $single_email_phone_sequence['id']; ?>' <?php if ($single_email_phone_sequence['id'] == $value['email_phone_sequence_id']) echo 'selected'; ?> > <?php echo $single_email_phone_sequence['campaign_name'] . " [" . $single_email_phone_sequence['campaign_type'] . "]"; ?> </option>
                                                                                    <?php endforeach;
                                                                                } ?>
                                                                            </select>
                                                                        </div>
                                                                    <?php } ?>

                                                                    <div class="form-group mb-1"
                                                                         id="skip_button_field_<?php echo $key; ?>">
                                                                        <label><?php echo $this->lang->line('Skip button text'); ?></label>
                                                                        <input type="text" class="form-control"
                                                                               name="skip_button_text[<?php echo $key; ?>]"
                                                                               placeholder="Put your skip button text here"
                                                                               value="<?php echo $value['skip_button_text']; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer text-center pt-0">
                                                                    <a href="#"
                                                                       class="btn btn-icon btn-sm icon-left btn-danger delete_single_block"
                                                                       single_block_div_id="block_<?php echo $key; ?>"><i
                                                                                class="bx bx-time"></i> <?php echo $this->lang->line('Remove This Question'); ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>

                                <div class="form-group">
                                    <label for=""><?php echo $this->lang->line("Select final reply template"); ?> </label>
                                    <select class="form-control select2" id="postback_id" name="postback_id"
                                            style="width: 100%;">
                                        <?php echo $postbacks; ?>
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

                                <div class="right_column_button add_question" id="multiple_choice">
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
                        <a class="btn btn-light float-right"
                           href="<?php echo base_url("custom_field_manager/campaign_list/{$selected_page_id}/1/$media_type") ?>"><i
                                    class="bx bx-time"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("Cancel"); ?></span></a>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>


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
