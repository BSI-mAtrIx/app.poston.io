<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li><?php echo $this->lang->line("Cart"); ?></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="shop-content">
            <div class="container main-content">
                <div class="invoice p-0 pt-2 shadow-none bg-light text-center pb-2">
                    <div class="empty-state">
                        <img class="img-fluid" style="height: 200px"
                             src="<?php echo base_url($n_eco_builder_config['empty_cart_image']); ?>" alt="image">
                        <h2 class="mt-0"><?php echo $this->lang->line("Cart is empty"); ?></h2>
                        <p class="lead"><?php echo $this->lang->line("There is no product added to cart. Please browse our store and add them to cart to continue."); ?></p>
                        <?php if (isset($not_found)) { ?>
                            <p class="lead"><?php echo $not_found; ?></p>
                        <?php }


                        $browse = _link('ecommerce/store/' . $js_store_unique_id);
                        $browse = mec_add_get_param($browse, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
                        ?>
                        <a href="<?php echo $browse; ?>" class="btn btn-outline-primary mt-4"><i
                                    class="w-icon-store"></i> <?php echo $this->lang->line("Browse Store"); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

