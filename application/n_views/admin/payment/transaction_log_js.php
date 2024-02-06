<?php
$drop_menu = '<a href="javascript:;" id="payment_date_range" class="btn btn-primary float-right has-icon-left btn-icon"><i class="bx bx-calendar"></i> ' . $this->lang->line("Choose Date") . '</a><input type="hidden" id="payment_date_range_val">';
?>


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
            order: [[2, "desc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'payment/transaction_log_data',
                type: 'POST',
                data: function (d) {
                    d.payment_date_range = $('#payment_date_range_val').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 2],
                    visible: false
                },
                {
                    targets: [6, 7, 8, 9],
                    className: 'text-center'
                },
                {
                    targets: [10],
                    className: 'text-right'
                },
                {
                    targets: [0, 1, 2],
                    sortable: false
                },
                {
                    targets: [8, 9, 10],
                    "render": function (data, type, row) {
                        if(data == '0'){
                            return '';
                        }
                        if(data == '30th Nov -1'){
                            return '';
                        }
                        if(data == '1st Jan 70 01:00:00'){
                           return '';
                        }
                        return data;
                    }
                },
            ],
            footerCallback: function (row, data, start, end, display) {
                var api = this.api(), data;
                var payment_total = api
                    .column(10)
                    .data()
                    .reduce(function (a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0);
                $(api.column(10).footer()).html('<?php echo $curency_icon;?>' + payment_total);
            },
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

        $(document).on('change', '#payment_date_range_val', function (event) {
            event.preventDefault();
            table.draw();
        });

        <?php if ($n_config['n_stripe_enabled'] == 'true' AND $n_config['n_stripe_subscription_enabled'] == 'true'
        AND $has_stripe_cust_id == 1
    ) { ?>
        $(document).on('click', '#stripe_manage', function (event) {
            event.preventDefault();

            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo site_url();?>n_stripe/subscription_manage",
                dataType: 'json',
                data: {csrf_token: "<?php echo $this->session->userdata('csrf_token_session'); ?>"
                },
                success: function (response) {
                    if (response.status == 1) {
                        window.location.href = response.url;
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }
            });

        });
        <?php } ?>


        <?php if ($this->session->userdata('user_type') == 'Admin'){ ?>

        $(document).on('click', '.open_invoice_admin', function(event){
            event.preventDefault();

            $el = $(this);

            var data = {
                transaction_id: $el.attr('data-id_trans'),
                package_id: $el.attr('data-id_pack'),
                "csrf_token": "<?php echo $this->session->userdata('csrf_token_session'); ?>",
            };

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: '<?php echo base_url('price/api_admin/invoice_get_data'); ?>',
                data: data,
                success: function (response) {
                    if (response.status==1) {
                        console.log(response.message.info_msg == undefined);
                        if (response.message.info_msg == undefined) {
                            $('#invoice_details').html(response.message.invoice_details);
                            $('#pricing_details').html(response.message.pricing_details);
                            $('#transaction_id_hidden').val($el.attr('data-id_trans'));

                            empty_form_values();

                            $("#open_invoice_admin_modal").modal();
                        }else{
                            swal.fire({
                                icon: 'error',
                                title: response.message.info_msg
                            });
                        }
                    }
                }
            });
        });

        var uploaded_file = $('#uploaded-file');
        Dropzone.autoDiscover = false;
        $("#manual-payment-dropzone").dropzone({ ///invoice_upload
            url: '<?php echo base_url('price/api_admin/invoice_upload'); ?>',
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

                if (data.n_dir) {
                    $('#n_dir').val(data.n_dir);
                }

            },
            removedfile: function (file) {
                var filename = $(uploaded_file).val();
                delete_uploaded_file(filename);
            },
            sending: function(file, xhr, formData){
                formData.append('csrf_token', "<?php echo $this->session->userdata('csrf_token_session'); ?>");
                formData.append('transaction_id', $('#transaction_id_hidden').val());
            }
        });

        function delete_uploaded_file(filename) {
            if ('' !== filename) {
                $.ajax({
                    type: 'POST',
                    dataType: 'JSON',
                    data: {filename,n_dir: $('#n_dir').val() ,csrf_token: "<?php echo $this->session->userdata('csrf_token_session'); ?>", transaction_id: $('#transaction_id_hidden').val()},
                    url: '<?php echo base_url('price/api_admin/invoice_delete_file'); ?>',
                    success: function (data) {
                        $('#uploaded-file').val('');
                    }
                });
            }

            // Empties form values
            empty_form_values();
        }

        function empty_form_values() {
            $('#paid-amount').val(''),
                $('.dz-preview').remove();
            $('#additional-info').val(''),
                $('#paid-currency').prop("selectedIndex", 0);
            $('#manual-payment-dropzone').removeClass('dz-started dz-max-files-reached');

            // Clears added file
            Dropzone.forElement('#manual-payment-dropzone').removeAllFiles(true);
        }

        <?php } ?>

    });


</script>
<?php if ($this->session->userdata('user_type') == 'Admin'){ ?>

<div class="modal fade" id="open_invoice_admin_modal" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line("Invoice Details") ?></h4>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>

            </div>
            <div class="modal-body" id="open_invoice_admin_modal_body">
                <div class="row">
                    <div class="col-6">
                        <div id="invoice_details">
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="pricing_details">
                        </div>
                    </div>
                </div>



                <form>
                    <input type="hidden" id="transaction_id_hidden">
                    <input type="hidden" id="n_dir">
                    <div class="form-group">
                        <label><i class="bx bx-paperclip"></i> <?php echo $this->lang->line('Attachment'); ?> <?php echo $this->lang->line('(Max 5MB)'); ?>
                        </label>
                        <div id="manual-payment-dropzone" class="dropzone mb-1">
                            <div class="dz-default dz-message">
                                <input class="form-control" name="uploaded-file" id="uploaded-file"
                                       type="hidden">
                                <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                  style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload'); ?></span>
                            </div>
                        </div>
                        <span class="text-danger">Allowed types: pdf, doc, txt, png, jpg and zip</span>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php } ?>