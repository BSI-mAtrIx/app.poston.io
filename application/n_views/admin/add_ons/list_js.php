<script>
    var base_url = "<?php echo base_url(); ?>";
    var is_demo = "<?php echo $is_demo; ?>";
    $("document").ready(function () {

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });

        $(".activate_action").click(function (e) {
            e.preventDefault();
            var action = $(this).attr('data-href');
            var datai = $(this).attr('data-i');
            $("#href-action").val(action);
            $(".put_add_on_title").html($("#get_add_on_title_" + datai).html());
            $("#activate_action_modal_refesh").val('0');
            $("#activate_action_modal").modal();
        });

        $('#activate_action_modal').on('hidden.bs.modal', function () {
            if ($("#activate_action_modal_refesh").val() == "1")
                location.reload();
        })

        $("#activate_submit").click(function () {
            if (is_demo == '1') {
                alertify.alert('<?php echo $this->lang->line("Alert");?>', 'Permission denied', function () {
                });
                return false;
            }
            var action = base_url + $("#href-action").val();
            var purchase_code = $("#purchase_code").val();

            $("#activate_submit").addClass('disabled');
            $("#activate_action_modal_msg").removeClass('alert').removeClass('alert-success').removeClass('alert-danger');
            var loading = '<img src="' + base_url + 'assets/pre-loader/color/Preloader_9.gif" class="center-block" height="30" width="30">';
            $("#activate_action_modal_msg").html(loading);

            $.ajax({
                type: 'POST',
                url: action,
                data: {purchase_code: purchase_code},
                dataType: 'JSON',
                success: function (response) {
                    $("#activate_action_modal_msg").html('');

                    if (response.status == '1') {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                            .then((value) => {
                                location.reload();
                            });
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                }
            });
        });

        $(".deactivate_action").click(function (e) {
            e.preventDefault();
            if (is_demo == '1') {
                alertify.alert('<?php echo $this->lang->line("Alert");?>', 'Permission denied', function () {
                });
                return false;
            }
            var action = base_url + $(this).attr('data-href');

            swal.fire({
                title: '<?php echo $this->lang->line("Deactive Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to deactive this add-on? Your add-on data will still remain."); ?>',
                icon: 'error',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
                                            location.reload();
                                        });
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });


        $(".delete_action").click(function (e) {
            e.preventDefault();
            if (is_demo == '1') {
                alertify.alert('<?php echo $this->lang->line("Alert");?>', 'Permission denied', function () {
                });
                return false;
            }
            var action = base_url + $(this).attr('data-href');

            swal.fire({
                title: '<?php echo $this->lang->line("Delete Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this add-on? This process can not be undone."); ?>',
                icon: 'error',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success')
                                        .then((value) => {
                                            location.reload();
                                        });
                                } else {
                                    swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                                }
                            }
                        });
                    }
                });
        });


    });
</script>