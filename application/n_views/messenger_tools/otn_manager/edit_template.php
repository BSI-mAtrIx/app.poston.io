<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
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
$include_prism = 0;
?>

<?php
$redirect_url = site_url('messenger_bot/otn_template_manager');
$THEMECOLORCODE = "#607D8B";
?>


<?php if ($iframe != '1') : ?>
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("Add OTN PostBack Template"); ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("messenger_bot"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                        </li>
                        <li class="breadcrumb-item"><a
                                    href="<?php echo base_url("messenger_bot/otn_template_manager"); ?>"><?php echo $this->lang->line("OTN Post-back Manager"); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="card <?php if ($iframe == '1') echo 'shadow-none'; ?>">
    <div class="card-body <?php if ($iframe == '1') echo 'p-0 overflow-hidden'; ?>">

        <div class="row">
            <div class="col-12">
                <form action="#" method="post" id="messenger_bot_form" style="padding-left: 0;">
                    <input type="hidden" name="id" id="id" value="<?php echo $bot_info['id']; ?>">

                    <div class="row" <?php if ($is_default == 'default') echo "style='display: none;'"; ?> >
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("Template Name"); ?></label>
                                <input type="<?php if ($is_default == 'default') echo 'hidden'; else echo 'text'; ?>"
                                       name="bot_name"
                                       value="<?php if (set_value('bot_name')) echo set_value('bot_name'); else {
                                           if (isset($bot_info['template_name'])) echo $bot_info['template_name'];
                                       } ?>" id="bot_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>
                                    <?php echo $this->lang->line("Select a reply PostBack"); ?>
                                </label>
                                <div>
                                    <select class="form-control push_postback select2 dropdown-item"
                                            id="reply_postback_id" name="reply_postback_id">
                                        <?php
                                        if (isset($bot_info['reply_postback_id']))
                                            $selected_value = $bot_info['reply_postback_id'];
                                        else
                                            $selected_value = '';
                                        foreach ($postback_dropdown as $key => $value) {
                                            $is_selected = ($key == $selected_value) ? 'selected' : '';
                                            echo "<option value='" . $key . "' " . $is_selected . ">" . $value . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <a href="" class="add_template float-left"
                                       page_id_add_postback="<?php echo $bot_info['page_id']; ?>"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                    </a>
                                    <a href="" class="ref_template float-right"
                                       page_id_ref_postback="<?php echo $bot_info['page_id']; ?>"><i
                                                class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?></a>
                                </div>


                            </div>
                        </div>
                    </div>

                    <br/>
                    <div class="row">

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("Selected page"); ?></label>
                                <?php
                                $page_list[''] = "Please select a page";

                                $page_select_extra_class = ' hidden';
                                $page_select_default_value = $bot_info['page_id'];

                                if (isset($action_type) && $action_type == 'clone') {
                                    $page_select_extra_class = ' select2';
                                }
                                echo form_dropdown('page_table_id', $page_list, $page_select_default_value, 'id="page_table_id" class="form-control' . $page_select_extra_class . '"');
                                $pagename = "";;
                                foreach ($page_list as $key => $value) {
                                    if ($key == $bot_info['page_id']) $pagename = $value;
                                }
                                if (!(isset($action_type) && $action_type == 'clone')) {
                                    echo " : <b>" . $pagename . "</b>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group" id="postback_section">
                                <label><?php echo $this->lang->line("OTN Postback ID"); ?>
                                    <?php if (isset($action_type) && $action_type == 'clone'): ?>
                                        <a href="#" data-placement="right" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("Supported Characters") ?>"
                                           data-content="It is recommended to use English characters as postback id. You can use a-z, A-Z, 0-9, -, , _"><i
                                                    class='bx bx-info-circle'></i> </a>
                                    <?php endif ?>
                                </label>

                                <input
                                        type="<?php echo (!(isset($action_type) && $action_type == 'clone')) ? "hidden" : ""; ?>"
                                        name="template_postback_id"
                                        id="template_postback_id"
                                        value="<?php
                                        if (set_value('otn_postback_id')) echo set_value('otn_postback_id');
                                        elseif ((isset($action_type) && $action_type == 'clone')) echo "";
                                        else {
                                            if (isset($bot_info['otn_postback_id'])) echo $bot_info['otn_postback_id'];
                                        }
                                        ?>"
                                        class="form-control push_postback"
                                >
                                <?php
                                if ((!(isset($action_type) && $action_type == 'clone'))) {
                                    echo " : <b>";
                                    if (set_value('otn_postback_id')) echo set_value('otn_postback_id'); else {
                                        if (isset($bot_info['otn_postback_id'])) echo $bot_info['otn_postback_id'];
                                    }
                                    echo "</b>";
                                }
                                ?>
                            </div>
                        </div>

                    </div>


                    <?php
                    $first_col = "col-12 col-sm-6";
                    if (!$this->is_drip_campaigner_exist && !$this->is_sms_email_drip_campaigner_exist) $first_col = "col-12";

                    $display = '';
                    if ($is_default == 'default') $display = "style='display: none;'";

                    $popover = '<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="' . $this->lang->line("Choose Labels") . '" data-content="' . $this->lang->line("If you choose labels, then when user click on this PostBack they will be added in those labels, that will help you to segment your leads & broadcasting from Messenger Broadcaster. If you don't want to add labels for this PostBack , then just keep it blank as it is.") . '"><i class="bx bx-info-circle"></i> </a>';

                    echo '<div class="row" ' . $display . '>
                  <div class="' . $first_col . '"> 
                      <div class="form-group">
                        <label style="width:100%">
                        ' . $this->lang->line("Choose Labels") . " " . $popover . '
                        <a class="blue float-right pointer" page_id_for_label="' . $bot_info['page_id'] . '" id="create_label_postback"><i class="bx bx-plus-circle"></i> ' . $this->lang->line("Create Label") . '</a>  
                        </label>';

                    $broadcaster_labels = $bot_info['label_id'];
                    $broadcaster_labels = explode(',', $broadcaster_labels);

                    $str = '<span id="first_dropdown"><select multiple="" class="select2 form-control" id="label_ids" name="label_ids[]">';
                    $str .= '<option value="">' . $this->lang->line('Select Labels') . '</option>';
                    foreach ($info_type as $value) {
                        $search_key = $value['id'];
                        $search_type = $value['group_name'];
                        $selected = '';
                        if (in_array($search_key, $broadcaster_labels)) $selected = 'selected="selected"';

                        $str .= "<option value='{$search_key}' {$selected}>" . $search_type . "</option>";
                    }
                    $str .= '</select></span>';
                    echo $str;

                    echo '</div>       
                  </div>';

                    if ($this->is_drip_campaigner_exist || $this->is_sms_email_drip_campaigner_exist) {
                        $popover2 = '<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="' . $this->lang->line("Choose Sequence Campaign") . '" data-content="' . $this->lang->line("Choose any drip or sequence campaign to set when user click on this postback button. Keep it blank if you don't want to set.") . '"><i class="bx bx-info-circle"></i> </a>';
                        echo
                            '<div class="col-12 col-sm-6"> 
                      <div class="form-group">
                        <label style="width:100%">
                        ' . $this->lang->line("Choose Sequence Campaigns") . " " . $popover2 . '
                        </label>';

                        $dripcampaign_id = $bot_info['drip_campaign_id'];
                        $dripcampaign_id = explode(',', $dripcampaign_id);

                        $str = '<span id="dripcampaign_dropdown"><select class="select2 form-control" id="drip_campaign_id" name="drip_campaign_id[]">';
                        $str .= '<option value="">' . $this->lang->line('Select') . '</option>';
                        foreach ($dripcampaign_list as $value) {
                            $search_key = $value['id'];
                            $search_type = $value['campaign_name'];
                            $selected = '';
                            if (in_array($search_key, $dripcampaign_id)) $selected = 'selected="selected"';

                            $str .= "<option value='{$search_key}' {$selected}>" . $search_type . "</option>";
                        }
                        $str .= '</select></span>';
                        echo $str;

                        echo '</div>       
                  </div>';
                    }
                    echo '</div>';
                    ?>


                    <br/><br/>
                    <div class="row">
                        <div class="col-6">
                            <button id="submit" class="btn btn-primary"><i
                                        class="bx bx-send"></i> <?php echo (!(isset($action_type) && $action_type == 'clone')) ? $this->lang->line('Update') : $this->lang->line("Clone");; ?>
                            </button>
                        </div>
                        <?php if ($iframe != '1') : ?>
                            <div class="col-6">
                                <a class="btn btn-secondary float-right"
                                   href="<?php echo base_url("messenger_bot/otn_template_manager"); ?>"><i
                                            class="bx bx-arrow-back"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("Back"); ?>
                                </a></button>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

        </div>
        <br>
        <div id="submit_status" class="text-center"></div>


    </div> <!-- end of card body -->
</div>

<?php if ($iframe != '1') : ?>

<?php endif; ?>



<?php
$areyousure = $this->lang->line("are you sure");
$somethingwentwrong = $this->lang->line("something went wrong.");
$doyoureallywanttodeletethisbot = $this->lang->line("do you really want to delete this bot?");
?>


<div class="modal fade" id="add_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Template'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%"></iframe>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-dark"><i class="bx bx-sync"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("Close & Refresh List"); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="error_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h3 class="modal-title"><i
                            class="bx bx-info-circle"></i> <?php echo $this->lang->line('campaign error'); ?></h3>
            </div>
            <div class="modal-body">
                <div class="alert text-center alert-warning" id="error_modal_content">

                </div>
            </div>
        </div>
    </div>
</div>