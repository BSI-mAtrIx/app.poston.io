<?php
$include_upload = 0;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
$include_summernote = 0;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 0;
$include_tagsinput = 0;
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

    .media .avatar-item .answer-to-question-box {
        width: 24px;
        height: 24px;
        bottom: -32px;
        left: 24px;
        position: absolute;
        display: flex;
        text-align: center;
        justify-content: center;
        align-items: center;
    }

    .media .avatar-item .answer-to-question-box a {
        width: 24px;
        height: 24px;
        font-size: 24px;
    }

    .question-info {
        line-height: 16px;
    }
</style>

<div class="section-body">
    <div class="row">
        <div id="right_column" class="col-12 col-md-12 col-lg-12 colrig">
            <div class="card main_card shadow-none">
                <div class="card-header p-0 pt-3">
                    <div>
                        <p class="question-info text-muted text-center"><?php echo $this->lang->line('Question & answer report may take upto few minutes/hours to update & synchronize here.'); ?></p>
                    </div>
                    <div class="col-12 p-0">
                        <input type="text" class="form-control float-right" onkeyup="search_in_ul(this,'post_list_ul')"
                               placeholder="Search...">
                    </div>
                </div>
                <div class="card-body p-0 pt-4">

                    <div class="text-center" id="sync_commenter_info_response"></div>
                    <ul class="list-unstyled list-unstyled-border makeScroll" id="post_list_ul"
                        style="max-height:700px;overflow-y: auto;">
                        <?php if (count($questions)): ?>
                            <?php foreach ($questions as $key => $question): ?>
                                <li class="media">
                                    <div class="avatar-item mr-3">
                                        <?php
                                        $isAnswered = isset($question['answers']) && count($question['answers']) ? true : false;
                                        $answerTitle = $isAnswered ? $this->lang->line('Update answer') : $this->lang->line('Answer to Question');
                                        ?>
                                        <?php if (!empty($question['profilePhotoUrl'])): ?>
                                            <img alt="image" src="<?php echo $question['profilePhotoUrl']; ?>"
                                                 width="70" height="70" style="border:1px solid #eee;"
                                                 data-toggle="tooltip" title="">
                                        <?php else: ?>
                                            <img alt="image"
                                                 src="<?php echo base_url('upload/xerobiz/dummy_author.jpg'); ?>"
                                                 width="70" height="70" style="border:1px solid #eee;"
                                                 data-toggle="tooltip" title="">
                                        <?php endif; ?>
                                        <div class="dropdown dropright avatar-badge">
                                                <span class="dropdown-toggle set_cam_by_post pointer blue"
                                                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="bx bx-cog"></i>
                                                </span>
                                            <div class="dropdown-menu large">
                                                <a
                                                        id="answer-to-question-link"
                                                        class="dropdown-item pointer edit_reply_info text-primary"
                                                        data-question-id="<?php echo $question['name']; ?>"
                                                        data-question-text="<?php echo htmlspecialchars($question['text']); ?>"
                                                        data-toggle="tooltip"
                                                        data-original-title="<?php echo $answerTitle; ?>"
                                                >
                                                    <i class="bx bx-edit"></i> <span
                                                            id="question-answer-title"><?php echo $answerTitle; ?></span>
                                                </a>
                                                <?php if ($isAnswered): ?>
                                                    <!--                                                        <a-->
                                                    <!--                                                            id="delete-question-answer-link"-->
                                                    <!--                                                            class="dropdown-item pointer edit_reply_info text-danger"-->
                                                    <!--                                                            data-question-id="--><?php //echo $question['name']; ?><!--"-->
                                                    <!--                                                            data-question-text="--><?php //echo htmlspecialchars($question['text']); ?><!--"-->
                                                    <!--                                                            data-toggle="tooltip"-->
                                                    <!--                                                            data-original-title="--><?php //echo $this->lang->line('Delete answer'); ?><!--"-->
                                                    <!--                                                        >-->
                                                    <!--                                                            <i class="bx bx-trash-alt"></i> --><?php //echo $this->lang->line('Delete answer'); ?>
                                                    <!--                                                        </a>-->
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <div class="d-block">
                                            <strong><?php echo $question['displayName']; ?></strong>
                                        </div>
                                        <div class="media-title d-inline">
                                            <?php echo $question['text'] ?>&nbsp;
                                            <span class="text-small text-muted d-inline">
                                                    <i class="bx bx-time"></i>&nbsp;
                                                    <?php echo date('M j, Y', strtotime($question['createTime'])); ?>
                                                </span>
                                        </div>
                                        <?php if (count($question['answers'])): ?>
                                            <ul class="list-unstyled list-unstyled-border mt-4 ml-4">
                                                <?php foreach ($question['answers'] as $answer): ?>
                                                    <li class="media mb-0">
                                                        <div class="avatar-item mr-3">
                                                            <?php if (!empty($question['profilePhotoUrl'])): ?>
                                                                <img alt="image"
                                                                     src="<?php echo $answer['profilePhotoUrl']; ?>"
                                                                     width="42" height="42"
                                                                     style="border:1px solid #eee;"
                                                                     data-toggle="tooltip" title="">
                                                            <?php else: ?>
                                                                <img alt="image"
                                                                     src="<?php echo base_url('upload/xerobiz/dummy_author.jpg'); ?>"
                                                                     width="42" height="42"
                                                                     style="border:1px solid #eee;"
                                                                     data-toggle="tooltip" title="">
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="d-block">
                                                                <strong><?php echo $answer['displayName']; ?></strong>
                                                            </div>
                                                            <div class="media-title">
                                                                <?php echo $answer['text'] ?>&nbsp;
                                                                <span class="text-small text-muted d-inline">
                                                                    <i class="bx bx-time"></i>&nbsp;
                                                                    <?php echo date('M j, Y', strtotime($answer['createTime'])); ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
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


<div class="modal fade" tabindex="-1" role="dialog" id="answer-to-question-modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $this->lang->line("Answer to question"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="answer-to-question-form">
                    <div class="form-group">
                        <label><?php echo $this->lang->line("Answer"); ?></label>
                        <textarea id="answer-to-question-message" class="form-control"></textarea>
                    </div>
                    <input type="hidden" id="question-id">
                    <input type="hidden" id="question-text">
                    <button type="submit" class="btn btn-primary btn-shadow"
                            id="answer-to-question-submit"><?php echo $this->lang->line("Answer now"); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

