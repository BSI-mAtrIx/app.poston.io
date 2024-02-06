<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/modules/chocolat/dist/css/chocolat.css?ver=<?php echo $n_config['theme_version']; ?>">
<script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script>

    var base_url = "<?php echo site_url(); ?>";
    var search_param = "<?php echo $search_param;?>";
    var csrf_token = "<?php echo $this->session->userdata('csrf_token_session');?>";


    $('#search_date_range').daterangepicker({
        locale: daterange_locale,
        ranges: {
            '<?php echo $this->lang->line("Last 30 Days");?>': [moment().subtract(29, 'days'), moment()],
            '<?php echo $this->lang->line("This Month");?>': [moment().startOf('month'), moment().endOf('month')],
            '<?php echo $this->lang->line("Last Month");?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    }, function (start, end) {
        $('#search_date_range_val').val(start.format('YYYY-M-D') + '|' + end.format('YYYY-M-D')).change();
    });

    var perscroll;
    var table1 = '';
    table1 = $("#mytable").DataTable({
        serverSide: true,
        processing: true,
        bFilter: false,
        order: [[12, "desc"]],
        pageLength: 10,
        ajax: {
            url: base_url + 'ecommerce/order_list_data',
            type: 'POST',
            data: function (d) {
                d.search_store_id = $('#search_store_id').val();
                d.search_status = $('#search_status').val();
                d.search_value = $('#search_value').val();
                d.search_date_range = $('#search_date_range_val').val();
            }
        },
        language:
            {
                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        columnDefs: [
            {
                targets: [1, 3, 5],
                visible: false
            },
            {
                targets: [0, 2, 4, 7, 8, 9, 10, 11, 12, 13],
                className: 'text-center'
            },
            {
                targets: [5, 6],
                className: 'text-right'
            },
            {
                targets: [0, 4, 8, 10],
                sortable: false
            },
            {
                targets: [8, 10],
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
                    data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                    data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                    data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                    data = data.replaceAll('fas fa-briefcase', 'bx bx-briefcase');
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
                    data = data.replaceAll('fas fa-male', 'bx bx-male')
                    data = data.replaceAll('fas fa-female', 'bx bx-female')
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
                    data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                    data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                    data = data.replaceAll('fas fa-city', 'bx bxs-city');
                    data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                    data = data.replaceAll('fas fa-at', 'bx bx-at');
                    data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                    data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                    data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                    data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                    data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                    data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');
                    data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                    data = data.replaceAll('fa fa-image', 'bx bx-image');
                    data = data.replaceAll('208px', '308px');
                    data = data.replaceAll("data-toggle='tooltip'", " data-html='true' data-toggle='tooltip'");
                    data = data.replaceAll('fa fa-info-circle', 'bx bx-info-circle');
                    data = data.replaceAll('fas fa-id-card', 'bx bxs-id-card');
                    data = data.replaceAll('fas fa-mars', 'bx bx-male-sign');
                    data = data.replaceAll('fas fa-language', 'bx bx-flag');
                    data = data.replaceAll('fas fa-globe', 'bx bx-globe');
                    data = data.replaceAll('far fa-clock', 'bx bx-time');


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

        $(document).on('change', '#search_store_id', function (e) {
            table1.draw();
        });

        $(document).on('change', '#search_status', function (e) {
            table1.draw();
        });

        $(document).on('change', '#search_date_range_val', function (e) {
            e.preventDefault();
            table1.draw();
        });

        $(document).on('keypress', '#search_value', function (e) {
            if (e.which == 13) $("#search_action").click();
        });

        $(document).on('click', '#search_action', function (event) {
            event.preventDefault();
            table1.draw();
        });

        setTimeout(function () {
            if (search_param != '') {
                $("#search_value").val(search_param);
                $("#search_action").click();
            }
        }, 1000);


        $(document).on('change', '.payment_status', function (e) {
            var table_id = $(this).attr('data-id');
            var payment_status = $(this).val();
            $("#status_changed_cart_id").val(table_id);
            $("#status_changed_status").val(payment_status);
            $("#status_changed_note").val("");

            let n_element = $('.open_mashkor[data-order_id="'+table_id+'"]');
            if(n_element.length==1 && payment_status=='approved'){
                n_element.click();
            }else{
                $("#change_payment_status_modal").modal();
            }
        });


        $(document).on('click', '#change_payment_status_submit', function (e) {
            var table_id = $("#status_changed_cart_id").val();
            var payment_status = $("#status_changed_status").val();
            var status_changed_note = $("#status_changed_note").val();
            $(this).addClass('btn-progress');
            $.ajax({
                context: this,
                type: 'POST',
                dataType: 'JSON',
                url: "<?php echo base_url('ecommerce/change_payment_status')?>",
                data: {table_id: table_id, payment_status: payment_status, status_changed_note: status_changed_note},
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == '1') {
                        var success_message = response.message;
                        var span = document.createElement("span");
                        span.innerHTML = success_message;
                        swal.fire({
                            title: '<?php echo $this->lang->line("Order Status Updated"); ?>',
                            html: span,
                            icon: 'success'
                        });
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error")?>', response.message, 'error');
                    }
                    $("#change_payment_status_modal").modal('hide');
                    table1.draw(false);
                },
                error: function (response) {
                    var span = document.createElement("span");
                    span.innerHTML = response.responseText;
                    swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                }
            });

        });

        $(document).on('click', '#mp-download-file', function (e) {
            e.preventDefault();

            // Makes reference
            var that = this;

            // Starts spinner
            $(that).removeClass('btn-outline-info');
            $(that).addClass('btn-info disabled btn-progress');

            // Grabs ID
            var file = $(this).data('id');

            // Requests for file
            $.ajax({
                type: 'POST',
                data: {file},
                dataType: 'JSON',
                url: '<?php echo base_url('ecommerce/manual_payment_download_file') ?>',
                success: function (res) {
                    // Stops spinner
                    $(that).removeClass('btn-info disabled btn-progress');
                    $(that).addClass('btn-outline-info');

                    // Shows error if something goes wrong
                    if (res.error) {
                        swal.fire({
                            icon: 'error',
                            text: res.error,
                            title: '<?php echo $this->lang->line('Error!'); ?>',
                        });
                        return;
                    }

                    // If everything goes well, requests for downloading the file
                    if (res.status && 'ok' === res.status) {
                        window.location = '<?php echo base_url('ecommerce/manual_payment_download_file'); ?>';
                    }
                },
                error: function (xhr, status, error) {
                    // Stops spinner
                    $(that).removeClass('btn-info disabled btn-progress');
                    $(that).addClass('btn-outline-info');

                    // Shows internal errors
                    swal.fire({
                        icon: 'error',
                        text: error,
                        title: '<?php echo $this->lang->line('Error!'); ?>',
                    });
                }
            });
        });


        $(document).on('click', '.additional_info', function () {
            $(this).addClass('btn-progress');
            var cart_id = $(this).attr('data-id');
            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo base_url('ecommerce/addtional_info_modal_content')?>",
                data: {cart_id: cart_id},
                success: function (response) {
                    $('.additional_info').removeClass('btn-progress');
                    $('#manual-payment-modal .modal-body').html(response);
                    $('#manual-payment-modal').modal();
                }
            });
        });


    });

</script>

<?php
if(file_exists(APPPATH.'modules/n_mashkar/include/order_list.php')){
    include(APPPATH.'modules/n_mashkar/include/order_list.php');
}
if(file_exists(APPPATH.'modules/n_printnode/controllers/N_printnode.php')){
    include(APPPATH.'modules/n_printnode/include/order_list_js.php');
}

?>