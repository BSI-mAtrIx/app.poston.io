<?php

if ($this->session->userdata('user_type') == 'Member' && in_array(198, $this->module_access)) $level1 = 19;
else $level1 = 20;

$media_type = $this->session->userdata('selected_global_media_type');

$level2 = 0;
$level3 = 0;

$postback_id_array = array();
foreach ($postback_ids as $value) {
    $postback_id_array[] = strtoupper($value['postback_id']);
}
$max_length = $this->lang->line("max_length");
$max_length = str_replace(array(' <b>%s</b> ', '<b>%s</b> '), array(" 30 ", $this->lang->line('menu title') . " "), $max_length);
?>


<style type="text/css">
    .add_template, .ref_template {
        font-size: 10px;
    }

    .form-control {
        /* border-radius: 10px !important; */
        height: 40px;
    }

    .modal-body h1 {
        width: 100%;
        margin: 20px 0;
        font-size: 20px;
    }

    .modal-body h2 {
        width: 100%;
        margin: 15px 0;
        font-size: 17px;
    }

    .modal-body h3 {
        width: 100%;
        margin: 10px 0;
        font-size: 15px;
    }

    .level1_title, .level2_title, .level3_title {
        color: <?php $THEMECOLORCODE;?> !important;
    }

    /*   .level1 .form-control{ border: 1px dashed orange;}
      .level2 .form-control {border: 1px dashed #00c0ef;}
      .level3 .form-control{ border: 1px dashed #999;} */
</style>


