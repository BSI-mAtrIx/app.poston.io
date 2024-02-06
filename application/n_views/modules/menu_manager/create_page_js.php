<script>
    $(document).ready(function ($) {
        var base_url = '<?php echo base_url(); ?>';

        $('div.note-group-select-from-files').remove();

        $(document).on('click', '#create_page', function (event) {
            event.preventDefault();

            var page_name = $("#page_name").val();
            var page_description = $("#page_description").val();

            if (page_name == '') {
                $("#page_name").addClass('is-invalid');
                return false;
            } else {
                $("#page_name").removeClass('is-invalid');
            }

            if (page_description == '') {
                $("#page_description").addClass('is-invalid');
                return false;
            } else {
                $("#page_description").removeClass('is-invalid');
            }

            $(this).addClass('btn-progress');
            var that = $(this);

            var report_link = base_url + "menu_manager/get_page_lists";

            $.ajax({
                url: base_url + 'menu_manager/create_page_action',
                type: 'POST',
                dataType: 'JSON',
                data: {page_name: page_name, page_description: page_description},
                success: function (response) {
                    $(that).removeClass('btn-progress');
                    if (response.error) {
                        var span = document.createElement("span");
                        span.innerHTML = response.error;
                        swal.fire({title: '<?php echo $this->lang->line("Warning"); ?>', html: span, icon: 'warning'});
                    }

                    if (response.status == "1") {
                        var span = document.createElement("span");
                        span.innerHTML = '<?php echo $this->lang->line("Page has been created successfully.") ?>';
                        swal.fire({
                            title: '<?php echo $this->lang->line("Page Created"); ?>',
                            html: span,
                            icon: 'success'
                        }).then((value) => {
                            window.location.href = report_link;
                        });
                    } else if (response.status == '0') {
                        var span = document.createElement("span");
                        span.innerHTML = '<?php echo $this->lang->line("Something went wrong,please try again.") ?>';
                        swal.fire({
                            title: '<?php echo $this->lang->line("Error"); ?>',
                            html: span,
                            icon: 'error'
                        }).then((value) => {
                            window.location.href = report_link;
                        });
                    }
                }
            })
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