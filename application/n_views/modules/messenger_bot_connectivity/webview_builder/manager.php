<?php
//todo: modals need changes
?>

<style>
    #get_subscriber_formdata {
        z-index: 1060 !important;
    }
</style>
<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php
$builder_load_url = base_url("messenger_bot_connectivity/load_form_builder/{$page_id}");
?>
<div class="row">


        <?php

        // Gets user info ID
        $facebook_rx_fb_user_info_id = $this->session->userdata('facebook_rx_fb_user_info');

        // Prepares sql statements and clauses
        $where = [
            'where' => [
                'facebook_rx_fb_user_info_id' => $facebook_rx_fb_user_info_id,
                'bot_enabled' => '1',
            ]
        ];

        $select = ['id', 'page_name'];

        // Executes query
        $pages = $this->basic->get_data('facebook_rx_fb_page_info', $where, $select, []);


        if (count($pages) > 0) {
            $page_info = $pages;
        } else {
            $page_info = array();
        }

        if (!empty($page_info) and $iframe == 0) { ?>
            <div class="col-sm-12 col-md-6">
            <fieldset class="form-group" id="store_list_field">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"
                               for="bot_list_select"><?php echo $this->lang->line("Pages"); ?></label>
                    </div>
                    <select class="form-control select2" id="bot_list_select">

                        <?php $i = 0;
                        $current_store_data = array();
                        foreach ($page_info as $value) {
                            if ($value['id'] == $this->session->userdata("ecommerce_selected_store")) $current_store_data = $value;

                            ?>
                            <option value="<?php echo $value['id']; ?>" <?php if ($i == 0 || $value['id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>>
                                <?php
                                if (addon_exist($module_id = 320, $addon_unique_name = "instagram_bot")) {
                                    if (isset($media_type) && $media_type == "ig") {
                                        echo $value['insta_username'] . " [" . $value['page_name'] . "]";
                                    } else {
                                        echo $value['page_name'];
                                    }
                                } else {
                                    echo $value['page_name'];
                                }
                                ?>
                            </option>

                            <?php $i++;
                        } ?>
                    </select>
                </div>
            </fieldset>
</div>
        <?php } ?>
    <div class="col-sm-12 col-md-6">
        <a href="<?php echo $builder_load_url; ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Create New Form'); ?>
        </a>
    </div>
</div>
<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id; ?>">
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="table-responsive">
                        <table id="webview-datatable" class="table table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Title"); ?></th>
                                <th><?php echo $this->lang->line("Page Name"); ?></th>
                                <th><?php echo $this->lang->line("Created At"); ?></th>
                                <th><?php echo $this->lang->line("Total Form Submitted"); ?></th>
                                <th><?php echo $this->lang->line("Last Form Submitted"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .card {
        box-shadow: none !important;
    }

    .data-div {
        margin-left: 45px;
    }

    .margin-top {
        margin-top: 30px;
    }

    .flex-column .nav-item .nav-link.active {
        background: #fff !important;
        color: #3516df !important;
        border: 1px solid #988be1 !important;
    }

    .flex-column .nav-item .nav-link .form_id, .flex-column .nav-item .nav-link .insert_date {
        color: #608683 !important;
        font-size: 12px !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    .waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 30px 0;
    }
</style>

<div class="modal fade" id="detail-webview-form-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding:30px;">
                <h3 class="modal-title"><i
                            class="bx bxs-help-circle"></i> <?php echo $this->lang->line("Form Details"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body" id="subscriber_actions_modal_body" data-backdrop="static" data-keyboard="false">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 id="detail-title"><?php echo $this->lang->line("Title"); ?></h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="section">
                                            <div class="section-title"><?php echo $this->lang->line("Page Name"); ?></div>
                                            <div id="detail-page-name" class="data-div"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="section">
                                            <div class="section-title"><?php echo $this->lang->line("Created At"); ?></div>
                                            <div id="detail-created-at" class="data-div"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="section">
                                            <div class="section-title"><?php echo $this->lang->line("Form ID"); ?></div>
                                            <div id="detail-form-id" class="data-div"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="section">
                                            <div class="section-title"><?php echo $this->lang->line("Labels"); ?></div>
                                            <div id="detail-assign-label" class="badges data-div"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="section">
                                            <div class="section-title"><?php echo $this->lang->line("Postback ID"); ?></div>
                                            <div id="detail-postback-id" class="data-div"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-12 margin-top">
                                    <div class="card-body pb-0">
                                        <input type="text" id="searching" name="searching" class="form-control"
                                               placeholder="<?php echo $this->lang->line("Search..."); ?>"
                                               style='width:200px;'>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card-body data-card">
                                        <div class="table-responsive2">
                                            <input type="hidden" id="put_form_id">
                                            <table class="table table-bordered" id="mytable1">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?php echo $this->lang->line("Avatar"); ?></th>
                                                    <th><?php echo $this->lang->line("First Name"); ?></th>
                                                    <th><?php echo $this->lang->line("Last Name"); ?></th>
                                                    <th><?php echo $this->lang->line("Subscriber ID"); ?></th>
                                                    <th><?php echo $this->lang->line("Submitted At"); ?></th>
                                                    <th><?php echo $this->lang->line("Actions"); ?></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div id="detail-first-view">
                                    <div class="first-view-spinner">
                                        <i class="bx bx-loader-alt bx-spin bx-2x blue"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="get_subscriber_formdata" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" style="min-width: 65%;">
        <div class="modal-content">
            <div class="modal-header" style="padding:30px;">
                <h3 class="modal-title"><i
                            class="bx bxs-help-circle"></i> <?php echo $this->lang->line("All Submitted Form Data"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body" data-backdrop="static" data-keyboard="false">
                <div class="row">
                    <div class="col-12">
                        <div class="row formdata_div"></div>
                    </div>

                    <!-- <div id="waiting-div">
                        <div class="first-view-spinner text-center" style="margin:">
                            <i class="bx bx-loader-alt bx-spin bx-2x blue"></i>
                        </div>
                    </div> -->
                    <div class="text-center waiting" id="waiting-div">
                        <i class="bx bx-loader-alt bx-spin blue text-center" style="font-size:40px"></i>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
            </div>

        </div>
    </div>
</div>
