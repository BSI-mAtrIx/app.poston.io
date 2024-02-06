<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/charts/chart.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/owl.carousel.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/charts/apexcharts.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/charts/apexcharts.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/swiper.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php

// second item section [last 7 days subscribers]
$current_date = date("Y-m-d");
$last_seven_day = date("Y-m-d", strtotime("$current_date - 7 days"));
$where = array(
    'where' => array(
        // 'user_id' => $user_id,
        'completed_at >=' => $last_seven_day . ' 00:00:00'
    )
);
$default_value = '0';
if ($this->session->userdata('user_type') != 'Admin') $default_value = '0';
if ($default_value == '0') {
    $user_id = $this->user_id;
    $data['other_dashboard'] = '0';
} else {
    $user_id = $default_value;
    if ($default_value == 'system')
        $data['system_dashboard'] = 'yes';
    else {
        $user_info = $this->basic->get_data('users', array('where' => array('id' => $user_id)));
        $data['user_name'] = isset($user_info[0]['name']) ? $user_info[0]['name'] : '';
        $data['user_email'] = isset($user_info[0]['email']) ? $user_info[0]['email'] : '';
        $data['system_dashboard'] = 'no';
    }
    $data['other_dashboard'] = '1';
}
if ($default_value != 'system') $where['where']['user_id'] = $user_id;

$select = array('sum(successfully_sent) as total_message_sent');
$seven_days_subscriber_info = $this->basic->get_data('messenger_bot_broadcast_serial', $where, $select, '', '', '', 'date_format(completed_at,"%Y-%m-%d") asc', 'date_format(completed_at,"%Y-%m-%d")');
$seven_days_messages_chart_label = array();
$seven_days_messages_chart_data = array();
$seven_days_messages_gain = 0;
if (!empty($seven_days_subscriber_info)) {
    foreach ($seven_days_subscriber_info as $value) {
        if (empty($value['completed_at'])) {
            continue;
        }
        array_push($seven_days_messages_chart_label, date("jS M y", strtotime($value['completed_at'])));
        array_push($seven_days_messages_chart_data, $value['subscribers']);
        $seven_days_subscriber_gain = $seven_days_messages_gain + $value['subscribers'];
    }
}

