

<script>
    $(window).on("load", function () {
        $('.ig_counter').html('<?php if (empty($ig_counter)) {
            $ig_counter = 0;
        }echo $ig_counter; ?>');
    });
</script>


<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $("document").ready(function () {
        var base_url = "<?php echo base_url(); ?>";

        // instagram section
        $(document).on('click', '.update_account', function () {
            var table_id = $(this).attr('table_id');
            $(this).find('i').removeClass('bx bx-sync');
            $(this).find('i').addClass('bx bx-loader-alt');
            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo site_url();?>instagram_reply/update_your_account_info",
                dataType: 'json',
                data: {table_id: table_id},
                success: function (response) {

                    $(this).find('i').removeClass('bx bx-loader-alt');
                    $(this).find('i').addClass('bx bx-sync');

                    if (response.status == 1) {
                        swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                            $("#media_count_" + table_id).text(response.media_count);
                            $("#follower_count_" + table_id).text(response.follower_count);
                        });
                    } else {
                        swal.fire('<?php echo $this->lang->line("Error"); ?>', response.message, 'error');
                    }
                },
                error: function (response) {
                    $(this).removeClass('bx bx-loader-alt');
                    $(this).addClass('bx bx bx-sync');
                    var span = document.createElement("span");
                    span.innerHTML = response.responseText;
                    swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                }
            });
        });


        // sweet alert + confirmation
        $(document).on('click', '.enable_webhook', function () {
            var restart = $(this).attr('restart');
            if (restart == 1) {
                var confirm_str = "<?php echo $this->lang->line("Do you really want to re-start Bot Connection for this page?"); ?>";
                var confirm_alert = '<?php echo $this->lang->line("Re-start Bot Connection"); ?>';
            } else {
                var confirm_str = "<?php echo $this->lang->line("Do you really want to enable Bot Connection for this page?"); ?>";
                var confirm_alert = '<?php echo $this->lang->line("Enable Bot Connection"); ?>';
            }
            swal.fire({
                title: confirm_alert,
                text: confirm_str,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var page_id = $(this).attr('bot-enable');

                        $(this).removeClass('btn-outline-primary');
                        $(this).addClass('btn-primary');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_accounts/enable_disable_webhook",
                            dataType: 'json',
                            data: {page_id: page_id, enable_disable: 'enable', restart: restart},
                            success: function (response) {
                                $(this).removeClass('btn-progress');
                                $(this).removeClass('btn-primary');
                                $(this).addClass('btn-outline-primary');
                                if (response.status == 1) {
                                    swal.fire('<?php echo $this->lang->line("Success"); ?>', response.message, 'success').then((value) => {
                                        location.reload();
                                    });
                                } else {
                                    var success_message = response.message;
                                    var span = document.createElement("span");
                                    span.innerHTML = success_message;
                                    swal.fire({
                                        title: '<?php echo $this->lang->line("Error"); ?>',
                                        html: span,
                                        icon: 'error'
                                    });
                                }
                            }
                        });
                    }
                });


        });

        $(document).on('click', '.disable_webhook', function () {

            swal.fire({
                title: '<?php echo $this->lang->line("Disable Bot Connection"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to disable Bot Connection for this page?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var page_id = $(this).attr('bot-enable');
                        var restart = $(this).attr('restart');

                        $(this).removeClass('btn-outline-dark');
                        $(this).addClass('btn-dark');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_accounts/enable_disable_webhook",
                            dataType: 'json',
                            data: {page_id: page_id, enable_disable: 'disable', restart: restart},
                            success: function (response) {
                                $(this).removeClass('btn-progress');
                                $(this).removeClass('btn-dark');
                                $(this).addClass('btn-outline-dark');
                                if (response.status == 1) {
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


        $(document).on('click', '.delete_full_bot', function () {
            var confirm_str = "<?php echo $this->lang->line("By proceeding, it will delete all settings of messenger bot, auto reply campaign, posting campaign, subscribers and all campaign reports of this page. This data can not be retrived. It will not delete the page itself from the system."); ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Delete Bot Connection & all settings"); ?>',
                text: confirm_str,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var page_id = $(this).attr('bot-enable');
                        var already_disabled = $(this).attr('already_disabled');

                        $(this).removeClass('btn-outline-danger');
                        $(this).addClass('btn-danger');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_accounts/delete_full_bot",
                            dataType: 'json',
                            data: {page_id: page_id, already_disabled: already_disabled},
                            success: function (response) {
                                $(this).removeClass('btn-progress');
                                $(this).removeClass('btn-danger');
                                $(this).addClass('btn-outline-danger');
                                if (response.status == 1) {
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


        $(document).on('click', '.group_delete', function (e) {
            e.preventDefault();
            var ifyoudeletethisgroup = "<?php echo $ifyoudeletethisgroup; ?>";
            var group_table_id = $(this).attr('table_id');
            swal.fire({
                title: '<?php echo $this->lang->line("Warning!"); ?>',
                text: ifyoudeletethisgroup,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $(this).removeClass('btn-outline-danger');
                        $(this).addClass('btn-danger');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_accounts/group_delete_action",
                            dataType: 'json',
                            data: {group_table_id: group_table_id},
                            success: function (response) {
                                $(this).removeClass('btn-progress');
                                $(this).removeClass('btn-danger');
                                $(this).addClass('btn-outline-danger');
                                if (response.status == 1) {
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


        $(document).on('click', '.page_delete', function () {
            var ifyoudeletethispage = "<?php echo $ifyoudeletethispage; ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure"); ?>',
                text: ifyoudeletethispage,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var page_table_id = $(this).attr('table_id');

                        $(this).removeClass('btn-outline-danger');
                        $(this).addClass('btn-danger');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_accounts/page_delete_action",
                            dataType: 'json',
                            data: {page_table_id: page_table_id},
                            success: function (response) {
                                if (response.status == 1) {
                                    $(this).removeClass('btn-progress');
                                    $(this).removeClass('btn-danger');
                                    $(this).addClass('btn-outline-danger');

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


        $(document).on('click', '.delete_account', function () {
            var ifyoudeletethisaccount = "<?php echo $ifyoudeletethisaccount; ?>";
            swal.fire({
                title: '<?php echo $this->lang->line("Are you sure"); ?>',
                text: ifyoudeletethisaccount,
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var user_table_id = $(this).attr('table_id');
                        $(this).removeClass('btn-outline-danger');
                        $(this).addClass('btn-danger');
                        $(this).addClass('btn-progress');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: "<?php echo site_url();?>social_accounts/account_delete_action",
                            dataType: 'json',
                            data: {user_table_id: user_table_id},
                            success: function (response) {

                                $(this).removeClass('btn-progress');
                                $(this).removeClass('btn-danger');
                                $(this).addClass('btn-outline-danger');

                                if (response.status == 1) {
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


        // $('#delete_confirmation').on('hidden.bs.modal', function () {
        // 	location.reload();
        // });


        $("#submit").click(function () {
            var facebooknumericidfirst = "<?php echo $facebooknumericidfirst; ?>";
            var fb_numeric_id = $("#fb_numeric_id").val().trim();
            if (fb_numeric_id == '') {
                alert(facebooknumericidfirst);
                return false;
            }

            var loading = '<br/><br/><img src="' + base_url + 'assets/pre-loader/Fading squares2.gif" class="center-block"><br/>';
            $("#response").html(loading);

            $.ajax
            ({
                type: 'POST',
                // async:false,
                url: base_url + 'social_accounts/send_user_roll_access',
                data: {fb_numeric_id: fb_numeric_id},
                success: function (response) {
                    $("#response").html(response);
                }

            });
        });


        $(document.body).on('click', '#fb_confirm', function () {
            var loading = '<br/><br/><img src="' + base_url + 'assets/pre-loader/Fading squares2.gif" class="center-block"><br/>';
            $("#response").html(loading);
            $.ajax
            ({
                type: 'POST',
                // async:false,
                url: base_url + 'social_accounts/ajax_get_login_button',
                data: {},
                success: function (response) {
                    $("#response").html(response);
                }

            });
        });


    });
</script>

<?php
if ($this->config->item('facebook_poster_group_enable_disable') == '1' && $this->is_group_posting_exist)
    $permissions = "email,pages_manage_posts,pages_manage_engagement,pages_manage_metadata,pages_read_engagement,pages_show_list,pages_messaging,public_profile,publish_to_groups,read_insights";
else
    $permissions = "email,pages_manage_posts,pages_manage_engagement,pages_manage_metadata,pages_read_engagement,pages_show_list,pages_messaging,public_profile,read_insights";
?>
