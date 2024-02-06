<!-- Start of Sticky Footer -->
<div class="sticky-footer sticky-content fix-bottom">

    <?php if ($n_eco_builder_config['show_mobile_menu_back'] == 'true') {

        ?>
        <a href="#" class="sticky-link" onclick="window.history.back()">
            <i class="w-icon-angle-left"></i>
            <?php if ($n_eco_builder_config['show_mobile_menu_only_icons'] == 'false') { ?>
                <p><?php echo $l->line('back'); ?></p><?php } ?>
        </a>
    <?php } ?>

    <?php if ($n_eco_builder_config['show_mobile_menu_home'] == 'true') {
        $nhome_sticky = _link('ecommerce/store/' . $js_store_unique_id);
        $nhome_sticky = mec_add_get_param($nhome_sticky, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
        ?>
        <a href="<?php echo $nhome_sticky; ?>" class="sticky-link active">
            <i class="w-icon-home"></i>
            <?php if ($n_eco_builder_config['show_mobile_menu_only_icons'] == 'false') { ?>
                <p><?php echo $l->line('home'); ?></p><?php } ?>
        </a>
    <?php } ?>

    <?php if ($n_eco_builder_config['show_mobile_menu_orders'] == 'true') { ?>
        <a href="<?php echo $my_orders_link; ?>" class="sticky-link d-none">
            <i class="w-icon-orders"></i>
            <?php if ($n_eco_builder_config['show_mobile_menu_only_icons'] == 'false') { ?>
                <p><?php echo $l->line('orders'); ?></p> <?php } ?>
        </a>
    <?php } ?>

    <?php if ($n_eco_builder_config['show_mobile_menu_cart'] == 'true') { ?>
        <a href="<?php echo $href; ?>" class="cart_url_api sticky-link">
            <i class="w-icon-cart"></i>
            <?php if ($n_eco_builder_config['show_mobile_menu_only_icons'] == 'false') { ?>
                <p><?php echo $l->line('Cart'); ?></p><?php } ?>
        </a>
    <?php } ?>

    <?php if ($n_eco_builder_config['show_mobile_menu_account'] == 'true') { ?>
        <a href="<?php e_link($my_account_link); ?>" class="sticky-link">
            <i class="w-icon-account"></i>
            <?php if ($n_eco_builder_config['show_mobile_menu_only_icons'] == 'false') { ?>
                <p><?php echo $l->line('Account'); ?></p> <?php } ?>
        </a>
    <?php } ?>

    <?php if ($n_eco_builder_config['show_mobile_menu_contact'] == 'true') {
        $ncontact_sticky = _link('ecommerce/contact/' . $js_store_unique_id);
        $ncontact_sticky = mec_add_get_param($ncontact_sticky, array("subscriber_id" => $subscriberId, "pickup" => $pickup));

        ?>
        <a href="<?php echo $ncontact_sticky; ?>" class="sticky-link">
            <i class="w-icon-comments"></i>
            <?php if ($n_eco_builder_config['show_mobile_menu_only_icons'] == 'false') { ?>
                <p><?php echo $l->line('contact'); ?></p><?php } ?>
        </a>
    <?php } ?>

    <?php if ($n_eco_builder_config['show_mobile_menu_search'] == 'true') { ?>
        <div class="header-search hs-toggle dir-up">
            <a href="#" class="search-toggle sticky-link">
                <i class="w-icon-search"></i>
                <?php if ($n_eco_builder_config['show_mobile_menu_only_icons'] == 'false') { ?>
                    <p><?php echo $l->line('home'); ?></p><?php } ?>
            </a>
            <form action="#" class="input-wrapper">
                <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search"
                       required/>
                <button class="btn btn-search" type="submit">
                    <i class="w-icon-search"></i>
                </button>
            </form>
        </div>
    <?php } ?>

</div>
<!-- End of Sticky Footer -->
