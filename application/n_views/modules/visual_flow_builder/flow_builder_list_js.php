<script>
    $(document).ready(function () {

        var base_url = "<?php echo base_url(); ?>";
        var page_auto_id = "<?php echo $page_auto_id; ?>";
        if (page_auto_id != 0)
            var data_url = base_url + 'visual_flow_builder/visual_flow_builder_data/' + page_auto_id;
        else
            var data_url = base_url + 'visual_flow_builder/visual_flow_builder_data';

        // datatable section started
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": data_url,
                    "type": 'POST',
                    "dataSrc": function (json) {
                        //$(".table-responsive").niceScroll();
                        return json.data;
                    }
                },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 3, 4],
                    visible: false
                },
                {
                    targets: [0, 5],
                    className: 'text-center',
                    sortable: false
                },
                {
                    targets: [4],
                    "render": function (data, type, row, meta) {
                        var media_type = row[4];
                        var str = '';
                        if (media_type == 'ig')
                            str = 'Instagram';
                        else
                            str = 'Facebook';
                        return str;
                    }
                },
                {
                    targets: [5],
                    "render": function (data, type, row, meta) {
                        var is_system = row[5];
                        var id = row[1];
                        var media_type = row[4];
                        var edit_str = "<?php echo $this->lang->line('Edit');?>";
                        var delete_str = "<?php echo $this->lang->line('Delete');?>";
                        var str = "";
                        var edit_url = base_url + "visual_flow_builder/edit_builder_data/" + id + "/1/" + media_type;
                        str = "&nbsp;<a target='_blank' class='text-center btn btn-circle btn-outline-warning' href='" + edit_url + "' title='" + edit_str + "'>" + '<i class="bx bx-edit"></i>' + "</a>";
                        if (is_system != 1)
                            str = str + "&nbsp;<a name='delete' href='#' class='text-center delete_data btn btn-circle btn-outline-danger ' title='" + delete_str + "' table_id=" + id + " '>" + '<i class="bx bx-trash"></i>' + "</a>";

                        return str;
                    }
                }
            ]
        });
        // End of datatable section

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
                var link = base_url + "visual_flow_builder/load_builder/" + page_table_id + "/1/" + media_type;
                window.location.replace(link);
            }

        });

        $(document).on('click', '.edit_reply_info', function (event) {
            event.preventDefault();
            var table_id = $(this).attr('table_id');
            var media_type = $(this).attr('media_type');
            var link = base_url + "visual_flow_builder/edit_builder_data/" + table_id + "/1/" + media_type;
            window.location.replace(link);
        });


        $(document).on('click', '.delete_data', function (event) {
            event.preventDefault();
            swal.fire({
                title: '<?php echo $this->lang->line("Warning"); ?>',
                text: '<?php echo $this->lang->line("Are you sure you want to delete this campaign"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willreset) => {
                    if (willreset.isDenied || willreset.isDismissed) {
                        return;
                    }
                    if (willreset.isConfirmed) {
                        $(this).addClass('btn-progress');
                        var table_id = $(this).attr('table_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: base_url + "visual_flow_builder/delete_flowbuilder_data",
                            dataType: 'json',
                            data: {table_id},
                            success: function (response) {
                                if (response.status == 1) {
                                    $(this).removeClass('btn-progress');

                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                                        table.draw();
                                    });
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            },
                            error: function (response) {
                                var span = document.createElement("span");
                                span.innerHTML = response.responseText;
                                swal.fire({
                                    title: '<?php echo $this->lang->line("Error!"); ?>',
                                    html: span,
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
        });


    });
</script>