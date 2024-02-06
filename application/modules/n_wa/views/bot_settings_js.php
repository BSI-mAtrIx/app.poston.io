<!-- BEGIN: Page Vendor JS-->
<?php
if (defined('NVX')) {
?>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php } ?>
<!-- END: Page Vendor JS-->

<script>
    $(document).ready(function () {

        <?php require_once(APPPATH.'modules/n_wa/include/sweetalert_v1.php'); ?>

        $(document).on('click', '#bot_get_numbers', function (){
            event.preventDefault();

            if($('#bsp_access_token').val()!=''){
                bot_access_token = $('#bsp_access_token').val();
                bot_business_id = $('#bsp_bot_business_id').val();
                if($('#bsp_bot_business_id').val()==''){
                    return;
                }
                bsp_on = 1;
            }else{
                bot_access_token = $('#bot_access_token').val();
                bot_business_id = $('#bot_business_id').val();
                bsp_on = 0;
            }

            $.blockUI({
                message: '<div class="bx bx-revision bx-spin bx-md"></div>',
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

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {
                    bot_business_id: bot_business_id,
                    bot_access_token: bot_access_token,
                    bsp_on: bsp_on,
                    csrf_token: '<?php echo $this->session->userdata('csrf_token_session'); ?>'
                },
                url: '<?php echo base_url('n_wa/api/get_phone_numbers'); ?>',
                success: function (res) {
                    $.unblockUI();

                    if (res.status==0) {
                        swal.fire({
                            icon: 'error',
                            text: res.message,
                            title: '<?php echo $this->lang->line('Warning!'); ?>',
                        });
                        return;
                    }

                    if(res.type == "ok_alert") {
                        iziToast.success({title: '', message: res.message, position: 'bottomRight'});
                    }

                    if(res.status=='ok'){
                        //$("#select_bot_id_number").select2('destroy');
                        $("#select_bot_id_number").html('<option value=""selected="selected"><?php echo $this->lang->line('Select phone number'); ?></option>');
                        $("#select_bot_id_number").select2({
                            'data': res.message.data,
                            'width': '100%'
                        }).change();
                        $('#select_bot_id_number_unhide').show();
                        $('#save_bot_settings_unhide').show();
                        $('#save_bot_settings_unhide3').show();
                    }


                    return res;
                },
                error: function (xhr, status, error) {
                    // Shows error if something goes wrong
                    $.unblockUI();
                    swal.fire({
                        icon: 'error',
                        text: xhr.responseText,
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                    });
                }
            });
        });

        $(document).on('change', '#bsp_bot_business_id', function (event) {
            event.preventDefault();
            $('#bot_get_numbers').click();
        });


        $('.repeater-default').repeater({
            show: function () {
                $(this).slideDown();
            },
            hide: function (deleteElement) {
                if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                }
            }
        });

});

</script>


<script>
    <?php
    if ($this->user_id != "") {
        $facebook_config = $this->basic->get_data("facebook_rx_config", array("where" => array('status'=>'1')));
        if (isset($facebook_config[0])) {
            $n_app_id = $facebook_config[0]["api_id"];
//            $n_app_secret = $facebook_config[0]["api_secret"];
//            $n_user_access_token = $facebook_config[0]["user_access_token"];
        }
    }
    ?>



    $(document).ready(function() {
        $.ajaxSetup({ cache: true });
        $.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
            FB.init({
                appId: '<?php echo $n_app_id; ?>',
                cookie : true, // enable cookies to allow the server to access the session
                xfbml: true,
                version: 'v18.0'
            });
        });
    });


        $(document).on('click', '#launchWhatsAppSignup', function () {
            event.preventDefault();
            launchWhatsAppSignup();
        });

        // Facebook Login with JavaScript SDK
        function launchWhatsAppSignup() {
            // Conversion tracking code
            if(typeof fbq != 'undefined'){
                console.log(1);
                fbq && fbq('trackCustom', 'WhatsAppOnboardingStart', {appId: '<?php echo $n_app_id; ?>', feature: 'whatsapp_embedded_signup'});
            }


            // Launch Facebook login
            FB.login(function (response) {
                if (response.authResponse) {
                    <?php if(!empty($bsp_on_version)){ ?>
                    const accessToken = response.authResponse.code;
                    <?php }else{ ?>
                    const accessToken = response.authResponse.accessToken;
                    <?php } ?>
                    //ajax

                    $.blockUI({
                        message: '<div class="bx bx-revision bx-spin bx-md"></div>',
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
                    $.ajax({
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            accessToken: accessToken,
                            csrf_token: '<?php echo $this->session->userdata('csrf_token_session'); ?>'
                        },
                        url: '<?php echo base_url('n_wa/api/get_bsp'); ?>',
                        success: function (res) {
                            $.unblockUI();

                            if (res.status==0) {
                                swal.fire({
                                    icon: 'error',
                                    text: res.message,
                                    title: '<?php echo $this->lang->line('Warning!'); ?>',
                                });
                                return;
                            }

                            if(res.type == "ok_alert") {
                                iziToast.success({title: '', message: res.message, position: 'bottomRight'});
                            }

                            if(res.status=='ok'){
                                $("#bsp_access_token").val(accessToken);

                                //$("#select_bot_id_number").select2('destroy');
                                $("#bsp_bot_business_id").html('<option value=""selected="selected"><?php echo $this->lang->line('Select WhatsApp Business ID'); ?></option>');
                                $("#bsp_bot_business_id").select2({
                                    'data': res.message.data,
                                    'width': '100%'
                                }).change();
                                $('#bsp_bot_business_id_unhide').show();
                                $('.bot_busines_manuall').hide();
                            }


                            return res;
                        },
                        error: function (xhr, status, error) {
                            // Shows error if something goes wrong
                            $.unblockUI();
                            swal.fire({
                                icon: 'error',
                                text: xhr.responseText,
                                title: '<?php echo $this->lang->line('Error!'); ?>',
                            });
                        }
                    });

                    //Use this token to call the debug_token API and get the shared WABA's ID
                } else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, {

                <?php if(!empty($bsp_on_version)){ ?>
                config_id: '<?php echo $bsp_config_id;?>', // configuration ID goes here
                response_type: 'code',    // must be set to 'code' for System User access token
                override_default_response_type: true, // when true, any response types passed in the "response_type" will take precedence over the default types
                extras: {
                    setup: {
                        //... // Prefilled data can go here
                    }
                }
                <?php }else{ ?>
                scope: "whatsapp_business_management,business_management,whatsapp_business_messaging",
                extras: {
                    "feature": "whatsapp_embedded_signup",
                    "version": 2,
                }
                <?php } ?>


            });
        }

</script>
