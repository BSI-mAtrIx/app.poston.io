<style>
    .row-actions{display:none;}
    tr:hover .row-actions{display:block;}
</style>
<?php
$include_select2 = 1;
$include_dropzone = 1;
$include_cropper = 1;
$include_datatable=1;

if (!defined('NVX')) { ?>
    <section class="section section_custom">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><?php echo $page_title; ?></div>
            </div>
        </div>
    </section>
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
    $jodit = 1;
    $include_select2 = 1;
}
?>



<?php include(APPPATH . 'modules/n_wa/include/alert_message.php'); ?>


    <div class="section-body ntheme main">
        <div class="card" id="nodata">
            <div class="card-header">
                <h5 class="card-title"><?php echo $this->lang->line('List WhatsApp Bots'); ?></h5>
                <div class="heading-elements">
                    <a href="<?php echo base_url('n_wa/bot_settings'); ?>" class="btn btn-primary block">
                        <?php echo $this->lang->line('Add New WhatsApp Bot'); ?>
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table row-grouping" id="mytable" style="width:100%">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line("id"); ?></th>
                            <th><?php echo $this->lang->line("bot_name"); ?></th>
                            <th><?php echo $this->lang->line("subscribers"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
