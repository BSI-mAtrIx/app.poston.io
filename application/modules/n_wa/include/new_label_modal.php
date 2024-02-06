<div class="modal fade" id="add_label" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo $this->lang->line("Add New Label") ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body" id="add_label_modal_body">

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>
                                <?php echo $this->lang->line('Label Name'); ?>
                            </label>
                            <input type="text" name="label_name" id="label_name" class="form-control">
                            <span id="name_err" class="text-danger"></span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button id="create_label" type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="bx bxs-save"></i>
                    <span class="align-middle ml-25">
                        <?php echo $this->lang->line("Create and close"); ?>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#create_label').on('click', function (event) {
            event.preventDefault();

            label_name = $("#label_name").val();
            $(this).addClass('btn-progress');
            var that = $(this);



            $.ajax({
                url: '<?php echo base_url('n_wa/api/ajax_label_insert'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {label_name: label_name, csrf_token: csrf_token, bot_id: bot_id},
                success: function (response) {


                    if (response.status == "0") {
                        var errorMessage = JSON.stringify(response, null, 10);
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', errorMessage, "error");
                    } else if (response.status == '1') {
                        iziToast.success({title: '', message: response.message, position: 'bottomRight'});


                        $('#editor_label_add').select2({
                            data: response.labels_data,
                            allowClear: true
                        });
                        $('#editor_label_remove').select2({
                            data: response.labels_data
                        });
                    }

                }
            });

        });
    });
</script>