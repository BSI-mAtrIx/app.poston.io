<?php

$include_prism = 1;

?>

<style>
    .dropdown-toggle::after {
        content: none !important;
    }

    .dropdown-toggle::before {
        content: none !important;
    }

    #post_type {
        width: 130px !important;
    }

    @media (max-width: 575.98px) {
        #page_id {
            width: 130px !important;
        }

        #post_type {
            max-width: 110px !important;
        }

    }

    .waiting, .modal_waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    .waiting i, .modal_waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 30px 0;
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
        <a href="<?php echo base_url("vidcasterlive/add_live_scheduler"); ?>" class="btn btn-primary mb-1">
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
                            <div class="input-group mb-3 float-left" id="searchbox">
                                <!-- search by post type -->
                                <div class="input-group-prepend">
                                    <select class="select2 form-control" id="post_type" name="post_type">
                                        <option value=""><?php echo $this->lang->line("All Posts"); ?></option>
                                        <option value="0"><?php echo $this->lang->line("Pending"); ?></option>
                                        <option value="1"><?php echo $this->lang->line("Processing"); ?></option>
                                        <option value="2"><?php echo $this->lang->line("Completed"); ?></option>
                                    </select>
                                </div>


                                <div class="input-group-append has-icon-left">
                                    <input name="searching" id="searching" autofocus
                                           class="form-control" type="text"
                                           placeholder="<?php echo $this->lang->line('Publisher/Campaign name'); ?>"/>
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
                                <?php echo $this->lang->line("Choose schedule date"); ?>
                            </a>
                            <input type="hidden" id="post_date_range_val">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table zero-configuration" id="mytable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo $this->lang->line("ID"); ?></th>
                                <th><?php echo $this->lang->line("Publisher"); ?></th>
                                <th><?php echo $this->lang->line("Campaign Name"); ?></th>
                                <th><?php echo $this->lang->line("Live"); ?></th>
                                <th><?php echo $this->lang->line("Status"); ?></th>
                                <th><?php echo $this->lang->line("Actions"); ?></th>
                                <th><?php echo $this->lang->line("Scheduled time"); ?></th>
                                <th><?php echo $this->lang->line("Stream Started"); ?></th>
                                <th><?php echo $this->lang->line("Stream Ended"); ?></th>
                                <th><?php echo $this->lang->line("FFMPEG Error Log"); ?></th>
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


<div class="modal fade" id="ffmpeg_log_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-code"></i> <?php echo $this->lang->line("FFMPEG Error Log"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="ffmpeg_log_content">

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="embed_code_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-code"></i> <?php echo $this->lang->line("Get Embed Code"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body" id="embed_code_content">

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="stream_info_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-code"></i> <?php echo $this->lang->line("Get Stream Info"); ?>
                </h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="row" id="stream_info_loading">

                </div>
                <div class="row" id="stream_info_content">
                    <div class="col-12">
                        <div class="section">
                            <h4 class="section-title"><?php echo $this->lang->line('Server URL'); ?></h4>
                            <pre class='language-javascript'><code id='server_url' class='dlanguage-javascript'></code></pre>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="section">
                            <h4 class="section-title"><?php echo $this->lang->line('Stream Key'); ?></h4>
                            <pre class='language-javascript'><code id='stream_key' class='dlanguage-javascript'></code></pre>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="section">
                            <h4 class="section-title"><?php echo $this->lang->line('Stream URL'); ?></h4>
                            <pre class='language-javascript'><code id='stream_url' class='dlanguage-javascript'></code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
