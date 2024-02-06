<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_colorpicker = 0;
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


<style type="text/css">
    @media (max-width: 575.98px) {
        #post_id {
            width: 50% !important;
        }
    }
</style>
<!-- new datatable section -->

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
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("comment_automation/comment_section_report"); ?>"><?php echo $this->lang->line("Report"); ?></a>
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
            <div class="card">
                <div class="card-body data-card">

                    <div class="input-group mb-3" id="searchbox">
                        <input type="text" class="form-control" id="post_id" autofocus
                               placeholder="<?php echo $this->lang->line('Post ID'); ?>" aria-label=""
                               aria-describedby="basic-addon2" style="max-width: 30%">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="search_submit" type="button"><i
                                        class="bx bx-search"></i> <span
                                        class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("id") ?></th>
                                <th><?php echo $this->lang->line("Page Name") ?></th>
                                <th><?php echo $this->lang->line("Post ID") ?></th>
                                <th><?php echo $this->lang->line("Auto Like") ?></th>
                                <th><?php echo $this->lang->line("Auto Share") ?></th>
                                <th><?php echo $this->lang->line("Actions") ?></th>
                                <th><?php echo $this->lang->line("Last Share Try") ?></th>
                                <th><?php echo $this->lang->line("Last Like Try") ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="view_report" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg" style="min-width: 80%;">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-list-ul"></i> <?php echo $this->lang->line("Auto Like/Share Report") ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body" id="view_report_modal_body">

            </div>
        </div>
    </div>
</div>