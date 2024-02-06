<style>
    .row-actions{display:none;}
    tr:hover .row-actions{display:block;}
</style>

<?php if (!defined('NVX')) { ?>
    <section class="section section_custom">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><?php echo $page_title; ?></div>
            </div>
        </div>
    </section>

    <style>
        .card-title{
            margin-bottom: 0;
        }

        .card .card-header {
            align-items: center;
            flex-wrap: wrap;
            justify-content: space-between;
        }

    </style>

<?php } else { ?>
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php

    $include_datatable = 1;
} ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo $this->lang->line("Files"); ?></h5>
                    <a class="btn btn-primary" href="<?php echo base_url('n_generator/editor'); ?>"><span
                                class="align-middle ml-25"><?php echo $this->lang->line("New document"); ?></span></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table row-grouping" id="mytable" style="width:100%">
                            <thead>
                            <tr>
                                <th><?php echo $this->lang->line("id"); ?></th>
                                <th><?php echo $this->lang->line("Title"); ?></th>
                                <th><?php echo $this->lang->line("Last Open"); ?></th>
                                <th><?php echo $this->lang->line("Created"); ?></th>
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
