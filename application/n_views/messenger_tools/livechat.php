<?php
$include_select2 = 1;
?>

<style>.select2 {
        width: 100% !important;
    }</style>
<div id="dynamic_field_modal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="page_name">
                <div class="modal-body" style="padding-bottom:0">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label><?php echo $this->lang->line("Select Facebook page / Instagram account"); ?></label>
                                <?php echo $page_dropdown; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top: 10px;">
                    <button id="submit" class="btn btn-primary"><i
                                class="bx bx-comment"></i> <?php echo $this->lang->line('Live Chat'); ?></button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal"><?php echo $this->lang->line('Back'); ?></button>
                </div>
            </form>
        </div>
    </div>

</div> 

