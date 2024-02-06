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
<?php $this->load->view('admin/theme/message'); ?>
<style>
    .dropdown-toggle::after {
        content: none !important;
    }

    .dropdown-toggle::before {
        content: none !important;
    }

    #searching {
        max-width: 30% !important;
    }

    #page_id {
        width: 150px !important;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 130px !important;
        }

        #searching {
            max-width: 77% !important;
        }
    }
</style>
<style type="text/css">
    div.tooltip {
        top: 28px !important;
    }

    .product_nviews .bs-tooltip-top .arrow {
        bottom: 1px !important;
    }

    .dataTable .dropdown-menu {
        width: 225px !important;
        transform: translate3d(-213px, -15px, 0px) !important;
    }
</style>

<section class="section section_custom">

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-none">
                    <div class="card-body data-card p-0 pr-2 pt-2">
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <input type="hidden" name="location_id" id="location_id"
                                       value="<?php echo $location_table_id; ?>">
                            </div>
                            <div class="col-md-3 col-12 text-right">
                                <a class="btn btn-primary" href="<?php echo base_url("gmb/add_settings"); ?>">
                                    <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add settings"); ?>
                                </a>
                            </div>
                        </div>
                        <div class="table-responsive2">
                            <table class="table table-bordered" id="mytable">
                                <thead>
                                <tr>
                                    <th><?php echo $this->lang->line("#"); ?></th>
                                    <th><?php echo $this->lang->line("ID"); ?></th>
                                    <th><?php echo $this->lang->line("Star"); ?></th>
                                    <th><?php echo $this->lang->line("Action"); ?></th>
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
</section>


