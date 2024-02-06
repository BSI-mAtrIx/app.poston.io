<script>

    var base_url = "<?php echo site_url(); ?>";

    $('#search_date_range').daterangepicker({
        locale: daterange_locale,
        ranges: {
            '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
            '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
            '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    }, function (start, end) {
        $('#search_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
    });

    var perscroll;
    var table1 = '';
    table1 = $("#mytable").DataTable({
        serverSide: true,
        processing: true,
        bFilter: false,
        order: [[5, "desc"]],
        pageLength: 10,
        ajax: {
            url: base_url + 'ecommerce/coupon_list_data',
            type: 'POST',
            data: function (d) {
                d.search_store_id = $('#search_store_id').val();
                d.search_value = $('#search_value').val();
                d.search_date_range = $('#search_date_range_val').val();
            }
        },
        language:
            {
                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        columnDefs: [
            {
                targets: [1, 8, 11],
                visible: false
            },
            {
                targets: [2, 3, 4, 5, 6, 7, 9, 10, 11],
                className: 'text-center'
            },
            {
                targets: [7, 10],
                sortable: false
            },
            {
                targets: [6],
                "render": function (data, type, row) {
                    data = data.replaceAll('text-success', '');
                    return data;
                }
            },
            {
                targets: [7],
                "render": function (data, type, row) {
                    data = data.replaceAll('fas fa-code', 'bx bx-code');
                    data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                    data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                    data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                    data = data.replaceAll('far fa-copy', 'bx bx-copy');
                    data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                    data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                    data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                    data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                    data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                    data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                    data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                    data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                    data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                    data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                    data = data.replaceAll('fa fa-user', 'bx bx-user');
                    data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                    data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                    data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                    data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                    data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                    data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                    data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                    data = data.replaceAll('fas fa-key', 'bx bx-key');
                    data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                    data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                    data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                    data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                    data = data.replaceAll('fa fa-send', 'bx bx-send');
                    data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                    data = data.replaceAll('fa fa-code', 'bx bx-code');
                    data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                    data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                    data = data.replaceAll('fas fa-play', 'bx bx-play');
                    data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                    data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                    data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                    data = data.replaceAll('swal(', 'swal.fire(');
                    data = data.replaceAll('rounded-circle', 'rounded-circle');
                    data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                    data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                    data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                    data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                    data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                    data = data.replaceAll('padding-10', 'p-10');
                    data = data.replaceAll('padding-left-10', 'pl-10');
                    data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                    data = data.replaceAll('data-toggle=\'tooltip\'', 'data-toggle=\'tooltip\' data-placement=\'bottom\'');
                    data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                    data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                    data = data.replaceAll('fas fa-city', 'bx bxs-city');
                    data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                    data = data.replaceAll('fas fa-at', 'bx bx-at');
                    data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                    data = data.replaceAll('100px', '150px');
                    return data;
                }
            },
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


    $("document").ready(function () {

        $(document).on('change', '#search_store_id', function (e) {
            table1.draw();
        });

        $(document).on('change', '#search_date_range_val', function (e) {
            e.preventDefault();
            table1.draw();
        });

        $(document).on('keypress', '#search_value', function (e) {
            if (e.which == 13) $("#search_action").click();
        });

        $(document).on('click', '#search_action', function (event) {
            event.preventDefault();
            table1.draw();
        });


        var Doyouwanttodeletethisrecordfromdatabase = "<?php echo $this->lang->line('Do you want to detete this record?'); ?>";
        $(document).on('click', '.delete_row', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: Doyouwanttodeletethisrecordfromdatabase,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'JSON',
                            url: "<?php echo base_url('ecommerce/delete_coupon')?>",
                            data: {table_id: table_id},
                            success: function (response) {
                                if (response.status == '1') {
                                    iziToast.success({
                                        title: '',
                                        message: response.message,
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: response.message,
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                }
                                table1.draw(false);
                            }
                        });
                    }
                });
        });


    });

</script>