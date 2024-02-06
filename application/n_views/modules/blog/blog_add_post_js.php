<script type="text/javascript">
    $(function () {
        $(".inputtags").tagsinput('items');
    });
    var base_url = "<?php echo site_url(); ?>";

    $(document.body).on('submit', 'form[name="post-store"]', function (e) {
        e.preventDefault();

        $("#save_post").addClass("btn-progress");
        $('.form-control').removeClass('is-invalid');
        var action = $(this).attr('action');
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: action,
            data: formData,
            dataType: 'JSON',
            success: function (response) {
                $("#save_post").removeClass("btn-progress");

                if (response.status == '0') {
                    $.each(response.errors, function (key, value) {
                        $('.' + key.replace('[]', '') + '_error').html(value);
                    });
                }

                if (response.status == "1") {
                    swal.fire('<?php echo $this->lang->line("Success")?>', response.message, 'success')
                        .then((value) => {
                            window.location.replace(base_url + "blog/posts");
                        });
                }

                if (response.status == "2") {
                    swal.fire('<?php echo $this->lang->line("Error")?>', response.message, 'error');
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        Dropzone.autoDiscover = false;
        $("#dropzone").dropzone({
            url: "<?php echo site_url();?>blog/upload_post_thumbnail",
            maxFilesize: 1,
            uploadMultiple: false,
            paramName: "file",
            createImageThumbnails: true,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            maxFiles: 1,
            addRemoveLinks: true,
            success: function (file, response) {
                $("#thumbnail").val(eval(response));
            },
            removedfile: function (file) {
                var name = $("#thumbnail").val();
                if (name != "") {
                    $(".dz-preview").remove();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url();?>blog/delete_post_thumbnail',
                        data: {op: "delete", name: name},
                        success: function (data) {
                            $("#thumbnail").val('');
                        }
                    });
                } else {
                    $(".dz-preview").remove();
                }
            },
        });

        $('textarea').each(function () {
            <?php if($jodit_cg){
            echo "editor = Jodit.make(this, {
                                    disablePlugins: [
                                        'about'
                                    ],
                                    buttons: [
                                        ...Jodit.defaultOptions.buttons,
                                    ],
                                    extraButtons: ext_butt
                });";
        }else{
            echo 'var editor = new Jodit(this);';
        } ?>
        });
    });
</script>