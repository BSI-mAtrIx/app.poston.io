<div class="modal fade" id="create_campaign" role="dialog" aria-labelledby="create_campaign" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $this->lang->line('Create campaign'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-12">
                        <fieldset class="form-group">
                            <label for="basicInput"><?php echo $this->lang->line('ad_campaign_name'); ?>
                                <em>(<?php echo $this->lang->line('required'); ?>)</em></label>
                            <p><?php echo $this->lang->line('add_name_ad_campaign'); ?></p>
                            <input min="1" required type="text" class="form-control ads-campaign-name"
                                   name="ads_crt_campaign_name"
                                   placeholder="<?php echo $this->lang->line('enter_campaign_name'); ?>">
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('campaign_objective'); ?></h6>
                        <p><?php echo $this->lang->line('campaign_objective_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control ads-campaign-objective-list select2"
                                    name="ads_crt_campaign_objective">
                                <option value="LINK_CLICKS"><?php echo $this->lang->line('link_clicks'); ?></option>
                                <option value="POST_ENGAGEMENT"><?php echo $this->lang->line('post_engagement'); ?></option>
                                <option value="PAGE_LIKES"><?php echo $this->lang->line('page_likes'); ?></option>
                                <option value="MESSAGES"><?php echo $this->lang->line('MESSAGES'); ?></option>
                                <?php if($n_ad_config['ads_video_size']>0){ ?>
                                <option value="VIDEO_VIEWS"><?php echo $this->lang->line('facebook_ads_video_views'); ?></option>
                                <?php } ?>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('campaign_status'); ?></h6>
                        <p><?php echo $this->lang->line('select_campaign_status'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control ads-campaign-status select2" name="ads_crt_campaign_status">
                                <option value="ACTIVE"><?php echo $this->lang->line('active'); ?></option>
                                <option value="PAUSED"><?php echo $this->lang->line('paused'); ?></option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('special_ad_category'); ?></h6>
                        <p><?php echo $this->lang->line('special_ad_category_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control special-ad-category select2" name="ads_crt_campaign_special">
                                <option value="NONE"><?php echo $this->lang->line('none'); ?></option>
                                <option value="HOUSING"><?php echo $this->lang->line('housing'); ?></option>
                                <option value="CREDIT"><?php echo $this->lang->line('credit'); ?></option>
                                <option value="EMPLOYMENT"><?php echo $this->lang->line('employment'); ?></option>

                            </select>
                        </fieldset>
                    </div>

                    <div class="col-6 d-none">
                        <fieldset class="form-group">
                            <label for="cpg_start_time"><?php echo $this->lang->line('Start date campaign'); ?> <a href="#" class="ml-1 clear_date" data-field="#cpg_start_time"><i class="bx bx-x"></i></a></label>
                            <input type="text" class="form-control cpg_start_time" id="cpg_start_time" name="cpg_start_time">
                        </fieldset>
                    </div>
                    <div class="col-6 d-none">
                        <fieldset class="form-group">
                            <label for="cpg_end_time"><?php echo $this->lang->line('End date campaign'); ?> <a href="#" class="ml-1 clear_date" data-field="#cpg_end_time"><i class="bx bx-x"></i></a></label>
                            <input type="text" class="form-control cpg_start_time" id="cpg_end_time" name="cpg_end_time">
                        </fieldset>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line('Close'); ?></span>
                </button>
                <button id="mod_create_campaign" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line('Create campaign'); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create_adset" role="dialog" aria-labelledby="create_adset" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $this->lang->line('Create AD Set'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <input type="hidden" value="" id="adset_cpg_id"/>
                    <input type="hidden" value="" id="ad_objective"/>

                    <div class="col-12" id="adset_cpg_show" style="display: none;">
                        <h6><?php echo $this->lang->line('ad_campaign'); ?></h6>
                        <p><?php echo $this->lang->line('ad_campaign_description'); ?></p>
                        <div class="form-group">
                            <select class="form-control" id="adset_select_ad_campaign" name="adset_select_ad_campaign">
                                <option></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-8">
                        <fieldset class="form-group">
                            <label for="basicInput"><?php echo $this->lang->line('ad_set_name'); ?>
                                <em>(<?php echo $this->lang->line('required'); ?>)</em></label>
                            <p><?php echo $this->lang->line('ad_set_name_description'); ?></p>
                            <input type="text" class="form-control ads_adset_name" name="ads_adset_name"
                                   id="ads_adset_name"
                                   placeholder="<?php echo $this->lang->line('enter_ad_set_name'); ?>">
                        </fieldset>
                    </div>

                    <div class="col-4">
                        <h6 class="mb-3"><?php echo $this->lang->line('Ad Set Status'); ?></h6>
                        <fieldset class="form-group">
                            <select class="form-control ad-set-status select2" name="ad-set-status">
                                <option value="ACTIVE"><?php echo $this->lang->line('active'); ?></option>
                                <option value="PAUSED"><?php echo $this->lang->line('paused'); ?></option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-6">
                        <h6><?php echo $this->lang->line('optimization_goal'); ?></h6>
                        <p><?php echo $this->lang->line('optimization_goal_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control select2" name="ads_campaign_optimization_goal"
                                    id="ads_campaign_optimization_goal">
                                <option value="IMPRESSIONS"><?php echo $this->lang->line('impressions'); ?></option>
                                <option value="LINK_CLICKS"><?php echo $this->lang->line('link_clicks'); ?></option>
                                <option value="REACH"><?php echo $this->lang->line('daily_unique_reach'); ?></option>
                                <option value="THRUPLAY"><?php echo $this->lang->line('facebook_ads_thruplay'); ?></option>
                                <option value="TWO_SECOND_CONTINUOUS_VIDEO_VIEWS"><?php echo $this->lang->line('facebook_ads_two_2_second_continuous_video_views'); ?></option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-6">
                        <h6><?php echo $this->lang->line('billing_event'); ?></h6>
                        <p><?php echo $this->lang->line('billing_event_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control select2" name="billing_event_description"
                                    id="billing_event_description">
                                <option value="IMPRESSIONS"><?php echo $this->lang->line('impressions'); ?></option>
                            </select>
                        </fieldset>
                    </div>


                    <div class="col-12 sponsored_messages_hide">
                        <h6><?php echo $this->lang->line('placement'); ?></h6>
                        <p><?php echo $this->lang->line('description'); ?></p>

                        <div class="row">
                            <div class="col-4 card p-0 shadow-none">
                                <div class="card-body">
                                    <h5 class="card-title">Facebook</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input"
                                                           id="ad_set_placement_facebook_feeds" checked="checked"
                                                           value="ad-set-placement-facebook-feeds">
                                                    <label for="ad_set_placement_facebook_feeds"><?php echo $this->lang->line('feeds'); ?></label>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-4 card p-0 shadow-none">
                                <div class="card-body">
                                    <h5 class="card-title">Instagram</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input"
                                                           id="ad_set_placement_instagram_feed" checked="checked"
                                                           value="ad-set-placement-messenger-inbox">
                                                    <label for="ad_set_placement_instagram_feed"><?php echo $this->lang->line('feed'); ?></label>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-4 card p-0 shadow-none">
                                <div class="card-body">
                                    <h5 class="card-title">Messenger</h5>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <fieldset>
                                                <div class="checkbox">
                                                    <input type="checkbox" class="checkbox-input"
                                                           id="ad_set_placement_messenger_inbox" checked="checked"
                                                           value="ad-set-placement-instagram-feed">
                                                    <label for="ad_set_placement_messenger_inbox"><?php echo $this->lang->line('inbox'); ?></label>
                                                </div>
                                            </fieldset>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row width-100p pl-1 pr-1">
                        <div class="col-6">
                            <p><?php echo $this->lang->line('Include Custom Audience'); ?></p>
                            <fieldset class="form-group">
                                <select class="form-control" name="ad_set_custom_audience_include_list"
                                        id="ad_set_custom_audience_include_list">
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-6">
                            <p><?php echo $this->lang->line('Exclude Custom Audience'); ?></p>
                            <fieldset class="form-group">
                                <select class="form-control" name="ad_set_custom_audience_exclude_list"
                                        id="ad_set_custom_audience_exclude_list">
                                </select>
                            </fieldset>
                        </div>
                    </div>

                    <div class="col-12">
                        <fieldset class="form-group">
                            <label for="basicInput"><?php echo $this->lang->line('target_cost'); ?>
                                (<?php echo $this->lang->line('min_target_cost'); ?> <span
                                        class="ad_set_target_cost"></span>)</label>
                            <p><?php echo $this->lang->line('target_cost_description'); ?></p>
                            <input type="text" class="form-control ads_adset_target_cost" id="ads_adset_target_cost"
                                   name="ads_adset_target_cost"
                                   placeholder="<?php echo $this->lang->line('enter_ad_set_target_cost'); ?>">
                        </fieldset>
                    </div>

                    <div class="col-4">
                        <h6 class="mb-3"><?php echo $this->lang->line('Ad Set Budget'); ?></h6>
                        <fieldset class="form-group">
                            <select class="form-control ad-set-budget select2" name="ad-set-budget" id="ads_adset_daily_budge_set">
                                <option value="daily"><?php echo $this->lang->line('Daily budget'); ?></option>
                                <option value="lifetime"><?php echo $this->lang->line('Lifetime budget'); ?></option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-8" id="ad_set_daily_budget_show">
                        <fieldset class="form-group">
                            <label for="ads_adset_daily_budget"><?php echo $this->lang->line('daily_budget'); ?>
                                (<?php echo $this->lang->line('min_daily_budget'); ?> <span
                                        class="ad_set_daily_budget"></span>)</label>
                            <p><?php echo $this->lang->line('daily_budget_description'); ?></p>
                            <input type="text" class="form-control ads_adset_daily_budget" name="ads_adset_daily_budget"
                                   id="ads_adset_daily_budget"
                                   placeholder="<?php echo $this->lang->line('enter_ad_set_daily_budget'); ?>">
                        </fieldset>
                    </div>

                    <div class="col-8" id="ad_set_lifetime_budget_show" style="display:none;">
                        <fieldset class="form-group">
                            <label for="ads_adset_lifetime_budget"><?php echo $this->lang->line('Lifetime Budget'); ?></label>
                            <p><?php echo $this->lang->line('The lifetime budget of the set defined in your account currency.'); ?></p>
                            <input type="text" class="form-control ads_adset_lifetime_budget" name="ads_adset_lifetime_budget"
                                   id="ads_adset_lifetime_budget"
                                   placeholder="<?php echo $this->lang->line('Enter the Ad Set`s lifetime budget'); ?>">
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('countries'); ?> <span class="ad_set_default_country"></span>
                        </h6>
                        <p><?php echo $this->lang->line('select_countries_supported'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control countries-list" id="ad_set_default_country"
                                    name="ad_set_default_country[]">

                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('regions'); ?></h6>
                        <p><?php echo $this->lang->line('regions_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="select_regions" id="select_regions" name="select_regions[]">

                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('cities'); ?></h6>
                        <p><?php echo $this->lang->line('cities_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control select2 select_cities" id="select_cities"
                                    name="select_cities[]">

                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('optimization_goal'); ?></h6>
                        <p><?php echo $this->lang->line('optimization_goal_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control select2" name="ads_campaign_ad_genders[]"
                                    id="ads_campaign_ad_genders" multiple>
                                <option value="female" selected><?php echo $this->lang->line('female'); ?></option>
                                <option value="male" selected><?php echo $this->lang->line('male'); ?></option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('age'); ?>
                            <span><em>(<?php echo $this->lang->line('default_age_any'); ?>)</em></span></h6>
                        <p><?php echo $this->lang->line('age_description'); ?></p>

                        <div class="row">
                            <div class="col-6">
                                <p><?php echo $this->lang->line('age_from'); ?></p>
                                <fieldset class="form-group">
                                    <select class="form-control select2" name="ads_campaign_age_from_list"
                                            id="ads_campaign_age_from_list">
                                        <option value="any"><?php echo $this->lang->line('any'); ?></option>
                                        <?php
                                        foreach (range(18, 65) as $number) {
                                            echo '<option value="' . $number . '">' . $number . '</option>';
                                        }
                                        ?>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-6">
                                <p><?php echo $this->lang->line('age_to'); ?></p>
                                <fieldset class="form-group">
                                    <select class="form-control select2" name="ads_campaign_age_to_list"
                                            id="ads_campaign_age_to_list">
                                        <option value="any"><?php echo $this->lang->line('any'); ?></option>
                                        <?php
                                        foreach (range(18, 71) as $number) {
                                            echo '<option value="' . $number . '">' . $number . '</option>';
                                        }
                                        ?>
                                    </select>
                                </fieldset>
                            </div>
                        </div>

                    </div>

                    <div class="col-12 sponsored_messages_hide">
                        <h6><?php echo $this->lang->line('device_types'); ?></h6>
                        <p><?php echo $this->lang->line('device_types_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control select2" name="ads_campaign_select_type[]"
                                    id="ads_campaign_select_type" multiple>
                                <option value="mobile" selected><?php echo $this->lang->line('mobile'); ?></option>
                                <option value="desktop" selected><?php echo $this->lang->line('desktop'); ?></option>
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12" id="adset_page_for_likes">
                        <h6><?php echo $this->lang->line('select_facebook_page'); ?></h6>
                        <p><?php echo $this->lang->line('select_facebook_page_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control select2" name="adset_creation_filter_fb_pages[]"
                                    id="adset_creation_filter_fb_pages" multiple>

                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('detailed_targeting'); ?></h6>
                        <p><?php echo $this->lang->line('detailed_targeting_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control select2" id="search_for_targeting_suggestions"
                                    name="search_for_targeting_suggestions[]" multiple>

                            </select>
                        </fieldset>
                    </div>

                    <div class="col-6">
                        <fieldset class="form-group">
                            <label for="adset_start_time"><?php echo $this->lang->line('Start date ad set'); ?> <a href="#" class="ml-1 clear_date" data-field="#adset_start_time"><i class="bx bx-x"></i></a></label>
                            <input type="text" class="form-control adset_start_time" id="adset_start_time" name="adset_start_time">
                        </fieldset>
                    </div>
                    <div class="col-6">
                        <fieldset class="form-group">
                            <label for="adset_end_time"><?php echo $this->lang->line('End date ad set'); ?> <a href="#" class="ml-1 clear_date" data-field="#adset_end_time"><i class="bx bx-x"></i></a></label>
                            <input type="text" class="form-control adset_end_time" id="adset_end_time" name="adset_end_time">
                        </fieldset>
                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line('Close'); ?></span>
                </button>
                <button id="mod_create_adset" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line('Create Ad Set'); ?></span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pixel-new-coversion" tabindex="-1" role="dialog" aria-labelledby="pixel-new-coversion-tab"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <?php
        echo form_open('#', array('class' => 'facebook-ads-create-pixel-conversion',
                //'data-csrf' => $this->security->get_csrf_token_name()
            )
        );
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $this->lang->line('create_pixel_coversion'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <fieldset class="form-group">
                            <label for="basicInput"><?php echo $this->lang->line('conversion_name'); ?></label>
                            <p><?php echo $this->lang->line('conversion_name_description'); ?></p>
                            <input type="text" class="form-control" name="ads_pixel_conversion_name"
                                   id="ads_pixel_conversion_name"
                                   placeholder="<?php echo $this->lang->line('enter_conversion_name'); ?>" required>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <fieldset class="form-group">
                            <label for="basicInput"><?php echo $this->lang->line('conversion_url'); ?></label>
                            <p><?php echo $this->lang->line('conversion_url_description'); ?></p>
                            <input type="text" class="form-control" name="ads_pixel_conversion_url"
                                   id="ads_pixel_conversion_url"
                                   placeholder="<?php echo $this->lang->line('enter_conversion_url'); ?>" required>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('conversion_type'); ?></h6>
                        <p><?php echo $this->lang->line('conversion_type_description'); ?></p>
                        <fieldset class="form-group">
                            <select class="form-control select2" name="ads_select_conversion_type"
                                    id="ads_select_conversion_type">
                                <option><?php echo $this->lang->line('select_type'); ?></option>
                                <option value="CONTENT_VIEW"><?php echo $this->lang->line('view_content'); ?></option>
                                <option value="SEARCH"><?php echo $this->lang->line('search'); ?></option>
                                <option value="ADD_TO_CART"><?php echo $this->lang->line('add_to_cart'); ?></option>

                                <option value="ADD_TO_WISHLIST"><?php echo $this->lang->line('add_to_wishlist'); ?></option>
                                <option value="INITIATED_CHECKOUT"><?php echo $this->lang->line('initiate_checkout'); ?></option>
                                <option value="ADD_PAYMENT_INFO"><?php echo $this->lang->line('add_payment_info'); ?></option>
                                <option value="PURCHASE"><?php echo $this->lang->line('purchase'); ?></option>
                                <option value="LEAD"><?php echo $this->lang->line('lead'); ?></option>
                                <option value="COMPLETE_REGISTRATION"><?php echo $this->lang->line('complete_registration'); ?></option>

                            </select>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line('Close'); ?></span>
                </button>
                <button id="ads_pixel_save_conversion" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line('save_conversion'); ?></span>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="new_custom_audiences_modal" tabindex="-1" role="dialog" aria-labelledby="new_custom_audiences_modal"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <?php
        echo form_open('#', array('class' => 'facebook-ads-create-custom-audiences',
                //'data-csrf' => $this->security->get_csrf_token_name()
            )
        );
        ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $this->lang->line('Create custom audiences'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="custom_audience_step_one">
                    <div class="col-12">
                        <fieldset class="form-group">
                            <label for="basicInput"><?php echo $this->lang->line('Custom Audience Name'); ?></label>
                            <input type="text" class="form-control" name="ads_custom_audience_name"
                                   id="ads_custom_audience_name"
                                   placeholder="<?php echo $this->lang->line('Enter Custom Audience Name'); ?>" required>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <fieldset class="form-group">
                            <label for="basicInput"><?php echo $this->lang->line('Custom Audience Description'); ?></label>
                            <input type="text" class="form-control" name="ads_custom_audience_description"
                                   id="ads_custom_audience_description"
                                   placeholder="<?php echo $this->lang->line('Enter Custom Audience Description'); ?>" required>
                        </fieldset>
                    </div>

                    <div class="col-12">
                        <h6><?php echo $this->lang->line('Create Custom Audience from:'); ?></h6>
                        <fieldset class="form-group">
                            <select class="form-control select2" name="ads_custom_audience_source"
                                    id="ads_custom_audience_source">
                                <option><?php echo $this->lang->line('select_type'); ?></option>
                                <option value="messenger_subscribers_id"><?php echo $this->lang->line('Messenger Subscribers ID'); ?></option>
                                <?php if(file_exists(APPPATH.'modules/n_wa/controllers/N_wa.php')){ ?>
                                    <option value="whatsapp_phone_numbers"><?php echo $this->lang->line('WhatsApp Phone Numbers'); ?></option>
                                <?php } ?>
                                <?php if(file_exists(APPPATH.'modules/n_telegram/controllers/N_telegram.php')){ ?>
                                    <option value="telegram_phone_numbers"><?php echo $this->lang->line('Telegram Phone Numbers'); ?></option>
                                <?php } ?>

                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12" id="ads_custom_audience_source_bot_div" style="display: none;">
                        <h6><?php echo $this->lang->line('Select bot from selected source'); ?></h6>
                        <fieldset class="form-group">
                            <select class="form-control select2" name="ads_custom_audience_source_bot"
                                    id="ads_custom_audience_source_bot">
                            </select>
                        </fieldset>
                    </div>

                    <div class="col-12" id="ads_custom_audience_source_labels_div" style="display: none;">
                        <h6><?php echo $this->lang->line('Select labels from selected source'); ?></h6>
                        <fieldset class="form-group">
                            <select class="form-control select2" name="ads_custom_audience_source_labels"
                                    id="ads_custom_audience_source_labels">
                            </select>
                        </fieldset>
                    </div>


                </div>
                <div class="row" id="custom_audience_step_two" style="display: none;">
                    <div class="col-12">
                        <h6><?php echo $this->lang->line('Do not close this window until process done.'); ?></h6>
                        <div class="progress progress-bar-primary mb-1">
                            <div id="custom_audience_current_progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                        </div>
						<p id="custom_audience_progress_unhide" style="margin: 10px auto; display:none;"><span id="custom_audience_current_value"></span> / <span id="custom_audience_total_value"></span></p>
                    </div>
                </div>
                <div class="row" id="custom_audience_step_three" style="display: none;">
                    <div class="col-12">
                        <h6><?php echo $this->lang->line('Creating custom audiences done. You can close now this window.'); ?></h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line('Close'); ?></span>
                </button>
                <button id="ads_custom_audience_save_batch" type="button" class="btn btn-primary ml-1">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block"><?php echo $this->lang->line('Save custom audience'); ?></span>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php
if($content_generator){
    include(APPPATH.'modules/n_generator/include/modal_message_universal.php');
}
?>