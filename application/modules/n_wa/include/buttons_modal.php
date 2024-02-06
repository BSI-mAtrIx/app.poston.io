<div class="modal fade" id="editor_add_new_button" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo $this->lang->line("Button manager") ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <input type="hidden" id="editor_button_origin">
                    <div class="row">
                        <div class="col-12">
                            <?php echo $this->lang->line('You cant mix Request contact or Request Location buttons with others buttons action. Otherwise only request buttons show.'); ?>
                        </div>
                        <div class="col-sm-12 col-6">
                            <fieldset>
                                <label for="editor_button_name">
                                    <?php echo $this->lang->line('Button name'); ?>
                                </label>
                                <div class="input-group">
                                    <input type="text" id="editor_button_name" name="editor_button_name"  class="form-control" placeholder="<?php echo $this->lang->line('Button name'); ?>">
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-sm-12 col-6">
                            <label for="editor_button_row">
                                <?php echo $this->lang->line('Button row'); ?>
                            </label>
                            <fieldset class="form-group">
                                <select class="form-control" id="editor_button_row" name="editor_button_row">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-sm-12 col-6">
                            <label for="editor_button_action">
                                <?php echo $this->lang->line('Button action'); ?>
                            </label>
                            <fieldset class="form-group">
                                <select class="form-control" id="editor_button_action" name="editor_button_action">
                                    <option value="message"><?php echo $this->lang->line('Message'); ?></option>
                                </select>
                            </fieldset>
                        </div>

                        <div class="col-sm-12 col-6 button_action_div" style="display: none;">
                            <fieldset>
                                <label for="editor_button_val">
                                    <?php echo $this->lang->line('Button value'); ?>
                                </label>
                                <div class="input-group">
                                    <input type="text" id="editor_button_val" name="editor_button_name"  class="form-control" placeholder="<?php echo $this->lang->line('Button value'); ?>">
                                </div>
                            </fieldset>
                        </div>

                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <button id="editor_button_save" type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="bx bxs-save"></i>
                    <span class="align-middle ml-25">
                        <?php echo $this->lang->line("Save and close"); ?>
                    </span>
                </button>
                <button id="editor_button_remove" type="button" class="btn btn-danger" data-dismiss="modal" style="display: none;">
                    <i class="bx bx-trash"></i>
                    <span class="align-middle ml-25">
                        <?php echo $this->lang->line("Remove button"); ?>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $('document').ready(function () {
        $('#editor_button_save').on('click',function (event) {
            var button_name = $('#editor_button_name').val();
            var button_val = $('#editor_button_val').val();
            var button_action = $('#editor_button_action').val();
            var button_row = $('#editor_button_row').val();

            if ($('#editor_button_origin').val() != '') {
                var origin_id = $('#editor_button_origin').val();
            } else {
                var origin_id = Math.floor(Date.now() / 1000);
            }

            //TODO: validation for value if action==url

            var button_data = {
                name: button_name,
                value: button_val,
                action: button_action,
                row: button_row,
                origin_id: origin_id,
            }

            button_data = JSON.stringify(button_data);
            if ($('#origin_' + origin_id).length > 0) {
                $('#origin_' + origin_id).val(button_data);
                $('#button_origin_' + origin_id).html(button_name);
            } else {
                $('#editor_node_buttons').append('<textarea id="origin_' + origin_id + '" class="editor_button_val" style="display:none">' + button_data + '</textarea>');
                $('#editor_node_buttons').append('<button id="button_origin_' + origin_id + '" data-toggle="modal" data-target="#editor_add_new_button" class="btn btn-outline-secondary buttons_edit_button" style="width:100%;" data-button-originid="' + origin_id + '" data-button-action="' + button_action + '">' + button_name + '</button>');
            }

            clear_data();
        });

        $('#editor_button_action').on('change', function (event) {
            var button_val_check = $(this).val();
            if (button_val_check == 'url') {
                $('.button_action_div').show();
            } else {
                $('.button_action_div').hide();
            }
        });

        $(document).on('click', '.buttons_edit_button', function (event) {
            var origin_id = $(this).attr('data-button-originid');
            var json = JSON.parse($('#origin_' + origin_id).val());


            $('#editor_button_name').val(json.name);
            $('#editor_button_val').val(json.value);
            $('#editor_button_action').val(json.action).change();
            $('#editor_button_row').val(json.row).change();

            if (json.action == 'url') {
                $('.button_action_div').show();
            } else {
                $('.button_action_div').hide();
            }

            $('#editor_button_remove').show();
            $('#editor_button_origin').val(json.origin_id);
        });

        $('#editor_button_remove').on('click', function (event) {
            var origin_id = $('#editor_button_origin').val();
            var node_id = $('#editor_id').val();


            $('#origin_' + origin_id).remove();
            $('#button_origin_' + origin_id).remove();

            const node = editor.nodes.find(n => n.id == node_id);

            node.outputs.forEach(output => {

                if (output.key == 'o-' + origin_id) {
                    node.data.buttons.forEach((but, ind) => {
                        if (but.origin_id == origin_id) {
                            node.data.buttons.splice(ind, 1);
                        }
                    });
                    node.removeOutput(output);
                    node.update();
                }
            });

            clear_data();
        });

        $('#editor_add_new_button_new').on('click', function (event) {
            clear_data();
        });

        function clear_data() {
            $('#editor_button_name').val('');
            $('#editor_button_val').val('');
            $('#editor_button_action').val('message').change();
            $('#editor_button_row').val(1).change();
            $('.button_action_div').hide();
            $('#editor_button_origin').val('');
            $('#editor_button_remove').hide();
        }

    });




