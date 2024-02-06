<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4 style="width: 100%"><i
                        class="bx bx-wrench"></i>&nbsp;<?php echo $this->config->item('product_short_name') . ' ' . $this->lang->line("Updates"); ?>
                <code class="float-right"><?php echo $this->lang->line('Your Version'); ?> :
                    <b>v<?php echo $current_version; ?></b></code></h4>
        </div>

        <div class="card-body">

            <?php
            if (count($update_versions) > 0) { ?>
                <div class="table-responsive2">
                    <table class='table table-bordered table-striped table-md'>
                        <tr class='head'>
                            <th style='text-align: center;'><?php echo $this->lang->line('Version'); ?></th>
                            <th style='text-align: center;'><?php echo $this->lang->line('Change Log'); ?></th>
                            <th style='text-align: center;'><?php echo $this->lang->line('Actions'); ?></th>
                        </tr>

                        <?php
                        $i = 1;
                        foreach ($update_versions as $update_version) {
                            $files_replaces = json_decode($update_version->f_source_and_replace);
                            $sql_cmd_array = explode(';', $update_version->sql_cmd);
                            $modal = "modal" . $i;
                            ?>
                            <tr>
                                <td style='text-align: center;'>
                                    <div class="badge badge-info">v<?php echo $update_version->version; ?></div>
                                </td>
                                <td style='text-align: center;'>
                                    <button class='btn btn-outline-primary' data-toggle="modal"
                                            data-target="#<?php echo $modal; ?>"><i
                                                class='bx bx-show'></i> <?php echo $this->lang->line('See Log'); ?>
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" tabindex="-1" role="dialog" id="<?php echo $modal; ?>"
                                         data-backdrop="static" data-keyboard="false">
                                        <div class="modal-dialog modal-lg" role="document">

                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title"><?php echo $update_version->name; ?> <?php echo $update_version->version; ?>
                                                        ( <?php echo $this->lang->line('Change Log'); ?> )</h3>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    if (count($files_replaces) > 0) { ?>
                                                        <br><br><h6><?php echo $this->lang->line('Files'); ?></h6>
                                                        <?php
                                                        foreach ($files_replaces as $file) { ?>
                                                            <li><?php echo $file[1]; ?></li>
                                                            <?php
                                                        }
                                                    }

                                                    if (count($sql_cmd_array) > 1) {
                                                        echo "<br><br><h6>" . $this->lang->line('SQL') . "</h6>";
                                                        $j = 1;
                                                        foreach ($sql_cmd_array as $single_cmd) {
                                                            if ($j < count($sql_cmd_array)) $semicolon = ';';
                                                            else $semicolon = '';
                                                            ?>
                                                            <p><?php echo $single_cmd . $semicolon; ?></p>
                                                            <?php
                                                            $j++;
                                                        }
                                                    } else {
                                                        if ($update_version->sql_cmd != '') {
                                                            echo "<br><br><h6>" . $this->lang->line('SQL') . "</h6>";
                                                            echo "<p>" . $update_version->sql_cmd . "</p>";
                                                        }
                                                    }

                                                    echo "<br><br><h6>" . $this->lang->line('Change Log') . "</h6>";
                                                    if ($update_version->change_log != '') echo "<pre>" . nl2br($update_version->change_log) . "</pre>";
                                                    else echo $this->lang->line('Not available');
                                                    ?>
                                                </div>
                                                <div class="modal-footer bg-whitesmoke br">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal"><i class="bx bx-trash-alt"></i> <span
                                                                class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style='text-align: center;'>
                                    <?php
                                    if ($i == 1) { ?>
                                        <button class='btn btn-outline-primary update'
                                                updateid="<?php echo $update_version->id; ?>"
                                                version="<?php echo $update_version->version; ?>"><i
                                                    class="bx bx-sort-up"></i> <?php echo $this->lang->line('Update Now'); ?>
                                        </button>
                                        <?php
                                    } else { ?>
                                        <button disabled='disabled' class='btn btn-outline-primary update'
                                                updateid="<?php echo $update_version->id; ?>"
                                                version="<?php echo $update_version->version; ?>"><i
                                                    class="bx bx-sort-up"></i> <?php echo $this->lang->line('Update Now'); ?>
                                        </button>
                                        <?php
                                    } ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>

                    </table>
                </div>
                <?php
            } else { ?>
                <h6> <?php echo $this->lang->line("No update available, you are already using latest version.") ?></h6>
                <?php
            } ?>
        </div>
    </div>

    <?php
    foreach ($add_ons as $add_on) {
        if (isset($add_on_update_versions[$add_on['id']])) $this_update_version = $add_on_update_versions[$add_on['id']];
        else $this_update_version = array();
        ?>

        <div class="card">
            <div class="card-header">
                <h4 style="width: 100%"><i
                            class="bx bx-plug"></i>&nbsp;<?php echo $add_on['add_on_name'] . ' ' . $this->lang->line("Updates"); ?>
                    <code class="float-right"><?php echo $this->lang->line('Your Version'); ?> :
                        <b>v<?php echo $add_on['version']; ?></b></code></h4>
            </div>
            <div class="card-body">
                <?php
                if (count($this_update_version) > 0) { ?>
                    <div class="table-responsive">
                        <table class='table table-bordered table-striped table-md'>
                            <tr class='head'>
                                <th style='text-align: center;'><?php echo $this->lang->line('Version'); ?></th>
                                <th style='text-align: center;'><?php echo $this->lang->line('Change Log'); ?></th>
                                <th style='text-align: center;'><?php echo $this->lang->line('Actions'); ?></th>
                            </tr>

                            <?php
                            $k = 1;
                            foreach ($this_update_version as $add_on_update_version) {
                                $add_on_files_replaces = json_decode($add_on_update_version->f_source_and_replace);
                                $add_on_sql_cmd_array = explode(';', $add_on_update_version->sql_cmd);
                                $modal = "modal-addon-" . $add_on_update_version->id . '-' . $k;
                                ?>
                                <tr>
                                    <td style='text-align: center;'>
                                        <div class="badge badge-info">
                                            v<?php echo $add_on_update_version->version; ?></div>
                                    </td>
                                    <td style='text-align: center;'>
                                        <button class='btn btn-outline-primary' data-toggle="modal"
                                                data-target="#<?php echo $modal; ?>"><i
                                                    class='bx bx-show'></i> <?php echo $this->lang->line('See Log'); ?>
                                        </button>
                                        <!-- Modal -->
                                        <div id="<?php echo $modal; ?>" class="modal fade" tabindex="-1" role="dialog"
                                             tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title"><?php echo $add_on_update_version->name; ?> <?php echo $add_on_update_version->version; ?>
                                                            ( <?php echo $this->lang->line('Change Log'); ?> )</h3>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <i class="bx bx-x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                        if (count($add_on_files_replaces) > 0) { ?>
                                                            <br><br><h6><?php echo $this->lang->line('Files'); ?></h6>
                                                            <?php
                                                            foreach ($add_on_files_replaces as $add_on_file) { ?>
                                                                <li><?php echo $add_on_file[1]; ?></li>
                                                                <?php
                                                            } ?>
                                                            <?php
                                                        }

                                                        if (count($add_on_sql_cmd_array) > 1) {
                                                            echo "<br><br><h6>" . $this->lang->line('SQL') . "</h6>";
                                                            $l = 1;
                                                            foreach ($add_on_sql_cmd_array as $add_on_single_cmd) {
                                                                if ($l < count($add_on_sql_cmd_array)) $semicolon = ';';
                                                                else $semicolon = '';
                                                                ?>
                                                                <p><?php echo $add_on_single_cmd . $semicolon; ?></p>
                                                                <?php
                                                                $l++;
                                                            }
                                                        } else {
                                                            if ($add_on_update_version->sql_cmd != '') {
                                                                echo "<br><br><h6>" . $this->lang->line('SQL') . "</h6>";
                                                                echo "<p>" . $add_on_update_version->sql_cmd . "</p>";
                                                            }
                                                        }
                                                        echo "<br><br><h6>" . $this->lang->line('Change Log') . "</h6>";
                                                        if ($add_on_update_version->change_log != '') echo "<pre>" . nl2br($add_on_update_version->change_log) . "</pre>";
                                                        else echo $this->lang->line('Not available');
                                                        ?>
                                                    </div>
                                                    <div class="modal-footer bg-whitesmoke br">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal"><i class="bx bx-trash-alt"></i>
                                                            <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span>
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                    <td style='text-align: center;'>
                                        <?php
                                        if ($k == 1) {
                                            ?>
                                            <button id="<?php echo 'addonupdate' . $add_on['id']; ?>"
                                                    class='btn btn-outline-primary'
                                                    folder="<?php echo $add_on['unique_name']; ?>"
                                                    updateid="<?php echo $add_on_update_version->id; ?>"
                                                    version="<?php echo $add_on_update_version->version; ?>"><i
                                                        class="bx bx-sort-up"></i> <?php echo $this->lang->line('Update Now'); ?>
                                            </button>
                                            <?php
                                        } else { ?>
                                            <button disabled='disabled' class='btn btn-outline-primary'
                                                    updateid="<?php echo $add_on_update_version->id; ?>"
                                                    version="<?php echo $add_on_update_version->version; ?>"><i
                                                        class="bx bx-sort-up"></i> <?php echo $this->lang->line('Update Now'); ?>
                                            </button>
                                            <?php
                                        } ?>
                                    </td>
                                </tr>
                                <?php
                                $k++;
                            }
                            ?>
                        </table>
                    </div>
                    <?php
                } else { ?>
                    <h6> <?php echo $this->lang->line("No update available, you are already using latest version.") ?></h6>
                    <?php
                } ?>
            </div>
        </div>
        <?php
    } ?>
</div>


<?php
$send_files = json_encode(array());
$send_sql = json_encode(array());
if (isset($update_versions[0])) {
    $send_files = $update_versions[0]->f_source_and_replace;
    $send_sql = json_encode(explode(';', $update_versions[0]->sql_cmd));
}
?>


<div class="modal fade" tabindex="-1" role="dialog" id="update_success" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-sort-up"></i> <?php echo $this->lang->line('System Update'); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="update_success_content"></div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash-alt"></i>
                    <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>

