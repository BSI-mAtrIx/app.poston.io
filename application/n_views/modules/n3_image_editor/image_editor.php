<style type="text/css">
    #tui-image-editor-container {
        min-height: 1000px;
    }

    .tui-image-editor-controls-logo {
        display: none !important;
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

    .fullscreen_ie #tui-image-editor-container {
        height: calc(100vh - 76px) !important;
    }
</style>

<link type="text/css"
      href="https://uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet">
<link type="text/css"
      href="<?= base_url() ?>plugins/tui/dist/tui-image-editor.css?ver=<?php echo $n_config['theme_version']; ?>"
      rel="stylesheet">


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

        <div id="tui-image-editor-container"></div>


    </div>


</div>