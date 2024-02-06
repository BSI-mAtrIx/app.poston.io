<?php

$import_section = 'false';
if (file_exists(APPPATH . 'n_eco_user/contact_page_' . strtolower($current_language) . '_p.php')) {
    $import_section = APPPATH . 'n_eco_user/contact_page_' . strtolower($current_language) . '_p.php';
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
                    <h4 class="card-title"><?php echo $this->lang->line('Contact page'); ?></h4>
                </div>
                <div class="card-body">
                    <?php echo $n_editor_data['gjs-html']; ?>
                </div>
            </div>
        </div>
    </div>
</div>
