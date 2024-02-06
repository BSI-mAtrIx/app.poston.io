<form><input type="hidden" name="csrf_token" id="csrf_token"
             value="<?php echo $this->session->userdata('csrf_token_session'); ?>"></form>

<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/forms/select/select2.min.css?ver=<?php echo $n_config['theme_version']; ?>">

<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<?php if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php') and $webhook_data_final['n_paymongo_enabled'] == '1') {
    include(APPPATH . 'modules/n_paymongo/views/ecommerce.php');
} ?>


<?php

if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php') and $webhook_data_final['n_moamalat_enabled'] == '1') {
    include(APPPATH . 'modules/n_moamalat/views/ecommerce.php');
}

if (file_exists(APPPATH . 'modules/n_sadad/controllers/N_sadad.php')) {
    include(APPPATH . 'modules/n_sadad/views/ecommerce.php');
} ?>




<script>
    var current_url = "<?php echo $current_url; ?>";
    var base_url = "<?php echo site_url(); ?>";
    var cart_id = '<?php echo $order_no;?>';
    var store_id = '<?php echo $webhook_data_final["store_id"];?>';
    var store_type = '<?php echo $webhook_data_final["store_type"];?>';
    var subscriber_id = '<?php echo $subscriber_id;?>';
    var new_addr_is_selected = 0;
    var selected_option = 0;

    var order_schedule = '<?php echo $order_schedule;?>';
    var today = new Date();
    var maxday = new Date();
    if (order_schedule == 'today') maxday = today;
    else if (order_schedule == 'tomorrow') maxday.setDate(maxday.getDate() + 1);
    else if (order_schedule == 'week') maxday.setDate(maxday.getDate() + 6);
    else maxday = false;

    var n_total_peymant_amount = 0;
    var n_total_delivery_price = '';
    var n_total_delivery_price_free = 0;

    var mashkor_blocked = 0;

    function go_to_payment_proceed(){
        $('#new_proceed_checkout').prop('disabled', true);

        setTimeout(function () {
            $('#new_proceed_checkout').prop('disabled', false);
        }, 1500);


        $pm_selected = $('#payment_method a.collapse');

        if($pm_selected.attr('action_modal')==1){
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#payment-options-modal'
                },
                preloader: false,
                modal: true
            });
        }

        if($pm_selected.attr('data-get-button')!=undefined){
            $.ajax({
                context: this,
                type: 'POST',
                dataType: 'JSON',
                url: $pm_selected.attr('data-get-button')+'/'+subscriber_id,
                success: function (response) {
                    $("#custom_button_json").html(response.button);

                    if($pm_selected.attr('action_id')!=undefined && $pm_selected.attr('action_id')!=''){
                        if($pm_selected.attr('action_class')!=undefined && $pm_selected.attr('action_class')!=''){
                            window.location.replace($('#'+$pm_selected.attr('action_id')).attr('href'));
                            return;
                        }
                        setTimeout(function () {
                            $('#'+$pm_selected.attr('action_id')).click();
                        }, 500);
                    }

                }
            });

            return;
        }



        if($pm_selected.attr('action_href')==undefined && $pm_selected.attr('href')=='#new_omise' ){
            <?php  if(file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php') and $webhook_data_final['n_omise_enabled'] == '1'){
            ?>

            omise_prepare();

            return;
            <?php } ?>
        }

        if($pm_selected.attr('action_href')!=undefined){
            window.location.replace($pm_selected.attr('action_href'));
        }

        if($pm_selected.attr('action_id')!=undefined && $pm_selected.attr('action_id')!=''){
            $('#'+$pm_selected.attr('action_id')).click();
        }

        if($pm_selected.attr('action_class')!=undefined && $pm_selected.attr('action_class')!=''){
            $('.'+$pm_selected.attr('action_class')).click();
        }
    }

    function go_to_payment(){

        $.ajax({
            type: 'POST',
            dataType:"JSON",
            data: {
                cart_id:cart_id,
                store_id:store_id,

                delivery_address_id:$("#select_delivery_address").val(),
                delivery_note:$('#delivery_note').val(),
                new_addr_is_selected:new_addr_is_selected,

                delivery_time: $("#delivery_time").val(),

                //delivery_address:delivery_address,

                subscriber_id:subscriber_id,
                csrf_token: "<?php echo $this->session->userdata('csrf_token_session'); ?>"
            },
            url: '<?php echo _link('ecommerce/apply_cart_additional_data'); ?>',
            success: function (response) {

                if (response.status == '0') {
                    var span = document.createElement("span");
                    span.innerHTML = response.message;
                    if (response.login_popup)
                        swal.fire({
                            title: '<?php echo $this->lang->line("Error"); ?>',
                            html: span,
                            icon: 'error'
                        }).then((value) => {
                            $("#login_form").trigger('click');
                        });
                    else swal.fire({title: '<?php echo $this->lang->line("Error"); ?>', html: span, icon: 'error'});
                } else if (response.status == '2') {
                    var span = document.createElement("span");
                    span.innerHTML = response.message;
                    swal.fire({title: '<?php echo $this->lang->line("Oops!"); ?>', html: span, icon: 'warning'});
                } else {
                    go_to_payment_proceed();
                }




            }
        });
    }


    function save_delivery_address($proceed_payment_action = 0){
        if($proceed_payment_action==1){
            if($('#shipping-toggle').hasClass("checked") ){
                if(new_addr_is_selected==1){

                }else{
                    go_to_payment();
                    return;
                }
            }else{
                //to payment
                $("#select_delivery_address").val(null).change();
                $("#select_delivery_address option[data-profile_address='1']").prop("selected", true).change();

                go_to_payment();
                return;
            }
        }

            var data_close = $(this).attr('data-close');
            if(typeof(data_close)==='undefined') data_close='0';
            var first_name = $("#delivery_firstname").val();
            var last_name = $("#delivery_lastname").val();
            var street = $("#delivery_address").val();
            var state = $("#delivery_state").val();
            var city = $("#delivery_town").val();
            var zip = $("#delivery_postcode").val();
            var country = $("#delivery_country").val();
            var country_code = $("#delivery_country option:selected").attr('phonecode');
            var email = $("#delivery_email").val();
            var mobile = $("#delivery_phone").val();
            // var note = $("#deliveryAddressModal input[name=note]").val();

            var title = '<?php echo $this->lang->line('Delivery'); ?>';
            var id = 0;

            if(first_name=="" || last_name=="" || street==""){
                swal.fire(error, input_required, 'error');
                return;
            }
            $("#save_address").addClass('btn-progress');
            $.ajax({
                context: this,
                type:'POST',
                dataType:'JSON',
                url:base_url_js+"save_address",
                data:{subscriber_id,store_id,first_name,last_name,street,state,city,zip,country,email,mobile,country_code,title,id},
                success:function(response){
                    if(response.status=='1'){

                        load_address_list(1);
                        if($proceed_payment_action==1){
                            go_to_payment();
                        }
                    }else{
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        swal.fire({ title:error, html:span,icon:'error'}).then((value) => {
                            $("#login_form").trigger('click tap');
                        });
                    }
                }
            });
    }

    function save_profile_adress($proceed_payment_action = 0 ) {
        var first_name = $("#firstname").val();
        var last_name = $("#lastname").val();
        var street = $("#street").val();
        var state = $("#state-new").val();
        var city = $("#city").val();
        var zip = $("#zip").val();
        var country = $("#country").val();
        var country_code = $("#country option:selected").attr('phonecode');
        var email = $("#email").val();
        var mobile = $("#phone").val();

        if(first_name=="" || last_name=="" || street==""){
            swal.fire(error, input_required, 'error');
            $('.order-summary').unblock();
            return;
        }

        $.ajax({
            context: this,
            type:'POST',
            dataType:'JSON',
            url:base_url_js+"save_profile_data",
            data:{subscriber_id,store_id,first_name,last_name,street,state,city,zip,country,email,mobile,country_code},
            success:function(response){
                if(response.status=='1'){
                    if (typeof load_address_list !== "undefined") load_address_list();



                    if($proceed_payment_action==1){
                        save_delivery_address($proceed_payment_action);
                    }
                }else{
                    var span = document.createElement("span");
                    span.innerHTML = response.message;
                    swal({ title:error, content:span,icon:'error'}).then((value) => {
                        $("#login_form").trigger('click tap');
                    });
                    $('.order-summary').unblock();
                }
            }
        });

    }

    function set_delivery_address(){
        $this = $( "#select_delivery_address option:selected" );

        $readonly = true;
        if($this.val()=='new'){
            $readonly = false;
        }

        $( "#delivery_firstname" ).val($this.attr('data-first_name')).prop('readonly', $readonly);
        $( "#delivery_lastname" ).val($this.attr('data-last_name')).prop('readonly', $readonly);
        $( "#delivery_address" ).val($this.attr('data-address')).prop('readonly', $readonly);
        $( "#delivery_town" ).val($this.attr('data-city')).prop('readonly', $readonly);
        $( "#delivery_postcode" ).val($this.attr('data-zip')).prop('readonly', $readonly);
        $( "#delivery_phone" ).val($this.attr('data-mobile')).prop('readonly', $readonly);
        $( "#delivery_email" ).val($this.attr('data-email')).prop('readonly', $readonly);
        $( "#delivery_state" ).val($this.attr('data-state')).prop('readonly', $readonly);

        $( "#delivery_country" ).val(null).change();
        $( "#delivery_country option[data-country='"+$this.attr('data-country')+"']" ).prop("selected", true).change().prop('readonly', $readonly);

        delivery_methods_change();
    }


    function load_address_list($go_to_payment=0) {
        $.ajax({
            context: this,
            type: 'POST',
            url: base_url_js + "/get_buyer_address_list/1",
            data: {subscriber_id: subscriber_id, store_id: store_id},
            success: function (response) {
                $("#put_delivery_address_list").html(response);
                $("#proceed_checkout").removeClass('btn-progress' );
                if(new_addr_is_selected==1){
                    $('#select_delivery_address option:last-child').attr('selected', 'selected');
                }else{
                    $('#select_delivery_address').val(selected_option).change();
                }

                $('#select_delivery_address').append('<option value="new"><?php echo $this->lang->line('New address'); ?></option>');

                set_delivery_address();

                if($go_to_payment==1){
                    go_to_payment();
                }


            }
        });
    }

    function set_payments_method($dms){
        $('#shipping-method li').hide();
        $('#we_cant_delivery').hide();
        $.each($dms, function( index, value ) {
            if(value.active != undefined && value.active == 1 ){
                $("#dm_payment_"+index).show();
            }
            $("#dm_payment_"+index+" #price_"+index).html(value.price);
        });
    }

    function find(input, target){
        var found = -1;
        for (var prop in input) {
            if(input[prop] == target){
                found = prop;
            }
        };

        return found;
    };

    var zone_id = '';
    var current_country = '';
    var current_states = '';
    var current_country_zones = {};
    var current_states_zones = {};
    var current_dm_zones = '';
    var required_states_zones = 0;
    var allow_order_zones = '';
    var cant_order = 0;
    var worldwide_current_country_zones = '';

    var first_open = 0;
    <?php if(!empty($delivery_methods_worldwide)){ ?>
        var worldwide_zone_id = '<?php echo $delivery_methods_worldwide['id']; ?>';
        worldwide_current_country_zones = 'all';
        worldwide_current_states_zones = 'all';
        var worldwide_current_dm_zones = JSON.parse('<?php echo $delivery_methods_worldwide['delivery_methods']; ?>');
        worldwide_required_states_zones = 0;
    <?php } ?>

    function delivery_methods_change(){
        $state_del = $('#delivery_state').val();
        $state_bill = $('#state-new').val();

        if($('#shipping-toggle').hasClass("checked") ){
            $country = $( "#delivery_country option:selected").attr('data-country');
            $state = $('#delivery_state').val();
        }else{
            $country = $( "#country option:selected").attr('data-country');
            $state = $('#state-new').val();
        }
        var delivery_address_id = $("#select_delivery_address").val();

        // if(find(current_country_zones, $country) === -1){

        $('#shipping-method input').prop('checked',false);

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {
                        delivery_address_id:delivery_address_id,
                        country:$country,
                        state:$state,
                        store_id:store_id,
                        csrf_token:'<?php echo $this->session->userdata('csrf_token_session'); ?>'
                },
                url: '<?php echo _link('ecommerce/ajax_get_shipping_zone'); ?>',
                success: function (response) {

                    $('#state-new').empty().select2({
                        placeholder: '<?php echo $this->lang->line('Search or type state'); ?>',
                        width: '100%',
                        tags: true,
                        tokenSeparators: [',', ' '],
                        data: response.states_data,
                        multiple: false,
                    }).val($state_bill).trigger('change.select2');

                    $('#delivery_state').empty().select2({
                        placeholder: '<?php echo $this->lang->line('Search or type state'); ?>',
                        width: '100%',
                        tags: true,
                        tokenSeparators: [',', ' '],
                        data: response.states_data,
                        multiple: false,
                    }).val($state_del).trigger('change.select2');

                    if(response.status==0){
                        if(worldwide_current_country_zones=='all'){
                            zone_id = worldwide_zone_id;

                            set_payments_method(worldwide_current_dm_zones);
                        }else{
                            $('#shipping-method li').hide();
                            $('#we_cant_delivery').show();

                            if(first_open>1){
                                swal.fire({
                                    title: '<?php echo $this->lang->line("Error"); ?>',
                                    html: '<?php echo $this->lang->line("We cant delivery to this address"); ?>',
                                    icon: 'error'
                                });
                                $('.order-summary').unblock();
                            }
                            first_open = first_open+1;
                        }

                        return;
                    }



                    if(response.allow_order==0){
                        allow_order_zones = 0;
                        cant_order = 1;
                    }

                    zone_id = response.id;

                    if(response.delivery_methods!=''){
                        current_dm_zones = JSON.parse(response.delivery_methods);
                    }



                    if(response.country!=''){
                        current_country_zones = JSON.parse(response.country);
                    }

                    if(response.states!=''){
                        current_states_zones = JSON.parse(response.states);
                    }

                    required_states_zones = response.required_state;

                    if(find(current_country_zones, $country) === 1){
                        cant_order = 1;
                    }

                    if(response.status==0 || required_states_zones==1 && find(current_states_zones, $state) === -1){
                        cant_order = 1;
                    }
                    
                    if(cant_order==0){
                        set_payments_method(current_dm_zones);
                    }else{
                        if(worldwide_current_country_zones=='all'){
                            set_payments_method(worldwide_current_dm_zones);
                        }else{
                            $('#shipping-method li').hide();
                        }
                    }

                    if(response.allow_order==0){
                        cant_order=1;
                        $('#shipping-method li').hide();
                    }


                }
            });
        // }else{
        //     if(find(current_country_zones, $country) === 1){
        //         cant_order =1;
        //     }
        //
        //     if(required_states_zones==1 && find(current_states_zones, $state) === -1){
        //         cant_order = 1;
        //     }
        //
        //     if(cant_order==0){
        //         set_payments_method(current_dm_zones);
        //     }else{
        //         if(worldwide_current_country_zones=='all'){
        //             set_payments_method(worldwide_current_dm_zones);
        //         }else{
        //             $('#shipping-method li').hide();
        //         }
        //     }
        // }



    }

    function set_payments_method_for_dm(){
        $('#payment_method div.card').hide();
        $('#payment_method div.card a').attr('class', 'expand');
        $('#payment_method div.card div.card-body').hide();
        $dm_selected = $("input:radio[name ='shipping']:checked");


        if($dm_selected.attr('data-cod')==1){
            $('#payment_method div.cod').show();
        }else{
            $('#payment_method div.card').show();
            $('#payment_method div.cod').hide();
        }

        $('#delivery_price_summary').html($('#price_'+$dm_selected.val()).html());


        if(n_total_delivery_price_free==1 || n_total_delivery_price_free=="1"){
            $('#delivery_price_summary').html(n_total_delivery_price);
        }

        $total_price = parseFloat($('#delivery_price_summary').html()) + parseFloat($('#total_price_summary').attr('data-base_price'));
        $('#total_price_summary').html(parseFloat($total_price).toFixed(2));


    }

    function apply_store_delivery_method(){
        var store_pickup = '0';
        var pickup_point_details = '';

        $dm_selected = $("input:radio[name ='shipping']:checked");

        $id = $dm_selected.attr('id');
        delivery_name = $dm_selected.attr('data-name');

        delivery_id = $dm_selected.val();

        if($id=='store_pickup'){
            store_pickup = '1';
            pickup_point_details = $('#pickup_point_details').val();
        }

        send_data = {cart_id, subscriber_id, store_pickup, delivery_name, pickup_point_details,delivery_id, zone_id};

        <?php if(file_exists(APPPATH.'/modules/n_mashkar/controllers/N_mashkar.php')){ ?>
        mashkor = $dm_selected.attr('data-type-mashkor');

        lat = $('#lat').val();
        lng = $('#lng').val();

        mash_landmark = $('#mash_landmark').val();
        mash_block = $('#mash_block').val();
        mash_building = $('#mash_building').val();
        mash_room_number = $('#mash_room_number').val();

        if(mashkor != undefined){
            $('#btn_mashkor_modal').show();

            send_data = {cart_id, subscriber_id, store_pickup, delivery_name, pickup_point_details,delivery_id, zone_id, lat, lng, mash_landmark, mash_block, mash_building, mash_room_number};
        }
        <?php } ?>


        $.ajax({
            type: 'POST',
            dataType:"JSON",
            data: send_data,
            url: '<?php echo _link('ecommerce/apply_store_delivery_method'); ?>',
            success: function (response) {
                n_total_delivery_price = response.delivery_price;
                n_total_delivery_price_free = response.free_shipping;
                n_total_peymant_amount = response.amount;

                if(n_total_delivery_price>0){
                    $('#delivery_price_summary').html(n_total_delivery_price);
                    $('#total_price_summary').html(n_total_peymant_amount);
                    $('.mashkor_price_delivery').html(n_total_delivery_price);
                }

                if(mashkor != undefined){
                    mashkor_blocked=0;
                    if(response.status==0){
                        mashkor_blocked=1;
                    }
                }

                if(n_total_delivery_price_free==1 || n_total_delivery_price_free=="1"){
                    $('#delivery_price_summary').html(n_total_delivery_price);
                    $('#total_price_summary').html(n_total_peymant_amount);
                }

                Wolmart.accordion('.card-header > a');
            }
        });
    }

    $("document").ready(function () {

        $(document).on('click', '.checkbox-toggle', function (e) {
            delivery_methods_change();
        });

        $(document).on('change', '#select_delivery_address', function (e) {
            set_delivery_address();
        });

        $(document).on('change', '#country', function (e) {
            $('#state-new').val('').change();
            delivery_methods_change();
        });

        $(document).on('change', '#state-new', function (e) {
            delivery_methods_change();
        });

        $(document).on('change', '#delivery_country', function (e) {
            if($('#shipping-toggle').hasClass("checked") ) {
                delivery_methods_change();
            }
        });

        $(document).on('change', '#delivery_state', function (e) {
            if($('#shipping-toggle').hasClass("checked") ) {
                delivery_methods_change();
            }
        });

        $(document).on('change', "input:radio[name ='shipping']", function (e) {
            set_payments_method_for_dm();
        });

        $('.select2').select2({width:'100%'});


        setTimeout(function () {
            load_address_list();
        }, 500);

        $('#delivery_time').datetimepicker({
            theme: 'light',
            format: 'Y-m-d H:i:s',
            formatDate: 'Y-m-d H:i:s',
            minDate: today,
            maxDate: maxday
        });

        $(document).on('click tap', '#apply_coupon', function (e) {
            e.preventDefault();
            var coupon_code = $("#coupon_code").val();

            save_profile_adress();
            save_delivery_address();


            $("#apply_coupon").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {coupon_code, cart_id, subscriber_id},
                url: '<?php echo _link('ecommerce/apply_coupon'); ?>',
                success: function (response) {
                    $("#apply_coupon").removeClass("btn-progress");
                    if (response.status == '0') swal.fire("<?php echo $this->lang->line('Error'); ?>", response.message, 'error');
                    else {
                        swal.fire("<?php echo $this->lang->line('Success'); ?>", response.message, 'success');
                        window.location.replace(current_url);
                    }
                }
            });

        });



        $(document).on('change', 'input:radio[name ="shipping"]', function (e) {
            apply_store_delivery_method();
        });


        $(document).on('click tap', '#new_proceed_checkout', function (e) {
            e.preventDefault();

            $('.order-summary').block({
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

            if($("input:radio[name ='shipping']:checked").attr('data-type-mashkor')!=undefined){
                let check_mash_block = $('#mash_block').val();
                let check_mash_building = $('#mash_building').val();
                let check_lat = $('#lat').val();
                let check_lng = $('#lng').val();

                if(check_mash_block=='' || check_mash_building == '' || check_lat == '' || check_lng == ''){
                    swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php  echo $this->lang->line('Please check fields checkout fields. Including Edit location for building and block.'); ?>", 'error');
                    $('.order-summary').unblock();
                    return;
                }

                if(mashkor_blocked==1){
                    swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php  echo $this->lang->line('Please contact with store owner. Code: 713'); ?>", 'error');
                    $('.order-summary').unblock();
                    return;
                }
            }

            if ($("input:radio[name ='shipping']:checked").val()==undefined){
                swal.fire("<?php echo $this->lang->line('Error'); ?>", '<?php echo $this->lang->line('Delivery method is not selected'); ?>', 'error');
                $('.order-summary').unblock();
                return;
            }

            if ($('#payment_method a.collapse').length == 0){
                swal.fire("<?php echo $this->lang->line('Error'); ?>", '<?php echo $this->lang->line('Payment method is not selected'); ?>', 'error');
                $('.order-summary').unblock();
                return;
            }

            if($('#shipping-toggle').hasClass("checked") ){
                if($("#select_delivery_address").val()=='new'){
                    new_addr_is_selected = 1;
                }
            }

            selected_option = $("#select_delivery_address").val();



            save_profile_adress(1);
        });


        $(document).on('click tap', '#proceed_checkout', function (e) {
            e.preventDefault();
            $("#payment_options").html('');
            var input_name;
            var address_data = new Object();
            var pickup_point_details = $("#pickup_point_details").val();
            var delivery_address_id = $("#select_delivery_address").val();
            var delivery_note = $("#delivery_note").val();
            var delivery_time = $("#delivery_time").val();
            var store_pickup = '0';
            if ($("#store_pickup").is(':checked')) store_pickup = '1';

            if (store_type == 'physical') {
                if (!delivery_address_id && $("#store_pickup").is(':checked') == false) {
                    swal.fire("<?php echo $this->lang->line('Error'); ?>", "<?php echo $this->lang->line('Please select delivery address or pickup point before you proceed.');?>", 'error');
                    return false;
                }
            }
            var subscriber_first_name = '<?php echo $wc_first_name;?>';
            var subscriber_last_name = '<?php echo $wc_last_name;?>';
            var subscriber_auto_id = '<?php echo $webhook_data_final['subscriber_auto_id'] ?? 0 ?>';
            var subscriber_country = '<?php echo $store_country;?>';
            var param = {
                cart_id: cart_id,
                subscriber_id: subscriber_id,
                subscriber_first_name: subscriber_first_name,
                subscriber_last_name: subscriber_last_name,
                delivery_address_id: delivery_address_id,
                store_pickup: store_pickup,
                pickup_point_details: pickup_point_details,
                delivery_note: delivery_note,
                subscriber_country: subscriber_country,
                store_id: store_id,
                delivery_time: delivery_time,
                subscriber_auto_id: subscriber_auto_id
            };
            var mydata = JSON.stringify(param);
            $("#proceed_checkout").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {mydata: mydata},
                url: '<?php echo _link('ecommerce/proceed_checkout'); ?>',
                success: function (response) {
                    $("#proceed_checkout").removeClass("btn-progress");
                    if (response.status == '0') {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        if (response.login_popup)
                            swal.fire({
                                title: '<?php echo $this->lang->line("Error"); ?>',
                                html: span,
                                icon: 'error'
                            }).then((value) => {
                                $("#login_form").trigger('click');
                            });
                        else swal.fire({title: '<?php echo $this->lang->line("Error"); ?>', html: span, icon: 'error'});
                    } else if (response.status == '2') {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        swal.fire({title: '<?php echo $this->lang->line("Oops!"); ?>', html: span, icon: 'warning'});
                    } else {
                        $("#payment_options").html(response.html);
                        $.magnificPopup.open({
                            type: 'inline',
                            items: {
                                src: '#payment-options-modal'
                            },
                            preloader: false,
                            modal: true
                        });
                        <?php if(file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php') and $webhook_data_final['n_omise_enabled'] == '1'){ ?>
                        omise_prepare();
                        <?php } ?>
                        <?php if(file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php') and $webhook_data_final['n_paymongo_enabled'] == '1'){ ?>
                        paymongo_prepare();
                        <?php } ?>
                        <?php if(file_exists(APPPATH . 'modules/n_paymentwall/controllers/N_paymentwall.php') and $webhook_data_final['n_paymentwall_enabled'] == '1'){ ?>
                        //paymentwall_prepare();
                        <?php } ?>
                        // $("#manual-payment-ins-modal .modal-body").html(response.manual_payment_instruction);
                        // $("html, body").animate({ scrollTop: $(document).height() }, 100);
                        // $("#proceed_checkout").parent().hide();
                    }
                }
            });

        });

        $(document).on('click tap', '#manual-payment-button', function () {
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: '#manual-payment-modal'
                },
                preloader: false,
                modal: true
            });
        });

        $(document).on('click tap', '#mollie-payment-button', function (e) {
            e.preventDefault();
            var redirect_url = $(this).attr('href');
            window.location.href = redirect_url;
        });

        $(document).on('click tap', '#cod-payment-button', function (e) {
            e.preventDefault();
            var cart_id = '<?php echo $order_no;?>';
            var subscriber_id = '<?php echo $subscriber_id;?>';
            $("#cod-payment-button").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                dataType: 'JSON',

                data: {cart_id, subscriber_id},
                url: '<?php echo _link('ecommerce/cod_payment'); ?>',
                success: function (response) {
                    $("#cod-payment-button").removeClass("btn-progress");
                    if (response.error) {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", response.error, 'error');
                    } else {
                        if (n_custom_domain == 1) {
                            response.redirect = response.redirect.replaceAll('ecommerce/', '');
                        }
                        window.location.href = response.redirect;
                    }
                }

            });
        });

        // Handles form submit
        $(document).on('click tap', '#manual-payment-submit', function () {

            // Reference to the current el
            var that = this;

            // Shows spinner
            $(that).addClass('btn-progress');
            var formData = new FormData($("#manaul_payment_data")[0]);

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                dataType: 'JSON',
                url: '<?php echo _link('ecommerce/manual_payment'); ?>',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.success) {

                        $(that).removeClass('btn-progress');
                        empty_form_values();
                        $('#manual-payment-modal').magnificPopup('close');
                        if (n_custom_domain == 1) {
                            response.redirect = response.redirect.replaceAll('ecommerce/', '');
                        }
                        window.location.href = response.redirect;
                    }

                    if (response.error) {

                        $(that).removeClass('btn-progress');

                        var span = document.createElement("span");
                        span.innerHTML = response.error;

                        swal.fire({
                            icon: 'error',
                            title: '<?php echo $this->lang->line('Error'); ?>',
                            html: span,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    $(that).removeClass('btn-progress');
                },
            });
        });


        // Empties form values
        function empty_form_values() {
            $('#paid-amount').val('');
            $('#additional-info').val('');
            $('#paid-currency').prop("selectedIndex", 0);
            $("#manual-payment-file").val('');
            // Clears added file
        }

        $(document).on('click tap', '.delete_item', function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var subscriber_id = '<?php echo $subscriber_id;?>';
            var cart_id = '<?php echo $order_no;?>';
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {id, cart_id, subscriber_id},
                url: '<?php echo _link('ecommerce/delete_cart_item'); ?>',
                success: function (response) {
                    if (response.status == '0') {
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", response.message, 'error');
                    } else {
                        window.location.replace(current_url);
                    }

                }
            });

        });

        $(document).on('focusout change', '.quantity', function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var action = $(this).attr("data-action");
            var quantity = $(this).val();

            quantity = parseInt(quantity);

            if (quantity == 0) {
                $('.delete_item[data-id=' + id + ']').trigger('click');
                return;
            }


            $(".add_to_cart").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                data: {id, action, cart_id, store_id, subscriber_id, quantity},
                url: '<?php echo _link('ecommerce/update_cart_item_checkout_input'); ?>',
                success: function (response) {
                    if (response.status == '0') {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        if (response.login_popup)
                            swal.fire({
                                title: '<?php echo $this->lang->line("Error"); ?>',
                                html: span,
                                icon: 'error'
                            }).then((value) => {
                                $("#login_form").trigger('click');
                            });
                        else swal.fire({
                            title: '<?php echo $this->lang->line("Error"); ?>',
                            html: span,
                            icon: 'error'
                        }).then((value) => {
                            window.location.reload();
                        });
                    } else {
                        window.location.reload();
                    }
                }
            });
        });

        $(document).on('click touchstart', '.add_to_cart2', function (e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
            var action = $(this).attr("data-action");
            var quantity = $(this).attr("data-quantity");
            quantity = parseInt(quantity);
            if (quantity <= 1 && action == 'remove') {
                $('.delete_item[data-id=' + id + ']').trigger('click');
                return;
            }

            $(".add_to_cart").addClass("btn-progress");
            $.ajax({
                type: 'POST',
                data: {id, action, cart_id, store_id, subscriber_id, quantity},
                url: '<?php echo _link('ecommerce/update_cart_item_checkout'); ?>',
                dataType: 'json',
                success: function (response) {
                    if (response.status == '0') {
                        var span = document.createElement("span");
                        span.innerHTML = response.message;
                        if (response.login_popup)
                            swal.fire({
                                title: '<?php echo $this->lang->line("Error"); ?>',
                                html: span,
                                icon: 'error'
                            }).then((value) => {
                                $("#login_form").trigger('click');
                            });
                        else swal.fire({
                            title: '<?php echo $this->lang->line("Error"); ?>',
                            html: span,
                            icon: 'error'
                        }).then((value) => {
                            window.location.reload();
                        });
                    } else {
                        window.location.reload();
                    }
                }
            });
        });

        $(".custom-file-input").on("change", function () {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $("#sadad_payment_modal .mfp-close, .swal2-confirm").on("click tap", function () {
            $('.order-summary').unblock();
        });

    });
