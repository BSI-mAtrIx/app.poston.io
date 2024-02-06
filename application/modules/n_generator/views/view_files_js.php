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
                "url": base_url + 'n_generator/api/files',
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

        $(document).on('click', '.delete_document', function (e) {
            e.preventDefault();
            let doc_id = $(this).attr('data-id');
            swal.fire({
                text: '<?php echo $this->lang->line('Are you sure you want to delete the document? This process is irreversible.'); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes, remove document'); ?>",
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
                        url: base_url+"n_generator/api/delete_document",
                        dataType: 'json',
                        data: {doc_id: doc_id, csrf_token: "<?php echo $this->session->userdata('csrf_token_session'); ?>"
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