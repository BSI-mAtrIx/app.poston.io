<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 1;
$include_owlcar = 0;
$include_prism = 0;
?>

<div class="section-header">
    <h1>
        <i class="bx bx-bar-chartr"></i>
        <?php $fb_page_id = isset($page_info['page_id']) ? $page_info['page_id'] : ""; ?>
        <?php $page_auto_id = isset($page_info['id']) ? $page_info['id'] : 0; ?>
        <?php echo $this->lang->line("Page Analytics"); ?> :
        <a href="<?php echo "https://facebook.com/" . $fb_page_id; ?>"
           target="_BLANK"><?php echo isset($page_info['page_name']) ? $page_info['page_name'] : ""; ?></a>

    </h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item">
            <form method="POST" action="<?php echo base_url('page_analytics/analytics/' . $page_auto_id); ?>">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="bx bx-calendar"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control datepicker" value="<?php echo $from_date; ?>" id="from_date"
                           name="from_date" style="width:115px">
                    <input type="text" class="form-control datepicker" value="<?php echo $to_date; ?>" id="to_date"
                           name="to_date" style="width:115px">
                    <button class="btn btn-outline-primary" style="margin-left:1px" type="submit"><i
                                class="bx bx-search"></i> <?php echo $this->lang->line("Search"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="section-body">
    <?php
    if ($error_message == "") { ?>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page and Post Stories (People talking about this)"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page and Post Stories") ?>"
                               data-content="<?php echo $this->lang->line("The summary of Page and Post Stories that people talking about this.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_post_stories_talking_about_this" height="180"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Impressions: Latest Top 10 Countries Unique"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Impressions") ?>"
                               data-content="<?php echo $this->lang->line("The number of people who have seen any content associated with your Page by country.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_impressions_latest_country" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Impressions"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Impressions") ?>"
                               data-content="<?php echo $this->lang->line("The number of times any content from your Page or about your Page entered a person's screen. This includes posts, stories, check-ins, ads, social information from people who interact with your Page Also through paid distribution such as an ad.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_impressions" height="180"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Impressions: Paid vs Unpaid"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Impressions") ?>"
                               data-content="<?php echo $this->lang->line("Paid: The number of times any content from your Page or about your Page entered a person's screen through paid distribution such as an ad. 
			        	    Unpaid: The number of times any content from your Page or about your Page entered a person's screen through unpaid distribution. This includes posts, stories, check-ins, social information from people who interact with your Page and more.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_impressions_paid_vs_unpaid" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Engagement"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Engagement") ?>"
                               data-content="<?php echo $this->lang->line("The number of times any content from your Page or about your Page entered a person's screen. This includes posts, stories, check-ins, ads, social information from people who interact with your Page Also through paid distribution such as an ad.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_engagements" height="280"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Reactions"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Reaction") ?>"
                               data-content="<?php echo $this->lang->line("Daily total post 'like', 'love', 'wow', 'sorry', 'anger'  reactions of a page.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_reactions" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page CTA Clicks"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page CTA Clicks") ?>"
                               data-content="<?php echo $this->lang->line("The number of clicks on your Page's contact info and call-to-action button.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_cta_clicks" height="180"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page CTA Clicks: Device Statistics"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page CTA Clicks Device Statistics") ?>"
                               data-content="<?php echo $this->lang->line("Number of people who logged in to Facebook and clicked the Page CTA button, broken down by www, mobile, api and other.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_cta_clicks2" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Fans"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page User Demographics") ?>"
                               data-content="<?php echo $this->lang->line("The total number of people who have liked your Page, And Daily fan adds in your page and fan Removes in your page.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_user_demographics" height="180"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Daily Fan Adds and removes in your page"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page User Demographics") ?>"
                               data-content="<?php echo $this->lang->line("The total number of people who have liked your Page, fan Removes from your page.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_user_adds_removes" height="180"></canvas>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Fans: Top 10 Countries"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page User Demographics") ?>"
                               data-content="<?php echo $this->lang->line("Top 10 Countries Like Your page") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_user_demographics_country" height="180"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Views: Latest Viewed Each Page Profile Tab"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page View") ?>"
                               data-content="<?php echo $this->lang->line("The number of people who have viewed each Page profile tab.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_profile_each_tabs" height="180"></canvas>
                    </div>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Views: Latest Device Statistics"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Views:Latest Device Statistics") ?>"
                               data-content="<?php echo $this->lang->line("The number of people logged in to Facebook who have viewed your Page profile, broken down by the type of device.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_view_devices_stats" height="180"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Views: Latest Page Views By Referers Domains"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Views By Referers") ?>"
                               data-content="<?php echo $this->lang->line("Logged-in page visit counts (unique users) by referral source.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_views_refferer" height="180"></canvas>
                    </div>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Video Views"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Video Views") ?>"
                               data-content="<?php echo $this->lang->line("The number of times your Page's videos played, During a single instance of a video playing, we'll exclude any time spent replaying the video.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_video_views" height="180"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Video Views: Paid Vs Unpaid"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Video Views: Paid Vs Unpaid") ?>"
                               data-content="<?php echo $this->lang->line("The number of times your Page's promoted and nonpromoted videos played for at least 3 seconds, or for nearly their total length if they're shorter than 3 seconds. For each impression of a video, we'll count video views separately and exclude any time spent replaying the video") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_video_views_paid_vs_unpaid" height="180"></canvas>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Post Impressions: Viral Vs Nonviral"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Post Impressions: Viral Vs Nonviral") ?>"
                               data-content="<?php echo $this->lang->line("Viral: The number of times your Page's posts entered a person's screen with social information attached. Social information displays when a person's friend interacted with you Page or post. This includes when someone's friend likes or follows your Page, engages with a post, shares a photo of your Page and checks into your Page. Nonviral : The number of times your Page's posts entered a person's screen. This does not include content created about your Page with social information attached. Social information displays when a person's friend interacted with you Page or post. This includes when someone's friend likes or follows your Page, engages with a post, shares a photo of your Page and checks into your Page.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_post_impression_viral_nonviral" height="180"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Page Post Impressions: Paid Vs Unpaid"); ?>
                            <a href="#" data-placement="bottom" data-toggle="popover" data-trigger="focus"
                               title="<?php echo $this->lang->line("Page Post Impressions: Paid Vs Unpaid") ?>"
                               data-content="<?php echo $this->lang->line("Paid: The number of times your Page's posts entered a person's screen through paid distribution such as an ad. Unpaid : The number of times your Page's posts entered a person's screen through unpaid distribution.") ?>"><i
                                        class='bx bxs-help-circle'></i> </a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="page_post_impression_paid_vs_unpaid" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo '
  			<div class="card">
                <div class="card-header">
                  <h4>' . $this->lang->line("Something Went Wrong") . '</h4>
                </div>
                <div class="card-body">
                  <div class="empty-state" data-height="400" style="height: 400px;">
                    <div class="empty-state-icon bg-danger">
                      <i class="bx bx-time"></i>
                    </div>
                    <h2>' . $this->lang->line("Something Went Wrong") . '</h2>
                    <p class="lead">
                     ' . $error_message . '
                    </p>
                  </div>
                </div>
              </div>';

    } ?>
