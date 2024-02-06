<?php
$addon_page = 'modules/' . $this->_module . '/views/' . $addon_page;
if (file_exists(FCPATH . 'application/' . $addon_page . '.php')) {
    include(FCPATH . 'application/' . $addon_page . '.php');
} else {
    var_dump('application/' . $addon_page . '.php');
}

    if((isset($rtl_on) && $rtl_on == true) OR (isset($is_rtl) && $is_rtl == true)){
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/thirdn_n_wa/style_rtl.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/thirdn_n_wa/app-chat-rtl.css">
        <?php
    }else{
        ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/thirdn_n_wa/app-chat.css">
    <?php }

 if (!defined('NVX')) {
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/thirdn_n_wa/style_legacy.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/thirdn_n_wa/boxicons/css/boxicons.min.css">
    <script src="<?php echo base_url(); ?>assets/thirdn_n_wa/jquery.blockUI.js"></script>
    <link rel="stylesheet"
          href="<?php echo base_url(); ?>assets/thirdn_n_wa/cropper/cropper.min.css">
    <script src="<?php echo base_url(); ?>assets/thirdn_n_wa/cropper/cropper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/thirdn_n_wa/cropper/jquery-cropper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/thirdn_n_wa/jquery.repeater.min.js"></script>

<?php
    if (file_exists(FCPATH . 'application/' . $addon_page . '_js.php')) {
        include(FCPATH . 'application/' . $addon_page . '_js.php');
    }
}