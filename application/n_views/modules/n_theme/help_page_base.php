<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("Help"); ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<?php

$import_section = 'false';
if (file_exists(APPPATH . 'n_eco_user/help_' . strtolower($current_language) . '.php')) {
    $import_section = APPPATH . 'n_eco_user/help_' . strtolower($current_language) . '.php';
} else {
    if (file_exists(APPPATH . 'n_eco_user/help_' . $n_config['dashboard_section_1_default'] . '.php')) {
        $import_section = APPPATH . 'n_eco_user/help_' . $n_config['dashboard_section_1_default'] . '.php';
    }
}


if ($import_section != 'false') {
    $n_editor_data = file_get_contents($import_section);
    $n_editor_data = json_decode($n_editor_data, true);
} else {
    $n_editor_data = array();
    $n_editor_data['gjs-html'] = '';
    $n_editor_data['gjs-components'] = '';
    $n_editor_data['gjs-assets'] = '';
    $n_editor_data['gjs-css'] = '';
    $n_editor_data['gjs-styles'] = '';
}

?>

<style>
    <?php echo $n_editor_data['gjs-css']; ?>
</style>

<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('Help'); ?></h4>
                </div>
                <div class="card-body">
                    <?php echo $n_editor_data['gjs-html']; ?>
                </div>
            </div>
        </div>
    </div>
</div>
