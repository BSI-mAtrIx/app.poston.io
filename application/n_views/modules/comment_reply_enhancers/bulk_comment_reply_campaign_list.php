<style>
    #page_id {
        width: 150px;
    }

    #searching {
        max-width: 40%;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 90px;
        }

        #searching {
            max-width: 50%;
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
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("comment_automation/comment_growth_tools"); ?>"><?php echo $this->lang->line("Comment Growth Tools"); ?></a>
                    </li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("comment_automation/comment_section_report"); ?>"><?php echo $this->lang->line("Report"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('admin/theme/message');
?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-md-9 col-12">
                            <div class="input-group mb-3 float-left" id="searchbox">
                                <!-- search by page name -->
                                <div class="input-group-prepend">
                                    <select class="select2 form-control" id="page_id" name="page_id">
                                        <option value=""><?php echo $this->lang->line("Page Name"); ?></option>
                                        <?php foreach ($page_info as $key => $value): ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if ($value['id'] == $this->session->userdata('selected_global_page_table_id')) echo 'selected'; ?>><?php echo $value['page_name']; ?></option>
                                        <?php endforeach ?>
                                    </select>
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
                        <div class="col-md-3 col-12">
                            <a href="javascript:;" id="post_date_range"
                               class="btn btn-primary float-right has-icon-left btn-icon"><i
                                        class="bx bx-calendar"></i> <?php echo $this->lang->line("Choose Date"); ?>
                            </a><input type="hidden" id="post_date_range_val">
                        </div>
                    </div>
                    <div class="table-responsive2">
                        <table class="table table-bordered" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("Campaign ID"); ?></th>
                                <th><?php echo $this->lang->line("Avatar"); ?></th>
                                <th><?php echo $this->lang->line("Name"); ?></th>
                                <th><?php echo $this->lang->line("Page name"); ?></th>
                                <th><?php echo $this->lang->line("Post ID"); ?></th>
                                <th><?php echo $this->lang->line("Reply"); ?></th>
                                <th><?php echo $this->lang->line("Sent"); ?></th>
                                <th><?php echo $this->lang->line("Failed"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                                <th style="min-width: 100px"><?php echo $this->lang->line("Status"); ?></th>
                                <th><?php echo $this->lang->line("Scheduled at"); ?></th>
                                <th><?php echo $this->lang->line("Last Updated"); ?></th>
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
                <h3 class="modal-title"><i class="bx bx-comment-dots"></i> <?php echo $this->lang->line("Report"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body data-card">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary"><i class="bx bxs-help-circle"></i></div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4><?php echo $this->lang->line('Campaign Name'); ?></h4></div>
                                        <div class="card-body" id="campaign_name"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="bx bx-news"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4><?php echo $this->lang->line('Page Name'); ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <a target="_BLANK" href="" id="pageName"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="bx bx-id-card-alt"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4><?php echo $this->lang->line('Post ID'); ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <a target="_BLANK" href="" id="postID"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-danger text-center" id="errorMsg"></div>
                                <br></div>
                        </div>
                    </div>
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
                                    <th><?php echo $this->lang->line("Commenter Name"); ?></th>
                                    <th><?php echo $this->lang->line("Commenter ID"); ?></th>
                                    <th><?php echo $this->lang->line("Comment Time"); ?></th>
                                    <th><?php echo $this->lang->line("Reply Status"); ?></th>
                                    <th><?php echo $this->lang->line("Replied At"); ?></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-12">
                        <div class="section">
                            <div class="section-title">
                                <h6><?php echo $this->lang->line('Reply Content'); ?></h6>
                            </div>
                            <div class="alert alert-light" id="replyContent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="commenter_list_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h4 class="modal-title"><i class="bx bx-list-ul"></i> <?php echo $this->lang->line("Report"); ?></h4>
            </div>
            <div class="modal-body" id="commenter_list_body">

            </div>
        </div>
    </div>
</div>