</div>


<?php

$steps = 10;
// Page Content Activity Steps
$page_content_activity_data_label = array_column($page_content_activity_unique, 'date');
$page_content_activity_data_values = array_column($page_content_activity_unique, 'value');
$page_content_activity_by_action_type_fan_value = array_column($page_content_activity_by_action_type_unique_fan, 'page_story_fan');
$page_content_activity_by_action_type_other_value = array_column($page_content_activity_by_action_type_unique_other, 'page_story_other');
$page_content_activity_by_action_type_page_post_value = array_column($page_content_activity_by_action_type_unique_page_post, 'page_story_page_post');
$page_content_final = array_merge($page_content_activity_data_values, $page_content_activity_by_action_type_fan_value, $page_content_activity_by_action_type_other_value, $page_content_activity_by_action_type_page_post_value);

$page_content_activity_unique_steps = (!empty($page_content_final)) ? round(max($page_content_final) / $steps) : 1;
if ($page_content_activity_unique_steps == 0) $page_content_activity_unique_steps = 1;


//Page Impressions Steps
$page_impressions_data_label = array_column($page_impressions_paid, 'date');
$page_impressions_paid_data_value = array_column($page_impressions_paid, 'value');
$page_impressions_paid_unique_data_value = array_column($page_impressions_paid_unique, 'value');
$page_impressions_organic = array_column($page_impressions_organic, 'value');
$page_impressions_organic_unique = array_column($page_impressions_organic_unique, 'value');


