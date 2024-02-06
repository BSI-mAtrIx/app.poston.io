<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("ecommerce"); ?>"><?php echo $this->lang->line("E-commerce"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Helper pages</h4>
        </div>
        <div class="card-body">

            <?php
            sort($all_pages);
            foreach ($all_pages as $k) { ?>
                <div class="row mb-1">
                    <div class="col-3">
                        <a class="card-title text-lowercase font-small-3"
                           href="<?php echo base_url() . $k; ?>"><?php echo $k; ?></a>
                    </div>
                    <div class="col-9">
                        <?php
                        ksort($language_info);
                        foreach ($language_info as $key_lang => $value_lang) {

                            $hp_exist = false;
                            $class_name = 'btn-outline-danger';
                            if (file_exists(APPPATH . 'n_eco_user/helper_' . md5($k) . '_' . $key_lang . '.php')) {
                                $class_name = 'btn-success';
                                $hp_exist = true;
                            }
                            ?>

                            <a title="<?php echo $this->lang->line("Theme settings"); ?>"
                               class="btn btn-small <?php echo $class_name; ?> mb-1"
                               href="<?php echo base_url('/n_theme/editor_page/helper_' . md5($k) . '_' . $key_lang); ?>">
                                <?php

                                if ($hp_exist == true) {
                                    echo '<i class="bx bx-edit"></i>  ';
                                }
                                echo $key_lang; ?>
                            </a>
                            <?php
                            if ($hp_exist == true) { ?>
                                <a title="<?php echo $this->lang->line("Theme settings"); ?>"
                                   class="btn btn-small btn-danger mb-1 hp_delete"
                                   data-file_lang="<?php echo md5($k) . '_' . $key_lang; ?>" href="#">
                                    <i class="bx bx-trash"></i> <?php echo $key_lang; ?>
                                </a>

                            <?php } ?>


                        <?php } ?>
                    </div>

                </div>
            <?php } ?>

        </div>
    </div>
</div>