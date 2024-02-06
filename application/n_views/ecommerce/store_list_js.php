<?php
if (!empty($current_store_data) && !empty($store_data)) {
    $max = (!empty($earning_chart_values)) ? max($earning_chart_values) : 0;
    $steps = $max / 5;
    if ($steps == 0) $steps = 1;

} ?>

<script>
    var $notification_sound_loop = false;
    var audio = new Audio('<?php echo base_url('n_assets/js/bell.mp3'); ?>');

    function playBell() {
        stopBell();
        audio.currentTime = 0;
        audio.play();
    }

    function stopBell() {
        audio.currentTime = 0;
        audio.pause();
    }

    audio.addEventListener('ended', function () {
        if ($notification_sound_loop == true && $('#notification_sound').attr('data-active') == 'true') {
            this.currentTime = 0;
            this.play();
        }
    }, false);


    function check_new_orders() {
        $.ajax({
            context: this,
            type: 'POST',
            url: "<?php echo site_url();?>ecommerce/latest_order_api",
            dataType: 'json',
            data: {
                csrf_token: '<?php echo $this->session->userdata('csrf_token_session'); ?>',
                store_id: $('#store_list_select').val()
            },
            success: function (response) {

                if (response.status == '0') {
                    $('#notification_sound').attr('data-active', 'false');
                    swal.fire({
                        title: '<?php echo $this->lang->line("Error"); ?>',
                        html: response.message,
                        icon: 'error'
                    });
                }

                if (response.status == '1') {
                    $('#notification_sound').attr('data-active', 'true');
                    if (parseInt(response.latest_order_id) != latest_order_id && latest_order_id != 0) {

                        if ($('#notification_sound').attr('data-active') == 'true') {
                            swal.fire('<?php echo $this->lang->line("New order"); ?>', '<?php echo $this->lang->line("You got new order"); ?>', 'success').then((value) => {
                                $notification_sound_loop = false;
                            });
                            $notification_sound_loop = true;
                        }

                        playBell();
                        alertify.success('<?php echo $this->lang->line("New order received"); ?>');
                    }
                    latest_order_id = parseInt(response.latest_order_id);

                }


            }
        });
    }

    var latest_order_id = 0;

    $(document).ready(function ($) {
        var base_url = '<?php echo base_url(); ?>';

        $(document).on('click', '#notification_sound', function (event) {
            $this = $(this);

            if ($('#notification_sound').attr('data-active') == 'false') {
                $('#notification_sound').attr('data-active', 'true');
                $this.removeClass('btn-primary');
                $this.addClass('btn-warning');

                $('#notification_sound i').addClass('bxs-bell-ring bx-tada');
                $('#notification_sound i').removeClass('bxs-bell-off');
                check_new_orders();
                return;
            }

            if ($('#notification_sound').attr('data-active') == 'true') {
                $('#notification_sound').attr('data-active', 'false');
                $this.removeClass('btn-warning');
                $this.addClass('btn-primary');

                $('#notification_sound i').addClass('bxs-bell-off');
                $('#notification_sound i').removeClass('bxs-bell-ring bx-tada');
                return;
            }


        });

        $(document).on('click', '#notification_sound_loop', function (event) {
            $this = $(this);

            if ($('#notification_sound_loop').attr('data-active') == 'false') {
                $('#notification_sound_loop').attr('data-active', 'true');
                $this.removeClass('btn-primary');
                $this.addClass('btn-warning');

                $notification_sound_loop = true;
                return;
            }

            if ($('#notification_sound_loop').attr('data-active') == 'true') {
                $('#notification_sound_loop').attr('data-active', 'false');
                $this.removeClass('btn-warning');
                $this.addClass('btn-primary');

                $notification_sound_loop = false;
                return;
            }

        });

        setInterval(function () {
            if ($('#notification_sound').attr('data-active') == 'true') {
                check_new_orders();
            }
        }, 15000);


        $(document).on('click', '.delete_campaign', function (event) {
            event.preventDefault();

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Store"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this store? Deleting store will also delete all related data like cart,purchase,settings etc."); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var base_url = '<?php echo site_url();?>';
                        $(this).addClass('btn-danger btn-progress');
                        $(this).removeClass('btn-outline-danger');
                        var that = $(this);
                        var campaign_id = $(this).attr('campaign_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>ecommerce/delete_store",
                            dataType: 'json',
                            data: {campaign_id: campaign_id},
                            success: function (response) {

                                $(that).removeClass('btn-danger btn-progress');
                                $(this).addClass('btn-outline-danger');

                                if (response.status == '1') {
                                    iziToast.success({
                                        title: '<?php echo $this->lang->line("Deleted Successfully"); ?>',
                                        message: response.message,
                                        position: 'bottomRight'
                                    });
                                    $("#search_submit").click();
                                } else
                                    iziToast.error({
                                        title: '<?php echo $this->lang->line("Error"); ?>',
                                        message: response.message,
                                        position: 'bottomRight'
                                    });
                            }
                        });
                    }
                });
        });

        $(document).on('click', '#copy_urls', function (event) {
            event.preventDefault();
            $("#copy_data_modal").modal();
        });

        $('#store_list_select').on('change', function (e) {
            var store_id = $('#store_list_select').val();
            $("#store_id").val(store_id);
            $("#search_submit").click();
        });

        var table2 = "";
        $(document).on('click', '.reminder_report', function (event) {
            event.preventDefault();
            $("#reminder_data").modal();

            setTimeout(function () {
                if (table2 == '') {
                    var perscroll2;
                    table2 = $("#mytable2").DataTable({
                        serverSide: true,
                        processing: true,
                        bFilter: true,
                        order: [[7, "desc"]],
                        pageLength: 10,
                        ajax: {
                            url: '<?php echo base_url("ecommerce/reminder_send_status_data"); ?>',
                            type: 'POST',
                            data: function (d) {
                                d.page_id = $('#hidden_page_id').val();
                            }
                        },
                        language:
                            {
                                url: '<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json');?>'
                            },
                        dom: '<"top"f>rt<"bottom"lip><"clear">',
                        columnDefs: [
                            {
                                targets: [1],
                                visible: false
                            },
                            {
                                targets: [0, 5, 6, 7, 8],
                                className: 'text-center'
                            }
                        ],
                        fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                            if (areWeUsingScroll) {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        },
                        scrollX: 'auto',
                        fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                            if (areWeUsingScroll) {
                                if (perscroll2) perscroll2.destroy();
                                perscroll2 = new PerfectScrollbar('#mytable2_wrapper .dataTables_scrollBody');
                            }
                        }
                    });
                } else table2.draw();
            }, 1000);
        });


        $(document).on('click', '.woo_error_log', function (e) {
            e.preventDefault();
            $(this).removeClass('btn-outline-primary').addClass("btn-primary").addClass('btn-progress');
            var id = $(this).attr('data-id');

            $.ajax
            ({
                type: 'POST',
                url: base_url + 'ecommerce/reminder_response',
                data: {id: id},
                context: this,
                success: function (response) {
                    $(this).addClass('btn-outline-primary').removeClass("btn-primary").removeClass('btn-progress');

                    var success_message = response;
                    var span = document.createElement("span");
                    span.innerHTML = success_message;
                    swal.fire({title: '<?php echo $this->lang->line("API Response"); ?>', html: span, icon: 'info'});
                }
            });
        });

        $(document).on('click', '.iframed', function (e) {
            e.preventDefault();
            var iframe_url = $(this).attr('href');
            var iframe_height = $(this).attr('data-height');
            $("iframe").attr('src', iframe_url).show();
            $(".hide_in_iframe").hide();
            $('.hide_row_iframed').hide();
            $("#store_date_range").hide();
            var title = " : " + $(this).attr("data-original-title");
            $("#iframe_title").html(title);
        });

        $("#products-carousel").owlCarousel({
            <?php if ($rtl_on) {
                echo 'rtl:true,';
            }  ?>
            items: 4,
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
                    items: 4
                }
            }
        });

        $('.datepicker_x').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            // minDate: today
        });

        $(".settings_menu a").click(function () {
            $(".settings_menu a").removeClass("active");
            $(this).addClass("active");
        });

        // Toggle menu

        $(document).ready(function () {
            $('body').addClass('menu-collapsed');
            $('.brand-logo').removeClass('d-none');

            $(".select2-icons").select2({
                dropdownAutoWidth: true,
                width: '100%',
                minimumResultsForSearch: Infinity,
                templateResult: iconFormat,
                templateSelection: iconFormat,
                escapeMarkup: function (es) {
                    return es;
                }
            });

            function iconFormat(icon) {
                var originalOption = icon.element;
                if (!icon.id) {
                    return icon.text;
                }
                var $icon = "<i class='" + $(icon.element).data('icon') + "'></i>" + icon.text;

                return $icon;
            }
        });


    });


