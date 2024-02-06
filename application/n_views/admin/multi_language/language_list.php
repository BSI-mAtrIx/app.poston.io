<style>.no_hover:hover {
        text-decoration: none;
    }</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('multi_language/index'); ?>"><?php echo $this->lang->line("Language Editor"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>
<div class="section-body">
    <div class="card">
        <div class="card-footer bg-whitesmoke">
            <a class="btn btn-primary add text-center" href="<?php echo base_url('multi_language/create_new_lang'); ?>">
                <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add New Language'); ?>
            </a>
            <a class="btn btn-outline-danger delete  float-right text-center" href="#">
                <i class="bx bx-trash"></i> <?php echo $this->lang->line('Delete Language'); ?>
            </a>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a id="systemTab" class="nav-link active" data-toggle="tab" href="#fbinboxer_languages_tab"
                       role="tab"
                       aria-selected="false"><?php echo $this->lang->line('System Languages') . ' ' . " (" . count($lang) . ")"; ?></a>
                </li>
                <li class="nav-item hidden">
                    <a id="addonTab" class="nav-link" data-toggle="tab" href="#addons_languages_tab" role="tab"
                       aria-selected="true"> <?php echo $this->lang->line("Add-ons Languages") . " (" . count($addons) . ")"; ?></a>
                </li>
                <li class="nav-item">
                    <a id="pluginTab" class="nav-link" data-toggle="tab" href="#plugins_languages_tab" role="tab"
                       aria-selected="false"><?php echo $this->lang->line("3rd Party Languages") . " (" . count($plugins_files) . ")"; ?></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="fbinboxer_languages_tab" role="tabpanel"
                     aria-labelledby="systemTab">
                    <section id="main_application_section">
                        <div class="row">
                            <?php
                            $i = 0;
                            foreach ($lang as $lang_name) : ?>
                                <div class="col-12 col-md-3 col-lg-3 text-center">
                                    <input type="hidden" name="folder_type" value="main-application_<?php echo $i; ?>">
                                    <div class="card card">
                                        <div class="card-header">
                                            <h4><i class="bx bx-folder-open"></i> <?php echo $lang_name; ?></h4>
                                        </div>
                                        <div class="card-footer">
                                            <a href="<?php echo base_url("multi_language/edit_language/" . $lang_name . "/main_app"); ?>"
                                               class="float-left btn-sm btn btn-outline-warning edit_btn">
                                                <i class="bx bx-edit"></i> <?php echo $this->lang->line("Edit"); ?>
                                            </a>
                                            <a target="_blank" class="btn btn-sm btn-outline-primary float-right"
                                               title="<?php echo $this->lang->line("Download this as backup") ?>"
                                               href="<?php echo base_url("multi_language/downloading_language_folder_zip/" . $lang_name . "/main_app"); ?>">
                                                <i class="bx bx-cloud-download"></i> <?php echo $this->lang->line("Download"); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endforeach; ?>

                        </div>
                    </section>
                </div>

                <div class="tab-pane fade hidden" id="addons_languages_tab" role="tabpanel" aria-labelledby="addonTab">
                    <section id="addon_section">
                        <div class="row">
                            <?php
                            $i = 0;
                            foreach ($addons as $addon_name) : ?>
                                <div class="col-12 col-md-3 col-lg-3">
                                    <div class="card card">
                                        <div class="card-header">
                                            <h4>
                                                <i class="bx bx-tag"></i> <?php echo str_replace("_", " ", $addon_name); ?>
                                            </h4>
                                        </div>
                                        <div class="card-footer">
                                            <div class="action_btn" file_type="add-on_<?php echo $i; ?>">
                                                <a href="<?php echo base_url("multi_language/edit_language/" . $addon_name . "/addon"); ?>"
                                                   class="float-left btn-sm btn btn-outline-warning edit_btn">
                                                    <i class="bx bx-edit"></i> <?php echo $this->lang->line("Edit"); ?>
                                                </a>
                                                <a id="addons"
                                                   class="btn btn-sm btn-outline-primary float-right download_addon"
                                                   addonname="<?php echo $addon_name; ?>" href=""
                                                   title="<?php echo $this->lang->line("Download this as backup") ?>"><i
                                                            class="bx bx-cloud-download"></i> <?php echo $this->lang->line("Download"); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endforeach; ?>
                        </div>
                    </section>
                </div>

                <div class="tab-pane fade" id="plugins_languages_tab" role="tabpanel" aria-labelledby="pluginTab">
                    <section id="plugin_section">
                        <div class="row">
                            <?php
                            $i = 0;
                            foreach ($plugins_files as $file_name) : ?>

                                <div class="col-12 col-md-3 col-lg-3 text-center">
                                    <div class="card card">
                                        <div class="card-header">
                                            <h4>
                                                <i class="bx bx-folder-open"></i> <?php echo str_replace(".json", "", $file_name); ?>
                                            </h4>
                                        </div>
                                        <div class="card-footer">
                                            <div class="action_btn" file_type="plugin_<?php echo $i; ?>">
                                                <?php $file_name = str_replace('.json', '', $file_name); ?>
                                                <a title="<?php echo $this->lang->line("Update this language") ?>"
                                                   href="<?php echo base_url("multi_language/edit_language/" . $file_name . "/plugin"); ?>"
                                                   class="float-left btn-sm btn btn-outline-warning edit_btn">
                                                    <i class="bx bx-edit"></i> <?php echo $this->lang->line("edit"); ?>
                                                </a>
                                                <a target="_blank" class="btn btn-sm btn-outline-primary float-right"
                                                   title="<?php echo $this->lang->line("Download this as backup") ?>"
                                                   href="<?php echo base_url("multi_language/downloading_language_folder_zip/" . $file_name . "/plugin"); ?>">
                                                    <i class="bx bx-cloud-download"></i> <?php echo $this->lang->line("Download"); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endforeach; ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="language_file_modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-trash"></i> <?php echo $this->lang->line("Select Language"); ?>
                </h3>
                <button type="button" class="close" id='modal_close' data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div id="response_status"></div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="d-none" id="addon_names"></div>
                        <blockquote class="d-none" id="addon_type"></blockquote>
                        <div id="languageDataBody">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?php $this->load->view("admin/multi_language/styles"); ?>