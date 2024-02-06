<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/extensions/swiper.min.css?ver=<?php echo $n_config['theme_version']; ?>">
<?php //TODO: file need improvements
?>

<style>
    .widget-earnings-scroll {
        position: relative;
    }

    .widget-earnings-scroll .widget-earnings-width {
        min-width: 390px;
    }

    #widget-earnings .widget-earnings-swiper.swiper-container .swiper-slide {
        /* widget swiper slide */
        font-weight: 500;
        background-color: #F2F4F4;
        height: auto;
        width: auto !important;
        color: #828D99;
        cursor: pointer;
    }

    #widget-earnings .widget-earnings-swiper.swiper-container .swiper-slide .swiper-text {
        font-family: 'Rubik', Helvetica, Arial, serif;
    }

    #widget-earnings .widget-earnings-swiper.swiper-container .swiper-slide.swiper-slide-active {
        /* swiper slide active */
        color: #FFFFFF;
        background-color: #5A8DEE !important;
        box-shadow: 0 3px 6px 0 rgba(90, 141, 238, 0.5) !important;
    }

    #widget-earnings .wrapper-content {
        display: none;
    }

    #widget-earnings .wrapper-content.active {
        display: block;
    }

    .avatar .img-fluid {
        max-width: 50px;
    }
</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("your existing accounts") ?></h5>
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


<?php
if ($this->session->userdata('success_message') == 'success') {
    echo '<div class="alert alert-success mb-2" role="alert">
            <div class="d-flex align-items-center">
              <i class="bx bx-like"></i>
              <span>
                ' . $this->lang->line('Your account has been imported successfully.') . '
              </span>
            </div>
          </div>';
    $this->session->unset_userdata('success_message');
}

if ($this->session->userdata('limit_cross') != '') {
    echo '<div class="alert alert-danger mb-2" role="alert">
            <div class="d-flex align-items-center">
              <i class="bx bx-error"></i>
              <span>
                ' . $this->session->userdata('limit_cross') . '
              </span>
            </div>
          </div>';

    $this->session->unset_userdata('limit_cross');
}

$is_demo = $this->is_demo;

?>

<div class="section-body">
    <div class="">
        <?php if ($show_import_account_box == 0) : ?>
            <br/>
            <div style="padding: 15px;">
                <div class='alert alert-danger text-center'><i
                            class='bx bx-time-five'></i> <?php echo $this->lang->line('Due to system configuration change you have to delete one or more imported FB accounts and import again. Please check the following accounts and delete the account that has warning to delete.'); ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="row  justify-content-center" style="padding:0 15px;">
            <!-- <div class="col text-center">		 -->
            <?php
            if ($is_demo && $this->session->userdata("user_type") == "Admin") {
                echo '<div class="alert alert-warning text-center">Account import has been disabled in admin account because you will not be able to unlink the Facebook account you import as admin. If you want to test with your own accout then <a href="' . base_url('home/sign_up') . '" target="_BLANK">sign up</a> to create your own demo account then import your Facebook account there.</div>';
            } elseif ($existing_accounts != '0') { ?>

            <?php } ?>
        </div>


    </div>
</div>

<?php

