<script>
    var base_url = "<?php echo site_url(); ?>";
    var csrf_token = "<?php echo $csrf_token; ?>";

    $(document).ready(function () {

        var perscroll;

        var table = $("#mytable").DataTable({
            serverSide: true,
            processing: true,
            bFilter: true,
            order: [[1, "desc"]],
            pageLength: 10,
            ajax:
                {
                    "url": base_url + 'payment/package_manager_data',
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
                    targets: [0, 6],
                    sortable: false
                },
                {
                    targets: [3],
                    "render": function (data, type, row, meta) {
                        if (row[5] == "1" && row[3] == "0")
                            return "Free";
                        else return data;
                    }
                },
                {
                    targets: [4],
                    "render": function (data, type, row, meta) {
                        if (row[5] == "1" && row[3] == "0")
                            return "Unlimited";
                        else return data;
                    }
                },
                {
                    targets: [5],
                    "render": function (data, type, row, meta) {
                        if (data == 1) return "<i class='bx bx-check-circle green'></i>";
                        else return "<i class='bx bx-time-circle'></i>";
                    }
                },
                {
                    targets: [6],
                    "render": function (data, type, row, meta) {
                        var url = base_url + 'payment/details_package/' + row[1];
                        var edit_url = base_url + 'payment/edit_package/' + row[1];
                        var delete_url = base_url + 'payment/delete_package/' + row[1];
                        var more = "<?php echo $this->lang->line('More Info');?>";
                        var edit_str = "<?php echo $this->lang->line('Edit');?>";
                        var delete_str = "<?php echo $this->lang->line('Delete');?>";
                        var str = "";
                        str = "&nbsp;<a class='btn btn-circle btn-outline-primary' href='" + url + "'>" + '<i class="bx bx-bullseye"></i>' + "</a>";
                        str = str + "&nbsp;<a class='btn btn-circle btn-outline-warning' href='" + edit_url + "'>" + '<i class="bx bx-edit"></i>' + "</a>";

                        if (row[5] == '0')
                            str = str + "&nbsp;<a href='" + delete_url + "' csrf_token='" + csrf_token + "' class='are_you_sure_datatable btn btn-circle btn-outline-danger'>" + '<i class="bx bx-trash"></i>' + "</a>";
                        else str = str + "&nbsp;<a class='btn btn-circle btn-outline-light' data-toggle='tooltip' title='<?php echo $this->lang->line("Default package can not be deleted.");?>'>" + '<i class="bx bx-trash"></i>' + "</a>";

                        return "<div style='min-weight:130px'>" + str + '</div>';
                    }
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
    });


</script>