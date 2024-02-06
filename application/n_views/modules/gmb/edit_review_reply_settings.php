<?php
$include_upload = 1;  //upload_js
$include_datatable = 1; //datatables
$include_datetimepicker = 1; //datetimepicker, daterange, moment
$include_emoji = 1;
$include_summernote = 1;
$include_colorpicker = 0;
$include_select2 = 1;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 1;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 0;
?>
<section class="section section_custom">

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-none">

                    <div class="card-body p-0 pt-2">
                        <form id="auto_reply_templete_form" action="#" method="post">
                            <input type="hidden" name="action_type" value="create">

                            <!-- rating block -->
                            <div class="form-group">
                                <label for="star_rating"> <?php echo $this->lang->line("Select rating") ?> </label>
                                <?php
                                $stars = [5 => 'five_star', 4 => 'four_star', 3 => 'three_star', 2 => 'two_star', 1 => 'one_star'];
                                $star_rating = isset($rating_details['star_rating']) ? $rating_details['star_rating'] : '';
                                ?>
                                <select class="select2 form-control" id="star_rating" name="star_rating">
                                    <option value=""><?php echo $this->lang->line("Select rating"); ?></option>
                                    <?php
                                    for ($i = 5; $i >= 1; $i--):
                                        $selected = ($star_rating == $stars[$i]) ? ' selected' : '';
                                        ?>
                                        <option value="<?php echo $stars[$i]; ?>" <?php echo $selected; ?>><?php echo $i . ' ' . $this->lang->line("Star"); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- offensive words -->
                            <div class="form-group" id="offensive_keywords_block">
                                <label for="offensive_keywords"> <?php echo $this->lang->line("Offensive keywords (press enter to separate words)") ?>
                                </label>
                                <textarea id="offensive_keywords" name="offensive_keywords"
                                          class="form-control inputtags"></textarea>
                            </div>

                            <!-- generic and keyword state block -->
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <?php
                                    $reply_type = isset($rating_details['reply_type']) ? $rating_details['reply_type'] : '';
                                    ?>
                                    <div class="form-group">
                                        <label for=""> <?php echo $this->lang->line('Reply type'); ?></label>
                                        <div class="custom-switches-stacked mt-2">
                                            <div class="row">
                                                <div class="col-6 col-md-4">
                                                    <label class="custom-switch">
                                                        <input id="reply_type_generic" type="radio" name="reply_type"
                                                               value="generic" <?php echo ('generic' == $reply_type) ? 'checked' : ''; ?>
                                                               class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description"><?php echo $this->lang->line("Generic"); ?></span>
                                                    </label>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label class="custom-switch">
                                                        <input id="reply_type_keyword" type="radio" name="reply_type"
                                                               value="keyword" <?php echo ('keyword' == $reply_type) ? 'checked' : ''; ?>
                                                               class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description"><?php echo $this->lang->line("Keyword"); ?></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- generic message block -->
                            <div class="form-group generic_message_block">
                                <label for="generic_message">
                                    <?php echo $this->lang->line("Message for generic reply") ?>
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
                                <?php $generic_message = isset($rating_details['generic_message']) ? $rating_details['generic_message'] : ''; ?>
                                <textarea id="generic_message" name="generic_message"
                                          class="form-control"><?php echo htmlspecialchars($generic_message); ?></textarea>
                            </div>

                            <!-- reply message block -->
                            <div class="reply_settings_block">
                                <?php if (isset($rating_details['keyword_settings']) && count($rating_details['keyword_settings'])):
                                    $i = 0;
                                    foreach ($rating_details['keyword_settings'] as $key => $keyword_settings):
                                        $i++;
                                        $odd_even = (0 == $i / 2) ? 'even' : 'odd';
                                        ?>

                                        <div class="card card-info single_card">
                                            <div class="card-header justify-content-between">
                                                <h4><?php echo $this->lang->line("Keyword"); ?></h4>
                                                <?php if ($i > 1): ?>
                                                    <div>
                                                        <button class="btn btn-outline-secondary remove_div">
                                                            <i class="bx bx-x"></i>&nbsp;
                                                            <?php echo $this->lang->line('Remove'); ?>
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="keyword_settings"> <?php echo $this->lang->line("Keyword") ?> </label>
                                                    <input name="keyword_settings[]"
                                                           class="form-control keyword_word_input" type="text"
                                                           value="<?php echo htmlspecialchars($keyword_settings); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="reply_settings">
                                                        <?php echo $this->lang->line("Reply message") ?>
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
                                                    <?php
                                                    $reply_settings = isset($rating_details['reply_settings'][$key]) ? $rating_details['reply_settings'][$key] : '';
                                                    ?>
                                                    <textarea name="reply_settings[]" class="form-control"
                                                              id="reply_settings"><?php echo $reply_settings; ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <div class="clearfix add_more_button_block">
                                    <input type="hidden" id="content_block" value="<?php echo $i; ?>">
                                    <input type="hidden" id="odd_or_even" value="<?php echo $odd_even; ?>">
                                    <button class="btn btn-outline-primary float-right" id="add_more_keyword_button"><i
                                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add more settings') ?>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <label for="not_found_reply_settings">
                                        <?php echo $this->lang->line("Message for no match") ?>
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
                                    <?php $not_found_reply_settings = isset($rating_details['not_found_reply_settings']) ? $rating_details['not_found_reply_settings'] : ''; ?>
                                    <textarea id="not_found_reply_settings" name="not_found_reply_settings"
                                              class="form-control"><?php echo htmlspecialchars($not_found_reply_settings); ?></textarea>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer">
                        <button id="create_template" type="button" class="btn btn-primary"><i
                                    class="bx bx-save"></i> <?php echo $this->lang->line('Update Settings'); ?></button>
                        <a href="<?php echo base_url('gmb/review_replies'); ?>"
                           class="btn float-right btn-secondary cancel_template"><i
                                    class="bx bx-x"></i> <?php echo $this->lang->line('Cancel'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


