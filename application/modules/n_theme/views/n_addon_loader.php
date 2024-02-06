<?php
//$addon_page = 'modules/' . $this->_module . '/views/' . $addon_page;
if (file_exists(FCPATH . 'application/' . $addon_page . '.php')) {
    include(FCPATH . 'application/' . $addon_page . '.php');
} else {
    var_dump('application/' . $addon_page . '.php');
}