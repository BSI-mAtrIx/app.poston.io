<script>
    var swiper = new Swiper('.category-ellipse-section-swiper', {
        'spaceBetween': <?php echo intval($n_eco_builder_config['menu_swiper_spacebetween']); ?>,
        'slidesPerView': <?php echo intval($n_eco_builder_config['menu_swiper_slidesoerview']); ?>,
        'breakpoints': {
            '480': {
                'slidesPerView': <?php echo intval($n_eco_builder_config['menu_swiper_spv_480']); ?>
            },
            '576': {
                'slidesPerView': <?php echo intval($n_eco_builder_config['menu_swiper_spv_576']); ?>
            },
            '768': {
                'slidesPerView': <?php echo intval($n_eco_builder_config['menu_swiper_spv_768']); ?>
            },
            '992': {
                'slidesPerView': <?php echo intval($n_eco_builder_config['menu_swiper_spv_992']); ?>
            },
            '1200': {
                'slidesPerView': <?php echo intval($n_eco_builder_config['menu_swiper_spv_1200']); ?>,
                'spaceBetween': <?php echo intval($n_eco_builder_config['menu_swiper_spacebetween_1200']); ?>
            },
        },
        grabCursor: true,
    });

</script>
