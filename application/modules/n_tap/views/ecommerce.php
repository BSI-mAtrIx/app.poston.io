
<div class="n_modal mfp-hide" id="sadad_payment_modal">
    <div class="">
        <h4><?php echo $this->lang->line("Sadad Payment"); ?></h4>
        <div class="modal-body">
            <p><?php echo $this->lang->line("Provide required details"); ?></p>


            <div class="alert alert-warning mb-2" role="alert" id="sadad_warning" style="display: none;">
                <span></span>
            </div>


            <div id="sadad_validate">

                <div class="form-group">
                    <label for="sadad_msisdn"><?php echo $this->lang->line('Phone number'); ?>*</label>
                    <input type="text" class="form-control form-control-md" name="sadad_msisdn" id="sadad_msisdn"
                           value="" required>
                </div>

                <?php
                $n_sadad_year = '';
                foreach (range(date('Y')-100, date('Y') + 15) as $year) {
                    $n_sadad_year .= '<option>' . $year . '</option>';
                }
                ?>


                <div class="form-group">
                    <label for="sadad_birthYear"><?php echo $this->lang->line('Birhtday Year'); ?>*</label>
                    <select class="form-control select2" name="sadad_birthYear" id="sadad_birthYear" required>

                        <?php echo $n_sadad_year; ?>

                    </select>
                </div>

            </div>

            <div id="sadad_otp_field" style="display: none;">
                <div class="form-group">
                    <label for="sadad_otp"><?php echo $this->lang->line('OTP Code'); ?>*</label>
                    <input type="text" class="form-control form-control-md" name="sadad_otp" id="sadad_otp"
                           value="" required>
                </div>
                <a style="cursor: pointer; float:right;" class="mb-5" id="sadad_resend_otp"><?php echo $this->lang->line("If you not receive OTP code, click here for resend"); ?></a>

            </div>

            <div class="mt-5">
                <button class="btn btn-dark btn-block btn-rounded float-right" id="sadad_confirm"><?php echo $this->lang->line("Next step"); ?></button>
                <button class="btn btn-dark btn-block btn-rounded float-right" id="sadad_confirm_otp" style="display: none;"><?php echo $this->lang->line("Verify OTP"); ?></button>
            </div>


        </div>
    </div>

    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>

</div>

<style>
    .select2-container--open{z-index:2500;}
</style>





<script type="text/javascript">

    $(document).ready(function ($) {
        var $sadad_tid = '';
        var $sadad_rid = '';
        var $sadad_transactionId = '';
        var $sadad_amount = '';

        //$('#sadad_birthYear').select2({width:"100%"});

        $(document).on('click', '#pay_sadad', function (event) {
            event.preventDefault();

            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#sadad_payment_modal'
                },
                preloader: false,
                modal: true
            });

            $('#sadad_validate').show();
            $('#sadad_confirm').show();
            $('#sadad_warning').hide();
            $('#sadad_otp_field').hide();
            $('#sadad_confirm_otp').hide();
        });

        $(document).on('click', '#sadad_confirm', function (event) {

            $('#sadad_payment_modal').block({
                message: '<div class="w-icon-store-seo font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });

            event.preventDefault();

            var to_send = {
                "sadad_msisdn": $('#sadad_msisdn').val(),
                "sadad_birthYear": $('#sadad_birthYear').val(),
                "csrf_token": "<?php echo $this->session->userdata('csrf_token_session'); ?>"
            };

            $.ajax({
                type: 'POST',
                data: to_send,
                dataType: 'JSON',
                url: $('#pay_sadad').attr('action_n_url'),
                success: function (response) {

                    if(response.success==true){
                        $('#sadad_validate').hide();
                        $('#sadad_confirm').hide();
                        $('#sadad_warning').hide();
                        $('#sadad_otp_field').show();
                        $('#sadad_confirm_otp').show();

                        $sadad_tid = response.tid;
                        $sadad_rid = response.rid;
                        $sadad_transactionId = response.transactionId;
                        $sadad_amount = response.amount;

                    }else{
                        $('#sadad_warning span').text(response.errText);
                        $('#sadad_warning').show();
                    }

                    $('#sadad_payment_modal').unblock();
                }
            });

        });

        $(document).on('click', '#sadad_confirm_otp', function (event) {
            event.preventDefault();

            $('#sadad_payment_modal').block({
                message: '<div class="w-icon-store-seo font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var to_send = {
                "sadad_tid": $sadad_tid,
                "sadad_rid": $sadad_rid,
                "sadad_transactionId": $sadad_transactionId,
                "sadad_amount": $sadad_amount,
                "sadad_otp": $('#sadad_otp').val(),
                "csrf_token": "<?php echo $this->session->userdata('csrf_token_session'); ?>"
            };

            $.ajax({
                type: 'POST',
                data: to_send,
                dataType: 'JSON',
                url: base_url + 'n_sadad/webhook_ecommerce/',
                success: function (response) {

                    if(response.success==true){
                        window.location.href = response.redirect;
                    }else{
                        $('#sadad_warning span').text(response.errText);
                        $('#sadad_warning').show();
                        //window.location.href = response.redirect;
                    }

                    $('#sadad_payment_modal').unblock();

                }
            });

        });


        $(document).on('click', '#sadad_resend_otp', function (event) {
            event.preventDefault();

            $('#sadad_payment_modal').block({
                message: '<div class="w-icon-store-seo font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#ffffff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });


            var to_send = {
                "sadad_transactionId": $sadad_transactionId,
                "csrf_token": "<?php echo $this->session->userdata('csrf_token_session'); ?>"
            };

            $.ajax({
                type: 'POST',
                data: to_send,
                dataType: 'JSON',
                url: base_url + 'n_sadad/resend_otp/',
                success: function (response) {

                    if(response.success==true){
                        $('#sadad_warning span').text(response.errText);
                        $('#sadad_warning').show();
                    }else{
                        $('#sadad_warning span').text(response.errText);
                        $('#sadad_warning').show();
                    }

                    $('#sadad_payment_modal').unblock();

                }
            });

        });




    });

</script>



