<?php if (!empty($this->session->userdata($store_id . "_sorting"))) { ?>
    <script>
        $(document).ready(function () {
            $("#set_sort").val('<?php echo $this->session->userdata($store_id . "_sorting"); ?>');
        });
    </script>
<?php } ?>