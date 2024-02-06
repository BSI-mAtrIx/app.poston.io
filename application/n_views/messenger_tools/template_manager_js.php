<script>
    var base_url = "<?php echo site_url(); ?>";

    var visual_flow_builder_exist = "<?php echo $visual_flow_builder_exist; ?>";
    var page_id = "<?php echo $page_id; ?>";
    if (visual_flow_builder_exist == 'yes')
      var shortable_column = [0,1,2,4,6];
    else
      var shortable_column = [0,1,2,4,5];

    <?php if(!empty($page_info) and $page_id != 0 and $iframe == 0){ ?>
    $('#bot_list_select').val('<?php echo $page_id; ?>');
    <?php } ?>

    $(document).on('change', '#bot_list_select', function (event) {
        window.location.href = base_url + 'messenger_bot/template_manager/' + $('#bot_list_select').val();
    });

    $(document).ready(function () {
        var areWeUsingScroll = false;
        //todo: areWeUsingScroll
        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });

        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[2, "desc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'messenger_bot/template_manager_data',
                type: 'POST',
                data: function (d) {
                    d.page_id = page_id;
                    d.template_media_type = $('#template_media_type').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 2],
                    visible: false
                },
                {
                    targets: '',
                    className: 'text-center'
                },
                {
                    targets: shortable_column,
                    sortable: false
                },
                {
                    targets: [6],
                    "render": function (data, type, row) {
                        <?php if($iframe==0){echo "data = data.replaceAll('/1/0/', '/0/0/');";} ?>
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
                        data = data.replaceAll('fas fa-play', 'bx bx-play');
                        data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                        data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                        data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                        data = data.replaceAll('swal.fire(', 'swal.fire(');
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

                        return data;
                    },
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
            }
        });


        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document).on('click', '.get_json_code', function (event) {
            event.preventDefault();
            var waiting_content = '<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size: 40px;"></i></div>';
            var table_id = $(this).attr('table_id');
            $('#get_json_code_modal_body').html(waiting_content);
            $('#get_json_code').modal();

            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo base_url('messenger_bot/get_json_code'); ?>",
                // dataType: 'json',
                data: {table_id: table_id},
                success: function (response) {
                    $('#get_json_code_modal_body').html(response);
                }
            });
        });

        $(document).on('change', '#page_id', function (event) {
            event.preventDefault();
            table.draw();
        });

        $(document).on('click', '.delete_template', function (e) {
            e.preventDefault();

            swal.fire({
                title: '<?php echo $this->lang->line("Delete!"); ?>',
                text: '<?php echo $this->lang->line("Do you want to detete this template?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var base_url = '<?php echo site_url();?>';
                        $(this).addClass('btn-progress');
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>messenger_bot/ajax_delete_template_info",
                            // dataType: 'json',
                            data: {table_id: table_id},
                            success: function (response) {
                                $(this).removeClass('btn-progress');
                                if (response == 'success') {
                                    iziToast.success({
                                        title: '',
                                        message: '<?php echo $this->lang->line("Template has been deleted successfully."); ?>',
                                        position: 'bottomRight'
                                    });
                                    table.draw();
                                } else if (response == 'no_match') {
                                    iziToast.error({
                                        title: '',
                                        message: '<?php echo $this->lang->line("No Template is found for this user with this ID."); ?>',
                                        position: 'bottomRight'
                                    });
                                } else {
                                    $("#delete_template_modal_body").html(response);
                                    $("#delete_template_modal").modal();
                                }
                            }
                        });
                    }
                });


        });

        $('#add').click(function (e) {
            e.preventDefault();
            $('#dynamic_field_modal').modal('show');
        });

        $('#submit').click(function (e) {
            e.preventDefault();
            var page_id_media = $('#page_table_id').val();
            var page_id_media_array = page_id_media.split("-");

            var page_table_id = page_id_media_array[0];
            var media_type = 'fb';
            if (typeof page_id_media_array[1] !== 'undefined') {
                media_type = page_id_media_array[1];
            }

            if (page_table_id == '') {
                swal.fire('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("You have to select a page"); ?>', 'warning');
                return false;
            } else {
                var link = base_url + "visual_flow_builder/load_builder/" + page_table_id + "/0/" + media_type;
                window.location.replace(link);
            }

        });

        $(document).on('click', '.edit_reply_info', function (event) {
            event.preventDefault();
            var table_id = $(this).attr('table_id');
            var media_type = $(this).attr('media_type');
            var link = base_url + "visual_flow_builder/edit_builder_data/" + table_id + "/2/" + media_type;
            window.location.replace(link);
        });


    });


</script>