<?php ?>

<style>
    body.semi-dark-layout .main-menu {
        background-color: <?php echo $n_config['theme_sidebar_color']; ?> !important;
    }

    .main-menu.menu-dark .navigation li a {
        color: <?php echo $n_config['sidebar_text_color']; ?> !important;
    }

    .nav-pills .nav-link.active, .nav-pills .show > .nav-link,
    .btn-primary {
        background-color: <?php echo $n_config['primary_color']; ?> !important;
    }

    .btn-primary {
        background-color: <?php echo $n_config['primary_color']; ?> !important;
    }

    .btn-primary:hover, .btn-primary.hover {
        background-color: <?php echo $n_config['btn_primary_color_hover']; ?> !important;
        color: #fff;
    }


    <?php
         if($rtl_on){
            $n_config['body_font_font_size'] = $n_config['body_font_font_size_rtl'];
            $n_config['card_title_font_size'] = $n_config['card_title_font_size_rtl'];
        }
    ?>

    body{
        font-size: <?php echo $n_config['body_font_font_size']; ?>;
    }

    .card .card-title {
        font-size: <?php echo $n_config['card_title_font_size']; ?>;
    }


    .btn-light-primary {
        background-color: <?php echo $n_config['light_primary_color']; ?> !important;
    }

    .btn-outline-danger {
        border: 1px solid <?php echo $n_config['danger_color']; ?> !important;
        background-color: transparent;
        color: <?php echo $n_config['danger_color']; ?> !important;
    }

    .btn-outline-danger:hover, .btn-outline-danger.hover {
        background-color: <?php echo $n_config['danger_color']; ?> !important;
        color: #fff !important;
    }

    .btn-outline-success {
        color: <?php echo $n_config['success_color']; ?> !important;
        border-color: <?php echo $n_config['success_color']; ?> !important;
    }

    .btn-outline-success:hover, .btn-outline-success.hover {
        background-color: <?php echo $n_config['success_color']; ?> !important;
        color: #fff !important;
    }


    .btn-outline-warning {
        border: 1px solid <?php echo $n_config['warning_color']; ?> !important;
        background-color: transparent;
        color: <?php echo $n_config['warning_color']; ?> !important;
    }

    .btn-outline-warning:hover, .btn-outline-warning.hover {
        background-color: <?php echo $n_config['warning_color']; ?> !important;
        color: #fff !important;
    }

    .badge.badge-primary {
        background-color: <?php echo $n_config['primary_color']; ?> !important;
    }

    .dropdown-item.active, .dropdown-item:active {
        color: #FFFFFF;
        background-color: <?php echo $n_config['primary_color']; ?>;
    }

    .main-menu .shadow-bottom {
        display: none !important;
        background: transparent !important;
    }

    a {
        color: <?php echo $n_config['primary_color']; ?>;
    }

    #middle_column_content .dropdown-toggle {
        color: <?php echo $n_config['primary_color']; ?> !important;
    }

    a:hover {
        color: <?php echo $n_config['primary_color_hover']; ?>;
    }

    .btn-outline-primary {
        border: 1px solid<?php echo $n_config['primary_outline_color']; ?>;
        background-color: transparent;
        color: <?php echo $n_config['primary_outline_color']; ?> !important;
    }


    .btn-outline-primary:hover, .btn-outline-primary.hover {
        background-color: <?php echo $n_config['primary_outline_color']; ?> !important;
        color: #fff !important;
    }

    .customizer .customizer-toggle {
        background: <?php echo $n_config['primary_color']; ?>;
    }

    .nav.nav-tabs .nav-item .nav-link:not(:active):hover, .nav.nav-tabs .nav-item .nav-link:not(:active):hover span, .nav.nav-tabs .nav-item .nav-link:not(.active):hover, .nav.nav-tabs .nav-item .nav-link:not(.active):hover span, .nav.nav-pills .nav-item .nav-link:not(:active):hover, .nav.nav-pills .nav-item .nav-link:not(:active):hover span, .nav.nav-pills .nav-item .nav-link:not(.active):hover, .nav.nav-pills .nav-item .nav-link:not(.active):hover span {
        color: <?php echo $n_config['primary_color_hover']; ?>;
    }

    .main-menu.menu-dark .navigation > li.nav-item.open.has-sub.open,
    .main-menu.menu-dark .navigation > li.nav-item.open.has-sub.sidebar-group-active,
    .main-menu.menu-dark .navigation > li.nav-item.sidebar-group-active.has-sub.open,
    .main-menu.menu-dark .navigation > li.nav-item.sidebar-group-active.has-sub.sidebar-group-active {
        border: 1px solid<?php echo $n_config['primary_color']; ?>;
        background-color: <?php echo $n_config['theme_sidebar_color']; ?>;
    }

    html body {
        background-color: <?php echo $n_config['dashboard_background']; ?>;
    }

    .vertical-layout.vertical-menu-modern .main-menu .navigation > li > a > i:not(.menu-livicon) {
        color: <?php echo $n_config['dark_icon_color']; ?>;
    }


</style>