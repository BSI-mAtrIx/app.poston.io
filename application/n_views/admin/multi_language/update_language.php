<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 0;
$include_jqueryui = 0;
$include_mCustomScrollBar = 1;
$include_dropzone = 0;
?>

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
        <?php
        if ($languageName == "main_app") { ?>
            <div class="card">
                <div class="card-footer bg-whitesmoke language_name_field">
                    <?php
                    if ($languagename != "english") { ?>
                        <br>
                        <div class="form-group">
                            <div class="input-group mb-3" id="languagename_field">
                                <input type="text" class="form-control" id="language_name" name="language_name"
                                       value="<?php echo $languagename; ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" id="update_language_name"><i
                                                class="bx bxs-save"></i> <?php echo $this->lang->line("Update Language"); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else { ?>
                        <input type="hidden" name="language_name" id="language_name"
                               value="<?php echo $languagename; ?>">
                        <div class="not_english text-center alert alert-warning">
                            <?php echo $this->lang->line("English language name can not be updated. You Can update the content if you like."); ?>
                        </div>
                        <?php
                    } ?>
                </div>

                <div class="card-header">
                    <h4 class="text-center"
                        style="width: 100%"><?php echo $this->lang->line('System Languages') . " : " . $languagename . " (" . count($folderFiles) . " " . $this->lang->line('files') . ")"; ?></h4>
                </div>

                <div class="card-body">
                    <?php
                    if (!empty($folderFiles)) {
                        $i = 0;
                        echo '<div class="row">';
                        foreach ($folderFiles as $value) { ?>

                            <div class="col-lg-3 col-12 text-center allFiles"
                                 file_type="main-application_<?php echo $i; ?>" file_name="<?php echo $value; ?>">
                                <div class="card">
                                    <div class="card-header pointer">
                                        <i class="bx bx-file"></i>&nbsp;<?php echo $value; ?>&nbsp;
                                        <i id="<?php echo str_replace(".php", '', $value); ?>"
                                           style="color:#13d408;display: none;" class="bx bx-check-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <?php $i++;
                        }
                        echo '</div>';
                    } else { ?>
                        <div class="text-center alert alert-warning">
                            <?php echo $this->lang->line("English language name can not be updated. You Can update the content if you like."); ?>
                        </div>
                        <?php
                    } ?>
                </div>

            </div>
            <?php
        } else if ($languageName == "plugin") { ?>
            <div class="card">

                <div class="card-header">
                    <h4 class="text-center"
                        style="width: 100%"><?php echo $this->lang->line('3rd Party Languages') . " : " . $plugin_file; ?></h4>
                </div>

                <div class="card-body">
                    <input type="hidden" id="language_name" name="language_name" value="<?php echo $plugin_file; ?>"
                           class="form-control text-center">

                    <div class="col-lg-6 col-12 text-center allFiles" file_type="plugin_0" id="plug">
                        <div class="card">
                            <div class="card-header pointer">
                                <i class="bx bx-plug"></i>&nbsp;<?php echo $plugin_file; ?>&nbsp;
                                <i id="plugins1" style="color:#13d408;display: none;" class="bx bx-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php
        } else if ($languageName == "addon") { ?>
            <!-- 			<div class="card">

	          <div class="card-header">
	          	<h4 class="text-center" style="width: 100%"><?php echo ucfirst(str_replace("_", ' ', $languagename)) . " " . $this->lang->line('Add-on Languages') . " (" . count($module_language_folders) . " " . $this->lang->line('files') . ")"; ?></h4>
	          </div>

	          <div class="card-body">
	          	<input type="hidden" id="language_name" name="language_name" value="<?php echo $languagename; ?>" class="form-control text-center" style="font-size: 14px;">

	          	<?php
            if (!empty($module_language_folders)) {
                $i = 0;
                echo '<div class="row">';
                foreach ($module_language_folders as $value) { ?>
		          		<div class="col-lg-3 col-12 text-center allFiles" file_type="add-on_<?php echo $i; ?>" folderName="<?php echo $value; ?>" id="addons">
		          			
		          			<div class="card">
			                  <div class="card-header pointer">
			                    <i class="bx bx-folder-open"></i>&nbsp;<?php echo ucfirst($value); ?>&nbsp;
								<i id="<?php echo $value; ?>" style="color:#13d408;display: none;" class="bx bx-check-circle"></i>
			                  </div>
			                </div>
		          		</div>
		          		
		          		<?php
                    $i++;
                }
                echo '</div>';
            } else { ?>
          			<div class="text-center alert alert-warning">
	          			<?php echo $this->lang->line("This language folder is empty. No files to show"); ?>
	          		</div>
	          	<?php
            } ?>
	          </div> 
	        </div> -->
            <?php
        } ?>
    </div>


<?php
$giveAname = $this->lang->line("Please put a language name & save it first.");
$editable_language = $this->uri->segment(3);
?>


    <div class="modal fade" tabindex="-1" role="dialog" id="language_file_modal" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document" style="min-width: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><i
                                class="bx bx-edit"></i> <?php echo $this->lang->line("Edit Language Translation"); ?>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row">
                        <div id="response_status"></div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="section-title mt-0 d-none" id="languName"></div>
                            <blockquote class="d-none" id="addon_languName"></blockquote>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="search_update_index" id="search_update_index"
                                               class="form-control" style="width:50%;"
                                               placeholder="<?php echo $this->lang->line('search...'); ?>"
                                               onkeyup="search_in_td(this,'update_language_form_table')">
                                    </div>
                                </div>
                            </div>
                            <div id="languageDataBody">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button form_id="language_creating_form" class="btn btn-primary update_language_button"><i
                                class="bx bxs-save" aria-hidden="true"></i> <?php echo $this->lang->line("Save"); ?>
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash"></i>
                        <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
                </div>
            </div>
        </div>
    </div>


<?php $this->load->view("admin/multi_language/styles"); ?>