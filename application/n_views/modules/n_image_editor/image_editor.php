<style type="text/css">
    .alert a {
        text-decoration: none;
    }

    #editormain image-editor .canvas-wrapper {
        min-height: 900px !important;
    }

    #editormain pixie-editor .tool-panel-container .cancel-button {
        width: 90px !important;
    }

    .fullscreen_ie {
        position: absolute;
        width: 100%;
        z-index: 1020;
        height: 100vh;
        top: 0;
        left: 0;
        background: #F2F4F4;
    }

    .fullscreen_ie .content-header, .fullscreen_ie .section-button {
        padding-left: 15px;
    }

    .fullscreen_ie iframe {
        height: calc(100vh - 236px) !important;
    }

    image-editor .content {
        margin-left: 0;
    }

</style>


<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>


<div id="editormain">


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

    <div class="section-button row">
        <div class="col-12">
            <a id="fullscreen_switch" href="#" class="btn btn-primary mb-1">
                <i class="bx bx-expand"></i> <?php echo $this->lang->line("Toggle Full Screen"); ?>
            </a>
        </div>
    </div>


    <div class="section-body">
        <iframe style="width:100%;  border:0; min-height: 100vh;" id="miniPaint"
                src="<?= base_url() ?>n_image_editor/editor"></iframe>
    </div>

</div>



