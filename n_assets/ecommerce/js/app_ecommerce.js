function load_data(start,reset,popmessage,comment_id){
    var limit = $("#load_more").attr("data-limit");
    $("#waiting").show();
    if(reset) counter = 0;
    $.ajax({
        url: base_url_js+'comment_list_data',
        type: 'POST',
        dataType : 'JSON',
        data: {start:start,limit:limit,product_id:current_product_id,store_id:current_store_id,store_favicon:store_favicon,store_name:store_name,comment_id:comment_id,subscriber_id:subscriber_id,pickup:pickup},
        success:function(response)
        {
            $("#waiting").hide();
            $("#nodata").hide();

            counter += response.found;
            $("#load_more").attr("data-start",counter);


            if(!reset)  $("#load_data").append(response.html);
            else $("#load_data").html(response.html);

            if(response.found!='0') $("#load_more").show();
            else
            {
                $("#load_more").hide();
                if(popmessage)
                {
                    Toast.fire({
                        icon: 'success',
                        title: no_more_comment
                    });

                    $("#nodata").hide();
                }
                else $("#nodata").show();
            }
        }
    });
}

$(document).ready(function() {
    const Toast =  Swal.mixin({
        toast: true,
        position: 'bottom-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    });
    tippy('[data-toggle]', {
        content(reference) {
            const id = reference.getAttribute('title');
            return id;
        },
        allowHTML: true,
    });

    $(document).on('click tap','.add_to_cart',function(e){
        e.preventDefault();
        var $this = $(this);
        var product_id = $(this).attr("data-product-id");
        var attribute_ids = $(this).attr("data-attributes");
        var action = $(this).attr("data-action");
        var buy_now = false;
        var $product = $this.closest('.product, .product-popup');
        if($(this).hasClass('buy_now')) buy_now = true;

        // if(attribute_ids!='')
        // {
        //    $(".options").each(function() {
        //        if($(this).val()=="")
        //        {
        //          if($(this).attr('data-optional')=='0') exit=true;
        //        }
        //        temp = $(this).attr('data-attr');
        //        attribute_info[temp] = $(this).val();
        //    });
        // }

        var attribute_info = [];
        var required_attr = [];
        var exit = false;
        if(attribute_ids!=''){
            $(".options").each(function() {
                // if($(this).val()=="") exit=true;
                if($(this).is(':checked')){
                    var temp = $(this).attr('data-attr');
                    var value =  $(this).val();
                    if(typeof(attribute_info[temp])==='undefined' || attribute_info[temp].length==0){
                        attribute_info[temp]=[];
                    }
                    attribute_info[temp].push(value);
                }
                var temp2 = $(this).attr('data-attr');
                if($(this).attr('data-optional')=='0' && required_attr.indexOf(temp2)==-1) required_attr.push(temp2);
            });
        }
        $.each(required_attr, function( index, value ) {
            if(typeof(attribute_info[value])==='undefined' || attribute_info[value].length==0){
                exit = true;
                return false;
            }
        });
        if(exit){
            swal.fire(error, choose_required_options+" (*)", 'error');
            return;
        }

        var item_count = $("#item_count").val();
        if (typeof(item_count)==='undefined') item_count = 0;
        else item_count = parseInt(item_count);

        if(item_count==0 && action=="add"){
            item_count=1;
        }
        if(item_count==0 && action=="remove"){
            swal.fire(error, item_can_not_be_removed, 'error');
            return false;
        }
        var new_count = 0;
        var param = {
            'product_id':product_id,
            'action':action,
            'subscriber_id':subscriber_id,
            'attribute_info':attribute_info,
            pickup:pickup,
            'quantity':item_count
        };
        var mydata = JSON.stringify(param);
        $(this).addClass("btn-progress");
        $.ajax({
            context : this,
            type: 'POST',
            dataType: 'JSON',
            data: {mydata:mydata},
            url: base_url_js+'update_cart_item',
            success: function(response) {

                $(this).removeClass("btn-progress");
                var cart_count = 0;
                if(response.status=='1'){
                    cart_count = response.cart_data.cart_count;
                    cart_count = parseInt(cart_count);
                }
                if(cart_count==0){
                    $("#cart_item_count").html('0');
                    // $("#single_visit_store").addClass('d-none');
                    // $(".buy_now").removeClass('d-none');
                    // if(attribute_ids=='')$("#single_buy_now").removeClass('d-none');
                }else{
                    $("#cart_item_count").html(cart_count);
                    if(n_custom_domain==1){
                        response.cart_data.cart_url = response.cart_data.cart_url.replaceAll('ecommerce/','');
                    }
                    $("#cart_href_icon").attr('href',response.cart_data.cart_url);
                    // $(".buy_now").addClass('d-none');
                    // $("#cart_count_display").show();
                    // $("#single_visit_store").attr('href',response.cart_data.cart_url).removeClass('d-none');
                    // $("#single_buy_now").addClass('d-none');
                }

                if(response.status=='0') {
                    var span = document.createElement("span");
                    span.innerHTML = response.message;
                    if (response.login_popup){
                        $.magnificPopup.open({
                            type: 'inline',
                            items: {
                                src: '#login_form_modal_view'
                            },
                            preloader: false,
                            modal: true
                        });
                        // swal.fire({title: error, html: span, icon: 'error'}).then((value) => {
                        //     $("#login_form").trigger('click tap');
                        // });
                        return;
                    }else{
                        swal.fire({ title:error, html:span,icon:'error'});
                        return;
                    }
                }else{
                    if(n_custom_domain==1){
                        response.cart_url = response.cart_url.replaceAll('ecommerce/','');
                    }
                    if(buy_now){
                        window.location.replace(response.cart_url);
                    }else{

                        if(action!="add"){
                            has_added_lang = has_removed_lang;
                        }

                        if(enable_alert_add_to_cart=='true'){
                            if($this.hasClass('add_to_cart_mdl')) {
                                $('.remove_before').remove();
                                productName = $('.product-'+product_id+' .product-name').first().text();
                                var alertHtml = '<div class="alert alert-success alert-cart-product mb-2 remove_before">\
                        <a href="'+response.cart_url+'" class="btn btn-success btn-rounded">'+view_cart_lang+'</a>\
                        <p class="mb-0 ls-normal">“'+ productName +  '”' + has_added_lang +'.</p>\
                        <a href="#" class="btn btn-link btn-close">\<i class="close-icon"></i>\</a>\
                        </div>'
                                $this.closest('.product-single').before(alertHtml);
                            }else{
                                $('.remove_before').remove();
                                productName = $this.closest('.product-single').find('.product-title').text();
                                var alertHtml = '<div class="alert alert-success alert-cart-product mb-2 remove_before">\
                        <a href="'+response.cart_url+'" class="btn btn-success btn-rounded">'+view_cart_lang+'</a>\
                        <p class="mb-0 ls-normal">“'+ productName +  '”' + has_added_lang +'.</p>\
                        <a href="#" class="btn btn-link btn-close">\<i class="close-icon"></i>\</a>\
                        </div>'
                                $this.closest('.product-single').before(alertHtml);
                            }

                        }

                        if(enable_popup_add_to_cart=='true') {
                            if($this.hasClass('add_to_cart_mdl')) {
                                var product_id = $('#add_to_cart_modal_view .quantity-minus').attr('data-product-id');
                                Wolmart.Minipopup.open({
                                    productClass: ' product-cart',
                                    name: $('.product-'+product_id+' .product-name').first().text(),
                                    nameLink: $('.product-'+product_id+' .product-name > a').first().attr('href'),
                                    imageSrc: $('.product-'+product_id+' .product-media img').first().attr('src'),
                                    imageLink: $('.product-'+product_id+' .product-name > a').first().attr('href'),
                                    message: '<p>' + has_added_lang + ':</p>',
                                    actionTemplate: '<a href="'+response.cart_url+'" class="btn btn-rounded btn-sm">' + view_cart_lang + '</a>'
                                });
                            }else{
                                Wolmart.Minipopup.open({
                                    productClass: ' product-cart',
                                    name: $product.find('.product-name, .product-title').text(),
                                    nameLink: $product.find('.product-name > a, .product-title > a').attr('href'),
                                    imageSrc: $product.find('.product-media img, .product-image:first-child img').attr('src'),
                                    imageLink: $product.find('.product-name > a').attr('href'),
                                    message: '<p>' + has_added_lang + ':</p>',
                                    actionTemplate: '<a href="'+response.cart_url+'" class="btn btn-rounded btn-sm">' + view_cart_lang + '</a>'
                                });
                            }
                        }

                        //iziToast.success({title: "",message: response.message,position: 'bottomRight',timeout: 1000});

                            new_count = response.this_cart_item.quantity;

                        $(".cart_item_count").html( response.cart_data.cart_count);
                        $('.cart_item_count').removeClass('d-none');
                        $("#item_count").val( new_count);
                        $('.cart_url_api').attr('href',  response.cart_url)


                        $("#upsell_product").css("display","block");
                    }
                }
            }
        });

    });

    $(document).on('click tap', '.collapse_link', function (e) {
        e.preventDefault();
        $($(this).attr("data-id")).show();
    });

    $(document).on('click tap', '#login_submit', function (e) {

        var password = $("#login_password").val();
        var email = $("#login_email").val();
        if (email == "" || password == "") {
            swal.fire(error,email_and_password_are_required, 'error');
            return;
        }
        $("#login_submit").addClass('btn-progress');

        $.ajax({
            context: this,
            type: 'POST',
            dataType: 'JSON',
            url: base_url_js+"login_action",
            data: {email, password, store_id},
            success: function (response) {
                $("#login_submit").removeClass('btn-progress');
                if (response.status == '0') {
                    swal.fire(error, response.message, 'error');
                }else{
                    if($(this).hasClass('login_from_popup')){
                       location.reload();
                    }else{
                       $(window).attr('location',base_url_js+'my_account/'+store_id)
                    }

                }
            }
        });
        e.preventDefault();
    });

    $(document).on('click tap', '#reset_password_submit', function (e) {
        e.preventDefault();
        var email = $("#login_email").val();
        if (email == "" ) {
            swal.fire(error,email_and_password_are_required, 'error');
            return;
        }
        $("#reset_password_submit").addClass('btn-progress');

        $.ajax({
            context: this,
            type: 'POST',
            dataType: 'JSON',
            url: base_url_js+"reset_password_action",
            data: {email, store_id},
            success: function (response) {
                $("#reset_password_submit").removeClass('btn-progress');
                if (response.status == '0') {
                    swal.fire(error, response.message, 'error');
                }else{
                    swal.fire(success, response.message, 'success');
                }
            }
        });
        e.preventDefault();
    });

    $(document).on('click tap', '#reset_password_submit_step_two', function (e) {
        e.preventDefault();
        var password = $("#register_password_reset").val();
        var password2 = $("#register_password_confirm_reset").val();
        if (password == '' || password != password2) {
            swal.fire(error,pass_not_match, 'error');
            return;
        }
        $("#reset_password_submit_step_two").addClass('btn-progress');

        var reset_token = $("#reset_token").val();

        $.ajax({
            context: this,
            type: 'POST',
            dataType: 'JSON',
            url: base_url_js+"reset_password_action_step_two",
            data: {password, store_id, reset_token},
            success: function (response) {
                $("#reset_password_submit_step_two").removeClass('btn-progress');
                if (response.status == '0') {
                    swal.fire(error, response.message, 'error');
                }else{
                    swal.fire(success, response.message, 'success');
                }
            }
        });
        e.preventDefault();
    });

    $(document).on('change', '#set_sort', function (e) {
        e.preventDefault();
        var set_sort = $("#set_sort").val();
        $.ajax({
            context: this,
            type: 'GET',
            url: base_url_js+"set_sort"+'/'+store_id+'/'+set_sort,
            success: function (response) {
                location.reload();
            }
        });
    });

    $(document).on('click tap','.leave_review_comment',function(e){
        var review_reply = $(this).prevAll('.review_reply').val();
        var parent_product_review_id = $(this).attr('parent-id');
        if(review_reply==""){
            swal.fire(error, please_write, 'error');
            return false;
        }
        $(this).addClass('btn-progress');
        $.ajax({
            context: this,
            type:'POST',
            dataType:'JSON',
            url:base_url+"ecommerce_review_comment/new_review_comment",
            data:{product_id:current_product_id,store_id:current_store_id,review_reply:review_reply,subscriber_id:subscriber_id,parent_product_review_id:parent_product_review_id},
            success:function(response){
                $(this).removeClass('btn-progress');
                if(response.status=='0') swal.fire(error,response.message,'error');
                else swal.fire(successfully, response.message, 'success').then((value) => {location.reload();});
            }
        });
    });

    $(document).on('click tap','.leave_comment',function(e){
        var new_comment = $(this).prevAll('.comment_reply').val();
        var parent_product_comment_id = $(this).attr('parent-id');
        if(new_comment==""){
            swal.fire(error, write_comment, 'error');
            return false;
        }
        $(this).addClass('btn-progress');
        $.ajax({
            context: this,
            type:'POST',
            dataType:'JSON',
            url:base_url+"ecommerce_review_comment/new_comment",
            data:{product_id:current_product_id,store_id:current_store_id,new_comment:new_comment,subscriber_id:subscriber_id,parent_product_comment_id:parent_product_comment_id,product_name:product_name,pickup:pickup},
            success:function(response){
                $(this).removeClass('btn-progress');
                if(response.status=='0') {
                    var span = document.createElement("span");
                    span.innerHTML = response.message;
                    if(response.login_popup)
                        swal.fire({ title:error, html:span,icon:'error'}).then((value) => {
                            $("#login_form").trigger('click tap');
                        });
                    else swal.fire({ title:error, html:span,icon:'error'});
                } else {
                    var data_start = $("#load_more").attr('data-start');
                    data_start  = parseInt(data_start);
                    data_start = data_start+1;
                    counter = counter+1;
                    $("#load_more").attr('data-start',data_start);
                    $("#nodata").hide();
                    if(parent_product_comment_id=='') $("#load_data").prepend(response.message);
                    else $(this).parent().parent().append(response.message);
                    if(parent_product_comment_id=='') $('html, body').animate({scrollTop: $("#comment_section").offset().top}, 1000);
                    $(this).prevAll('.comment_reply').val('');
                }
            }
        });
    });

    $(document).on('click tap','#rate_now',function(e){
        e.preventDefault();
        var reason = $(".review-form #reason").val();
        var rating = $(".review-form #rating").val();
        var review = $(".review-form #review").val();
        var cart_id = $(".review-form #cart_id").val();
        var insert_id = $(".review-form #insert_id").val();
        if(reason=='' || rating=='' || cart_id=='')
        {
            swal.fire(error, required_fields+' *','error');
            return false;
        }
        $(this).addClass('btn-progress');
        $.ajax({
            context: this,
            type:'POST',
            dataType:'JSON',
            url:base_url+"ecommerce_review_comment/new_review",
            data:{product_id:current_product_id,store_id:current_store_id,reason:reason,subscriber_id:subscriber_id,rating:rating,review:review,cart_id:cart_id,product_name:product_name,insert_id:insert_id},
            success:function(response){
                $(this).removeClass('btn-progress');
                if(response.status=='0')
                {
                    var span = document.createElement("span");
                    span.innerHTML = response.message;
                    if(response.login_popup)
                        swal.fire({ title:error, html:span,icon:'error'}).then((value) => {
                            $("#login_form").trigger('click tap');
                        });
                    else swal.fire({ title:error, html:span,icon:'error'});
                }
                else
                {
                    swal.fire(review_submitted, response.message, 'success').then((value) => {location.reload();});
                }
            }
        });
    });

    if(ecommerce_review_comment_exist=='1' && document.body.classList.contains('product_single')){
        setTimeout(function () {
            var start = $("#load_more").attr("data-start");
            load_data(start, false, false, "");
        }, 1000);

        $(document).on('click tap', '#load_more', function (e) {
            var start = $("#load_more").attr("data-start");
            load_data(start, false, true, "");
        });
    }

    $(document).on('click tap','.hide-comment',function(e){
        e.preventDefault();

        swal.fire({
            title: hide_comment,
            text: really_want_comment,
            icon: 'warning',
            confirmButtonText: yes,
            cancelButtonText: no,
            showCancelButton: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed)
                {
                    var id = $(this).attr('data-id');
                    var subscriber_id = subscriber_id;
                    $(this).addClass('btn-progress');
                    $.ajax({
                        context: this,
                        type:'POST',
                        dataType:'JSON',
                        url:base_url+"ecommerce_review_comment/hide_comment",
                        data:{product_id:current_product_id,store_id:current_store_id,subscriber_id:subscriber_id,id:id},
                        success:function(response){
                            $(this).removeClass('btn-progress');

                            if(response.status=='0') swal.fire({ title:error, html:response.message,icon:'error'});
                            else $(this).parent().parent().hide();
                        }
                    });
                }
            });
    });

    $(document).on('click tap','.hide-review',function(e){
        e.preventDefault();

        swal.fire({
            title: hide_review,
            text: really_want_review,
            icon: 'warning',
            confirmButtonText: yes,
            cancelButtonText: no,
            showCancelButton: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed)
                {
                    var id = $(this).attr('data-id');
                    var subscriber_id = subscriber_id;
                    $(this).addClass('btn-progress');
                    $.ajax({
                        context: this,
                        type:'POST',
                        dataType:'JSON',
                        url:base_url+"ecommerce_review_comment/hide_review",
                        data:{product_id:current_product_id,store_id:current_store_id,subscriber_id:subscriber_id,id:id},
                        success:function(response){
                            $(this).removeClass('btn-progress');
                            if(response.status=='0') swal.fire(error,response.message,'error');
                            else swal.fire(successfully, response.message, 'success').then((value) => {location.reload();});
                        }
                    });
                }
            });
    });

    if(document.body.classList.contains('product_single')){
        var attribute_info = [];
        $(".options").each(function() {
            if($(this).is(':checked'))
            {
                var temp = $(this).attr('data-attr');
                var value =  $(this).val();
                if(typeof(attribute_info[temp])==='undefined' || attribute_info[temp].length==0)
                {
                    attribute_info[temp]=[];
                }
                attribute_info[temp].push(value);
            }
        });
        $.ajax({
            context: this,
            type:'POST',
            dataType:'JSON',
            url:base_url_js+"get_price_basedon_attribues",
            data:{product_id:current_product_id,current_store_id:current_store_id,attribute_info:attribute_info,currency_icon:currency_icon,currency_position:currency_position,decimal_point:decimal_point,thousand_comma:thousand_comma},
            success:function(response){
                $("#calculated_price_basedon_attribute").html(response.price_html);
                $("#calculated_price_basedon_attribute").slideDown();
            }
        });
    }

    $(document).on('change','.options',function(e){
        var attribute_info = [];
        $(".options").each(function() {
            if($(this).is(':checked'))
            {
                var temp = $(this).attr('data-attr');
                var value =  $(this).val();
                if(typeof(attribute_info[temp])==='undefined' || attribute_info[temp].length==0)
                {
                    attribute_info[temp]=[];
                }
                attribute_info[temp].push(value);
            }
        });
        $.ajax({
            context: this,
            type:'POST',
            dataType:'JSON',
            url:base_url_js+"get_price_basedon_attribues",
            data:{product_id:current_product_id,current_store_id:current_store_id,attribute_info:attribute_info,currency_icon:currency_icon,currency_position:currency_position,decimal_point:decimal_point,thousand_comma:thousand_comma},
            success:function(response){
                $("#calculated_price_basedon_attribute").html(response.price_html);
                $("#calculated_price_basedon_attribute").slideDown();
            }
        });
    });

    $(document).on('click tap', '#register_submit', function(e) {

        var register_first_name = $("#register_first_name").val();
        var register_last_name = $("#register_last_name").val();
        var register_email = $("#register_email").val();
        var register_password = $("#register_password").val();
        var register_password_confirm = $("#register_password_confirm").val();

        if(register_first_name=="" || register_last_name=="" || register_email=="" || register_password=="" || register_password_confirm==""){
            swal.fire(error, required_fields, 'error');
            return;
        }
        $("#register_submit").addClass('btn-progress');

        $.ajax({
            context: this,
            type:'POST',
            dataType:'JSON',
            url:base_url_js+"register_action",
            data:{register_first_name,register_last_name,register_email,register_password,register_password_confirm,store_id,js_user_id},
            success:function(response){
                $("#register_submit").removeClass('btn-progress');
                if (response.status == '0') {
                    swal.fire(error, response.message, 'error');
                }else{
                    $(window).attr('location',base_url_js+'my_account/'+store_id)
                }
            }
        });
        e.preventDefault();
    });

    $("#reg").submit(function(e){
        e.preventDefault();
    });

    $("#log").submit(function(e){
        e.preventDefault();
    });

    $(document).on('click tap', '.logout_btn', function(e) {
        e.preventDefault();
        $.ajax({
            context: this,
            type:'POST',
            data:{store_id,store_unique_id,subscriber_id},
            url:base_url_js+"logout",
            success:function(response){
                if(response=='1') location.reload();
                else window.location.replace(base_url_js+'store/'+store_unique_id);
            }
        });
    });

    $(document).on('click tap', '#guest_register_form', function(e) {
        $(this).addClass('btn-progress');
        $.ajax({
            context: this,
            type:'POST',
            dataType:'JSON',
            url:base_url_js+"guest_login_action",
            data:{store_id,js_user_id},
            success:function(response){
                $(this).removeClass('btn-progress');
                if(response.status=='0')
                    swal.fire(error, response.message, 'error');
                else window.location.replace(base_url_js+'store/'+store_unique_id);
            }
        });
        e.preventDefault();
    });

    $(document).on('click tap', '#new_address', function(e) {
        e.preventDefault();
        $("#new_address").addClass('btn-progress');
        $.ajax({
            context: this,
            type:'POST',
            url:base_url_js+"get_buyer_address",
            data:{subscriber_id:subscriber_id,store_id:store_id,operation:'add'},
            success:function(response){
                data = response;

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
                data = data.replaceAll('data-toggle=\'tooltip\'', 'data-toggle=\'tooltip\' data-placement=\'bottom\'');
                data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                data = data.replaceAll('fas fa-city', 'bx bxs-city');
                data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                data = data.replaceAll('fas fa-at', 'bx bx-at');
                data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');




                $("#deliveryAddressModalBody").html(data);

                $.magnificPopup.open({
                    type: 'inline',
                    items: {
                        src: '#deliveryAddressModal'
                    },
                    preloader: false,
                    modal: true
                });

                $("#deliveryAddressModalBody #country").select2({width:'100%'}).trigger('change');

                $("#save_address").removeClass('d-none');
                $("#new_address").addClass('d-none');
                $("#new_address").removeClass('btn-progress');
                setTimeout(function(){
                    $("#deliveryAddressModal select[name=country]").trigger('change');
                }, 500);
            }
        });
    });

    $(document).on('click tap', '#save_address', function(e)  {
        e.preventDefault();
        var data_close = $(this).attr('data-close');
        if(typeof(data_close)==='undefined') data_close='0';
        var first_name = $("#deliveryAddressModal input[name=first_name]").val();
        var last_name = $("#deliveryAddressModal input[name=last_name]").val();
        var street = $("#deliveryAddressModal input[name=street]").val();
        var state = $("#deliveryAddressModal select[name=state]").val();
        var city = $("#deliveryAddressModal input[name=city]").val();
        var zip = $("#deliveryAddressModal input[name=zip]").val();
        var country = $("#deliveryAddressModal select[name=country]").val();
        var country_code = $("#deliveryAddressModal select[name=country] option:selected").attr('phonecode');
        var email = $("#deliveryAddressModal input[name=email]").val();
        var mobile = $("#deliveryAddressModal input[name=mobile]").val();
        // var note = $("#deliveryAddressModal input[name=note]").val();
        var title = $("#deliveryAddressModal input[name=title]").val();
        var id = $("#deliveryAddressModal input[name=id]").val();

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
                $("#save_address").removeClass('btn-progress');
                if(response.status=='1'){
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    $('#deliveryAddressModal').magnificPopup('close');
                    setTimeout(function(){
                        // if(data_close=='0'){
                        //     $("#showAddress").trigger('click tap');
                        //     $("#sidebarCollapse").click();
                        // }
                        $("#save_address").attr('data-close','0');
                        if (typeof load_address_list !== "undefined") load_address_list();
                    }, 500);
                }
                else
                {
                    var span = document.createElement("span");
                    span.innerHTML = response.message;
                    swal.fire({ title:error, html:span,icon:'error'}).then((value) => {
                        $("#login_form").trigger('click tap');
                    });
                }
            }
        });

    });

    $(document).on('click tap', '#delete_address', function(e) {
        e.preventDefault();

        swal.fire({title: delete_address,
            text: delete_this_address,
            icon: 'warning',
            confirmButtonText: yes,
            cancelButtonText: no,
            showCancelButton: true,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed)
                {
                    var id  = $(this).attr('data-id');
                    $("#delete_address").addClass('btn-progress');
                    $.ajax({
                        context: this,
                        type:'POST',
                        url:base_url_js+"delete_address",
                        data:{subscriber_id:subscriber_id,id:id},
                        success:function(response){
                            Toast.fire({
                                icon: 'success',
                                title: address_has_been_deleted
                            });
                            $('#deliveryAddressModal').magnificPopup('close');
                            setTimeout(function(){
                                $("#showAddress").trigger('click');
                                $("#sidebarCollapse").click();
                            }, 500);
                        }
                    });
                }
            });
    });

    $(".language_switch").click(function(e){
        e.preventDefault();
        var language=$(this).attr('data-id');
        $.ajax({
            url: base_url_js+'language_changer',
            type: 'POST',
            data: {language:language},
            success:function(response){
                location.reload();
            }
        });
    });



    $(document).on('click tap', '.show_delivery', function(e) {
        e.preventDefault();
        if( $('#show_delivery').hasClass('show') == false){
            $('#show_delivery').show();
            $('#show_delivery').addClass('show');
        }else{
            $('#show_delivery').hide();
            $('#show_delivery').removeClass('show');
        }
    });

    $(document).on('click tap', '.choose_time_delivery', function(e) {
        e.preventDefault();
        if( $('#choose_time_delivery').hasClass('show') == false){
            $('#choose_time_delivery').show();
            $('#choose_time_delivery').addClass('show');
        }else{
            $('#choose_time_delivery').hide();
            $('#choose_time_delivery').removeClass('show');
        }
    });

    $(document).on('click tap', '.print-options',function () {
        var id  = $(this).attr('id');
        var contents = $("#print-area").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.

        //Append the external CSS file.
        if(id=="mobile-print")
            frameDoc.document.write('<link href="'+base_url+'assets/css/print/ecommerce-thermal-mobile-print.css" rel="stylesheet" type="text/css" />');
        else if(id=="thermal-print")
            frameDoc.document.write('<link href="'+base_url+'assets/css/print/ecommerce-thermal-print.css" rel="stylesheet" type="text/css" />');
        else frameDoc.document.write('<link href="'+base_url+'assets/css/print/ecommerce-print.css" rel="stylesheet" type="text/css" />');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 1000);
    });

    $(document).on('click tap', '#showProfile', function(e) {
        e.preventDefault();
        $("#save_profile").addClass('btn-progress');
        $.magnificPopup.open({
            type: 'inline',
            items: {
                src: '#profileModal'
            },
            preloader: false,
            modal: true
        });
        $.ajax({
            context: this,
            type:'POST',
            url:base_url_js+"get_buyer_profile",
            data:{subscriber_id:subscriber_id,store_id:store_id},
            success:function(response){
                $("#profileModalBody").html(response);
                $("#save_profile").removeClass('btn-progress');

                $("#profileModal select[name=country]").select2({width:'100%'});

                if($("#profileModal select[name=country").length>0)
                {
                    setTimeout(function(){
                        $("#profileModal select[name=country]").trigger('change');
                    }, 500);
                }



                else $("#save_profile").hide();
            }
        });
    });


    $(document).on('click tap', '#save_profile', function(e) {
        e.preventDefault();
        var first_name = $("#profileModal input[name=first_name]").val();
        var last_name = $("#profileModal input[name=last_name]").val();
        var street = $("#profileModal input[name=street]").val();
        var state = $("#profileModal input[name=state]").val();
        var city = $("#profileModal input[name=city]").val();
        var zip = $("#profileModal input[name=zip]").val();
        var country = $("#profileModal select[name=country]").val();
        var country_code = $("#profileModal select[name=country] option:selected").attr('phonecode');
        var email = $("#profileModal input[name=email]").val();
        var mobile = $("#profileModal input[name=mobile]").val();

        if(first_name=="" || last_name=="" || street==""){
            swal.fire(error, input_required, 'error');
            return;
        }
        $("#save_profile").addClass('btn-progress');

        $.ajax({
            context: this,
            type:'POST',
            dataType:'JSON',
            url:base_url_js+"save_profile_data",
            data:{subscriber_id,store_id,first_name,last_name,street,state,city,zip,country,email,mobile,country_code},
            success:function(response){
                $("#save_profile").removeClass('btn-progress');
                if(response.status=='1')
                {
                   //iziToast.success({title: "",message: response.message,position: 'bottomRight',timeout: 3000});
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });

                    $("#sidebarCollapse").click();
                    if (typeof load_address_list !== "undefined") load_address_list();
                }
                else
                {
                    var span = document.createElement("span");
                    span.innerHTML = response.message;
                    swal({ title:error, content:span,icon:'error'}).then((value) => {
                        $("#login_form").trigger('click tap');
                    });
                }
            }
        });

    });

    $(document).on('click tap', '#showAddress', function(e) {
        e.preventDefault();
        var data_close = $(this).attr('data-close');
        $("#save_address").addClass('d-none');
        $("#save_address").attr('data-close',data_close);
        $("#new_address").removeClass('d-none')
        $("#new_address").addClass('btn-progress');

        $.magnificPopup.open({
            type: 'inline',
            items: {
                src: '#deliveryAddressModal'
            },
            preloader: false,
            modal: true
        });
        $.ajax({
            context: this,
            type:'POST',
            url:base_url_js+"get_buyer_address_list",
            data:{subscriber_id:subscriber_id,store_id:store_id,data_close},
            success:function(response){
                $("#deliveryAddressModalBody").html(response);
                $("#new_address").removeClass('btn-progress');
                if($("#deliveryAddressModalBody .list-group").length==0)
                    $("#new_address").hide();
            }
        });
    });

    $(document).on('click tap', '.saved_address_row', function(e) {
        e.preventDefault();
        var data_close = $(this).attr('data-close');
        var id = $(this).attr('data-id');
        var profile_address = $(this).attr('data-profile');
        if(profile_address=='1')
        {

            $('#deliveryAddressModal').magnificPopup('close');
            setTimeout(function(){
                $("#showProfile").trigger('click tap');
            }, 500);
            return;
        }
        $("#new_address").addClass('btn-progress');
        $.ajax({
            context: this,
            type:'POST',
            url:base_url_js+"get_buyer_address",
            data:{subscriber_id:subscriber_id,store_id:store_id,operation:'edit',id:id},
            success:function(response){
                $("#deliveryAddressModalBody").html(response);
                $("#save_address").removeClass('d-none');
                $("#save_address").attr('data-close',data_close);
                $("#new_address").addClass('d-none');
                $("#new_address").removeClass('btn-progress');

                $("#deliveryAddressModalBody #country").select2({width:'100%'}).trigger('change');
            }
        });
    });


    $(window).on('click touch focus', '#search_mobile', function (e) {
        e.preventDefault();
        Wolmart.$body.addClass('mmenu-active');
    });

});