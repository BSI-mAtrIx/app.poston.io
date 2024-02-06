<?php
    $addon_page = 'modules/'.$this->_module.'/views/'.$addon_page;
    if(file_exists(FCPATH.'application/'.$addon_page.'.php')){
        include(FCPATH.'application/'.$addon_page.'.php');
    }else{
        var_dump('application/'.$addon_page.'.php');
    }


if (!defined('NVX')) {
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/n_adsmanager/boxicons/css/boxicons.min.css">
<?php
    if(file_exists(FCPATH.'application/'.$addon_page.'_js.php')){
        include(FCPATH.'application/'.$addon_page.'_js.php');
    }
}