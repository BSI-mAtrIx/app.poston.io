<div class="card shadow-none bg-transparent panel_dis" data-panel="front_product_but">
    <div class="card-header rounded-0 shadow-none bg-primary bg-darken-2 p-1">
        <h4 class="card-title text-white">
            <?php echo $this->lang->line("Front-end Builder") ?>
        </h4>
    </div>

    <?php
    $id_header = 'accordionFront1';
    $controls_header = 'Front';
    $i = 0;
    ?>
    <div class="card-body bg-transparent pt-1 pb-0 pl-0 pr-0 scrolling">
        <div class="accordion" id="<?php echo $id_header; ?>">

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Frontend Settings'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="<?php echo $controls_header . $i; ?>"
                     class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Page section width"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['front_width_size'])) {
                                $select_lan = $n_eco_builder_config['front_width_size'];
                            }
                            $options = array();
                            $options['full_width'] = $this->lang->line('Full width');
                            $options['boxed'] = $this->lang->line('Boxed');

                            echo form_dropdown('front_width_size', $options, $select_lan, 'class="make_change form-control" id="front_width_size"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('front_width_size'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Hide reviews on frontend"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['front_hide_reviews'])) {
                                $select_lan = $n_eco_builder_config['front_hide_reviews'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Hide');
                            $options['false'] = $this->lang->line('Show');

                            echo form_dropdown('front_hide_reviews', $options, $select_lan, 'class="make_change form-control" id="front_hide_reviews"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('front_hide_reviews'); ?></span>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Front product add to cart slideup"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['front_hide_add_to_cart_slideup'])) {
                                $select_lan = $n_eco_builder_config['front_hide_add_to_cart_slideup'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Slide up');
                            $options['false'] = $this->lang->line('Hidden');

                            echo form_dropdown('front_hide_add_to_cart_slideup', $options, $select_lan, 'class="make_change form-control" id="front_hide_add_to_cart_slideup"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('front_hide_add_to_cart_slideup'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="homestore_single_slideup_bg"
                                   class="text-white"><?php echo $this->lang->line('Product slideup background color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="homestore_single_slideup_bg" name="homestore_single_slideup_bg"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['homestore_single_slideup_bg']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('homestore_single_slideup_bg'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Mobile view columns"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['mobile_columns_div'])) {
                                $select_lan = $n_eco_builder_config['mobile_columns_div'];
                            }
                            $options = array();
                            $options['1'] = $this->lang->line('1 Column');
                            $options['2'] = $this->lang->line('2 Columns');

                            echo form_dropdown('mobile_columns_div', $options, $select_lan, 'class="make_change form-control" id="mobile_columns_div"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('mobile_columns_div'); ?></span>
                    </div>


                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i += 1;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Featured section'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="<?php echo $controls_header . $i; ?>"
                     class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Featured products section"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['front_featured_products_show'])) {
                                $select_lan = $n_eco_builder_config['front_featured_products_show'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['one_page'] = $this->lang->line('Hide');

                            echo form_dropdown('front_featured_products_show', $options, $select_lan, 'class="make_change form-control" id="front_featured_products_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('front_featured_products_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Products per row'); ?></p>
                        <div class="form-group">
                            <div id="front_featured_products_rows" class="mt-1 mb-3"></div>
                        </div>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="front_featured_products_text"
                                   class="text-white"><?php echo $this->lang->line('Text section'); ?></label>
                            <div class="input-group">
                                <input type="text" id="front_featured_products_text" name="background_color_header_top"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['front_featured_products_text']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('front_featured_products_text'); ?></span>
                        </fieldset>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show reviews"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['front_featured_reviews_show'])) {
                                $select_lan = $n_eco_builder_config['front_featured_reviews_show'];
                            }
                            $options = array();
                            $options['none'] = $this->lang->line('Hide reviews');
                            $options['show'] = $this->lang->line('Show');
                            $options['always_show'] = $this->lang->line('Always show');

                            echo form_dropdown('front_featured_reviews_show', $options, $select_lan, 'class="make_change form-control" id="front_featured_reviews_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('front_featured_reviews_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="front_featured_products_limit"
                                   class="text-white"><?php echo $this->lang->line('How many products to show'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="front_featured_products_limit"
                                       name="front_featured_products_limit" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['front_featured_products_limit']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('front_featured_products_limit'); ?></span>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i += 1;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('New products section'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="<?php echo $controls_header . $i; ?>"
                     class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("New products section"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['new_products_show'])) {
                                $select_lan = $n_eco_builder_config['new_products_show'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['one_page'] = $this->lang->line('Hide');

                            echo form_dropdown('new_products_show', $options, $select_lan, 'class="make_change form-control" id="new_products_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('new_products_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Products per row'); ?></p>
                        <div class="form-group">
                            <div id="new_products_rows" class="mt-1 mb-3"></div>
                        </div>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="new_products_text"
                                   class="text-white"><?php echo $this->lang->line('Text section'); ?></label>
                            <div class="input-group">
                                <input type="text" id="new_products_text" name="background_color_header_top"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['new_products_text']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('new_products_text'); ?></span>
                        </fieldset>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show reviews"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['new_products_reviews_show'])) {
                                $select_lan = $n_eco_builder_config['new_products_reviews_show'];
                            }
                            $options = array();
                            $options['none'] = $this->lang->line('Hide reviews');
                            $options['show'] = $this->lang->line('Show');
                            $options['always_show'] = $this->lang->line('Always show');

                            echo form_dropdown('new_products_reviews_show', $options, $select_lan, 'class="make_change form-control" id="new_products_reviews_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('new_products_reviews_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="new_products_products_limit"
                                   class="text-white"><?php echo $this->lang->line('How many products to show'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="new_products_products_limit"
                                       name="new_products_products_limit" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['new_products_products_limit']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('new_products_products_limit'); ?></span>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i += 1;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Deals section'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="<?php echo $controls_header . $i; ?>"
                     class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Deals section"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['front_deals_products_show'])) {
                                $select_lan = $n_eco_builder_config['front_deals_products_show'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['one_page'] = $this->lang->line('Hide');

                            echo form_dropdown('front_deals_products_show', $options, $select_lan, 'class="make_change form-control" id="front_deals_products_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('front_deals_products_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Products per row'); ?></p>
                        <div class="form-group">
                            <div id="front_deals_products_rows" class="mt-1 mb-3"></div>
                        </div>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="front_deals_products_text"
                                   class="text-white"><?php echo $this->lang->line('Text section'); ?></label>
                            <div class="input-group">
                                <input type="text" id="front_deals_products_text" name="background_color_header_top"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['front_deals_products_text']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('front_deals_products_text'); ?></span>
                        </fieldset>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show reviews"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['front_deals_reviews_show'])) {
                                $select_lan = $n_eco_builder_config['front_deals_reviews_show'];
                            }
                            $options = array();
                            $options['none'] = $this->lang->line('Hide reviews');
                            $options['show'] = $this->lang->line('Show');
                            $options['always_show'] = $this->lang->line('Always show');

                            echo form_dropdown('front_deals_reviews_show', $options, $select_lan, 'class="make_change form-control" id="front_deals_reviews_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('front_deals_reviews_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="front_deals_products_limit"
                                   class="text-white"><?php echo $this->lang->line('How many products to show'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="front_deals_products_limit"
                                       name="front_deals_products_limit" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['front_deals_products_limit']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('front_deals_products_limit'); ?></span>
                        </fieldset>
                    </div>

                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i += 1;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Best sellers section'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="<?php echo $controls_header . $i; ?>"
                     class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Best sellers section"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['front_sales_products_show'])) {
                                $select_lan = $n_eco_builder_config['front_sales_products_show'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['one_page'] = $this->lang->line('Hide');

                            echo form_dropdown('front_sales_products_show', $options, $select_lan, 'class="make_change form-control" id="front_sales_products_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('front_sales_products_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Products per row'); ?></p>
                        <div class="form-group">
                            <div id="front_sales_products_rows" class="mt-1 mb-3"></div>
                        </div>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="front_sales_products_text"
                                   class="text-white"><?php echo $this->lang->line('Text section'); ?></label>
                            <div class="input-group">
                                <input type="text" id="front_sales_products_text" name="background_color_header_top"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['front_sales_products_text']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('front_sales_products_text'); ?></span>
                        </fieldset>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show reviews"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['front_sales_reviews_show'])) {
                                $select_lan = $n_eco_builder_config['front_sales_reviews_show'];
                            }
                            $options = array();
                            $options['none'] = $this->lang->line('Hide reviews');
                            $options['show'] = $this->lang->line('Show');
                            $options['always_show'] = $this->lang->line('Always show');

                            echo form_dropdown('front_sales_reviews_show', $options, $select_lan, 'class="make_change form-control" id="front_sales_reviews_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('front_sales_reviews_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="front_sales_products_limit"
                                   class="text-white"><?php echo $this->lang->line('How many products to show'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="front_sales_products_limit"
                                       name="front_sales_products_limit" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['front_sales_products_limit']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('front_sales_products_limit'); ?></span>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php $i += 1;
                echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Order section'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="<?php echo $controls_header . $i; ?>"
                     class="collapse bg-secondary border-top-darken-2">
                    <ul class="sort list-group" id="front_sortable">
                        <?php
                        $order_front = explode(',', $n_eco_builder_config['front_order']);
                        foreach ($order_front as $k) {
                            switch ($k) {
                                case 'front_featured_products';
                                    echo '<li class="list-group-item ui-state-default" id="front_featured_products"><span class="handle">+</span>' . $l->line('Featured section') . '</li>';
                                    break;
                                case 'new_products';
                                    echo ' <li class="list-group-item ui-state-default" id="new_products"><span class="handle">+</span>' . $l->line('New products section') . '</li>';
                                    break;
                                case 'front_deals_products';
                                    echo '<li class="list-group-item ui-state-default" id="front_deals_products"><span class="handle">+</span>' . $l->line('Deals section') . '</li>';
                                    break;
                                case 'front_sales_products';
                                    echo '<li class="list-group-item ui-state-default" id="front_sales_products"><span class="handle">+</span>' . $l->line('Best sellers section') . '</li>';
                                    break;
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>


        </div>
    </div>
</div>