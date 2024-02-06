<style>
    body.semi-dark-layout .main-menu {
        background-color: <?php echo $n_eco_config['theme_sidebar_color']; ?> !important;
    }

    .main-menu.menu-dark .navigation li a {
        color: <?php echo $n_eco_config['sidebar_text_color']; ?> !important;
    }

    .nav-pills .nav-link.active, .nav-pills .show > .nav-link,
    .btn-primary {
        background-color: <?php echo $n_eco_config['primary_color']; ?> !important;
    }

    .navigation {
        font-family: "<?php echo $n_eco_config['nav_font']; ?>", Helvetica, Arial, serif !important;
    }

    <?php
         if($rtl_on){
            $n_eco_config['body_font_size'] = $n_eco_config['body_font_font_size_rtl'];
            $n_eco_config['card_title_font_size'] = $n_eco_config['card_title_font_size_rtl'];
        }
    ?>

    body {
        font-family: "<?php echo $n_eco_config['body_font']; ?>", Helvetica, Arial, serif !important;
        font-size: <?php echo $n_eco_config['body_font_size']; ?>;
    }

    .card .card-title {
        font-size: <?php echo $n_eco_config['card_title_font_size']; ?>;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: "<?php echo $n_eco_config['nav_font']; ?>", Helvetica, Arial, serif;
    }

    .btn-light-primary {
        background-color: <?php echo $n_eco_config['light_primary_color']; ?> !important;
    }

    .btn-outline-danger {
        border: 1px solid <?php echo $n_eco_config['danger_color']; ?> !important;
        background-color: transparent;
        color: <?php echo $n_eco_config['danger_color']; ?> !important;
    }

    .btn-outline-danger:hover, .btn-outline-danger.hover {
        background-color: <?php echo $n_eco_config['danger_color']; ?> !important;
        color: #fff !important;
    }

    .btn-outline-success {
        color: <?php echo $n_eco_config['success_color']; ?> !important;
        border-color: <?php echo $n_eco_config['success_color']; ?> !important;
    }

    .btn-outline-success:hover, .btn-outline-success.hover {
        background-color: <?php echo $n_eco_config['success_color']; ?> !important;
        color: #fff !important;
    }


    .btn-outline-warning {
        border: 1px solid <?php echo $n_eco_config['warning_color']; ?> !important;
        background-color: transparent;
        color: <?php echo $n_eco_config['warning_color']; ?> !important;
    }

    .btn-outline-warning:hover, .btn-outline-warning.hover {
        background-color: <?php echo $n_eco_config['warning_color']; ?> !important;
        color: #fff !important;
    }

    .badge.badge-primary {
        background-color: <?php echo $n_eco_config['primary_color']; ?> !important;
    }

    .dropdown-item.active, .dropdown-item:active {
        color: #FFFFFF;
        background-color: <?php echo $n_eco_config['primary_color']; ?>;
    }

    .main-menu .shadow-bottom {
        display: none !important;
        background: transparent !important;
    }

    a {
        color: <?php echo $n_eco_config['primary_color']; ?>;
    }

    #middle_column_content .dropdown-toggle {
        color: <?php echo $n_eco_config['primary_color']; ?> !important;
    }

    a:hover {
        color: <?php echo $n_eco_config['primary_color_hover']; ?>;
    }

    .btn-outline-primary {
        border: 1px solid<?php echo $n_eco_config['primary_outline_color']; ?>;
        background-color: transparent;
        color: <?php echo $n_eco_config['primary_outline_color']; ?> !important;
    }


    .btn-outline-primary:hover, .btn-outline-primary.hover {
        background-color: <?php echo $n_eco_config['primary_outline_color']; ?> !important;
        color: #fff !important;
    }


</style>