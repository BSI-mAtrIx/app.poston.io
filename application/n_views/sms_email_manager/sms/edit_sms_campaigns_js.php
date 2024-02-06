<?php include("application/n_views/sms_email_manager/sms/sms_section_global_js.php"); ?>
<?php if ($xlabels != "") { ?>
    <script type="text/javascript">
        var xlabels = "<?php echo $xlabels;?>";
    </script>
    <?php
} ?>

<?php if ($xexcluded_label_ids != "") { ?>
    <script type="text/javascript">var xexcluded_label_ids = "<?php echo $xexcluded_label_ids;?>";</script>
    <?php
} ?>

<?php if ($contact_id != "") { ?>
    <script type="text/javascript">setTimeout(function () {
            $("#contacts_id").trigger('change');
        }, 2000);</script>
    <?php
} ?>

<?php if ($manual_phone != "") { ?>
    <script type="text/javascript">setTimeout(function () {
            $("#to_numbers").trigger('keyup');
        }, 2000);</script>
    <?php
} ?>

<script type="text/javascript">
    var xpage_id = '<?php echo $xpage_id; ?>';
    $(document).ready(function ($) {
        if (xpage_id != "0") {
            $("#page").val(xpage_id).trigger('change');
        } else {
            $(".waiting").hide();
        }
    });
</script>