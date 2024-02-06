<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/modules/chocolat/dist/css/chocolat.css?ver=<?php echo $n_config['theme_version']; ?>">
<script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>
    var base_url = "<?php echo site_url(); ?>";

    var drop_menu = '<?php echo $drop_menu;?>';
    setTimeout(function () {
        $("#mytable_filter").append(drop_menu);
        $('#payment_date_range').daterangepicker({
            locale: daterange_locale,
            ranges: {
                '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
                '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
                '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        }, function (start, end) {
            $('#payment_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
        });
    }, 2000);


    $(document).ready(function () {
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[0, "desc"]],
            pageLength: 10,
            ajax: {
                url: '<?php echo base_url('payment/transaction_log_manual_data'); ?>',
                type: 'POST',
                data: function (d) {
                    d.payment_date_range = $('#payment_date_range_val').val();
                }
            },
            language: {
                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'email'},
                {data: 'additional_info'},
                {data: 'attachment'},
                {data: 'status'},
                {data: 'actions'},
                {data: 'package'},
                {data: 'price'},
                {data: 'validity'},
                {data: 'paid_amount'},
                {data: 'created_at'},
            ],
            columnDefs: [
                {
                    // targets: [1,2],
                    // visible: false
                },
                {
                    targets: [1, 2, 4, 5, 6, 7, 8, 9, 10, 11],
                    className: 'text-center'
                },
                {
                    // targets: [10],
                    // className: 'text-right'
                },
                {
                    targets: [3, 4, 5, 6, 7, 8, 9, 10],
                    sortable: false
                },
                {
                    targets: [4, 6],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                        data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                        data = data.replaceAll('fas fa-map', 'bx bx-map');
                        data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                        data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                        data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                        data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                        data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
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
                        data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                        data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                        data = data.replaceAll('fas fa-city', 'bx bxs-city');
                        data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                        data = data.replaceAll('fas fa-at', 'bx bx-at');
                        data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                        data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                        data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                        data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                        data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                        data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                        data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                        data = data.replaceAll('far fa-hand-point-right', 'bx bxs-hand-right');
                        data = data.replaceAll('fa fa-image', 'bx bx-image');
                        data = data.replaceAll('fa fa-download', 'bx bx-download');


                        return data;
                    }
                },

            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data;
                var payment_total = api
                    .column(8)
                    .data()
                    .reduce(function (a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);

                $(api.column(8).footer()).html(parseFloat(payment_total, 2));
            },
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (perscroll) {
                        perscroll.destroy();
                    }

                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (perscroll) {
                        perscroll.destroy();
                    }

                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            }
        });

        $(document).on('change', '#payment_date_range_val', function (event) {
            event.preventDefault();
            table.draw();
        });

        // Downloads file
        $(document).on('click', '#mp-download-file', function (e) {
            e.preventDefault();

            // Makes reference
            var that = this;

            // Starts spinner
            $(that).removeClass('btn-outline-info');
            $(that).addClass('btn-info disabled btn-progress');

            // Grabs ID
            var file = $(this).data('id');

            // Requests for file
            $.ajax({
                type: 'POST',
                data: {file},
                dataType: 'JSON',
                url: '<?php echo base_url('payment/manual_payment_download_file') ?>',
                success: function (res) {
                    // Stops spinner
                    $(that).removeClass('btn-info disabled btn-progress');
                    $(that).addClass('btn-outline-info');

                    // Shows error if something goes wrong
                    if (res.error) {
                        swal.fire({
                            icon: 'error',
                            text: res.error,
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                        });
                        return;
                    }

                    // If everything goes well, requests for downloading the file
                    if (res.status && 'ok' === res.status) {
                        window.location = '<?php echo base_url('payment/manual_payment_download_file'); ?>';
                    }
                },
                error: function (xhr, status, error) {
                    // Stops spinner
                    $(that).removeClass('btn-info disabled btn-progress');
                    $(that).addClass('btn-outline-info');

                    // Shows internal errors
                    swal.fire({
                        icon: 'error',
                        text: error,
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                    });
                }
            });
        });

        <?php if ('Admin' == $this->session->userdata('user_type')): ?>
        // Approve manual transaction
        $(document).on('click', '#mp-approve-btn, #mp-reject-btn', function (e) {
            e.preventDefault();

            // Makes reference
            var that = this;

            // Gets transaction ID
            var id = $(that).data('id');
            var action_type = $(that).attr('id');

            if ('mp-reject-btn' === action_type) {
                var reject_modal = $('#manual-payment-reject-modal');

                // Sets values to rejection form's hidden fields
                $('#mp-transaction-id').val(id);
                $('#mp-action-type').val(action_type);

                // Opens up rejection modal
                $(reject_modal).modal();
                return;
            }

            // Gets classes
            var prev_btn_el = $(that).parent().prev();
            var el_classes = prev_btn_el ? prev_btn_el[0].className : '';
            var new_classes = el_classes ? el_classes.replace('-outline', '') : '';

            // Shows spinner
            $(prev_btn_el).removeClass();
            $(prev_btn_el).addClass(new_classes.concat(' disabled btn-progress'));

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {id, action_type},
                url: '<?php echo base_url('payment/manual_payment_handle_actions'); ?>',
                success: function (res) {
                    // Stops spinner
                    $(prev_btn_el).removeClass();
                    $(prev_btn_el).addClass(el_classes);

                    // Shows error if something goes wrong
                    if (res.error) {
                        swal.fire({
                            icon: 'error',
                            text: res.error,
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                        });
                        return;
                    }
                    // If everything goes well, requests for downloading the file
                    if (res.status && 'ok' === res.status) {
                        // Shows success message
                        swal.fire({
                            icon: 'success',
                            text: res.message,
                            title: '<?php echo $this->lang->line('Success!'); ?>',
                        });

                        // Reloads datatable
                        table.ajax.reload();
                    }
                },
                error: function (xhr, status, error) {
                    // Stops spinner
                    $(prev_btn_el).removeClass();
                    $(prev_btn_el).addClass(el_classes);

                    // Shows error if something goes wrong
                    swal.fire({
                        icon: 'error',
                        text: xhr.responseText,
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                    });
                }
            });
        });

        // Handles payment's approval
        $(document).on('click', '#manual-payment-reject-submit', function (e) {
            e.preventDefault();

            // Makes reference
            var that = this;

            // Starts spinner
            $(that).addClass('btn-progress disabled');

            // Gets some vars
            var id = $('#mp-transaction-id').val();
            var action_type = $('#mp-action-type').val();
            var rejected_reason = $('#rejected-reason').val();

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {id, action_type, rejected_reason},
                url: '<?php echo base_url('payment/manual_payment_handle_actions'); ?>',
                success: function (res) {
                    // Stops spinner
                    $(that).removeClass('btn-progress disabled');

                    // Shows error if something goes wrong
                    if (res.error) {
                        swal.fire({
                            icon: 'error',
                            text: res.error,
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                        });
                        return;
                    }
                    // If everything goes well, requests for downloading the file
                    if (res.status && 'ok' === res.status) {
                        // Shows success message
                        swal.fire({
                            icon: 'success',
                            text: res.message,
                            title: '<?php echo $this->lang->line('Success!'); ?>',
                        });

                        // Clears rejection msg
                        $('#rejected-reason').val('');

                        // Closes modal
                        $('#manual-payment-reject-modal').modal('toggle');

                        // Reloads datatable
                        table.ajax.reload();
                    }
                },
                error: function (xhr, status, error) {
                    // Stops spinner
                    $(that).removeClass('btn-progress disabled');

                    // Shows error if something goes wrong
                    swal.fire({
                        icon: 'error',
                        text: xhr.responseText,
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                    });
                }
            });
        });

        <?php endif; ?>

        // Handles data re-submit form's data
        $(document).on('click', '#manual-payment-resubmit', function (e) {
            e.preventDefault();

            // Makes reference
            var that = this;

            // Gets transaction ID
            var id = $(that).data('id');
            $('#mp-resubmitted-id').val(id);

            // Starts spinner
            $('#mp-spinner').addClass('d-flex');

            // Opens up modal
            $('#manual-payment-modal').modal();

            // Gets data via ajax
            $.ajax({
                method: 'POST',
                dataType: 'JSON',
                cache: false,
                data: {id},
                url: '<?php echo base_url('payment/transaction_log_manual_resubmit_data'); ?>',
                success: function (res) {

                    if (res.status && 'ok' === res.status) {
                        // Stops spinner
                        $('#mp-spinner').removeClass('d-flex');
                        $('#mp-spinner').addClass('d-none');

                        // Sets values
                        if (res.manual_payment_status
                            && 'yes' === res.manual_payment_status
                        ) {
                            $('#manual-payment-instructions').removeClass('d-none');
                        } else {
                            $('#manual-payment-instructions').addClass('d-none');
                        }

                        if (res.manual_payment_instruction) {
                            $('#payment-instructions').text(res.manual_payment_instruction);
                        }

                        $('#paid-amount').val(res.paid_amount);
                        $('#paid-currency').val(res.paid_currency);
                        $('#additional-info').val(res.additional_info);
                        $('#selected-package-id').val(res.package_id);
                    }

                    if (res.error) {
                        swal.fire({
                            icon: 'error',
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                            text: res.error,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Stops spinner
                    $('#mp-spinner').removeClass('d-flex');
                    $('#mp-spinner').addClass('d-none');

                    // Displays error
                    swal.fire({
                        icon: 'error',
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                        text: error,
                    });
                },
            });
        });

        // Uploads files
        var uploaded_file = $('#uploaded-file');
        Dropzone.autoDiscover = false;
        $("#manual-payment-dropzone").dropzone({
            url: '<?php echo base_url('payment/manual_payment_upload_file'); ?>',
            maxFilesize: 5,
            uploadMultiple: false,
            paramName: "file",
            createImageThumbnails: true,
            acceptedFiles: ".pdf,.doc,.txt,.png,.jpg,.jpeg,.zip",
            maxFiles: 1,
            addRemoveLinks: true,
            success: function (file, response) {
                var data = JSON.parse(response);

                // Shows error message
                if (data.error) {
                    swal.fire({
                        icon: 'error',
                        text: data.error,
                        title: '<?php echo $this->lang->line('Error!'); ?>'
                    });
                    return;
                }

                if (data.filename) {
                    $(uploaded_file).val(data.filename);
                }
            },
            removedfile: function (file) {
                var filename = $(uploaded_file).val();
                delete_uploaded_file(filename);
            },
        });

        // Handles form submit
        $(document).on('click', '#manual-payment-submit', function () {

            // Reference to the current el
            var that = this;

            // Shows spinner
            $(that).addClass('disabled btn-progress');

            var data = {
                paid_amount: $('#paid-amount').val(),
                paid_currency: $('#paid-currency').val(),
                package_id: $('#selected-package-id').val(),
                additional_info: $('#additional-info').val(),
                mp_resubmitted_id: $('#mp-resubmitted-id').val(),
            };

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: '<?php echo base_url('payment/manual_payment'); ?>',
                data: data,
                success: function (response) {
                    if (response.success) {
                        // Hides spinner
                        $(that).removeClass('disabled btn-progress');

                        // Empties form values
                        empty_form_values();
                        $('#selected-package-id').val('');
                        $('#mp-resubmitted-id').val('');

                        // Shows success message
                        swal.fire({
                            icon: 'success',
                            title: '<?php echo $this->lang->line('Success!'); ?>',
                            text: response.success,
                        });

                        // Refreshes datatable
                        table.ajax.reload();

                        // Hides modal
                        $('#manual-payment-modal').modal('hide');
                    }

                    // Shows error message
                    if (response.error) {
                        // Hides spinner
                        $(that).removeClass('disabled btn-progress');

                        swal.fire({
                            icon: 'error',
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                            text: response.error,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    $(that).removeClass('disabled btn-progress');
                },
            });
        });

        $('#manual-payment-modal').on('hidden.bs.modal', function (e) {
            var filename = $(uploaded_file).val();
            delete_uploaded_file(filename);
            $('#selected-package-id').val('');
        });

        function delete_uploaded_file(filename) {
            if ('' !== filename) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    data: {filename},
                    url: '<?php echo base_url('payment/manual_payment_delete_file'); ?>',
                    success: function (data) {
                        $('#uploaded-file').val('');
                    }
                });
            }

            // Empties form values
            empty_form_values();
        }

        // Empties form values
        function empty_form_values() {
            $('#paid-amount').val(''),
                $('.dz-preview').remove();
            $('#additional-info').val(''),
                $('#paid-currency').prop("selectedIndex", 0);
            $('#manual-payment-dropzone').removeClass('dz-started dz-max-files-reached');

            // Clears added file
            Dropzone.forElement('#manual-payment-dropzone').removeAllFiles(true);
        }

    });

</script>