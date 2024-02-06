<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;
?>
<?php
$file_upload_limit = 2;
if ($this->config->item('xerobiz_file_upload_limit') != '') {
    $file_upload_limit = $this->config->item('xerobiz_file_upload_limit');
}
?>
<style type="text/css">
    .space {
        height: 10px;
    }

    .select2 {
        width: 100% !important;
    }

    #title_variable {
        border: 1px dashed #d0d0d0;
    }

    .ajax-upload-dragdrop {
        width: 100% !important;
        border: 2px dashed #dadada;
    }
</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('gmb'); ?>"><?php echo $this->lang->line('Google My Business'); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('gmb/campaigns'); ?>"><?php echo $this->lang->line('Campaigns'); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href='#add_feed_modal' id="add_feed" class="btn btn-primary mb-1" data-toggle="modal">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New auto posting feed"); ?>
        </a>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-light mb-2" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bx bx-bulb"></i>
                    <span>
                <?php echo $this->lang->line("RSS auto posting will be publised as Link post.It will post once any new feed comes to RSS feed after setting it in the system. It will not post any existing feeds during setup the campaign."); ?>
              </span>
                </div>
            </div>

        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php
                    echo "<div class='table-responsive data-card'> 
                            <table class='table table-bordered table-condensed' id='mytable'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>" . $this->lang->line("SN") . "</th>";
                    echo "<th>" . $this->lang->line("Feed Name") . "</th>";
                    echo "<th class='text-center'>" . $this->lang->line("Status") . "</th>";
                    echo "<th class='text-center'>" . $this->lang->line("Actions") . "</th>";
                    echo "<th class='text-center'>" . $this->lang->line("Last Updated") . "</th>";
                    echo "<th class='text-center'>" . $this->lang->line("Last Feed") . "</th>";
                    echo "</tr></thead>";
                    echo "<tbody>";

                    $i = 0;

                    foreach ($settings_data as $key => $value) {

                        $i++;

                        if ($value['last_pub_date'] != "0000-00-00 00:00:00") {
                            $last_pub_date = date('j M H:i', strtotime($value['last_pub_date']));
                        } else {
                            $last_pub_date = "<i class='bx bx-time'></i>";
                        }

                        $status = '';

                        if ($value['status'] == '1') {
                            $status = '<span class="text-success"><i class="bx bx-check-circle"></i> ' . $this->lang->line("Active") . '</span>';
                        } else if ($value['status'] == '0') {
                            $status = '<span class="text-danger"><i class="bx bx-time"></i> ' . $this->lang->line("Inactive") . '</span>';
                        } else {
                            $status = '<span class="text-warning"><i class="bx bx-block"></i> ' . $this->lang->line("Disabled") . '</span>';
                        }

                        echo "<tr>";
                        echo "<td nowrap>" . $i . "</td>";
                        echo "<td nowrap><a href='" . $value['feed_url'] . "' target='_BLANK'>" . $value['feed_name'] . "</a></td>";
                        echo "<td class='text-center' nowrap>" . $status . "</td>";
                        echo "<td class='text-center' nowrap>";
                        echo '<div class="dropdown d-inline dropright">
                                        <button class="btn btn-outline-primary dropdown-toggle no_caret" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bx bx-briefcase"></i></button>
                            
                                        <div class="dropdown-menu mini_dropdown text-center">
                            
                                        <a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Settings") . '" class="btn btn-circle btn-outline-primary campaign_settings"><i class="bx bx-cog"></i></a>';

                        if ($value['status'] == '1') {
                            echo '<a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Disable") . '" class="btn btn-circle btn-outline-warning disable_settings"><i class="bx bx-block"></i></a>';
                        } else {
                            echo '<a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Enable") . '" class="btn btn-circle btn-outline-success enable_settings"><i class="bx bx-check-circle"></i></a>';
                        }

                        echo '<a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Delete") . '" class="btn btn-circle btn-outline-danger delete_settings"><i class="bx bx-trash-alt"></i></a>';

                        echo '<a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Error") . '" class="btn btn-circle btn-outline-secondary error_log"><i class="bx bx-bug"></i></a>';

                        echo '</div></div>';
                        echo "<td class='text-center' nowrap>" . date("d M H:i", strtotime($value["last_updated_at"])) . "</td>";
                        echo "<td class='text-center' nowrap>" . $last_pub_date . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table></div>";
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="error_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-bug"></i>&nbsp;
                    <?php echo $this->lang->line("Error Log") ?></span>
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="xit-spinner bg-white text-primary">
                    <i class="bx bx-spin bx-loader fa-3x"></i>
                </div>
                <div id="error_modal_container"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default float-right" data-dismiss="modal" id="close_settings">
                    <i class="bx bx-x"></i>&nbsp;
                    <?php echo $this->lang->line("Close"); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="settings_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-cog"></i>&nbsp;
                    <?php echo $this->lang->line("Campaign Settings") ?>&nbsp;
                    <span id="put_feed_name"></span>
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="feed_setting_container"></div>

            <div class="modal-footer pl-4 pr-4">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close_settings">
                    <i class="bx bx-x"></i>&nbsp;
                    <?php echo $this->lang->line("Close"); ?>
                </button>
                <button type="button" class="btn btn-primary ml-0" id="save_settings">
                    <i class="bx bx-paper-plane"></i>&nbsp;
                    <?php echo $this->lang->line("Create Campaign"); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_feed_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bx bx-rss"></i>&nbsp;
                    <?php echo $this->lang->line("Auto-Posting Feed") ?>
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="add_feed_form">
                <div class="modal-body">
                    <div class="text-center waiting hidden" id="loader">
                        <i class="bx bx-spin bx-loader blue text-center" style="font-size:40px"></i>
                    </div>
                    <div id="response"></div>
                    <div class="space"></div>

                    <label class="margin-bottom-label">
                        <?php echo $this->lang->line("Feed Name") ?> *
                    </label>
                    <input type="text" name="feed_name" id="feed_name" class="form-control mb-3">

                    <label class="margin-bottom-label">
                        <?php echo $this->lang->line("RSS Feed URL") ?> *
                    </label>
                    <input type="text" name="feed_url" id="feed_url" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add_feed_submit">
                        <i class='bx bx-plus-circle'></i>&nbsp;
                        <?php echo $this->lang->line('Add Feed'); ?>
                    </button>

                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class='bx bx-time'></i>&nbsp;
                        <?php echo $this->lang->line('Close'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>




