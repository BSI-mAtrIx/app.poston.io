<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("FAQ"); ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<?php

$import_section = 'false';
if (file_exists(APPPATH . 'n_eco_user/faq_' . strtolower($current_language) . '.php')) {
    $import_section = APPPATH . 'n_eco_user/faq_' . strtolower($current_language) . '.php';
} else {
    if (file_exists(APPPATH . 'n_eco_user/faq_' . $n_config['page_faq_default'] . '.php')) {
        $import_section = APPPATH . 'n_eco_user/faq_' . $n_config['page_faq_default'] . '.php';
    }
}


if ($import_section != 'false') {
    $n_editor_data = file_get_contents($import_section);
    $n_editor_data = json_decode($n_editor_data, true);
} else {
    $n_editor_data = array();
}

?>


<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card bg-transparent shadow-none">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('FAQ'); ?></h4>
                </div>
                <div class="card-body">
                    <div id="accordion-icon-wrapper1" class="collapse-icon accordion-icon-rotate">
                        <div class="accordion" id="accordionWrapar2">
                            <?php
                            if (!empty($n_editor_data)) {
                                foreach ($n_editor_data['group-a'] as $k => $v) { ?>
                                    <div class="card collapse-header">
                                        <div id="heading5" class="card-header" data-toggle="collapse" role="button"
                                             data-target="#accordion<?php echo $k; ?>" aria-expanded="false"
                                             aria-controls="accordion<?php echo $k; ?>">
                      <span class="collapse-title d-flex align-items-center"><i class="bx bxs-circle font-small-1"></i>
                        <?php echo $v['question']; ?>
                      </span>
                                        </div>
                                        <div id="accordion<?php echo $k; ?>" role="tabpanel"
                                             data-parent="#accordionWrapar2" aria-labelledby="heading5"
                                             class="collapse">
                                            <div class="card-body">
                                                <?php echo $v['answer']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }

                            ?>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
