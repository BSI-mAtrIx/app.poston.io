<link href="<?php echo base_url(); ?>assets/fb/facebook.css" rel="stylesheet">
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
<section class="section section_custom n_igstats">
    <div class="section-header">
        <h1><i class="fa fa-search-location"></i><?php echo $this->lang->line('Statistics account') . ': ';
            echo $pageinfo[0]['insta_username']; ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a
                        href="<?php echo base_url('n_igstats/'); ?>"><?php echo $this->lang->line('statistics'); ?></a>
            </div>
            <div class="breadcrumb-item"><?php echo $this->lang->line('Statistics account'); ?></div>
        </div>
    </div>


    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="well well_border_left">
                        <h4 class="text-center"><i
                                    class="fa fa-instagram"></i> <?php echo $this->lang->line("analytics"); ?> : <a
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
                    <i class="fa fa-user blue"></i>
                  </span>
                                        <span class=""><a
                                                    href="https://www.instagram.com/<?php echo $pageinfo[0]['insta_username']; ?>"
                                                    target="_blank"><?php echo $pageinfo[0]['insta_username']; ?></a></span>
                                    </li>
                                    <li>
                  <span class="handle ui-sortable-handle">
                    <i class="fa fa-globe blue"></i>
                  </span>
                                        <span class=""><b><?php echo $this->lang->line("Website"); ?></b> : <a
                                                    href="<?php echo $pageinfo[0]['insta_website']; ?>"
                                                    target="_blank"><?php echo $pageinfo[0]['insta_website']; ?></a></span>
                                    </li>
                                    <li>
                  <span class="handle ui-sortable-handle">
                    <i class="fa fa-arrow-circle-o-down blue"></i>
                  </span>
                                        <span class=""><b><?php echo $pageinfo[0]['insta_followers_count']; ?></b> <?php echo $this->lang->line("Followers"); ?>
                </span></li>
                                    <li>
                  <span class="handle ui-sortable-handle">
                    <i class="fa fa-camera blue"></i>
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
                                                    class="fa fa-hand-o-up"></i> <?php echo $this->lang->line("Click"); ?>
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
                                                    class="fa fa-eye"></i> <?php echo $this->lang->line('User Post impressions'); ?>
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
                                                    class="fa fa-map"></i> <?php echo $this->lang->line('audience country'); ?>
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

                                                        <?php echo $reach_country_list; ?>

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
                                                    class="fa fa-th-large"></i> <?php echo $this->lang->line('audience locale'); ?>
                                        </h3>


                                    </div>

                                    <div class="box-body chart-responsive">

                                        <div class="box-body">

                                            <div class="row">

                                                <div class="col-12">
                                                    <div class="text-center"><?php echo $reach_by_audience_locale_description; ?></div>
                                                </div>

                                                <div class="col-xs-12 col-md-6">

                                                    <textarea class="hidden" id="reach_by_audience_locale_data"
                                                              cols="30"
                                                              rows="10"><?php echo $reach_by_audience_locale_data; ?></textarea>

                                                    <div class="chart-responsive">

                                                        <canvas id="reach_by_audience_locale_pieChart"
                                                                height="250"></canvas>

                                                    </div><!-- ./chart-responsive -->

                                                </div><!-- /.col -->

                                                <div class="col-6 yscroll"
                                                     style="padding-top:5px;height:250px;overflow:auto;">

                                                    <ul class="chart-legend clearfix" id="">

                                                        <?php echo $reach_locale_list; ?>

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
                                                    class="fa fa-map-marker"></i> <?php echo $this->lang->line('User city'); ?>
                                        </h3>

                                    </div>
                                    <div class="box-body chart-responsive yscroll"
                                         style="height: 300px; overflow-y:auto;">
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
                                                    class="fa fa-female"></i> <?php echo $this->lang->line('User gender age'); ?>
                                        </h3>

                                    </div>
                                    <div class="box-body chart-responsive yscroll"
                                         style="overflow-y: auto;height: 300px;">
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
                                                    class="fa fa-bullhorn"></i> <?php echo $this->lang->line('Reach'); ?>
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
                                                    class="fa fa-group"></i> <?php echo $this->lang->line('Follower'); ?>
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
</section>

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

