<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
$include_summernote = 1;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 0;
$include_tagsinput = 1;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;
?>

<style>
    .dropright .dropdown-toggle::after {
        display: none;
    }

    #main_review_content .waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    #main_review_content .waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 30px 0;
    }

    .review-info {
        line-height: 16px;
    }

    .avatar-item img {
        border-radius: 50%;
    }

    .media-title span {
        float: right;
    }

    li.media {
        margin-bottom: 30px;
    }

    div.tooltip_pd {
        top: 0px !important;
    }
</style>

<div class="section-body">
    <div class="row">
        <div id="right_column" class="col-12 col-md-12 col-lg-12 colrig">
            <div class="card main_card shadow-none">
                <div class="card-header p-0 pt-3">
                    <div>
                        <p class="review-info text-muted text-center"><?php echo $this->lang->line('Review report may take upto few minutes/hours to update & synchronize here.'); ?></p>
                    </div>
                    <div class="col-12 p-0">
                        <input type="text" class="form-control float-right" onkeyup="search_in_ul(this,'post_list_ul')"
                               placeholder="Search...">
                    </div>
                </div>
                <div class="card-body p-0 pt-4" id="main_review_content">

                    <ul class="list-unstyled list-unstyled-border makeScroll" id="post_list_ul"
                        style="max-height:700px;overflow-y: auto;">
                        <?php if (count($reviews)): ?>
                            <?php foreach ($reviews as $key => $review): ?>
                                <li class="media">
                                    <div class="avatar-item mr-3">
                                        <?php if (!empty($review['profilePhotoUrl'])): ?>
                                            <img alt="image" src="<?php echo $review['profilePhotoUrl']; ?>" width="70"
                                                 height="70" style="border:1px solid #eee;" data-toggle="tooltip"
                                                 title="">
                                        <?php else: ?>
                                            <img alt="image"
                                                 src="<?php echo base_url('upload/xerobiz/dummy_author.jpg'); ?>"
                                                 width="70" height="70" style="border:1px solid #eee;"
                                                 data-toggle="tooltip" title="">
                                        <?php endif; ?>
                                        <div class="dropdown dropright avatar-badge">
                                                <span class="dropdown-toggle pointer blue" data-toggle="dropdown"
                                                      aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-cog"></i>
                                                </span>
                                            <div class="dropdown-menu large">
                                                <a
                                                        class="pointer dropdown-item has-icon text-primary update-review-reply"
                                                        data-review-id="<?php echo isset($review['name']) ? $review['name'] : ''; ?>"
                                                        data-review-star="<?php echo isset($review['starRating']) ? $review['starRating'] : ''; ?>"
                                                        data-review-comment="<?php echo isset($review['comment']) ? $review['comment'] : ''; ?>"
                                                        data-location-name="<?php echo isset($review['locationName']) ? $review['locationName'] : ''; ?>"
                                                        data-display-name="<?php echo isset($review['displayName']) ? $review['displayName'] : ''; ?>"
                                                        data-profile-photo="<?php echo isset($review['profilePhotoUrl']) ? $review['profilePhotoUrl'] : ''; ?>"
                                                        data-toggle="tooltip"
                                                        data-original-title="<?php echo $this->lang->line("Update reply to review"); ?>"
                                                >
                                                    <i class="bx bx-edit"></i> <?php echo $this->lang->line('Update review reply'); ?>
                                                </a>
                                                <a
                                                        class="pointer dropdown-item has-icon text-danger delete-review-reply"
                                                        data-toggle="tooltip"
                                                        title="<?php $this->lang->line("Delete review reply"); ?>"
                                                        data-review-id="<?php echo isset($review['name']) ? $review['name'] : ''; ?>"
                                                >
                                                    <i class="bx bx-trash-alt"></i> <?php echo $this->lang->line('Delete review reply'); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="media-title">
                                            <?php echo isset($review['displayName']) ? $review['displayName'] : $this->lang->line('Anonymous'); ?>
                                            &nbsp;
                                            <span class="text-small text-muted">
                                                    <i class="bx bx-time"></i>&nbsp;
                                                    <?php echo date('M j, Y', strtotime($review['createTime'])); ?>
                                                </span>
                                        </div>
                                        <div class="media-title">
                                            <?php if ('FIVE' == $review['starRating']): ?>
                                                <i class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i>
                                            <?php elseif ('FOUR' == $review['starRating']): ?>
                                                <i class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i>
                                            <?php elseif ('THREE' == $review['starRating']): ?>
                                                <i class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i>
                                            <?php elseif ('TWO' == $review['starRating']): ?>
                                                <i class="bx bx-star text-warning"></i><i
                                                        class="bx bx-star text-warning"></i>
                                            <?php elseif ('ONE' == $review['starRating']): ?>
                                                <i class="bx bx-star text-warning"></i>
                                            <?php endif; ?>
                                        </div>
                                        <span class="text-medium text-justify">
                                                <?php echo $review['comment']; ?>
                                            </span>
                                        <?php if (is_array($review['reviewReply']) && count($review['reviewReply'])): ?>
                                            <ul class="list-unstyled list-unstyled-border mt-4 ml-4">
                                                <li class="media mb-0">
                                                    <div class="media-body">
                                                        <?php if (isset($review['reviewReply']['comment'])): ?>
                                                            <div class="d-block">
                                                                <?php echo $review['reviewReply']['comment']; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (isset($review['reviewReply']['updateTime'])): ?>
                                                            <span class="text-small text-muted d-inline">
                                                                    <i class="bx bx-time"></i>
                                                                    &nbsp;&nbsp;
                                                                    <?php echo date('M j, Y', strtotime($review['reviewReply']['updateTime'])); ?>
                                                                </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="update-review-reply-modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <?php echo $this->lang->line('Reply to review'); ?>

                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update-review-reply-form">
                    <div class="form-group">
                        <label>
                            <?php echo $this->lang->line('Reply message'); ?>
                            <a href="#"
                               data-placement="bottom"
                               data-toggle="popover"
                               data-trigger="focus"
                               title="<?php echo $this->lang->line("Spintax"); ?>"
                               data-content="Spintax example : {Hello|Howdy|Hola} to you, {Mr.|Mrs.|Ms.} {{Jason|Malina|Sara}|Williams|Davis}"
                            >
                                <i class='bx bx-info-circle'></i>
                            </a>
                        </label>
                        <textarea id="review-reply-message" class="form-control"></textarea>
                    </div>
                    <input type="hidden" id="review-id">
                    <input type="hidden" id="review-star">
                    <input type="hidden" id="review-comment">
                    <input type="hidden" id="reviewer-location-name">
                    <input type="hidden" id="reviewer-display-name">
                    <input type="hidden" id="reviewer-profile-photo">
                    <input type="hidden" id="reply-type" value="location_manager_index">
                    <button type="submit" class="btn btn-primary btn-shadow"
                            id="update-review-reply-submit"><?php echo $this->lang->line('Reply now'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

