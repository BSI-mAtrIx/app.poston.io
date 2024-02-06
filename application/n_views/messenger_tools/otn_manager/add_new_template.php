<?php
$redirect_url = site_url('messenger_bot/otn_template_manager/');
$THEMECOLORCODE = "#607D8B";

?>

    <style type="text/css">

        label.css-label {
            background-image: url(<?php echo base_url('assets/images/csscheckbox.png'); ?>);
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            color: <?php echo $THEMECOLORCODE; ?> !important;
            font-size: 15px !important;
        }

        .css-label-container {
            padding: 10px;
            border: 1px dashed<?php echo $THEMECOLORCODE; ?>;
            border-radius: 5px;
        }

        <?php if($iframe=='1') echo '
        .card-primary .card-body,.card-primary .card-header,.card-primary .card-footer{padding:15px;}
        .card-secondary .card-body,.card-secondary .card-header,.card-secondary .card-footer{padding:12px;}';
        ?>
    </style>

<?php if ($iframe != '1') : ?>
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("Add an OTN PostBack Template"); ?></h5>
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

    <div class="card shadow-none ">
        <div class="card-body <?php if ($iframe == '1') echo 'p-0 overflow-hidden'; ?>">

            <div class="row">
                <div class="<?php if ($is_iframe == "1") echo 'col-12'; else echo 'col-12 col-lg-12'; ?>">
                    <form action="#" method="post" id="messenger_bot_form" style="padding-left: 0;">
                        <div class="row">
                            <div class="<?php if ($default_page == '') echo 'col-12 col-sm-6'; else echo 'col-12'; ?>">
                                <div class="form-group">
                                    <label><?php echo $this->lang->line("Template Name"); ?></label>
                                    <input type="text" name="bot_name" id="bot_name" class="form-control">
                                </div>
                            </div>
                            <?php if ($default_page != '') : ?>
                                <input type="hidden" name="page_table_id" id="page_table_id"
                                       value="<?php echo $default_page; ?>">
                            <?php else : ?>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label><?php echo $this->lang->line("Choose a Page"); ?></label>
                                        <?php
                                        $page_list[''] = "Please select a page";
                                        echo form_dropdown('page_table_id', $page_list, $default_page, 'id="page_table_id" class="select2 form-control"');
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <?php if ($default_child_postback_id == '') : ?>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>
                                            <?php echo $this->lang->line("Select a reply PostBack"); ?>
                                        </label>
                                        <select class="form-control push_postback select2" name="reply_postback_id"
                                                id="reply_postback_id">
                                            <option value=""><?php echo $this->lang->line('Please select a page first.'); ?></option>
                                        </select>

                                        <a href="" class="add_template float-left" page_id_add_postback=""><i
                                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add"); ?>
                                        </a>
                                        <a href="" class="ref_template float-right" page_id_ref_postback=""><i
                                                    class="bx bx-sync"></i> <?php echo $this->lang->line("Refresh"); ?>
                                        </a>

                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group" id="postback_section">
                                        <label>
                                            <?php echo $this->lang->line("OTN PostBack id"); ?>
                                            <a href="#" data-placement="right" data-toggle="popover"
                                               data-trigger="focus"
                                               title="<?php echo $this->lang->line("Supported Characters") ?>"
                                               data-content="It is recommended to use English characters as postback id. You can use a-z, A-Z, 0-9, -, , _"><i
                                                        class='bx bx-info-circle'></i> </a>
                                        </label>
                                        <input type="text" name="template_postback_id" id="template_postback_id"
                                               class="form-control">
                                    </div>
                                </div>
                            <?php else : ?>
                                <input type="hidden" name="template_postback_id" id="template_postback_id"
                                       value="<?php echo urldecode($default_child_postback_id); ?>">
                                <input type="hidden" name="postback_type" value="child" id="child_postback">
                            <?php endif; ?>
                        </div>
                        <br/>


                        <?php
                        $first_col = "col-12 col-sm-6";
                        if (!$this->is_drip_campaigner_exist && !$this->is_sms_email_drip_campaigner_exist) $first_col = "col-12";
                        $popover = '<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="' . $this->lang->line("Choose Labels") . '" data-content="' . $this->lang->line("If you choose labels, then when user click on this PostBack they will be added in those labels, that will help you to segment your leads & broadcasting from Messenger Broadcaster. If you don't want to add labels for this PostBack , then just keep it blank as it is.") . '"><i class="bx bx-info-circle"></i> </a>';
                        echo '<div class="row">
              <div class="' . $first_col . '"> 
                  <div class="form-group">
                    <label style="width:100%" class="show_label hidden">
                    ' . $this->lang->line("Choose Labels") . ' ' . $popover . '
                    <a class="blue float-right pointer" page_id_for_label="" id="create_label_postback"><i class="bx bx-plus-circle"></i> ' . $this->lang->line("Create Label") . '</a>  
                    </label>
                    <span id="first_dropdown"></span>                                  
                  </div>       
              </div>';

                        if ($this->is_drip_campaigner_exist || $this->is_sms_email_drip_campaigner_exist) {
                            $popover2 = '<a href="#" data-placement="bottom"  data-toggle="popover" data-trigger="focus" title="' . $this->lang->line("Choose Sequence Campaign") . '" data-content="' . $this->lang->line("Choose any drip or sequence campaign to set when user click on this postback button. Keep it blank if you don't want to set.") . '"><i class="bx bx-info-circle"></i> </a>';
                            echo '
                  <div class="col-12 col-sm-6 hidden dropdown_con"> 
                      <div class="form-group">
                        <label style="width:100%">
                        ' . $this->lang->line("Choose Sequence Campaigns") . ' ' . $popover2 . '
                        </label>
                        <span id="dripcampaign_dropdown"></span>                                  
                      </div>       
                  </div>';
                        }
                        echo '</div>';
                        ?>

                        <br/><br/>
                        <div class="row">
                            <div class="col-6">
                                <button id="submit" class="btn btn-primary"><i class="bx bx-send"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("submit"); ?></span>
                                </button>
                            </div>
                            <?php if ($iframe != '1') : ?>
                                <div class="col-6">
                                    <a class="btn btn-secondary float-right"
                                       href="<?php echo base_url("messenger_bot/otn_template_manager"); ?>"><i
                                                class="bx bx-time"></i> <span
                                                class="align-middle ml-25"><?php echo $this->lang->line("Back"); ?>
                                    </a></button>
                                </div>
                            <?php endif; ?>
                        </div>


                    </form>

                </div>


            </div>

        </div>
    </div>


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


<?php if ($is_iframe == "1") echo '<link rel="stylesheet" type="text/css" href="' . base_url('css/bot_template.css?ver=' . $n_config['theme_version']) . '">'; ?>