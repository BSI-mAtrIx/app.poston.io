<script>
    $(document).ready(function ($) {

        var base_url = '<?php echo base_url(); ?>';
        var Doyouwanttodeletealltheserecordsfromdatabase = "<?php echo $this->lang->line('Do you want to detete all the records from the database?'); ?>";
        var Doyouwanttodeletethisrecordfromdatabase = "<?php echo $this->lang->line('Do you want to detete this record?'); ?>";

        setTimeout(function () {
            $('#page_date_range').daterangepicker({
                locale: daterange_locale,
                ranges: {
                    '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
                    '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
                    '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            }, function (start, end) {
                $('#page_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
            });
        }, 2000);

        var today = new Date();
        var next_date = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
        $('.datepicker_x').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today,
            maxDate: next_date
        })


        // =========================== SMS API Section started and datatable section started ========================
        var perscroll;
        var table = $("#mytable_custom_page_lists").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[2, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": base_url + 'menu_manager/page_lists_data',
                    "type": 'POST',
                    data: function (d) {
                        d.searching = $('#searching_page').val();
                        d.page_date_range = $('#page_date_range_val').val();
                    }
                },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [2],
                    visible: false
                },
                {
                    targets: [0, 1, 3, 4, 6, 7],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 3, 4, 6],
                    sortable: false
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
                        data = data.replaceAll('tooltip()', "tooltip({container : 'body'})");


                        return data;
                    }
                },
            ],
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_custom_page_lists_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_custom_page_lists_wrapper .dataTables_scrollBody');
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

        $(document).on('keyup', '#searching_page', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document).on('change', '#page_date_range_val', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document).on('click', '.delete_page', function (e) {
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
                            url: base_url + "menu_manager/delete_single_page",
                            data: {table_id: table_id},
                            success: function (response) {
                                if (response == '1') {
                                    iziToast.success({
                                        title: '',
                                        message: '<?php echo $this->lang->line('Page has been deleted successfully.'); ?>',
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: '<?php echo $this->lang->line('Something went wrong, please try once again.'); ?>',
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                }
                                table.draw();
                            }
                        });
                    }
                });
        });


        $(document).on('click', '.delete_selected_page', function (event) {
            event.preventDefault();

            var page_ids = [];
            $(".datatableCheckboxRow:checked").each(function () {
                page_ids.push(parseInt($(this).val()));
            });

            if (page_ids.length == 0) {

                swal.fire('<?php echo $this->lang->line("Warning")?>', '<?php echo $this->lang->line("You didn`t select any Page to delete.") ?>', 'warning');
                return false;

            } else {

                swal.fire({
                    title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                    text: Doyouwanttodeletealltheserecordsfromdatabase,
                    icon: 'warning',
                    confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                    cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                    showCancelButton: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {

                        if (willDelete.isConfirmed) {

                            $(this).addClass('btn-progress');
                            $.ajax({
                                context: this,
                                type: 'POST',
                                url: base_url + "menu_manager/ajax_delete_all_selected_pages",
                                data: {info: page_ids},
                                success: function (response) {
                                    $(this).removeClass('btn-progress');

                                    if (response == '1') {

                                        iziToast.success({
                                            title: '',
                                            message: '<?php echo $this->lang->line('Selected Contacts has been deleted Successfully.'); ?>',
                                            position: 'bottomRight'
                                        });

                                    } else {

                                        iziToast.error({
                                            title: '',
                                            message: '<?php echo $this->lang->line('Something went wrong, please try once again.'); ?>',
                                            position: 'bottomRight'
                                        });

                                    }

                                    table.draw();
                                }
                            });

                        }
                    });
            }

        });
    });
</script>