<script src="https://checkout.razorpay.com/v1/checkout.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>
    $(document).ready(function () {

        // Fixes multiple modal issues
        $('.modal').on("hidden.bs.modal", function (e) {
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });

        var base_url = "<?php echo site_url();?>",
            payment_modal = $('#payment_modal');


        $(document).on('click', ".choose_package", function (e) {
            e.preventDefault();
            var package = $(this).attr('data-id');
            // Sets package id for manual payment
            $('#selected-package-id').val(package);
            var redirect_url = base_url + 'payment/payment_button/' + package;

            var has_reccuring = <?php echo $has_reccuring; ?>;
            if (has_reccuring) {
                swal.fire("<?php echo $this->lang->line('Subscription Message'); ?>", "<?php echo $this->lang->line('You have already a subscription enabled in paypal. If you want to use different paypal or different package, make sure to cancel your previous subscription from your paypal.');?>")
                    .then((value) => {
                        window.location.assign(redirect_url)
                    });
            } else {
                window.location.assign(redirect_url)
            }
        });
    });
</script>

<script>

    $("#annual_plan_check").on('change', function () {
        if ($(this).is(':checked')) {
            $('.annual_0').hide();
            $('.annual_1').show();
        } else {
            $('.annual_0').show();
            $('.annual_1').hide();
        }
    });

    <?php if ($display_hide == 1) {
        echo "$('#annual-hide').hide()";
    } ?>

    $('.scrollit').each(function () {
        const ps = new PerfectScrollbar($(this)[0], {
            suppressScrollX: true,
            wheelSpeed: 1,
            wheelPropagation: false,
        });
    });


</script>

<?php if ('yes' == $manual_payment): ?>
    <script>
        $(document).ready(function () {

            $(document).on('click', '#manual-payment-button', function () {
                $('#payment_modal').modal('toggle');
                $('#manual-payment-modal').modal();
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

                            // Shows success message
                            swal.fire({
                                icon: 'success',
                                title: '<?php echo $this->lang->line('Success!'); ?>',
                                text: response.success,
                            });

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
<?php endif; ?>