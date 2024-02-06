<script>
    $('document').ready(function () {

        <?php require_once(APPPATH.'modules/n_wa/include/sweetalert_v1.php'); ?>

        var csrf_token = "<?php echo $this->session->userdata('csrf_token_session'); ?>";

        var base_url = "<?php echo site_url(); ?>";
        var csrf_token = "<?php echo $csrf_token; ?>";


            var perscroll;
            var table = $("#mytable").DataTable({
                serverSide: true,
                processing: true,
                bFilter: true,
                order: [[1, "desc"]],
                pageLength: 10,
                ajax: {
                    "url": base_url + 'n_wa/api/list_subscribers',
                    "type": 'POST',
                    data: {
                        'csrf_token': csrf_token,
                        'bot_id': <?php echo $bot_id; ?>
                    },
                },
                language: {
                    url: "<?php echo base_url('assets/modules/datatables/language/' . $this->language . '.json'); ?>"
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">',
                columnDefs: [
                    {
                        targets: [0],
                        visible: false
                    },
                    {
                        targets: [1],
                        className: 'text-left'
                    }
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



    });
</script>