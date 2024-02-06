<footer class="sticky-content fix-bottom">
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-left">
                <?php
                $hide_all_rights_footer = '';
                if ($n_eco_builder_config['hide_all_rights_footer'] == 'true') {
                    $hide_all_rights_footer = 'd-none';
                }
                ?>
                <span class="copyright <?php echo $hide_all_rights_footer; ?>"><?php echo date('Y'); ?> &copy; <?php echo isset($social_analytics_codes['store_name']) ? $social_analytics_codes['store_name'] : ""; ?> <?php echo $l->line('All Rights Reserved'); ?></span>
            </div>
            <div class="footer-right">
                <a class="text-uppercase rtl_margin_left" href="<?php
                $terms_ntheme = _link('ecommerce/terms/' . $js_store_unique_id);
                $terms_ntheme = mec_add_get_param($terms_ntheme, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
                echo $terms_ntheme;
                ?>"><?php echo $this->lang->line("Terms"); ?></a>
                <a class="border-left pl-1 text-uppercase" href="<?php
                $policy_ntheme = _link('ecommerce/refund_policy/' . $js_store_unique_id);
                $policy_ntheme = mec_add_get_param($policy_ntheme, array("subscriber_id" => $subscriberId, "pickup" => $pickup));
                echo $policy_ntheme;
                ?>"><?php echo $this->lang->line("Refund Policy"); ?></a>
            </div>
        </div>
    </div>
</footer>
