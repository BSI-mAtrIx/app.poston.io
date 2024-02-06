$(document).ready(function() {
    $.fn.donetyping = function(callback, delay){
        delay || (delay = 1000);
        var timeoutReference;
        var doneTyping = function(elt){
            if (!timeoutReference) return;
            timeoutReference = null;
            callback(elt);
        };

        this.each(function(){
            var self = $(this);
            self.on('keyup',function(){
                if(timeoutReference) clearTimeout(timeoutReference);
                timeoutReference = setTimeout(function(){
                    doneTyping(self);
                }, delay);
            }).on('blur',function(){
                doneTyping(self);
            });
        });

        return this;
    };

    var csrf_token=$("#csrf_token").val();

    var build_url_iframe = function($new_var = '', $refresh){
        var url_new = '';
        if($new_var!=''){
            url_new = '&new_var='+JSON.stringify($new_var);
        }

        var url = base_url+'ecommerce/store/'+$('body').attr("data-id")+'?builder=1'+url_new
        var $iframe = $('#if_scroll');
        if ($iframe.length) {
            $iframe.attr('src',url);
            // if($refresh==false){
            //     $iframe.attr('src',url);
            // }else{
            //     $uri_curr = $('#if_scroll')[0].baseURI+'?builder=1'+url_new;
            //     $iframe.attr('src', $uri_curr);
            // }

            return false;
        }
        return true;
    }

    $(document).on('click', '.builder_restore_defaults', function (e) {
        e.preventDefault();
        swal.fire({
            title: '',
            text: areyousure,
            icon: 'warning',
            confirmButtonText: yes,
            cancelButtonText: no,
            showCancelButton: true,
            dangerMode: true,
            context: this,
        })
            .then((willDelete) => {
                if (willDelete.isConfirmed)
                {
                    var post_url=base_url+'ecommerce_builder/builder_restore_default_settings/'+$('body').attr("data-id");
                    $.post(post_url, {csrf_token: csrf_token},
                        function (response,textStatus, jqXHR) {
                            if(response.status == "1"){
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                                window.location.reload(true);
                            }else{
                                Toast.fire({
                                    icon: 'error',
                                    title: response.message
                                });
                            }
                        }, 'JSON').done(function() {

                    });
                }
            });





    });

    $(document).on('click', '.section_buttons button', function (e) {
        e.preventDefault();
        $('#panels_dis .panel_dis').hide();
        $('#panels_dis [data-panel="'+e.currentTarget.id+'"]').show();
        $('.section_buttons .primary').removeClass('primary').addClass('white');
        $(e.currentTarget).find('i').removeClass('white').addClass('primary')
    });

    $(document).on('click', '.iframe_view_style', function (e) {
        e.preventDefault();
        e.currentTarget.id
        $('.iframe_view_style i').removeClass('text-primary').addClass('text-white');
        $(e.currentTarget).find('i').removeClass('text-white').addClass('text-primary');

        if($(e.currentTarget).data('view_as')=='mobile'){
            $('#if_scroll').width(375);
            $('#if_scroll').height(812);
        }
        if($(e.currentTarget).data('view_as')=='tablet'){
            $('#if_scroll').width(768);
            $('#if_scroll').height(1024);
        }
        if($(e.currentTarget).data('view_as')=='desktop'){
            $('#if_scroll').width('100%');
            $('#if_scroll').height('100vh');
        }
    });

    $("#eco_upload_fav").uploadFile({
        url:base_url+"ecommerce_builder/upload_image_only/store_favicon",
        fileName:"file",
        maxFileSize:5*1024*1024,
        uploadButtonClass: 'btn btn-sm btn-primary mr-10',
        showPreview:false,
        returnType: "json",
        dragDrop: true,
        showDelete: true,
        multiple:false,
        maxFileCount:1,
        acceptFiles:".png",
        deleteCallback: function (data, pd) {
            var delete_url=base_url;
            $.post(delete_url, {op: "delete",name: data},
                function (resp,textStatus, jqXHR) {
                    $("#eco_upload_fav").val('');
                    $("#eco_upload_fav").hide();
                });

        },
        onSuccess:function(files,data,xhr,pd)
        {
            var save = 'upload/ecommerce/'+data;
            send_save('"store_favicon": "'+save+'"' );
            $("#eco_upload_fav").val(base_url+save);
            $("#store_favicon_img").attr('src',base_url+save);
        }
    });

    $("#eco_upload_logo").uploadFile({
        url:base_url+"ecommerce_builder/upload_image_only/store_logo_light",
        fileName:"file",
        maxFileSize:5*1024*1024,
        uploadButtonClass: 'btn btn-sm btn-primary mr-10',
        showPreview:false,
        returnType: "json",
        dragDrop: true,
        showDelete: true,
        multiple:false,
        maxFileCount:1,
        acceptFiles:".png",
        deleteCallback: function (data, pd) {
            var delete_url=base_url;
            $.post(delete_url, {op: "delete",name: data},
                function (resp,textStatus, jqXHR) {
                    $("#eco_upload_logo").val('');
                    $("#eco_upload_logo").hide();
                });

        },
        onSuccess:function(files,data,xhr,pd)
        {
            var save = 'upload/ecommerce/'+data;
            send_save('"store_logo_light": "'+save+'"' );
            $("#eco_upload_logo").val(base_url+save);
            $("#eco_upload_logo_img").attr('src',base_url+save);
        }
    });

    $("#eco_upload_dark_logo").uploadFile({
        url:base_url+"ecommerce_builder/upload_image_only/store_logo_dark",
        fileName:"file",
        maxFileSize:5*1024*1024,
        uploadButtonClass: 'btn btn-sm btn-primary mr-10',
        showPreview:false,
        returnType: "json",
        dragDrop: true,
        showDelete: true,
        multiple:false,
        maxFileCount:1,
        acceptFiles:".png",
        deleteCallback: function (data, pd) {
            var delete_url=base_url;
            $.post(delete_url, {op: "delete",name: data},
                function (resp,textStatus, jqXHR) {
                    $("#eco_upload_dark_logo").val('');
                    $("#eco_upload_dark_logo").hide();
                });

        },
        onSuccess:function(files,data,xhr,pd)
        {
            var save = 'upload/ecommerce/'+data;
            send_save('"store_logo_dark": "'+save+'"' );
            $("#eco_upload_dark_logo").val(base_url+save);
            $("#eco_upload_dark_logo_img").attr('src',base_url+save);
        }
    });

    $("#og_image_website").uploadFile({
        url:base_url+"ecommerce_builder/upload_image_only/og_image_website",
        fileName:"file",
        maxFileSize:5*1024*1024,
        uploadButtonClass: 'btn btn-sm btn-primary mr-10',
        showPreview:false,
        returnType: "json",
        dragDrop: true,
        showDelete: true,
        multiple:false,
        maxFileCount:1,
        acceptFiles:".jpg,.png",
        deleteCallback: function (data, pd) {
            var delete_url=base_url;
            $.post(delete_url, {op: "delete",name: data},
                function (resp,textStatus, jqXHR) {
                    $("#og_image_website").val('');
                    $("#og_image_website").hide();
                });

        },
        onSuccess:function(files,data,xhr,pd)
        {
            var save = 'upload/ecommerce/'+data;
            send_save('"og_image_website": "'+save+'"' );
            $("#store_dark_icon").val(base_url+save);
            $("#store_dark_icon_img").attr('src',base_url+save);
        }
    });

    $("#store_light_icon").uploadFile({
        url:base_url+"ecommerce_builder/upload_image_only/store_light_icon",
        fileName:"file",
        maxFileSize:5*1024*1024,
        uploadButtonClass: 'btn btn-sm btn-primary mr-10',
        showPreview:false,
        returnType: "json",
        dragDrop: true,
        showDelete: true,
        multiple:false,
        maxFileCount:1,
        acceptFiles:".png",
        deleteCallback: function (data, pd) {
            var delete_url=base_url;
            $.post(delete_url, {op: "delete",name: data},
                function (resp,textStatus, jqXHR) {
                    $("#store_light_icon").val('');
                    $("#store_light_icon").hide();
                });

        },
        onSuccess:function(files,data,xhr,pd)
        {
            var save = 'upload/ecommerce/'+data;
            send_save('"store_light_icon": "'+save+'"' );
            $("#store_light_icon").val(base_url+save);
            $("#store_light_icon_img").attr('src',base_url+save);
        }
    });

    $("#store_light_icon").uploadFile({
        url:base_url+"ecommerce_builder/upload_image_only/store_light_icon",
        fileName:"file",
        maxFileSize:5*1024*1024,
        uploadButtonClass: 'btn btn-sm btn-primary mr-10',
        showPreview:false,
        returnType: "json",
        dragDrop: true,
        showDelete: true,
        multiple:false,
        maxFileCount:1,
        acceptFiles:".png",
        deleteCallback: function (data, pd) {
            var delete_url=base_url;
            $.post(delete_url, {op: "delete",name: data},
                function (resp,textStatus, jqXHR) {
                    $("#store_light_icon").val('');
                    $("#store_light_icon").hide();
                });

        },
        onSuccess:function(files,data,xhr,pd)
        {
            var save = 'upload/ecommerce/'+data;
            send_save('"store_light_icon": "'+save+'"' );
            $("#store_light_icon").val(base_url+save);
            $("#store_light_icon_img").attr('src',base_url+save);
        }
    });

    $('input.spectrum').spectrum();

    $("input.spectrum").on('change.spectrum', function(e, tinycolor) {
        e.preventDefault();
        id = $(this).attr('id');
        val = $(this).val();
        val = val.replaceAll('#', '%23');
        string = '"'+id+'":"'+val+'"'
        send_save(string);
    });

    $("input.spectrum").on("dragstop.spectrum", function(e, color) {
        e.preventDefault();
        id = $(this).attr('id');
        val = $(this).val();
        string = '"'+id+'":"'+val+'"';
        send_save(string);
    });

    $(document).on('input', 'input.make_change', function (e) {
        e.preventDefault();
        id = $(this).attr('id');
        val = $(this).val();
        if($(this).attr('min')!=undefined){
            if(parseInt(val)<=parseInt($(this).attr('min'))){
                Toast.fire({
                    icon: 'error',
                    title: error_min_val
                });
                $(this).val($(this).attr('min'))
                return;
            }
        }
        val = val.replaceAll('#', '%23');
        val = val.replaceAll('"', 'quot');
        val = val.replaceAll("'", "\'");
        string = '"'+id+'":"'+val+'"';
        send_save(string);
    });

    $(document).on('change', 'select.make_change', function(e) {
        e.preventDefault();
        id = $(this).attr('id');
        val = $(this).find(":selected").val();
        string = '"'+id+'":"'+val+'"';
        send_save(string);
    });

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

    var send_save =  function($data, $refresh = 'false'){
        var post_url=base_url+'ecommerce_builder/save_builder/'+$('body').attr("data-id");
        $data = JSON.parse("{"+$data+"}")
        $.post(post_url, {csrf_token: csrf_token, _data: $data},
            function (response,textStatus, jqXHR) {
                if(response.status == "1")
                {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    build_url_iframe($data, $refresh);
                } else
                {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }

            }, 'JSON').done(function() {

        });
    }

    $('textarea.make_change').on('keyup', function(e) {
        e.preventDefault();
        id = $(this).attr('id');
        $(this).donetyping(function(){
            val = $('#'+id).val();
            val = val.replace(/'/g, 'apos').replace(/"/g, 'quot');
            val = JSON.stringify(val);
            string = '"'+id+'":'+val+'';
            send_save(string);
        }, 500 );
    });

    $(document).on('click', '#save_codes_before_body', function (e) {
        e.preventDefault();
        var post_url=base_url+'ecommerce_builder/ecommerce_marketing_save_new/'+$('body').attr("data-id");
        var data_codes_before_body = JSON.stringify($('#codes_before_body').val());
        $.post(post_url, {csrf_token: csrf_token, codes_before_body: data_codes_before_body},
            function (response,textStatus, jqXHR) {
                if(response.status == "1")
                {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    build_url_iframe($data, $refresh);
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }

            }, 'JSON').done(function() {
        });
    });

    $(document).on('click', '#save_codes_before_head', function (e) {
        e.preventDefault();
        var post_url=base_url+'ecommerce_builder/ecommerce_marketing_save_new/'+$('body').attr("data-id")+'/head';
        var data_codes_before_head = JSON.stringify($('#codes_before_head').val());
        $.post(post_url, {csrf_token: csrf_token, codes_before_body: data_codes_before_head},
            function (response,textStatus, jqXHR) {
                if(response.status == "1")
                {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    build_url_iframe($data, $refresh);
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }

            }, 'JSON').done(function() {
        });
    });

    $(document).on('click', '#save_codes_custom_css', function (e) {
        e.preventDefault();
        var post_url=base_url+'ecommerce_builder/ecommerce_save_codes_custom_css/'+$('body').attr("data-id");
        var data_codes_custom_css = JSON.stringify($('#codes_custom_css').val());
        $.post(post_url, {csrf_token: csrf_token, data_codes_custom_css: data_codes_custom_css},
            function (response,textStatus, jqXHR) {
                if(response.status == "1")
                {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    build_url_iframe($data, $refresh);
                } else
                {
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    });
                }

            }, 'JSON').done(function() {
        });
    });

    new PerfectScrollbar('#scroll_this', {suppressScrollX: true});

    var pipsRange = document.getElementById('pips-range');
    var pipsStepsFilter = document.getElementById('pips-steps-filter');
    var direction = 'ltr';

    var range_all_sliders = {
        'min': [3],
        'max': [8],
    };

    if (typeof pipsRange !== undefined && pipsRange !== null) {
        noUiSlider.create(pipsRange, {
            range: range_all_sliders,
            direction: direction,
            start: 0,
            behaviour: 'drag',
            step: 1,
            pips: {
                mode: 'steps',
                density: 1
            }
        });

        pipsRange.noUiSlider.set(category_perpage);

        pipsRange.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
            string = '"category_perpage":"'+Math.round(values[handle])+'"';
            if(Math.round(values[handle])!=category_perpage){
               send_save(string);
                category_perpage=Math.round(values[handle]);
            }
        });
    };

    var front_featured_products_pipe = document.getElementById('front_featured_products_rows');
    if (typeof front_featured_products_pipe !== undefined && front_featured_products_pipe !== null) {
        noUiSlider.create(front_featured_products_pipe, {
            range: range_all_sliders,
            direction: direction,
            start: 0,
            behaviour: 'drag',
            step: 1,
            pips: {
                mode: 'steps',
                density: 1
            }
        });

        front_featured_products_pipe.noUiSlider.set(front_featured_products_rows);

        front_featured_products_pipe.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
            string = '"front_featured_products_rows":"'+Math.round(values[handle])+'"';
            if(Math.round(values[handle])!=front_featured_products_rows){
               send_save(string);
                front_featured_products_rows=Math.round(values[handle]);
            }
        });
    }

    var front_deals_products_pipe = document.getElementById('front_deals_products_rows');
    if (typeof front_deals_products_pipe !== undefined && front_deals_products_pipe !== null) {
        noUiSlider.create(front_deals_products_pipe, {
            range: range_all_sliders,
            direction: direction,
            start: 0,
            behaviour: 'drag',
            step: 1,
            pips: {
                mode: 'steps',
                density: 1
            }
        });

        front_deals_products_pipe.noUiSlider.set(front_deals_products_rows);

        front_deals_products_pipe.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
            string = '"front_deals_products_rows":"'+Math.round(values[handle])+'"';
            if(Math.round(values[handle])!=front_deals_products_rows){
               send_save(string);
                front_deals_products_rows=Math.round(values[handle]);
            }
        });
    }

    var front_sales_products_pipe = document.getElementById('front_sales_products_rows');
    if (typeof front_sales_products_pipe !== undefined && front_sales_products_pipe !== null) {
        noUiSlider.create(front_sales_products_pipe, {
            range: range_all_sliders,
            direction: direction,
            start: 0,
            behaviour: 'drag',
            step: 1,
            pips: {
                mode: 'steps',
                density: 1
            }
        });

        front_sales_products_pipe.noUiSlider.set(front_sales_products_rows);

        front_sales_products_pipe.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
            string = '"front_sales_products_rows":"'+Math.round(values[handle])+'"';
            if(Math.round(values[handle])!=front_sales_products_rows){
               send_save(string);
                front_sales_products_rows=Math.round(values[handle]);
            }
        });
    }

    var new_products_rows_pipe = document.getElementById('new_products_rows');
    if (typeof new_products_rows_pipe !== undefined && new_products_rows_pipe !== null) {
        noUiSlider.create(new_products_rows_pipe, {
            range: range_all_sliders,
            direction: direction,
            start: 0,
            behaviour: 'drag',
            step: 1,
            pips: {
                mode: 'steps',
                density: 1
            }
        });

        new_products_rows_pipe.noUiSlider.set(new_products_rows);

        new_products_rows_pipe.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
            string = '"new_products_rows":"'+Math.round(values[handle])+'"';
            if(Math.round(values[handle])!=new_products_rows){
                send_save(string);
                new_products_rows=Math.round(values[handle]);
            }
        });
    }

    var product_single_width_0_items_related_pipe = document.getElementById('product_single_width_0_items_related');
    var product_single_width_576_items_related_pipe = document.getElementById('product_single_width_576_items_related');
    var product_single_width_768_items_related_pipe = document.getElementById('product_single_width_768_items_related');
    var product_single_width_992_items_related_pipe = document.getElementById('product_single_width_992_items_related');

    function create_slider_numbers($string, $string2, $string3){
        if (typeof $string !== undefined && $string !== null) {
            noUiSlider.create($string, {
                range: range_all_sliders,
                direction: direction,
                start: 0,
                behaviour: 'drag',
                step: 1,
                pips: {
                    mode: 'steps',
                    density: 1
                }
            });

            $string.noUiSlider.set($string3);

            $string.noUiSlider.on('update', function (values, handle, unencoded, isTap, positions) {
                string = '"'+$string2+'":"'+Math.round(values[handle])+'"';
                if(Math.round(values[handle])!=$string3){
                    send_save(string);
                    $string3=Math.round(values[handle]);
                }
            });
        }

    }

    create_slider_numbers(product_single_width_0_items_related_pipe, 'product_single_width_0_items_related',product_single_width_0_items_related);
    create_slider_numbers(product_single_width_576_items_related_pipe, 'product_single_width_576_items_related', product_single_width_576_items_related);
    create_slider_numbers(product_single_width_768_items_related_pipe, 'product_single_width_768_items_related', product_single_width_768_items_related);
    create_slider_numbers(product_single_width_992_items_related_pipe, 'product_single_width_992_items_related', product_single_width_992_items_related);


    $('#front_sortable').sortable({
        axis: 'y',
        update: function (event, ui) {
            var data = $(this).sortable('toArray');

            var save_data = '';
            data.forEach(function( index ) {
                save_data = save_data + index + ",";
            });

            string = '"front_order":"'+save_data+'"';
            send_save(string);
        }
    });

    $(document).on('click', '.show_home', function (e) {
        e.preventDefault();
        build_url_iframe('');
    });

    $(document).on('click', '.action_iframe', function (e) {
        e.preventDefault();
        var frame = document.getElementById("if_scroll");
        frame.src = $(this).attr('data-action');
    });

    $(document).on('click','#variables',function(e){
        e.preventDefault();

        var success_message= '{{order_no}}<br/>{{customer_info}}<br/>{{product_info}}<br/>{{order_status}}<br/>{{order_url}}<br/>{{payment_method}}<br/>{{tax}}<br/>{{total_price}}<br/>{{delivery_address}}';
        var span = document.createElement("span");
        span.innerHTML = success_message;
        swal.fire({ title:Variables_lang, html:span,icon:'info'});
    });

        $(".select2").select2({
            dropdownAutoWidth: true,
            width: '100%'
        });

    $('#store_lang').on("change", function(e) {
        var store_lang = '';
        $.each( $('#store_lang').val(), function(index, value) {
            store_lang = store_lang+value+',';
        });
        string = '"store_lang":"'+store_lang+'"';
        send_save(string);
    });

    $(document).on('click','.copy_to',function(e){
        e.preventDefault();
        var file_data = $(this).attr('data-file');

        swal.fire({
            title: copy_to_header,
            input: 'select',
            inputOptions: swal_copy_to_langs,
            inputPlaceholder: copy_to_select,
            showCancelButton: true,
        }).then(function (result) {
            if (result.dismiss != 'cancel') {
                var post_url=base_url+'ecommerce_builder/copy_to/'+$('body').attr("data-id")+'/'+result.value;
                if(result.value==''){
                    swal.fire(warning, copy_to_you_need, 'warning');
                }else{
                    $.post(post_url, {csrf_token: csrf_token, file: file_data},
                        function (response,textStatus, jqXHR) {
                            if(response.status == "1"){
                                swal.fire({ title:success, html:response.message,icon:'success'});
                            }else{
                                swal.fire({ title:error, html:response.message,icon:'error'});
                            }
                        }, 'JSON').done(function() {
                    });
                }
            }
        });
    });


});