</script>


<?php

if (file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php') and $webhook_data_final['n_omise_enabled'] == '1') { ?>
    <script type="text/javascript"
            src="https://cdn.omise.co/omise.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
    <script type="text/javascript">
        // Set default parameters
        function omise_prepare() {
            $('.order-summary').unblock();

            OmiseCard.configure({
                publicKey: '<?php echo $ecommerce_config['n_omise_pubkey']; ?>',
                image: 'https://cdn.omise.co/assets/dashboard/images/omise-logo.png',
                frameLabel: '<?php echo $store_name; ?>',
            });

            // Configuring your own custom button
            OmiseCard.configureButton('#omise-checkout-button-1', {
                buttonLabel: '<?php echo $this->lang->line('PAY Now');  echo ' ' . $currency_left; ?>'+n_total_peymant_amount+'<?php echo $currency_right; ?>',
                submitLabel: '<?php echo $this->lang->line('PAY Now'); ?>',
                amount: n_total_peymant_amount+'00',
                currency: '<?php echo $currency; ?>',
            });

            // Then, attach all of the config and initiate it by 'OmiseCard.attach();' method
            OmiseCard.attach();

            $('#omise-checkout-button-1').click();
        }
    </script>
<?php } ?>

<?php if (file_exists(APPPATH . 'modules/n_tdsp/controllers/N_tdsp.php') and $webhook_data_final['n_tdsp_enabled'] == '1') {
    include(APPPATH . 'modules/n_tdsp/lib/button_ecommerce_lib_js.php');
 } ?>

