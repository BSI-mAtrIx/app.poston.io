<script>

    var base_url = "<?php echo site_url(); ?>";

    function doSearch(event) {
        event.preventDefault();
        $j('#tt').datagrid('load', {
            search_campaign_name: $j('#search_campaign_name').val(),
            search_page: $j('#search_page').val(),
            search_drip_type: $j('#search_drip_type').val(),
            is_searched: 1
        });

    }

</script>