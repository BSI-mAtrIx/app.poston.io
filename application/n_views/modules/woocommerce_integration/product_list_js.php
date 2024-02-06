<script>

    var base_url = "<?php echo site_url(); ?>";

    var perscroll;
    var table1 = '';
    var woocommerce_config_id = '<?php echo $config_id;?>';
    table1 = $("#mytable").DataTable({
        serverSide: true,
        processing: true,
        bFilter: false,
        order: [[3, "asc"]],
        pageLength: 10,
        ajax: {
            url: base_url + 'woocommerce_integration/product_list_data',
            type: 'POST',
            data: function (d) {
                d.search_store_id = $('#search_store_id').val();
                d.search_value = $('#search_value').val();
            }
        },
        language:
            {
                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        columnDefs: [
            {
                targets: [2, 4, 5, 6],
                className: 'text-center'
            },
            {
                targets: [1, 2, 5],
                sortable: false
            },
            {
                targets: [5],
                "render": function (data, type, row) {
                    data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                    data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                    data = data.replaceAll('fas fa-map', 'bx bx-map');
                    data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                    data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                    data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                    data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                    data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
                    data = data.replaceAll('fas fa-code', 'bx bx-code');
                    data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                    data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                    data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                    data = data.replaceAll('far fa-copy', 'bx bx-copy');
                    data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                    data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                    data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                    data = data.replaceAll('fas fa-eye', 'bx bxs-show');

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


    $("document").ready(function () {

        $(document).on('keypress', '#search_value', function (e) {
            if (e.which == 13) $("#search_action").click();
        });

        $(document).on('click', '#search_action', function (event) {
            event.preventDefault();
            table1.draw();
        });

        $(document).on('click', '#export_to_ecommerce', function (event) {
            event.preventDefault();
            var ids = [];
            $(".datatableCheckboxRow:checked").each(function () {
                ids.push(parseInt($(this).val()));
            });
            var selected = ids.length;
            if (selected == 0) {
                swal.fire('<?php echo $this->lang->line("Warning") ?>', '<?php echo $this->lang->line("You have not selected any product to export."); ?>', 'warning');
                return;
            }
            if (selected > 50) {
                swal.fire('<?php echo $this->lang->line("Warning") ?>', '<?php echo $this->lang->line("You can export maximum 50 products at a time"); ?>', 'warning');
                return;
            }
            $("#export_modal").modal();
        });

        $(document).on('click', '#export_now', function (event) {
            event.preventDefault();
            var ids = [];
            $(".datatableCheckboxRow:checked").each(function () {
                ids.push(parseInt($(this).val()));
            });
            var selected = ids.length;
            if (selected == 0) return;
            var store_id = $("#store_id").val();
            if (store_id == "") {
                swal.fire('<?php echo $this->lang->line("Warning") ?>', '<?php echo $this->lang->line("Please select ecommerce store."); ?>', 'warning');
                return;
            }

            $(this).addClass('btn-progress');

            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo site_url();?>woocommerce_integration/export_product",
                dataType: 'json',
                data: {store_id, ids, woocommerce_config_id},
                success: function (response) {

                    $(this).removeClass('btn-progress');

                    if (response.status == 1) {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                            location.reload();
                        });

                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }
            });

        });

    });

</script>