<?php if (file_exists(APPPATH . 'modules/n_stripe/controllers/N_stripe.php')
   // and $webhook_data_final['n_tdsp_enabled'] == '1'
) {
    include(APPPATH . 'modules/n_stripe/lib/button_ecommerce_lib_js.php');
}   ?>

<?php if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php') and $webhook_data_final['n_epayco_enabled'] == '1') {
    include(APPPATH . 'modules/n_epayco/lib/button_ecommerce_lib_js.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_sellix/controllers/N_sellix.php') and $webhook_data_final['n_sellix_enabled'] == '1') {
    include(APPPATH . 'modules/n_sellix/lib/button_ecommerce_lib_js.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_chapa/controllers/N_chapa.php') and $webhook_data_final['n_chapa_enabled'] == '1') {
    include(APPPATH . 'modules/n_chapa/lib/button_ecommerce_lib_js.php');
} ?>

<?php if (file_exists(APPPATH . 'modules/n_zaincash/controllers/N_zaincash.php') and $webhook_data_final['n_zaincash_enabled'] == '1') {
    include(APPPATH . 'modules/n_zaincash/lib/button_ecommerce_lib_js.php');
} ?>


<div class="n_modal mfp-hide" id="deliveryAddressModal">
    <div>
        <h4><?php echo $this->lang->line("Delivery Address"); ?></h4>
        <div class="modal-body" id="deliveryAddressModalBody">

        </div>
        <button type="button" id="new_address" class="btn btn-primary btn-block no_radius p-3 m-0"><i
                    class="w-icon-plus"></i> <?php echo $this->lang->line("Add Address"); ?></button>
        <button type="button" id="save_address" data-close="0"
                class="btn btn-primary btn-block no_radius p-3 m-0 d-none"><i
                    class="w-icon-check-solid"></i> <?php echo $this->lang->line("Save Address"); ?> </button>
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>


