<?php
/* include universal js */
$include_js_uni = "application/n_views/sms_email_manager/contact_book/contact_book_js.php";
?>
<?php
//TODO: check modals
//TODO: 0000000 NEED BEFORE RELEASE
?>
<style>


    .card-header {
        border-bottom-width: thin !important;
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
                                href="<?php echo base_url("subscriber_manager"); ?>"><?php echo $this->lang->line("Subscriber Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary add_group mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Group"); ?>
        </a>
    </div>
</div>


<div class="section-body">
    <div class="card"><br>
        <div class="row">
            <div class="col-12">
                <div class="card-header">
                    <form action="<?php echo base_url('sms_email_manager/contact_group_list/'); ?>" method="post">
                        <div class="input-group mb-3" id="searchbox">
                            <div class="input-group-prepend">
                                <select name="rows_number" class="selectric form-control" id="rows_number"
                                        style="width: 100%;">
                                    <option value="10" <?php if ($per_page == 10) echo 'selected'; ?>><?php echo $this->lang->line('10 items'); ?></option>
                                    <option value="25" <?php if ($per_page == 25) echo 'selected'; ?>><?php echo $this->lang->line('25 items'); ?></option>
                                    <option value="50" <?php if ($per_page == 50) echo 'selected'; ?>><?php echo $this->lang->line('50 items'); ?></option>
                                    <option value="100" <?php if ($per_page == 100) echo 'selected'; ?>><?php echo $this->lang->line('100 items'); ?></option>
                                    <option value="500" <?php if ($per_page == 500) echo 'selected'; ?>><?php echo $this->lang->line('500 items'); ?></option>
                                    <option value="all" <?php if ($per_page == 'all') echo 'selected'; ?>><?php echo $this->lang->line('All items'); ?></option>
                                </select>
                            </div>

                            <input name="search_value" type="text" class="form-control group_search no_radius"
                                   placeholder="<?php echo $this->lang->line('Type...'); ?>" aria-label=""
                                   aria-describedby="basic-addon2" value="<?php echo $search_value; ?>">

                            <div class="input-group-append" style="margin-top:-1px !important;">
                                <button class="btn btn-primary no_radius" id="group_search_submit" type="submit"><i
                                            class="bx bx-search"></i> <?php echo $this->lang->line('Search'); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($contactGroups) > 0): ?>
                <div class="row">
                    <?php foreach ($contactGroups as $key => $group): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4><?php echo date('M j, y', strtotime($group['created_at'])) ?></h4>
                                    <div class="card-header-action">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-outline-primary edit_group"
                                               group_id="<?php echo $group['id']; ?>"
                                               title="<?php echo $this->lang->line('Edit'); ?>"><i
                                                        class="bx bx-edit"></i> </a>
                                            <a href="#" class="btn btn-outline-primary delete_group"
                                               group_id="<?php echo $group['id']; ?>"
                                               title="<?php echo $this->lang->line('Delete'); ?>"><i
                                                        class="bx bx-trash-alt"></i> </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body text-center">
                                    <span style="font-family: cursive;"><?php echo (strlen($group['type']) > 30) ? substr($group['type'], 0, 25) . '...' : $group['type']; ?></span>
                                </div>

                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

                <div class="float-right">
                    <?php echo $page_links; ?>
                </div>

            <?php endif ?>
        </div>

    </div>
</div>


<div class="modal fade" id="add_contact_group_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add Contact Group'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><?php echo $this->lang->line('Group Name'); ?></label>
                            <input type="text" class="form-control" name="group_name" id="group_name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke">
                <button type="button" id="save_group" class="btn btn-primary"><i class="bx bxs-save"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="update_contact_group_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-edit"></i> <?php echo $this->lang->line('Update Contact Group'); ?></h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div id="group_body">

                </div>

            </div>

            <div class="modal-footer bg-whitesmoke">
                <button type="button" id="update_group" class="btn btn-primary"><i
                            class="bx bx-edit"></i> <?php echo $this->lang->line('Update'); ?></button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>
            </div>

        </div>
    </div>
</div>

