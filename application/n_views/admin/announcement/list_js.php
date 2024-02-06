<script>
    var base_url = "<?php echo site_url(); ?>";
    var counter = 0;
    $(document).ready(function () {

        setTimeout(function () {
            var start = $("#load_more").attr("data-start");
            load_data(start, false, false);
        }, 1000);


        $(document).on('click', '#load_more', function (e) {
            var start = $("#load_more").attr("data-start");
            load_data(start, false, true);
        });

        $(document).on('change', '#seen_type', function (e) {
            var start = '0';
            load_data(start, true, false);
        });


        $(document).on('click', '#search_submit', function (e) {
            var start = '0';
            load_data(start, true, false);
        });

        function load_data(start, reset, popmessage) {
            var limit = $("#load_more").attr("data-limit");
            var search = $("#search").val();
            var seen_type = $("#seen_type").val();
            $("#waiting").show();
            if (reset) {
                $("#search_submit").addClass("btn-progress");
                counter = 0;
            }
            $.ajax({
                url: base_url + 'announcement/list_data',
                type: 'POST',
                dataType: 'JSON',
                data: {start: start, limit: limit, search: search, seen_type: seen_type},
                success: function (response) {
                    $("#waiting").hide();
                    $("#nodata").hide();
                    $("#search_submit").removeClass("btn-progress");

                    counter += response.found;
                    $("#load_more").attr("data-start", counter);
                    response.html = response.html.replaceAll('fas fa-code', 'bx bx-code');
                    response.html = response.html.replaceAll('fas fa-edit', 'bx bx-edit');
                    response.html = response.html.replaceAll('fa fa-edit', 'bx bx-edit');
                    response.html = response.html.replaceAll('far fa-copy', 'bx bx-copy');
                    response.html = response.html.replaceAll('fa fa-trash', 'bx bx-trash');
                    response.html = response.html.replaceAll('fas fa-trash', 'bx bx-trash');
                    response.html = response.html.replaceAll('fa fa-eye', 'bx bxs-show');
                    response.html = response.html.replaceAll('fas fa-eye', 'bx bxs-show');
                    response.html = response.html.replaceAll('fas fa-trash-alt', 'bx bx-trash');
                    response.html = response.html.replaceAll('fa fa-wordpress', 'bx bxl-wordpress');
                    response.html = response.html.replaceAll('fa fa-briefcase', 'bx bx-briefcase');
                    response.html = response.html.replaceAll('fab fa-wpforms', 'bx bx-news');
                    response.html = response.html.replaceAll('fas fa-file-export', 'bx bx-export');
                    response.html = response.html.replaceAll('fa fa-comment', 'bx bx-comment');
                    response.html = response.html.replaceAll('fa fa-user', 'bx bx-user');
                    response.html = response.html.replaceAll('fa fa-refresh', 'bx bx-refresh');
                    response.html = response.html.replaceAll('fa fa-plus-circle', 'bx bx-plus-circle');
                    response.html = response.html.replaceAll('fas fa-comments', 'bx bx-comment');
                    response.html = response.html.replaceAll('fa fa-hand-o-right', 'bx bx-link-external');
                    response.html = response.html.replaceAll('fab fa-facebook-square', 'bx bxl-facebook-square');
                    response.html = response.html.replaceAll('fas fa-exchange-alt', 'bx bx-repost');
                    response.html = response.html.replaceAll('fa fa-sync-alt', 'bx bx-sync');
                    response.html = response.html.replaceAll('fas fa-key', 'bx bx-key');
                    response.html = response.html.replaceAll('fas fa-bolt', 'bx bxs-bolt');
                    response.html = response.html.replaceAll('fas fa-ellipsis-h', 'bx bx-dots-horizontal-rounded');


                    if (!reset) $("#load_data").append(response.html);
                    else $("#load_data").html(response.html);

                    if (response.found != '0') $("#load_more").show();
                    else {
                        $("#load_more").hide();
                        if (popmessage) {
                            swal.fire("<?php echo $this->lang->line('No data found') ?>", "", "warning");
                            $("#nodata").hide();
                        } else $("#nodata").show();
                    }
                }
            });
        }

        $(document).on('click', '.mark_seen', function (e) {
            e.preventDefault();
            var link = $(this).attr("href");

            $(this).addClass('btn-progress');
            $.ajax({
                context: this,
                url: link,
                type: 'POST',
                dataType: 'JSON',
                data: {},
                success: function (response) {
                    $(this).removeClass('btn-progress');
                    if (response.status == "1") {
                        iziToast.success({
                            title: '<?php echo $this->lang->line("Success"); ?>',
                            message: response.message,
                            position: 'bottomRight'
                        });
                        $(this).parent().parent().parent().hide();
                    } else iziToast.error({
                        title: '<?php echo $this->lang->line("Error"); ?>',
                        message: response.message,
                        position: 'bottomRight'
                    });
                }
            });
        });

        $(document).on('click', '#mark_seen_all', function (e) {
            e.preventDefault();
            var mes = '<?php echo $this->lang->line("Do you really want to mark all unseen notifications as seen?");?>';
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
                        $(this).addClass('btn-progress');
                        $.ajax({
                            context: this,
                            url: base_url + "announcement/mark_seen_all",
                            type: 'POST',
                            dataType: 'JSON',
                            data: {},
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

        $(document).on('click', '.delete_annoucement', function (e) {
            e.preventDefault();
            var link = $(this).attr("href");
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
                        $(this).addClass('btn-progress');
                        $.ajax({
                            context: this,
                            url: link,
                            type: 'POST',
                            dataType: 'JSON',
                            data: {},
                            success: function (response) {
                                $(this).removeClass('btn-progress');
                                if (response.status == "1") {
                                    iziToast.success({
                                        title: '<?php echo $this->lang->line("Success"); ?>',
                                        message: response.message,
                                        position: 'bottomRight'
                                    });
                                    $(this).parent().parent().parent().parent().parent().hide();
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

    });
</script>