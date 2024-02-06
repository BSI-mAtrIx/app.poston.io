<?php
$include_emoji = 1;
//TODO: icons form
//TODO: check modals

?>
<style type="text/css">
    .space {
        height: 10px;
    }

    .select2 {
        width: 100% !important;
    }
</style>

<?php $is_broadcaster_exist = $this->is_broadcaster_exist_deprecated; ?>
<?php $is_ultrapost_exist = $this->is_ultrapost_exist; ?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("ultrapost"); ?>"><?php echo $this->lang->line("Facebook Poster"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a class="btn btn-primary mb-1" id="add_feed" data-toggle="modal" href='#add_feed_modal'>
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('New Auto Posting Feed'); ?>
        </a>
    </div>
</div>


<div class="section-body">
    <div class='text-center text-primary'
         style='padding:12px;border:.5px solid #dee2e6;background: #fff;'><?php echo $this->lang->line("RSS auto posting will be publised as Link post.It will post once any new feed comes to RSS feed after setting it in the system. It will not post any existing feeds during setup the campaign.") ?></div>
    <div class="row">
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
                    // echo "<th class='text-center'>".$this->lang->line("Feed Type")."</th>";
                    echo "<th class='text-center'>" . $this->lang->line("Status") . "</th>";
                    echo "<th class='text-center'>" . $this->lang->line("Actions") . "</th>";
                    echo "<th class='text-center'>" . $this->lang->line("Last Updated") . "</th>";
                    echo "<th class='text-center'>" . $this->lang->line("Last Feed") . "</th>";
                    if ($is_broadcaster_exist)
                        echo "<th class='text-center'>" . $this->lang->line("Broadcast as Page") . "</th>";
                    if ($this->is_ultrapost_exist)
                        echo "<th>" . $this->lang->line("Post as Pages") . "</th>";
                    echo "</tr></thead>";

                    echo "<tbody>";
                    $i = 0;
                    foreach ($settings_data as $key => $value) {
                        $i++;
                        if ($value['last_pub_date'] != "0000-00-00 00:00:00") $last_pub_date = date('j M H:i', strtotime($value['last_pub_date']));
                        else $last_pub_date = "<i class='bx bx-time'></i>";

                        $page_names = json_decode($value['page_names'], true);
                        if (!is_array($page_names)) $page_names = array();
                        $page_names = array_values($page_names);
                        $page_names = implode(',', $page_names);

                        $page_name = $value['page_name'];

                        if ($page_names != "") $page_names = "<a target='_BLANK' href='" . base_url("ultrapost/text_image_link_video") . "'>" . $page_names . "</a>";
                        if ($page_name != "") $page_name = "<a target='_BLANK' href='" . base_url("messenger_broadcaster/quick_bulk_broadcast_report") . "'>" . $page_name . "</a>";

                        $status = '';
                        if ($value['status'] == '1') $status = '<span class="text-success"><i class="bx bx-check-circle"></i> ' . $this->lang->line("Active") . '</span>';
                        else if ($value['status'] == '0') $status = '<span class="text-danger"><i class="bx bx-time-five"></i> ' . $this->lang->line("Inactive") . '</span>';
                        else $status = '<span class="text-warning"><i class="bx bx-block"></i> ' . $this->lang->line("Disabled") . '</span>';

                        echo "<tr>";
                        echo "<td nowrap>" . $i . "</td>";
                        echo "<td nowrap><a href='" . $value['feed_url'] . "' target='_BLANK'>" . $value['feed_name'] . "</a></td>";
                        // echo "<td class='text-center' nowrap>".strtoupper($value['feed_type'])."</td>";
                        echo "<td class='text-center' nowrap>" . $status . "</td>";
                        echo "<td class='text-center' nowrap>";

                        echo '
                    <div class="dropdown d-inline dropright">
                      <button class="btn btn-outline-primary dropdown-toggle no_caret" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bx bx-briefcase"></i></button>

                      <div class="dropdown-menu mini_dropdown text-center" style="width:290px !important">

                        <a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Settings") . '" class="btn btn-circle btn-outline-primary campaign_settings"><i class="bx bxs-cog"></i></a>';

                        if ($value['status'] == '1')
                            echo '<a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Disable") . '" class="btn btn-circle btn-outline-warning disable_settings"><i class="bx bx-block"></i></a>';
                        else echo '<a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Enable") . '" class="btn btn-circle btn-outline-success enable_settings"><i class="bx bx-check-circle"></i></a>';

                        if ($value['cron_status'] == '1')
                            echo '<a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Force Process") . '" class="btn btn-circle btn-outline-warning force_process"><i class="bx bx-play-circle"></i></a>';

                        echo '<a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Delete") . '" class="btn btn-circle btn-outline-danger delete_settings"><i class="bx bx-trash-alt"></i></a>';

                        echo '<a href="" data-id="' . $value['id'] . '" data-toggle="tooltip" title="' . $this->lang->line("Error") . '" class="btn btn-circle btn-outline-secondary error_log"><i class="bx bx-bug"></i></a>';

                        echo '
                      </div>
                    </div>';

                        echo "<td class='text-center' nowrap>" . date("d M H:i", strtotime($value["last_updated_at"])) . "</td>";
                        echo "<td class='text-center' nowrap>" . $last_pub_date . "</td>";

                        if ($is_broadcaster_exist)
                            echo "<td class='text-center' nowrap>" . $page_name . "</td>";

                        if ($this->is_ultrapost_exist)
                            echo "<td nowrap>" . $page_names . "</td>";


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
                <h3 class="modal-title"><i class="bx bx-bug"></i> <?php echo $this->lang->line("Error Log") ?></span>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-center waiting hidden" id="error_loading"><i
                            class="bx bx-loader-alt bx-spin blue text-center" style="font-size:40px"></i></div>
                <div id="error_modal_container"></div>
            </div>
            <div class="modal-footer" style="padding-left: 30px;padding-right: 30px;">
                <button type="button" class=" btn btn-secondary float-right" data-dismiss="modal" id="close_settings"><i
                            class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="settings_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bxs-cog"></i> <?php echo $this->lang->line("Campaign Settings") ?>
                    <span id="put_feed_name"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" id="feed_setting_container">

            </div>
            <div class="modal-footer" style="padding-left: 30px;padding-right: 30px;">
                <button type="button" class=" btn btn-secondary" data-dismiss="modal" id="close_settings"><i
                            class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
                <button type="button" class=" btn btn-primary" id="save_settings" style="margin-left: 0;"><i
                            class="bx bx-paper-plane"></i> <?php echo $this->lang->line("Create Campaign"); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="add_feed_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-rss"></i> <?php echo $this->lang->line("Auto-Posting Feed") ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                </button>
            </div>
            <form action="#" enctype="multipart/form-data" id="add_feed_form">
                <div class="modal-body">
                    <div class="text-center waiting hidden" id="loader"><i
                                class="bx bx-loader-alt bx-spin blue text-center" style="font-size:40px"></i></div>
                    <div id="response"></div>
                    <div class="space"></div>
                    <div class='hidden'> <!-- hidden temporarily, will be needed in future -->
                        <label class="margin-bottom-label" style="color: rgb(0, 0, 0);">
                            <?php echo $this->lang->line("Feed Type") ?> *
                        </label>
                        <div class="space"></div>
                        <?php
                        foreach ($feed_types as $key => $value) {
                            $is_checked = $is_default_label = '';
                            if ($value == 'rss') {
                                $is_checked = 'checked';
                                $is_default_label = 'default-label';
                            }
                            echo '<input type="radio" class="css-checkbox" ' . $is_checked . ' name="feed_type" value="' . $value . '" id="feed_type' . $value . '" style="color: rgb(0, 0, 0);"> <label for="feed_type' . $value . '" class="css-label triple-label ' . $is_default_label . '" style="color: rgb(0, 0, 0);"> <i class="checkicon fa fa-check" style="display: none;"></i> ' . ucfirst($value) . '</label>';
                        } ?>
                        <div class="space"></div>
                    </div>

                    <label class="margin-bottom-label" style="color: rgb(0, 0, 0);">
                        <?php echo $this->lang->line("Feed Name") ?> *
                    </label>
                    <div class="space"></div>
                    <input type="text" name="feed_name" id="feed_name" class="form-control">

                    <div class="space"></div>
                    <div class="space"></div>

                    <label class="margin-bottom-label" style="color: rgb(0, 0, 0);">
                        <?php echo $this->lang->line("RSS Feed URL") ?> *
                    </label>
                    <div class="space"></div>
                    <input type="text" name="feed_url" id="feed_url" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class=" btn btn-primary" id="add_feed_submit"><i
                                class='bx bx-plus-circle'></i> <?php echo $this->lang->line('Add Feed'); ?></button>
                    <button type="button" class=" btn btn-secondary" data-dismiss="modal"><i
                                class='bx bx-time'></i> <?php echo $this->lang->line('Close'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
