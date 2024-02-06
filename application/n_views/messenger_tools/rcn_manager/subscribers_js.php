
<script>
    var base_url="<?php echo site_url(); ?>";

    <?php if(!empty($page_info) and $page_id == 0 and $iframe == 0){ ?>
    window.location.href = base_url + 'messenger_bot/otn_subscribers/' + $('#bot_list_select').val();
    <?php } ?>

    <?php if(!empty($page_info) and $page_id != 0 and $iframe == 0){ ?>
    $('#bot_list_select').val(<?php echo $page_id; ?>);
    <?php } ?>

    $(document).on('change', '#bot_list_select', function (event) {
        window.location.href = base_url + 'messenger_bot/rcn_subscribers/' + $('#bot_list_select').val();
    });

    $(document).ready(function() {
        var areWeUsingScroll = false;
        var perscroll;
        table = $("#mytable").DataTable({
            serverSide: true,
            processing:true,
            bFilter: false,
            order: [[ 7, "desc" ]],
            pageLength: 10,
            ajax: {
                url: base_url+'messenger_bot/rcn_subscribers_data',
                type: 'POST',
                data: function ( d )
                {
                    d.page_id = $('#page_id').val();
                    d.postback_id = $('#postback_id').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [0],
                    visible: false
                },
                {
                    targets: '',
                    className: 'text-center'
                },
                {
                    targets: [0,4,6],
                    sortable: false
                }
            ],
            fnInitComplete:function(){ // when initialization is completed then apply scroll plugin
                if(areWeUsingScroll)
                {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function( oSettings ) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if(areWeUsingScroll)
                {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            }
        });

        $(document).on('click', '#search_submit', function(event) {
            event.preventDefault();
            table.draw();
        });


        $(document).on('change', '#page_id', function(event) {
            event.preventDefault();
            table.draw();
        });


    });
</script>