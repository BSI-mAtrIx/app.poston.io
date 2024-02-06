<script>
    var counter = 0;
    var current_product_id = "<?php echo $current_product_id; ?>";
    var current_store_id = "<?php echo $current_store_id; ?>";
    var store_favicon = "<?php echo isset($social_analytics_codes['store_favicon']) ? $social_analytics_codes['store_favicon'] : '';?>";
    var store_name = "<?php echo isset($social_analytics_codes['store_name']) ? $social_analytics_codes['store_name'] : '';?>";
    var product_name = "<?php echo isset($product_data['product_name']) ? $product_data['product_name'] : '';?>";
    var comment_id = "<?php echo $comment_id;?>";

    $(document).ready(function () {

        setTimeout(function () {
            var start = $("#load_more").attr("data-start");
            load_data(start, false, false, comment_id);
        }, 1000);

    });
</script>