<script>
    var base_url = "<?php echo site_url(); ?>";
    var csrf_token = "<?php echo $csrf_token; ?>";

    $(document).ready(function () {
        var perscroll;
        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[2, "desc"]],
            pageLength: 10,
            ajax: {
                "url": base_url + 'price/api_admin/plans',
                "type": 'POST',
                data: {
                    'csrf_token': csrf_token
                },
            },
            language: {
                url: "<?php echo base_url('assets/modules/datatables/language/' . $this->language . '.json'); ?>"
            },
            dom: '<"top"f>rt<"bottom"lip><"clear">',
            columnDefs: [
                {
                    targets: [0],
                    visible: false
                },
                {
                    targets: [1, 2],
                    className: 'text-center'
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

        $(document).on('click', '.delete_plan', function (e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            swal.fire({
                text: '<?php echo $this->lang->line('Are you sure you want to delete dynamic plan? This process is irreversible.'); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes, remove dynamic plan'); ?>",
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
                        url: base_url+"price/api_admin/plan_delete",
                        dataType: 'json',
                        data: {id: id, csrf_token: "<?php echo $this->session->userdata('csrf_token_session'); ?>"
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

    })
</script>