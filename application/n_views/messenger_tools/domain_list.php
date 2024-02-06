<!-- new datatable section -->

<div class="content-header row d-none">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("messenger_bot/bot_menu_section"); ?>"><?php echo $this->lang->line("Messenger Bot"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-sm-12 col-md-6">
        <?php
        $page_info = $pagelist[array_key_first($pagelist)]['page_data'];
        if (!empty($page_info) and $iframe == 0) { ?>
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
                            <option value="<?php echo $value['page_id']; ?>" <?php if ($i == 0 || $value['page_id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>>
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
    <div class="col-sm-12 col-md-6">
        <a id="add_new_domain" href="#" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Domain"); ?>
        </a>

    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">

                    <input type="hidden" id="page_id" name="page_id" value="<?php echo $page_id; ?>">

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
                                <th><?php echo $this->lang->line("FB Account") ?></th>
                                <th><?php echo $this->lang->line("Page Name") ?></th>
                                <th><?php echo $this->lang->line("Domain Count") ?></th>
                                <th><?php echo $this->lang->line("Action") ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="domain_list_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-list-ul"></i> <?php echo $this->lang->line("Domain List"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h4 class='text-center'><?php echo $this->lang->line('Page') . " : "; ?><span
                                    id="put_page_name"></span> (<span id="put_account_name"></span>)</h4><br/>
                    </div>

                    <div class="col-12 margin-top">
                        <input type="text" id="searching" name="searching" class="form-control"
                               placeholder="<?php echo $this->lang->line("Search..."); ?>" style='width:200px;'>
                    </div>
                    <div class="col-12">
                        <div class="data-card">
                            <input type="hidden" name="put_page_id" id="put_page_id">
                            <div class="table-responsive2">
                                <table class="table table-bordered" id="mytable1" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line("Domain"); ?></th>
                                        <th><?php echo $this->lang->line("Whitelisted At"); ?></th>
                                        <th><?php echo $this->lang->line("Actions"); ?></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i> <?php echo $this->lang->line('close'); ?></button>
            </div> -->
        </div>
    </div>
</div>

<div class="modal fade" id="add_new_domain_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-plus"></i> <?php echo $this->lang->line("Add Domain"); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div id="add_new_domain_response" class="text-center"></div>
                <div class="form-group col-12" style="padding:0 5px 0 0; display:none;">
                    <label><?php echo $this->lang->line("Page") ?> *</label>
                    <select class="form-control select2" id="add_new_domain_page_old" name="add_new_domain_page_old">
                        <?php
                        echo "<option value=''>" . $this->lang->line('Choose Page') . "</option>";
                        foreach ($pagelist as $key => $value) {
                            echo '<optgroup label="' . addslashes($value['account_name']) . '">';
                            foreach ($value['page_data'] as $key2 => $value2) {
                                echo "<option value='" . $value2['page_id'] . "'>" . $value2['page_name'] . "</option>";
                            }
                            echo '</optgroup>';
                        } ?>
                    </select>
                </div>
                <div class="form-group col-12" style="padding:0 5px 0 0">
                    <label><?php echo $this->lang->line("Domain") ?> *</label>
                    <input placeholder="http://xyz.com" name="add_new_domain_name" id="add_new_domain_name"
                           class="form-control" type="text"/>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary float-right" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('close'); ?></button>
                <button class="btn btn-primary float-left" name="add_new_domain_submit" id="add_new_domain_submit"
                        type="button"><i class="bx bx-save"></i> <?php echo $this->lang->line('save'); ?></button>
            </div>
        </div>
    </div>
</div>