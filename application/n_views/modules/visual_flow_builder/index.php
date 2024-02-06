<?php
include(FCPATH . 'application/n_views/config.php');
if ($n_config['default_flowbuilder'] == 'true') {
    include(FCPATH . 'application/modules/visual_flow_builder/views/index.php');
    exit;
} else {
    include(FCPATH . 'application/n_views/include/function_helper_theme.php');
    $current_language = $this->language;
    if (strpos(strtolower($n_config['rtl_langs']), strtolower($current_language)) !== false) {
        $rtl_on = true;
        $html_lang = 'lang="' . LangToCode($current_language, $n_config) . '" data-textdirection="rtl"';
    } else {
        $rtl_on = false;
        $html_lang = 'lang="' . LangToCode($current_language, $n_config) . '" data-textdirection="ltr"';
    }


//        if(!file_exists(FCPATH.'application/n_views/modules/visual_flow_builder/index_'.$n_config['theme_version'].'.php')){
    $add_html = '<style>';
    $add_html .= '.xit-fb-template .title:first-child{background:#fff!important;}';
    $add_html .= '.tabs-content-component{background:#fff!important;}';
    $add_html .= '.xit-fb-template.node.trigger, .fb-dockmenu-header{background:#fff!important;}';

    $add_html .= '#xit-flow-builder div.xit-fb-template div.title:first-child {
            color: #475F7B!important;
        font-weight: 700;
    letter-spacing: 0.05rem;
    font-size: 1.2rem;
    margin-bottom: 0rem;
    text-transform: capitalize;
}';
    $add_html .= '.card_data_body .text_message, .postback_title {
background-color: #EFEFEF;
border: 1px solid #EFEFEF;
color: #3D3D3D;
}';

    $add_html .= '.xit-fb-template .title-content {
font-weight: 700;
}';

    $add_html .= '.tabs-content-component-icon svg{
color: #475F7B!important;
}';

    $add_html .= '.swal2-header, .swal2-container.swal2-top-end .swal2-popup{
        background:#fff;
}';

    $add_html .= '.swal2-header .swal2-title, .swal2-container.swal2-top-end .swal2-title{
color: #475F7B!important;
    font-weight: 700!important;
}';

    $add_html .= '.xit-fb-template .list-group-horizontal .list-group-item span{
color: #475F7B !important;
font-weight: 500!important;
}';

    $add_html .= '.xit-fb-template .list-group-horizontal .list-group-item span svg{
display:none;
}';

    $add_html .= '.tabs-content-component:hover{
    border: 0.5px dashed #5A8DEE ;
}';

    $add_html .= '.tabs-content-component:hover,
         .tabs-content-component:hover svg,
         .tabs-content-component:hover .tabs-content-component-title{
color: #5A8DEE  !important;
}';

    $add_html .= '.btn-light, .btn-light.disabled {
    background-color: #fff;
    border-color: #475F7B;
    color: #475F7B;
}';

    $add_html .= '.btn-light:hover {
            color: #fff !important;
            background-color: #475F7B !important;
    border-color: #475F7B !important;
}';

    $add_html .= 'btn-light::placeholder{
    color: #475F7B!important;
}';


    $add_html .= '.btn-light:hover::placeholder{
            color: #fff !important;
        }';

    $add_html .= '#xit-flow-builder .xit-fb-template.trigger .title:first-child{
            background: transparent !important;
        }';


    if ($rtl_on) {
        $add_html .= 'select, textarea, input, .emojionearea .emojionearea-editor{direction:rtl!important};';
    }


    $add_html .= '</style>';

    $output = file_get_contents(FCPATH . 'application/modules/visual_flow_builder/views/index.php');

    $output = str_replace('lang="en"', "<?php echo \$html_lang; ?>", $output);

    $str = str_replace('</body>', $add_html . '</body>', $output);

//write the entire string
    file_put_contents(FCPATH . 'application/n_views/modules/visual_flow_builder/index_' . $n_config['theme_version'] . '.php', $str);
    //}

    include(FCPATH . 'application/n_views/modules/visual_flow_builder/index_' . $n_config['theme_version'] . '.php');

}
?>
