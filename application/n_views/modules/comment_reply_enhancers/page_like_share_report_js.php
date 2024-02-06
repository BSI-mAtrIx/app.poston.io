<script>
    var base_url = "<?php echo site_url(); ?>";
    var table_id = "<?php echo $table_id; ?>";

    $(document).ready(function () {

        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[2, "desc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'comment_reply_enhancers/page_like_share_report_data/' + table_id,
                type: 'POST',
                dataSrc: function (json) {
                    //$(".table-responsive").niceScroll();
                    return json.data;
                },
                data: function (d) {
                    d.post_id = $('#post_id').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [2],
                    visible: false
                },
                {
                    targets: '',
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 7],
                    sortable: false
                }
            ]
        });


        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });


        $(document).on('click', '.view_report', function () {
            var loading = '<div class="text-center"><img src="' + base_url + 'assets/pre-loader/custom_lg.gif" class="center-block"></div>';
            $("#view_report_modal_body").html(loading);
            $("#view_report").modal();
            var table_id = $(this).attr('table_id');
            $.ajax({
                type: 'POST',
                url: base_url + "comment_reply_enhancers/like_share_details",
                data: {table_id: table_id},
                // async: false,
                success: function (response) {
                    $("#view_report_modal_body").html(response);
                }

            });

        });


    });


</script>