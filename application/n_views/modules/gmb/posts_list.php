<?php $include_mCustomScrollBar = 1; ?>
<style>
    .dropright .dropdown-toggle::after {
        display: none;
    }
</style>

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12 colrig">
            <div class="card main_card shadow-none">
                <div class="card-header p-0 pt-3">
                    <div class="col-12 p-0">
                        <input type="text" class="form-control float-right" onkeyup="search_in_ul(this,'post_list_ul')"
                               placeholder="Search...">
                    </div>
                </div>
                <div class="card-body p-0 pt-4" style="max-height: 500px;">

                    <div class="text-center" id="sync_commenter_info_response"></div>
                    <ul class="list-unstyled list-unstyled-border makeScroll" id="post_list_ul"
                        style="max-height:700px;overflow-y: auto;">
                        <?php if (count($posts_list)): ?>
                            <?php foreach ($posts_list as $key => $post): ?>
                                <?php if ('callToAction' == $post['post_type']): ?>
                                    <li class="media">
                                        <div class="avatar-item mr-3">
                                            <?php if (!empty($post['photo'])): ?>
                                                <img alt="image" src="<?php echo $post['photo']; ?>" width="70"
                                                     height="70" style="border:1px solid #eee;" data-toggle="tooltip"
                                                     title="">
                                            <?php else: ?>
                                                <img alt="image"
                                                     src="<?php echo base_url('upload/xerobiz/dummy_post_photo.jpg'); ?>"
                                                     width="70" height="70" style="border:1px solid #eee;"
                                                     data-toggle="tooltip" title="">
                                            <?php endif; ?>
                                        </div>
                                        <div class="media-body">
                                            <div class="media-title">
                                                <a href="<?php echo $post['searchUrl']; ?>"
                                                   target="_blank"><?php echo $post['summary']; ?></a>
                                            </div>
                                            <span class="text-small">
                                                    <i class="bx bx-time"></i>
                                                    <?php echo date('M j, Y', strtotime($post['createTime'])); ?>
                                                </span>
                                            <br/>
                                            <span class="small"><?php echo $this->lang->line('CTA'); ?> (<?php echo $post['actionType']; ?>)</span>
                                            <?php if ('call' != strtolower($post['actionType'])): ?>
                                                / <a href="<?php echo $post['url']; ?>" class="text-primary small"
                                                     target="_blank"><?php echo $this->lang->line('Action URL'); ?></a>
                                            <?php endif; ?>
                                            / <a
                                                    href="#"
                                                    data-toggle="modal"
                                                    data-target="post-analytics-modal"
                                                    class="post_analytics text-primary small"
                                                    data-post-name="<?php echo $post['name']; ?>"
                                            ><?php echo $this->lang->line('Analytics'); ?></a>
                                        </div>
                                    </li>
                                <?php elseif ('offer' == $post['post_type']): ?>
                                    <li class="media">
                                        <div class="avatar-item mr-3">
                                            <?php if (!empty($post['photo'])): ?>
                                                <img alt="image" src="<?php echo $post['photo']; ?>" width="70"
                                                     height="70" style="border:1px solid #eee;" data-toggle="tooltip"
                                                     title="">
                                            <?php else: ?>
                                                <img alt="image"
                                                     src="<?php echo base_url('upload/xerobiz/dummy_post_photo.jpg'); ?>"
                                                     width="70" height="70" style="border:1px solid #eee;"
                                                     data-toggle="tooltip" title="">
                                            <?php endif; ?>
                                        </div>
                                        <div class="media-body pt-2">
                                            <div class="media-title">
                                                <a href="<?php echo $post['searchUrl']; ?>"
                                                   target="_blank"><?php echo $post['summary']; ?></a>
                                            </div>
                                            <span class="text-small">
                                                    <i class="bx bx-time"></i>
                                                    <?php echo date('M j, Y', strtotime($post['createTime'])); ?>
                                                </span>
                                            <br/>
                                            <span class=""></span>
                                            <span class="small"><?php echo $this->lang->line('OFFER'); ?> (<?php echo $this->lang->line('Coupon code:') . ' ' . $post['couponCode']; ?>)</span>
                                            / <a href="<?php echo $post['redeemUrl']; ?>" class="text-primary small"
                                                 target="_blank"><?php echo $this->lang->line('Redeem URL'); ?></a>
                                            / <a
                                                    href="#"
                                                    data-toggle="modal"
                                                    data-target="post-analytics-modal"
                                                    class="post_analytics text-primary small"
                                                    data-post-name="<?php echo $post['name']; ?>"
                                            ><?php echo $this->lang->line('Analytics'); ?></a>
                                        </div>
                                    </li>
                                <?php elseif ('event' == $post['post_type']): ?>
                                    <li class="media">
                                        <div class="avatar-item mr-3">
                                            <?php if (!empty($post['photo'])): ?>
                                                <img alt="image" src="<?php echo $post['photo']; ?>" width="70"
                                                     height="70" style="border:1px solid #eee;" data-toggle="tooltip"
                                                     title="">
                                            <?php else: ?>
                                                <img alt="image"
                                                     src="<?php echo base_url('upload/xerobiz/dummy_post_photo.jpg'); ?>"
                                                     width="70" height="70" style="border:1px solid #eee;"
                                                     data-toggle="tooltip" title="">
                                            <?php endif; ?>
                                        </div>
                                        <div class="media-body pt-2">
                                            <div class="media-title">
                                                <a href="<?php echo $post['searchUrl']; ?>"
                                                   target="_blank"><?php echo $post['title']; ?></a>
                                            </div>
                                            <span class="text-small">
                                                    <i class="bx bx-time"></i>
                                                    <?php echo date('M j, Y', strtotime($post['createTime'])); ?>
                                                </span>
                                            <br/>
                                            <span class="small">
                                                    <?php echo $this->lang->line('EVENT'); ?>
                                                    (<?php echo $this->lang->line('Start date:') . ' ' .
                                                    date('M j, Y', strtotime($post['start_date_time'])) . ' - ' .
                                                    $this->lang->line('End date:') . ' ' .
                                                    date('M j, Y', strtotime($post['end_date_time']));
                                                ?>)
                                                </span>
                                            / <a
                                                    href="#"
                                                    data-toggle="modal"
                                                    data-target="post-analytics-modal"
                                                    class="post_analytics text-primary small"
                                                    data-post-name="<?php echo $post['name']; ?>"
                                            ><?php echo $this->lang->line('Analytics'); ?></a>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="post-analytics-modal" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $this->lang->line("Post analytics") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Local post views search'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the local post was viewed on Google Search."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div id="post-insights-container" class="card-body">
                        <canvas id="local_post_views_search" height="200"></canvas>
                    </div>
                </div>
                <div class="xit-spinner bg-white text-primary">
                    <i class="bx bx-spin bx-loader fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

