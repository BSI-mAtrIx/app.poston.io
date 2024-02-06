<div class="card">

    <div class="card-header border-bottom">
        <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Blogger'); ?></h4>
    </div>

    <div class="card-body makeScroll_1 account_div_height p-0">
        <div class="row multi_layout pills-stacked p-0">
            <div class="col-md-4 col-sm-12 p-0">
                <ul class="nav nav-pills flex-column text-center text-md-left">
                    <?php $i = 0; ?>
                    <?php foreach ($blogger_account_list as $key => $single_account): ?>

                        <li class="nav-item blogger_accounts_list media p-0 <?php if ($i == 0) echo "force_active"; ?>"
                            style="margin-bottom: 0 !important;" blogger_id="<?php echo $single_account['id']; ?>">
                            <a class="nav-link active" id="stacked-b-<?php echo $single_account['id'] ?>"
                               data-toggle="pill" href="#b_account_tab-<?php echo $single_account['id'] ?>"
                               aria-expanded="true">
                                <div class="card-title-details d-flex align-items-center">
                                    <div class="avatar bg-rgba-primary p-25 ml-0">
                                        <img class="" src="<?php echo $single_account['picture']; ?>"
                                             alt="img placeholder" height="60" width="60">
                                    </div>
                                    <div>
                                        <h4 class="font-small-3 white bold"><?php echo $single_account['name']; ?></h4>
                                        <div class="font-small-1"><?php echo $key; ?></div>
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
                    <?php foreach ($blogger_account_list as $single_account): ?>

                        <div class="tab-pane blogger_account_tab"
                             id="b_account_tab-<?php echo $single_account['id'] ?>">
                            <div class="card main_card">

                                <div class="card-header border-bottom  pt-0 mt-0">
                                    <input type="text" class="form-control float-right search_blog_list"
                                           onkeyup="search_in_ul(this,'blog_list_ul')"
                                           placeholder="<?php echo $this->lang->line("Search..."); ?>"
                                           style="width:60%">
                                    <div class="heading-elements">
                                        <fieldset>
                                            <div class="checkbox">
                                                <input type="checkbox"
                                                       class="checkbox-input select_all_blogger_blog select_all_facebook_page"
                                                       id="select_blogger_accounts_all_blogs-<?php echo $single_account['id']; ?>"
                                                       blogger_id="<?php echo $single_account['id']; ?>">
                                                <label for="select_blogger_accounts_all_blogs-<?php echo $single_account['id']; ?>"
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
                                            <?php if (count($single_account['blog_info']) > 0): ?>

                                                <?php foreach ($single_account['blog_info'] as $single_blog): ?>
                                                    <?php $img_src = base_url('assets/images/blogger.jpg'); ?>
                                                    <tr>
                                                        <td class="width-50 p-0 text-center">
                                                            <fieldset>
                                                                <div class="checkbox">

                                                                    <input type="checkbox"
                                                                           class="checkbox-input single_blogger_blog-<?php echo $single_account['id']; ?>"
                                                                           name="blogger_blogs[]"
                                                                           id="blogger_cbx-<?php echo $i; ?>"
                                                                           value="blogger_blog_info-<?php echo $single_blog['table_id']; ?>"
                                                                        <?php
                                                                        if (($post_action == 'edit' || $post_action == 'clone') && count($campaigns_social_media) > 0) {
                                                                            $temp = "blogger_blog_info-" . $single_blog['table_id'];
                                                                            if (in_array($temp, $campaigns_social_media)) {
                                                                                echo "checked";
                                                                            }
                                                                        }
                                                                        ?> >

                                                                    <label for="blogger_cbx-<?php echo $i; ?>"></label>
                                                                </div>
                                                            </fieldset>
                                                        </td>
                                                        <td class="width-15-per p-0">
                                                            <div class="avatar bg-rgba-primary p-25 ml-0">
                                                                <img class="img-fluid" src="<?php echo $img_src; ?>"
                                                                     alt="img placeholder" height="60" width="60">
                                                            </div>
                                                        </td>
                                                        <td class="pl-0">
                                                            <div>
                                                                <h5 class="font-small-3 bold"><?php echo $single_blog['blog_name']; ?></h5>
                                                                <div class="font-small-2"><?php echo $single_blog['blog_id'] ?></div>
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