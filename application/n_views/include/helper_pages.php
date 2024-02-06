<?php
$import_modal = 'false';
if (file_exists(APPPATH . 'n_eco_user/helper_' . md5(uri_string()) . '_' . strtolower($current_language) . '.php')) {
    $import_modal = APPPATH . 'n_eco_user/helper_' . md5(uri_string()) . '_' . strtolower($current_language) . '.php';
} else {
    if (file_exists(APPPATH . 'n_eco_user/helper_' . md5(uri_string()) . '_' . $n_config['helper_default_lang'] . '.php')) {
        $import_modal = APPPATH . 'n_eco_user/helper_' . md5(uri_string()) . '_' . $n_config['helper_default_lang'] . '.php';
    }
}

if ($import_modal != 'false') {
    $n_modal_data = file_get_contents($import_modal);
    $n_modal_data = json_decode($n_modal_data, true);
} else {
    $n_modal_data = array();
    $n_modal_data['gjs-html'] = '';
    $n_modal_data['gjs-components'] = '';
    $n_modal_data['gjs-assets'] = '';
    $n_modal_data['gjs-css'] = '';
    $n_modal_data['gjs-styles'] = '';
}

if ($import_modal != 'false') {

    echo '<style>' . $n_modal_data['gjs-css'] . '</style>';
    ?>
    <div class="customizer d-block">
        <a class="customizer-toggle" data-toggle="modal" data-target="#helper_modal_show" href="javascript:void(0);"><i
                    class="bx bx-help-circle <?php if ($n_config['helper_animation'] == 'true') {
                        echo 'bx-spin';
                    } ?> white"></i></a>
    </div>


    <div class="modal fade text-left" id="helper_modal_show" tabindex="-1" role="dialog" aria-labelledby="start_modal1"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel1"><?php echo $this->lang->line('Help'); ?></h3>
                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body p-0 pt-1">
                    <?php echo $n_modal_data['gjs-html']; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" id="start_modal_hide" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><?php echo $this->lang->line('Close'); ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

<?php } ?>