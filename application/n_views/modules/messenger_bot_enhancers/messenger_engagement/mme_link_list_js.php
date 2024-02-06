<script>
    $(document).ready(function ($) {

        var base_url = '<?php echo base_url(); ?>';

        var areWeUsingScroll = false;
        //todo: areWeUsingScroll
        $(document).ready(function () {
            'use strict';

            $(".select2").select2({
                dropdownAutoWidth: true,
                width: '100%',

            });
        });


        <?php if(!empty($page_info) and $page_id == 0 and $iframe == 0){ ?>
        window.location.href = base_url + 'messenger_bot_enhancers/mme_link_list/' + $('#bot_list_select').val();
        <?php } ?>

        <?php if(!empty($page_info) and $page_id != 0 and $iframe == 0){ ?>
        $('#bot_list_select').val(<?php echo $page_id; ?>);
        <?php } ?>

        $(document).on('change', '#bot_list_select', function (event) {
            window.location.href = base_url + 'messenger_bot_enhancers/mme_link_list/' + $('#bot_list_select').val();
        });

        // datatable section started
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": base_url + 'messenger_bot_enhancers/mme_link_list_data',
                    "type": 'POST',
                    data: function (d) {
                        d.search_page_id = $('#page_id').val();
                    }
                },
            language:
                {
                    url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
                },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [1, 2],
                    visible: false
                },
                {
                    targets: [0, 1, 3, 4, 5, 7],
                    className: 'text-center'
                },
                {
                    targets: [0, 1, 3, 4, 5, 6, 9],
                    sortable: false
                },
                {
                    targets: [3],
                    render: function (data, type, row, meta) {
                        var embed_js = '<a campaign_id=' + row[1] + ' class="badge badge-status get_js_embed" title="<?php echo $this->lang->line('Get Embed Code') ?>" style="cursor: pointer;"><i class="bx bx-code"></i> <?php echo $this->lang->line('Js Code'); ?></a> <a campaign_id=' + row[1] + ' class="badge badge-status get_qr_code" title="<?php echo $this->lang->line('Get QR Code') ?>" style="cursor: pointer;"><i class="bx bx-code-alt"></i> <?php echo $this->lang->line('QR Code'); ?></a>';
                        return embed_js;
                    }
                },
                {
                    targets: [4],
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

        $(document).on('change', '#search_page_id', function (event) {
            event.preventDefault();
            table.draw();
        });


        $(document).on('click', '#search_submit', function (event) {
            event.preventDefault();
            table.draw();
        });


        $(document).on('click', '.get_js_embed', function (event) {
            event.preventDefault();

            var campaign_id = $(this).attr('campaign_id');

            $.ajax({
                url: '<?php echo base_url('messenger_bot_enhancers/mme_link_js_code') ?>',
                type: 'POST',
                dataType: 'JSON',
                data: {campaign_id: campaign_id},
                success: function (response) {
                    if (response) {

                        $(".description").text(response.str1);
                        $("#get_embed_modal").modal();
                        Prism.highlightAll();

                        $("#mme").text(response.str2);

                        $(".toolbar-item").find('a').addClass('copy');
                    } else {

                        swal.fire('<?php echo $this->lang->line("Error"); ?>', '<?php echo $this->lang->line("Something went wrong"); ?>', 'error');
                    }


                }

            });

        });


        $(document).on('click', '.get_qr_code', function (event) {
            event.preventDefault();

            var campaign_id = $(this).attr('campaign_id');

            $.ajax({
                url: '<?php echo base_url('messenger_bot_enhancers/mme_link_qr_code') ?>',
                type: 'POST',
                data: {campaign_id: campaign_id},
                success: function (response) {
                    $("#qr_container").html(response);
                    $("#get_embed_modal2").modal();
                }

            });

        });


        $(document).on('click', '.copy', function (event) {
            event.preventDefault();

            $(this).html('<?php echo $this->lang->line("Copied!"); ?>');
            var that = $(this);

            var text = $(this).parent().parent().parent().find('code').text();
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();


            // iziToast.success({
            //     title: "",
            //     message: "<?php echo $this->lang->line('Copied to clipboard') ?>",
            // });

            setTimeout(function () {
                $(that).html('<?php echo $this->lang->line("Copy"); ?>');
            }, 2000);

        });


        $(document).on('click', '.delete_campaign', function (event) {
            event.preventDefault();

            swal.fire({
                title: '<?php echo $this->lang->line("Delete M.me"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to delete this m.me link?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        var base_url = '<?php echo site_url();?>';
                        $(this).addClass('btn-progress');
                        $(this).removeClass('btn-outline-danger');
                        var that = $(this);
                        var campaign_id = $(this).attr('campaign_id');

                        $.ajax({
                            context: this,
                            type: 'POST',
                            url: base_url + 'messenger_bot_enhancers/mme_link_delete',
                            dataType: 'JSON',
                            data: {campaign_id: campaign_id},
                            success: function (response) {

                                $(that).removeClass('btn-danger btn-progress');

                                if (response.status == '1')
                                    iziToast.success({
                                        title: '<?php echo $this->lang->line("Deleted Successfully"); ?>',
                                        message: response.message,
                                        position: 'bottomRight'
                                    });
                                else
                                    iziToast.error({
                                        title: '<?php echo $this->lang->line("Error"); ?>',
                                        message: response.message,
                                        position: 'bottomRight'
                                    });


                                table.draw();
                            }
                        });
                    }
                });
        });


        $(".xscroll1").mCustomScrollbar({
            autoHideScrollbar: true,
            theme: "light-thick",
            axis: "x"
        });

        // $(".toolbar-item").css('display', 'none');


    });

</script>