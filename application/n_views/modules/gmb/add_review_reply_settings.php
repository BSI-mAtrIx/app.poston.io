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
                                <select class="select2 form-control" id="star_rating" name="star_rating">
                                    <option value=""><?php echo $this->lang->line("Select rating"); ?></option>
                                    <option value="five_star"><?php echo $this->lang->line("5 Star"); ?></option>
                                    <option value="four_star"><?php echo $this->lang->line("4 Star"); ?></option>
                                    <option value="three_star"><?php echo $this->lang->line("3 Star"); ?></option>
                                    <option value="two_star"><?php echo $this->lang->line("2 Star"); ?></option>
                                    <option value="one_star"><?php echo $this->lang->line("1 Star"); ?></option>
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
                                    <div class="form-group">
                                        <label for=""> <?php echo $this->lang->line('Reply type'); ?></label>
                                        <div class="custom-switches-stacked mt-2">
                                            <div class="row">
                                                <div class="col-6 col-md-4">
                                                    <label class="custom-switch">
                                                        <input type="radio" name="reply_type" value="generic" checked
                                                               class="custom-switch-input">
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description"><?php echo $this->lang->line("Generic"); ?></span>
                                                    </label>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label class="custom-switch">
                                                        <input type="radio" name="reply_type" value="keyword"
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
                                    <?php echo $this->lang->line("Message for generic reply.") ?>
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
                                <textarea id="generic_message" name="generic_message" class="form-control"></textarea>
                            </div>

                            <!-- reply message block -->
                            <div class="reply_settings_block">
                                <div class="card card-info single_card">
                                    <div class="card-header">
                                        <h4><?php echo $this->lang->line("Keyword"); ?></h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="keyword_settings"> <?php echo $this->lang->line("Keyword") ?> </label>
                                            <input name="keyword_settings[]" class="form-control keyword_word_input"
                                                   type="text">
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
                                            <textarea name="reply_settings[]" class="form-control"
                                                      id="reply_settings"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix add_more_button_block">
                                    <input type="hidden" id="content_block" value="1">
                                    <input type="hidden" id="odd_or_even" value="odd">
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
                                    <textarea id="not_found_reply_settings" name="not_found_reply_settings"
                                              class="form-control"></textarea>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer">
                        <button id="create_template" type="button" class="btn btn-primary"><i
                                    class="bx bx-save"></i> <?php echo $this->lang->line('Add Settings'); ?></button>
                        <a href="<?php echo base_url('gmb/add_settings'); ?>"
                           class="btn float-right btn-secondary cancel_template"><i
                                    class="bx bx-x"></i> <?php echo $this->lang->line('Cancel'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


