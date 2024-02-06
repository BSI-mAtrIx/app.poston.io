<?php $this->load->view('admin/theme/message'); ?>
<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
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
<style>
    .dropdown-toggle::after {
        content: none !important;
    }

    .dropdown-toggle::before {
        content: none !important;
    }

    .text-decoration-none {
        text-decoration: none !important;
    }

    .article.article-style-c .article-details .article-category {
        text-transform: unset;
    }

    .text-transform-none {
        text-transform: none !important
    }

    #searching {
        max-width: 30% !important;
    }

    #page_id {
        width: 150px !important;
    }

    #post_type {
        width: 110px !important;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 130px !important;
        }

        #post_type {
            max-width: 105px !important;
        }

        #searching {
            max-width: 77% !important;
        }
    }

    .media-post-title {
        line-height: 22px;
        font-weight: normal !important;
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
                                href="<?php echo base_url('gmb'); ?>"><?php echo $this->lang->line('Google My Business'); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('gmb/campaigns'); ?>"><?php echo $this->lang->line('Campaigns'); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url("gmb/create_post"); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create new post campaign"); ?>
        </a>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-md-9 col-12">
                            <div class="input-group mb-3 float-left" id="searchbox">
                                <!-- search by post type -->
                                <div class="input-group-prepend">
                                    <select class="select2 form-control" id="post_type" name="post_type">
                                        <option value=""><?php echo $this->lang->line("All Posts"); ?></option>
                                        <option value="cta_post"><?php echo $this->lang->line("CTA Post"); ?></option>
                                        <option value="event_post"><?php echo $this->lang->line("Event Post"); ?></option>
                                        <option value="offer_post"><?php echo $this->lang->line("Offer Post"); ?></option>
                                    </select>
                                </div>

                                <!-- search by page name -->
                                <div class="input-group-prepend">
                                    <select class="select2 form-control" id="location_name" name="location_name">
                                        <option value=""><?php echo $this->lang->line("Location Name"); ?></option>
                                        <?php if (count($locations)): ?>
                                            <?php foreach ($locations as $key => $value): ?>
                                                <option value="<?php echo $value['location_display_name']; ?>"><?php echo $value['location_display_name']; ?></option>
                                            <?php endforeach ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <input type="text" class="form-control" id="searching" name="searching" autofocus
                                       placeholder="<?php echo $this->lang->line('Search...'); ?>" aria-label=""
                                       aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="search_submit"
                                            title="<?php echo $this->lang->line('Search'); ?>" type="button"><i
                                                class="bx bx-search"></i> <span
                                                class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <a href="javascript:;" id="post_date_range"
                               class="btn btn-primary float-right icon-left btn-icon"><i
                                        class="bx bx-calendar"></i> <?php echo $this->lang->line("Choose Date"); ?>
                            </a><input type="hidden" id="post_date_range_val">
                        </div>
                    </div>
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Campaign ID"); ?></th>
                                <th><?php echo $this->lang->line("Campaign Name"); ?></th>
                                <th><?php echo $this->lang->line("Post Type"); ?></th>
                                <th><?php echo $this->lang->line("Post Title"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                                <th><?php echo $this->lang->line("Status"); ?></th>
                                <th><?php echo $this->lang->line("Scheduled at"); ?></th>
                                <th><?php echo $this->lang->line('Error Message'); ?></th>
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

<div class="modal fade" tabindex="-1" role="dialog" id="campaign-report-modal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="min-width:30%;">
        <div class="modal-content">
            <div class="modal-body p-0" id="report_data"></div>
            <div class="modal-footer bg-whitesmoke">
                <button class="btn btn-light float-right" data-dismiss="modal"><i
                            class="bx bx-x"></i> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>
    </div>
</div>


