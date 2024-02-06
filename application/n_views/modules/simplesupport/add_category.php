<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("simplesupport/tickets"); ?>"><?php echo $this->lang->line("Support Desk"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("simplesupport/support_category_manager"); ?>"><?php echo $this->lang->line("Support category"); ?></a>
                    </li>

                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="row">
    <div class="col-12">

        <form class="form-horizontal" action="<?php echo site_url() . 'simplesupport/add_category_action'; ?>"
              method="POST">
            <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label for="category_name"> <?php echo $this->lang->line("Category Name") ?> *</label>
                        <input name="category_name" value="<?php echo set_value('category_name'); ?>"
                               class="form-control" type="text">
                        <span class="text-danger"><?php echo form_error('category_name'); ?></span>
                    </div>

                </div>

                <div class="card-footer bg-whitesmoke">
                    <button name="submit" type="submit" class="btn btn-primary"><i class="bx bxs-save"></i> <span
                                class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                    <button type="button" class="btn btn-secondary float-right"
                            onclick='goBack("simplesupport/support_category_manager",0)'><i class="bx bx-trash"></i>
                        <span class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span></button>
                </div>
            </div>
        </form>
    </div>
</div>

