<script>
    var base_url = "<?php echo site_url(); ?>";
    $(document).ready(function () {

        $('#ticket_reply_text').summernote({
            height: 300,
            minHeight: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['codeview']]
            ]
        });

        $(document.body).on('click', '.ticket_action', function (e) {
            e.preventDefault();
            var id = $(this).attr("table_id");
            var action = $(this).attr("data-type");

            $(this).addClass('btn-progress');
            $.ajax({
                context: this,
                url: base_url + "simplesupport/ticket_action",
                type: 'POST',
                dataType: 'JSON',
                data: {id: id, action: action},
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == "1") iziToast.success({
                        title: '<?php echo $this->lang->line("Success"); ?>',
                        message: response.message,
                        position: 'bottomRight'
                    });
                    else iziToast.error({
                        title: '<?php echo $this->lang->line("Error"); ?>',
                        message: response.message,
                        position: 'bottomRight'
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            });
        });

        $(document.body).submit(function () {
            $(".reply").attr("disabled", true);
            return true;
        });

    });
</script>