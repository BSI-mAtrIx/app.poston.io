<script type="text/javascript">
    var base_url = "<?php echo base_url();?>";

    $("document").ready(function () {
        var perscroll;
        var table1 = '';
        table1 = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: false,
            order: [[8, "desc"]],
            pageLength: 10,
            ajax: {
                url: base_url + 'ecommerce/customer_list_data',
                type: 'POST',
                data: function (d) {
                    // d.page_id = $('#page_id').val();
                    d.search_value = $('#search_value').val();
                }
            },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [0, 2, 3, 7, 8],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 2, 7],
                    sortable: false
                },
                {
                    targets: [5, 6, 7, 8],
                    "render": function (data, type, row) {
                        data = data.replaceAll('fas fa-user-slash', 'bx bxs-user-x');
                        data = data.replaceAll('fas fa-comment-slash', 'bx bx-comment-x');
                        data = data.replaceAll('fas fa-map', 'bx bx-map');
                        data = data.replaceAll('fas fa-birthday-cake', 'bx bx-cake');
                        data = data.replaceAll('fas fa-headset', 'bx bx-headphone');
                        data = data.replaceAll('fas fa-phone', 'bx bx-phone');
                        data = data.replaceAll('fas fa-robot', 'bx bx-bot');
                        data = data.replaceAll('fas fa-envelope', 'bx bx-envelope');
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
                        data = data.replaceAll('fas fa-briefcase', 'bx bx-briefcase');
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
                        data = data.replaceAll('fas fa-male', 'bx bx-male')
                        data = data.replaceAll('fas fa-female', 'bx bx-female')
                        data = data.replaceAll('fas fa-clone', 'bx bxs-copy-alt');
                        data = data.replaceAll('fas fa-receipt', 'bx bx-receipt');
                        data = data.replaceAll('fa fa-paper-plane', 'bx bx-paper-plane');
                        data = data.replaceAll('fa fa-send', 'bx bx-send');
                        data = data.replaceAll('fas fa-hand-point-right', 'bx bx-news');
                        data = data.replaceAll('fa fa-code', 'bx bx-code');
                        data = data.replaceAll('fa fa-clone', 'bx bx-duplicate');
                        data = data.replaceAll('fas fa-pause', 'bx bx-pause');
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
                        data = data.replaceAll('fas fa-info-circle', 'bx bx-info-circle');
                        data = data.replaceAll('fa fa-image', 'bx bx-image');
                        data = data.replaceAll('208px', '308px');
                        data = data.replaceAll("data-toggle='tooltip'", " data-html='true' data-toggle='tooltip'");
                        data = data.replaceAll('fa fa-info-circle', 'bx bx-info-circle');
                        data = data.replaceAll('fas fa-id-card', 'bx bxs-id-card');
                        data = data.replaceAll('fas fa-mars', 'bx bx-male-sign');
                        data = data.replaceAll('fas fa-language', 'bx bx-flag');
                        data = data.replaceAll('fas fa-globe', 'bx bx-globe');
                        data = data.replaceAll('far fa-clock', 'bx bx-time');
                        data = data.replaceAll('fas fa-cart-plus', 'bx bxs-cart-add');


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

        $(document).on('click', '#search_subscriber', function (e) {
            e.preventDefault();
            table1.draw(false);
        });

        $(document).on('click', '.change_password', function (e) {
            e.preventDefault();
            var email = $(this).attr('data-email');
            var id = $(this).attr('data-id');
            $("#user_email").val(email);
            $("#user_id").val(id);
            $("#password").val("");
            $("#confirm_password").val("");
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

            var id = $("#user_id").val();
            var email = $("#user_email").val();
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();

            password = password.trim();
            confirm_password = confirm_password.trim();

            if (email == '') {
                $("#user_email").addClass('is-invalid');
                return false;
            } else $("#user_email").removeClass('is-invalid');

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
                url: base_url + 'ecommerce/change_user_password_action',
                type: 'POST',
                dataType: 'JSON',
                data: {id, password, confirm_password, email},
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

        $('#change_password').on("hidden.bs.modal", function (e) {
            table1.draw(false);
        });
    });

</script>