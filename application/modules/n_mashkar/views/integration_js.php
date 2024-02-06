<script>

    $("document").ready(function () {

        $(document).on('click', '#test_mashkor', function (e) {
            e.preventDefault();

            $('#nodata').block({
                message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 1,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });

            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {
                    csrf_token: "<?php echo $this->session->userdata('csrf_token_session'); ?>"
                },
                url: '<?php echo base_url('n_mashkar/test_mashkor'); ?>',
                success: function (response) {
                    if (response.status == '0'){
                        swal.fire("<?php echo $this->lang->line('Error'); ?>", response.message, 'error');
                    }else{
                        swal.fire("<?php echo $this->lang->line('Success'); ?>", response.message, 'success');
                    }
                    $('#nodata').unblock();
                }
            });
        });

    });
</script>