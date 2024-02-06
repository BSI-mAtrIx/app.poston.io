<script>
    $("document").ready(function () {

        var base_url = "<?php echo base_url(); ?>";
        var csrf_token = "<?php echo $this->session->userdata('csrf_token_session'); ?>";
        var url_bot = 'n_wa/api/'

        $(document).on('click', '#fetch_credit_line_button', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                data: {csrf_token:csrf_token},
                url: base_url + url_bot + 'get_credit_line',
                success: function (data) {

                    if(data.status!=undefined && data.status==0){
                        if(data.message.alert_message==undefined){
                            swal.fire({
                                icon: 'error',
                                text: data.message,
                                title: '<?php echo $this->lang->line('error'); ?>',
                            });
                        }else{
                            swal.fire({
                                icon: 'error',
                                text: data.message.alert_message,
                                title: data.message.alert_type,
                            });
                        }

                    }

                    if(data.status!=undefined && data.status=='ok'){
                        var options = '';
                        $(data.message.data).each(function( index, element ) {
                            options += '<option value="'+element.id+'">'+element.text+'</option>'
                        });
                        $('#api_wa_credit_id').append(options);
                        swal.fire({
                            icon: 'success',
                            text: '<?php echo $this->lang->line('Credit lines loaded'); ?>',
                            title: '<?php echo $this->lang->line('success'); ?>'
                        });
                    }

                }
            });
        });


    });
</script>