if (!empty($existing_accounts)) : ?>
    <div class="content-body" id="stacked-pill">
        <div class="row">
            <div class="col-sm-12">
                <div class="card bg-transparent shadow-none">
                    <div class="row pills-stacked">
                        <div class="col-md-3 col-sm-12">
                            <ul class="nav nav-pills flex-column text-center text-md-left">
                                <li class="nav-item mb-1">
                                    <?php
                                    $fb_login_button = str_replace("ThisIsTheLoginButtonForFacebook", $this->lang->line("Login with Facebook"), $fb_login_button);
                                    $fb_login_button = str_replace('fab fa-facebook', 'bx bxl-facebook-square', $fb_login_button);
                                    ?>
                                    <p data-toggle="tooltip" class="nav-link" data-placement="right"
                                       title="<?php echo $this->lang->line("You must be logged in your facebook account for which you want to refresh your access token. for synch your new page, simply refresh your token. if any access token is restricted for any action, refresh your access token."); ?>"> <?php if ($this->config->item('developer_access') != '1') echo $fb_login_button; ?></p>
                                </li>
                                <?php $i = 0;
                                foreach ($existing_accounts as $value) : ?>
                                <li>
                                    <span class="font-small-3 bold"><?php echo $value['name']; ?></span>

                                    <button class="delete_account btn-circle btn btn-danger btn-sm float-right "
                                            table_id="<?php echo $value['userinfo_table_id']; ?>"
                                            data-toggle="tooltip" data-placement="bottom"
                                            title="<?php echo $this->lang->line("Do you want to remove this account from our database? you can import again."); ?>">
                                        <i class="bx bx-trash-alt"></i>
                                    </button>

                                </li>


                                    <li class="nav-item mt-1">
                                        <a class="nav-link <?php if ($i == 0) {echo 'active';} ?>" id="stacked-pill_facebook-<?php echo $value['userinfo_table_id']; ?>"
                                           data-toggle="pill"
                                           href="#vertical-pill_facebook-<?php echo $value['userinfo_table_id']; ?>"
                                           aria-expanded="true">
                                             <?php echo $this->lang->line('Facebook Pages') ?> (<?php echo count($value['page_list']); ?>)

                                        </a>
                                    </li>

                                    <li class="nav-item mt-1">
                                        <a class="nav-link" id="stacked-pill_instagram-<?php echo $value['userinfo_table_id']; ?>"
                                           data-toggle="pill"
                                           href="#vertical-pill_instagram-<?php echo $value['userinfo_table_id']; ?>"
                                           aria-expanded="true">
                                            <?php echo $this->lang->line('Instagram Accounts') ?> (<span class="ig_counter"></span>)

                                        </a>
                                    </li>

                                    <li class="nav-item mt-1">
                                        <a class="nav-link" id="stacked-pill_groups-<?php echo $value['userinfo_table_id']; ?>"
                                           data-toggle="pill"
                                           href="#vertical-pill_groups-<?php echo $value['userinfo_table_id']; ?>"
                                           aria-expanded="true">
                                            <?php echo $this->lang->line('Facebook Groups') ?> (<?php echo count($value['group_list']); ?>)

                                        </a>
                                    </li>

                                    <?php
                                    $i++;
                                endforeach;
                                ?>

                            </ul>
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <div class="tab-content">
                                <?php $i = 0;
                                foreach ($existing_accounts as $value) : ?>
                                    <div role="tabpanel" class="tab-pane" id="vertical-pill_instagram-<?php echo $value['userinfo_table_id']; ?>"
                                     aria-labelledby="stacked-pill_instagram-<?php echo $value['userinfo_table_id']; ?>"
                                     aria-expanded="true">
                                    <div class="widget-earnings-scroll table-responsive">
                                        <h4 class="card-title"><?php echo $this->lang->line('Instagram list') ?>
                                            <span class="text-muted">(<span class="ig_counter"></span>  <?php echo $this->lang->line("accounts"); ?>)</span>
                                        </h4>

                                        <div class="card-title-details d-flex align-items-center">

                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <tbody>

                                                    <?php
                                                    $ig_counter = 0;
                                                    foreach ($value['page_list'] as $page_info) :
                                                        ?>
                                                        <?php if (isset($page_info['has_instagram']) && $page_info['has_instagram'] == '1') : ++$ig_counter; ?>
                                                        <tr>
                                                            <td class="width-100 p-0">
                                                                <div class="avatar bg-rgba-primary p-25 ml-0">
                                                                    <img class="img-fluid img_fb_onerror"
                                                                         onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';"
                                                                         src="<?php echo $page_info['page_profile']; ?>"
                                                                         alt="img placeholder"
                                                                         height="70" width="70">
                                                                </div>
                                                            </td>
                                                            <td class="pl-0">
                                                                <div>
                                                                    <a target="_BLANK"
                                                                       href="https://www.instagram.com/<?php echo $page_info['insta_username']; ?>">
                                                                        <h5 class="font-small-3 bold"><?php echo $page_info['insta_username']; ?></h5>
                                                                    </a>
                                                                    <div class="font-small-1"><?php echo $this->lang->line('Media'); ?>
                                                                        :
                                                                        <span id="media_count_<?php echo $page_info['id']; ?>"><?php echo custom_number_format($page_info['insta_media_count']); ?>
                                                                    </div>
                                                                    <div class="font-small-1"><?php echo $this->lang->line('Followers'); ?>
                                                                        :
                                                                        <span id="follower_count_<?php echo $page_info['id']; ?>"><?php echo custom_number_format($page_info['insta_followers_count']); ?>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="width-40-per ">
                                                                <div class="float-right">
                                                                    <!--                                                                                                TODO: check for addon if exist-->
                                                                    <?php if (file_exists(APPPATH . 'modules/n_igstats/controllers/N_igstats.php')) { ?>
                                                                        <a style="margin-top:10px;margin-right:5px;"
                                                                           href="<?php echo base_url(); ?>n_igstats/user_insight/<?php echo $page_info['id']; ?>"
                                                                           target="_blank"
                                                                           class="btn-circle btn btn-outline-success"
                                                                           table_id="<?php echo $page_info['id']; ?>"
                                                                           title="<?php echo $this->lang->line("Data analytics"); ?>"
                                                                           data-placement="right"
                                                                           data-toggle="tooltip">
                                                                            <i class="bx bx-stats"></i>
                                                                        </a>

                                                                    <?php } ?> <a
                                                                            style="margin-top:10px;margin-right:5px;"
                                                                            href="#"
                                                                            class="btn-circle btn btn-outline-success update_account"
                                                                            table_id="<?php echo $page_info['id']; ?>"
                                                                            title="<?php echo $this->lang->line("Update account info"); ?>"
                                                                            data-placement="right"
                                                                            data-toggle="tooltip">
                                                                        <i class="bx bx-sync"></i>
                                                                    </a>


                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                    <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>


                                    </div>
                                </div>

                                    <div role="tabpanel" class="tab-pane" id="vertical-pill_groups-<?php echo $value['userinfo_table_id']; ?>"
                                         aria-labelledby="stacked-pill_instagram-<?php echo $value['userinfo_table_id']; ?>"
                                         aria-expanded="true">
                                        <div class="widget-earnings-scroll table-responsive">
                                            <h4 class="card-title"><?php echo $this->lang->line('Group List') ?>
                                                <span class="text-muted">(<?php echo count($value['group_list']); ?> <?php echo $this->lang->line("groups"); ?>)</span>
                                            </h4>
                                            <?php if ($this->config->item('facebook_poster_group_enable_disable') == '1') : ?>
                                                <div class="card-title-details d-flex align-items-center">

                                                    <div class="table-responsive">
                                                        <table class="table table-borderless">
                                                            <tbody>

                                                            <?php foreach ($value['group_list'] as $group_info) : ?>
                                                                <tr>
                                                                    <td class="width-100 p-0">
                                                                        <div class="avatar bg-rgba-primary p-25 ml-0">
                                                                            <img class="img-fluid img_fb_onerror"
                                                                                 onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';"
                                                                                 src="<?php echo $group_info['group_profile']; ?>"
                                                                                 alt="img placeholder"
                                                                                 height="70" width="70">
                                                                        </div>
                                                                    </td>
                                                                    <td class="pl-0">
                                                                        <div>
                                                                            <a target="_BLANK"
                                                                               href="https://facebook.com/<?php echo $group_info['group_id']; ?>">
                                                                                <h5 class="font-small-3 bold"><?php echo $group_info['group_name']; ?></h5>
                                                                            </a>
                                                                            <div class="font-small-1"> <?php echo $this->lang->line('Group ID'); ?>
                                                                                : <?php echo $group_info['group_id']; ?></div>

                                                                        </div>
                                                                    </td>
                                                                    <td class="width-40-per ">
                                                                        <div class="float-right">
                                                                            <a style="margin-top:10px;margin-right:5px;"
                                                                               href="#"
                                                                               class="btn-circle btn btn-outline-danger group_delete"
                                                                               table_id="<?php echo $group_info['id']; ?>"
                                                                               title="<?php echo $this->lang->line("Do you want to remove this group from our database?"); ?>"
                                                                               data-placement="left"
                                                                               data-toggle="tooltip">
                                                                                <i class="bx bx-trash-alt"></i>
                                                                            </a>

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>


                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane <?php if ($i == 0) {echo 'active';} ?>" id="vertical-pill_facebook-<?php echo $value['userinfo_table_id']; ?>"
                                         aria-labelledby="stacked-pill_facebook-<?php echo $value['userinfo_table_id']; ?>"
                                         aria-expanded="true">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-xl-12 dashboard-earning-swiper"
                                                 id="widget-earnings">
                                                <!-- earnings swiper starts -->

                                                <div class="widget-earnings-scroll table-responsive ps">
                                                    <h4 class="card-title"><?php echo $this->lang->line('Page List') ?>
                                                        <span class="text-muted">(<?php echo count($value['page_list']); ?> <?php echo $this->lang->line("pages"); ?>)</span>
                                                    </h4>

                                                    <div class="card-title-details d-flex align-items-center">

                                                        <div class="table-responsive">
                                                            <table class="table table-borderless">
                                                                <tbody>
                                                                <?php foreach ($value['page_list'] as $page_info) : ?>
                                                                    <tr>
                                                                        <td class="width-100 p-0">
                                                                            <div class="avatar bg-rgba-primary p-25 ml-0">
                                                                                <img class="img-fluid img_fb_onerror"
                                                                                     onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';"
                                                                                     src="<?php echo $page_info['page_profile']; ?>"
                                                                                     alt="img placeholder"
                                                                                     height="70" width="70">
                                                                            </div>
                                                                        </td>
                                                                        <td class="pl-0">
                                                                            <div>
                                                                                <a target="_BLANK"
                                                                                   href="<?php echo base_url('messenger_bot_analytics/result/') . $page_info['id']; ?>">
                                                                                    <h5 class="font-small-3 bold"><?php echo $page_info['page_name']; ?></h5>
                                                                                </a>
                                                                                <div class="font-small-1"><?php echo $this->lang->line('email'); ?>
                                                                                    : <?php echo $page_info['page_email']; ?></div>
                                                                                <div class="font-small-1"> <?php echo $this->lang->line('Page ID'); ?>
                                                                                    : <a target="_BLANK"
                                                                                         href="https://facebook.com/<?php echo $page_info['page_id']; ?>"><?php echo $page_info['page_id']; ?></a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td class="width-40-per ">
                                                                            <div class="float-right">
                                                                                <?php if ($page_info['bot_enabled'] == '1') : ?>
                                                                                    <button style="margin-top:10px;margin-right:5px;"
                                                                                            class="btn-sm btn btn-circle btn-outline-danger delete_full_bot"
                                                                                            bot-enable="<?php echo $page_info['id']; ?>"
                                                                                            id="bot-<?php echo $page_info['id']; ?>"
                                                                                            already_disabled="no"
                                                                                            title="<?php echo $this->lang->line("Delete Bot Connection & all settings."); ?>"
                                                                                            data-placement="right"
                                                                                            data-toggle="tooltip">
                                                                                        <i class="bx bxs-eraser"></i>
                                                                                    </button>
                                                                                <?php elseif ($page_info['bot_enabled'] == '2'): ?>
                                                                                    <button style="margin-top:10px;margin-right:5px;"
                                                                                            class="btn-sm btn btn-circle btn-outline-danger delete_full_bot"
                                                                                            bot-enable="<?php echo $page_info['id']; ?>"
                                                                                            id="bot-<?php echo $page_info['id']; ?>"
                                                                                            already_disabled="yes"
                                                                                            title="<?php echo $this->lang->line("Delete Bot Connection & all settings."); ?>"
                                                                                            data-placement="right"
                                                                                            data-toggle="tooltip">
                                                                                        <i class="bx bxs-eraser"></i>
                                                                                    </button>
                                                                                <?php endif; ?>

                                                                                <?php if ($page_info['bot_enabled'] == '0') : ?>
                                                                                    <button style="margin-top:10px;margin-right:5px;"
                                                                                            restart='0'
                                                                                            bot-enable="<?php echo $page_info['id']; ?>"
                                                                                            id="bot-<?php echo $page_info['id']; ?>"
                                                                                            class="btn btn-sm btn-outline-primary btn-circle enable_webhook"
                                                                                            title="<?php echo $this->lang->line("Enable Bot Connection"); ?>"
                                                                                            data-placement="left"
                                                                                            data-toggle="tooltip">
                                                                                        <i class="bx bx-plug"></i>
                                                                                    </button>
                                                                                <?php elseif ($page_info['bot_enabled'] == '1') : ?>
                                                                                    <button style="margin-top:10px;margin-right:5px;"
                                                                                            restart='0'
                                                                                            bot-enable="<?php echo $page_info['id']; ?>"
                                                                                            id="bot-<?php echo $page_info['id']; ?>"
                                                                                            class="btn btn-sm btn-outline-dark btn-circle disable_webhook"
                                                                                            title="<?php echo $this->lang->line("Disable Bot Connection"); ?>"
                                                                                            data-placement="left"
                                                                                            data-toggle="tooltip">
                                                                                        <i class="bx bx-toggle-left"></i>
                                                                                    </button>
                                                                                <?php else : ?>
                                                                                    <button style="margin-top:10px;margin-right:5px;"
                                                                                            restart='1'
                                                                                            bot-enable="<?php echo $page_info['id']; ?>"
                                                                                            id="bot-<?php echo $page_info['id']; ?>"
                                                                                            class="btn btn-sm btn-outline-primary btn-circle enable_webhook"
                                                                                            title="<?php echo $this->lang->line("Re-start Bot Connection"); ?>"
                                                                                            data-placement="left"
                                                                                            data-toggle="tooltip">
                                                                                        <i class="bx bx-toggle-right"></i>
                                                                                    </button>
                                                                                <?php endif; ?>

                                                                                <?php if ($page_info['bot_enabled'] == 1) : ?>
                                                                                    <button style="margin-top:10px;margin-right:5px;"
                                                                                            class="btn-sm btn btn-outline-danger btn-circle right-button disabled"
                                                                                            table_id="<?php echo $page_info['id']; ?>"
                                                                                            title="<?php echo $this->lang->line("To enable delete button, first disable bot connection."); ?>"
                                                                                            data-placement="right"
                                                                                            data-toggle="tooltip">
                                                                                        <i class="bx bx-trash-alt"></i>
                                                                                    </button>
                                                                                <?php else : ?>
                                                                                    <button style="margin-top:10px;margin-right:5px;"
                                                                                            class="btn-sm btn btn-outline-danger btn-circle page_delete"
                                                                                            table_id="<?php echo $page_info['id']; ?>"
                                                                                            title="<?php echo $this->lang->line("Delete this page from database."); ?>"
                                                                                            data-placement="right"
                                                                                            data-toggle="tooltip">
                                                                                        <i class="bx bx-trash-alt"></i>
                                                                                    </button>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>


                                                    </div>

                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <?php $i++; endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <?php
    $fb_login_button = str_replace("ThisIsTheLoginButtonForFacebook", $this->lang->line("Login with Facebook"), $fb_login_button);
    $fb_login_button = str_replace('fab fa-facebook', 'bx bxl-facebook-square', $fb_login_button);
    ?>
    <div class="card text-center" id="nodata">
        <div class="card-body">
            <div class="empty-state">
                <img class="img-flud img_fb_onerror"
                     onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';"
                     style="height: 200px"
                     src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
                <h2 class="mt-0"><?php echo $this->lang->line("You haven not connected any account yet.") ?></h2>
                <br/>
                <h4>
                    <div class="text-center">
                        <p style="max-width: 250px; margin: 0 auto;" data-toggle="tooltip" data-placement="bottom"
                           title="<?php echo $this->lang->line("you must be logged in your facebook account for which you want to refresh your access token. for synch your new page, simply refresh your token. if any access token is restricted for any action, refresh your access token."); ?>"> <?php if ($this->config->item('developer_access') != '1') echo $fb_login_button; ?></p>
                    </div>
                </h4>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade" id="delete_confirmation" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close"><i
                            class="bx bx-x"></i></button>
                <h4 class="modal-title text-center"><i
                            class="bx bx-flag"></i> <?php echo $this->lang->line("Deletion Report") ?></h4>
            </div>
            <div class="modal-body" id="delete_confirmation_body">

            </div>
        </div>
    </div>
</div>

<?php

$doyouwanttodelete = $this->lang->line("Do you want to delete this group from database?");
$ifyoudeletethispage = $this->lang->line("If you delete this page, all the campaigns corresponding to this page will also be deleted. Do you want to delete this page from database?");
$ifyoudeletethisaccount = $this->lang->line("If you delete this account, all the pages, groups and all the campaigns corresponding to this account will also be deleted form database. do you want to delete this account from database?");
$facebooknumericidfirst = $this->lang->line("Please enter your facebook numeric id first");
$ifyoudeletethisgroup = $this->lang->line("If you delete this group, all the campaigns corresponding to this group will also be deleted. Do you want to delete this group from database?");

?>






