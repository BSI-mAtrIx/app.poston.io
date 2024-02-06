
<script>
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {

        $('[data-toggle=\"tooltip\"]').tooltip();

        var drop_menu = '<?php echo $drop_menu;?>';
        setTimeout(function () {
            $("#mytable_filter").append(drop_menu);
        }, 1000);


        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[2, "asc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'custom_cname/delivery_methods_list_data',
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
            var delivery_name = $("#delivery_name").val();

            if (store_id == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Store is required"); ?>', 'warning');
                return;
            }

            if (delivery_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Delivery name is required"); ?>', 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);

            var alldatas = new FormData($("#row_add_form")[0]);

            $.ajax({
                url: base_url + 'custom_cname/ajax_create_new_delivery_methods',
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
                url: base_url + 'custom_cname/ajax_get_delivery_methods_update_info',
                type: 'POST',
                dataType: 'JSON',
                data: {table_id: table_id},
                success: function (response) {
                    $("#edit_delivery_name").val(response.name);
                    $("#edit_default_price").val(response.default_price);

                    $("#edit_table_id").val(response.id);


                    if(response.cod==1){
                        $("#edit_cod").prop( "checked", true );
                    }else{
                        $("#edit_cod").prop( "checked", false );
                    }

                    if(response.enabled==1){
                        $("#edit_enable").prop( "checked", true );
                    }else{
                        $("#edit_enable").prop( "checked", false );
                    }

                    <?php
                    if(file_exists(APPPATH.'/modules/n_mashkar/controllers/N_mashkar.php')){ ?>

                    if(response.mashkor.mashkor_cod_card=='on'){
                        $("#update_mashkor_cod_card").prop( "checked", true );
                    }else{
                        $("#update_mashkor_cod_card").prop( "checked", false );
                    }

                    if(response.mashkor.mashkor_cod_cash=='on'){
                        $("#update_mashkor_cod_cash").prop( "checked", true );
                    }else{
                        $("#update_mashkor_cod_cash").prop( "checked", false );
                    }

                    if(response.mashkor.mashkor_online=='on'){
                        $("#update_mashkor_online").prop( "checked", true );
                    }else{
                        $("#update_mashkor_online").prop( "checked", false );
                    }

                    <?php } ?>

                }
            })
        });


        $(document).on('click', '#update_row', function (event) {
            event.preventDefault();

            var category_name = $("#category_name2").val();

            if (category_name == "") {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Category name is required"); ?>', 'warning');
                return;
            }

            $(this).addClass('btn-progress')
            var that = $(this);


            var alldatas = new FormData($("#row_update_form")[0]);

            $.ajax({
                url: base_url + 'custom_cname/ajax_update_delivery_methods',
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
                            url: "<?php echo base_url('custom_cname/delete_delivery_methods')?>",
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

        $("#mashkor_cod_cash, #mashkor_cod_card").on('change', function () {
            $("#cod").prop('checked', true);
        });

        $("#mashkor_online").on('change', function () {
            $("#cod").prop('checked', false);
        });

        $("#mashkor_cod_cash, #mashkor_cod_card, #mashkor_online").on('change', function (e) {
            let mashkid = $(this);
            if(mashkid.attr('id')!='mashkor_cod_card'){
                $("#mashkor_cod_card").prop('checked', false);
            }
            if(mashkid.attr('id')!='mashkor_cod_cash'){
                $("#mashkor_cod_cash").prop('checked', false);
            }
            if(mashkid.attr('id')!='mashkor_online'){
                $("#mashkor_online").prop('checked', false);
            }
        });

        $("#update_mashkor_cod_cash, #update_mashkor_cod_card").on('change', function () {
            $("#edit_cod").prop('checked', true);
        });

        $("#update_mashkor_online").on('change', function () {
            $("#edit_cod").prop('checked', false);
        });

        $("#update_mashkor_cod_cash, #update_mashkor_cod_card, #update_mashkor_online").on('change', function (e) {
            let mashkid = $(this);
            if(mashkid.attr('id')!='update_mashkor_cod_card'){
                $("#update_mashkor_cod_card").prop('checked', false);
            }
            if(mashkid.attr('id')!='update_mashkor_cod_cash'){
                $("#update_mashkor_cod_cash").prop('checked', false);
            }
            if(mashkid.attr('id')!='update_mashkor_online'){
                $("#update_mashkor_online").prop('checked', false);
            }
        });

    });
</script>