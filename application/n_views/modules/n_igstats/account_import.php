<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 0;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 1;
?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="container-fluid">
                    <div class="row clearfix">

                        <div class="col-xs-12" style="margin:15px auto;">
                            <h4>
                                <div class="text-center" style="margin-bottom:80px;">
                                    <p style="font-size:15px; margin-top:15px; max-width:80%; margin:15px auto;">
                                        <?php echo $this->lang->line("Below are your Instagram business or creator accounts. Accounts must be linked to the Facebook page. If you don't see your account, import it."); ?>
                                    </p>
                                    <div class="text-center">
                                        <a style="color:#fff;" href="/social_accounts/index"
                                           class="center-block btn btn-primary update_your_account">
                                            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Import account"); ?>
                                        </a>
                                    </div>
                                </div>
                            </h4>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:20px;">
                        <?php if ($existing_accounts != '0' && $show_import_account_box == 1 && !empty($existing_accounts)) { ?>
                            <?php $i = 0;
                            foreach ($existing_accounts as $value) : ?>

                                <?php foreach ($value['instra_info_list'] as $instra_info) : ?>
                                    <div class="col-md-4" style="margin-bottom:50px;">
                                        <div class="text-center">
                                            <img src="<?php echo $instra_info['page_profile']; ?>"
                                                 class='custom-top-margin img-thumbnail' style="height:90px;">
                                        </div>
                                        <div class="text-center">
                                            <a href="https://www.instagram.com/<?php echo $instra_info['insta_username']; ?>">
                                                <h3 style="font-size:13px; margin-top:20px; margin-bottom:20px;">
                                                    @<?php echo $instra_info['insta_username']; ?></h3>
                                            </a>
                                        </div>
                                        <div class="row text-center" style="margin-bottom:20px;">
                                            <div class="col-md-7">
                                                <b><?php echo custom_number_format($instra_info['insta_followers_count']); ?></b> <?php echo $this->lang->line('Followers'); ?>
                                            </div>
                                            <div class="col-md-5">
                                                <b><?php echo custom_number_format($instra_info['insta_media_count']); ?></b> <?php echo $this->lang->line('media'); ?>
                                            </div>
                                        </div>

                                        <a style="margin:0 0 5px 0;width:100%;" class="center-block btn btn-primary"
                                           href="<?php echo base_url('/n_igstats/user_insight/' . $instra_info['id']); ?>">
                                            <i class="bx bx-list-ul"></i>
                                            <?php echo $this->lang->line("Account statistics") ?>
                                        </a>

                                        <a style="margin:0 0 5px 0;width:100%; color:#fff;"
                                           data-id="<?php echo $instra_info['id']; ?>"
                                           class="center-block btn btn-primary update_your_account">
                                            <i class="bx bx-repost"></i>
                                            <?php echo $this->lang->line("Update account data"); ?>
                                        </a>

                                    </div>
                                <?php endforeach; ?>

                            <?php endforeach; ?>
                        <?php } else echo "<br><br>"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








