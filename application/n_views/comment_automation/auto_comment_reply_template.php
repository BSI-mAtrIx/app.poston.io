<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
$include_summernote = 0;
$include_emoji = 1;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
?>

<?php $is_demo = $this->is_demo; ?>
<?php $is_admin = ($this->session->userdata('user_type') == "Admin") ? 1 : 0; ?>
<link rel="stylesheet"
      href="<?php echo base_url('n_assets/css/system/instagram/auto_comment_reply_template.css?ver=' . $n_config['theme_version']); ?>">

<div id="dynamic_field_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" id="add_name">
                <div class="modal-header">
                    <h3 class="modal-title"><i
                                class="bx bxs-grid-alt"></i> <?php echo $this->lang->line('Please Give The Following Information For Post Auto Comment'); ?>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal"><i class="bx bx-x"></i></button>
                </div>
                <div class="modal-body pb-0">

                    <label>
                        <i class="bx bxs-grid-alt"></i>
                        <?php echo $this->lang->line('Template Name'); ?>
                    </label>
                    <div class="form-group">
                        <input type="text" name="template_name" id="name" class="form-control"
                               placeholder="<?php echo $this->lang->line('Your Template Name'); ?>"/>
                    </div>
                    <div id="dynamic_field">

                    </div>

                    <button type="button" name="add_more" id="add_more"
                            class="font_size_10px text-center btn btn-sm btn-outline-primary add_more_edit float-right">
                        <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('add more'); ?></button>
                    <button type="button" id="add_more_new"
                            class="font_size_10px text-center btn btn-sm btn-outline-primary add_more_new float-right">
                        <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('add more'); ?>
                    </button>
                    <div class="smallspace clearfix"></div>
                    <div class="col-xs-12 text-center" id="response_status"></div>
                </div>
                <div class="modal-footer" style="margin-top: 10px;">
                    <input type="hidden" name="hidden_id" id="hidden_id"/>
                    <input type="hidden" name="action" id="action" value="insert"/>

                    <button type="submit" name="submit" id="submit" class="btn btn-primary"><i class='bx bx-save'></i>
                        <span class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    <button class="btn btn-secondary float-right" data-dismiss="modal"><i class="bx bx-trash"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>

                </div>
            </form>
        </div>
    </div>

</div>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("comment_automation/comment_growth_tools"); ?>"><?php echo $this->lang->line("Comment Growth Tools"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a name="add" id="add" href="#" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create new template"); ?>
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
                                <th><?php echo $this->lang->line("Template Name"); ?></th>
                                <th class="min_width_150px"><?php echo $this->lang->line("Actions"); ?></th>
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


<div class="modal fade" id="delete_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center"><?php echo $this->lang->line("Template Delete Confirmation") ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="delete_template_modal_body">

            </div>
        </div>
    </div>
</div>
