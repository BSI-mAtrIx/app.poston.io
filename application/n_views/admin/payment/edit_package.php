<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('payment/package_manager'); ?>"><?php echo $this->lang->line("Package Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>


<div class="row">
    <div class="col-12">

        <form class="form-horizontal" action="<?php echo site_url() . 'payment/edit_package_action'; ?>" method="POST">
            <input type="hidden" name="csrf_token" id="csrf_token"
                   value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
            <input name="id" value="<?php echo $value[0]["id"]; ?>" class="form-control" type="hidden">
            <input name="is_default" value="<?php echo $value[0]["is_default"]; ?>" class="form-control" type="hidden">

            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name"> <?php echo $this->lang->line("Package Name") ?> *</label>
                                <input name="name" value="<?php echo $value[0]["package_name"]; ?>" class="form-control"
                                       type="text">
                                <span class="text-danger"><?php echo form_error('name'); ?></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="price"><?php echo $this->lang->line("Price") ?>
                                    - <?php echo isset($payment_config[0]['currency']) ? $payment_config[0]['currency'] : 'USD'; ?>
                                    *</label>
                                <?php
                                if ($value[0]['is_default'] == "1") { ?>
                                    <select name="price" id="price_default" class="select2 form-control">
                                        <option value="Trial" <?php if ($value[0]["price"] == "Trial") echo 'selected="yes"'; ?>><?php echo $this->lang->line("Trial"); ?></option>
                                        <option value="0" <?php if ($value[0]["price"] == "0") echo 'selected="yes"'; ?>><?php echo $this->lang->line("Free"); ?></option>
                                    </select>
                                    <?php
                                } else { ?>
                                    <input name="price" value="<?php echo $value[0]["price"]; ?>" class="form-control"
                                           type="text">
                                    <?php
                                }
                                ?>
                                <span class="text-danger"><?php echo form_error('price'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="hidden">
                        <label for="price"><?php echo $this->lang->line("Validity"); ?> *</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" name="validity_amount" value="<?php echo $validity_amount; ?>"
                                       class="form-control">
                            </div>
                            <div class="col-6">
                                <?php echo form_dropdown('validity_type', $validity_type, $validity_type_info, 'class="select2 form-control" style="width:100%"'); ?>
                            </div>
                        </div>
                        <span class="text-danger"><?php echo form_error('validity_amount'); ?></span>

                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="visible"><i
                                            class="bx bx-dollar-circle"></i> <?php echo $this->lang->line('Available to Purchase'); ?>
                                </label>

                                <div class="form-group">
                                    <?php
                                    $visible = $value[0]["visible"];
                                    if ($visible == '') $visible = '1';
                                    ?>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="visible" id="visible" value="1"
                                               class="custom-control-input" <?php if ($visible == '1') echo 'checked'; ?>>
                                        <label class="custom-control-label mr-1" for="visible"></label>
                                        <span><?php echo $this->lang->line('Yes'); ?></span>
                                        <span class="text-danger"><?php echo form_error('visible'); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group" id="highlight_container">
                                <label for="highlight"><i
                                            class="bx bx-bulb"></i> <?php echo $this->lang->line('Highlighted Package'); ?>
                                </label>

                                <div class="form-group">
                                    <?php
                                    $highlight = $value[0]["highlight"];
                                    if ($highlight == '') $highlight = '0';
                                    ?>
                                    <label class="custom-switch mt-2">
                                        <input type="checkbox" name="highlight" id="highlight" value="1"
                                               class="custom-control-input" <?php if ($highlight == '1') echo 'checked'; ?>>
                                        <label class="custom-control-label mr-1" for="highlight"></label>
                                        <span><?php echo $this->lang->line('Yes'); ?></span>
                                        <span class="text-danger"><?php echo form_error('highlight'); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for=""><?php echo $this->lang->line("Modules") ?> *</label>
                        <?php $mandatory_modules = array(65, 66, 199, 200); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <?php
                                $current_modules = array();
                                $current_modules = explode(',', $value[0]["module_ids"]);
                                $monthly_limit = json_decode($value[0]["monthly_limit"], true);
                                $bulk_limit = json_decode($value[0]["bulk_limit"], true);

                                echo "<tr>";
                                echo "<th class='info' width='20px'>";
                                echo $this->lang->line("#");
                                echo "</th>";
                                echo "<th class='text-center info' width='20px'>";
                                echo '<input class="regular-checkbox" id="all_modules" type="checkbox"/><label for="all_modules"></label>';
                                echo "</th>";
                                echo "<th class='info'>";
                                echo $this->lang->line("Module");
                                echo "</th>";
                                echo "<th class='text-center info' colspan='2'>";
                                echo $this->lang->line("Usage Limit");
                                echo "</th>";
                                echo "<th class='text-center info' colspan='2'>";
                                echo $this->lang->line("Bulk Limit");
                                echo "</th>";
                                echo "</tr>";

                                $SL = 0;
                                foreach ($modules as $module) {
                                    $SL++;
                                    echo "<tr>";
                                    echo "<td class='text-center'>" . $SL . "</td>";
                                    echo "<td class='text-center'>";
                                    $check_module = '';
                                    if (is_array($current_modules) && in_array($module['id'], $current_modules)) $check_module = 'checked'; ?>
                                    <input name="modules[]" id="box<?php echo $SL; ?>"
                                           class="modules regular-checkbox <?php if (in_array($module['id'], $mandatory_modules)) echo 'mandatory'; ?>" <?php echo $check_module; ?> <?php if (in_array($module['id'], $mandatory_modules)) echo 'checked onclick="return false;"'; ?>
                                           type="checkbox" value="<?php echo $module['id']; ?>"/> <?php echo $module['id']; ?><?php

                                    $style = "style='cursor:pointer;'";
                                    if (in_array($module['id'], $mandatory_modules)) $style = "style='border-color:#6777EF;cursor:pointer;' title='" . $this->lang->line('This is a mandatory module and can not be unchecked.') . "' data-toggle='tooltip'";


                                    echo "<label for='box" . $SL . "' " . $style . "></label>";
                                    echo "</td>";

                                    echo "<td>" . $module['module_name'] . "</td>";

                                    $xmonthly_val = 0;
                                    $xbulk_val = 0;

                                    if (in_array($module["id"], $current_modules)) {
                                        $xmonthly_val = $monthly_limit[$module["id"]];

                                        if(empty($bulk_limit[$module["id"]])){
                                            $bulk_limit[$module["id"]] = 0;
                                        }
                                        $xbulk_val = $bulk_limit[$module["id"]];
                                    }

                                    if ($module["limit_enabled"] == '0') {
                                        $disabled = " readonly";
                                        $limit = $this->lang->line("Unlimited");
                                        $style = 'background:#ddd';
                                    } else {
                                        $disabled = "";
                                        $limit = $module['extra_text'];
                                        $style = '';
                                    }


                                    echo "<td align='center'>" . $limit . "</td><td align='center'><input type='number' " . $disabled . " class='form-control' value='" . $xmonthly_val . "' min='0' style='width:70px; " . $style . "' name='monthly_" . $module['id'] . "'></td>";

                                    if ($module["bulk_limit_enabled"] == "0") {
                                        $disabled = " readonly";
                                        $limit = "";
                                        $style = 'background:#ddd';

                                    } else {
                                        $disabled = "";
                                        $limit = "";
                                        $style = '';
                                    }
                                    $xval = $xbulk_val;

                                    echo "<td align='center'><input type='number' class='form-control' " . $disabled . " value='" . $xval . "'  min='0' style='width:70px; " . $style . "' name='bulk_" . $module['id'] . "'></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </table>
                        </div>
                        <span class="text-danger"><?php echo "<br/><br/>" . form_error('modules[]'); ?></span>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button name="submit" type="submit" class="btn btn-primary"><i class="bx bxs-save"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    <button type="button" class="btn btn-secondary float-right"
                            onclick='goBack("payment/package_manager",0)'><i class="bx bx-trash"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>
                </div>
            </div>
        </form>
    </div>
</div>


<style type="text/css" media="screen">
    table label {
        margin-top: 10px;
    }
</style>