<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>plugins/morris/morris.min.js" type="text/javascript"></script>

<script>
    $("document").ready(function () {

        var phoneCall = "<?php echo $phoneCall; ?>";
        var textMessage = "<?php echo $textMessage; ?>";
        var getDirections = "<?php echo $getDirections; ?>";
        var website = "<?php echo $website; ?>";
        var impressions = "<?php echo $impressions; ?>";
        var reach = "<?php echo $reach; ?>";
        var follower = "<?php echo $follower; ?>";
        var email_contacts = "<?php echo $email_contacts; ?>";
        var profile_views = "<?php echo $profile_views; ?>";

        var clicks_type_data = $('#clicks_type_data').val();

        var line = new Morris.Line({
            element: 'clicks_line_chart',
            resize: true,
            data: JSON.parse(clicks_type_data),
            xkey: 'date',
            ykeys: ['phone_call', 'text_message', 'get_directions', 'website', 'email_contacts'],
            labels: [phoneCall, textMessage, getDirections, website, email_contacts],
            lineColors: ["#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092"],
            lineWidth: 1,
            hideHover: 'auto'
        });


        // LINE CHART
        var impressions_data = $('#impressions_data').val();
        var line = new Morris.Line({
            element: 'impressions_line_chart',
            resize: true,
            data: JSON.parse(impressions_data),
            xkey: 'date',
            ykeys: ['impressions'],
            labels: [impressions],
            lineColors: ["#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092"],
            lineWidth: 1,
            hideHover: 'auto'
        });


        // LINE CHART
        var reach_data = $('#reach_data').val();
        //var profile_views = 'profile_views';
        var line = new Morris.Line({
            element: 'reach_chart',
            resize: true,
            data: JSON.parse(reach_data),
            xkey: 'date',
            ykeys: ['reach', 'profile_views'],
            labels: [reach, profile_views],
            lineColors: ["#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092"],
            lineWidth: 1,
            hideHover: 'auto'
        });

        // LINE CHART
        var follower_count_data = $('#follower_count_data').val();
        var line = new Morris.Area({
            element: 'follower_count_chart',
            resize: true,
            data: JSON.parse(follower_count_data),
            xkey: 'date',
            ykeys: ['follower_count'],
            labels: [follower],
            lineColors: ["#ff004e", "#99002f", "#0090ff", "#00d8ff", "#0024ff", "#ff4e00", "#fff000", "#00ffa2", "#00064d", "#008917", "#d900d6", "#820081", "#340082", "#00fa41", "#387447", "#ff0000", "#424242", "#00b3ad", "#5400ff", "#5b4092"],
            lineWidth: 1,
            hideHover: 'auto'
        });

        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 30, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: false,

            legend: {
                display: false
            }
        };

        //-------------
        //- PIE CHART -
        //-------------
        var reach_by_user_country_data = $("#reach_by_user_country_data").val();
        var pieChartCanvas = $("#reach_by_country_pieChart").get(0).getContext("2d");
        var PieData = JSON.parse(reach_by_user_country_data);

        var labels = PieData.map(function (e) {
            return e.label;
        });
        var data = PieData.map(function (e) {
            return e.value;
        });

        var colors = PieData.map(function (e) {
            return e.color;
        });

        // You can switch between pie and douhnut using the method below.
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: colors
                }],
                labels: labels
            },
            options: pieOptions
        });


        //-----------------
        //- END PIE CHART -
        //-----------------

        //-------------
        //- PIE CHART -
        //-------------
        var reach_by_audience_locale_data = $("#reach_by_audience_locale_data").val();
        var pieChartCanvas = $("#reach_by_audience_locale_pieChart").get(0).getContext("2d");
        var PieData = JSON.parse(reach_by_audience_locale_data);
        var labels = PieData.map(function (e) {
            return e.label;
        });
        var data = PieData.map(function (e) {
            return e.value;
        });

        var colors = PieData.map(function (e) {
            return e.color;
        });

        // You can switch between pie and douhnut using the method below.
        var pieChart = new Chart(pieChartCanvas, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: data,
                    backgroundColor: colors
                }],
                labels: labels
            },
            options: pieOptions
        });


        //-----------------
        //- END PIE CHART -
        //-----------------

    });
</script>

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