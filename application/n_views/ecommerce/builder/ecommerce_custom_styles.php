body, .header{font-family: <?php echo $n_eco_builder_config['font_family']; ?>,sans-serif;}
h1, h2, h3, h4, h5, h6 {font-family: <?php echo $n_eco_builder_config['font_family']; ?>,sans-serif;}
.product {font-family: <?php echo $n_eco_builder_config['font_family']; ?>,sans-serif;}



.product-single .btn-primary{
color: <?php echo $n_eco_builder_config['add_to_cart_color_font']; ?>;
border-color: <?php echo $n_eco_builder_config['add_to_cart_color_bg']; ?>;
background-color: <?php echo $n_eco_builder_config['add_to_cart_color_bg']; ?>;
}

.product-single .btn-primary:hover, .product-single .btn-primary:active, .product-single .btn-primary:focus{
color: <?php echo $n_eco_builder_config['add_to_cart_color_font_hover']; ?>;
border-color: <?php echo $n_eco_builder_config['add_to_cart_color_bg_hover']; ?>;
background-color: <?php echo $n_eco_builder_config['add_to_cart_color_bg_hover']; ?>;
}

.product-hidden-details .btn-cart{
color: <?php echo $n_eco_builder_config['home_add_to_cart_color_font']; ?>;
border-color: <?php echo $n_eco_builder_config['home_add_to_cart_color_bg']; ?>;
background-color: <?php echo $n_eco_builder_config['home_add_to_cart_color_bg']; ?>;
}

.product-hidden-details .btn-cart:hover{
color: <?php echo $n_eco_builder_config['home_add_to_cart_color_font_hover']; ?>;
border-color: <?php echo $n_eco_builder_config['home_add_to_cart_color_bg_hover']; ?>;
background-color: <?php echo $n_eco_builder_config['home_add_to_cart_color_bg_hover']; ?>;
}

.footer-bottom {
background: <?php echo $n_eco_builder_config['footer_background']; ?>;
}

.footer-bottom .copyright{
color: <?php echo $n_eco_builder_config['footer_background_text_color']; ?>;
}

.footer-bottom a{
color: <?php echo $n_eco_builder_config['footer_background_link_color']; ?>;
}

.footer-bottom a:hover{
color: <?php echo $n_eco_builder_config['footer_background_link_color_hover']; ?>;
}

.text-dark {
color: <?php echo $n_eco_builder_config['font_color_text_dark']; ?> !important;
}

.text-light {
color: <?php echo $n_eco_builder_config['font_color_text_light']; ?> !important;
}

.product-price .text-light{
color: <?php echo $n_eco_builder_config['font_color_product_light']; ?> !important;
}

.product-price .text-dark{
color: <?php echo $n_eco_builder_config['font_color_product_dark']; ?> !important;
}

h1, h2, h3, h4, h5, h6 {
color: <?php echo $n_eco_builder_config['font_color_headers']; ?>;
}

.product-cat {
color: <?php echo $n_eco_builder_config['font_color_product_cat']; ?>;
}

.header-middle,
.header-middle .cart_url_api,
.cart_url_api .cart-label
{
color: <?php echo $n_eco_builder_config['font_color_header_middle']; ?>!important;
}

.header-middle .header-right>a:hover,
.cart_url_api:hover .cart-label
{
color: <?php echo $n_eco_builder_config['font_color_header_middle_hover']; ?>!important;
}

.header-top{
color: <?php echo $n_eco_builder_config['font_color_header_top']; ?>;
}

.header-top .header-right>a:hover{
color: <?php echo $n_eco_builder_config['font_color_header_top_hover']; ?>;
}

html body {
background-color: <?php echo $n_eco_builder_config['background_body']; ?>;
}

.header-bottom{
background-color: <?php echo $n_eco_builder_config['menu_background']; ?>;
border: 1px solid <?php echo $n_eco_builder_config['menu_background']; ?>;
}

.menu>li>a:not(.menu-title){
color: <?php echo $n_eco_builder_config['menu_font_color']; ?>;
}

.menu>li:hover>a:not(.menu-title){
color: <?php echo $n_eco_builder_config['menu_font_color_hover']; ?>;
}

.menu>li.active>a:not(.menu-title){
color: <?php echo $n_eco_builder_config['menu_font_color_active']; ?>;
}

#guest_register_form{
color: <?php echo $n_eco_builder_config['guest_register_form_type_btn_font_color']; ?>;
<?php if ($n_eco_builder_config['guest_register_form_type'] == 'btn') {
    echo 'border-color: ' . $n_eco_builder_config['guest_register_form_type_btn_bg_color'] . ';
    background-color: ' . $n_eco_builder_config['guest_register_form_type_btn_bg_color'] . ';';
} ?>
}

#guest_register_form:hover{
color: <?php echo $n_eco_builder_config['guest_register_form_type_btn_font_color_hover']; ?>;
<?php if ($n_eco_builder_config['guest_register_form_type'] == 'btn') {
    echo 'border-color: ' . $n_eco_builder_config['guest_register_form_type_btn_bg_color_hover'] . ';
    background-color: ' . $n_eco_builder_config['guest_register_form_type_btn_bg_color_hover'] . ';';
} ?>
}

.page-content{
background-color: <?php echo $n_eco_builder_config['background_page_content']; ?>;
}

.store_name_n{
color: <?php echo $n_eco_builder_config['store_name_font_color']; ?>;
margin-left:15px;
font-size: <?php echo $n_eco_builder_config['store_name_font_size']; ?>px;
}

.store_name_n:hover{
color: <?php echo $n_eco_builder_config['store_name_font_color_hover']; ?>;
}


.homestore_single  .product-slideup-content .product-details{
background-color: <?php echo $n_eco_builder_config['homestore_single_slideup_bg']; ?>;
}

.homestore_single  .product-slideup-content .product-hidden-details{
background-color: <?php echo $n_eco_builder_config['homestore_single_slideup_bg']; ?>;
}

.product_single .product-single  .mb-6 > .product-details{
background-color: <?php echo $n_eco_builder_config['product_single_product_details_bg']; ?>;
}


.product_single .product-tabs .nav-link{
color: <?php echo $n_eco_builder_config['product_single_nav_link_color']; ?>;
}

.product_single .product-tabs .nav-tabs .nav-link:hover,
.product_single .product-tabs .nav-tabs .nav-link.active{
color: <?php echo $n_eco_builder_config['product_single_nav_link_color_active']; ?>;
}
.product_single .tab-content{
background-color: <?php echo $n_eco_builder_config['product_single_nav_content_bg']; ?>;
}

.mfp-newsletter .mfp-content{
max-width: <?php echo $n_eco_builder_config['welcome_modal_maxwidth']; ?>px;
}


<?php if ($n_eco_builder_config['breadcrumb_hide'] == 'true') { ?>
    .breadcrumb-nav{
    display: none!important;
    }
<?php } ?>


<?php if ($n_eco_builder_config['header_welcome_animate'] == 'true') { ?>
    .welcome-msg {
    transform: translateX(0);
    animation: 6s linear 2s 1 showMsgFirst,12s linear 8s infinite showMsg;
    }
<?php } ?>


.login-popup .form-checkbox a#guest_register_form {
    font-size: <?php echo $n_eco_builder_config['guest_font_size']; ?>;
}