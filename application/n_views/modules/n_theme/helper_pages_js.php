<script>
    $(document).on('click', '.hp_delete', function (e) {
        e.preventDefault();
        var mes = '<?php echo $this->lang->line("Do you really want to remove helper page?");?>';
        var page_id = $(this).attr('data-file_lang');
        swal.fire({
            title: "<?php echo $this->lang->line("Are you sure?");?>",
            text: mes,
            icon: "warning",
            confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
            cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
            showCancelButton: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                $(this).addClass('btn-progress');
                $.ajax({
                    context: this,
                    url: base_url + "n_theme/helper_page_remove",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        'page_id': page_id,
                        'csrf_token': '<?php echo $this->session->userdata('csrf_token_session'); ?>'
                    },
                    success: function (response) {
                        $(this).removeClass('btn-progress');
                        if (response.status == "1") {
                            location.reload();
                        } else iziToast.error({
                            title: '<?php echo $this->lang->line("Error"); ?>',
                            message: response.message,
                            position: 'bottomRight'
                        });
                    }
                });
            }
        });

    });
</script>