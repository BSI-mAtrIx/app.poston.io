<?php
include(FCPATH . 'application/n_views/instagram_reply/comment_reply/comment_reply_css.php');
?>
<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
?>
<link rel="stylesheet"
      href="<?php echo base_url('n_assets/css/system/instagram/instagram_comment_reply.css?ver=' . $n_config['theme_version']); ?>">
<style type="text/css">
    .profile-widget-items {
        display: grid;
        grid-template-columns: 1fr 1fr;
        text-align: center;
        padding: 15px;
    }

    .profile-widget-items .profile-widget-item i {
        font-size: 1.7rem;
    }

    .article-title h4 {
        font-size: 1.10rem;
        padding: 15px;
        padding-bottom: 0;
    }

    article {
        box-shadow: -8px 12px 18px 0 rgb(25 42 70 / 13%);
    }
</style>
<?php
//todo: 0000000 before release
?>
<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("instagram_reply") ?>"><?php echo $this->lang->line("Instagram Reply"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 ">
                    <div class="form-group">
                        <div class="form-group">
                            <div class="input-group">
                                <select name="account_name" id="account_name" class="select2 form-control">
                                    <option value=""><?php echo $this->lang->line('Select Account'); ?></option>
                                    <?php foreach ($account_lists as $value) {
                                        echo '<option value="' . $value['id'] . '">' . $value['insta_username'] . ' [' . $value['page_name'] . '] ' . '</option>';
                                    } ?>
                                </select>
                                <input type="text" class="form-control" id="hash_tag" name="hash_tag"
                                       placeholder="<?php echo $this->lang->line('Provide hash tag'); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" id="search_hashtag"><i
                                                class="bx bx-search"></i> <?php echo $this->lang->line('Search'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-center" id="preloader"></div>

                <div class="col-12">
                    <div id="hashtag_search_result"></div>
                </div>
            </div>
        </div>
    </div>
</div>