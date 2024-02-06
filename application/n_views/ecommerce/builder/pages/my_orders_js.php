<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.html5.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.print.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/buttons.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/pdfmake.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/tables/datatable/vfs_fonts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<link href="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>plugins/datetimepickerjquery/jquery.datetimepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/extensions/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/pickers/daterange/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/modules/chocolat/dist/css/chocolat.css?ver=<?php echo $n_config['theme_version']; ?>">

<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/forms/select/select2.min.css?ver=<?php echo $n_config['theme_version']; ?>">

<script src="<?php echo base_url(); ?>n_assets/app-assets/vendors/js/forms/select/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<style>
    .select2-dropdown{z-index:3000!important;}
    .select2{width:100%!important}
</style>
<script>

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
    table1 = $("#order_table").DataTable({
        serverSide: true,
        processing: true,
        bFilter: false,
        order: [[2, "desc"]],
        pageLength: 10,
        ajax: {
            url: base_url_js + 'my_orders_data',
            type: 'POST',
            data: function (d) {
                d.search_store_id = $('#search_store_id').val();
                d.search_pickup = $('#search_pickup').val();
                d.search_subscriber_id = $('#search_subscriber_id').val();
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
                targets: [0, 1],
                visible: false
            },
            {
                targets: [4],
                "render": function (data, type, row) {
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
        }
    });


    $("document").ready(function () {

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

        $(document).on('click tap', '#search_action', function (event) {
            event.preventDefault();
            table1.draw();
        });

        $(document).on('click tap', '#mp-download-file', function (e) {
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

        $(document).on('click tap', '.additional_info', function () {
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
                    //$('#manual-payment-modal').modal();
                    $.magnificPopup.open({
                        type: 'inline',
                        items: {
                            src: '#manual-payment-modal'
                        },
                        preloader: false,
                        modal: true
                    });
                }
            });
        });


    });


    function load_states_by_country(){
        $state_del = $('#state').val();
        $state_bill = $('#state').val();

        $country = $( "#country option:selected").attr('data-country');
        $state = $('#state').val();

        //var delivery_address_id = $("#select_delivery_address").val();


        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: {
                delivery_address_id:0,
                country:$country,
                state:$state,
                store_id:store_id,
                csrf_token:'<?php echo $this->session->userdata('csrf_token_session'); ?>'
            },
            url: '<?php echo _link('ecommerce/ajax_get_shipping_zone'); ?>',
            success: function (response) {

                $('#state').empty().select2({
                    placeholder: '<?php echo $this->lang->line('Search or type state'); ?>',
                    width: '100%',
                    tags: true,
                    tokenSeparators: [',', ' '],
                    data: response.states_data,
                    multiple: false,
                }).val($state_bill).trigger('change');

                //
                //$('#delivery_state').empty().select2({
                //    placeholder: '<?php //echo $this->lang->line('Search or type state'); ?>//',
                //    width: '100%',
                //    tags: true,
                //    tokenSeparators: [',', ' '],
                //    data: response.states_data,
                //    multiple: false,
                //}).val($state_del).trigger('change.select2');


            }
        });


    }

    $(document).on('change', '#country', function (e) {
        load_states_by_country();
    });


</script>


<div class="n_modal mfp-hide" id="manual-payment-modal">
    <div class="">
        <h4 id="manual-payment-modallabel"><?php echo $this->lang->line("Manual Payment Information"); ?></h4>
        <div class="modal-body">
        </div><!-- ends modal-body -->
    </div>
    <button title="<?php echo $l->line('Close'); ?>" type="button" class="mfp-close"><span>×</span></button>
</div>
