
<input type="hidden" name="image_hash" id="image_hash" value=""/>
<input type="hidden" name="preview_image" id="preview_image" value=""/>
<input type="hidden" name="ad_video_id" id="ad_video_id" value=""/>

<div class="row clean">
    <div class="col-6">
        <div class="col-12 ad-creation-options">
            <div class="panel">
                <div class="card-header border">
                    <h4 class="card-title">
                        <?php echo $this->lang->line('ad_content'); ?>
                    </h4>
                </div>
                <div class="card-body border">


                    <div class="row">
                        <div class="col-12">
                            <fieldset class="form-group mt-1 width-100p">
                                <label for="ad_name"><?php echo $this->lang->line('ad_name'); ?> <em
                                            class="required">(<?php echo $this->lang->line('required'); ?>)</em></label>
                                <input type="text" class="ad_name form-control"
                                       placeholder="<?php echo $this->lang->line('ad_name'); ?>" name="ad_name"
                                       id="ad_name">
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h6><?php echo $this->lang->line('Ad Creativity Status'); ?></h6>
                            <fieldset class="form-group">
                                <select class="form-control ad-creativity-status select2" name="ad-creativity-status">
                                    <option value="ACTIVE"><?php echo $this->lang->line('active'); ?></option>
                                    <option value="PAUSED"><?php echo $this->lang->line('paused'); ?></option>
                                </select>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row" id="ad_image_upload_view" style="display:none;">
                        <p><?php echo $this->lang->line('Recommended image size: 1200 x 628 pixels'); ?></p>
                        <div class="form-group w-100">
                            <label for="feature-dropzone">
                                <?php echo $this->lang->line("image"); ?> <span
                                        class="text-danger">(<?php echo $this->lang->line('required_for_instagram'); ?>)</span>
                            </label>
                            <div id="feature-dropzone" class="dropzone mb-1">
                                <div class="dz-default dz-message">
                                    <input class="form-control" name="featured_images" id="featured-uploaded-file"
                                           type="hidden">
                                    <span style="font-size: 20px;"><i class="bx bx-cloud-upload"
                                                                      style="font-size: 35px;color: #6777ef;"></i> <?php echo $this->lang->line('Upload image'); ?></span>
                                </div>
                            </div>
                            <span class="text-danger"><?php echo form_error('featured_images'); ?></span>
                        </div>

                        <div class="form-group w-100" id="ad_creativity_details_message_img_desc">
                            <fieldset class="form-group mt-1 width-100p">
                                <label for="ad_img_title"><?php echo $this->lang->line('Image title'); ?> <em
                                            class="required">(<?php echo $this->lang->line('required'); ?>)</em></label>
                                <input type="text" class="ad_img_title form-control"
                                       placeholder="<?php echo $this->lang->line('Image title'); ?>" name="ad_img_title"
                                       id="ad_img_title">
                            </fieldset>
                            <fieldset class="form-group mt-1 width-100p">
                                <label for="ad_img_subtitle"><?php echo $this->lang->line('Image Subtitle'); ?> <em
                                            class="required">(<?php echo $this->lang->line('optional'); ?>)</em></label>
                                <input type="text" class="ad_img_subtitle form-control"
                                       placeholder="<?php echo $this->lang->line('Image Subtitle'); ?>" name="ad_img_subtitle"
                                       id="ad_img_subtitle">
                            </fieldset>
                        </div>
                    </div>



                    <?php
                    $vid_d_none = '';
                    if($n_ad_config['ads_video_size']==0){$vid_d_none = 'd-none';}
                    ?>
                    <div class="row <?php echo $vid_d_none; ?>" id="ad_video_upload_view" style="display:none;">
                        <div class="form-group w-100">
                            <label>
                                <?php echo $this->lang->line("video"); ?> <span
                                        class="text-danger">(<?php echo $this->lang->line('required'); ?>)</span>
                            </label>
                            <div id="video_ad-dropzone" class="dropzone mb-1">
                                <div class="dz-default dz-message">
                                    <input class="form-control" name="video_ad" id="video_ad-uploaded-file"
                                           type="hidden">
                                    <span style="font-size: 20px;">
                                        <i class="bx bx-cloud-upload" style="font-size: 35px;color: #6777ef;"></i>
                                        <?php echo $this->lang->line('Upload video'); ?>
                                    </span>
                                </div>
                            </div>
                            <span class="text-danger"><?php echo form_error('video_ad'); ?></span>
                        </div>
                    </div>

                    <div class="row ad_creativity_details_eng">
                        <fieldset class="form-group mt-1 width-100p">
                            <label for="ad_text"><?php echo $this->lang->line('text'); ?> <em
                                        class="required">(<?php echo $this->lang->line('required'); ?>)</em></label>
                            <textarea class="text form-control" id="ad_text" rows="7"
                                      placeholder="<?php echo $this->lang->line('text'); ?>"></textarea>
                            <?php if($content_generator){ ?>
                            <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="facebook_ads_text" data-paste-universal="#ad_text" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                            <?php } ?>
                        </fieldset>

                    </div>

                    <div class="row ad_creativity_details_message_img_btn">
                        <a href="#" type="button" id="ad_creativity_details_message_img_btn_action" class="btn btn-outline-primary mr-1 mb-1"><?php echo $this->lang->line('Add image'); ?></a>
                    </div>

                    <div class="row ad_creativity_details_eng" id="ad_creativity_details_website">
                        <fieldset class="form-group mt-1 width-100p">
                            <label for="website_url"><?php echo $this->lang->line('website_url'); ?> <em
                                        class="required">(<?php echo $this->lang->line('required'); ?>)</em></label>
                            <input type="text" class="website_url form-control"
                                   placeholder="<?php echo $this->lang->line('website_url'); ?>" name="website_url"
                                   id="website_url">
                        </fieldset>
                    </div>


                    <div class="row ad_creativity_details_eng" id="ad_creativity_details_advanced">
                        <div class="col-12">
                            <p class="show-more-content">
                                <a data-toggle="collapse" href="#ads_creation_show_ads_advanced" role="button"
                                   aria-expanded="false" aria-controls="multiCollapseExample2">
                                    <?php echo $this->lang->line('show_advanced_options'); ?>
                                </a>
                            </p>
                            <div class="row">
                                <div class="col">
                                    <div class="collapse multi-collapse" id="ads_creation_show_ads_advanced">
                                        <div class="row">
                                            <fieldset class="form-group mt-1 width-100p">
                                                <label for="headline"><?php echo $this->lang->line('headline'); ?></label>
                                                <input type="text" class="headline form-control" id="headline"
                                                       placeholder="<?php echo $this->lang->line('headline'); ?>"
                                                       name="ad_headline" name="ad_headline">
                                                <?php if($content_generator){ ?>
                                                <a data-toggle="modal" data-target="#generator_modal_message" class="generate_modal_universal" data-action-universal="facebook_ads_headline_one" data-paste-universal="#headline" href="#"><?php echo $this->lang->line('Generate text'); ?></a>
                                                <?php } ?>
                                            </fieldset>
                                        </div>
                                        <div class="row">
                                            <fieldset class="form-group mt-1 width-100p">
                                                <label for="description"><?php echo $this->lang->line('news_feed_link_description'); ?></label>
                                                <textarea class="description form-control" id=" ad_description" rows="7"
                                                          placeholder="<?php echo $this->lang->line('news_feed_link_description'); ?>"></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 ad-creation-options"  id="ad_creativity_details_messages">
            <div class="panel">
                <div class="card-header border">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">
                                <?php echo $this->lang->line('Messages buttons'); ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body border">
                    <div class="row">
                        <input type="hidden" name="ad_creativity_details_mess_button_counts" id="ad_creativity_details_mess_button_counts" value="1" />

                        <div class="col-12">
                            <label for="ad_creativity_details_messages_select_type"><?php echo $this->lang->line('Select the action you want people to take. Suggest quick replies for customers to tap, or use a button to send people to your site.'); ?></label>
                            <fieldset class="form-group">
                                <select class="form-control select2 ad_creativity_details_messages_select_type" id="ad_creativity_details_messages_select_type"
                                        name="ad_creativity_details_messages_select_type">

                                    <option value="buttons"><?php echo $this->lang->line('Buttons'); ?></option>
                                    <option value="quick_reply"><?php echo $this->lang->line('Quick Replies'); ?></option>

                                </select>
                            </fieldset>
                        </div>

                        <div class="col-12 row" id="ad_creativity_details_messages_buttons_container">
                        </div>

                        <div class="col-12 mt-1">
                            <a href="#" type="button" id="ad_creativity_details_messages_buttons_new" class="btn btn-outline-primary mr-1 mb-1"><?php echo $this->lang->line('Add button'); ?></a>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        <div class="col-12 ad-creation-options ad-identity">
            <div class="panel">
                <div class="card-header border">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">
                                <?php echo $this->lang->line('identity'); ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body border">
                    <div class="row">
                        <div class="col-12">
                            <h6><?php echo $this->lang->line('select_facebook_page'); ?></h6>
                            <p><?php echo $this->lang->line('your_facebook_page_represents_business'); ?></p>
                            <fieldset class="form-group">
                                <select class="form-control select2 select_adp_fb_page" id="select_adp_fb_page"
                                        name="select_adp_fb_page">

                                </select>
                            </fieldset>
                        </div>

                        <div class="col-12">
                            <h6><?php echo $this->lang->line('instagram'); ?></h6>
                            <p><?php echo $this->lang->line('instagram_below_connected_facebook'); ?></p>
                            <fieldset class="form-group">
                                <select class="form-control select2 select_adp_ig_page" id="select_adp_ig_page"
                                        name="select_adp_ig_page">

                                </select>
                            </fieldset>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        <div class="col-12 ad-creation-options post-engagement-list">
            <div class="panel">
                <div class="card-header border">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="panel-title">
                                <?php echo $this->lang->line('posts'); ?>
                            </h4>
                        </div>
                        <div class="col-6 text-right">
                            <select class="form-control select2" id="post-engagement-from-network" name="post-engagement-from-network">
                                <option value="facebook" selected>Facebook</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body border p-0">

                        <div class="post-engagement-from-facebook" id="post-engagement-from-facebook" role="tabpanel" aria-labelledby="post-engagement-from-facebook-tab">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="row" colspan="3">
                                            <input type="text" class="form-control post-engagement-search-posts" id="post-engagement-search-posts" placeholder="Search posts">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th scope="col" colspan="2">
                                            <?php echo $this->lang->line('post'); ?>
                                        </th>
                                        <th scope="col">
                                            <?php echo $this->lang->line('actions'); ?>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="col-12 ad-creation-preview ad-preview-display">
            <div class="panel">
                <div class="card-header border">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="card-title">
                                <?php echo $this->lang->line('ad_preview'); ?>
                            </h4>
                        </div>
                        <div class="col-6 text-right">
                            <div class="dropdown d-none">
                                <button class="btn btn-secondary dropdown-toggle btn-select" type="button"
                                        id="dropdownMenuButton27" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="fab fa-facebook"></i>
                                    <?php echo $this->lang->line('desktop_news_feed'); ?>
                                </button>
                                <div class="dropdown-menu ads-campaign-dropdown" aria-labelledby="dropdownMenuButton27">
                                    <a class="dropdown-item" href="#links-clicks-preview-fb-desktop-feed">
                                        <i class="fab fa-facebook"></i>
                                        <?php echo $this->lang->line('desktop_news_feed'); ?>
                                    </a>
                                    <a class="dropdown-item" href="#links-clicks-preview-instagram-feed">
                                        <i class="icon-social-instagram"></i>
                                        <?php echo $this->lang->line('instagram_feed'); ?>
                                    </a>
                                    <a class="dropdown-item" href="#links-clicks-preview-messenger-inbox">
                                        <i class="fab fa-facebook-messenger"></i>
                                        <?php echo $this->lang->line('messenger_inbox'); ?>
                                    </a>
                                </div>
                            </div>
                            <button class="btn" id="reload_preview"><i class="bx bx-refresh"></i> </button>
                        </div>
                    </div>
                </div>
                <div class="card-body shadow-none border p-0" id="preview_ad_iframe">
                    <p class="p-2"><?php echo $this->lang->line('To generate Ad Preview first fill all required fields.'); ?></p>
                </div>
            </div>
        </div>
        <div class="col-12 ad-creation-options pixel-conversion-tracking">
            <div class="panel">
                <div class="card-header border">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">
                                <?php echo $this->lang->line('tracking'); ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="card-body border">
                    <div class="row">
                        <div class="col-12">
                            <h6><?php echo $this->lang->line('Facebook Pixel'); ?></h6>
                            <p><?php echo $this->lang->line('your_facebook_pixel_account'); ?></p>
                            <fieldset class="form-group">
                                <select class="form-control select2 select_adp_pixel" id="select_adp_pixel"
                                        name="select_adp_pixel">

                                </select>
                            </fieldset>
                        </div>

                        <div class="col-12">
                            <h6><?php echo $this->lang->line('conversion_tracking'); ?></h6>
                            <p><?php echo $this->lang->line('select_a_conversion_tracking'); ?></p>
                            <fieldset class="form-group">
                                <select class="form-control select2 select_adp_convtracking"
                                        id="select_adp_convtracking" name="select_adp_convtracking">

                                </select>
                            </fieldset>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>


