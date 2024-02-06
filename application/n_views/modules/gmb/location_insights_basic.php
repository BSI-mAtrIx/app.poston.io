<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
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
$include_chartjs = 1;
$include_owlcar = 0;
$include_prism = 0;
?>
<?php $this->load->view('admin/theme/message'); ?>
<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?><?php echo $this->lang->line('for'); ?><?php echo '"' . $location_display_name . '"'; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
        <div class="float-right mt-2 mb-1">
            <form method="POST" action="<?php echo base_url("gmb/location_insights_basic/{$location_table_id}"); ?>">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="bx bx-calendar"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control datepicker" value="<?php echo $from_date; ?>" id="from_date"
                           name="from_date" style="width:115px">
                    <input type="text" class="form-control datepicker" value="<?php echo $to_date; ?>" id="to_date"
                           name="to_date" style="width:115px">
                    <input type="hidden" class="form-control" value="<?php echo $location_name; ?>"
                           name="location_name">
                    <button class="btn btn-outline-primary" style="margin-left:1px" type="submit"><i
                                class="bx bx-search"></i> <?php echo $this->lang->line("Search"); ?></button>
                </div>
            </form>
        </div>
    </div>

</div>

<div class="section-body">
    <?php if (!empty($no_data)): ?>

        <div class="card" id="nodata">
            <div class="card-body">
                <div class="empty-state">
                    <img class="img-fluid" style="height: 200px"
                         src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
                    <h2 class="mt-0"><?php echo $no_data; ?></h2>
                </div>
            </div>
        </div>

    <?php else: ?>

        <!-- starts QUERIES_DIRECT and QUERIES_INDIRECT -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Queries Direct'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the resource was shown when searching for the location directly."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="queries_direct" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Queries Indirect'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-original-title="<?php echo $this->lang->line("The number of times the resource was shown as a result of a categorical search (for example, restaurant)."); ?>"
                                    data-toggle="tooltip"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="queries_indirect" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts QUERIES_CHAIN chain and VIEWS_MAPS -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Queries Chain'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("	The number of times a resource was shown as a result of a search for the chain it belongs to, or a brand it sells. For example, Starbucks, Adidas. This is a subset of QUERIES_INDIRECT."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="queries_chain" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Views Maps'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the resource was viewed on Google Maps."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="views_maps" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts VIEWS_SEARCH and ACTIONS_WEBSITE -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Views Search'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the resource was viewed on Google Search."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="views_search" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Actions Website'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the website was clicked."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="actions_website" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts ACTIONS_PHONE and ACTIONS_DRIVING_DIRECTIONS -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Actions Phone'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the phone number was clicked."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="actions_phone" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Actions Driving Directions'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times driving directions were requested."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="actions_driving_directions" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts ACTIONS_PHONE and ACTIONS_DRIVING_DIRECTIONS -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Photos Views Merchant'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of views on media items uploaded by the merchant."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="photos_views_merchant" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Photos Views Customers'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of views on media items uploaded by customers."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="photos_views_customers" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts PHOTOS_COUNT_MERCHANT and PHOTOS_COUNT_CUSTOMERS -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Photos Count Merchant'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The total number of media items that are currently live that have been uploaded by the merchant."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="photos_count_merchant" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Photos Count Customers'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The total number of media items that are currently live that have been uploaded by customers."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="photos_count_customers" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts LOCAL_POST_VIEWS_SEARCH and LOCAL_POST_ACTIONS_CALL_TO_ACTION -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Local Post Views Search'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the local post was viewed on Google Search."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="local_post_views_search" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Local Post Actions Call To Action'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the call to action button was clicked on Google."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="local_post_actions_call_to_action" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

    <?php endif; ?>
</div>



