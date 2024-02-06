<style>
    .tickets-list:last-child .ticket-item {
        border-bottom: 1px solid #dee2e6 !important;
    }

    .tickets-list:first-child .ticket-item {
        border-top: 0 !important;
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
                                href="<?php echo base_url('integration'); ?>"><?php echo $this->lang->line("Integration"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a id="add_feed" href="#" data-target="#activecampaign-integration-modal" data-toggle="modal"
           class="btn btn-primary mb-1 add_connector">
            <i class="bx bx-plus-circle"></i> <?= $this->lang->line('Add Account') ?>
        </a>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="table-responsive">
                        <table id="activecampaign-datatable" class="table table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Tracking name"); ?></th>
                                <th><?php echo $this->lang->line("API URL"); ?></th>
                                <th><?php echo $this->lang->line("API Key"); ?></th>
                                <th><?php echo $this->lang->line("Created At"); ?></th>
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


<div class="modal fade" tabindex="-1" role="dialog" id="activecampaign-integration-modal" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-plus-circle"></i> Activecampaign
                    - <?= $this->lang->line('Add Account') ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="" id="activecampaign-integration-form">
                    <div class="form-group">
                        <label><?= $this->lang->line('Tracking Name') ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="bx bx-tag"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="tracking-name"
                                   placeholder='<?php echo $this->lang->line("Tracking Name"); ?>' name="tracking-name"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= $this->lang->line('API URL') ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="bx bx-link"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="api-url" placeholder="Activecampaign API URL"
                                   name="api-url" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= $this->lang->line('API Key') ?></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="bx bx-key"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="api-key" placeholder="Activecampaign API Key"
                                   name="api-key" autocomplete="off">
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary btn-shadow float-left"
                                id="activecampaign-submit-button"><i
                                    class="bx bxs-save"></i> <?= $this->lang->line('Save') ?></button>
                        <button type="button" class="btn btn-secondary btn-shadow float-right" data-dismiss="modal"><i
                                    class="bx bx-time"></i> <?= $this->lang->line('Cancel') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="activecampaign-details-modal" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document" style="min-width:50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Activecampaign - <?= $this->lang->line('Account Details') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="card shadow-none">
                    <div class="card-header p-1 pb-0">
                        <h5 id="display-tracking-name"><?php echo $this->lang->line('Test Account'); ?></h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="activecampaign-list-group" class="list-group">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

