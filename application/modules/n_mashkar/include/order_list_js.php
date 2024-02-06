<script>
    $(document).on('click', '.open_mashkor', function(e){
        $('#mashkor_modal').modal();

        //add loader

        var post_cart_id = $(this).attr('data-order_id');
        $('#mashkor_type input').val('');
        $('#post_cart_id').val(post_cart_id);
        $.ajax({
            context: this,
            type: 'POST',
            dataType: 'JSON',
            url: "<?php echo base_url('n_mashkar/get_order_details')?>",
            data: {cart_id: post_cart_id, csrf_token: csrf_token},
            success: function (response) {
                if(response.status==0){
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                }

                data_resp = response.message;

                $('#customer_name').val(data_resp.first_name+' '+data_resp.last_name);
                $('#mobile_number').val(data_resp.mobile);
                if(data_resp.mashkor_type == 1 || data_resp.mashkor_type == 2){
                    $('#amount_to_collect').val(data_resp.payment_amount);
                }
                $('#street').val(data_resp.address);
                $('#latitude').val(data_resp.lat);
                $('#longitude').val(data_resp.lng);
                $('#vendor_order_id').val(data_resp.vendor_id);

                $('#mashkor_type').val(data_resp.mashkor_type);

                $('#mashkor_type .alert').hide();
                $('#mashkor_type #mashkor_type_'+data_resp.mashkor_type).show();
                $('#area').val(data_resp.city);

                $('#landmark').val(data_resp.mashkor.mash_landmark);
                $('#block').val(data_resp.mashkor.mash_block);
                $('#building').val(data_resp.mashkor.mash_building);
                $('#room_number').val(data_resp.mashkor.mash_room_number);

            }
        });
    });

    $(document).on('click', '#mashkor_create_order', function(e){
        e.preventDefault();

        $('#mashkor_modal').block({
            message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
            timeout: 2000, //unblock after 2 seconds
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });

        var post_cart_id = $('#post_cart_id').val();
        var mashkor_type = $('#mashkor_type').val();
        var customer_name = $('#customer_name').val();
        var mobile_number = $('#mobile_number').val();
        var amount_to_collect = $('#amount_to_collect').val();
        var vendor_order_id = $('#vendor_order_id').val();
        var latitude = $('#latitude').val();
        var longitude = $('#longitude').val();
        var landmark = $('#landmark').val();
        var area = $('#area').val();
        var block = $('#block').val();
        var street = $('#street').val();
        var building = $('#building').val();
        var room_number = $('#room_number').val();

        $.ajax({
            context: this,
            type: 'POST',
            dataType: 'JSON',
            url: "<?php echo base_url('n_mashkar/create_order')?>",
            data: {
                cart_id: post_cart_id,
                mashkor_type: mashkor_type,
                customer_name: customer_name,
                mobile_number: mobile_number,
                amount_to_collect: amount_to_collect,
                vendor_order_id: vendor_order_id,
                latitude: latitude,
                longitude: longitude,
                landmark: landmark,
                area: area,
                block: block,
                street: street,
                building: building,
                room_number: room_number,
                csrf_token: csrf_token
            },
            success: function (response) {
                $.unblockUI();

                if(response.status==0){
                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                }

                if(response.status==1){
                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success');

                    $('#mashkor_modal').modal('hide');
                }

            }
        });
    });


</script>