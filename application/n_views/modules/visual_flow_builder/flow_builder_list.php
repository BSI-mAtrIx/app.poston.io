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
$include_mCustomScrollBar = 0;
$include_dropzone = 1;
?>

<style type="text/css">
    .button {
        margin-top: 10px;
    }

    .datagrid-body {
        overflow: hidden !important;
    }

    .emojionearea, .emojionearea.form-control {
        height: 150px !important;
    }


</style>

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
                                    <select class="form-control select2" id="page_table_id" name="page_table_id"
                                            style="width:100%;">
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
                                    </select>
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

<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot/bot_menu_section"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<?php

$builder_load_url = base_url("visual_flow_builder/load_builder/{$page_auto_id}/1/{$media_type}");
?>
<div class="alert alert-secondary alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        <?php echo $this->lang->line('Action button like Get Started, No Match etc are available in Action Button Settings Tab.'); ?>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a target="_blank" href="<?php echo $builder_load_url; ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create new Flow"); ?>
        </a>
        <a href="<?php echo base_url('messenger_bot/saved_templates'); ?>" target="_BLANK" class="btn btn-primary mb-1">
            <i class="bx bx-upload"></i> <?php echo $this->lang->line("Import from template"); ?>
        </a>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Template ID"); ?></th>
                                <th><?php echo $this->lang->line("Reference Name"); ?></th>
                                <th><?php echo $this->lang->line("Page Name"); ?></th>
                                <th><?php echo $this->lang->line("Media Type"); ?></th>
                                <th style="min-width: 150px"><?php echo $this->lang->line("Actions"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


