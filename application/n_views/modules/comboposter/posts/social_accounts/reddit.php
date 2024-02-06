<div class="card">
    <div class="card-header border-bottom">
        <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Reddit'); ?></h4>
        <div class="heading-elements" style="top:20px;">
            <fieldset>
                <div class="checkbox">
                    <input type="checkbox" class="checkbox-input reddit_all_account_select"
                           id="reddit_all_account_select">
                    <label for="reddit_all_account_select" title="<?php echo $this->lang->line("Select all"); ?>"
                           style="margin-top:10px;"><?php echo $this->lang->line("Select all"); ?></label>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="card-body account_div_height">
        <div class="row">
            <div class="col-7 makeScroll_1">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($reddit_account_list as $single_account): ?>
                            <?php $img_src = $single_account['profile_pic']; ?>
                            <tr>
                                <td class="width-50 p-0 text-center">
                                    <fieldset>
                                        <div class="checkbox">
                                            <input type="checkbox" class="checkbox-input reddit_single_user"
                                                   name="reddit_accounts[]" id="reddit_single_user-<?php echo $i; ?>"
                                                   value="reddit_users_info-<?php echo $single_account['id'] ?>"
                                                <?php
                                                if (($post_action == 'edit' || $post_action == 'clone') && count($campaigns_social_media) > 0) {
                                                    $temp = "reddit_users_info-" . $single_account['id'];
                                                    if (in_array($temp, $campaigns_social_media)) {
                                                        echo "checked";
                                                    }
                                                }
                                                ?>
                                            >
                                            <label class="" for="reddit_single_user-<?php echo $i; ?>"></label>
                                        </div>
                                    </fieldset>

                                </td>
                                <td class="width-15-per p-0">
                                    <div class="avatar bg-rgba-primary p-25 ml-0">
                                        <img class="img-fluid" src="<?php echo $img_src; ?>" alt="img placeholder"
                                             height="70" width="70">
                                    </div>
                                </td>
                                <td class="pl-0">
                                    <div>
                                        <h5 class="font-small-3 bold"><?php echo $single_account['username']; ?></h5>
                                        <div class="font-small-2"><a
                                                    href="<?php echo 'https://www.reddit.com' . $single_account['url'] ?>"
                                                    target="_BLANK"><?php echo $this->lang->line("Visit Reddit"); ?></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <?php $i++; ?>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="col-5">

                <div class="form-group">
                    <label for="subreddits"><?php echo $this->lang->line('Please select at least one subreddit'); ?></label>
                    <?php
                    if ($post_action == 'edit' || $post_action == 'clone') {
                        $default_value = $campaign_form_info['subreddits'];
                    } else {
                        $default_value = '0';
                    }
                    echo form_dropdown('subreddits', $subreddits, $default_value, 'id="subreddits" class="form-control select2" style="width: 100%"');
                    ?>
                </div>

            </div>
        </div>

    </div>
</div>
