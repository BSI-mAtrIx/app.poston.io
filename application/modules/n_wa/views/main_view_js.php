<script>
    $('document').ready(function () {

        <?php require_once(APPPATH.'modules/n_wa/include/sweetalert_v1.php'); ?>

        var csrf_token = "<?php echo $this->session->userdata('csrf_token_session'); ?>";

        var base_url = "<?php echo site_url(); ?>";
        var csrf_token = "<?php echo $csrf_token; ?>";


            var perscroll;
            var table = $("#mytable").DataTable({
                serverSide: true,
                processing: true,
                bFilter: true,
                order: [[1, "desc"]],
                pageLength: 10,
                ajax: {
                    "url": base_url + 'n_wa/api/list_bots',
                    "type": 'POST',
                    data: {
                        'csrf_token': csrf_token
                    },
                },
                language: {
                    url: "<?php echo base_url('assets/thirdn_n_wa/datatables_language/' . $this->language . '.json'); ?>"
                },
                dom: '<"top"f>rt<"bottom"lip><"clear">',
                columnDefs: [
                    {
                        targets: [0],
                        visible: false
                    },
                    {
                        targets: [1],
                        className: 'text-left'
                    }
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

        var slug = function(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
            var to   = "aaaaaeeeeeiiiiooooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '_') // collapse whitespace and replace by -
                .replace(/-+/g, '_'); // collapse dashes

            return str;
        };

        $(document).on('input', '#lp_name', function (event) {
            $('#lp_name_url').val(slug($('#lp_name').val()));
        });

        $(document).on('input', '#lp_name_url', function (event) {
            $('#lp_name_url').val(slug($('#lp_name_url').val()));
        });

        $(document).on('input', '#wildcard_domain', function (event) {
            $('#wildcard_domain').val(slug($('#wildcard_domain').val()));
        });

        $(document).on('click', '.delete_bot', function (e) {
            e.preventDefault();
            let bot_id = $(this).attr('data-id');
            swal.fire({
                text: '<?php echo $this->lang->line('Are you sure you want to delete the bot? This process is irreversible.'); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes, remove bot'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('Cancel'); ?>",
                showCancelButton: true,
            }).then((userAction) => {
                if(typeof userAction == 'boolean'){
                    sa_confirmed = userAction;
                }else{
                    sa_confirmed = userAction.isConfirmed;
                }
                if (sa_confirmed) {
                    $.ajax({
                        context: this,
                        type: 'POST',
                        url: base_url+"n_wa/api/delete_bot",
                        dataType: 'json',
                        data: {bot_id: bot_id, csrf_token: "<?php echo $this->session->userdata('csrf_token_session'); ?>"
                        },
                        success: function (response) {
                            if (response.status == 1) {
                                window.location.reload();
                            } else {
                                swal.fire('<?php echo $this->lang->line("Warning"); ?>', response.message, 'warning');
                            }
                        }
                    });
                }
            });

        });



    });
</script>