if (isset($_GET['n_demo'])) {
    $seven_days_messages_chart_label = $seven_days_subscriber_chart_label;
    $seven_days_messages_chart_data = $seven_days_subscriber_chart_data;
}
?>
<script type="text/javascript">
    $(document).on('click', '.no_action', function (event) {
        event.preventDefault();
    });

    $(document).ready(function () {
        <?php if($n_config['theme_appeareance_on'] == 'true'){ ?>

        var $primary = '<?php echo $n_config['primary_color'];?>',
            $success = '<?php echo $n_config['success_color'];?>',
            $danger = '<?php echo $n_config['danger_color'];?>',
            $warning = '<?php echo $n_config['warning_color'];?>',
            $info = '#00CFDD',
            $label_color_light = '#E6EAEE';
        ;
        var $label_color = '#475f7b';
        var $primary_light = '<?php echo $n_config['light_primary_color'];?>';
        var $danger_light = '#ffeed9';
        var $gray_light = '#828D99';
        var $sub_label_color = "#596778";
        var $radial_bg = "#e7edf3";

        <?php }else{ ?>

        var $primary = '#5A8DEE',
            $success = '#39DA8A',
            $danger = '#FF5B5C',
            $warning = '#FDAC41',
            $info = '#00CFDD',
            $label_color_light = '#E6EAEE';
        var $label_color = '#475f7b';
        var $primary_light = '#E2ECFF';
        var $danger_light = '#ffeed9';
        var $gray_light = '#828D99';
        var $sub_label_color = "#596778";
        var $radial_bg = "#e7edf3";

        <?php } ?>




        var themeColors = [$primary, $warning, $danger, $success, $info, $sub_label_color];

        var font = '<?php if ($rtl_on) {
            echo $n_config['body_font_rtl'];
        } else {
            echo $n_config['body_font'];
        }?>';


        var sub_uns_area_options = {
            series: [{
                name: '<?php echo $this->lang->line('Un-Subscribed'); ?>',
                data: <?php echo json_encode(array_values($uns_data_checking)); ?>,
                type: 'area',
            }, {
                name: '<?php echo $this->lang->line('Subscribed'); ?>',
                data: <?php echo json_encode(array_values($sub_data_checking));?>,
                type: 'area',
            }],
            colors: [$danger, $primary],
            chart: {
                type: 'area',
                height: 280,
                stacked: false,
                sparkline: {
                    enabled: true
                },
                toolbar: {
                    show: true,
                },
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth',
                width: 2.5,
                dashArray: [0, 8]
            },
            xaxis: {
                type: 'string',
                offsetY: -50,
                fontFamily: font,
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: true,
                    style: {
                        fontFamily: font,
                        colors: $sub_label_color
                    }
                }
            },
            yaxis: {
                tickAmount: 4,
                floating: false,
                labels: {
                    style: {
                        fontFamily: font,
                        colors: $sub_label_color,
                    },
                    offsetY: -7,
                    offsetX: 0,
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    gradientToColors: [$danger, $primary],
                    opacityFrom: 0.7,
                    opacityTo: 0.55,
                    stops: [0, 80, 100]
                }
            },
            legend: {
                offsetY: 0
            },
            tooltip: {
                x: {
                    format: "yyyy",
                },
                fixed: {
                    enabled: false,
                    position: 'topRight'
                }
            },

        };

        var sub_uns_area = new ApexCharts(
            document.querySelector("#sub_uns_area"),
            sub_uns_area_options
        );
        sub_uns_area.render();


        var lineAreaOptions = {
            chart: {
                height: 350,
                type: 'area',
                stacked: false,
                sparkline: {
                    enabled: true
                },
                toolbar: {
                    show: true,
                },
            },
            colors: themeColors,
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth',
                width: 2.5,
                dashArray: [0, 8]
            },
            fill: {
                type: 'gradient',
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    gradientToColors: themeColors,
                    opacityFrom: 0.7,
                    opacityTo: 0.55,
                    stops: [0, 80, 100]
                }
            },
            series: [{
                name: '<?php echo $this->lang->line('Male'); ?>',
                data: <?php echo json_encode(array_values($male_subscribers));?>,
                type: 'area',
                fontFamily: font,
            }, {
                name: '<?php echo $this->lang->line('Female'); ?>',
                data: <?php echo json_encode(array_values($female_subscribers));?>,
                type: 'area',
                fontFamily: font,
            }],
            legend: {
                offsetY: -10
            },
            xaxis: {
                offsetY: -50,
                categories: <?php echo json_encode(array_values($male_female_date_list));?>,
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: true,
                    style: {
                        fontFamily: font,
                        colors: $sub_label_color
                    }
                }
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy'
                },
            }
        }
        var lineAreaChart = new ApexCharts(
            document.querySelector("#male_vs_female_chart"),
            lineAreaOptions
        );
        lineAreaChart.render();

        // seven_days_subscriber_chart
        // -----------------------------
        var primaryLineChartOption = {
            chart: {
                height: 80,
                // width: 180,
                type: 'area',
                toolbar: {
                    show: false
                },
                sparkline: {
                    enabled: true,
                },
            },
            grid: {
                show: false,

            },
            colors: [$primary],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            series: [{
                name: "",
                data: <?php echo json_encode(array_values($seven_days_subscriber_chart_data));?>
            }],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: "horizontal",
                    gradientToColors: [$primary],
                    opacityFrom: 0,
                    opacityTo: 0.9,
                    stops: [0, 30, 70, 100]
                }
            },
            tooltip: {
                y: {
                    title: {
                        formatter: '',
                    },
                },
                fixed: {
                    enabled: true,
                    position: 'topCenter',
                    offsetX: 0,
                    offsetY: 50,
                },
            },
            xaxis: {
                show: false,
                labels: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
                type: 'category',
                categories: <?php echo json_encode(array_values($seven_days_subscriber_chart_label));?>,
            },
            yaxis: {
                show: false
            },

        }

        var primaryLineChart = new ApexCharts(
            document.querySelector("#seven_days_subscriber_chart"),
            primaryLineChartOption
        );
        primaryLineChart.render();

        // hourly_subscriber_chart
        // -----------------------------
        var primaryLineChartOption = {
            chart: {
                height: 80,
                // width: 180,
                type: 'area',
                toolbar: {
                    show: false
                },
                sparkline: {
                    enabled: true,
                },
            },
            grid: {
                show: false,
            },
            colors: [$primary],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: "horizontal",
                    gradientToColors: [$primary],
                    opacityFrom: 0,
                    opacityTo: 0.9,
                    stops: [0, 30, 70, 100]
                }
            },
            series: [{
                name: "",
                data: <?php echo json_encode(array_values($hourly_subscriber_chart_data));?>
            }],
            tooltip: {
                y: {
                    title: {
                        formatter: '',
                    },
                },
                fixed: {
                    enabled: true,
                    position: 'topCenter',
                    offsetX: 0,
                    offsetY: 50,
                },
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: "horizontal",
                    gradientToColors: [$primary],
                    opacityFrom: 0,
                    opacityTo: 0.9,
                    stops: [0, 30, 70, 100]
                }
            },
            xaxis: {
                show: false,
                labels: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
                type: 'category',
                categories: <?php echo json_encode(array_values($hourly_subscriber_chart_label));?>,
            },
            yaxis: {
                show: false
            },
        }

        var primaryLineChart = new ApexCharts(
            document.querySelector("#hourly_subscriber_chart"),
            primaryLineChartOption
        );
        primaryLineChart.render();

        // hourly_subscriber_chart
        // -----------------------------
        var primaryLineChartOption = {
            chart: {
                height: 80,
                // width: 180,
                type: 'area',
                toolbar: {
                    show: false
                },
                sparkline: {
                    enabled: true,
                },
            },
            grid: {
                show: false,
            },
            colors: [$primary],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: "horizontal",
                    gradientToColors: [$primary],
                    opacityFrom: 0,
                    opacityTo: 0.9,
                    stops: [0, 30, 70, 100]
                }
            },
            series: [{
                name: "",
                data: <?php echo json_encode(array_values($seven_days_messages_chart_data));?>
            }],
            tooltip: {
                y: {
                    title: {
                        formatter: '',
                    },
                },
                fixed: {
                    enabled: true,
                    position: 'topCenter',
                    offsetX: 0,
                    offsetY: 50,
                },
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: "horizontal",
                    gradientToColors: [$primary],
                    opacityFrom: 0,
                    opacityTo: 0.9,
                    stops: [0, 30, 70, 100]
                }
            },
            xaxis: {
                show: false,
                labels: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
                type: 'category',
                categories: <?php echo json_encode(array_values($seven_days_messages_chart_label));?>,
            },
            yaxis: {
                show: false
            },
        }

        var primaryLineChart = new ApexCharts(
            document.querySelector("#seven_days_messages_chart"),
            primaryLineChartOption
        );
        primaryLineChart.render();

        donut_render('#donut-email', <?php echo number_format($combined_info['email']['male']); ?>, <?php echo number_format($combined_info['email']['female'], 0, '.', '');
            ?>);
        donut_render('#donut-phone', <?php echo number_format($combined_info['phone']['male']); ?>, <?php echo number_format($combined_info['phone']['female'], 0, '.', '');
            ?>);
        donut_render('#donut-birthdate', <?php echo number_format($combined_info['birthdate']['male']); ?>, <?php echo number_format($combined_info['birthdate']['female'], 0, '.', '');
            ?>);

        $(document).on('click', '.period_change', function (e) {
            e.preventDefault();
            $(".period_change").removeClass('active');
            $(this).addClass('active');
            var period = $(this).attr('period');
            var selected_period = $(this).html();
            $("#selected_period").html(selected_period);

            $("#period_change_content").hide();
            $("#period_loader").removeClass('hidden');
            var system_dashboard = "<?php echo $has_system_dashboard; ?>";
            if (system_dashboard == 'yes')
                var url = "<?php echo base_url('dashboard/get_subscriber_data_div/')?>" + system_dashboard;
            else
                var url = "<?php echo base_url('dashboard/get_subscriber_data_div')?>";

            $.ajax({
                type: 'POST',
                url: url,
                data: {period: period},
                dataType: 'JSON',
                success: function (response) {
                    $("#period_loader").addClass('hidden');

                    $("#total_email_gain").html(response.email.total_email_gain);
                    //$("#email_male_percentage").css('width',response.email.male_percentage);
                    $("#email_male_number").html(response.email.male);
                    //$("#email_female_percentage").css('width',response.email.female_percentage);
                    $("#email_female_number").html(response.email.female);

                    $('#donut-email').html('');
                    donut_render('#donut-email', response.email.male, response.email.female);


                    $("#total_phone_gain").html(response.phone.total_phone_gain);
                    //$("#phone_male_percentage").css('width',response.phone.male_percentage);
                    $("#phone_male_number").html(response.phone.male);
                    // $("#phone_female_percentage").css('width',response.phone.female_percentage);
                    $("#phone_female_number").html(response.phone.female);

                    $('#donut-phone').html('');
                    donut_render('#donut-phone', response.phone.male, response.phone.female);

                    $("#total_birthdate_gain").html(response.birthdate.total_birthdate_gain);
                    // $("#birthdate_male_percentage").css('width',response.birthdate.male_percentage);
                    $("#birthdate_male_number").html(response.birthdate.male);
                    // $("#birthdate_female_percentage").css('width',response.birthdate.female_percentage);
                    $("#birthdate_female_number").html(response.birthdate.female);

                    $('#donut-birthdate').html('');
                    donut_render('#donut-birthdate', response.birthdate.male, response.birthdate.female);


                    $("#period_change_content").show();
                }
            });

        });

        function donut_render(selector, male, female) {
            var donutSuccessChartOption = {
                chart: {
                    width: 100,
                    type: 'donut'
                },
                dataLabels: {
                    enabled: false,
                    style: {
                        fontWeight: 'bold',
                        colors: ['#000'],
                    },
                },
                series: [parseInt(male), parseInt(female)],
                labels: ["<?php echo $this->lang->line('Male'); ?>", "<?php echo $this->lang->line('Female'); ?>"],
                stroke: {
                    width: 2
                },
                colors: themeColors,
                plotOptions: {
                    pie: {

                        donut: {
                            size: '60%',
                        },
                    }
                },
                legend: {
                    show: false
                }
            }
            var donutSuccessChart = new ApexCharts(
                document.querySelector(selector),
                donutSuccessChartOption
            );
            donutSuccessChart.render();


        }

        if ($(".n_subs .card-body").length > 0) {
            var widget_earnings = new PerfectScrollbar(".n_subs .card-body");
        }

        $(document).on('click', '#subsdiff_donut', function (e) {
            $('.substat .radialbar').hide();
            $('.substat .donut').show();
            $('#subsdiff_rad').removeClass('btn-light-primary');
            $('#subsdiff_rad').addClass('btn-primary');

            $('#subsdiff_donut').removeClass('btn-primary');
            $('#subsdiff_donut').addClass('btn-light-primary');

        });

        $(document).on('click', '#subsdiff_rad', function (e) {
            $('.substat .radialbar').show();
            $('.substat .donut').hide();
            $('#subsdiff_rad').addClass('btn-light-primary');
            $('#subsdiff_rad').removeClass('btn-primary');
            $('#subsdiff_donut').addClass('btn-primary');
            $('#subsdiff_donut').removeClass('btn-light-primary');
        });


        var s_vals = [<?php echo isset($refferer_source_info['checkbox_plugin']['subscribers']) ? number_format($refferer_source_info['checkbox_plugin']['subscribers'], 0, '.', '') : 0 ?>,
            <?php echo isset($refferer_source_info['sent_to_messenger']['subscribers']) ? number_format($refferer_source_info['sent_to_messenger']['subscribers'], 0, '.', '') : 0 ?>,
            <?php echo isset($refferer_source_info['customer_chat_plugin']['subscribers']) ? number_format($refferer_source_info['customer_chat_plugin']['subscribers'], 0, '.', '') : 0 ?>,
            <?php echo isset($refferer_source_info['direct']['subscribers']) ? number_format($refferer_source_info['direct']['subscribers'], 0, '.', '') : 0 ?>,
            <?php echo isset($refferer_source_info['comment_private_reply']['subscribers']) ? number_format($refferer_source_info['comment_private_reply']['subscribers'], 0, '.', '') : 0 ?>,
            <?php echo isset($refferer_source_info['me_link']['subscribers']) ? number_format($refferer_source_info['me_link']['subscribers'], 0, '.', '') : 0 ?>];
        var s_total = s_vals.reduce(function (a, b) {
            return parseInt(a) + parseInt(b)
        }, 0);
        var s_percs = s_vals.slice(0);

        s_percs.forEach(function (val, idx, arr) {
            s_percs[idx] = 100 / (s_total / val);
        });


        var radialSubsDifferentOptions = {
            chart: {
                height: 280,
                type: 'radialBar',
                style: {
                    fontFamily: font
                }
            },
            colors: themeColors,
            plotOptions: {
                radialBar: {
                    track: {
                        strokeWidth: '97%',
                        opacity: 1,
                        margin: 3,
                    },
                    dataLabels: {
                        name: {
                            fontSize: '22px',
                            fontFamily: font,
                            offsetY: 0,
                        },
                        value: {
                            fontFamily: font,
                            color: $label_color,
                            fontSize: '16px',
                            offsetY: 0,
                            formatter: function (val) {
                                return s_vals[s_percs.findIndex(function (v) {
                                    return v == val;
                                })];
                            }
                        },
                        total: {
                            show: true,
                            color: $gray_light,
                            fontFamily: font,
                            label: '<?php echo $this->lang->line("Total"); ?>',
                            // color: $label_color,
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce(function (a, b) {
                                    return s_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                                }, 0)
                            }
                        }
                    }
                }
            },
            series: s_percs,
            labels: [
                "<?php echo $refferer_source_info['checkbox_plugin']['title']; ?>",
                "<?php echo $refferer_source_info['sent_to_messenger']['title']; ?>",
                "<?php echo $refferer_source_info['customer_chat_plugin']['title']; ?>",
                "<?php echo $refferer_source_info['direct']['title']; ?>",
                "<?php echo $refferer_source_info['comment_private_reply']['title']; ?>",
                "<?php echo $refferer_source_info['me_link']['title']; ?>",
            ],
        }
        var radialSubsDifferent = new ApexCharts(
            document.querySelector(".subscribers_source_radialbar"),
            radialSubsDifferentOptions
        );
        radialSubsDifferent.render();


        var donutSubsDifferentOptions = {
            chart: {
                width: 280,
                type: 'donut'
            },
            dataLabels: {
                enabled: false,
                style: {
                    fontWeight: 'bold',
                    colors: ['#000'],
                },
            },
            series: [
                <?php echo isset($refferer_source_info['checkbox_plugin']['subscribers']) ? number_format($refferer_source_info['checkbox_plugin']['subscribers'], 0, '.', '') : 0 ?>,
                <?php echo isset($refferer_source_info['sent_to_messenger']['subscribers']) ? number_format($refferer_source_info['sent_to_messenger']['subscribers'], 0, '.', '') : 0 ?>,
                <?php echo isset($refferer_source_info['customer_chat_plugin']['subscribers']) ? number_format($refferer_source_info['customer_chat_plugin']['subscribers'], 0, '.', '') : 0 ?>,
                <?php echo isset($refferer_source_info['direct']['subscribers']) ? number_format($refferer_source_info['direct']['subscribers'], 0, '.', '') : 0 ?>,
                <?php echo isset($refferer_source_info['comment_private_reply']['subscribers']) ? number_format($refferer_source_info['comment_private_reply']['subscribers'], 0, '.', '') : 0 ?>,
                <?php echo isset($refferer_source_info['me_link']['subscribers']) ? number_format($refferer_source_info['me_link']['subscribers'], 0, '.', '') : 0 ?>
            ],
            labels: [
                "<?php echo $refferer_source_info['checkbox_plugin']['title']; ?>",
                "<?php echo $refferer_source_info['sent_to_messenger']['title']; ?>",
                "<?php echo $refferer_source_info['customer_chat_plugin']['title']; ?>",
                "<?php echo $refferer_source_info['direct']['title']; ?>",
                "<?php echo $refferer_source_info['comment_private_reply']['title']; ?>",
                "<?php echo $refferer_source_info['me_link']['title']; ?>",
            ],
            stroke: {
                width: 2
            },
            colors: themeColors,
            plotOptions: {
                pie: {
                    donut: {
                        size: '85%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '15px',
                                colors: $sub_label_color,
                                offsetY: 20,
                                fontFamily: font,
                            },
                            value: {
                                show: true,
                                fontSize: '26px',
                                fontFamily: font,
                                color: $label_color,
                                offsetY: -20,
                                formatter: function (val) {
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                label: '<?php echo $this->lang->line("Impression"); ?>',
                                fontFamily: font,
                                color: $gray_light,
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce(function (a, b) {
                                        return a + b
                                    }, 0)
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                show: false
            }
        }
        var donutSuccessChart = new ApexCharts(
            document.querySelector('.subscribers_source_chart'),
            donutSubsDifferentOptions
        );
        donutSuccessChart.render();


    });
</script>

<script type="text/javascript">


    $("#products-carousel").owlCarousel({
        items: 3,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        loop: true,
        responsive: {
            0: {
                items: 2
            },
            768: {
                items: 2
            },
            1200: {
                items: 3
            }
        }
    });

    $("#carousel_24h").owlCarousel({
        items: 3,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        loop: true,
        responsive: {
            0: {
                items: 2
            },
            768: {
                items: 2
            },
            1200: {
                items: 3
            }
        }
    });


</script>


<script>
    $(document).ready(function () {

        $(document).on('click', '.month_change', function (e) {
            e.preventDefault();
            $(".month_change").removeClass('active');
            $(this).addClass('active');
            var month_no = $(this).attr('month_no');
            var month_name = $(this).html();
            $("#orders-month").html(month_name);

            $(".month_change_middle_content").hide();
            $("#loader").removeClass('hidden');
            var_dump($has_system_dashboard);
            var system_dashboard = "<?php echo $has_system_dashboard; ?>";
            if (system_dashboard == 'yes')
                var url = "<?php echo base_url('dashboard/get_first_div_content/')?>" + system_dashboard;
            else
                var url = "<?php echo base_url('dashboard/get_first_div_content')?>";

            $.ajax({
                type: 'POST',
                url: url,
                data: {month_no: month_no},
                dataType: 'JSON',
                success: function (response) {
                    $("#loader").addClass('hidden');
                    $("#subscribed").html(response.subscribed);
                    $("#unsubscribed").html(response.unsubscribed);
                    $("#total_subscribers").html(response.total_subscribers);
                    $("#message_sent").html(response.total_message_sent);
                    $(".month_change_middle_content").show();
                }
            });
        });


    });
</script>

<?php
if ($n_config['start_modal_show'] == 'true' or ($n_config['start_modal_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) {
    ?>
    <script type="text/javascript">
        var show_always_welcome = true;
        var filemtime_modal = 1;
        var filemtime_modal_storage = 0;

        <?php if($n_config['start_modal_always_show'] == 'false'){ ?>
        var start_modal_hide = localStorage.getItem("start_modal_hide");
        var filemtime_modal_storage = localStorage.getItem("filemtime_modal_storage");
        var filemtime_modal = <?php if ($import_modal == false) {
            echo 1;
        } else {
            echo filemtime($import_modal);
        } ?>;

        if (start_modal_hide != null) {
            show_always_welcome = false;
        }

        if (filemtime_modal_storage == null) {
            filemtime_modal_storage = 0;
        }

        $(document).on('click', '#start_modal_hide', function (e) {
            localStorage.setItem("start_modal_hide", 'false');
            localStorage.setItem("filemtime_modal_storage", filemtime_modal);
        });
        <?php } ?>

        if (filemtime_modal_storage < filemtime_modal) {
            $(window).on('load', function () {
                $('#start_modal_show').modal('show');
            });
        }
    </script>
    <?php
}

if (file_exists(APPPATH . 'views/dashboard/inc_dashboard.php')) {
    include(APPPATH . 'n_views/dashboard/user_guide_js.php');
}
?>