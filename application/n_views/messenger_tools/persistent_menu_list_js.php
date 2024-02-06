<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
    var action_menu = '<?php echo $action_menu;?>';
    setTimeout(function () {
        $("#mytable_filter").append(action_menu);
    }, 1000);

    setTimeout(function () {
        $(".fade_out").fadeOut();
    }, 3000);
    var media_type = '<?php echo $media_type; ?>';
    var target_index = 3;
    if (media_type == 'ig') target_index = 2;
    var table = $("#mytable").DataTable({
        language:
            {
                url: "<?php echo base_url('n_assets/plugins/datatables_language/' . $this->language . '.json'); ?>"
            },
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        columnDefs: [
            {
                targets: [target_index],
                sortable: false
            }
        ]
    });

    $(document).ready(function () {
        $("#publish_menu").click(function (e) {
            var publish_disabled = "<?php echo $publish_disabled;?>";
            if (publish_disabled == 'disabled') {
                alertify.alert('<?php echo $this->lang->line("Alert"); ?>', "<?php echo $disabled_msg;?>", function () {
                });
                e.preventDefault();
            }
        });


        $(document).on('click', '.remove_persistent_menu', function (e) {
            e.preventDefault();
            var link = $(this).attr("href");
            swal.fire({
                title: '<?php echo $this->lang->line("Warning!"); ?>',
                text: '<?php echo $this->lang->line("Are you sure that you want to remove persistent menu from Facebook?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        window.location.href = link;
                    }
                });
        });

        $(document).on('click', '.delete_persistent_menu', function (e) {
            e.preventDefault();
            var link = $(this).attr("href");
            var title = $(this).attr("title");
            if (link == '#') {
                swal.fire('<?php echo $this->lang->line("Warning!"); ?>', title, 'warning');
                return;
            }
            swal.fire({
                title: '<?php echo $this->lang->line("Warning!"); ?>',
                text: '<?php echo $this->lang->line("Do you really want to remove this item?"); ?>',
                icon: 'warning',
                confirmButtonText: "<?php echo $this->lang->line('Yes'); ?>",
                cancelButtonText: "<?php echo $this->lang->line('No'); ?>",
                showCancelButton: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        window.location.href = link;
                    }
                });
        });

    });
</script>