<div class="n_modal mfp-hide" id="payment-options-modal">
    <div class="">
        <div class="modal-body" id="payment_options">
            <?php echo $hidden_code; ?>
            <?php if(file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php') and $webhook_data_final['n_paymongo_enabled'] == '1'){ ?>
                    <script>paymongo_prepare();</script>
            <?php } ?>
            <div id="custom_button_json" style="display: none;"></div>
        </div>
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>

<div class="n_modal mfp-hide" id="manual-payment-modal">
    <div class="">
        <h4><?php echo $this->lang->line("Manual payment"); ?></h4>
        <div class="modal-body">
            <div class="container p-0">

                <form action="#" method="POST" id="manaul_payment_data" enctype="multipart/form-data">
                    <?php if (isset($manual_payment_instruction) && !empty($manual_payment_instruction)): ?>
                        <div class="alert alert-success alert-block alert-inline mb-4">
                            <h4 class="alert-title">
                                <i class="w-icon-dots-circle"></i><?php echo $this->lang->line('Instructions'); ?></h4>

                            <?php echo $manual_payment_instruction; ?>
                            <button class="btn btn-link btn-close">
                                <i class="close-icon"></i>
                            </button>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="cart_id" id="cart_id" value="<?php echo $order_no; ?>">
                    <input type="hidden" name="subscriber_id" id="subscriber_id" value="<?php echo $subscriber_id; ?>">

                    <!-- Paid amount and currency -->
                    <div class="row">
                        <div class="col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="paid-amount"><?php echo $this->lang->line('Paid Amount'); ?></label>
                                <input type="number" name="paid-amount" id="paid-amount" class="form-control" min="1">
                                <input type="hidden" id="selected-package-id">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <div class="form-group">
                                <label for="paid-currency"><?php echo $this->lang->line('Currency'); ?></label>
                                <?php echo form_dropdown('paid-currency', $currency_list, $currency, ['id' => 'paid-currency', 'class' => 'form-control select2', 'style' => 'width:100%']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Additional Info -->
                        <div class="col-12 mb-2">
                            <div class="form-group">
                                <label for="paid-amount"><?php echo $this->lang->line('Additional Info'); ?></label>
                                <textarea name="additional-info" id="additional-info" class="form-control"></textarea>
                            </div>
                        </div>
                        <!-- Image upload - Dropzone -->
                        <div class="col-12">
                            <div class="form-group">
                                <label class="d-flex" style="width:100%;">
                                    <span class="header-left">
                                        <?php echo $this->lang->line('Attachment'); ?><?php echo $this->lang->line('(Max 5MB)'); ?>
                                    </span>
                                    <span class="header-right"><?php echo $this->lang->line("Allowed types"); ?>: pdf, doc, txt, png, jpg, zip</span>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="manual-payment-file"
                                           name="manual-payment-file">
                                    <label class="custom-file-label"
                                           for="manual-payment-file"><?php echo $l->line('Choose file'); ?></label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <button type="button" id="manual-payment-submit" class="btn btn-primary mt-2"><i
                                class="w-icon-check-solid"></i> <?php echo $this->lang->line('Submit'); ?></button>
                </form>

            </div><!-- ends container -->
        </div><!-- ends modal-body -->
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>


<div class="d-none"><?php echo $sslcommerz_button; ?></div>
<?php if (isset($postdata_array) && !empty($postdata_array)):
    $postdata_array = json_encode($postdata_array);
    if ($sslcommerz_mode == 'live') $direct_api_url = "https://seamless-epay.sslcommerz.com/embed.min.js";
    else $direct_api_url = "https://sandbox.sslcommerz.com/embed.min.js";
    ?>
    <script>
        $("document").ready(function () {
            var direct_api_url = '<?php echo $direct_api_url; ?>';
            var ssl_post_data = '<?php echo $postdata_array; ?>';
            var ssl_post_json_data = JSON.parse(ssl_post_data);
            $('#sslczPayBtn').prop('postdata', ssl_post_json_data);
            (function (window, document) {
                var loader = function () {
                    var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
                    script.src = direct_api_url + '?' + Math.random().toString(36).substring(7);
                    tag.parentNode.insertBefore(script, tag);
                };
                window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
            })(window, document);
        });
    </script>
<?php endif; ?>

<?php if(file_exists(APPPATH.'modules/n_mashkar/include/checkout_js.php')){
    include(APPPATH.'modules/n_mashkar/include/checkout_js.php');
}
?>