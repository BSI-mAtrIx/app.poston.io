<script>
    var csrf_token = $("#csrf_token").val();
    var base_url = "<?php echo base_url(); ?>";
    var base_url_js = "<?php e_link('ecommerce/', true); ?>"
    var store_id = "<?php echo $store_id; ?>";
    var is_mobile = areWeUsingScroll = false;
    var subscriber_id = '<?php echo $subscriberId;?>';
    var store_unique_id = '<?php echo $js_store_unique_id;?>';
    var js_user_id = '<?php echo $js_user_id;?>';
    var ecommerce_review_comment_exist = '<?php echo $this->ecommerce_review_comment_exist;?>';
    var is_in_iframne = false;
    if (window.location !== window.parent.location) is_in_iframne = true;
    var ecommerce_review_comment_exist = '<?php echo $this->ecommerce_review_comment_exist;?>';

    var n_custom_domain = <?php echo $check_cn_nn; ?>;

    var enable_alert_add_to_cart = '<?php echo $n_eco_builder_config['product_single_alert_add_to_cart'];?>';
    var enable_popup_add_to_cart = '<?php echo $n_eco_builder_config['product_single_popup_add_to_cart'];?>';
    var pickup = '<?php echo $pickup;?>';

    var daterange_locale = {
        //"format": "MM/DD/YYYY",
        "separator": " - ",
        "applyLabel": "<?php echo $this->lang->line("Apply");?>",
        "cancelLabel": "<?php echo $this->lang->line("Cancel");?>",
        "fromLabel": "<?php echo $this->lang->line("From");?>",
        "toLabel": "<?php echo $this->lang->line("To");?>",
        "customRangeLabel": "<?php echo $this->lang->line("Custom");?>",
        "weekLabel": "<?php echo $this->lang->line("W");?>",
        "daysOfWeek": [
            "<?php echo $this->lang->line("Su");?>",
            "<?php echo $this->lang->line("Mo");?>",
            "<?php echo $this->lang->line("Tu");?>",
            "<?php echo $this->lang->line("We");?>",
            "<?php echo $this->lang->line("Th");?>",
            "<?php echo $this->lang->line("Fr");?>",
            "<?php echo $this->lang->line("Sa");?>"
        ],
        "monthNames": [
            "<?php echo $this->lang->line("January");?>",
            "<?php echo $this->lang->line("February");?>",
            "<?php echo $this->lang->line("March");?>",
            "<?php echo $this->lang->line("April");?>",
            "<?php echo $this->lang->line("May");?>",
            "<?php echo $this->lang->line("June");?>",
            "<?php echo $this->lang->line("July");?>",
            "<?php echo $this->lang->line("August");?>",
            "<?php echo $this->lang->line("September");?>",
            "<?php echo $this->lang->line("October");?>",
            "<?php echo $this->lang->line("November");?>",
            "<?php echo $this->lang->line("December");?>"
        ],
        //"firstDay": 1
    };


    var email_and_password_are_required = "<?php echo $this->lang->line("Email and password are required."); ?>";
    var pass_not_match = "<?php echo$this->lang->line("Passwords does not match.");?>";
    var error = "<?php echo $this->lang->line("Error"); ?>";
    var success = "<?php echo $this->lang->line("Success"); ?>";
    var successfully = "<?php echo $this->lang->line("Hidden Successfully"); ?>";
    var please_write = "<?php echo $this->lang->line("Please write a reply."); ?>";
    var review_submitted = "<?php echo $this->lang->line("Review Submitted"); ?>";
    var required_fields = "<?php echo $this->lang->line("Please fill in the required fields"); ?>";
    var no_more_comment = "<?php echo $this->lang->line("No more comment found."); ?>";
    var yes = "<?php echo $this->lang->line("Yes"); ?>";
    var no = "<?php echo $this->lang->line("No"); ?>";
    var hide_comment = "<?php echo $this->lang->line("Hide comment?"); ?>";
    var really_want_comment = "<?php echo $this->lang->line("Do you really really want to hide this comment?"); ?>";
    var hide_review = "<?php echo $this->lang->line("Hide review?"); ?>";
    var really_want_review = "<?php echo $this->lang->line("Do you really really want to hide this review?"); ?>";
    var write_comment = "<?php echo $this->lang->line("Please write a comment."); ?>";
    var choose_required_options = "<?php echo $this->lang->line("Please choose the required options."); ?>";
    var item_can_not_be_removed = "<?php echo $this->lang->line("Item can not be removed. It is not in cart anymore."); ?>";
    var view_cart_lang = "<?php echo $this->lang->line("View cart"); ?>";
    var has_added_lang = "<?php echo $this->lang->line(" has been added to your cart"); ?>";
    var has_removed_lang = "<?php echo $this->lang->line(" has been removed from your cart"); ?>";
    var input_required = "<?php echo $this->lang->line("Please input the required fields."); ?>";
    var address_has_been_deleted = "<?php echo $this->lang->line("Address has been deleted successfully."); ?>";
    var delete_address = "<?php echo $this->lang->line("Delete Address"); ?>";
    var delete_this_address = "<?php echo $this->lang->line("Do you really want to delete this address?"); ?>";

    $(document).ready(function () {
        $(document).on('click tap', '.add_to_cart_modal', function (e) {
            e.preventDefault();
            var product_id = $(this).attr('data-product-id');
            var buy_now = '0';
            var subscriber_id = "<?php echo isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : ''; ?>";
            if ($(this).hasClass('buy_now')) buy_now = '1';
            if (buy_now) $(this).addClass('btn-progress');
            else {
                $(this).removeClass('btn-outline-primary');
                $(this).addClass('btn-progress');
                $(this).addClass('btn-primary');
            }
            $("#add_to_cart_modal_view .modal-body").html('<div class="text-center" id="waiting" style="width: 100%;margin: 30px 0;" <i class=" w-icon-return2 blue" style="font-size:60px;"></i></div>');

            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#add_to_cart_modal_view'
                },
                preloader: false,
                modal: true
            });
            $.ajax({
                context: this,
                type: 'POST',
                data: {product_id, buy_now, subscriber_id},
                url: '<?php echo _link('ecommerce/add_to_cart_modal'); ?>',
                success: function (response) {
                    $(this).removeClass("btn-progress");
                    if (!buy_now) {
                        $(this).removeClass('btn-primary');
                        $(this).addClass('btn-outline-primary');
                    }
                    response = response.replaceAll('#add_to_cart_modal_view #cart_actions{position:fixed;bottom:0;left:0}', '');
                    var data = response;
                    data = data.replaceAll('fas fa-cart-plus', 'w-icon-plus');
                    data = data.replaceAll('fas fa-minus-circle', 'w-icon-minus');


                    $("#add_to_cart_modal_view .modal-body").html(data);
                }

            });
        });


    });

