<?php $this->load->view('admin/theme/message');

$include_select2 = 1;

?>
<style>
    #page_id {
        width: 150px;
    }

    #searching {
        max-width: 40%;
    }

    .swal-text {
        text-align: left !important;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 90px;
        }

        #searching {
            max-width: 50%;
        }

        #add_label {
            max-width: 100% !important;
        }
    }
</style>
<?php
//todo: modal
//todo: icons
?>
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
        <a href="#" class="btn btn-primary mb-1 add_label">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("New Label"); ?>
        </a>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-md-8 col-12">
                            <div class="input-group mb-3 float-left" id="searchbox">

                                <!-- search by page name -->
                                <div class="input-group-prepend">
                                    <?php echo $page_dropdown; ?>
                                </div>

                                <input type="text" class="form-control" id="searching" name="searching" autofocus
                                       placeholder="<?php echo $this->lang->line('Search...'); ?>" aria-label=""
                                       aria-describedby="basic-addon2">

                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="search_submit"
                                            title="<?php echo $this->lang->line('Search'); ?>" type="button"><i
                                                class="bx bx-search"></i> <span
                                                class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Label"); ?></th>
                                <th><?php echo $this->lang->line("Label ID"); ?></th>
                                <th><?php echo addon_exist($module_id = 320, $addon_unique_name = "instagram_bot") ? $this->lang->line("Page/Account") : $this->lang->line("Page Name"); ?></th>
                                <th><?php echo $this->lang->line("Action"); ?></th>
                                <th><?php echo $this->lang->line("Social Media"); ?></th>
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


<div class="modal fade" id="add_label" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Label") ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" id="add_label_modal_body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="bx bx-purchase-tag-alt"></i> <?php echo $this->lang->line('Label Name'); ?>
                            </label>
                            <input type="text" name="group_name" id="group_name" class="form-control">
                            <span id="name_err" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label><i class="bx bxs-file"></i> <?php echo $this->lang->line('Page Name'); ?></label>
                            <?php echo $page_dropdown2; ?>
                            <span id="page_err" class="text-danger"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="result_status"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="bx bx-time"></i> <?php echo $this->lang->line('Close'); ?></button>
                <button id="create_label" type="button" class="btn btn-primary"><i class="bx bxs-save"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
            </div>
        </div>
    </div>
</div>
