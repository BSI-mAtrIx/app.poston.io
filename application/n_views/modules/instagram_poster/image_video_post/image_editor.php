<?php $include_js_uni = FCPATH . "application/n_views/modules/instagram_poster/image_video_post/image_editor_js.php"; ?>

<div class="modal fade modal-fullscreen" id="tuiModal" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header pt-1 pr-2 bg-dark no_radius">
                <h5 class="modal-title" id="exampleModalLabel"><i
                            class="bx bx-image"></i> <?php echo $this->lang->line("Editor"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body p-0">
                <div id="tui-image-editor-container"></div>
                <input type="hidden" id="image_type">
            </div>
            <div class="modal-footer bg-dark no_radius">
                <button type="button" class="btn btn-warning" id="image_save"><i
                            class="bx bx-save"></i> <?php echo $this->lang->line("Save Image"); ?></button>
                <button type="button" class="btn btn-light" data-dismiss="modal"><span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>

