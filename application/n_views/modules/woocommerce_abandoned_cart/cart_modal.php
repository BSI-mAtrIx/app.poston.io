<script>
    $(document).ready(function ($) {
        $(document).on('click', '.webhook_data', function (event) {
            event.preventDefault();
            var base_url = '<?php echo site_url();?>';
            var webhook_id = $(this).attr('data-id');
            $("#webhook_data .modal-body").html('<div class="text-center waiting"><i class="bx bx-loader-alt bx-spin blue text-center" style="font-size: 50px"></i></div><br/>');
            $("#webhook_data").modal();

            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo site_url();?>woocommerce_abandoned_cart/webhook_data",
                data: {webhook_id: webhook_id},
                success: function (response) {
                    $("#webhook_data .modal-body").html(response);
                }
            });
        });
    });
</script>

<div class="modal fade" id="webhook_data" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx-task"></i> <?php echo $this->lang->line("Activity"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-time"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>