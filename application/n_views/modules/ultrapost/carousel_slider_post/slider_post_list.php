<?php $this->load->view('admin/theme/message'); ?>
<style>
    .dropdown-toggle::after {
        content: none !important;
    }

    .badges {
        padding: 2px 10px;
        border-radius: 10px;
        font-size: 12px;
    }

    .purple {
        color: #d43f8d !important;
    }

    #page_id {
        width: 150px;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 90px;
        }

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
                    <li class="breadcrumb-item active"><a
                                href="<?php echo base_url("ultrapost"); ?>"><?php echo $this->lang->line("Facebook Poster"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url("ultrapost/carousel_slider_poster"); ?>" class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Create new Post"); ?>
        </a>
    </div>
</div>


<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-md-9 col-12">
                            <div class="input-group mb-3" id="searchbox"><!-- search by page name -->
                                <div class="input-group-prepend">
                                    <select class="form-control select2" id="page_id" name="page_id">
                                        <!--	          	  	          	        	<option value="">-->
                                        <?php //echo $this->lang->line("Page Name"); ?><!--</option>-->
                                        <?php foreach ($fb_page_info as $key => $value): ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>><?php echo $value['page_name']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <div class="input-group-prepend has-icon-left">
                                    <input name="campaign_name" id="campaign_name" aria-describedby="basic-addon2"
                                           class="form-control" type="text"
                                           placeholder="<?php echo $this->lang->line('campaign name'); ?>"/>
                                    <div class="form-control-position">
                                        <i class="bx bx-search"></i>
                                    </div>
                                </div>

                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="search_submit"
                                            title="<?php echo $this->lang->line('Search'); ?>" type="button"><i
                                                class="bx bx-search"></i> <span
                                                class="d-none d-sm-inline"><?php echo $this->lang->line('Search'); ?></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <a href="javascript:;" id="post_date_range"
                               class="btn btn-primary float-right has-icon-left btn-icon">
                                <i class="bx bx-calendar"></i>
                                <?php echo $this->lang->line("Choose Date"); ?>
                            </a>
                            <input type="hidden" id="post_date_range_val">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table zero-configuration" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Campaign ID"); ?></th>
                                <th><?php echo $this->lang->line('Name'); ?></th>
                                <th><?php echo $this->lang->line('Campaign Type'); ?></th>
                                <th><?php echo $this->lang->line('Publisher'); ?></th>
                                <th><?php echo $this->lang->line('Post Type'); ?></th>
                                <th><?php echo $this->lang->line('Actions'); ?></th>
                                <th><?php echo $this->lang->line('Status'); ?></th>
                                <th><?php echo $this->lang->line('Scheduled at'); ?></th>
                                <th><?php echo $this->lang->line('Error'); ?></th>
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


<div class="modal fade" id="view_report_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-windows"></i> <?php echo $this->lang->line("Report of Video Slide Show/Carousel Post"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body data-card">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <input type="text" id="searching1" name="searching1" class="form-control"
                               placeholder="<?php echo $this->lang->line("Search..."); ?>" style='width: 200px;'>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive2">
                            <input type="hidden" id="put_row_id">
                            <table class="table table-bordered" id="mytable1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo $this->lang->line("id"); ?></th>
                                    <th><?php echo $this->lang->line("posting page or group"); ?></th>
                                    <th><?php echo $this->lang->line("Post Type"); ?></th>
                                    <th><?php echo $this->lang->line("Post ID"); ?></th>
                                    <th><?php echo $this->lang->line("Posting Status"); ?></th>
                                    <th><?php echo $this->lang->line("Schedule Time"); ?></th>
                                    <th><?php echo $this->lang->line("Error"); ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="embed_code_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-code"></i> <?php echo $this->lang->line('Get Embed Code'); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="embed_code_content">

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="view_report" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog  modal-lg" style="min-width: 70%;max-width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h4 class="modal-title text-center"><i
                            class="bx bx-list-ul"></i> <?php echo $this->lang->line("report of Video Slide Show/Carousel Post") ?>
                </h4>
            </div>
            <div class="modal-body text-center" id="view_report_modal_body">

            </div>
        </div>
    </div>
</div>