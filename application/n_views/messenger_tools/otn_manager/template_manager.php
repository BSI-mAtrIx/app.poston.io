<!-- new datatable section -->

<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("OTN Post-back Manager"); ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot_broadcast"); ?>"><?php echo $this->lang->line("Broadcasting"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("OTN Post-back Manager"); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <?php if (!empty($page_info) and $iframe == 0) { ?>
            <fieldset class="form-group" id="store_list_field">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text"
                               for="bot_list_select"><?php if ($media_type == 'ig') echo $this->lang->line("Accounts"); else echo $this->lang->line("Pages"); ?></label>
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

        <?php } ?>

    </div>
</div>


<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div>
                        <input type="hidden" value="<?php echo $page_id; ?>" id="page_id" name="page_id">
                        <div class="input-group mb-3" id="searchbox">
                            <input type="text" class="form-control" id="postback_id" autofocus
                                   placeholder="<?php echo $this->lang->line('PostBack'); ?>" aria-label=""
                                   aria-describedby="basic-addon2" style="max-width: 30%">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="search_submit" type="button"><i
                                            class="bx bx-search"></i> <span
                                            class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div>
                        <?php
                        $new_otn_url_classic = base_url("messenger_bot/otn_create_new_template/1/{$page_id}");
                        $new_otn_url_builder = base_url("visual_flow_builder/load_builder/{$page_id}/1/{$media_type}");

                        $drop_menu = '<a href="#" class="float-right btn btn-danger ml-2 get_otn_subscribers" page_table_id="' . $page_id . '" is_iframe="1"><i class="bx bx-user"></i> ' . $this->lang->line("OTN Subscribers") . '</a>&nbsp;<a href="' . $new_otn_url_builder . '" target="_BLANK" class="float-right btn btn-primary" title="' . $this->lang->line('Use Flow Builder') . '"><i class="bx bx-plus-circle"></i> ' . $this->lang->line("New Template") . '</a>&nbsp;<a href="' . $new_otn_url_classic . '" class="btn btn-info float-right mr-2 iframed" title="' . $this->lang->line('Use Classic Editor') . '"><i class="bx bx-plus-circle"></i></a>';

                        echo $drop_menu;
                        ?>


                    </div>
                </div>


                <div class="card-body data-card">


                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("id") ?></th>
                                <th><?php echo $this->lang->line("Page name") ?></th>
                                <th><?php echo $this->lang->line("Template name") ?></th>
                                <th><?php echo $this->lang->line("OTN postback ID") ?></th>
                                <th><?php echo $this->lang->line("Total OPTin subscribers") ?></th>
                                <th><?php echo $this->lang->line("Message sent") ?></th>
                                <th><?php echo $this->lang->line("Message not sent") ?></th>
                                <th><?php echo $this->lang->line("Type") ?></th>
                                <th><?php echo $this->lang->line("Actions") ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="otn_subscribers_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 95%;">
        <div class="modal-content">
            <div class="modal-header bbw">
                <h5 class="modal-title blue"><i
                            class="bx bx-user"></i> <?php echo $this->lang->line("OTN Subscribers"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div id="modalBody" class="modal-body">
                <input type="text" class="form-control" id="postback_id" autofocus
                       placeholder="<?php echo $this->lang->line('OTN PostBack ID'); ?>" aria-label=""
                       aria-describedby="basic-addon2" style="max-width: 40%">
                <div class="table-responsive2 data-card">
                    <input type="hidden" value="" id="get_subscribers_page_id" name="get_subscribers_page_id">
                    <table class="table table-bordered table-sm table-striped" id="mytable2">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line("Page Name"); ?></th>
                            <th><?php echo $this->lang->line("First Name"); ?></th>
                            <th><?php echo $this->lang->line("Last Name"); ?></th>
                            <th><?php echo $this->lang->line("OTN PostBack"); ?></th>
                            <th><?php echo $this->lang->line("Subscriber ID"); ?></th>
                            <th><?php echo $this->lang->line("OPT-in Token"); ?></th>
                            <th><?php echo $this->lang->line("OPT-in Time"); ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="modal-footer bg-whitesmoke">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line("Close"); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete_template_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center"><i
                            class="bx bx-trash"></i> <?php echo $this->lang->line("Template Delete Confirmation"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="delete_template_modal_body">

            </div>
        </div>
    </div>
</div>