<?php
//TODO: check modals

?>

<style>
    #sequence_search {
        max-width: 40% !important;
    }

    .bbw {
        border-bottom-width: thin !important;
        border-bottom: solid .5px #f9f9f9 !important;
        padding-bottom: 20px;
    }

    .button-outline {
        background: #fff;
        border: .5px dashed #ccc;
    }

    .button-outline:hover {
        border: 1px dashed #6777EF !important;
        cursor: pointer;
    }
</style>

<input type="hidden" name="sms_email_sequence_csrf_token" id="sms_email_sequence_csrf_token"
       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot_broadcast"); ?>"><?php echo $this->lang->line("Broadcasting"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url("sms_email_sequence/create_sequnce_for_external"); ?>"
           class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Sequence"); ?>
        </a>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="input-group float-left" id="searchbox">
                                <input type="text" class="form-control" id="sequence_search" name="sequence_search"
                                       autofocus placeholder="<?php echo $this->lang->line('Search...'); ?>"
                                       aria-label="" aria-describedby="basic-addon2">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive2 data-card">
                                <table class="table table-bordered" id="mytable_external_sequence">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("ID"); ?></th>
                                        <th><?php echo $this->lang->line("Name"); ?></th>
                                        <th><?php echo $this->lang->line("Last Sent"); ?></th>
                                        <th><?php echo $this->lang->line('Campaign Type'); ?></th>
                                        <th><?php echo $this->lang->line('Actions'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="sms_email_message_content_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header smallpadding">
                <h3 class="modal-title"><i class="bx bx-show"></i> <?php echo $this->lang->line('Campaign Report'); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body smallpadding" id="sms_email_message_content_modal_content"></div>
        </div>
    </div>
</div>
