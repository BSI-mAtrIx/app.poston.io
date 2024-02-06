<div class="card shadow-none bg-transparent panel_dis" data-panel="category_but">
    <div class="card-header rounded-0 shadow-none bg-primary bg-darken-2 p-1">
        <h4 class="card-title text-white">
            <?php echo $this->lang->line("Category view") ?>
        </h4>
    </div>
    <div class="card-body bg-transparent pt-1 pb-0 pl-0 pr-0 scrolling">
        <div class="accordion" id="accordionCategory1">

            <div class="card bg-secondary bg-darken-3 collapse-header rounded-0  ">
                <div id="Category1" class="card-header border-0 pl-1 pr-1" role="tablist" data-toggle="collapse"
                     data-target="#accordionCategory1" aria-expanded="false" aria-controls="accordionCategory1">
                    <span class="collapse-title text-white"><?php echo $l->line('Product view'); ?></span>

                </div>

                <div id="accordionCategory1" role="tabpanel" data-parent="#accordionCategory1"
                     aria-labelledby="Category1" class="collapse bg-secondary border-top-darken-2">

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <p class="text-center text-bold-700"><?php echo $l->line('Columns'); ?></p>
                        <div class="form-group">
                            <div id="pips-range" class="mt-1 mb-3"></div>
                        </div>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Show reviews"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['category_hide_reviews'])) {
                                $select_lan = $n_eco_builder_config['category_hide_reviews'];
                            }
                            $options = array();
                            $options['none'] = $this->lang->line('Hide reviews');
                            $options['show'] = $this->lang->line('Show');
                            $options['always_show'] = $this->lang->line('Always show');

                            echo form_dropdown('category_hide_reviews', $options, $select_lan, 'class="make_change form-control" id="category_hide_reviews"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('category_hide_reviews'); ?></span>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="pagination_per_page"
                                   class="text-white"><?php echo $this->lang->line('Products in category per page (pagination)'); ?></label>
                            <div class="input-group">
                                <input type="number" min="1" id="pagination_per_page" name="pagination_per_page"
                                       class="form-control make_change"
                                       value="<?php echo $n_eco_builder_config['pagination_per_page']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('pagination_per_page'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Category product style"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['category_product_views_style'])) {
                                $select_lan = $n_eco_builder_config['category_product_views_style'];
                            }
                            $options = array();
                            $options['boxed'] = $this->lang->line('Boxed');
                            $options['2columnlist'] = $this->lang->line('List 2 columns');

                            echo form_dropdown('category_product_views_style', $options, $select_lan, 'class="make_change form-control" id="category_product_views_style"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('category_product_views_style'); ?></span>
                    </div>

                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Category product change style buttons"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['category_product_views_style_buttons'])) {
                                $select_lan = $n_eco_builder_config['category_product_views_style_buttons'];
                            }
                            $options = array();
                            $options['false'] = $this->lang->line('Hide');
                            $options['true'] = $this->lang->line('Show');

                            echo form_dropdown('category_product_views_style_buttons', $options, $select_lan, 'class="make_change form-control" id="category_product_views_style_buttons"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('category_product_views_style_buttons'); ?></span>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <h6 class="text-white"><?php echo $this->lang->line("Category description with image"); ?></h6>
                        <div class="form-group">
                            <?php
                            $select_lan = false;
                            if (isset($n_eco_builder_config['category_single_description'])) {
                                $select_lan = $n_eco_builder_config['category_single_description'];
                            }
                            $options = array();
                            $options['true'] = $this->lang->line('Show');
                            $options['false'] = $this->lang->line('Hide');


                            echo form_dropdown('category_single_description', $options, $select_lan, 'class="make_change form-control" id="category_single_description"'); ?>
                        </div>
                        <span class="text-danger"><?php echo form_error('category_single_description'); ?></span>
                    </div>


                    <div class="card-body bg-secondary text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_product_light"
                                   class="text-white"><?php echo $this->lang->line('Light color for product price'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_product_light" name="font_color_product_light"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_product_light']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_product_light'); ?></span>
                        </fieldset>
                    </div>

                    <div class="card-body bg-secondary bg-darken-1 text-white pl-1 pr-1">
                        <fieldset>
                            <label for="font_color_product_dark"
                                   class="text-white"><?php echo $this->lang->line('Dark color for product price'); ?></label>
                            <div class="input-group">
                                <input type="text" id="font_color_product_dark" name="font_color_product_dark"
                                       class="form-control spectrum make_change"
                                       value="<?php echo $n_eco_builder_config['font_color_product_dark']; ?>">
                            </div>
                            <span class="text-danger"><?php echo form_error('font_color_product_dark'); ?></span>
                        </fieldset>
                    </div>


                </div>
            </div>


        </div>
    </div>
</div>