</script>


<script>
    $(document).ready(function ($) {
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


        var options = {
            series: [{
                name: '<?php echo $this->lang->line('Gross sales'); ?>',
                type: 'area',
                data: [<?php echo $earn_stat['sum_pay']; ?>]
            }, {
                name: '<?php echo $this->lang->line('Net sales'); ?>',
                type: 'area',
                data: [<?php echo $earn_stat['sum_subtotal']; ?>]
            }, {
                name: '<?php echo $this->lang->line('Average this year'); ?>',
                type: 'line',
                data: [<?php echo $earn_stat['this_year_av_payment_amount']; ?>]
            }, {
                name: '<?php echo $this->lang->line('Average last year'); ?>',
                type: 'line',
                data: [<?php echo $earn_stat['last_year_av_payment_amount']; ?>]
            }],
            chart: {
                height: 400,
                type: 'line',
            },
            stroke: {
                curve: 'smooth',
                width: 2.5,
                dashArray: [0, 8]
            },
            colors: [$primary, $warning, $danger, $success, $info, $sub_label_color],
            fill: {
                opacity: [0.85, 0.25, 1, 1],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    gradientToColors: [$danger, $primary],
                    opacityFrom: 0.7,
                    opacityTo: 0.55,
                    stops: [0, 80, 100]
                },
            },
            labels: ['<?php echo $earn_stat['dates']; ?>'],
            markers: {
                size: 0
            },
            xaxis: {
                type: 'string',

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
            yaxis: [
                {
                    labels: {
                        style: {
                            fontFamily: font,
                            colors: $sub_label_color,
                        },
                        offsetY: -7,
                        offsetX: 0,
                    },
                    title: {
                        text: '<?php echo $this->lang->line('Amount'); ?>',
                    },
                },
            ],
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y) {
                        if(typeof y !== "undefined") {
                            return  "<?php echo $currency_left; ?> " + y.toFixed(0) + " <?php echo $currency_right; ?>";
                        }
                        return y;
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart_new"), options);
        chart.render();

        var subs_typeOptions = {
            chart: {
                type: 'pie',
                height: 320
            },
            colors: themeColors,
            labels: ['<?php echo $n_sub_type['labels']; ?>'],
            series: [<?php echo $n_sub_type['series']; ?>],
            legend: {
                itemMargin: {
                    horizontal: 2
                },
            },
            responsive: [{
                breakpoint: 576,
                options: {
                    chart: {
                        width: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        }
        var pieChart = new ApexCharts(
            document.querySelector("#subs_type"),
            subs_typeOptions
        );
        pieChart.render();

        var order_typeOptions = {
            chart: {
                type: 'pie',
                height: 320
            },
            colors: themeColors,
            labels: [<?php echo $n_orders_type['labels']; ?>],
            series: [<?php echo $n_orders_type['series']; ?>],
            legend: {
                itemMargin: {
                    horizontal: 2
                },
            },
            responsive: [{
                breakpoint: 576,
                options: {
                    chart: {
                        width: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        }
        var pieChart = new ApexCharts(
            document.querySelector("#order_type"),
            order_typeOptions
        );
        pieChart.render();


    });
    
</script>