<div class="tab-pane fade d-none" id="ads-create-ads-post-engagement" role="tabpanel"
     aria-labelledby="ads-create-ads-links-tab">
    <div class="card shadow-none">
        <div class="row clean">
            <div class="col-6">
                <div class="col-12 ad-creation-options ad-identity">
                    <div class="form-group">
                        <select class="form-control" id="ads-select-ad-campaign" name="ads-select-ad-campaign">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="col-12 ad-creation-options post-engagement-list">
                    <div class="panel">
                        <div class="card-header border">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title">
                                        <?php echo $this->lang->line('posts'); ?>
                                    </h4>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle btn-select" type="button"
                                                id="dropdownMenuButton28" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="fab fa-facebook"></i>
                                            Facebook
                                        </button>
                                        <div class="dropdown-menu ads-campaign-dropdown"
                                             aria-labelledby="dropdownMenuButton28">
                                            <a class="dropdown-item" href="#ads-post-engagement-from-facebook">
                                                <i class="fab fa-facebook"></i>
                                                Facebook
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body shadow-none">
                            <div class="row">
                                <fieldset class="form-group mt-1 width-100p">
                                    <label for="ad_name"><?php echo $this->lang->line('ad_name'); ?> <em
                                                class="required">(<?php echo $this->lang->line('required'); ?>
                                            )</em></label>
                                    <input type="text" class="ad_name form-control"
                                           placeholder="<?php echo $this->lang->line('ad_name'); ?>" name="ad_name">
                                </fieldset>
                            </div>
                            <hr>
                            <div class="tab-content" id="post-engagement-list">
                                <div class="tab-pane fade show active post-engagement-from-facebook"
                                     id="ads-post-engagement-from-facebook" role="tabpanel"
                                     aria-labelledby="ads-post-engagement-from-facebook-tab">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="row" colspan="3">
                                                    <input type="text" class="form-control post-engagement-search-posts"
                                                           placeholder="Search posts">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th scope="col" colspan="2">
                                                    <?php echo $this->lang->line('post'); ?>
                                                </th>
                                                <th scope="col">
                                                    <?php echo $this->lang->line('actions'); ?>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="post-engagement-from-instagram" role="tabpanel"
                                     aria-labelledby="post-engagement-from-instagram-tab">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="row" colspan="3">
                                                    <input type="text" class="form-control post-engagement-search-posts"
                                                           placeholder="Search posts">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th scope="col" colspan="2">
                                                    <?php echo $this->lang->line('post'); ?>
                                                </th>
                                                <th scope="col">
                                                    <?php echo $this->lang->line('actions'); ?>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="col-12 ad-creation-preview ad-preview-display">
                    <div class="panel">
                        <div class="card-header border">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title">
                                        <?php echo $this->lang->line('ad_preview'); ?>
                                    </h4>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle btn-select" type="button"
                                                id="dropdownMenuButton29" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="fab fa-facebook"></i>
                                            <?php echo $this->lang->line('desktop_news_feed'); ?>
                                        </button>
                                        <div class="dropdown-menu ads-campaign-dropdown"
                                             aria-labelledby="dropdownMenuButton29">
                                            <a class="dropdown-item" href="#links-clicks-preview-fb-desktop-feed">
                                                <i class="fab fa-facebook"></i>
                                                <?php echo $this->lang->line('desktop_news_feed'); ?>
                                            </a>
                                            <a class="dropdown-item" href="#links-clicks-preview-instagram-feed">
                                                <i class="icon-social-instagram"></i>
                                                <?php echo $this->lang->line('instagram_feed'); ?>
                                            </a>
                                            <a class="dropdown-item" href="#links-clicks-preview-messenger-inbox">
                                                <i class="fab fa-facebook-messenger"></i>
                                                <?php echo $this->lang->line('messenger_inbox'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body shadow-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane fade d-none" id="ads-create-ads-page-likes" role="tabpanel"
     aria-labelledby="ads-create-ads-page-likes-tab">
    <div class="card shadow-none">
        <div class="row clean">
            <div class="col-6">
                <div class="col-12 ad-creation-options">
                    <div class="panel">
                        <div class="card-header border">
                            <h4 class="card-title">
                                <?php echo $this->lang->line('ad_content'); ?>
                            </h4>
                        </div>
                        <div class="card-body shadow-none">
                            <div class="row">
                                <fieldset class="form-group mt-1 width-100p">
                                    <label for="ad_name"><?php echo $this->lang->line('ad_name'); ?> <em
                                                class="required">(<?php echo $this->lang->line('required'); ?>
                                            )</em></label>
                                    <input type="text" class="ad_name form-control"
                                           placeholder="<?php echo $this->lang->line('ad_name'); ?>" name="ad_name">
                                </fieldset>
                            </div>
                            <div class="row">
                                <div class="col-12 adset-page-likes-preview-settings text-center">
                                    <hr>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle btn-select" type="button"
                                                id="dropdownMenuButton126" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="icon-picture"></i>
                                            <?php echo $this->lang->line('image'); ?> <em
                                                    class="required">(<?php echo $this->lang->line('optional'); ?>)</em>
                                        </button>
                                        <div class="dropdown-menu ads-campaign-dropdown"
                                             aria-labelledby="dropdownMenuButton126">
                                            <a class="dropdown-item" href="#adset-page-likes-preview-settings-photo">
                                                <i class="icon-picture"></i>
                                                <?php echo $this->lang->line('image'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="tab-content" id="adset-page-likes-preview-settings">
                                        <div class="tab-pane fade show active"
                                             id="adset-page-likes-preview-settings-photo" role="tabpanel"
                                             aria-labelledby="adset-page-likes-preview-settings-photo-tab">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <button type="button"
                                                            class="btn btn-primary btn-upload upload-ads-image"
                                                            data-toggle="button" aria-pressed="false"
                                                            autocomplete="off">
                                                        <i class="icon-cloud-upload"></i>
                                                        <?php echo $this->lang->line('select_image'); ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row ads-uploaded-photo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <fieldset class="form-group mt-1 width-100p">
                                    <label for="text"><?php echo $this->lang->line('text'); ?> <em
                                                class="required">(<?php echo $this->lang->line('required'); ?>
                                            )</em></label>
                                    <textarea class="text form-control" id="text" rows="7"
                                              placeholder="<?php echo $this->lang->line('text'); ?>"></textarea>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="col-12 ad-creation-preview ad-preview-display">
                    <div class="panel">
                        <div class="card-header border">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title">
                                        <?php echo $this->lang->line('ad_preview'); ?>
                                    </h4>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle btn-select" type="button"
                                                id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="fab fa-facebook"></i>
                                            <?php echo $this->lang->line('desktop_news_feed'); ?>
                                        </button>
                                        <div class="dropdown-menu ads-campaign-dropdown"
                                             aria-labelledby="dropdownMenuButton13">
                                            <a class="dropdown-item" href="#adset-page-likes-preview-fb-desktop-feed">
                                                <i class="fab fa-facebook"></i>
                                                <?php echo $this->lang->line('desktop_news_feed'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-pane fade d-none" id="ads-create-ads-video-views" role="tabpanel"
     aria-labelledby="ads-create-ads-video-views-tab">
    <div class="card shadow-none">
        <div class="row clean">
            <div class="col-6">
                <div class="col-12 ad-creation-options">
                    <div class="panel">
                        <div class="card-header border">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="card-title">
                                        <?php echo $this->lang->line('ad_content'); ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body shadow-none">
                            <div class="row">
                                <fieldset class="form-group mt-1 width-100p">
                                    <label for="ad_name"><?php echo $this->lang->line('ad_name'); ?> <em
                                                class="required">(<?php echo $this->lang->line('required'); ?>
                                            )</em></label>
                                    <input type="text" class="ad_name form-control"
                                           placeholder="<?php echo $this->lang->line('ad_name'); ?>" name="ad_name">
                                </fieldset>
                            </div>
                            <div class="row">
                                <div class="col-12 ads-create-ads-video-views-preview-settings text-center">
                                    <hr>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle btn-select" type="button"
                                                id="dropdownMenuButton120" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="icon-camrecorder"></i>
                                            <?php echo $this->lang->line('video'); ?> <em
                                                    class="required">(<?php echo $this->lang->line('required'); ?>)</em>
                                        </button>
                                        <div class="dropdown-menu ads-campaign-dropdown"
                                             aria-labelledby="dropdownMenuButton120">
                                            <a class="dropdown-item"
                                               href="#ads-create-ads-video-views-preview-settings-video">
                                                <i class="icon-camrecorder"></i>
                                                <?php echo $this->lang->line('video'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="tab-content" id="ads-create-ads-video-views-preview-settings">
                                        <div class="tab-pane fade show active"
                                             id="ads-create-ads-video-views-preview-settings-video" role="tabpanel"
                                             aria-labelledby="ads-create-ads-video-views-preview-settings-video-tab">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <button type="button"
                                                            class="btn btn-primary btn-upload upload-ads-video"
                                                            data-toggle="button" aria-pressed="false"
                                                            autocomplete="off">
                                                        <i class="icon-cloud-upload"></i>
                                                        <?php echo $this->lang->line('select_video'); ?>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row ads-uploaded-video">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <fieldset class="form-group mt-1 width-100p">
                                    <label for="text"><?php echo $this->lang->line('text'); ?> <em
                                                class="required">(<?php echo $this->lang->line('required'); ?>
                                            )</em></label>
                                    <textarea class="text form-control" id="text" rows="7"
                                              placeholder="<?php echo $this->lang->line('text'); ?>"></textarea>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="col-12 ad-creation-preview ad-preview-display">
                    <div class="panel">
                        <div class="card-header border">
                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title">
                                        <?php echo $this->lang->line('ad_preview'); ?>
                                    </h4>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle btn-select" type="button"
                                                id="dropdownMenuButton13" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="fab fa-facebook"></i>
                                            <?php echo $this->lang->line('desktop_news_feed'); ?>
                                        </button>
                                        <div class="dropdown-menu ads-campaign-dropdown"
                                             aria-labelledby="dropdownMenuButton13">
                                            <a class="dropdown-item" href="#links-clicks-preview-fb-desktop-feed">
                                                <i class="fab fa-facebook"></i>
                                                <?php echo $this->lang->line('desktop_news_feed'); ?>
                                            </a>
                                            <a class="dropdown-item" href="#links-clicks-preview-instagram-feed">
                                                <i class="icon-social-instagram"></i>
                                                <?php echo $this->lang->line('instagram_feed'); ?>
                                            </a>
                                            <a class="dropdown-item" href="#links-clicks-preview-messenger-inbox">
                                                <i class="fab fa-facebook-messenger"></i>
                                                <?php echo $this->lang->line('messenger_inbox'); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-none">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>