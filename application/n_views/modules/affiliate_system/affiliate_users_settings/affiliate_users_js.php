<script>
    var base_url = "<?php echo site_url(); ?>";

    $(document).ready(function () {

        $('div.note-group-select-from-files').remove();

        var affiliate_users_perscroll;
        var affiliate_users_table = $("#mytable_affiliate_users").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax: {
                "url": base_url + 'affiliate_system/affiliate_users_data',
                "type": 'POST'
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1],
                    visible: false
                },
                {
                    targets: '',
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 2, 3, 4, 8, 9],
                    sortable: false
                },
                {
                    targets: [9],
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
                        data = data.replaceAll('208px', '300px');

                        return data;
                    }
                },
            ],
            fnInitComplete: function () {  // when initialization is completed then apply scroll plugin
                if (areWeUsingScroll) {
                    if (affiliate_users_perscroll) affiliate_users_perscroll.destroy();
                    affiliate_users_perscroll = new PerfectScrollbar('#mytable_affiliate_users_wrapper .dataTables_scrollBody');
                }
            },
            scrollX: 'auto',
            fnDrawCallback: function (oSettings) { //on paginition page 2,3.. often scroll shown, so reset it and assign it again
                if (areWeUsingScroll) {
                    if (affiliate_users_perscroll) affiliate_users_perscroll.destroy();
                    affiliate_users_perscroll = new PerfectScrollbar('#mytable_affiliate_users_wrapper .dataTables_scrollBody');
                }
            },
            "drawCallback": function (settings) {
                $('table [data-toggle="tooltip"]').tooltip('dispose');
                $('table [data-toggle="tooltip"]').tooltip(
                    {
                        placement: 'left',
                        container: 'body',
                        html: true,
                        template: '<div class="tooltip tooltip_pd" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    }
                );
            }
        });

        $(document).on('click', '.delete_affiliate', function (e) {
            e.preventDefault();
            var link = $(this).attr("href");
            var refresh = $(this).attr("data-refresh");
            var csrf_token = $(this).attr('csrf_token');

            if (typeof (csrf_token) === 'undefined') csrf_token = '';

            var mes = '<?php echo $this->lang->line("Do you really want to delete it?");?>';
            swal.fire({
                title: "<?php echo $this->lang->line("Are you sure?");?>",
                text: mes,
                icon: "warning",
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        $(this).addClass('btn-progress btn-danger').removeClass('btn-outline-danger');
                        $.ajax({
                            context: this,
                            url: link,
                            type: 'POST',
                            dataType: 'JSON',
                            data: {csrf_token: csrf_token},
                            success: function (response) {
                                $(this).removeClass('btn-progress btn-danger').addClass('btn-outline-danger');
                                if (response.status == 1) {
                                    iziToast.success({title: '', message: response.message, position: 'bottomRight'});
                                    if (refresh != '0') {
                                        if ($(this).hasClass('non_ajax')) $(this).parent().parent().hide();
                                        else $('#mytable_affiliate_users').DataTable().ajax.reload();
                                    }
                                } else iziToast.error({title: '', message: response.message, position: 'bottomRight'});
                            }
                        });
                    }
                });
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
                url: base_url + 'affiliate_system/change_affiliate_password_action',
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

    });


</script>