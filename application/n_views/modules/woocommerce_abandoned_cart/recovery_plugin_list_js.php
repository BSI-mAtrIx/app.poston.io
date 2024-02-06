<?php
if (!empty($domain_info) && !empty($plugin_info)) {
    $max = (!empty($earning_chart_values)) ? max($earning_chart_values) : 0;
    $steps = $max / 5;
    if ($steps == 0) $steps = 1;
    ?>

    <script type="text/javascript">
        var statistics_chart = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(statistics_chart, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($earning_chart_labels); ?>,
                datasets: [{
                    label: '<?php echo $this->lang->line("Earning"); ?>',
                    data: <?php echo json_encode(array_values($earning_chart_values)); ?>,
                    borderWidth: 3,
                    borderColor: '#6777ef',
                    backgroundColor: 'transparent',
                    pointBackgroundColor: '#6777ef',
                    pointBorderColor: '#6777ef',
                    pointRadius: 3
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            stepSize: <?php echo $steps; ?>
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                            color: '#dee2e6',
                            lineWidth: 1
                        }
                    }]
                },
            }
        });
    </script>
    <?php
} ?>

<script>
    $(document).ready(function ($) {

        var areWeUsingScroll = false;
        //todo: areWeUsingScroll
        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });
        var base_url = '<?php echo base_url(); ?>';
        // datatable section started
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": base_url + 'woocommerce_abandoned_cart/recovery_plugin_list_data',
                    "type": 'POST',
                    data: function (d) {
                        d.search_page_id = $('#search_page_id').val();
                        d.search_domain_name = $('#search_domain_name').val();
                    }
                },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 5, 6],
                    visible: false
                },
                {
                    targets: [0, 1, 4, 6, 7],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 4, 8],
                    sortable: false
                }
            ],
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            }
        });


        $(document).on('click', '.delete_campaign', function (event) {
            event.preventDefault();

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Plugin"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this plugin?"); ?>',
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
                            url: "<?php echo site_url();?>woocommerce_abandoned_cart/recovery_plugin_delete",
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

        $(document).on('click', '.page_list_item', function (event) {
            event.preventDefault();
            $('.page_list_item').removeClass('active');
            $(this).addClass('active');
            var plugin_id = $(this).attr('page_table_id');
            $("#plugin_id").val(plugin_id);
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
                            url: '<?php echo base_url("woocommerce_abandoned_cart/campaign_sent_status_data"); ?>',
                            type: 'POST',
                            dataSrc: function (json) {
                               // $(".table-responsive").niceScroll();
                                return json.data;
                            },
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
                        },
                        "drawCallback": function (settings) {
                            $('table [data-toggle="tooltip"]').tooltip('dispose');
                            $('table [data-toggle="tooltip"]').tooltip(
                                {
                                    placement: 'left',
                                    container: 'body',
                                    html: true,
                                    template: '<div class="tooltip tooltip_pd" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                                }
                            );
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
                url: base_url + 'woocommerce_abandoned_cart/reminder_reponse',
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

    });

</script>

<?php
include(FCPATH . 'application/n_views/modules/woocommerce_abandoned_cart/download_code.php');
include(FCPATH . 'application/n_views/modules/woocommerce_abandoned_cart/cart_modal.php');
?>