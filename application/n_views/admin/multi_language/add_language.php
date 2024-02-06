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
        <div class="card-footer bg-whitesmoke language_name_field">
            <br>
            <div class="form-group">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="language_name" name="language_name"
                           placeholder="<?php echo $this->lang->line("language name"); ?>" aria-label="">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" id="save_language_name"><i
                                    class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Language"); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a id="main_tab" class="nav-link active" data-toggle="tab" href="#fbinboxer_languages_tab"
                       role="tab" aria-selected="false"><?php echo $this->lang->line('System Languages'); ?></a>
                </li>
                <li class="nav-item hidden">
                    <a id="addon_tab" class="nav-link" data-toggle="tab" href="#addons_languages_tab" role="tab"
                       aria-selected="true"> <?php echo $this->lang->line("Add-ons Languages"); ?></a>
                </li>
                <li class="nav-item">
                    <a id="plugin_tab" class="nav-link" data-toggle="tab" href="#plugins_languages_tab" role="tab"
                       aria-selected="false"><?php echo $this->lang->line("3rd Party Languages"); ?></a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="fbinboxer_languages_tab" role="tabpanel"
                     aria-labelledby="main_tab">
                    <section id="main_app_section">
                        <div class="row" style="padding: 0px 0px 0 9px !important;">
                            <?php
                            $i = 0;
                            foreach ($file_name as $value) : ?>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-12 text-center language_file"
                                     file_type="main-application_<?php echo $i; ?>" file_name="<?php echo $value; ?>">
                                    <div class="card">
                                        <div class="card-header langFile">
                                            <i class="bx bx-file"></i>&nbsp;<?php echo $value; ?>&nbsp;
                                            <i id="<?php echo str_replace(".php", '', $value); ?>"
                                               style="color:#13d408;display: none;" class="bx bx-check-circle"></i>
                                        </div>
                                    </div>
                                </div> <?php
                                $i++;
                            endforeach;
                            ?>
                        </div>
                    </section>
                </div>

                <!--               <div class="tab-pane fade hidden" id="addons_languages_tab" role="tabpanel" aria-labelledby="addon_tab">
                <section id="addon_section">
		      		<div class="row" style="padding: 0px 0px 0 9px !important;">
		      			<?php $i = 0;
                foreach ($addons as $addon): ?>
		      			<div class="col-lg-3 col-xs-12 col-md-3 col-sm-12 text-center language_file" id="addons" file_type="add-on_<?php echo $i; ?>">
							<div class="card">
			                  <div class="card-header langFile">
			                    <i class="bx bx-tag"></i> &nbsp;<?php echo str_replace(array('.php', '_', 'lang'), ' ', $addon); ?>
								<i id="<?php echo str_replace(".php", '', $value); ?>" style="color:#13d408;display: none;" class="bx bx-check-circle"></i>
								&nbsp;<i id="<?php echo str_replace(array('.php', '_', 'lang'), array('', '', ''), $addon); ?>" style="color:#13d408; display: none;" class="bx bx-check-circle"></i>
			                  </div>
			                </div>
		      			</div>
		      			<?php $i++; endforeach; ?>
		      		</div>
				</section>
              </div> -->

                <div class="tab-pane fade" id="plugins_languages_tab" role="tabpanel" aria-labelledby="plugin_tab">
                    <section id="plugin_section">
                        <div class="row">
                            <div class="language_file" file_type="plugin_0" id="plugins">
                                <div class="card">
                                    <div class="card-header langFile">
                                        <i class="bx bx-plug"></i>
                                        &nbsp;<?php echo $this->lang->line("Plugin Languages"); ?>
                                        &nbsp;<i id="plugins1" style="color:#13d408;display: none;"
                                                 class="bx bx-check-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


<?php $giveAname = $this->lang->line("Please put a language name & then save."); ?>


<div class="modal fade" tabindex="-1" role="dialog" id="language_file_modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i
                            class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Add Language Translation"); ?>
                </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">

                <div class="section-title mt-0 d-none" id="language_type_modal"></div>
                <blockquote class="d-none" id="new_lang_val"></blockquote>

                <div class="row">
                    <div id="response_status"></div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <input type="text" name="search_index" id="search_index" class="form-control"
                                   style="width:50%;" placeholder="<?php echo $this->lang->line('search...'); ?>"
                                   onkeyup="search_in_td(this,'add_language_form_table')">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div id="languageDataBody">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" form_id="language_creating_form" class="btn btn-primary save_language_button"><i
                            class="bx bxs-save"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("save"); ?></span></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash"></i> <span
                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view("admin/multi_language/styles"); ?>