</script>

<div class="n_modal mfp-hide" id="login_form_modal_view">
    <div class="">
        <h4 id="login_form_modal_viewLabel"><?php echo $this->lang->line("Login / Sign Up"); ?></h4>
        <div class="modal-body">
            <div class="alert alert-warning alert-simple alert-inline">
                <h4 class="alert-title"><?php echo $l->line('please login to continue.'); ?></div>
            <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
                <ul class="nav nav-tabs text-uppercase" role="tablist">
                    <li class="nav-item">
                        <a href="#sign-in" class="nav-link active"><?php echo $l->line('Sign In'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#sign-up" class="nav-link"><?php echo $l->line('Sign Up'); ?></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="sign-in">
                        <form method="POST" id="log" action="#" class="needs-validation" novalidate="" _lpchecked="1">
                            <div class="form-group">
                                <label for="login_email"><?php echo $l->line('Email address'); ?></label>
                                <input type="text" class="form-control" name="username" id="login_email" required>
                            </div>
                            <div class="form-group mb-0">
                                <label for="login_password"><?php echo $l->line('Password'); ?></label>
                                <input type="password" class="form-control" name="password" id="login_password"
                                       required>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="submit" id="login_submit"
                                            class="btn btn-primary mt-1"><?php echo $l->line('Login'); ?></button>
                                </div>
                                <div class="col-md-6">
                                    <?php if ($is_guest_login == '1') {
                                        if ($n_eco_builder_config['guest_register_form_type'] == 'text') {
                                            ?>
                                            <div class="form-checkbox text-right mt-2">
                                                <a href="#"
                                                   id="guest_register_form"><?php echo $l->line('Continue as guest'); ?></a>
                                            </div>
                                            <?php
                                        }
                                        if ($n_eco_builder_config['guest_register_form_type'] == 'btn') {
                                            ?>
                                            <button type="submit" id="guest_register_form"
                                                    class="btn btn-primary login_from_popup mt-1"><?php echo $l->line('Continue as guest'); ?></button>
                                            <?php
                                        }
                                        ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="sign-up">
                        <form method="POST" id="reg" action="#" class="needs-validation" novalidate="" _lpchecked="1">
                            <div class="form-group">
                                <label for="register_first_name"><?php echo $this->lang->line("Name"); ?>*</label>

                                <input type="text" class="form-control"
                                       placeholder="<?php echo $this->lang->line("First Name"); ?>"
                                       id="register_first_name" name="" required autofocus autocomplete="off">
                                <input type="text" class="form-control mt-5"
                                       placeholder="<?php echo $this->lang->line("Last Name"); ?>"
                                       id="register_last_name" name="" required autofocus autocomplete="off">

                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group">
                                <label for="register_email"><?php echo $this->lang->line("Email"); ?>*</label>
                                <input type="email" class="form-control"
                                       placeholder="<?php echo $this->lang->line("Email"); ?>" id="register_email"
                                       name="" required autofocus autocomplete="off">
                            </div>
                            <div class="form-group mb-5">
                                <label for="register_password"
                                       class="control-label"><?php echo $this->lang->line("Password"); ?>*</label>
                                <input type="password" id="register_password"
                                       placeholder="<?php echo $this->lang->line("Password"); ?>" class="form-control"
                                       name="" required autocomplete="off">
                                <input type="password" id="register_password_confirm"
                                       placeholder="<?php echo $this->lang->line("Confirm Password"); ?>"
                                       class="form-control mt-5" name="" required autocomplete="off">
                            </div>

                            <button href="#" id="register_submit"
                                    class="btn btn-primary"><?php echo $this->lang->line("Register"); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- ends modal-body -->
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>

<div class="n_modal mfp-hide" id="add_to_cart_modal_view">
    <div class="">
        <h4 id="add_to_cart_modal_viewLabel"><?php echo $this->lang->line("Choose Options"); ?></h4>
        <div class="modal-body">
        </div><!-- ends modal-body -->
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>

<div class="n_modal mfp-hide" id="profileModal">
    <div class="">
        <h4 id="profileModalLabel"><?php echo $this->lang->line("Profile"); ?></h4>
        <div class="modal-body" id="profileModalBody">
        </div><!-- ends modal-body -->
        <button type="button" id="save_profile" class="btn btn-primary btn-block no_radius p-3 m-0"><i
                    class="w-icon-check-solid"></i> <?php echo $this->lang->line("Save Profile"); ?></button>
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>

<div class="n_modal mfp-hide" id="deliveryAddressModal">
    <div class="">
        <h4 id="profileModalLabel"><?php echo $this->lang->line("Delivery Address"); ?></h4>
        <div class="modal-body" id="deliveryAddressModalBody">
        </div><!-- ends modal-body -->
        <div class="d-flex">
            <button type="button" id="new_address" class="btn btn-primary btn-block no_radius p-3 m-0"><i
                        class="w-icon-plus"></i> <?php echo $this->lang->line("Add Address"); ?></button>
            <button type="button" id="save_address" data-close="0"
                    class="btn btn-primary btn-block no_radius p-3 m-0 d-none"><i
                        class="w-icon-check-solid"></i> <?php echo $this->lang->line("Save Address"); ?> </button>
        </div>

    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>
