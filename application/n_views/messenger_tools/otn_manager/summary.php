<?php
//todo: new graphics?
?>
    <div class="form-group">
        <?php
        $pop = "";
        if ($this->uri->segment(2) == "create_quick_broadcast_campaign" || $this->uri->segment(2) == "edit_quick_broadcast_campaign")
            $pop = $this->lang->line("This campaign is totally handled by Facebook for each send. So actual send may differ for various reason. As for example, if any subscriber did not interact with your bot for many days like 2 months or page sent private reply of comment but he never replied back, in those cases, those subscribers will not be eligible for quick broadcasting. While targeting by label it may happen that some subscribers have label in Facebook but have not been assigned label in our system, they are eligible for quick broadcasting.");
        ?>
        <label class="full_width">
            <?php if ($pop != '') { ?>
                <a class="float-right" data-toggle="popover" href="#" data-placement="top" data-trigger="focus"
                   title="<?php echo $this->lang->line('Campaign Reach'); ?>" data-content="<?php echo $pop; ?>"><i
                            class="bx bxs-help-circle"></i></a>
            <?php } ?>
        </label>
        <ul class="list-group">
            <?php if ($this->uri->segment(2) == "create_quick_broadcast_campaign" || $this->uri->segment(2) == "edit_quick_broadcast_campaign") { ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $this->lang->line("Estimated Reach"); ?>
                    <span class="badge badge-status" id="page_subscriber">0</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center active">
                    <?php echo $this->lang->line("Targeted Reach"); ?>
                    <span class="badge badge-status" id="targetted_subscriber">0</span>
                </li>
                <?php
            } else { ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $this->lang->line("Page Subscribers"); ?>
                    <span class="badge badge-status" id="page_subscriber">0</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center active">
                    <?php echo $this->lang->line("Targeted Reach"); ?>
                    <span class="badge badge-status" id="targetted_subscriber">0</span>
                </li>
                <?php
            } ?>
        </ul>
    </div>

    <div class="d-none d-lg-inline col-lg-3 prview_div" style="">

        <div id="text_preview_div" style="">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/text.png')) echo site_url() . "assets/images/preview/text.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/text.png"; ?>"
                 class="img-rounded" alt="Text Preview">
        </div>

        <div id="image_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/image.png')) echo site_url() . "assets/images/preview/image.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/image.png"; ?>"
                 class="img-rounded" alt="Image Preview">
        </div>

        <div id="audio_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/mp3.png')) echo site_url() . "assets/images/preview/mp3.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/mp3.png"; ?>"
                 class="img-rounded" alt="Audio Preview">
        </div>

        <div id="video_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/video.png')) echo site_url() . "assets/images/preview/video.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/video.png"; ?>"
                 class="img-rounded" alt="Video Preview">
        </div>

        <div id="file_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/file.png')) echo site_url() . "assets/images/preview/file.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/file.png"; ?>"
                 class="img-rounded" alt="File Preview">
        </div>

        <div id="quick_reply_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/quick_reply.png')) echo site_url() . "assets/images/preview/quick_reply.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/quick_reply.png"; ?>"
                 class="img-rounded" alt="Quick Reply Preview">
        </div>

        <div id="text_with_buttons_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/button.png')) echo site_url() . "assets/images/preview/button.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/button.png"; ?>"
                 class="img-rounded" alt="Text With Buttons Preview">
        </div>

        <div id="generic_template_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/generic.png')) echo site_url() . "assets/images/preview/generic.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/generic.png"; ?>"
                 class="img-rounded" alt="Generic Template Preview">
        </div>

        <div id="carousel_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/carousel.png')) echo site_url() . "assets/images/preview/carousel.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/carousel.png"; ?>"
                 class="img-rounded" alt="Carousel Template Preview">
        </div>

        <div id="list_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/list.png')) echo site_url() . "assets/images/preview/list.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/list.png"; ?>"
                 class="img-rounded" alt="List Template Preview">
        </div>

        <div id="media_preview_div" style="display: none;">
            <img src="<?php if (file_exists(FCPATH . 'assets/images/preview/media.png')) echo site_url() . "assets/images/preview/media.png"; else echo "https://mysitespy.net/2waychat_demo/msgbot_demo/preview/media.png"; ?>"
                 class="img-rounded" alt="Media Template Preview">
        </div>

    </div>


    <style type="text/css">
        .prview_div div {
            text-align: right
        }

        .prview_div img {
            border: 1px solid #ccc;
        }

        .select2 {
            width: 100% !important;
        }

        .popover {
            min-width: 330px !important;
        }
    </style>

<?php

$include_js_uni = FCPATH . "application/n_views/messenger_tools/otn_manager/summary_js.php";

?>