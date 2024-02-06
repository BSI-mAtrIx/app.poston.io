<?php
$xdata = $this->CI->basic->get_data("nvx_addons", array("where" => array("name" => 'n_generator')), '', '', 1);
if (!isset($xdata[0])){
    $return_cg_code = 'empty';
}

$return_cg_code = $xdata[0]['code'];