<style>
    .row-actions{display:none;}
    tr:hover .row-actions{display:block;}
</style>
<?php


if (!defined('NVX')) { ?>
    <section class="section section_custom">
        <div class="section-header">
            <h1><i class="fa fa-search-location"></i> <?php echo $page_title; ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="<?php echo base_url(); ?>n_wa"><?php echo $this->lang->line("WhatsApp"); ?></a></div>
                <div class="breadcrumb-item"><?php echo $page_title; ?></div>
            </div>
        </div>
    </section>

<?php } else { ?>
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2 mt-1">
            <div class="breadcrumbs-top">
                <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
                <div class="breadcrumb-wrapper d-none d-sm-block">
                    <ol class="breadcrumb p-0 mb-0 pl-1">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                        class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>n_wa"><?php echo $this->lang->line('WhatsApp bot'); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php
    $jodit = 1;
    $include_select2 = 1;
    $include_dropzone = 1;
    $include_cropper = 1;
    $include_datatable=1;
}



?>



<?php include(APPPATH . 'modules/n_wa/include/alert_message.php'); ?>


    <div class="section-body ntheme main">
        <div class="card" id="nodata">
            <div class="card-header">
                <h5 class="card-title"><?php echo $page_title; ?></h5>
            </div>
            <div class="card-body">
                <div class="accordion" id="wa_help">

                    <?php

                    function turnUrlIntoHyperlink($string){

                        //The Regular Expression filter
                        $reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";

                        // Check if there is a url in the text
                        if(preg_match_all($reg_exUrl, $string, $url)) {

                            // Loop through all matches
                            foreach($url[0] as $key => $newLinks){

                                if(strstr( $newLinks, ":" ) === false){
                                    $url = 'https://'.$newLinks;
                                }else{
                                    $url = $newLinks;
                                }

                                // Create Search and Replace strings
                                $replace = '<a href="'.$url.'" title="'.$url.'" target="_blank" class="external">'.$url.'</a>,';
                                $newLinks = '/'.preg_quote($newLinks, '/').'/';
                                $string = preg_replace($newLinks, '{'.$key.'}', $string, 1);

                            }
                            $arr_replace = explode(',', $replace);
                            foreach ($arr_replace as $key => $link) {
                                $string = str_replace('{'.$key.'}', $link, $string);
                            }
                        }

                        //Return result
                        return $string;
                    }

                    $wa_help_arr = array();

                    $wa_help_arr[] = array(
                        'heading' => 'wa_head_',
                        'accordion' => 'wa_acc_',
                        'title' => 'How to obtain WhatsApp Business ID?',
                        'body' => '1. First you need create Meta App. Go to https://developers.facebook.com/<br/>2. If you have not logged, click in menu "Log in"<br/>3. Click My Apps<br />4. Click Create App<br />5. Select app type: Business and click next<br />6. Fill fields: app name, contact email - what you want. You need select Business Account. <br />7. Add product to your app: find WhatsApp and click set up<br />8. On left menu click WhatsApp > Getting started<br />9. You have now WhatsApp Business Account ID. Copy it to our app into "PROVIDE YOUR WHATSAPP BUSINESS ID"<br />10. Don\'t close this page. Don\'t use temporary access token',
                    );

                    $wa_help_arr[] = array(
                        'heading' => 'wa_head_',
                        'accordion' => 'wa_acc_',
                        'title' => 'How to obtain WhatsApp Access Token?',
                        'body' => '1. First you need get WhatsApp Business ID.<br/>2. Go to: https://business.facebook.com/ <br/>3. Dropdown select list after Meta Business Suite log<br/>4. Click Settings near business account connected with your App<br/>5. Click "Business settings" in middle section<br/>6. Go to Users > System Users<br/>7. Click "Add"<br/>8. Fill fields: System user role - Admin, System user name: anything<br/>9. Click to created user then click Add assets<br/>10. Select asset type: Apps, select assets: your app and select App Full Control ON. Save it<br />11. Click on "Generate new token"<br/>12. Select your App and select: business_management, whatsapp_business_management, whatsapp_business_messaging<br/>13. Click save and copy your Access token into our App.',
                    );

                    $wa_help_arr[] = array(
                        'heading' => 'wa_head_',
                        'accordion' => 'wa_acc_',
                        'title' => 'How to add phone number?',
                        'body' => '1. Go to https://developers.facebook.com/<br/>2. In your app settings (WhatsApp > Getting Started) find section: Step 5: Add a phone number<br/>3. Click add phone number and complete wizard',
                    );

                    $wa_help_arr[] = array(
                        'heading' => 'wa_head_',
                        'accordion' => 'wa_acc_',
                        'title' => 'How to configure webhook?',
                        'body' => '1. Go to https://developers.facebook.com/<br/>2. In your app settings (WhatsApp > Configuration) click edit near Webhook<br/>3. Copy from our app Webhook URL and paste into Callback URL<br />4. Copy from our app Webhook Verify Token and paste into Verify token<br/>5. Click verify and save<br/>6. In Meta App Webhook Configuration click Manage<br />7. Click Subscribe near messages<br/>8. Go to Settings > Basic Fill required fields: Display name, privacy policy URL, terms of service url. Then click save change',
                    );

                    $count = 0;
                    foreach($wa_help_arr as $k => $v){
                        echo '<div class="card collapse-header">
                        <div id="'.$v['heading'].$count.'" class="card-header" role="tablist" data-toggle="collapse" data-target="#'.$v['accordion'].$count.'" aria-expanded="false" aria-controls="'.$v['accordion'].$count.'">
                            <span class="collapse-title">'.$this->lang->line($v['title']).'</span>
                        </div>
                        <div id="'.$v['accordion'].$count.'" role="tabpanel" data-parent="#wa_help" aria-labelledby="'.$v['heading'].$count.'" class="collapse">
                            <div class="card-body">
                                '.turnUrlIntoHyperlink($this->lang->line($v['body'])).'
                            </div>
                        </div>
                    </div>';
                    $count++;
                    }


                    ?>
                </div>
            </div>
        </div>
    </div>
