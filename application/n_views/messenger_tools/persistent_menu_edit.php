<?php
$item_json_array = json_decode($xdata["item_json"], true);
$current_postbacks = json_decode($xdata["poskback_id_json"], true);
$text_with_button_counter_level1_js = isset($item_json_array['call_to_actions']) ? count($item_json_array['call_to_actions']) : 0;
$media_type = $this->session->userdata('selected_global_media_type');
?>

<div class="clearfix"></div>
<?php

if ($this->session->userdata('user_type') == 'Member' && in_array(198, $this->module_access)) $level1 = 19;
else $level1 = 20;

$level2 = 0;
$level3 = 0;

$postback_id_array = array();
foreach ($postback_ids as $value) {
    if (!in_array($value['postback_id'], $current_postbacks))
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
        margin: 10px 0;
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
    <div class="modal-dialog modal-lg" style="max-width: 100%">
        <div class="modal-content shadow-none">
            <?php if ($iframe != '1') : ?>
                <div class="modal-header">
                    <h3 class="modal-title"><i
                                class="bx bx-edit"></i> <?php echo $this->lang->line("Edit Persistent Menu"); ?> [<a
                                href="https://facebook.com/<?php echo $page_info['page_id']; ?>"><?php echo $page_info['page_name']; ?></a>]
                    </h3>
                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                                class="bx bx-x"></i></button>
                </div>
            <?php endif; ?>
            <div class="modal-body p-0">
                <form id="messenger_bot_form">
                    <input type="hidden" name="page_table_id" id="page_table_id" value="<?php echo $page_auto_id; ?>">
                    <input type="hidden" name="auto_id" id="auto_id" value="<?php echo $xdata["id"]; ?>">
                    <textarea id="current_postbacks" name="current_postbacks"
                              class="hidden"><?php echo $xdata["poskback_id_json"]; ?></textarea>
                    <input type="hidden" name="level1_limit" value="<?php echo $level1; ?>">
                    <input type="hidden" name="level2_limit" value="<?php echo $level2; ?>">
                    <input type="hidden" name="level3_limit" value="<?php echo $level3; ?>">

                    <?php
                    if ($started_button_enabled == '0') echo "<div class='alert alert-warning text-center'>" . $this->lang->line("To create persistent menu you must enable get started button first.") . "</div>";
                    else { ?>
                        <div class="row">
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Locale"); ?></label>
                                    <?php echo form_dropdown('locale', $locale, $xdata["locale"], 'class="form-control" id="locale"'); ?>
                                </div>
                            </div>
                            <?php if ($media_type == "fb") { ?>
                                <div class="col-6 col-md-4">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Composer Input Disabled?"); ?></label>
                                        <select class="form-control" id="composer_input_disabled"
                                                name="composer_input_disabled">
                                            <option <?php if ($xdata["composer_input_disabled"] == '1') echo 'selected'; ?>
                                                    value="1"><?php echo $this->lang->line("Yes"); ?></option>
                                            <option <?php if ($xdata["composer_input_disabled"] == '0') echo 'selected'; ?>
                                                    value="0"><?php echo $this->lang->line("No"); ?></option>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-12 col-md-4">
                            </div>
                        </div>

                        <?php
                        for ($i = 1; $i <= $level1; $i++) {
                            $level1_xtitle = isset($item_json_array["call_to_actions"][$i]["title"]) ? $item_json_array["call_to_actions"][$i]["title"] : "";
                            $level1_xtype = isset($item_json_array["call_to_actions"][$i]["type"]) ? $item_json_array["call_to_actions"][$i]["type"] : "web_url";
                            if ($level1_xtype == 'postback') $level1_xtype = 'post_back'; // stored as postback in database
                            $level1_xpostback = isset($item_json_array["call_to_actions"][$i]["payload"]) ? $item_json_array["call_to_actions"][$i]["payload"] : "";
                            $level1_xurl = isset($item_json_array["call_to_actions"][$i]["url"]) ? $item_json_array["call_to_actions"][$i]["url"] : "";
                            ?>

                            <div class="card card-primary level1<?php if (!isset($item_json_array["call_to_actions"][$i])) echo ' hidden'; ?>"
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
                                                <input value="<?php echo $level1_xtitle; ?>" type="text"
                                                       class="form-control"
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
                                                    <option <?php if ($level1_xtype == 'web_url' || $level1_xtype == 'nested') echo 'selected'; ?>
                                                            value="web_url"><?php echo $this->lang->line("Web URL"); ?></option>
                                                    <option <?php if ($level1_xtype == 'post_back') echo 'selected'; ?>
                                                            value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                    <!-- <option <?php if ($level1_xtype == 'nested') echo 'selected'; ?> value="nested"><?php echo $this->lang->line("Nested"); ?></option> -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-8 col-md-4">
                                            <div class="form-group"
                                                 id="text_with_button_postid_div_<?php echo $i; ?>" <?php if ($level1_xtype != 'post_back') echo 'style="display: none;"'; ?>>

                                                <?php
                                                $pname = "text_with_button_post_id_" . $i;
                                                $pdefault = $level1_xpostback;
                                                echo form_dropdown($pname, $poption, $pdefault, 'class="form-control push_postback" id="' . $pname . '"');
                                                ?>
                                                <a href="" class="add_template float-left"><i
                                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                </a>
                                                <a href="" class="ref_template float-right"><i
                                                            class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                </a>


                                            </div>
                                            <div class="form-group"
                                                 id="text_with_button_web_url_div_<?php echo $i; ?>" <?php if ($level1_xtype != 'web_url') echo 'style="display: none;"'; ?>>
                                                <input value="<?php echo $level1_xurl; ?>" type="text"
                                                       class="form-control"
                                                       placeholder="<?php echo $this->lang->line("web url"); ?>"
                                                       name="text_with_button_web_url_<?php echo $i; ?>"
                                                       id="text_with_button_web_url_<?php echo $i; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    for ($j = 1; $j <= $level2; $j++) {
                                        $level2_xtitle = isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["title"]) ? $item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["title"] : "";
                                        $level2_xtype = isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["type"]) ? $item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["type"] : "web_url";
                                        if ($level2_xtype == 'postback') $level2_xtype = 'post_back'; // stored as postback in database
                                        $level2_xpostback = isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["payload"]) ? $item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["payload"] : "";
                                        $level2_xurl = isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["url"]) ? $item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["url"] : "";
                                        ?>

                                        <div class="card card-warning level2<?php if (!isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j])) echo ' hidden'; ?>"
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
                                                            <input value="<?php echo $level2_xtitle; ?>" type="text"
                                                                   class="form-control"
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
                                                                <option <?php if ($level2_xtype == 'web_url' || $level1_xtype == 'nested') echo 'selected'; ?>
                                                                        value="web_url"><?php echo $this->lang->line("Web URL"); ?></option>
                                                                <option <?php if ($level2_xtype == 'post_back') echo 'selected'; ?>
                                                                        value="post_back"><?php echo $this->lang->line("Post Back"); ?></option>
                                                                <!-- <option <?php if ($level2_xtype == 'nested') echo 'selected'; ?> value="nested"><?php echo $this->lang->line("Nested"); ?></option> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-8 col-md-4">
                                                        <div class="form-group"
                                                             id="text_with_button_postid_div_<?php echo $i; ?>_<?php echo $j; ?>" <?php if ($level2_xtype != 'post_back') echo 'style="display: none;"'; ?>>
                                                            <!-- <input value="<?php echo $level2_xpostback; ?>" type="text" class="form-control" placeholder="<?php echo $this->lang->line("PostBack id"); ?>" name="text_with_button_post_id_<?php echo $i; ?>_<?php echo $j; ?>" id="text_with_button_post_id_<?php echo $i; ?>_<?php echo $j; ?>"> -->

                                                            <?php
                                                            $pname = "text_with_button_post_id_" . $i . "_" . $j;
                                                            $pdefault = $level2_xpostback;
                                                            echo form_dropdown($pname, $poption, $pdefault, 'class="form-control push_postback" id="' . $pname . '"');
                                                            ?>
                                                            <a href="" class="add_template float-left"><i
                                                                        class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                            </a>
                                                            <a href="" class="ref_template float-right"><i
                                                                        class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                            </a>

                                                        </div>
                                                        <div class="form-group"
                                                             id="text_with_button_web_url_div_<?php echo $i; ?>_<?php echo $j; ?>" <?php if ($level2_xtype != 'web_url') echo 'style="display: none;"'; ?>>
                                                            <input value="<?php echo $level2_xurl; ?>" type="text"
                                                                   class="form-control"
                                                                   placeholder="<?php echo $this->lang->line("web url"); ?>"
                                                                   name="text_with_button_web_url_<?php echo $i; ?>_<?php echo $j; ?>"
                                                                   id="text_with_button_web_url_<?php echo $i; ?>_<?php echo $j; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                for ($k = 1; $k <= $level3; $k++) {
                                                    $level3_xtitle = isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"][$k]["title"]) ? $item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"][$k]["title"] : "";
                                                    $level3_xtype = isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"][$k]["type"]) ? $item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"][$k]["type"] : "web_url";
                                                    if ($level3_xtype == 'postback') $level3_xtype = 'post_back'; // stored as postback in database
                                                    $level3_xpostback = isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"][$k]["payload"]) ? $item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"][$k]["payload"] : "";
                                                    $level3_xurl = isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"][$k]["url"]) ? $item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"][$k]["url"] : "";
                                                    ?>
                                                    <div class="card card-secondary level3<?php if (!isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"][$k])) echo ' hidden'; ?>"
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
                                                                        <input value="<?php echo $level3_xtitle; ?>"
                                                                               type="text" class="form-control"
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
                                                                            <option value="web_url" <?php if ($level3_xtype == 'web_url') echo 'selected'; ?> ><?php echo $this->lang->line("Web URL"); ?></option>
                                                                            <option value="post_back" <?php if ($level3_xtype == 'post_back') echo 'selected'; ?>><?php echo $this->lang->line("Post Back"); ?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-8 col-md-4">
                                                                    <div class="form-group"
                                                                         id="text_with_button_postid_div_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>" <?php if ($level3_xtype != 'post_back') echo 'style="display: none;"'; ?>>
                                                                        <?php
                                                                        $pname = "text_with_button_post_id_" . $i . "_" . $j . "_" . $k;
                                                                        $pdefault = $level3_xpostback;
                                                                        echo form_dropdown($pname, $poption, $pdefault, 'class="form-control push_postback" id="' . $pname . '"');
                                                                        ?>
                                                                        <a href="" class="add_template float-left"><i
                                                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                                                        </a>
                                                                        <a href="" class="ref_template float-right"><i
                                                                                    class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                                                        </a>

                                                                    </div>
                                                                    <div class="form-group"
                                                                         id="text_with_button_web_url_div_<?php echo $i; ?>_<?php echo $j; ?>_<?php echo $k; ?>" <?php if ($level3_xtype != 'web_url') echo 'style="display: none;"'; ?>>
                                                                        <input value="<?php echo $level3_xurl; ?>"
                                                                               type="text" class="form-control"
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

                                                <?php
                                                $level3_add_hide = '';
                                                $level3_remove_hide = '';
                                                $tempu3 = isset($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"]) ? count($item_json_array["call_to_actions"][$i]["call_to_actions"][$j]["call_to_actions"]) : 0;
                                                if ($tempu3 >= $level3 || $level2_xtype != 'nested') $level3_add_hide = 'hidden';
                                                if ($tempu3 <= 1 || $level2_xtype != 'nested') $level3_remove_hide = 'hidden';
                                                ?>

                                                <a href="#" style="border-radius: 0;"
                                                   class="btn btn-sm btn-outline-primary float-right level3_add <?php echo $level3_add_hide; ?>"
                                                   id="add_more_<?php echo $i ?>_<?php echo $j ?>"><i
                                                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("level-3 menu"); ?>
                                                </a>
                                                <a href="#" style="border-radius: 0;margin-right:2px;"
                                                   class="btn btn-sm btn-outline-danger float-right level3_remove  <?php echo $level3_remove_hide; ?>"
                                                   id="remove_menu_<?php echo $i ?>_<?php echo $j ?>"><i
                                                            class="bx bx-trash"></i> <?php echo $this->lang->line("remove"); ?>
                                                </a>
                                                <div class="clearfix"></div>
                                            </div> <!-- level2 card body end -->
                                        </div> <!-- level2 end -->
                                        <?php
                                    } ?>

                                    <?php
                                    $level2_add_hide = '';
                                    $level2_remove_hide = '';
                                    $tempu2 = isset($item_json_array["call_to_actions"][$i]["call_to_actions"]) ? count($item_json_array["call_to_actions"][$i]["call_to_actions"]) : 0;
                                    if ($tempu2 >= $level2 || $level1_xtype != 'nested') $level2_add_hide = 'hidden';
                                    if ($tempu2 <= 1 || $level1_xtype != 'nested') $level2_remove_hide = 'hidden';
                                    ?>

                                    <a href="#" style="border-radius: 0;"
                                       class="btn btn-sm btn-outline-primary float-right level2_add <?php echo $level2_add_hide; ?>"
                                       id="add_more_<?php echo $i ?>"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("level-2 menu"); ?>
                                    </a>
                                    <a href="#" style="border-radius: 0;margin-right:2px;"
                                       class="btn btn-sm btn-outline-danger float-right level2_remove <?php echo $level2_remove_hide; ?>"
                                       id="remove_menu_<?php echo $i ?>"><i
                                                class="bx bx-trash"></i> <?php echo $this->lang->line("remove"); ?></a>
                                    <div class="clearfix"></div>
                                </div> <!-- leve1 card body end -->
                            </div> <!-- leve1 end -->
                            <?php
                        } ?>

                        <a href="#" style="border-radius: 0;"
                           class="btn btn-sm btn-outline-primary float-right <?php if ($text_with_button_counter_level1_js >= $level1) echo 'hidden'; ?>"
                           id="add_more"><i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?></a>
                        <a href="#" style="border-radius: 0;margin-right:2px;"
                           class="btn btn-sm btn-outline-danger float-right <?php if ($text_with_button_counter_level1_js <= 1) echo 'hidden'; ?>"
                           id="remove_menu"><i class="bx bx-trash"></i> <?php echo $this->lang->line("remove"); ?></a>
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

