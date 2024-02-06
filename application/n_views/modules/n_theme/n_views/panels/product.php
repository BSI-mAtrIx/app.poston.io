<div class="card shadow-none bg-transparent panel_dis" style="display:none;" data-panel="prodsing_but">
    <div class="card-header rounded-0 shadow-none bg-primary bg-darken-2 p-1">
        <h4 class="card-title text-white">
            <?php echo $this->lang->line("Product single") ?>
        </h4>
    </div>

    <?php
    $id_header = 'accordionProdsing1';
    $controls_header = 'Prodsing';
    $i = 0;
    ?>
    <div class="card-body bg-transparent pt-1 pb-0 pl-0 pr-0 scrolling">
        <div class="accordion" id="<?php echo $id_header; ?>">

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Product settings'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Gallery preview"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['product_single_gallery_type'])) {
                                $select_lan = $n_eco_builder_config['product_single_gallery_type'];
                            }
                            $options = array();
                            $options['product-gallery-horizontal'] = $this->lang->line('Horizontal');
                            $options['product-gallery-vertical'] = $this->lang->line('Vertical');

                            echo form_dropdown('product_single_gallery_type', $options, $select_lan, 'class="make_change form-control" id="product_single_gallery_type"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('product_single_gallery_type'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Sticky bottom add to cart"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['product_single_sticky'])) {
                                $select_lan = $n_eco_builder_config['product_single_sticky'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Enable');
                            $options['false'] = $this->lang->line('Disable');

                            echo form_dropdown('product_single_sticky', $options, $select_lan, 'class="make_change form-control" id="product_single_sticky"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('product_single_sticky'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show AddThis"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['addthis_show'])) {
                                $select_lan = $n_eco_builder_config['addthis_show'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('addthis_show', $options, $select_lan, 'class="make_change form-control" id="addthis_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('addthis_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="addthis_class"
                                   class="text-white"><?php echo $this->lang->line('AddThis class'); ?><span
                                        data-toggle="tooltip"
                                        data-original-title="<?php echo $this->lang->line('Example: addthis_native_toolbox'); ?>"><i
                                            class="bx bxs-help-circle"></i></span></label>
                            <div class="input-group">
                                <input type="text" id="addthis_class" name="addthis_class"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['addthis_class']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('addthis_class'); ?></span>
                        </fieldset>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <label for="addthis_code" class="text-white"><?php echo $l->line('AddThis JS Code URL'); ?><span
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line('Example: //s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e4ed5651fc8a1e6'); ?>"><i
                                        class="bx bxs-help-circle"></i></span></label>
                        <div class="row">
                            <div class="col-12">
                                <fieldset class="form-group">
                                    <textarea class="form-control make_change" id="addthis_code" rows="3"
                                              name="addthis_code"
                                              placeholder="<?php echo $l->line('Example: //s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e4ed5651fc8a1e6'); ?>"><?php echo $n_eco_builder_config['addthis_code']; ?></textarea>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show product reviews"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['product_single_reviews_show'])) {
                                $select_lan = $n_eco_builder_config['product_single_reviews_show'];
                            }
                            $options = array();
                            $options['always_show'] = $this->lang->line('Always show');
                            $options['show'] = $this->lang->line('Show');
                            $options['none'] = $this->lang->line('Hide');

                            echo form_dropdown('product_single_reviews_show', $options, $select_lan, 'class="make_change form-control" id="product_single_reviews_show"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('product_single_reviews_show'); ?></span>
                    </div>
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show product sales"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['product_single_show_sales'])) {
                                $select_lan = $n_eco_builder_config['product_single_show_sales'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');

                            echo form_dropdown('product_single_show_sales', $options, $select_lan, 'class="make_change form-control" id="product_single_show_sales"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('product_single_show_sales'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="product_single_product_details_bg"
                                   class="text-white"><?php echo $this->lang->line('Product details background'); ?></label>
                            <div class="input-group">
                                <input type="text" id="product_single_product_details_bg"
                                       name="product_single_product_details_bg"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['product_single_product_details_bg']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('product_single_product_details_bg'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="product_single_nav_link_color"
                                   class="text-white"><?php echo $this->lang->line('Product single tabs name font color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="product_single_nav_link_color"
                                       name="product_single_nav_link_color" class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['product_single_nav_link_color']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('product_single_nav_link_color'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="product_single_nav_link_color_active"
                                   class="text-white"><?php echo $this->lang->line('Product single tabs name font active/hover color'); ?></label>
                            <div class="input-group">
                                <input type="text" id="product_single_nav_link_color_active"
                                       name="product_single_nav_link_color_active"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['product_single_nav_link_color_active']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('product_single_nav_link_color_active'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="product_single_nav_content_bg"
                                   class="text-white"><?php echo $this->lang->line('Product single tabs content background'); ?></label>
                            <div class="input-group">
                                <input type="text" id="product_single_nav_content_bg"
                                       name="product_single_nav_content_bg" class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['product_single_nav_content_bg']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('product_single_nav_content_bg'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Display price before reviews"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['product_single_show_price_place'])) {
                                $select_lan = $n_eco_builder_config['product_single_show_price_place'];
                            }
                            $options = array();
                            $options['show_review_price'] = $this->lang->line('Show');
                            //                            $options['show_cart_price'] = $this->lang->line('Before add to cart');
                            //                            $options['show_both_price'] = $this->lang->line('Both');
                            $options['hide'] = $this->lang->line('Hide');

                            echo form_dropdown('product_single_show_price_place', $options, $select_lan, 'class="make_change form-control" id="product_single_show_price_place"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('product_single_show_price_place'); ?></span>
                    </div>


                </div>

            </div>

            <?php
            $i = $i + 1;
            ?>

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="<?php echo $controls_header . $i; ?>" class="card-header border-0 pl-1 pr-1" role="tablist"
                     data-toggle="collapse" data-target="#<?php echo $controls_header . $i; ?>" aria-expanded="false"
                     aria-controls="<?php echo $controls_header; ?>">
                    <span class="collapse-title text-white"><?php echo $l->line('Related product'); ?></span>
                </div>

                <div id="<?php echo $controls_header . $i; ?>" role="tabpanel" data-parent="#<?php echo $id_header; ?>"
                     aria-labelledby="heading1" class="collapse bg-secondary border-top-darken-2">
                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Related products autoplay"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['product_single_autoplay_items_related'])) {
                                $select_lan = $n_eco_builder_config['product_single_autoplay_items_related'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('On');
                            $options['false'] = $this->lang->line('Off');

                            echo form_dropdown('product_single_autoplay_items_related', $options, $select_lan, 'class="make_change form-control" id="product_single_autoplay_items_related"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('product_single_autoplay_items_related'); ?></span>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Sticky bottom add to cart"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['product_single_sticky'])) {
                                $select_lan = $n_eco_builder_config['product_single_sticky'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Enable');
                            $options['false'] = $this->lang->line('Disable');

                            echo form_dropdown('product_single_sticky', $options, $select_lan, 'class="make_change form-control" id="product_single_sticky"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('product_single_sticky'); ?></span>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="product_single_max_load_items_related"
                                   class="text-white"><?php echo $this->lang->line('Maximum related products to show'); ?></label>
                            <div class="input-group">
                                <input type="number" id="product_single_max_load_items_related"
                                       name="product_single_max_load_items_related" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['product_single_max_load_items_related']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('product_single_max_load_items_related'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Related products max width  576px'); ?></p>
                        <div class="form-group">
                            <div id="product_single_width_0_items_related" class="mt-1 mb-3"></div>
                        </div>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Related products max width 768px'); ?></p>
                        <div class="form-group">
                            <div id="product_single_width_576_items_related" class="mt-1 mb-3"></div>
                        </div>
                    </div>
                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Related products max width 992px'); ?></p>
                        <div class="form-group">
                            <div id="product_single_width_768_items_related" class="mt-1 mb-3"></div>
                        </div>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Related products min width 992px'); ?></p>
                        <div class="form-group">
                            <div id="product_single_width_992_items_related" class="mt-1 mb-3"></div>
                        </div>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="product_single_autoplaytimeout_items_related"
                                   class="text-white"><?php echo $this->lang->line('Autoplay related products miliseconds'); ?></label>
                            <div class="input-group">
                                <input type="number" id="product_single_autoplaytimeout_items_related"
                                       name="product_single_autoplaytimeout_items_related"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['product_single_autoplaytimeout_items_related']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('product_single_autoplaytimeout_items_related'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="product_single_items_related_title"
                                   class="text-white"><?php echo $this->lang->line('Related products title'); ?></label>
                            <div class="input-group">
                                <input type="text" id="product_single_items_related_title"
                                       name="product_single_items_related_title" class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['product_single_items_related_title']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('product_single_items_related_title'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>


        </div>
    </div>
</div>
