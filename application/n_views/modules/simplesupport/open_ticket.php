<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 1;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("simplesupport/tickets"); ?>"><?php echo $this->lang->line("Support Desk"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url('simplesupport/open_ticket_action'); ?>" method="POST"
                  enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" id="csrf_token"
                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Ticket Title"); ?> *</label>
                                    <input class="form-control" name="ticket_title" id="ticket_title" type="input"
                                           required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line('Ticket Type') ?> *</label>
                                    <select class="select2 form-control" id="support_category" name="support_category"
                                            required>
                                        <?php
                                        echo "<option value=''>{$this->lang->line('Please select a category')}</option>";
                                        foreach ($support_category as $key => $val) {
                                            $id = $val['id'];
                                            $group_name = $val['category_name'];
                                            echo "<option value='{$id}'>{$group_name}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="image_rich_content_block">
                            <label><?php echo $this->lang->line('Ticket Desctiption'); ?> *</label>
                            <!-- <div id="toolbar-container"></div> -->
                            <div id="ckeditor">
                                <textarea required class="form-control" name="ticket_text" id="ticket_text"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-whitesmoke">
                        <?php $red_link = "simplesupport/tickets"; ?>
                        <button type="submit" class="btn btn-primary open"><i
                                    class="bx bx-send"></i> <?php echo $this->lang->line('Open Ticket'); ?> </button>
                        <a onclick="goBack('<?php echo $red_link ?>',1)"
                           class="btn btn-light float-right cancel from-show"><i
                                    class="bx bx-time"></i> <?php echo $this->lang->line("Cancel"); ?> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<style type="text/css">
    .modal-backdrop, .modal-backdrop.in {
        display: none;
    }

    .note-group-select-from-files {
        display: none;
    }

</style>

