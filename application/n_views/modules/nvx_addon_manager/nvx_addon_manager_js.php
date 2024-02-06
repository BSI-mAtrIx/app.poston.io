<script>

    var base_url = "<?php echo base_url(); ?>";
    var is_demo = 0;
    $("document").ready(function () {

        $('[data-toggle="popover"]').popover();
        $('[data-toggle="popover"]').on('click', function (e) {
            e.preventDefault();
            return true;
        });


        $(".code_action").click(function (e) {
            e.preventDefault();
            var action = $(this).attr('data-href');
            var datai = $(this).attr('data-i');
            var base = $(this).attr('data-base');
            var key = $(this).attr('data-key');
            $("#href-action").val(action);
            $("#xid-action").val(datai);
            $("#base-action").val(base);
            $("#key-action").val(key);
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
            var action = base_url + 'nvx_addon_manager/purchase_code';
            var purchase_code = $("#purchase_code").val();
            var xid = $("#xid-action").val();
            var base = $("#base-action").val();
            var key = $("#key-action").val();

            $("#activate_submit").addClass('disabled');
            $("#activate_action_modal_msg").removeClass('alert').removeClass('alert-success').removeClass('alert-danger');
            var loading = '<img src="' + base_url + 'assets/pre-loader/color/Preloader_9.gif" class="center-block" height="30" width="30">';
            $("#activate_action_modal_msg").html(loading);

            $.ajax({
                type: 'POST',
                url: action,
                data: {purchase_code: purchase_code, xid: xid, base: base, key: key},
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

            var action = base_url + $(this).attr('data-href');
            var xid = $(this).attr('data-i');
            var base = $(this).attr('data-base');
            var key = $(this).attr('data-key');
            var dir = $(this).attr('data-dir');

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
                            data: {xid: xid, base: base, key: key, dir: dir},
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


        $(".activate_action").click(function (e) {
            e.preventDefault();
            var action = base_url + $(this).attr('data-href');

            swal.fire({
                title: '<?php echo $this->lang->line("Activate Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to activate this add-on?"); ?>',
                icon: 'success',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: action,
                            dataType: 'JSON',
                            success: function (response) {
                                if (response.status == '1') {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
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

        $(".activate_ntheme_action").click(function (e) {
            e.preventDefault();
            var action = base_url + 'nvx_addon_manager/n_theme_activate';

            swal.fire({
                title: $(this).attr('data-title'),
                text: $(this).attr('data-text'),
                icon: 'success',
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


        $(".update_action").click(function (e) {
            e.preventDefault();

            var action = base_url + 'nvx_addon_manager/update_script';
            var xid = $(this).attr('data-i');
            var dir = $(this).attr('data-dir');

            swal.fire({
                title: '<?php echo $this->lang->line("Update Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you want to update this add-on?"); ?>',
                icon: 'success',
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
                            data: {xid: xid, dir: dir},
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

        $("#iu_update_submit").click(function (e) {
            e.preventDefault();

            var action = base_url + 'nvx_addon_manager/install_update_nviews';
            var xid = $(this).attr('data-i');
            var dir = $(this).attr('data-dir');

            swal.fire({
                title: '<?php echo $this->lang->line("Update Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you want to update this add-on?"); ?>',
                icon: 'success',
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
                            data: {xid: xid, dir: dir},
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

        $(".update_nm_action").click(function (e) {
            e.preventDefault();

            var action = base_url + 'nvx_addon_manager/update_script_manager';
            var xid = $(this).attr('data-i');
            var dir = $(this).attr('data-dir');

            swal.fire({
                title: '<?php echo $this->lang->line("Update Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you want to update this add-on?"); ?>',
                icon: 'success',
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
                            data: {xid: xid, dir: dir},
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

        $(".download_action").click(function (e) {
            e.preventDefault();

            var action = base_url + 'nvx_addon_manager/download_script';
            var xid = $(this).attr('data-i');
            var dir = $(this).attr('data-dir');

            swal.fire({
                title: '<?php echo $this->lang->line("Download Add-on?"); ?>',
                text: '<?php echo $this->lang->line("Do you want to download this add-on?"); ?>',
                icon: 'success',
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
                            data: {xid: xid, dir: dir},
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