<head>
    <title><?php echo $page_title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url('plugins/alertifyjs/css/alertify.min.css') ?>"/>
    <link rel="stylesheet" href="<?php echo base_url('plugins/alertifyjs/css/themes/default.min.css') ?>"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style type="text/css">
        @media screen {
            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 400;
                src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 700;
                src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 400;
                src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 700;
                src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
            }
        }

        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width: 600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
<!-- HIDDEN PREHEADER TEXT -->
<div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
    We're thrilled to have you here! Get ready to dive into your new account.
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <!-- LOGO -->
    <tr>
        <td bgcolor="#FFA73B" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td bgcolor="#ffffff" align="center" valign="top"
                        style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111;line-height: 48px;">
                        <?php if ($status == '0') : ?>
                            <h1 style="font-size: 48px; font-weight: 700; margin: 2;"><?php echo $this->lang->line("Welcome!"); ?></h1>
                        <?php else : ?>
                            <h1 style="font-size: 48px; font-weight: 700; margin: 2;"><?php echo $this->lang->line("Thank You"); ?></h1>
                        <?php endif; ?>
                        <img src=" https://img.icons8.com/clouds/100/000000/handshake.png" width="200" height="200"
                             style="display: block; border: 0px;"/>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr id="default_msg">
                    <td bgcolor="#ffffff" align="left"
                        style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <?php if ($status == '1') : ?>
                            <h4 class="text-center"
                                style="margin: 0;"><?php echo $this->lang->line("You already subscribed to our system."); ?></h4>
                        <?php else : ?>
                            <p style="margin: 0;"><?php echo $this->lang->line("Hey, you are almost ready to get in touch of us. simply click the below button to verify your email address."); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr id="success_block" style="display: none;">
                    <td bgcolor="#ffffff" align="left"
                        style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <h4 class="text-center text-success" style="margin: 0;"></h4>
                    </td>
                </tr>
                <tr>
                    <td id="alert_msg" bgcolor="#ffffff" align="left"
                        style="display: none;color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                        <div class="alert alert-danger text-center mr-4 ml-4"><?php echo $this->lang->line("Sorry, Requested Data Not Found.") ?></div>
                    </td>
                </tr>
                <?php if ($status == '0') : ?>
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <input type="hidden" name="user_id" id="user_id"
                                                       value="<?php echo $user_id; ?>">
                                                <input type="hidden" name="contact_id" id="contact_id"
                                                       value="<?php echo $contact_id; ?>">
                                                <input type="hidden" name="sequence_ids" id="sequence_ids"
                                                       value="<?php echo $sequence_ids; ?>">
                                                <td align="center" style="border-radius: 3px;" bgcolor="#FFA73B">
                                                    <a href="#" id="submit"
                                                       style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FFA73B; display: inline-block;">
                                                        <?php echo $this->lang->line("Confirm Email"); ?></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> <!-- COPY -->
                <?php endif; ?>
            </table>
        </td>
    </tr>


</table>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/24f7885cb9.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/16327/MorphSVGPlugin.min.js"></script>
<script src="<?php echo base_url('plugins/alertifyjs/alertify.min.js') ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/izitoast/js/iziToast.min.js"></script>


<script>
    $(document).ready(function ($) {

        $("#alert_msg").hide();
        $(document).on('click', '#submit', function (event) {
            event.preventDefault();

            var user_id = $("#user_id").val();
            var contact_id = $("#contact_id").val();
            var sequence_ids = $("#sequence_ids").val();

            if ((user_id == "" && contact_id == "") || (user_id == 0 || contact_id == 0)) {
                $("#alert_msg").show();
            }

            $.ajax({
                context: this,
                url: "<?php echo base_url('email_optin_form_builder/confirm_optin_action') ?>",
                type: 'POST',
                data: {user_id, contact_id, sequence_ids},
                success: function (response) {

                    if (response == 1) {
                        // $("#alert_msg").show();
                        // $("#alert_msg").children().removeClass("alert alert-danger");
                        // $("#alert_msg").children().addClass('alert alert-success');
                        // $("#alert_msg").children().html("Successfully Subscribed to our newsletter.");
                        $(this).hide();
                        $("#default_msg").hide(100);
                        $("#success_block").show(500);
                        $("#success_block").children().children().html("<i class='far fa-check-circle text-success'></i> Successfully Subscribed to our newsletter.");
                    }

                }
            })

        });
    });
</script>
</body>