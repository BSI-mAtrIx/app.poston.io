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
$include_prism = 1;
?>

<!-- new datatable section -->

<div class="content-header row <?php if($iframe==1){echo 'd-none';} ?> ">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("Post-back Manager"); ?></h5>
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
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("Post-back Manager"); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?php

$builder_load_url = base_url("visual_flow_builder/load_builder/{$page_id}/1/{$media_type}");
$classic_url = base_url("messenger_bot/create_new_template/{$iframe}/{$page_id}/0/{$media_type}");

?>
<div class="row">
        <?php

        if ($media_type == 'ig') {

            $ig_flow_page_list = $ig_flow_page_list['page_list'];

            if (!empty($ig_flow_page_list) and $iframe == 0) { ?>
        <div class="col-sm-12 col-md-6">
                <fieldset class="form-group" id="store_list_field">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text"
                                   for="bot_list_select"><?php if ($media_type == 'ig') echo $this->lang->line("Accounts"); else echo $this->lang->line("Pages"); ?></label>
                        </div>
                        <select class="form-control select2" id="bot_list_select">

                            <?php $i = 0;
                            $current_store_data = array();
                            foreach ($ig_flow_page_list as $key => $value) {
                                if ($key == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                                ?>
                                <option value="<?php echo $key; ?>" <?php if ($i == 0 || $key == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>>
                                    <?php echo $value; ?>
                                </option>

                                <?php $i++;
                            } ?>
                        </select>
                    </div>
                </fieldset>
        </div>
            <?php }
        }

        if ($media_type == 'fb' and !empty($page_info) and $iframe == 0) { ?>
        <div class="col-sm-12 col-md-6">
            <fieldset class="form-group" id="store_list_field">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"
                               for="bot_list_select"><?php if ($media_type == 'ig') echo $this->lang->line("Accounts"); else echo $this->lang->line("Pages"); ?></label>
                    </div>
                    <select class="form-control select2" id="bot_list_select">

                        <?php $i = 0;
                        $current_store_data = array();
                        foreach ($page_info as $value) {
                            if ($value['id'] == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                            ?>
                            <option value="<?php echo $value['id']; ?>" <?php if ($i == 0 || $value['id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>>
                                <?php
                                if (addon_exist($module_id = 320, $addon_unique_name = "instagram_bot")) {
                                    if (isset($media_type) && $media_type == "ig") {
                                        echo $value['insta_username'] . " [" . $value['page_name'] . "]";
                                    } else {
                                        echo $value['page_name'];
                                    }
                                } else {
                                    echo $value['page_name'];
                                }
                                ?>
                            </option>

                            <?php $i++;
                        } ?>
                    </select>
                </div>
            </fieldset>
        </div>
        <?php } ?>
    <div class="col-sm-12 col-md-6">

        <a class="btn btn-primary mb-1" href="<?php echo $builder_load_url; ?>" target="_BLANK">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Postback"); ?>
        </a>

        <a class="btn btn-primary mb-1" href="<?php echo $classic_url; ?>"
           title="<?php echo $this->lang->line("Use Classic Builder"); ?>">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create with classic editor"); ?>
        </a>
    </div>
</div>


<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">

                    <div class="table-responsive2">
                        <input type="hidden" id="template_media_type" name="template_media_type"
                               value="<?php echo $media_type; ?>">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("id") ?></th>
                                <th><?php echo $this->lang->line("Name") ?></th>
                                <th><?php echo $this->lang->line("Postback ID") ?></th>
                                <?php if ($visual_flow_builder_exist == 'yes') : ?>
                                    <th><?php echo $this->lang->line("Type") ?></th>
                                <?php endif; ?>
                                <th><?php echo $this->lang->line("Actions") ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="get_json_code" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center"><i
                            class="bx bx-code"></i> <?php echo $this->lang->line("JSON Code"); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="get_json_code_modal_body">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center"><i
                            class="bx bx-trash"></i> <?php echo $this->lang->line("Template Delete Confirmation"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="delete_template_modal_body">

            </div>
        </div>
    </div>
</div>

<div id="dynamic_field_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="page_name">
                <div class="modal-body" style="padding-bottom:0">
                    <div class="row">
                        <div class="col-12">
                            <?php if (addon_exist($module_id = 320, $addon_unique_name = "instagram_bot")) : ?>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Please select a page"); ?></label>
                                    <select name="page_table_id" id="page_table_id" class="form-control select2"
                                            style="width:100%;">
                                        <?php
                                        echo "<option value=''>" . $this->lang->line('Choose a Page') . "</option>";
                                        if ($media_type == 'fb') {
                                            foreach ($flow_page_list['page_list'] as $key => $value) {
                                                echo "<option value='" . $key . "' >" . $value . "</option>";
                                            }

                                        } else if ($media_type == 'ig') {
                                            foreach ($ig_flow_page_list['page_list'] as $key => $value) {
                                                echo "<option value='" . $key . "' >" . $value . "</option>";
                                            }

                                        }
                                        ?>
                                    </select>

                                    <!-- <select class="form-control select2" id="page_table_id" name="page_table_id" style="width:100%;">
                            <?php
                                    echo "<option value=''>" . $this->lang->line('Choose a Page') . "</option>";
                                    foreach ($group_page_list as $key => $value) {
                                        echo '<optgroup label="' . $value['media_name'] . '">';
                                        foreach ($value['page_list'] as $key2 => $value2) {
                                            echo "<option value='" . $key2 . "' >" . $value2 . "</option>";
                                        }
                                        echo '</optgroup>';
                                    }
                                    ?>
                          </select> -->
                                </div>
                                <!-- <div class="form-group">
                        <label class="d-block"><?php echo $this->lang->line('Media'); ?></label>
                        <div class="row">
                          <div class="col-12 col-md-6">
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="media_type_fb" name="media_type" value="fb" class="custom-control-input">
                              <label class="custom-control-label" for="media_type_fb"><?php echo $this->lang->line('Facebook'); ?></label>
                            </div>
                          </div>
                          <div class="col-12 col-md-6">
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="media_type_ig" name="media_type" value="ig" class="custom-control-input">
                              <label class="custom-control-label" for="media_type_ig"><?php echo $this->lang->line('Instagram'); ?></label>
                            </div>
                          </div>
                        </div>
                      </div> -->
                            <?php else : ?>
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Please select a page"); ?></label>
                                    <?php
                                    $page_list[''] = $this->lang->line("Choose a Page");
                                    echo form_dropdown('page_table_id', $page_list, '', 'id="page_table_id" class="form-control select2" style="width:100%;"');
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 10px;">
                    <button class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>
                    <button id="submit" class="btn btn-primary"><i
                                class="bx bx-check"></i> <?php echo $this->lang->line('Ok'); ?></button>

                </div>
            </form>
        </div>
    </div>

</div>