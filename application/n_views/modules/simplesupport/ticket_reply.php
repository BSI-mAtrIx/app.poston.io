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
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0">      <?php $userurl = ($this->session->userdata("user_type") == "Admin") ? base_url("admin/edit_user/" . $ticket_info[0]["user_id"]) : base_url("member/edit_profile"); ?>
                <?php echo $this->lang->line("Ticket"); ?> #<?php echo $ticket_info[0]['id']; ?>
                : <a href="<?php echo $userurl; ?>"><?php echo $user_info[0]['name']; ?></a>
                <span id="ticket_status">
      <?php if ($ticket_info[0]["ticket_status"] == "1") echo "[" . $this->lang->line("Open") . "]"; ?>
      <?php if ($ticket_info[0]["ticket_status"] == "2") echo "[" . $this->lang->line("Closed") . "]"; ?>
      <?php if ($ticket_info[0]["ticket_status"] == "3") echo "[" . $this->lang->line("Resolved") . "]"; ?>
      </span></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("simplesupport/tickets"); ?>"><?php echo $this->lang->line("Support Desk"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("Ticket"); ?>
                        #<?php echo $ticket_info[0]["id"]; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>
                        <i class="bx bxs-folder-open"></i> <?php echo $ticket_info[0]["ticket_title"]; ?>
                        <code>&nbsp;<i
                                    class="bx bx-time"></i> <?php echo date_time_calculator($ticket_info[0]['ticket_open_time'], true); ?>
                        </code>
                    </h4>
                    <div class="card-header-action">
                        <div class="btn-group">
                            <?php
                            $id = $ticket_info[0]["id"];
                            $action = "";

                            if ($ticket_info[0]['ticket_status'] != '3')
                                $action .= '<a  table_id="' . $id . '" href="" class="btn btn-outline-primary ticket_action"  data-type="resolve"><i class="bx bx-paper-plane"></i> ' . $this->lang->line("Resolve") . '</a>';

                            if ($ticket_info[0]['ticket_status'] != '2')
                                $action .= '<a  table_id="' . $id . '" href="" class="btn btn-outline-primary ticket_action"  data-type="close"><i class="bx bx-block"></i> ' . $this->lang->line("Close") . '</a>';

                            if ($ticket_info[0]['display'] == '1' && $this->session->userdata("user_type") == "Admin")
                                $action .= '<a  table_id="' . $id . '" href="" class="btn btn-outline-primary ticket_action"  data-type="hide"><i class="bx bxs-hide"></i> ' . $this->lang->line("Hide") . '</a>';

                            echo $action;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-whitesmoke text-justify">
                    <?php echo $ticket_info[0]['ticket_text']; ?>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                        <?php if (count($ticket_replied) == 0) echo "<br>" . $this->lang->line("No reply found."); ?>
                        <?php foreach ($ticket_replied as $single_reply) { ?>
                            <li class="media">

                                <?php if ($single_reply['brand_logo'] != '') : ?>
                                    <img width="70" class="mr-3 rounded-circle"
                                         src="<?php echo base_url('member/') . $single_reply['brand_logo']; ?> " alt="">
                                <?php else: ?>
                                    <img width="70" class="mr-3 rounded-circle"
                                         src="<?php echo base_url('assets/img/avatar.png'); ?> " alt="">
                                <?php endif; ?>

                                <div class="media-body">
                                    <div class="media-title mb-1"><?php echo $single_reply['name']; ?></div>
                                    <div class="text-time"><i
                                                class="bx bx-time"></i> <?php echo date_time_calculator($single_reply['ticket_reply_time'], true); ?>
                                    </div>
                                    <div class="media-description text-muted text-justify">
                                        <?php if (isset($single_reply['ticket_reply_text'])) echo $single_reply['ticket_reply_text']; ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        } ?>
                    </ul>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <form class="from-show" action="<?php echo base_url('simplesupport/reply_action/'); ?>"
                          method="POST" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="csrf_token" id="csrf_token"
                               value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                        <input type="hidden" name="id" value="<?php echo $ticket_info[0]['id']; ?>">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('Reply Ticket'); ?></label>
                            <div id="ckeditor">
                                <textarea required class="form-control" name="ticket_reply_text"
                                          id="ticket_reply_text"></textarea>
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                    <?php $red_link = "simplesupport/tickets"; ?>
                    <button type="submit" class="btn btn-primary reply"><i
                                class="bx bx-send"></i> <?php echo $this->lang->line('Reply'); ?> </button>
                    <a onclick="goBack('<?php echo $red_link ?>',1)"
                       class="btn btn-light float-right cancel from-show"><i
                                class="bx bx-time"></i> <?php echo $this->lang->line("Cancel"); ?> </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    .modal-backdrop, .modal-backdrop.in {
        display: none;
    }
</style>


<style type="text/css">
    .note-group-select-from-files {
        display: none;
    }
</style>