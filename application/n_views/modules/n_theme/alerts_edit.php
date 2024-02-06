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
                    <form class="form repeater-default" action="<?php echo site_url() . 'n_theme/alerts_save' ?>"
                          method="POST">
                        <div data-repeater-list="group-a">
                            <?php if (empty($data_json)) { ?>
                                <div data-repeater-item>
                                    <div class="row justify-content-between">
                                        <div class="col-md-4 col-sm-12 form-group">
                                            <label for="default"><?php echo $this->lang->line("Default lang"); ?> </label>
                                            <input type="text" class="form-control" id="default" name="default"
                                                   placeholder="default">


                                            <h6 class="mt-2"><?php echo $this->lang->line("Alert type"); ?></h6>
                                            <div class="form-group">
                                                <?php
                                                $select_lan = 'alert-primary';
                                                $options = array();
                                                $options['alert-primary'] = 'alert-primary';
                                                $options['alert-danger'] = 'alert-danger';
                                                $options['alert-warning'] = 'alert-warning';
                                                $options['alert-success'] = 'alert-success';
                                                $options['alert-info'] = 'alert-info';
                                                $options['alert-secondary'] = 'alert-secondary';

                                                $options['border-primary'] = 'border-primary';
                                                $options['border-danger'] = 'border-danger';
                                                $options['border-warning'] = 'border-warning';
                                                $options['border-success'] = 'border-success';
                                                $options['border-info'] = 'border-info';
                                                $options['border-secondary'] = 'border-secondary';

                                                $options['bg-rgba-primary'] = 'bg-rgba-primary';
                                                $options['bg-rgba-danger'] = 'bg-rgba-danger';
                                                $options['bg-rgba-warning'] = 'bg-rgba-warning';
                                                $options['bg-rgba-success'] = 'bg-rgba-success';
                                                $options['bg-rgba-info'] = 'bg-rgba-info';
                                                $options['bg-rgba-secondary'] = 'bg-rgba-secondary';


                                                echo form_dropdown('alert_type', $options, $select_lan, 'class="select2 form-control" id="alert_type"'); ?>
                                            </div>

                                            <button class="btn btn-danger text-nowrap px-1 mt-2" data-repeater-delete
                                                    type="button"><i class="bx bx-x"></i>
                                                <?php echo $this->lang->line("Delete"); ?>
                                            </button>


                                        </div>
                                        <div class="col-md-8 col-sm-12 form-group">
                                            <?php
                                            ksort($language_info);
                                            foreach ($language_info as $key_lang => $value_lang) { ?>

                                                <label for="alert_<?php echo $key_lang; ?>"><?php echo $this->lang->line("Alert text"); ?><?php echo $key_lang; ?></label>
                                                <textarea class="form-control" id="alert_<?php echo $key_lang; ?>"
                                                          name="alert_text_<?php echo $key_lang; ?>"
                                                          placeholder="Alert text"></textarea>

                                            <?php } ?>


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
                                                <label for="default"><?php echo $this->lang->line("Default lang"); ?> </label>
                                                <input type="text" class="form-control" id="default"
                                                       name="group-a[<?php echo $k; ?>][default]"
                                                       value="<?php echo $v['default']; ?>" placeholder="default">

                                                <h6 class="mt-2"><?php echo $this->lang->line("Alert type"); ?></h6>
                                                <div class="form-group">
                                                    <?php
                                                    $select_lan = $v['alert_type'];
                                                    $options = array();
                                                    $options['alert-primary'] = 'alert-primary';
                                                    $options['alert-danger'] = 'alert-danger';
                                                    $options['alert-warning'] = 'alert-warning';
                                                    $options['alert-success'] = 'alert-success';
                                                    $options['alert-info'] = 'alert-info';
                                                    $options['alert-secondary'] = 'alert-secondary';

                                                    $options['border-primary'] = 'border-primary';
                                                    $options['border-danger'] = 'border-danger';
                                                    $options['border-warning'] = 'border-warning';
                                                    $options['border-success'] = 'border-success';
                                                    $options['border-info'] = 'border-info';
                                                    $options['border-secondary'] = 'border-secondary';

                                                    $options['bg-rgba-primary'] = 'bg-rgba-primary';
                                                    $options['bg-rgba-danger'] = 'bg-rgba-danger';
                                                    $options['bg-rgba-warning'] = 'bg-rgba-warning';
                                                    $options['bg-rgba-success'] = 'bg-rgba-success';
                                                    $options['bg-rgba-info'] = 'bg-rgba-info';
                                                    $options['bg-rgba-secondary'] = 'bg-rgba-secondary';


                                                    echo form_dropdown('group-a[' . $k . '][alert_type]', $options, $select_lan, 'class="select2 form-control" id="alert_type"'); ?>
                                                </div>

                                                <button class="btn btn-danger text-nowrap px-1 mt-2"
                                                        data-repeater-delete type="button"><i
                                                            class="bx bx-x"></i>
                                                    <?php echo $this->lang->line("Delete"); ?>
                                                </button>
                                            </div>
                                            <div class="col-md-8 col-sm-12 form-group">
                                                <?php
                                                ksort($language_info);
                                                foreach ($language_info as $key_lang => $value_lang) {
                                                    if (empty($v['alert_text_' . $key_lang])) {
                                                        $v['alert_text_' . $key_lang] = '';
                                                    }
                                                    ?>

                                                    <label for="alert_<?php echo $key_lang; ?>"><?php echo $this->lang->line("Alert text"); ?><?php echo $key_lang; ?></label>
                                                    <textarea class="form-control"
                                                              name="group-a[<?php echo $k; ?>][alert_text_<?php echo $key_lang; ?>]"
                                                              id="alert_<?php echo $key_lang; ?>"
                                                              placeholder="Alert text"><?php echo $v['alert_text_' . $key_lang]; ?></textarea>

                                                <?php } ?>
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