<div id="persistent_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="max-width: 100%">
        <div class="modal-content shadow-none">
            <?php if ($iframe != '1') : ?>
                <div class="modal-header">
                    <h3 class="modal-title"><i
                                class="bx bx-list-ul"></i> <?php echo $this->lang->line("Persistent Menu"); ?> [<a
                                href="https://facebook.com/<?php echo $page_info['page_id']; ?>"><?php echo $page_info['page_name']; ?></a>]
                    </h3>
                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                                class="bx bx-x"></i></button>
                </div>
            <?php endif; ?>
            <div class="modal-body p-0">
                <form id="messenger_bot_form">
                    <input type="hidden" name="page_table_id" id="page_table_id" value="<?php echo $page_auto_id; ?>">
                    <input type="hidden" name="level1_limit" value="<?php echo $level1; ?>">
                    <input type="hidden" name="level2_limit" value="<?php echo $level2; ?>">
                    <input type="hidden" name="level3_limit" value="<?php echo $level3; ?>">

                    <?php
                    if ($started_button_enabled == '0') echo "<div class='alert alert-warning text-center'>" . $this->lang->line("To create persistent menu you must enable get started button first.") . "</div>";
                    else { ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Locale"); ?></label>
                                    <?php echo form_dropdown('locale', $locale, 'default', 'class="form-control" id="locale"'); ?>
                                </div>
                            </div>

                            <?php if ($media_type == "fb") { ?>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Composer Input Disabled?"); ?></label>
                                        <select class="form-control" id="composer_input_disabled"
                                                name="composer_input_disabled">
                                            <option value="1"><?php echo $this->lang->line("Yes"); ?></option>
                                            <option value="0" selected><?php echo $this->lang->line("No"); ?></option>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <?php
                        for ($i = 1; $i <= $level1; $i++) { ?>
                            <div class="card card-primary level1<?php if ($i > 1) echo ' hidden'; ?>"
                                 id="text_with_buttons_row_<?php echo $i; ?>">
                                <div class="card-header">
                                    <h4 class="full_width level1_title">
                                        <?php echo $this->lang->line("Menu"); ?>
                                    </h4>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                       placeholder="<?php echo $this->lang->line("menu title"); ?>"
                                                       name="text_with_buttons_text_<?php echo $i; ?>"
                                                       id="text_with_buttons_text_<?php echo $i; ?>">
                                            </div>
                                        </div>
                                        <div class="col-4 col-md-4">
                                            <div class="form-group">
                                                <select class="form-control text_with_button_type_class_level1"
                                                        id="text_with_button_type_<?php echo $i; ?>"
                                                        name="text_with_button_type_<?php echo $i; ?>">
                                                    <!-- <option value=""><?php echo $this->lang->line('please select a type'); ?></option> -->
                                                    <option value="web_url"><?php echo $this->lang->line("Web URL"); ?></option>
                                                    <option value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                    <!-- <option value="nested"><?php echo $this->lang->line("Nested"); ?></option> -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-4">
                                            <div class="form-group" id="text_with_button_postid_div_<?php echo $i; ?>"
                                                 style="display: none;">
                                                <!-- <input type="text" class="form-control" placeholder="<?php echo $this->lang->line("PostBack id"); ?>" name="text_with_button_post_id_<?php echo $i; ?>" id="text_with_button_post_id_<?php echo $i; ?>"> -->
                                                <select class="form-control push_postback"
                                                        name="text_with_button_post_id_<?php echo $i; ?>"
                                                        id="text_with_button_post_id_<?php echo $i; ?>">
                                                    <option value=""><?php echo $this->lang->line("Select PostBack id"); ?></option>
                                                </select>
                                                <a href="" class="add_template float-left"><i
                                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                </a>
                                                <a href="" class="ref_template float-right"><i
                                                            class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                </a>
                                            </div>
                                            <div class="form-group" id="text_with_button_web_url_div_<?php echo $i; ?>">
                                                <input type="text" class="form-control"
                                                       placeholder="<?php echo $this->lang->line("web url"); ?>"
                                                       name="text_with_button_web_url_<?php echo $i; ?>"
                                                       id="text_with_button_web_url_<?php echo $i; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    for ($j = 1; $j <= $level2; $j++) { ?>
                                        <div class="card card-warning level2<?php if ($j > 0) echo ' hidden'; ?>"
                                             id="text_with_buttons_row_<?php echo $i; ?>_<?php echo $j; ?>">
                                            <div class="card-header">
                                                <h4 class="full_width level2_title">
                                                    <?php echo $this->lang->line("level-2 menu"); ?>
                                                </h4>
                                            </div>
                                            <div class="card-body">

                                                <div class="row">
                                                    <div class="col-12 col-md-4">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                   placeholder="<?php echo $this->lang->line("menu title"); ?>"
                                                                   name="text_with_buttons_text_<?php echo $i; ?>_<?php echo $j; ?>"
                                                                   id="text_with_buttons_text_<?php echo $i; ?>_<?php echo $j; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-4 col-md-4">
                                                        <div class="form-group">
                                                            <select class="form-control text_with_button_type_class_level2"
                                                                    id="text_with_button_type_<?php echo $i; ?>_<?php echo $j; ?>"
                                                                    name="text_with_button_type_<?php echo $i; ?>_<?php echo $j; ?>">
                                                                <!-- <option value=""><?php echo $this->lang->line('please select a type'); ?></option> -->
                                                                <option value="web_url"><?php echo $this->lang->line("Web URL"); ?></option>
                                                                <option value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                                <!-- <option value="nested"><?php echo $this->lang->line("Nested"); ?></option> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-8 col-md-4">
                                                        <div class="form-group"
                                                             id="text_with_button_postid_div_<?php echo $i; ?>_<?php echo $j; ?>"
                                                             style="display: none;">

                                                            <select class="form-control push_postback"
                                                                    name="text_with_button_post_id_<?php echo $i; ?>_<?php echo $j; ?>"
                                                                    id="text_with_button_post_id_<?php echo $i; ?>_<?php echo $j; ?>">
                                                                <option value=""><?php echo $this->lang->line("Select PostBack id"); ?></option>
                                                            </select>
                                                            <a href="" class="add_template float-left"><i
                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                            </a>
                                                            <a href="" class="ref_template float-right"><i
                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                            </a>
                                                        </div>
                                                        <div class="form-group"
                                                             id="text_with_button_web_url_div_<?php echo $i; ?>_<?php echo $j; ?>">
                                                            <input type="text" class="form-control"
                                                                   placeholder="<?php echo $this->lang->line("web url"); ?>"
                                                                   name="text_with_button_web_url_<?php echo $i; ?>_<?php echo $j; ?>"
                                                                   id="text_with_button_web_url_<?php echo $i; ?>_<?php echo $j; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                for ($k = 1; $k <= $level3; $k++) { ?>
                                                    <div class="card card-secondary level3<?php if ($k > 0) echo ' hidden'; ?>"
                                                         id="text_with_buttons_row_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>">
                                                        <div class="card-header">
                                                            <h4 class="full_width level3_title">
                                                                <?php echo $this->lang->line("level-3 menu"); ?>
                                                            </h4>
                                                        </div>
                                                        <div class="card-body">

                                                            <div class="row">
                                                                <div class="col-12 col-md-4">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control"
                                                                               placeholder="<?php echo $this->lang->line("menu title"); ?>"
                                                                               name="text_with_buttons_text_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                               id="text_with_buttons_text_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 col-md-4">
                                                                    <div class="form-group">
                                                                        <select class="form-control text_with_button_type_class_level3"
                                                                                id="text_with_button_type_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                name="text_with_button_type_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>">
                                                                            <!-- <option value=""><?php echo $this->lang->line('please select a type'); ?></option> -->
                                                                            <option value="web_url"><?php echo $this->lang->line("Web URL"); ?></option>
                                                                            <option value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-8 col-md-4">
                                                                    <div class="form-group"
                                                                         id="text_with_button_postid_div_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                         style="display: none;">

                                                                        <select class="form-control push_postback"
                                                                                name="text_with_button_post_id_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                                id="text_with_button_post_id_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>">
                                                                            <option value=""><?php echo $this->lang->line("Select PostBack id"); ?></option>
                                                                        </select>
                                                                        <a href="" class="add_template float-left"><i
                                                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                                        </a>
                                                                        <a href="" class="ref_template float-right"><i
                                                                                    class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                                        </a>
                                                                    </div>
                                                                    <div class="form-group"
                                                                         id="text_with_button_web_url_div_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>">
                                                                        <input type="text" class="form-control"
                                                                               placeholder="<?php echo $this->lang->line("web url"); ?>"
                                                                               name="text_with_button_web_url_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>"
                                                                               id="text_with_button_web_url_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <!-- level3 card body end -->
                                                    </div> <!-- level3 end -->
                                                    <?php
                                                } ?>
                                                <a href="#" style="border-radius: 0;"
                                                   class="btn btn-sm btn-outline-primary float-right level3_add hidden"
                                                   id="add_more_<?php echo $i ?>_<?php echo $j ?>"><i
                                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("level-3 menu"); ?>
                                                </a>
                                                <a href="#" style="border-radius: 0;margin-right:2px;"
                                                   class="btn btn-sm btn-outline-danger float-right level3_remove hidden"
                                                   id="remove_menu_<?php echo $i ?>_<?php echo $j ?>"><i
                                                            class="bx bx-trash"></i> <?php echo $this->lang->line("remove"); ?>
                                                </a>
                                                <div class="clearfix"></div>
                                            </div> <!-- level2 card body end -->
                                        </div> <!-- level2 end -->
                                        <?php
                                    } ?>
                                    <a href="#" style="border-radius: 0;"
                                       class="btn btn-sm btn-outline-primary float-right level2_add hidden"
                                       id="add_more_<?php echo $i ?>"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("level-2 menu"); ?>
                                    </a>
                                    <a href="#" style="border-radius: 0;margin-right:2px;"
                                       class="btn btn-sm btn-outline-danger float-right level2_remove hidden"
                                       id="remove_menu_<?php echo $i ?>"><i
                                                class="bx bx-trash"></i> <?php echo $this->lang->line("remove"); ?></a>
                                    <div class="clearfix"></div>
                                </div> <!-- leve1 card body end -->
                            </div> <!-- leve1 end -->
                            <?php
                        } ?>
                        <a href="#" style="border-radius: 0;" class="btn btn-sm btn-outline-primary float-right"
                           id="add_more"><i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?></a>
                        <a href="#" style="border-radius: 0;margin-right:2px;"
                           class="btn btn-sm btn-outline-danger float-right hidden" id="remove_menu"
                           style="margin-right:5px"><i
                                    class="bx bx-trash"></i> <?php echo $this->lang->line("remove"); ?></a>
                        <div class="clearfix"></div>

                        <br><br>

                        <div class="row">
                            <div class="col-12">
                                <button id="submit" class="btn btn-primary"><i class="bx bx-send"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span>
                                </button>
                                <a href="<?php echo base_url("messenger_bot/persistent_menu_list/$page_auto_id/1"); ?>"
                                   class="btn btn-secondary float-right"><i class="bx bx-x-circle"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?>
                                </a></button>
                                <br>
                                <br>
                                <div id="submit_status" class="text-center"></div>
                            </div>
                        </div>
                        <?php
                    } ?>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="clearfix"></div>


<div class="modal fade" id="error_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h3 class="modal-title"><i class="bx bx-info-circle"></i> <?php echo $this->lang->line('Error'); ?></h3>
            </div>
            <div class="modal-body">
                <div class="alert text-center alert-warning" id="error_modal_content">

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <iframe width="100%" frameborder="0" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i class="bx bx-sync"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("Close & Refresh List"); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>
