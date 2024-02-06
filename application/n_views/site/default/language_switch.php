<?php


$flag_current = LangToCode($current_language, $n_config); ?>
<div class="heading-elements">
    <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true"
       aria-expanded="false">
        <i class="flag-icon flag-icon-<?php echo $flag_current; ?>"></i>
        <span class="selected-language"><?php echo $current_language; ?></span>
    </a>
    <div class="dropdown-menu" aria-labelledby="dropdown-flag">
        <?php
        ksort($language_info);
        foreach ($language_info as $key_lang => $value_lang) {
            $selected = '';
            // if($key==$this->session->userdata("facebook_rx_fb_user_info")) $selected='active';
            //var_dump($value);
            $flag = LangToCode($value_lang, $n_config);


            echo '
                                    <a class="dropdown-item language_switch" href="#" data-id="' . $key_lang . '" data-language="' . $key_lang . '" ' . $selected . '><i class="flag-icon flag-icon-' . $flag . ' mr-50"></i> ' . $value_lang . '</a>
                                    ';
        }
        ?>
    </div>
</div>