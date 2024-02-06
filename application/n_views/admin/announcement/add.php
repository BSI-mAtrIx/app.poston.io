<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('announcement/full_list'); ?>"><?php echo $this->lang->line("Announcement"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">

    <div class="row">
        <div class="col-12">
            <form class="form-horizontal" action="<?php echo site_url() . 'announcement/add_action'; ?>" method="POST">
                <input type="hidden" name="csrf_token" id="csrf_token"
                       value="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label><?php echo $this->lang->line("Title"); ?> *</label><br/>
                            <input type="text" id="title" name="title" class="form-control"/>
                            <span class="text-danger"><?php echo form_error('title'); ?></span>
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line("Description"); ?> *</label><br/>
                            <textarea name="description" style="height:200px !important;" class="form-control"
                                      id="description"></textarea>
                            <span class="text-danger"><?php echo form_error('description'); ?></span>
                        </div>


                            <div class="form-group">
                                <label for="status"> <?php echo $this->lang->line('Status'); ?></label><br>
                                <label class="custom-switch mt-2">
                                    <input type="checkbox" name="status" id="status" value="published"
                                           class="custom-control-input" checked>
                                    <label class="custom-control-label mr-1" for="status"></label>
                                    <span><?php echo $this->lang->line('Publish'); ?></span>
                                    <span class="text-danger"><?php echo form_error('status'); ?></span>
                                </label>
                            </div>


                    </div>
                    <div class="card-footer bg-whitesmoke">
                        <button name="submit" type="submit" id="save_announcement" class="btn btn-primary"><i
                                    class="bx bxs-save"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                        <button type="button" class="btn btn-secondary float-right"
                                onclick='goBack("announcement/full_list",0)'><i class="bx bx-trash"></i> <span
                                    class="align-middle ml-25"><?php echo $this->lang->line("cancel"); ?></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

