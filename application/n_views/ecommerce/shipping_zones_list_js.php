
<script>
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {

        $('[data-toggle=\"tooltip\"]').tooltip();

        var drop_menu = '<?php echo $drop_menu;?>';
        setTimeout(function () {
            $("#mytable_filter").append(drop_menu);
        }, 1000);

        function check_req_state($button){
            $state_check = $($button+'required_state').prop('checked');
            $state_field = $($button+'states_list').val();
            if($state_check == true && $state_field==''){
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Before enable required state option you need define state list."); ?>', 'warning');
                $($button+'required_state').prop('checked', false)
            }
        }

        $(document).on('click', '#edit_required_state', function (event) {
            check_req_state('#edit_');
        });

        $(document).on('click', '#required_state', function (event) {
            check_req_state('#');
        });




        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[2, "asc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'custom_cname/shipping_zone_list_data',
                type: 'POST'
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: [3],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 3],
                    sortable: false
                },
                {
                    targets: [3],
                    "render": function (data, type, row) {
                        data = data.replaceAll('text-success', '');
                        return data;
                    }
                },
            ],
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
            },
            "drawCallback": function (settings) {
                $('table [data-toggle="tooltip"]').tooltip('dispose');
                $('table [data-toggle="tooltip"]').tooltip(
                    {
                        placement: 'left',
                        container: 'body',
                        html: true,
                        template: '<div class="tooltip tooltip_pd" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    }
                );
            }

        });
        var editor = null;
        $(document).on('click', '#add_new_row', function (event) {
            event.preventDefault();
            $("#add_row_form_modal").modal();

            $(".country_list").select2({
                tags: false,
                tokenSeparators: [',', ' '],
                width: '100%',
                multiple: true,
                placeholder: "<?php echo $this->lang->line('Choose Options');?>",
            }).val('').change();

            $('.states_list').select2({
                placeholder: '<?php echo $this->lang->line('Search or type state'); ?>',
                width: '100%',
                tags: true,
                tokenSeparators: [',', ' '],

                multiple: true,
                ajax: {
                    delay: 400,
                    url: base_url + 'custom_cname/ajax_get_states_shipping_zone/',
                    type: "POST",
                    dataType: 'json',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            csrf_token: '<?php echo $this->session->userdata('csrf_token_session'); ?>',
                            country_ids: $(".country_list").val()
                        }

                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: data.data
                        };
                    }
                }
            }).val('').change();
        });
        $('textarea').each(function () {
            <?php if($jodit_cg){
            echo "editor = Jodit.make(this, {
                                    disablePlugins: [
                                        'about'
                                    ],
                                    buttons: [
                                        ...Jodit.defaultOptions.buttons,
                                    ],
                                    extraButtons: ext_butt
                });";
        }else{
            echo 'var editor = new Jodit(this);';
        } ?>
        });

        $(document).on('click', '#save_row', function (event) {
            event.preventDefault();

            var store_id = $("#store_id").val();
            var delivery_name = $("#zone_name").val();
            var country_list = $(".country_list").val();

            if (store_id == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Store is required"); ?>', 'warning');
                return;
            }

            if (delivery_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Shipping zone name is required"); ?>', 'warning');
                return;
            }

            if (country_list == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Country list is required"); ?>', 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var $country_list = {};
            for (var value_id of $('.country_list').val()) {
                $country_list[value_id]  = get_country_name(value_id);
            }
            $('#country_list_ids').val(JSON.stringify($country_list));

            var $states_list = {};
            for (var val of $('.states_list').select2('data')) {
                $states_list[val.id]  = val.text;
            }
            $('#states_list_ids').val(JSON.stringify($states_list));



            var alldatas = new FormData($("#row_add_form")[0]);

            $.ajax({
                url: base_url + 'custom_cname/ajax_create_new_shipping_zone',
                type: 'POST',
                dataType: 'JSON',
                data: alldatas,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');

                    if (response.status == "1") {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});

                    } else {
                        iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                    }
                    $("#add_row_form_modal").modal('hide');

                }
            })

        });

        $(document).on('click', '.edit_row', function (event) {
            event.preventDefault();
            $("#update_row_form_modal").modal();

            var table_id = $(this).attr("table_id");
            var loading = '<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size:40px"></i></div>';
            $("#update_contact_modal_body").html(loading);

            $.ajax({
                url: base_url + 'custom_cname/ajax_get_shipping_zone_update_info',
                type: 'POST',
                dataType: 'JSON',
                data: {table_id: table_id},
                success: function (response) {

                    $("#edit_country_list_ids").val('');
                    $("#edit_states_list_ids").val('');
                    $("#edit_zone_name").val('');
                    $("#edit_worldwide").val(0);


                    $("#edit_country_list").val('');
                    $("#edit_states_list").val('');

                    $(".edit_delivery_methods .active_off").prop( "checked", false );


                    $(".edit_delivery_methods .price_set_to_default").each(function( index, value ) {
                        var $this = $(this);

                        $this.val($this.attr('data-default-price'));
                    });

                    $("#edit_zone_name").val(response.name);
                    $("#edit_table_id").val(response.id);
                    $("#edit_worldwide").val(response.worldwide);

                    if(response.allow_order==1){
                        $("#edit_allow_order").prop( "checked", true );
                    }else{
                        $("#edit_allow_order").prop( "checked", false );
                    }

                    // country  delivery_methods  states

                    var c_data = {};
                    var results = [];
                    var c_val = [];

                    if(response.country!=''){
                        $.each(JSON.parse(response.country), function( index, value ) {
                            var new_data = {};
                            new_data['id'] = index;
                            new_data['text'] = value;
                            new_data['selected'] = true;
                            results[index] = new_data;
                            c_val.push(index);
                        });
                        c_data = results;
                    }


                        $(".edit_country_list").select2({
                            tags: false,
                            tokenSeparators: [',', ' '],
                            width: '100%',
                            multiple: true,
                            placeholder: "<?php echo $this->lang->line('Choose Options');?>",
                            //data: c_data
                        }).val(c_val).change();


                    var s_data = {};
                    var results = [];
                    var i = 0
                    var s_val = [];

                    if(response.states!='') {
                        $.each(JSON.parse(response.states), function (index, value) {
                            var new_data = {};
                            new_data['id'] = index;
                            new_data['text'] = value;
                            new_data['selected'] = true;
                            results[i] = new_data;
                            i = i+1;
                            s_val.push(index);
                        });
                        s_data = results;
                    }

                    console.log(s_data);

                    $(".edit_states_list").val(null).trigger('change');

                    $(".edit_states_list").select2({
                        tags: true,
                        tokenSeparators: [',', ' '],
                        width: '100%',
                        multiple: true,
                        placeholder: "<?php echo $this->lang->line('Choose Options');?>",
                        data: s_data,
                        ajax: {
                            delay: 400,
                            url: base_url + 'custom_cname/ajax_get_states_shipping_zone/',
                            type: "POST",
                            dataType: 'json',
                            data: function (params) {
                                var query = {
                                    search: params.term,
                                    csrf_token: '<?php echo $this->session->userdata('csrf_token_session'); ?>',
                                    country_ids: $(".edit_country_list").val()
                                }

                                return query;
                            },
                            processResults: function (data) {
                                return {
                                    results: data.data
                                };
                            }
                        }
                    });

                    if(response.states=='') {
                        $(".edit_states_list").val(null).trigger('change');
                    }else{
                        $(".edit_states_list").val(s_val).trigger('change');
                    }

                    if(response.required_state==1){
                        $("#edit_required_state").prop( "checked", true );
                    }else{
                        $("#edit_required_state").prop( "checked", false );
                    }

                    if(response.active==1){
                        $("#edit_active").prop( "checked", true );
                    }else{
                        $("#edit_active").prop( "checked", false );
                    }


                    $.each(JSON.parse(response.delivery_methods), function( index, value ) {

                        $('#edit_payment_'+index+'_price').val(value.price);

                        if(value.active==1){
                            $('#edit_payment_'+index+'_active').prop( "checked", true );
                        }else{
                            $('#edit_payment_'+index+'_active').prop( "checked", false );
                        }
                    });

                }
            })
        });



        $(document).on('click', '#update_row', function (event) {
            event.preventDefault();

            $(this).addClass('btn-progress')
            var that = $(this);


            var delivery_name = $("#edit_zone_name").val();
            var country_list = $(".edit_country_list").val();

            if (delivery_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Shipping zone name is required"); ?>', 'warning');
                return;
            }

            if (country_list == '' && $("#edit_worldwide").val()==0) {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Country list is required"); ?>', 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var $country_list = {};

                for (var value_id of $('.edit_country_list').val()) {
                    $country_list[value_id]  = get_country_name(value_id);
                }
                $('#edit_country_list_ids').val(JSON.stringify($country_list));


            var $states_list = {};
            for (var val of $('.edit_states_list').select2('data')) {
                $states_list[val.id]  = val.text;
            }
            $('#edit_states_list_ids').val(JSON.stringify($states_list));


            var alldatas = new FormData($("#row_update_form")[0]);

            $.ajax({
                url: base_url + 'custom_cname/ajax_update_shipping_zone',
                type: 'POST',
                dataType: 'JSON',
                data: alldatas,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $(that).removeClass('btn-progress');

                    if (response.status == "1") {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});

                    } else {
                        iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                    }
                    $("#update_row_form_modal").modal('hide');

                }
            })

        });

        var Doyouwanttodeletethisrecordfromdatabase = "<?php echo $this->lang->line('Do you want to detete this record?'); ?>";
        $(document).on('click', '.delete_row', function (e) {
            e.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure?"); ?>',
                text: Doyouwanttodeletethisrecordfromdatabase,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            dataType: 'JSON',
                            url: "<?php echo base_url('custom_cname/delete_shipping_zone')?>",
                            data: {table_id: table_id},
                            success: function (response) {
                                if (response.status == '1') {
                                    iziToast.success({
                                        title: '',
                                        message: response.message,
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                } else {
                                    iziToast.error({
                                        title: '',
                                        message: response.message,
                                        position: 'bottomRight',
                                        timeout: 3000
                                    });
                                }
                                table.draw(false);
                            }
                        });
                    }
                });
        });


        // $("#add_row_form_modal").on('hidden.bs.modal', function ()
        // {
        //     $("#row_add_form").trigger('reset');
        //     table.draw();
        // });

        $("#add_row_form_modal").on('hidden.bs.modal', function (event) {
            event.preventDefault();
            $("#row_add_form").trigger('reset');
            table.draw();
        });

        $("#update_row_form_modal").on('hidden.bs.modal', function () {
            table.draw(false);
        });


    });

    function get_country_name($id){
        $array_c = <?php echo json_encode($country_list); ?>

        return $array_c[$id];
    }
</script>