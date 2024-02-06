<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 0;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 1;
$include_chartjs = 1;
?>

<link href="<?php echo base_url(); ?>assets/fb/facebook.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet">
<style>
    .n_igstats ul {
        list-style: none !important;
    }

    .morris-hover {
        position: absolute;
        z-index: 1000;
    }

    .morris-hover.morris-default-style {
        border-radius: 10px;
        padding: 6px;
        color: #666;
        background: rgba(255, 255, 255, 0.8);
        border: solid 2px rgba(230, 230, 230, 0.8);
        font-family: sans-serif;
        font-size: 12px;
        text-align: center;
    }

    .morris-hover.morris-default-style .morris-hover-row-label {
        font-weight: bold;
        margin: 0.25em 0;
    }

    .morris-hover.morris-default-style .morris-hover-point {
        white-space: nowrap;
        margin: 0.1em 0;
    }
</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line('Statistics account') . ': ';
                echo $pageinfo[0]['insta_username']; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("n_igstats/"); ?>"><?php echo $this->lang->line("statistics"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line('Statistics account'); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body n_igstats">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="well well_border_left">
                    <h4 class="text-center"><i
                                class="bx bxl-instagram"></i> <?php echo $this->lang->line("analytics"); ?> : <a
                                href="https://www.instagram.com/<?php echo $pageinfo[0]['insta_username']; ?>"
                                target="_blank"><?php echo $pageinfo[0]['insta_username']; ?></a></h4>
                </div>
                <div class="container-fluid">

                    <div class="row">
                        <div class="text-center col-xs-12 col-md-3 hidden-xs hidden-sm">
                            <img src="<?php echo $pageinfo[0]['page_profile']; ?>" style="height:165px;"
                                 class="img-thumbnail">
                        </div>
                        <div class="col-xs-12 col-md-9">
                            <ul class="todo-list ui-sortable">
                                <li>
                  <span class="handle ui-sortable-handle">
                    <i class="bx bx-user blue"></i>
                  </span>
                                    <span class=""><a
                                                href="https://www.instagram.com/<?php echo $pageinfo[0]['insta_username']; ?>"
                                                target="_blank"><?php echo $pageinfo[0]['insta_username']; ?></a></span>
                                </li>
                                <li>
                  <span class="handle ui-sortable-handle">
                    <i class="bx bx-globe blue"></i>
                  </span>
                                    <span class=""><b><?php echo $this->lang->line("Website"); ?></b> : <a
                                                href="<?php echo $pageinfo[0]['insta_website']; ?>"
                                                target="_blank"><?php echo $pageinfo[0]['insta_website']; ?></a></span>
                                </li>
                                <li>
                  <span class="handle ui-sortable-handle">
                    <i class="bx bx-right-top-arrow-circle blue"></i>
                  </span>
                                    <span class=""><b><?php echo $pageinfo[0]['insta_followers_count']; ?></b> <?php echo $this->lang->line("Followers"); ?>
                </span></li>
                                <li>
                  <span class="handle ui-sortable-handle">
                    <i class="bx bx-camera blue"></i>
                  </span>
                                    <span class=""><b><?php echo $pageinfo[0]['insta_media_count']; ?></b> <?php echo $this->lang->line("Media"); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row" style="padding-top:10px;">
                        <div class="col-xs-12 col-md-6" style="padding-top:20px;">
                            <!-- AREA CHART -->
                            <div class="card box-primary">

                                <div class="box-header with-border">

                                    <h3 class="box-title" style=" word-spacing: 4px;"><i
                                                class="bx bx-hand-up"></i> <?php echo $this->lang->line("Click"); ?>
                                    </h3>


                                </div>

                                <div class="box-body">

                                    <div class="text-center"><?php echo $clicks_type_data_description; ?></div>

                                    <textarea class="hidden" id="clicks_type_data" cols="30"
                                              rows="10"><?php echo $clicks_type_data; ?></textarea>
                                    <div class="chart">
                                        <div class="chart" id="clicks_line_chart" style="height: 300px;"></div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                        <div class="col-xs-12 col-md-6" style="padding-top:20px;">
                            <!-- AREA CHART -->
                            <div class="card box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title" style=" word-spacing: 4px;"><i
                                                class="bx bx-show"></i> <?php echo $this->lang->line('User Post impressions'); ?>
                                    </h3>

                                </div>

                                <div class="box-body">
                                    <div class="text-center"><?php echo $impressions_data_description; ?></div>
                                    <textarea class="hidden" id="impressions_data" cols="30"
                                              rows="10"><?php echo $impressions_data; ?></textarea>
                                    <div class="chart">
                                        <div class="chart" id="impressions_line_chart" style="height: 300px;"></div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <!-- DONUT CHART -->
                            <div class="card box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title" style=" word-spacing: 4px;"><i
                                                class="bx bx-map"></i> <?php echo $this->lang->line('audience country'); ?>
                                    </h3>


                                </div>

                                <div class="box-body chart-responsive">

                                    <div class="box-body">

                                        <div class="row">

                                            <div class="col-12">
                                                <div class="text-center"><?php echo $reach_by_user_country_description; ?></div>
                                            </div>

                                            <div class="col-xs-12 col-md-6">

                                                <textarea class="hidden" id="reach_by_user_country_data" cols="30"
                                                          rows="10"><?php echo $reach_by_user_country_data; ?></textarea>

                                                <div class="chart-responsive">

                                                    <canvas id="reach_by_country_pieChart" height="250"></canvas>

                                                </div><!-- ./chart-responsive -->

                                            </div><!-- /.col -->

                                            <div class="col-6 yscroll"
                                                 style="padding-top:5px;height:250px;overflow:auto;">

                                                <ul class="chart-legend clearfix" id="">

                                                    <?php echo str_replace('fa fa-circle', 'bx bx-radio-circle-marked', $reach_country_list); ?>

                                                </ul>

                                            </div><!-- /.col -->

                                        </div><!-- /.row -->

                                    </div><!-- /.box-body -->

                                </div><!-- /.box-body -->

                            </div><!-- /.box -->

                        </div>

                        <div class="col-xs-12 col-md-6">
                            <!-- DONUT CHART -->
                            <div class="card box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title" style=" word-spacing: 4px;"><i
                                                class="bx bxs-grid-alt"></i> <?php echo $this->lang->line('audience locale'); ?>
                                    </h3>


                                </div>

                                <div class="box-body chart-responsive">

                                    <div class="box-body">

                                        <div class="row">

                                            <div class="col-12">
                                                <div class="text-center"><?php echo $reach_by_audience_locale_description; ?></div>
                                            </div>

                                            <div class="col-xs-12 col-md-6">

                                                <textarea class="hidden" id="reach_by_audience_locale_data" cols="30"
                                                          rows="10"><?php echo $reach_by_audience_locale_data; ?></textarea>

                                                <div class="chart-responsive">

                                                    <canvas id="reach_by_audience_locale_pieChart"
                                                            height="250"></canvas>

                                                </div><!-- ./chart-responsive -->

                                            </div><!-- /.col -->

                                            <div class="col-6 yscroll"
                                                 style="padding-top:5px;height:250px;overflow:auto;">

                                                <ul class="chart-legend clearfix" id="">

                                                    <?php echo str_replace('fa fa-circle', 'bx bx-radio-circle-marked', $reach_locale_list); ?>

                                                </ul>

                                            </div><!-- /.col -->

                                        </div><!-- /.row -->

                                    </div><!-- /.box-body -->

                                </div><!-- /.box-body -->

                            </div><!-- /.box -->

                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="card box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title" style=" word-spacing: 4px;"><i
                                                class="bx bx-map-pin"></i> <?php echo $this->lang->line('User city'); ?>
                                    </h3>

                                </div>
                                <div class="box-body chart-responsive yscroll" style="height: 300px; overflow-y:auto;">
                                    <div class="text-center"><?php echo $user_city_description; ?></div>
                                    <div class="table-responsive">
                                        <?php echo $user_city_data; ?>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="card box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title" style=" word-spacing: 4px;"><i
                                                class="bx bx-female"></i> <?php echo $this->lang->line('User gender age'); ?>
                                    </h3>

                                </div>
                                <div class="box-body chart-responsive yscroll" style="overflow-y: auto;height: 300px;">
                                    <div class="text-center"><?php echo $user_gender_age_data_description; ?></div>
                                    <div class="table-responsive">
                                        <?php echo $user_gender_age_data; ?>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                        <div class="col-xs-12 col-md-6" style="padding-top:20px;">
                            <!-- AREA CHART -->
                            <div class="card box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title" style=" word-spacing: 4px;"><i
                                                class="bx bx-volume-full"></i> <?php echo $this->lang->line('Reach'); ?>
                                    </h3>

                                </div>
                                <div class="box-body">
                                    <div class="text-center"><?php echo $reach_data_description; ?></div>
                                    <textarea class="hidden" id="reach_data" cols="30"
                                              rows="10"><?php echo $reach_data; ?></textarea>
                                    <div class="chart">
                                        <div class="chart tab-pane active" id="reach_chart"
                                             style="position: relative;height: 300px;"></div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                        <div class="col-xs-12 col-md-6" style="padding-top:20px;">
                            <!-- AREA CHART -->
                            <div class="card box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title" style=" word-spacing: 4px;"><i
                                                class="bx bx-group"></i> <?php echo $this->lang->line('Follower'); ?>
                                    </h3>

                                </div>
                                <div class="box-body">
                                    <div class="text-center"><?php echo $follower_count_description; ?></div>
                                    <textarea class="hidden" id="follower_count_data" cols="30"
                                              rows="10"><?php echo $follower_count_data; ?></textarea>
                                    <div class="chart">
                                        <div class="chart tab-pane active" id="follower_count_chart"
                                             style="position: relative;height: 300px;"></div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?php
$phoneCall = $this->lang->line("Phone call");
$textMessage = $this->lang->line("Text message");
$getDirections = $this->lang->line("Get directions");
$website = $this->lang->line("website");
$impressions = $this->lang->line("Impressions");
$reach = $this->lang->line("Reach");
$follower = $this->lang->line("Follower");
$email_contacts = $this->lang->line("Email contacts");
$profile_views = $this->lang->line("profile_views");
?>


<style type="text/css">
    .well {
        border-radius: 0 !important;
        padding: 15px 10px;
        font-size: 16px;
    }

    .todo-list > li {
        background: #fff;
    }
</style>