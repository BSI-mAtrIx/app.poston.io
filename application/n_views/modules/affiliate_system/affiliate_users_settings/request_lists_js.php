<script>
    $(document).ready(function () {

        setTimeout(function () {
            $('#request_date_range').daterangepicker({
                locale: daterange_locale,
                ranges: {
                    '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
                    '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
                    '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            }, function (start, end) {
                $('#request_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
            });
        }, 2000);

        var base_url = "<?php echo site_url(); ?>";
        var affiliate_requests_perscroll;
        var affiliate_requests_table = $("#mytable_affiliate_request_lists").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax: {
                "url": base_url + 'affiliate_system/all_requests_data',
                "type": 'POST',
                data: function (d) {
                    d.request_date_range = $('#request_date_range_val').val();
                    d.search_request_status = $('#search_request_status').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: [0, 1, 3, 4, 5, 6, 7, 8],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 2, 3],
                    sortable: false
                }
            ],
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (affiliate_requests_perscroll) affiliate_requests_perscroll.destroy();
                    affiliate_requests_perscroll = new PerfectScrollbar('#mytable_affiliate_request_lists_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (affiliate_requests_perscroll) affiliate_requests_perscroll.destroy();
                    affiliate_requests_perscroll = new PerfectScrollbar('#mytable_affiliate_request_lists_wrapper .dataTables_scrollBody');
                }
            }
        });

        $(document).on('change', '#request_date_range_val', function (event) {
            event.preventDefault();
            affiliate_requests_table.draw();
        });

        $(document).on('change', '#search_request_status', function (event) {
            event.preventDefault();
            affiliate_requests_table.draw();
        });

        $(document).on('change', '.request_status', function (e) {
            e.preventDefault();
            var id = $(this).attr('request_id');
            var affiliate_id = $(this).attr('affiliate_id');
            var amount = $(this).attr('amount');
            var status = $(this).val();
            var somethingwentwrong = "<?php echo $this->lang->line('Something went wrong, please try once again.'); ?>";

            //todo: check this
            if (status == '2') {
                swal.fire({
                    title: "<?php echo $this->lang->line('Reason Of Cancelation'); ?>",
                    content: {
                        element: "textarea",
                        attributes: {
                            placeholder: "<?php echo $this->lang->line('Reason Of Cancelation'); ?>",
                            id: 'reason',
                            rows: '6',
                        },
                    },
                    confirmButtonText: "<?php echo $this->lang->line('Submit'); ?>",
                    cancelButtonText: "<?php echo $this->lang->line('Cancel'); ?>",
                    showCancelButton: true,
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                })
                    .then((value) => {
                        if (value.isDenied || value.isDismissed) {
                            return;
                        }
                        value = value.value
                        if (value != null) {
                            var message = document.querySelector(".swal-content__textarea").value;
                            $.ajax({
                                context: this,
                                type: 'POST',
                                url: "<?php echo base_url('affiliate_system/change_request_states')?>",
                                data: {
                                    id: id,
                                    status: status,
                                    affiliate_id: affiliate_id,
                                    amount: amount,
                                    message: message
                                },
                                success: function (response) {

                                    if (response == '1') {
                                        iziToast.success({
                                            title: '',
                                            message: '<?php echo $this->lang->line('Status has been changed Successfully.'); ?>',
                                            position: 'bottomRight'
                                        });
                                        affiliate_requests_table.draw();
                                    } else {
                                        iziToast.error({
                                            title: '',
                                            message: '<?php echo $this->lang->line('Something went wrong, please try once again.'); ?>',
                                            position: 'bottomRight'
                                        });
                                        affiliate_requests_table.draw();
                                    }


                                }
                            });
                        }
                    });
            } else {
                swal.fire({
                    title: '<?php echo $this->lang->line("Change Status"); ?>',
                    text: '<?php echo $this->lang->line("Do you want to change the status of the request?"); ?>',
                    icon: 'warning',
                    confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                    cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                    showCancelButton: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete.isConfirmed) {
                            $.ajax({
                                context: this,
                                type: 'POST',
                                url: "<?php echo base_url('affiliate_system/change_request_states')?>",
                                data: {id: id, status: status, affiliate_id: affiliate_id, amount: amount, message: ''},
                                success: function (response) {


                                    if (response == '1') {
                                        iziToast.success({
                                            title: '',
                                            message: '<?php echo $this->lang->line('Status has been changed Successfully.'); ?>',
                                            position: 'bottomRight'
                                        });
                                        affiliate_requests_table.draw();
                                    } else {
                                        iziToast.error({
                                            title: '',
                                            message: '<?php echo $this->lang->line('Something went wrong, please try once again.'); ?>',
                                            position: 'bottomRight'
                                        });
                                        affiliate_requests_table.draw();
                                    }


                                }
                            });
                        }
                    });
            }
        });

        $(document).on('click', '.delete_request', function (e) {
            e.preventDefault();
            var table_id = $(this).attr("request_id");
            var affiliate_id = $(this).attr("affiliate_id");
            var csrf_token = $(this).attr('csrf_token');

            if (typeof (csrf_token) === 'undefined') csrf_token = '';

            var mes = '<?php echo $this->lang->line("Do you really want to delete it?");?>';
            var mes2 = '<?php echo $this->lang->line("Request has been deleted successfully");?>';
            var mes3 = '<?php echo $this->lang->line("something went wrong, please try once again.");?>';
            swal.fire({
                title: "<?php echo $this->lang->line("Are you sure?");?>",
                text: mes,
                icon: "warning",
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $(this).addClass('btn-progress btn-danger').removeClass('btn-outline-danger');
                        $.ajax({
                            context: this,
                            url: base_url + "affiliate_system/delete_affiliate_request",
                            type: 'POST',
                            data: {csrf_token: csrf_token, table_id: table_id, affiliate_id: affiliate_id},
                            success: function (response) {
                                $(this).removeClass('btn-progress btn-danger').addClass('btn-outline-danger');
                                if (response == 1) {
                                    iziToast.success({title: '', message: mes2, position: 'bottomRight'});
                                } else iziToast.error({title: '', message: mes3, position: 'bottomRight'});

                                affiliate_requests_table.draw();
                            }
                        });
                    }
                });
        });

        $(document).on('click', '.method_details', function (event) {
            event.preventDefault();
            /* Act on the event */
            var method_name = $(this).attr("method_name");
            var details = $(this).attr("details");
            $("#method_name").html(method_name);
            $("#method_details").html(details);
            $("#method_details_modal").modal();
        });

    });
</script>