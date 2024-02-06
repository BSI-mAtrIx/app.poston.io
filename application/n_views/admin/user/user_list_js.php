<script>
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {

        $('div.note-group-select-from-files').remove();

        var drop_menu = '<?php echo $drop_menu;?>';
        setTimeout(function () {
            $("#mytable_filter").append(drop_menu);
        }, 2000);

        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[2, "desc"]],
            pageLength: 10,
            ajax: {
                "url": base_url + 'admin/user_manager_data',
                "type": 'POST'
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [2, 9],
                    visible: false
                },
                {
                    targets: [0, 1, 3, 8, 10, 11, 12, 14],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 3, 11],
                    sortable: false
                },
                {
                    targets: [8, 11],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-code', 'bx bx-code');
                        data = data.replaceAll('fas fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa fa-edit', 'bx bx-edit');
                        data = data.replaceAll('fa  fa-edit', 'bx bx-edit');
                        data = data.replaceAll('far fa-copy', 'bx bx-copy');
                        data = data.replaceAll('fa fa-trash', 'bx bx-trash');
                        data = data.replaceAll('fas fa-trash', 'bx bx-trash');
                        data = data.replaceAll('fa fa-eye', 'bx bxs-show');
                        data = data.replaceAll('fas fa-eye', 'bx bxs-show');
                        data = data.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                        data = data.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                        data = data.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                        data = data.replaceAll('fab fa-wpforms', 'bx bx-news');
                        data = data.replaceAll('fas fa-file-export', 'bx bx-export');
                        data = data.replaceAll('fa fa-comment', 'bx bx-comment');
                        data = data.replaceAll('fa fa-user', 'bx bx-user');
                        data = data.replaceAll('fa fa-refresh', 'bx bx-refresh');
                        data = data.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                        data = data.replaceAll('fas fa-comments', 'bx bx-comment');
                        data = data.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                        data = data.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                        data = data.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                        data = data.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                        data = data.replaceAll('fas fa-key', 'bx bx-key');
                        data = data.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                        data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                        data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                        data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                        data = data.replaceAll('fa fa-send', 'bx bx-send');
                        data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                        data = data.replaceAll('fa fa-code', 'bx bx-code');
                        data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                        data = data.replaceAll('fas fa-pause', 'bx bx-pause');
                        data = data.replaceAll('fas fa-play', 'bx bx-play');
                        data = data.replaceAll('fa fa-cog', 'bx bx-cog');
                        data = data.replaceAll('fa fa-check-circle', 'bx bx-check-circle');
                        data = data.replaceAll('fas fa-comment', 'bx bx-comment');
                        data = data.replaceAll('swal(', 'swal.fire(');
                        data = data.replaceAll('rounded-circle', 'rounded-circle');
                        data = data.replaceAll('fas fa-check-circle', 'bx bx-check-circle');
                        data = data.replaceAll('fas fa-plug', 'bx bx-plug');
                        data = data.replaceAll('fas fa-times-circle', 'bx bx-time');
                        data = data.replaceAll('fas fa-chart-bar', 'bx bx-chart');
                        data = data.replaceAll('fas fa-cloud-download-alt', 'bx bxs-cloud-download');
                        data = data.replaceAll('padding-10', 'p-10');
                        data = data.replaceAll('padding-left-10', 'pl-10');
                        data = data.replaceAll('h4', 'h5 class="card-title font-medium-1"');
                        data = data.replaceAll('fas fa-heart', 'bx bx-heart');
                        data = data.replaceAll('fas fa-road', 'bx bx-location-plus');
                        data = data.replaceAll('fas fa-city', 'bx bxs-city');
                        data = data.replaceAll('fas fa-globe-americas', 'bx bx-globe');
                        data = data.replaceAll('fas fa-at', 'bx bx-at');
                        data = data.replaceAll('fas fa-mobile-alt', 'bx bx-mobile-alt');
                        data = data.replaceAll('<div class="dropdown-title"><?php echo $this->lang->line('Options'); ?></div>', '<h6 class="dropdown-header"><?php echo $this->lang->line('Options'); ?></h6>');
                        data = data.replaceAll('fas fa-file-signature', 'bx bxs-user-badge');
                        data = data.replaceAll('fas fa-user-circle', 'bx bxs-user');
                        data = data.replaceAll('fas fa-toggle-on', 'bx bx-toggle-right');
                        data = data.replaceAll('fas fa-toggle-off', 'bx bx-toggle-left');


                        return data;
                    }
                },
            ],
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (perscroll) perscroll.destroy();
                    perscroll = new PerfectScrollbar('#mytable_wrapper .dataTables_scrollBody');
                }
            }
        });

        $(document).on('click', '.change_password', function (e) {
            e.preventDefault();

            var user_id = $(this).attr('data-id');
            var user_name = $(this).attr('data-user');

            $("#putname").html(user_name);
            $("#putid").val(user_id);

            $("#change_password").modal();
        });

        var confirm_match = 0;
        $(".password").keyup(function () {

            var new_pass = $("#password").val();
            var conf_pass = $("#confirm_password").val();

            if (new_pass == '' || conf_pass == '') {
                return false;
            }

            if (new_pass == conf_pass) {
                confirm_match = 1;
                $("#password").removeClass('is-invalid');
                $("#confirm_password").removeClass('is-invalid');
            } else {
                confirm_match = 0;
                $("#confirm_password").addClass('is-invalid');
            }

        });

        $(document).on('click', '#save_change_password_button', function (e) {
            e.preventDefault();

            var user_id = $("#putid").val();
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();
            var csrf_token = $("#csrf_token").val();

            password = password.trim();
            confirm_password = confirm_password.trim();

            if (password == '' || confirm_password == '') {
                $("#password").addClass('is-invalid');
                return false;
            } else {
                $("#password").removeClass('is-invalid');
            }

            if (confirm_match == '1') {
                $("#confirm_password").removeClass('is-invalid');
            } else {
                $("#confirm_password").addClass('is-invalid');
                return false;
            }

            $("#save_change_password_button").addClass("btn-progress");

            $.ajax({
                url: base_url + 'admin/change_user_password_action',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    user_id: user_id,
                    password: password,
                    confirm_password: confirm_password,
                    csrf_token: csrf_token
                },
                success: function (response) {
                    $("#save_change_password_button").removeClass("btn-progress");

                    if (response.status == "1")
                        swal.fire('<?php echo $this->lang->line("Success")?>', response.message, 'success')
                            .then((value) => {
                                $("#change_password").modal('hide');
                            });

                    else swal.fire('<?php echo $this->lang->line("Error")?>', response.message, 'error');
                },
                error: function (response) {
                    var span = document.createElement("span");
                    span.innerHTML = response.responseText;
                    swal.fire({title: '<?php echo $this->lang->line("Error!"); ?>', html: span, icon: 'error'});
                }
            });

        });


        $(document).on('click', '.send_email_ui', function (e) {
            var user_ids = [];
            $(".datatableCheckboxRow:checked").each(function () {
                user_ids.push(parseInt($(this).val()));
            });

            if (user_ids.length == 0) {
                swal.fire('<?php echo $this->lang->line("Warning")?>', '<?php echo $this->lang->line("You have to select users to send email.") ?>', 'warning');
                return false;
            } else $("#modal_send_sms_email").modal();
        });

        $(document).on('click', '#send_sms_email', function (e) {

            var subject = $("#subject").val();
            var message = $("#message").val();
            var csrf_token = $("#csrf_token").val();

            var user_ids = [];
            $(".datatableCheckboxRow:checked").each(function () {
                user_ids.push(parseInt($(this).val()));
            });

            if (user_ids.length == 0) {
                swal.fire('<?php echo $this->lang->line("Warning")?>', '<?php echo $this->lang->line("You have to select users to send email.") ?>', 'warning');
                return false;
            }

            if (subject == '') {
                $("#subject").addClass('is-invalid');
                return false;
            } else {
                $("#subject").removeClass('is-invalid');
            }

            if (message == '') {
                $("#message").addClass('is-invalid');
                return false;
            } else {
                $("#message").removeClass('is-invalid');
            }

            $(this).addClass('btn-progress');
            $("#show_message").html('');
            $.ajax({
                context: this,
                type: 'POST',
                url: "<?php echo site_url(); ?>admin/send_email_member",
                data: {message: message, user_ids: user_ids, subject: subject, csrf_token: csrf_token},
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    $("#show_message").addClass("alert alert-primary");
                    $("#show_message").html(response);
                }
            });

        });
    });


</script>