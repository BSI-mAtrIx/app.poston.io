<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/charts/chart.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/owl.carousel.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/charts/apexcharts.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>
    $("document").ready(function () {

        var startDate = '<?php echo $start_date; ?>';
        var endDate = '<?php echo $end_date; ?>';
        var base_url = "<?php echo site_url(); ?>";
        var csrf_token = "<?php echo $this->session->userdata('csrf_token_session'); ?>";

        function change_data(){
            var page_id = $('#bot_list_select').val();

            $.ajax({
                type: 'POST',
                url: base_url + 'n_theme/change_data_dash',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    page_id: page_id,
                    csrf_token: csrf_token
                },
                dataType: 'JSON',
                success: function (response) {
                    location.reload();
                }
            });
        }

        $('#period_stats_in').daterangepicker({
            locale: daterange_locale,
            ranges: {
                '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
                '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
                '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: startDate,
            endDate: endDate
        }, function (start, end) {
            $('#period_stats_in').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
            startDate = start.format('YYYY-M-D');
            endDate = end.format('YYYY-M-D');
            change_data();
        });

        $(document).on('change', '#bot_list_select', function (e) {
            e.preventDefault();
            change_data();
        })














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
            legend: {
                show: false
            }
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
                name: '<?php echo $this->lang->line('Subscribers'); ?>',
                data: <?php echo json_encode(array_values($stats_subscriber_gain));?>,
                type: 'area',
                fontFamily: font,
            }, {
                name: '<?php echo $this->lang->line('Emails'); ?>',
                data: <?php echo json_encode(array_values($stats_email_gain));?>,
                type: 'area',
                fontFamily: font,
            }, {
                name: '<?php echo $this->lang->line('Phone'); ?>',
                data: <?php echo json_encode(array_values($stats_phone_gain));?>,
                type: 'area',
                fontFamily: font,
            }],
            legend: {
                offsetY: -10
            },
            xaxis: {
                offsetY: -50,
                categories: <?php echo json_encode(array_values($stats_date_list));?>,
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
            document.querySelector("#stats_chart"),
            lineAreaOptions
        );
        lineAreaChart.render();






        var donutEmailsOptions = {
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
                <?php echo $pending_email_campaigns; ?>,
                <?php echo $processing_email_campaigns; ?>,
                <?php echo $stopped_email_campaigns; ?>,
                <?php echo $completed_email_campaigns; ?>


            ],
            labels: [
                "<?php echo $this->lang->line('Pending'); ?>",
                "<?php echo $this->lang->line('Processing'); ?>",
                "<?php echo $this->lang->line('Stopped'); ?>",
                "<?php echo $this->lang->line('Completed'); ?>"

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
                                label: '<?php echo $this->lang->line("Campaigns"); ?>',
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
                show: true
            }
        }
        var donutEmailsChart = new ApexCharts(
            document.querySelector('.email_cpg_chart'),
            donutEmailsOptions
        );
        donutEmailsChart.render();


        var donutSmsOptions = {
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
                <?php echo $pending_sms_campaigns; ?>,
                <?php echo $processing_sms_campaigns; ?>,
                <?php echo $stopped_sms_campaigns; ?>,
                <?php echo $completed_sms_campaigns; ?>


            ],
            labels: [
                "<?php echo $this->lang->line('Pending'); ?>",
                "<?php echo $this->lang->line('Processing'); ?>",
                "<?php echo $this->lang->line('Stopped'); ?>",
                "<?php echo $this->lang->line('Completed'); ?>"

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
                                label: '<?php echo $this->lang->line("Campaigns"); ?>',
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
                show: true
            }
        }
        var donutSmsChart = new ApexCharts(
            document.querySelector('.sms_cpg_chart'),
            donutSmsOptions
        );
        donutSmsChart.render();

        var donutPositngOptions = {
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
                <?php echo $pending_posting_campaigns; ?>,
                <?php echo $processing_posting_campaigns; ?>,
                <?php echo $completed_posting_campaigns; ?>


            ],
            labels: [
                "<?php echo $this->lang->line('Pending'); ?>",
                "<?php echo $this->lang->line('Processing'); ?>",
                "<?php echo $this->lang->line('Completed'); ?>"

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
                                label: '<?php echo $this->lang->line("Posts"); ?>',
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
                show: true
            }
        }
        var donutPostingChart = new ApexCharts(
            document.querySelector('.posting_cpg_chart'),
            donutPositngOptions
        );
        donutPostingChart.render();



    });


</script>

<?php
if ($n_config['start_modal_show'] == 'true' or ($n_config['start_modal_only_admin'] == 'true' and $this->session->userdata('user_type') == 'Admin')) {
    ?>
    <script type="text/javascript">
        var show_always_welcome = true;
        var filemtime_modal = 1;

        <?php if($n_config['start_modal_always_show'] == 'false'){ ?>
        var start_modal_hide = localStorage.getItem("start_modal_hide");
        var filemtime_modal_storage = localStorage.getItem("filemtime_modal_storage");
        var filemtime_modal = <?php if (empty($import_modal)) {
            echo 0;
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