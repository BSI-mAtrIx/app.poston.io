<div class="card">

    <div class="card-header border-bottom">
        <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Facebook'); ?></h4>
    </div>

    <div class="card-body makeScroll_1 account_div_height p-0">
        <div class="row multi_layout pills-stacked p-0">
            <div class="col-md-4 col-sm-12 p-0">
                <ul class="nav nav-pills flex-column text-center text-md-left">
                    <?php $i = 0; ?>
                    <?php foreach ($facebook_account_list as $single_account): ?>

                        <li class="nav-item facebook_accounts_list media p-0 <?php if ($i == 0) echo "force_active"; ?>"
                            style="margin-bottom: 0 !important;" facebook_id="<?php echo $single_account['fb_id']; ?>">
                            <a class="nav-link active" id="stacked-fb--<?php echo $single_account['fb_id'] ?>"
                               data-toggle="pill" href="#account_tab-<?php echo $single_account['fb_id'] ?>"
                               aria-expanded="true">
                                <div class="card-title-details d-flex align-items-center">
                                    <div class="avatar bg-rgba-primary p-25 ml-0">
                                        <img class=""
                                             src="<?php echo "https://graph.facebook.com/me/picture?access_token=" . $single_account['user_access_token'] . "&amp;width=60&amp;height=60"; ?>"
                                             alt="img placeholder" height="60" width="60"
                                             onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';">
                                    </div>
                                    <div>
                                        <h4 class="font-small-3 white bold"><?php echo $single_account['name']; ?></h4>
                                        <div class="font-small-1"><?php echo $single_account['email']; ?></div>
                                    </div>

                                </div>
                            </a>
                        </li>

                        <?php $i++; ?>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="text-center facebook_waiting" style="display: none;">
                    <i class="bx bx-loader-alt bx-spin blue text-center" style="font-size: 50px;margin-top: 230px;"></i>
                </div>
                <?php $i = 1; ?>
                <div class="tab-content shadow-none p-0">
                    <?php foreach ($facebook_account_list as $single_account): ?>

                        <div class="tab-pane facebook_account_tab"
                             id="account_tab-<?php echo $single_account['fb_id'] ?>">
                            <div class="card main_card">

                                <div class="card-header border-bottom  pt-0 mt-0">
                                    <input type="text" class="form-control float-right search_page_list"
                                           onkeyup="search_in_table(this,'page_list_ul')"
                                           placeholder="<?php echo $this->lang->line("Search..."); ?>"
                                           style="width:60%">
                                    <div class="heading-elements">
                                        <fieldset>
                                            <div class="checkbox">
                                                <input type="checkbox"
                                                       class="checkbox-input select_facebook_accounts_all_pages select_all_facebook_page"
                                                       id="select_facebook_accounts_all_pages-<?php echo $single_account['fb_id']; ?>"
                                                       facebook_id="<?php echo $single_account['fb_id']; ?>">
                                                <label for="select_facebook_accounts_all_pages-<?php echo $single_account['fb_id']; ?>"
                                                       title="<?php echo $this->lang->line("Select all"); ?>"
                                                       style="margin-top:10px;"><?php echo $this->lang->line("Select all"); ?></label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-borderless" id="page_list_ul">
                                            <tbody>
                                            <?php if ($single_account['total_pages'] > 0): ?>
                                                <?php foreach ($single_account['page_list'] as $single_page): ?>
                                                    <?php $img_src = $single_page['page_profile']; ?>
                                                    <tr>
                                                        <td class="width-50 p-0 text-center">
                                                            <fieldset>
                                                                <div class="checkbox">

                                                                    <input type="checkbox"
                                                                           class="single_facebook_page-<?php echo $single_account['fb_id']; ?> checkbox-input "
                                                                           name="facebook_pages[]"
                                                                           id="facebook_cbx-<?php echo $i; ?>"
                                                                           value="facebook_rx_fb_page_info-<?php echo $single_page['id']; ?>"
                                                                        <?php
                                                                        if (($post_action == 'edit' || $post_action == 'clone') && count($campaigns_social_media) > 0) {
                                                                            $temp = "facebook_rx_fb_page_info-" . $single_page['id'];
                                                                            if (in_array($temp, $campaigns_social_media)) {
                                                                                echo "checked";
                                                                            }
                                                                        }
                                                                        ?> >

                                                                    <label for="facebook_cbx-<?php echo $i; ?>"></label>
                                                                </div>
                                                            </fieldset>
                                                        </td>
                                                        <td class="width-15-per p-0">
                                                            <div class="avatar bg-rgba-primary p-25 ml-0">
                                                                <img class="img-fluid" src="<?php echo $img_src; ?>"
                                                                     alt="img placeholder" height="60" width="60"
                                                                     onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';">
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <div>
                                                                <h5 class="font-small-3 bold"><?php echo $single_page['page_name']; ?></h5>
                                                                <?php if ($single_page['username'] != ''): ?>
                                                                    <div class="font-small-2"><?php echo $single_page['username'] ?></div>
                                                                <?php endif ?>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <?php $i++; ?>
                                                <?php endforeach ?>

                                            <?php endif ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>

                    <?php endforeach ?>


                </div>
            </div>
        </div>
    </div>
</div>
