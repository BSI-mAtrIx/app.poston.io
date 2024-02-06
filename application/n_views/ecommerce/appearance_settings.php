<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 1;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
?>

<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("ecommerce"); ?>"><?php echo $this->lang->line("E-commerce"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php
if ($this->session->flashdata('success_message') == 1)
    echo "<div class='alert alert-success text-center'><i class='bx bx-check-circle'></i> " . $this->lang->line("Your data has been successfully stored into the database.") . "</div><br>";

if (!isset($xvalue["is_category_wise_product_view"])) $xvalue["is_category_wise_product_view"] = "0";
if (!isset($xvalue["product_listing"])) $xvalue["product_listing"] = "list";
if (!isset($xvalue["theme_color"])) $xvalue["theme_color"] = "#6777ef";
if ($xvalue["theme_color"] == "") $xvalue["theme_color"] = "#6777ef";

$colors = array('#6777ef', '#2d88ff', '#1261a0', '#545096', '#e55053', '#fc4444', '#ff8342', '#ffc156', '#00c9b8', '#00a65a', '#164a41', '#293745');
?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <form action="<?php echo base_url("ecommerce/appearance_settings_action"); ?>" method="POST">
                <div class="card shadow-none">
                    <div class="card-body p-0">


                        <div class="row">
                            <div class="col-12 col-md-6 d-none">
                                <div class="form-group mb-0">
                                    <label><?php echo $this->lang->line("Choose Theme color"); ?></label>
                                </div>
                                <?php $select_front_theme = $xvalue["theme_color"]; ?>

                                <div class="row gutters-xs mb-3">
                                    <?php foreach ($colors as $key => $value) : ?>
                                        <div class="col-auto">
                                            <label class="colorinput">
                                                <input name="theme_front" type="radio" value="<?php echo $value; ?>"
                                                       class="colorinput-input" <?php if ($select_front_theme == $value) echo "checked"; ?>/>
                                                <span class="colorinput-color"
                                                      style="background: <?php echo $value; ?>"></span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 d-none">
                                <div class="form-group mb-0 ">
                                    <label><?php echo $this->lang->line(""); ?></label>
                                </div>
                                <?php echo "<input type='color' name='theme_color' id='theme_color' class='form-control border-right' value='" . $select_front_theme . "'>"; ?>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label>
                                        <?php echo $this->lang->line("Product grouping"); ?>
                                    </label>
                                    <div class="selectgroup d-block">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_category_wise_product_view" value="1"
                                                   class="selectgroup-input" <?php if (isset($xvalue["is_category_wise_product_view"]) && $xvalue["is_category_wise_product_view"] == '1') echo 'checked'; ?>>
                                            <span class="selectgroup-button"> <?php echo $this->lang->line("Category-wise") ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="is_category_wise_product_view" value="0"
                                                   class="selectgroup-input" <?php if (isset($xvalue["is_category_wise_product_view"]) && $xvalue["is_category_wise_product_view"] == '0') echo 'checked'; ?>>
                                            <span class="selectgroup-button"> <?php echo $this->lang->line("None") ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label>
                                        <?php echo $this->lang->line("Product viewing"); ?>
                                    </label>
                                    <div class="selectgroup d-block">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="product_listing" value="grid"
                                                   class="selectgroup-input" <?php if (isset($xvalue["product_listing"]) && $xvalue["product_listing"] == 'grid') echo 'checked'; ?>>
                                            <span class="selectgroup-button"> <?php echo $this->lang->line("Grid view") ?></span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="product_listing" value="list"
                                                   class="selectgroup-input" <?php if (isset($xvalue["product_listing"]) && $xvalue["product_listing"] == 'list') echo 'checked'; ?>>
                                            <span class="selectgroup-button"> <?php echo $this->lang->line("List view") ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group mb-3">
                                    <label><?php echo $this->lang->line("Product sorting"); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><?php echo $this->lang->line("Order by"); ?></span>
                                        </div>
                                        <?php
                                        $product_sort = isset($xvalue['product_sort']) ? $xvalue['product_sort'] : "name";
                                        $product_sort_order = isset($xvalue['product_sort_order']) ? $xvalue['product_sort_order'] : "asc";
                                        $arr = array
                                        (
                                            'name' => $this->lang->line('Product Title'),
                                            'new' => $this->lang->line('New Product'),
                                            'price' => $this->lang->line('Price'),
                                            'sale' => $this->lang->line('Total Sales'),
                                            'random' => $this->lang->line('Random')
                                        );
                                        $arr2 = array
                                        (
                                            'asc' => $this->lang->line('Ascending'),
                                            'desc' => $this->lang->line('Descending')
                                        );
                                        ?>
                                        <?php echo form_dropdown('product_sort', $arr, $product_sort, "class='form-control'"); ?>
                                        <?php echo form_dropdown('product_sort_order', $arr2, $product_sort_order, "class='form-control'"); ?>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-md-6 d-none">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Font"); ?></label>
                                    <?php
                                    $default_font = isset($xvalue['font']) ? $xvalue['font'] : '"Trebuchet MS",Arial,sans-serif';
                                    if ($default_font == '') $default_font = '"Trebuchet MS",Arial,sans-serif';
                                    ?>
                                    <?php echo form_dropdown('font', $font_list, $default_font, "class='form-control id='font'"); ?>
                                </div>
                            </div>

                            <div class="col-12 <?php if ($xdata2['store_type'] == 'physical') echo 'col-md-6'; ?>">
                                <div class="form-group">
                                    <label>
                                        <?php echo $this->lang->line("Buy now button title"); ?>
                                    </label>
                                    <div class="input-group mb-2">
                                        <input type="text" name="buy_button_title" id="buy_button_title"
                                               class="form-control"
                                               value="<?php echo isset($xvalue['buy_button_title']) ? $xvalue['buy_button_title'] : "Buy Now"; ?>">
                                    </div>
                                </div>
                            </div>

                            <?php if ($xdata2['store_type'] == 'physical') : ?>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label>
                                            <?php echo $this->lang->line("Store pickup title"); ?>
                                        </label>
                                        <div class="input-group mb-2">
                                            <input type="text" name="store_pickup_title" id="store_pickup_title"
                                                   class="form-control"
                                                   value="<?php echo isset($xvalue['store_pickup_title']) ? $xvalue['store_pickup_title'] : "Store Pickup"; ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><?php echo $this->lang->line('Hide Add to Cart Button'); ?></label>
                                    <br>
                                    <?php
                                    $hide_add_to_cart = isset($xvalue['hide_add_to_cart']) ? $xvalue['hide_add_to_cart'] : "0";
                                    ?>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="hide_add_to_cart" value="1"
                                               class="custom-switch-input" <?php if ($hide_add_to_cart == '1') echo 'checked'; ?>>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"><?php echo $this->lang->line('Hide'); ?></span>
                                        <span class="text-danger"><?php echo form_error('hide_add_to_cart'); ?></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for=""><?php echo $this->lang->line('Hide Buy Now Button'); ?></label>
                                    <br>
                                    <?php
                                    $hide_buy_now = isset($xvalue['hide_buy_now']) ? $xvalue['hide_buy_now'] : "0";
                                    ?>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="hide_buy_now" value="1"
                                               class="custom-switch-input" <?php if ($hide_buy_now == '1') echo 'checked'; ?>>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description"><?php echo $this->lang->line('Hide'); ?></span>
                                        <span class="text-danger"><?php echo form_error('hide_buy_now'); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <?php
                        if ($this->basic->is_exist("modules", array("id" => 310))) :
                            if ($this->session->userdata('user_type') == 'Admin' || in_array(310, $this->module_access)) :
                                ?>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for=""><?php echo $this->lang->line('Whatsapp Send Order Button'); ?></label>
                                            <br>
                                            <?php
                                            $whatsapp_send_order_button = isset($xvalue['whatsapp_send_order_button']) ? $xvalue['whatsapp_send_order_button'] : "0";
                                            ?>
                                            <label class="custom-switch mt-2">
                                                <input type="checkbox" id="whatsapp_send_order_button"
                                                       name="whatsapp_send_order_button" value="1"
                                                       class="custom-switch-input" <?php if ($whatsapp_send_order_button == '1') echo 'checked'; ?>>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description"><?php echo $this->lang->line('Hide'); ?></span>
                                                <span class="text-danger"><?php echo form_error('whatsapp_send_order_button'); ?></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 whatsapp_phone_number_div" <?php if ($whatsapp_send_order_button == '1') echo 'style="display:block"'; else echo 'style="display:none"' ?>>
                                        <div class="form-group">
                                            <label for=""><?php echo $this->lang->line('Whatsapp Phone Number'); ?>
                                                <span class="text-danger">*</span></label>
                                            <br>
                                            <?php
                                            $whatsapp_phone_number = isset($xvalue['whatsapp_phone_number']) ? $xvalue['whatsapp_phone_number'] : "";
                                            ?>
                                            <input type="text" name="whatsapp_phone_number" id="whatsapp_phone_number"
                                                   value="<?php echo $whatsapp_phone_number; ?>" class="form-control"
                                                   placeholder="<?php echo $this->lang->line('Type phone number with country code'); ?>">
                                            <span class="text-danger"><?php echo form_error('whatsapp_phone_number'); ?></span>
                                        </div>
                                    </div>

                                    <div class="col-12 whatsapp_message_div" <?php if ($whatsapp_send_order_button == '1') echo 'style="display:block"'; else echo 'style="display:none"' ?>>
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line('Whatsapp Send Order text'); ?></label>
                                            <a id="variables" class="float-right text-warning pointer"><i
                                                        class="bx bx-circle"></i> <?php echo $this->lang->line("Variables"); ?>
                                            </a>

                                            <textarea name="whatsapp_send_order_text" id="whatsapp_send_order_text"
                                                      cols="30" rows="10" class="form-control whatsapp_send_order_text"
                                                      style="height:250px !important;"><?php echo !empty($xvalue['whatsapp_send_order_text']) ? $xvalue['whatsapp_send_order_text'] : $default_whatsapp_send_order_text; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                            <?php endif; ?>
                        <?php endif; ?>


                        <div class="card-footer p-0">
                            <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bx-save"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span>
                            </button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>



