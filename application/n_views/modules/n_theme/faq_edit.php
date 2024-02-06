<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $this->lang->line("FAQ"); ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message');
$jodit = 1; ?>


<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo $this->lang->line('FAQ'); ?></h4>
                </div>
                <div class="card-body">
                    <form class="form repeater-default"
                          action="<?php echo site_url() . 'n_theme/faq_save/' . $lang_faq . '/' . $file_save; ?>"
                          method="POST">
                        <div data-repeater-list="group-a">
                            <?php if (empty($data_json)) { ?>
                                <div data-repeater-item>
                                    <div class="row justify-content-between">
                                        <div class="col-md-4 col-sm-12 form-group">
                                            <label for="question"><?php echo $this->lang->line("Question"); ?> </label>
                                            <input type="text" class="form-control" id="question" name="question"
                                                   placeholder="Question">
                                            <button class="btn btn-danger text-nowrap px-1 mt-2" data-repeater-delete
                                                    type="button"><i
                                                        class="bx bx-x"></i>
                                                <?php echo $this->lang->line("Delete"); ?>
                                            </button>
                                        </div>
                                        <div class="col-md-8 col-sm-12 form-group">
                                            <label for="answer"><?php echo $this->lang->line("Answer"); ?></label>
                                            <textarea class="form-control" id="answer" name="answer"
                                                      placeholder="Answer"></textarea>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            <?php } else {
                                foreach ($data_json['group-a'] as $k => $v) {
                                    ?>
                                    <div data-repeater-item>
                                        <div class="row justify-content-between">
                                            <div class="col-md-4 col-sm-12 form-group">
                                                <label for="question"><?php echo $this->lang->line("Question"); ?> </label>
                                                <input type="text" class="form-control" id="question"
                                                       name="group-a[<?php echo $k; ?>][question]"
                                                       placeholder="Question" value="<?php echo $v['question']; ?>">
                                                <button class="btn btn-danger text-nowrap px-1 mt-2"
                                                        data-repeater-delete type="button"><i
                                                            class="bx bx-x"></i>
                                                    <?php echo $this->lang->line("Delete"); ?>
                                                </button>
                                            </div>
                                            <div class="col-md-8 col-sm-12 form-group">
                                                <label for="answer"><?php echo $this->lang->line("Answer"); ?></label>
                                                <textarea class="form-control" id="answer"
                                                          name="group-a[<?php echo $k; ?>][answer]"
                                                          placeholder="Answer"><?php echo $v['answer']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                <?php }
                            } ?>
                        </div>


                        <div class="form-group">
                            <div class="col p-0">
                                <button class="btn btn-primary" data-repeater-create type="button"><i
                                            class="bx bx-plus"></i>
                                    Add
                                </button>
                                <button class="btn btn-primary" id="save-btn" type="submit"><i class="bx bx-save"></i>
                                    <span class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span>
                                </button>
                            </div>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>
</div>

