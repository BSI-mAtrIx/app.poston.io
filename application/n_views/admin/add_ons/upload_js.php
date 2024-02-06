<script>
    var base_url = "<?php echo base_url(); ?>";
    $("document").ready(function () {

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });

        $("#addon_url_upload").uploadFile({
            url: base_url + "addons/upload_addon_zip",
            fileName: "myfile",
            maxFileSize: 100 * 1024 * 1024,
            uploadButtonClass: 'btn btn-sm btn-primary mr-10',
            showPreview: false,
            returnType: "json",
            dragDrop: true,
            showDelete: true,
            multiple: false,
            maxFileCount: 1,
            showDelete: false,
            acceptFiles: ".zip",
            deleteCallback: function (data, pd) {
                var delete_url = "<?php echo site_url('addons/delete_uploaded_zip');?>";
                $.post(delete_url, {op: "delete", name: data},
                    function (resp, textStatus, jqXHR) {
                    });

            },
            onSuccess: function (files, data, xhr, pd) {
                var data_modified = data;
                window.location.assign(base_url + 'addons/lists');
            }
        });
    });
</script>