</script>

<div class="modal fade" id="editor_image_caption_edit" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="min-width: 30%;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <?php echo $this->lang->line("Edit caption") ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="#">
                    <input type="hidden" id="editor_image_caption_edit_id">
                    <div class="row">

                        <div class="col-sm-12 col-6">
                            <fieldset>
                                <label for="editor_image_caption_text">
                                    <?php echo $this->lang->line('Caption text'); ?>
                                </label>
                                <div class="input-group">
                                    <textarea id="editor_image_caption_text" name="editor_image_caption_text"  class="form-control" placeholder="<?php echo $this->lang->line('Caption text'); ?>"></textarea>
                                </div>
                            </fieldset>
                        </div>

                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <button id="editor_image_caption_save" type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="bx bxs-save"></i>
                    <span class="align-middle ml-25">
                        <?php echo $this->lang->line("Save and close"); ?>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).on('click', '.edit_caption_image', function (event) {
        $this = $(this);
        var editor_images = $('#editor_images').val();
        if (editor_images != '') {
            editor_images = JSON.parse(editor_images);

            current_filename = $this.attr('data-filename');
            current_caption = editor_images[current_filename].caption;

            $('#editor_image_caption_text').val(current_caption);
            $('#editor_image_caption_edit_id').val(current_filename);

            $('#editor_image_caption_edit').modal('show')

        }
    });

    $('#editor_image_caption_save').on('click', function (event) {
        $this = $(this);

        var editor_images = $('#editor_images').val();
        if(editor_images!='') {
            editor_images = JSON.parse(editor_images);

            current_filename = $('#editor_image_caption_edit_id').val();
            current_caption = $('#editor_image_caption_text').val();

            editor_images[current_filename].caption = current_caption;

            $('#editor_images').val(JSON.stringify(editor_images));

            parse_editor_images();
        }
    });

    $(document).on('click', '.editor_images_remove_button_action', function (event) {
        $this = $(this);

        var editor_images = $('#editor_images').val();
        if(editor_images!='') {
            editor_images = JSON.parse(editor_images);

            current_filename = $this.attr('data-filename');

            delete editor_images[current_filename];

            $('#editor_images').val(JSON.stringify(editor_images));
            parse_editor_images();
        }
    });

    $(document).on('click', '.editor_audio_remove_button_action', function (event) {
        $this = $(this);
        var filename = $this.attr('data-filename');
        delete_uploaded_file_audio(filename);
    });

    $(document).on('click', '.editor_file_remove_button_action', function (event) {
        $this = $(this);
        var filename = $this.attr('data-filename');
        delete_uploaded_file_file(filename);
    });

</script>