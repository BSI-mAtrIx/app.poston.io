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
    <div class="col-md-4 col-sm-4 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="bx bx-shopping-bag"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4><?php echo $this->lang->line("Package Name") ?></h4>
                </div>
                <div class="card-body">
                    <?php echo $value[0]["package_name"]; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="bx bx-dollar-circle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4><?php echo $this->lang->line("Price") ?>
                        - <?php echo isset($payment_config[0]['currency']) ? $payment_config[0]['currency'] : 'USD'; ?></h4>
                </div>
                <div class="card-body">
                    <?php
                    if ($value[0]['is_default'] == "1") {
                        if ($value[0]["price"] == "Trial") echo $this->lang->line("Trial");
                        if ($value[0]["price"] == "0") echo $this->lang->line("Free");
                    } else echo $value[0]["price"];
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="bx bx-stopwatch"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4><?php echo $this->lang->line("Validity"); ?></h4>
                </div>
                <div class="card-body">
                    <?php echo $validity_amount; ?><?php echo $this->lang->line($validity_type[$validity_type_info]); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h4 class="card-title"><i
                            class="bx bxs-help-circle"></i> <?php echo $this->lang->line("Module Access"); ?></h4></div>
            <div class="card-body">

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
                            if (is_array($current_modules) && !in_array($module['id'], $current_modules)) continue;
                            echo "<tr>";
                            echo "<td class='text-center'>" . $SL . "</td>";
                            echo "<td>" . $module['module_name'] . "</td>";

                            $xmonthly_val = 0;
                            $xbulk_val = 0;

                            if (in_array($module["id"], $current_modules)) {
                                $xmonthly_val = $monthly_limit[$module["id"]];
                                $xbulk_val = $bulk_limit[$module["id"]];
                            }

                            if ($module["limit_enabled"] == '0') {
                                $disabled = " readonly";
                                $limit = $this->lang->line("Unlimited");
                                $style = 'border:none;background:#fff;';
                            } else {
                                $disabled = " readonly";
                                $limit = $module['extra_text'];
                                $style = 'border:none;background:#fff;';
                            }


                            echo "<td align='center'>" . $limit . "</td><td align='center'><input type='text' " . $disabled . " class='form-control' value='" . $xmonthly_val . "' min='0' style='width:70px; " . $style . "' name='monthly_" . $module['id'] . "'></td>";

                            if ($module["bulk_limit_enabled"] == "0") {
                                $disabled = " readonly";
                                $limit = "";
                                $style = 'border:none;background:#fff;';

                            } else {
                                $disabled = " readonly";
                                $limit = "";
                                $style = 'border:none;background:#fff;';
                            }
                            $xval = $xbulk_val;

                            echo "<td align='center'><input type='text' class='form-control' " . $disabled . " value='" . $xval . "'  min='0' style='width:70px; " . $style . "' name='bulk_" . $module['id'] . "'></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" onclick='goBack("payment/package_manager",0)'><i
                            class="bx bx-left-arrow-alt"></i> <?php echo $this->lang->line("Go back"); ?></button>
            </div>
        </div>
    </div>
</div>


<style type="text/css" media="screen">
    table label {
        margin-top: 10px;
    }
</style>