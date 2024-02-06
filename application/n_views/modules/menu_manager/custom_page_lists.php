<label></label>
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
$include_dropzone = 0;
$include_tagsinput = 0;
?>
<style>
    .dropdown-toggle::after {
        content: none !important;
    }

    #searching_page {
        max-width: 50% !important;
    }

    #campaign_status {
        width: 110px !important;
    }

    @media (max-width: 575.98px) {
        #searching_page {
            max-width: 77% !important;
        }
    }

    div.tooltip_pd {
        top: 0px !important;
    }
</style>


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("menu_manager/index"); ?>"><?php echo $this->lang->line("Menu Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url('menu_manager/create_page'); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Page"); ?>
        </a>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="input-group float-left" id="searchbox">
                                <input type="text" class="form-control" id="searching_page" name="searching_page"
                                       autofocus placeholder="<?php echo $this->lang->line('Search...'); ?>"
                                       aria-label="" aria-describedby="basic-addon2">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="javascript:;" id="page_date_range"
                               class="btn btn-primary float-right has-icon-left btn-icon"><i
                                        class="bx bx-calendar"></i> <?php echo $this->lang->line("Choose Date"); ?>
                            </a><input type="hidden" id="page_date_range_val">
                            <a href="#" class="btn btn-danger float-right mr-2 delete_selected_page"
                               data-toggle="tooltip" title="<?php echo $this->lang->line("Delete Selected"); ?>"><i
                                        class="bx bx-trash-alt"></i> <?php echo $this->lang->line("Delete"); ?></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive2">
                                <table class="table table-bordered" id="mytable_custom_page_lists">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="vertical-align:middle;width:20px">
                                            <input class="regular-checkbox" id="datatableSelectAllRows"
                                                   type="checkbox"/>
                                            <label for="datatableSelectAllRows"></label>
                                        </th>
                                        <th><?php echo $this->lang->line("ID"); ?></th>
                                        <th><?php echo $this->lang->line("Page Name"); ?></th>
                                        <th><?php echo $this->lang->line("Slug"); ?></th>
                                        <th><?php echo $this->lang->line("URL"); ?></th>
                                        <th><?php echo $this->lang->line("Created"); ?></th>
                                        <th style="width:230px"><?php echo $this->lang->line('Actions'); ?></th>
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
    </div>
</div>



