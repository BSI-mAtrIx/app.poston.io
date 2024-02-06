<div class="card">

    <div class="card-header border-bottom">
        <h4 class="card-title d-flex align-items-center"><?php echo $this->lang->line('Linkedin'); ?></h4>
        <div class="heading-elements" style="top:20px;">
            <fieldset>
                <div class="checkbox">
                    <input type="checkbox" class="checkbox-input linkedin_all_account_select"
                           id="linkedin_all_account_select">
                    <label for="linkedin_all_account_select" title="<?php echo $this->lang->line("Select all"); ?>"
                           style="margin-top:10px;"><?php echo $this->lang->line("Select all"); ?></label>
                </div>
            </fieldset>
        </div>
    </div>

    <div class="card-body account_div_height">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tbody>
                <?php $i = 0; ?>
                <?php foreach ($linkedin_account_list as $single_account): ?>
                    <?php $img_src = $single_account['profile_pic']; ?>
                    <tr>
                        <td class="width-50 p-0 text-center">
                            <fieldset>
                                <div class="checkbox">
                                    <input type="checkbox" class="checkbox-input linkedin_single_user"
                                           name="linkedin_accounts[]" id="linkedin_single_user-<?php echo $i; ?>"
                                           value="linkedin_users_info-<?php echo $single_account['id'] ?>"
                                        <?php
                                        if (($post_action == 'edit' || $post_action == 'clone') && count($campaigns_social_media) > 0) {
                                            $temp = "linkedin_users_info-" . $single_account['id'];
                                            if (in_array($temp, $campaigns_social_media)) {
                                                echo "checked";
                                            }
                                        }
                                        ?>
                                    >
                                    <label class="" for="linkedin_single_user-<?php echo $i; ?>"></label>
                                </div>
                            </fieldset>

                        </td>
                        <td class="width-15-per p-0">
                            <div class="avatar bg-rgba-primary p-25 ml-0">
                                <img class="img-fluid" src="<?php echo $img_src; ?>" alt="img placeholder" height="70"
                                     width="70">
                            </div>
                        </td>
                        <td class="pl-0">
                            <div>
                                <h5 class="font-small-3 bold"><?php echo $single_account['name']; ?></h5>
                                <div class="font-small-2">@<?php echo $single_account['linkedin_id']; ?></div>
                            </div>
                        </td>
                    </tr>

                    <?php $i++; ?>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
