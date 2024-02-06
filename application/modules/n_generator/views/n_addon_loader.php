<?php
$addon_page = 'modules/' . $this->_module . '/views/' . $addon_page;
if (file_exists(FCPATH . 'application/' . $addon_page . '.php')) {
    include(FCPATH . 'application/' . $addon_page . '.php');
} else {
    var_dump('application/' . $addon_page . '.php');
}


if (!defined('NVX')) {
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/gen_thirdn/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/gen_thirdn/boxicons/css/animations.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/gen_thirdn/boxicons/css/transformations.css">
    <script>
        $(".char-textarea").on("keyup", function (event) {
            checkTextAreaMaxLength(this, event)
            // to later change text color in dark layout
            $(this).addClass("active")
        })

        function checkTextAreaMaxLength(textBox, e) {
            var maxLength = parseInt($(textBox).data("length"))

            if (!checkSpecialKeys(e)) {
                if (textBox.value.length < maxLength - 1)
                    textBox.value = textBox.value.substring(0, maxLength)
            }
            $(".char-count").html(textBox.value.length)

            if (textBox.value.length > maxLength) {
                $(".char-count").css("color", '#fc544b')
                $(".char-textarea").css("color", '#fc544b')
                // to change text color after limit is maxedout out
                $(".char-textarea").addClass("max-limit")
            } else {
                $(".char-count").css("color", '#064663')
                $(".char-textarea").css("color", '#495057')
                $(".char-textarea").removeClass("max-limit")
            }

            return true
        }

        function checkSpecialKeys(e) {
            if (
                e.keyCode != 8 &&
                e.keyCode != 46 &&
                e.keyCode != 37 &&
                e.keyCode != 38 &&
                e.keyCode != 39 &&
                e.keyCode != 40
            )
                return false
            else return true
        }

    </script>
    <?php
    if (file_exists(FCPATH . 'application/' . $addon_page . '_js.php')) {
        include(FCPATH . 'application/' . $addon_page . '_js.php');
    }
}