$page_impressions_final = array_merge($page_impressions_paid_data_value, $page_impressions_paid_unique_data_value, $page_impressions_organic, $page_impressions_organic_unique);
$page_impressions_steps = (!empty($page_impressions_final)) ? round(max($page_impressions_final) / $steps) : 1;
if ($page_impressions_steps == 0) $page_impressions_steps = 1;

//Page Impressions Second Steps

$page_impressions_data_label1 = array_column($page_impressions, 'date');
$page_impressions_values = array_column($page_impressions, 'value');
$page_impressions_unique_values = array_column($page_impressions_unique, 'value');
$page_impressions_viral_values = array_column($page_impressions_viral, 'value');
$page_impressions_viral_unique_values = array_column($page_impressions_viral_unique, 'value');
$page_impressions_nonviral_values = array_column($page_impressions_nonviral, 'value');
$page_impressions_nonviral_unique_values = array_column($page_impressions_nonviral_unique, 'value');
$page_impressions_final2 = array_merge($page_impressions_values, $page_impressions_unique_values, $page_impressions_viral_values, $page_impressions_viral_unique_values, $page_impressions_nonviral_values, $page_impressions_nonviral_unique_values);
$page_impressions_steps2 = (!empty($page_impressions_final2)) ? round(max($page_impressions_final2) / $steps) : 1;
if ($page_impressions_steps2 == 0) $page_impressions_steps2 = 1;


//Page Engagement

$page_engaged_users_data_label = array_column($page_engaged_users, 'date');
$page_engaged_users_data_values = array_column($page_engaged_users, 'value');
$page_post_engagements_data_values = array_column($page_post_engagements, 'value');
$page_consumptions_data_values = array_column($page_consumptions, 'value');
$page_consumptions_unique_data_values = array_column($page_consumptions_unique, 'value');
$page_places_checkin_total_data_values = array_column($page_places_checkin_total, 'value');
$page_negative_feedback_data_values = array_column($page_negative_feedback, 'value');
$page_positive_feedback_by_type_total = array_column($page_positive_feedback_by_type_total, 'value');
$page_fans_online_per_day_data_values = array_column($page_fans_online_per_day, 'value');

//Page Reaction

$page_actions_post_reactions_like_total_data_label = array_column($page_actions_post_reactions_like_total, 'date');
$page_actions_post_reactions_like_total_data_values = array_column($page_actions_post_reactions_like_total, 'value');
$page_actions_post_reactions_love_total_data_values = array_column($page_actions_post_reactions_love_total, 'value');
$page_actions_post_reactions_wow_total_data_values = array_column($page_actions_post_reactions_wow_total, 'value');

//Page CTA Clicks
$page_total_actions_data_label = array_column($page_total_actions, 'date');
$page_total_actions_data_values = array_column($page_total_actions, 'value');
$page_cta_clicks_logged_in_total_values = array_column($page_cta_clicks_logged_in_total, 'value');
$page_call_phone_clicks_logged_in_unique_values = array_column($page_call_phone_clicks_logged_in_unique, 'value');
$page_get_directions_clicks_logged_in_unique_values = array_column($page_get_directions_clicks_logged_in_unique, 'value');
$page_cta_final = array_merge($page_total_actions_data_values, $page_cta_clicks_logged_in_total_values, $page_call_phone_clicks_logged_in_unique_values, $page_get_directions_clicks_logged_in_unique_values);

$page_cta_clicks = (!empty($page_cta_final)) ? round(max($page_cta_final) / $steps) : 1;
if ($page_cta_clicks == 0) $page_cta_clicks = 1;

