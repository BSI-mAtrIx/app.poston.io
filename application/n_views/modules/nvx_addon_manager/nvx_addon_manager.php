<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">

    <div class="row">


        <div class="col-12">

            <div class="card">
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line("Documentation (Help page)"); ?>: <br/>
                            <a href="https://nvxgroup.com/docs/" target="_blank">
                                <?php echo $this->lang->line("Go to Documentation"); ?>
                            </a>
                        </h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">

            <div class="card">
                <div class="card-wrap">
                    <div class="card-header">
                        <h4><?php echo $this->lang->line("Join to our group on Facebook"); ?>: <br/> <a
                                    href="https://www.facebook.com/groups/457356838761613"
                                    target="_blank"><?php echo $this->lang->line("Go to Facebook"); ?></a></h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">

            <div class="card">
                <div class="card-wrap">
                    <div class="card-header">
                        <h4><?php echo $this->lang->line("BUG Reports"); ?>: <br/> <a
                                    href="https://docs.google.com/forms/d/e/1FAIpQLSetMDrc-b4cHUHtD_BF1td0caYInkPwPTxWKWxW9tZYmZ-zJw/viewform"
                                    target="_blank"><?php echo $this->lang->line("Go to BUG Report Form"); ?></a></h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4 col-md-4 col-sm-12">

            <div class="card">
                <div class="card-wrap">
                    <div class="card-header">
                        <h4><?php echo $this->lang->line("Like my job?"); ?> <br/> <a
                                    href="https://nvxgroup.com/donate-for-hard-work-and-yerba-mate/"
                                    target="_blank"><?php echo $this->lang->line("Go to TIP"); ?></a></h4>
                    </div>
                </div>
            </div>

        </div>


    </div>

    <div class="card">

        <div class="card-header">
            <h4 style="width: 100%">
                <i class="bx bx-wrench"></i>&nbsp; <span
                        id="get_nviews_title_1019">Re-design dashboard UI XeroChat</span>
                <?php if ($nviews['installed'] == 1) { ?> <span class="badge badge-light"><i
                            class="bx bx-check-circle"></i> <?php echo $this->lang->line("Active"); ?></span> <?php } ?>
                <?php if ($nviews['installed'] == 0) { ?> <span class='badge badge-light'><i
                            class='bx bx-block'></i> <?php echo $this->lang->line("Inactive"); ?></span> <?php } ?>
                <?php if ($nviews['code'] == 0) { ?><span class='badge badge-light'><i
                        class='bx bx-block'></i> <?php echo $this->lang->line("Purchase code invalid"); ?>
                    </span><?php } ?>
                <code class="float-right">
                    <?php if (!empty($nviews['version'])) {
                        echo $this->lang->line('Your Version'); ?> : <b>v<?php echo $nviews['version']; ?></b>
                        <br/><?php } ?>
                    <?php if (!empty($nviews['Latest_Version']) and $nviews['Latest_Version'] > $nviews['version']) {
                        echo $this->lang->line('New Version'); ?> : <b>
                        v<?php echo $nviews['Latest_Version']; ?></b><?php } ?>
                </code>
            </h4>
        </div>

        <div class="card-body">
            <p class="text-danger">Please check News before update XeroChat. Always update first NVX Addon Manager.</p>

            <?php if ($nviews['downloaded'] == 1 and $nviews['activated'] == 1) { ?>

                <a title="<?php echo $this->lang->line("Deactivate"); ?>"
                   class="btn btn-outline-primary activate_ntheme_action" href="#"
                   data-text="<?php echo $this->lang->line("Do you really want to deactivate this dashboard theme?"); ?>"
                   data-title="<?php echo $this->lang->line("Deactivate theme?"); ?>"
                >
                    <i class="bx bx-block"></i> <?php echo $this->lang->line('Deactivate'); ?>
                </a>


            <?php } ?>

            <?php if ($nviews['downloaded'] == 1 and $nviews['activated'] == 0) { ?>

                <a title="<?php echo $this->lang->line("Activate"); ?>"
                   class="btn btn-outline-primary activate_ntheme_action" href="#"
                   data-text="<?php echo $this->lang->line("Do you really want to activate this dashboard theme?"); ?>"
                   data-title="<?php echo $this->lang->line("Activate theme?"); ?>"
                >
                    <i class="bx bx-check"></i> <?php echo $this->lang->line('Activate'); ?>
                </a>


            <?php } ?>

            <?php if (!empty($nviews['Latest_Version']) and $nviews['Latest_Version'] > $nviews['version'] and $nviews['code'] == 1) { ?>

                <a title="<?php echo $this->lang->line("Install/Update"); ?>" class="btn btn-outline-primary"
                   data-i='<?php echo $nviews['PID']; ?>' data-base="<?php echo $nviews['BASE']; ?>"
                   data-key="<?php echo $nviews['KEY']; ?>" href="#" data-toggle="modal"
                   data-target="#iu_nviews_action_modal"><i
                            class="bx bx-upload"></i> <?php echo $this->lang->line('Install/Update'); ?></a>


            <?php } ?>

            <a title="<?php echo $this->lang->line("Install/Update"); ?>" class="btn btn-outline-primary" href="#"
               data-toggle="modal" data-target="#iu_nviews_news_modal"><i
                        class="bx bx-news"></i> <?php echo $this->lang->line('News'); ?></a>


            <div class="modal fade" tabindex="-1" role="dialog" id="iu_nviews_action_modal" data-backdrop="static"
                 data-keyboard="false">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i
                                        class="bx bx-check"></i> <?php echo $this->lang->line("Install/Update"); ?>
                                <span class="put_add_on_title"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php echo $nviews['news']; ?>

                            <div id="activate_action_modal_msg" class="text-center"></div>
                            <div class="form-group">
                                <input type="hidden" id="href-action" value="">
                                <input type="hidden" id="xid-action" value="">
                                <input type="hidden" id="base-action" value="">
                                <input type="hidden" id="key-action" value="">
                                <input type="hidden" id="iu_nviews_action_modal_refresh" value="0">
                            </div>

                        </div>

                        <div class="modal-footer bg-whitesmoke">
                            <button type="button" id="iu_update_submit" class="btn btn-primary"><i
                                        class="bx bx-check-circle"></i> <?php echo $this->lang->line("Install/Update"); ?>
                            </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                        class="bx bx-trash-alt"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" tabindex="-1" role="dialog" id="iu_nviews_news_modal" data-backdrop="static"
                 data-keyboard="false">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i
                                        class="bx bx-check"></i> <?php echo $this->lang->line("Install/Update"); ?>
                                <span class="put_add_on_title"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php echo $nviews['news_news']; ?>
                        </div>

                        <div class="modal-footer bg-whitesmoke">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                        class="bx bx-trash-alt"></i> <span
                                        class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- //check API -->

            <?php if ($nviews['code'] == 0) { ?>
                <a title="<?php echo $this->lang->line("Change purchase code"); ?>"
                   class="btn btn-outline-primary code_action" data-i='<?php echo $nviews['PID']; ?>'
                   data-base="<?php echo $nviews['BASE']; ?>" data-key="<?php echo $nviews['KEY']; ?>" href="#"
                   data-href="<?php echo '/nvx_addon_manager/purchase_code'; ?>"><i
                            class="bx bx-code"></i> <?php echo $this->lang->line('Change purchase code'); ?></a>


            <?php } ?>




            <?php if (!empty($nviews['changelog'])) { ?>

                <a title="<?php echo $this->lang->line("See Log"); ?>" class="btn btn-outline-primary changelog_action"
                   data-i='<?php echo $nviews['PID']; ?>' data-base="<?php echo $nviews['BASE']; ?>"
                   data-key="<?php echo $nviews['KEY']; ?>" href="#" data-toggle="modal"
                   data-target="#changelog_<?php echo $nviews['PID']; ?>"><i
                            class="bx bx-show"></i> <?php echo $this->lang->line('See Log'); ?></a>

                <!-- Modal -->
                <div class="modal fade" tabindex="-1" role="dialog" id="changelog_<?php echo $nviews['PID']; ?>"
                     data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?php echo $nviews['Name']; ?> <?php echo $nviews['Latest_Version']; ?>
                                    ( <?php echo $this->lang->line('Change Log'); ?> )</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php echo $nviews['changelog']; ?>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                            class="bx bx-trash"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <?php

            echo $nviews['URL_Product'];

            if (file_exists(APPPATH . 'modules/n_theme/controllers/N_theme.php')) {
                ?>

                <div class="row mt-2">
                    <h4 class="card-title">Theme manager</h4>
                    <div class="col-12">
                        <a title="<?php echo $this->lang->line("Theme settings"); ?>" class="btn btn-outline-primary"
                           href="<?php echo base_url('/n_theme/settings'); ?>">
                            <i class="bx bx-wrench"></i> <?php echo $this->lang->line('Theme settings'); ?>
                        </a>
                        <a title="<?php echo $this->lang->line("Install Arabic translation"); ?>" target="_blank"
                           class="btn btn-outline-primary" href="<?php echo base_url('/n_theme/install_arabic'); ?>">
                            <i class="bx bx-wrench"></i> <?php echo $this->lang->line('Install Arabic translation'); ?>
                        </a>
                        <a title="<?php echo $this->lang->line("Install Theme translation"); ?>" target="_blank"
                           class="btn btn-outline-primary"
                           href="<?php echo base_url('/n_theme/install_theme_lang'); ?>">
                            <i class="bx bx-wrench"></i> <?php echo $this->lang->line('Install Theme translation'); ?>
                        </a>
                        <a title="<?php echo $this->lang->line("Fix Menu"); ?>" target="_blank"
                           class="btn btn-outline-primary" href="<?php echo base_url('/n_theme/fix_menu'); ?>">
                            <i class="bx bx-wrench"></i> <?php echo $this->lang->line('Fix Menu'); ?>
                        </a>
                        <a title="<?php echo $this->lang->line("Fix Database"); ?>" target="_blank"
                           class="btn btn-outline-primary"
                           href="<?php echo base_url('/n_theme/reinstall_database'); ?>">
                            <i class="bx bx-wrench"></i> <?php echo $this->lang->line('Fix Database'); ?>
                        </a>
                    </div>
                </div>

            <?php } ?>

        </div>

    </div>

    <?php

    foreach ($products as $value) {

        if ($value['XID'] == 1019) {
            continue;
        }

        ?>
        <div class="card">

            <div class="card-header">
                <h4 style="width: 100%">
                    <i class="bx bx-wrench"></i>&nbsp; <span
                            id="get_add_on_title_<?php echo $value['XID']; ?>"><?php echo $value['Name']; ?></span>
                    <?php if ($value['addon_data']['installed'] == 1) { ?> <span class="badge badge-light"><i
                                class="bx bx-check-circle"></i> <?php echo $this->lang->line("Active"); ?></span> <?php } ?>
                    <?php if ($value['addon_data']['installed'] == 0) { ?> <span class='badge badge-light'><i
                                class='bx bx-block'></i> <?php echo $this->lang->line("Inactive"); ?></span> <?php } ?>
                    <?php if ($value['addon_data']['code'] == 0) { ?><span class='badge badge-light'><i
                            class='bx bx-block'></i> <?php echo $this->lang->line("Purchase code invalid"); ?>
                        </span><?php } ?>
                    <code class="float-right">
                        <?php if (!empty($value['addon_data']['version'])) {
                            echo $this->lang->line('Your Version'); ?> :
                            <b>v<?php echo $value['addon_data']['version']; ?></b><br/><?php } ?>
                        <?php if (!empty($value['Latest_Version']) and $value['Latest_Version'] > $value['addon_data']['version']) {
                            echo $this->lang->line('New Version'); ?> : <b>
                            v<?php echo $value['Latest_Version']; ?></b><?php } ?>
                    </code>
                </h4>
            </div>

            <div class="card-body">


                <?php $module_controller = str_replace('.php', '', strtolower('/nvx_addon_manager')); ?>
                <?php if ($value['XID'] != 1012 and !empty($value['addon_data']['controller_name'])) {
                    $module_controller = str_replace('.php', '', strtolower($value['addon_data']['controller_name']));

                } ?>


                <!-- //check API -->

                <?php if ($value['XID'] != 1012 and $value['addon_data']['code'] == 0 or $value['XID'] != 1012 and $value['addon_data']['installed'] == 0) { ?>
                    <a title="<?php echo $this->lang->line("Change purchase code"); ?>"
                       class="btn btn-outline-primary code_action" data-i='<?php echo $value['PID']; ?>'
                       data-base="<?php echo $value['BASE']; ?>" data-key="<?php echo $value['KEY']; ?>" href="#"
                       data-href="<?php echo '/nvx_addon_manager/purchase_code'; ?>"><i
                                class="bx bx-code"></i> <?php echo $this->lang->line('Change purchase code'); ?>
                    </a> <?php } ?>

                <!-- //if module not exist -->
                <?php if ($value['XID'] != 1012 and empty($value['addon_data']['downloaded']) and $value['addon_data']['code'] == 1) { ?>

                    <a title="<?php echo $this->lang->line("Download"); ?>"
                       class="btn btn-outline-primary download_action" data-i='<?php echo $value['PID']; ?>'
                       data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                       data-key="<?php echo $value['KEY']; ?>" href="#"
                       data-href="<?php echo '/nvx_addon_manager/download'; ?>"><i
                                class="bx bx-save"></i> <?php echo $this->lang->line('Download'); ?></a>

                <?php } ?>
                <!-- //if module exist and update availably  -->
                <?php

                if (!empty($value['addon_data']['version']) and !empty($value['Latest_Version']) and $value['Latest_Version'] > $value['addon_data']['version']) {

                    if ($value['XID'] != 1012) { ?>

                        <a title="<?php echo $this->lang->line("Update"); ?>"
                           class="btn btn-outline-primary update_action" data-i='<?php echo $value['PID']; ?>'
                           data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                           data-key="<?php echo $value['KEY']; ?>" href="#"
                           data-href="<?php echo '/nvx_addon_manager/update_script'; ?>"><i
                                    class="bx bx-upload"></i> <?php echo $this->lang->line('Update'); ?></a>

                    <?php }

                    if ($value['XID'] == 1012) { ?>

                        <a title="<?php echo $this->lang->line("Update"); ?>"
                           class="btn btn-outline-primary update_nm_action" data-i='<?php echo $value['PID']; ?>'
                           data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                           data-key="<?php echo $value['KEY']; ?>" href="#"
                           data-href="<?php echo '/nvx_addon_manager/update_script_manager'; ?>"><i
                                    class="bx bx-upload"></i> <?php echo $this->lang->line('Update'); ?></a>

                    <?php } ?>

                <?php }
                if(empty($value['changelog'])){
                    $value['changelog'] = '';
                }

                ?>

                <a title="<?php echo $this->lang->line("Update"); ?>" class="btn btn-outline-primary changelog_action"
                   data-i='<?php echo $value['PID']; ?>' data-dir='<?php echo $value['DIR']; ?>'
                   data-base="<?php echo $value['BASE']; ?>" data-key="<?php echo $value['KEY']; ?>" href="#"
                   data-href="<?php echo '/nvx_addon_manager/changelog'; ?>" data-toggle="modal"
                   data-target="#changelog_<?php echo $value['PID']; ?>"><i
                            class="bx bx-show"></i> <?php echo $this->lang->line('See Log'); ?></a>
                <!-- Modal -->
                <div class="modal fade" tabindex="-1" role="dialog" id="changelog_<?php echo $value['PID']; ?>"
                     data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title"><?php echo $value['Name']; ?> <?php echo $value['Latest_Version']; ?>
                                    ( <?php echo $this->lang->line('Change Log'); ?> )</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="bx bx-x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <?php echo $value['changelog']; ?>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                            class="bx bx-trash-alt"></i> <span
                                            class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- //check install.txt -->
                <?php if ($value['addon_data']['installed'] == 0 and $value['addon_data']['downloaded'] == 1 and $value['addon_data']['code'] == 1) { ?>

                    <a title="<?php echo $this->lang->line("activate"); ?>"
                       class="btn btn-outline-primary activate_action" data-i='<?php echo $value['PID']; ?>'
                       data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                       data-key="<?php echo $value['KEY']; ?>" href="#"
                       data-href="<?php echo $module_controller . '/activate'; ?>"><i
                                class="bx bx-check"></i> <?php echo $this->lang->line('activate'); ?></a>

                <?php }

                if ($value['addon_data']['installed'] == 1 and $value['addon_data']['downloaded'] == 1 and $value['addon_data']['code'] == 1) { ?>

                    <a title="<?php echo $this->lang->line("deactivate"); ?>"
                       class="btn btn-outline-dark deactivate_action" href="#" data-i='<?php echo $value['PID']; ?>'
                       data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>"
                       data-key="<?php echo $value['KEY']; ?>"
                       data-href="<?php echo '/nvx_addon_manager/n_deactivate'; ?>"><i
                                class="bx bx-block"></i> <?php echo $this->lang->line('deactivate'); ?></a>

                <?php }

                echo $value['URL_Product'];

                ?>
                <!--

                                //if exist install.txt then
                 -->

                <!--                 <a title="<?php echo $this->lang->line("delete"); ?>" class="btn btn-outline-danger delete_action" href="#" data-i='<?php echo $value['PID']; ?>' data-dir='<?php echo $value['DIR']; ?>' data-base="<?php echo $value['BASE']; ?>" data-key="<?php echo $value['KEY']; ?>" data-href="<?php echo $module_controller . '/delete'; ?>"><i class="bx bx-trash"></i> <?php echo $this->lang->line('delete'); ?></a> -->


            </div>

        </div>
        <?php


    }


    ?>


    <div class="card">


    </div>

</div>


<div class="modal fade" tabindex="-1" role="dialog" id="activate_action_modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-check"></i> <?php echo $this->lang->line("activate"); ?> <span
                            class="put_add_on_title"></span></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">

                <div id="activate_action_modal_msg" class="text-center"></div>
                <div class="form-group">
                    <label>
                        <?php echo $this->lang->line("add-on purchase code"); ?>
                    </label>
                    <input type="text" class="form-control" name="purchase_code" id="purchase_code">
                    <input type="hidden" id="href-action" value="">
                    <input type="hidden" id="xid-action" value="">
                    <input type="hidden" id="base-action" value="">
                    <input type="hidden" id="key-action" value="">
                    <input type="hidden" id="activate_action_modal_refesh" value="0">
                </div>

            </div>

            <div class="modal-footer bg-whitesmoke">
                <button type="button" id="activate_submit" class="btn btn-primary"><i
                            class="bx bx-check-circle"></i> <?php echo $this->lang->line("Activate"); ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bx bx-trash-alt"></i>
                    <span class="align-middle ml-25"><?php echo $this->lang->line("close"); ?></span></button>
            </div>
        </div>
    </div>
</div>

          
          