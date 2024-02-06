<main class="main">
    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li><?php echo $this->lang->line("Review"); ?></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="shop-content">
            <div class="container main-content">
                <h4><?php echo $this->lang->line("Review"); ?></h4>
                <?php
                $product_data = $review_data[0];
                $subscriber_id = $this->session->userdata($product_data['store_id'] . "ecom_session_subscriber_id");
                if ($subscriber_id == "") $subscriber_id = isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : "";
                if ($this->ecommerce_review_comment_exist):
                    ?>
                    <ul class="comments list-style-none">
                        <?php
                        foreach ($review_data as $key => $value) {
                            $profile_pic = ($value['profile_pic'] != "") ? "<img class='rounded-circle mr-3' style='height:50px;width:50px;' src='" . $value["profile_pic"] . "'>" : "<img class='rounded-circle mr-3' style='height:50px;width:50px;' src='" . base_url('assets/img/avatar/avatar-1.png') . "'>";
                            $image_path = ($value["image_path"] != "") ? "<img class='rounded-circle mr-3' style='height:50px;width:50px;' src='" . base_url($value["image_path"]) . "'>" : $profile_pic;
                            $review_url = base_url("ecommerce/review/" . $value["id"]);
                            // if($subscriber_id!="") $review_url .= "?subscriber_id=".$subscriber_id;
                            $review_url = mec_add_get_param($review_url, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
                            $reply_button = $hide_button = $reply_block = $review_reply_show = '';

                            if ($this->user_id != '') {
                                if ($value['review_reply'] == '') $reply_button = ' <a class="collpase_link d-inline float-right" data-toggle="collapse" href="#collapsereview' . $value["id"] . '" role="button" aria-expanded="false" aria-controls="collapsereview' . $value["id"] . '"><i class="w-icon-comment"></i> ' . $this->lang->line("Reply") . '</a>';
                                $hide_button = '<a data-id="' . $value["id"] . '" class="d-inline float-right pr-3 hide-review text-muted" href="#"><i class="w-icon-search-minus"></i> ' . $this->lang->line("Hide") . '</a>';
                                if ($value['review_reply'] == '') $reply_block = '
                  <div class="input-group collapse pt-2" id="collapsereview' . $value["id"] . '">
                    <textarea class="form-control review_reply" name="review_reply" style="height:50px !important;"></textarea>
                    <button class="btn btn-primary leave_review_comment no_radius" parent-id="' . $value['id'] . '"><i class="w-icon-reports"></i> ' . $this->lang->line("Reply") . '</button>              
                  </div>';
                            }
                            $review_reply_text = preg_replace("/(https?:\/\/[a-zA-Z0-9\-._~\:\/\?#\[\]@!$&'\(\)*+,;=]+)/", '<a target="_BLANK" href="$1">$1</a>', $value["review_reply"]); // find and replace links with ancor tag
                            if ($value['review_reply'] != '') {
                                $store_favicon_src = isset($social_analytics_codes['store_favicon']) ? base_url("upload/ecommerce/" . $social_analytics_codes['store_favicon']) : base_url('assets/img/avatar/avatar-1.png');
                                $storeName = isset($social_analytics_codes['store_name']) ? $social_analytics_codes['store_name'] : $this->lang->line("Admin");
                                $review_reply_show = '
                  <div class="media mt-3 w-100">
                        <img onerror="this.onerror=null;this.src=\'' . base_url('assets/img/avatar/avatar-1.png') . '\';" class="rounded-circle mr-3" style="height:50px;width:50px;" src="' . $store_favicon_src . '">
                        <div class="media-body">
                          <h6 class="mt-1 mb-0">' . $storeName . ' <i class="w-icon-user text-primary"></i></h6>
                          <p style="font-size:11px;" class="m-0 text-muted d-inline">' . date("d M,y H:i", strtotime($value['replied_at'])) . '                    
                          <p class="mb-0">' . nl2br($review_reply_text) . '</p>
                        </div>
                    </div>';
                            }
                            $review_star_single = mec_display_rating_starts($value['rating'], 'text-medium');
                            $review_text = preg_replace("/(https?:\/\/[a-zA-Z0-9\-._~\:\/\?#\[\]@!$&'\(\)*+,;=]+)/", '<a target="_BLANK" href="$1">$1</a>', $value["review"]); // find and replace links with ancor tag
//                    echo '
//                <div class="media mb-4 mt-2 w-100 p-2" id="review-'.$value["id"].'">
//                  '.$image_path.'
//                  <div class="media-body">
//                    <h6 class="mt-1 mb-0 w-100">'.$value["first_name"].' '.$value["last_name"].'<span class="pl-2 text-medium">'.$review_star_single.' '.number_format($value['rating'],1).'</span></h6>
//                    <p style="font-size:11px;" class="m-0 d-inline"><a target="_BLANK" href="'.$review_url.'">'.date("d M,y H:i",strtotime($value['inserted_at'])).'</a></p>
//                    '.$reply_button.$hide_button.'
//                    <p class="mb-0 mt-2 text-justify"><b>'.$value["reason"].'</b> : '.nl2br($review_text).'</p>
//                    '.$reply_block.$review_reply_show.'
//                  </div>
//                </div>';
//
                            ?>
                            <li class="comment">
                                <div class="comment-body">
                                    <figure class="comment-avatar">
                                        <img onerror="this.onerror=null;this.src='<?php echo base_url('assets/img/avatar/avatar-1.png'); ?>';"
                                             src="<?php echo $profile_pic; ?>" style="border-radius: 50%"
                                             alt="Commenter Avatar" width="90" height="90">
                                    </figure>
                                    <div class="comment-content" style="width: 100%;">
                                        <h4 class="comment-author">
                                            <a href="<?php echo $review_url; ?>"><?php echo $value["first_name"] . ' ' . $value["last_name"]; ?></a>
                                            <span class="comment-date"><?php echo date("d M,y H:i", strtotime($value['inserted_at'])); ?></span>
                                        </h4>
                                        <div class="ratings-container comment-rating">
                                            <div class="ratings-full">
                                                                                <span class="ratings"
                                                                                      style="width: <?php echo rating_calc($value['rating'], 1); ?>%;"></span>
                                                <span
                                                        class="tooltiptext tooltip-top"></span>
                                            </div>
                                        </div>
                                        <p><strong><?php echo $value["reason"]; ?></strong></p>
                                        <p><?php echo nl2br($review_text); ?></p>
                                        <div class="comment-action">
                                            <?php if ($this->user_id != '') { ?>
                                                <a href="#" data-id="#collapsereview<?php echo $value["id"]; ?>"
                                                   class="collapse_link  btn btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize"
                                                   role="button" aria-expanded="false"
                                                   aria-controls="collapsereview<?php echo $value["id"]; ?>">
                                                    <i class="w-icon-comment"></i><?php echo $this->lang->line("Reply"); ?>
                                                </a>
                                                <a href="#" data-id="<?php echo $value["id"]; ?>"
                                                   class="btn btn-link btn-underline sm btn-icon-left font-weight-normal text-capitalize hide-review">
                                                    <i class="w-icon-search-minus"></i><?php echo $this->lang->line("Hide"); ?>
                                                </a>
                                            <?php } ?>
                                            <?php if (!empty($value["image_path"])) { ?>
                                                <div class="review-image">
                                                    <a href="#">
                                                        <figure>
                                                            <img src="<?php echo base_url($value["image_path"]); ?>"
                                                                 width="60" height="60"
                                                                 alt=""
                                                                 data-zoom-image=""<?php echo base_url($value["image_path"]); ?>
                                                            " />
                                                        </figure>
                                                    </a>
                                                </div>
                                            <?php }
                                            if ($value['review_reply'] == '') {
                                                echo '
                          <div class="pt-2" id="collapsereview' . $value["id"] . '" style="display: none;">
                            <textarea class="form-control review_reply" name="review_reply" style="height:50px !important;"></textarea>
                            <button class="btn btn-dark leave_review_comment no_radius" parent-id="' . $value['id'] . '"><i class="w-icon-reports"></i> ' . $this->lang->line("Reply") . '</button>              
                          </div>';
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php


                        } ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