//Page Fans

$page_fans_data_values = array_column($page_fans, 'value');
$page_fans_steps = (!empty($page_fans_data_values)) ? round(max($page_fans_data_values) / $steps) : 1;
if ($page_fans_steps == 0) $page_fans_steps = 1;

// Page fan Adds and removes
$page_fan_adds_data_values = array_column($page_fan_adds, 'value');
$page_fan_removes_data_values = array_column($page_fan_removes, 'value');
$user_demographics_merge = array_merge($page_fan_adds_data_values, $page_fan_removes_data_values);
$demo_steps = (!empty($user_demographics_merge)) ? round(max($user_demographics_merge) / $steps) : 1;
if ($demo_steps == 0) $demo_steps = 1;


//$country_code = array_keys($page_fans_country['country']);


//Page Content
// $page_content_keys = array_keys(isset($page_tab_views_login_top['value']) ? $page_tab_views_login_top['value']: array()) ;
// $final_page_content_keys = str_replace('_', ' ', $page_content_keys);

//Page Video Views Paid Vs Unpaid
$page_video_views_paid_data_label = array_column($page_video_views_paid, 'date');
$page_video_views_paid_data_values = array_column($page_video_views_paid, 'value');
$page_video_views_organic_data_values = array_column($page_video_views_organic, 'value');
$page_video_views_final = array_merge($page_video_views_paid_data_values, $page_video_views_organic_data_values);
$page_video_steps = (!empty($page_video_views_final)) ? round(max($page_video_views_final) / $steps) : 1;
if ($page_video_steps == 0) $page_video_steps = 1;


// Page Video views

$page_video_views_data_label = array_column($page_video_views, 'date');
$page_video_views_data_values = array_column($page_video_views, 'value');
$page_video_views_autoplayed_data_values = array_column($page_video_views_autoplayed, 'value');
$page_video_views_click_to_play_data_values = array_column($page_video_views_click_to_play, 'value');
$page_video_views_unique_data_values = array_column($page_video_views_unique, 'value');
$page_video_view_time_data_values = array_column($page_video_view_time, 'value');

$page_video_views_final2 = array_merge($page_video_views_data_values, $page_video_views_autoplayed_data_values, $page_video_views_click_to_play_data_values, $page_video_views_unique_data_values, $page_video_view_time_data_values);
$page_video_steps2 = (!empty($page_video_views_final2)) ? round(max($page_video_views_final2) / $steps) : 1;
if ($page_video_steps2 == 0) $page_video_steps2 = 1;


// Page Post Impressions viral and Nonviral
$page_posts_impressions_viral_data_label = array_column($page_posts_impressions_viral, 'date');
$page_posts_impressions_viral_data_values = array_column($page_posts_impressions_viral, 'value');
$page_posts_impressions_nonviral_data_values = array_column($page_posts_impressions_nonviral, 'value');
$page_post_impression_viral_nonviral_final = array_merge($page_posts_impressions_viral_data_values, $page_posts_impressions_nonviral_data_values);
$page_post_impressions_steps = (!empty($page_post_impression_viral_nonviral_final)) ? round(max($page_post_impression_viral_nonviral_final) / $steps) : 1;
if ($page_post_impressions_steps == 0) $page_post_impressions_steps = 1;


// Page Post Impressions Paid vs Unpaid
$page_posts_impressions_paid_data_label = array_column($page_posts_impressions_paid, 'date');
$page_posts_impressions_paid_data_values = array_column($page_posts_impressions_paid, 'value');
$page_posts_impressions_organic_data_values = array_column($page_posts_impressions_organic, 'value');
$page_post_impression_paid_vs_unpaid_final = array_merge($page_posts_impressions_paid_data_values, $page_posts_impressions_organic_data_values);
$page_post_impressions_steps2 = (!empty($page_post_impression_paid_vs_unpaid_final)) ? round(max($page_post_impression_paid_vs_unpaid_final) / $steps) : 1;
if ($page_post_impressions_steps2 == 0)
    $page_post_impressions_steps2 = 1;

?>




