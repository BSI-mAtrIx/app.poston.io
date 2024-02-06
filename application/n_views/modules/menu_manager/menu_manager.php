<link rel="stylesheet"
      href="<?php echo base_url("plugins/menu_manager/css/bootstrap-iconpicker.min.css?ver=" . $n_config['theme_version']); ?>">
<link rel="stylesheet"
      href="<?php echo base_url('plugins/menu_manager/css/menu.css?ver=' . $n_config['theme_version']) ?>">


<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("menu_manager/index"); ?>"><?php echo $this->lang->line("Menu Manager"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>

                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="#" class="btn btn-primary mb-1 reset_menu">
            <i class="bx bx-repost"></i> <?php echo $this->lang->line("Reset To Default"); ?>
        </a>
    </div>
</div>

<div class="section-body">

    <?php if ($this->session->userdata('user_type') == 'Admin' && $this->session->userdata('license_type') == 'double') : ?>
        <div class="alert alert-light alert-dismissible show fade mt-0 mb-4">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>×</span>
                </button>
                <i class="bx bx-bell bx-2x"></i>
                <?php echo $this->lang->line("Some links that are available in member panel such as 'Payment' (Renew Package, Transaction Log, Usage Log) or support desk are not included here as they are statically added inside application/views/admin/theme/sidebar.php"); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="bx bx-menu"></i> <?php echo $this->lang->line("Current Links"); ?></h4>
                </div>
                <div class="card-body">
                    <ul id="myEditor" class="sortableLists list-group">
                    </ul>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button id="btnOut" type="button" class="btn btn-primary"><i
                                class="bx bxs-save"></i> <?php echo $this->lang->line('save'); ?> </button>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4><i class="bx bx-folder-open"></i> <?php echo $this->lang->line("Manage Links"); ?></h4>
                </div>
                <div class="card-body">
                    <form id="frmEdit">
                        <div class="form-group">
                            <label for="name"><?php echo $this->lang->line('Name'); ?></label>
                            <div class="input-group" data-icon-style="lines">
                                <input type="text" class="form-control item-menu required" name="text" id="name"
                                       data-validation="name">
                                <div class="input-group-append d-none"
                                     title="<?php echo $this->lang->line('Choose icon color'); ?>" id="color-picker">
                                    <input type="color" name="color" id="color" class="form-control item-menu no_radius"
                                           style="width: 50px;" value="#0D8BF1">
                                </div>
                                <div class="input-group-append" id="icon-picker">
                                    <button type="button" id="myEditor_icon" class="btn btn-secondary icon-btn"
                                            data-iconset="fontawesome"></button>
                                </div>
                                <input type="hidden" name="icon" class="item-menu" id="iconPicker">
                            </div>
                            <span class="text-danger" id="error_msg"></span>
                            <span class="text-danger" id="error_msg4"></span>
                        </div>

                        <!-- Targets -->
                        <div class="form-group">
                            <label for="target"><?php echo $this->lang->line('Target'); ?></label>
                            <select name="target" id="target" class="form-control item-menu">
                                <option value="0"><?php echo $this->lang->line('Internal'); ?></option>
                                <option value="1"
                                        selected="select"><?php echo $this->lang->line('External'); ?></option>
                            </select>
                        </div>

                        <!-- URL -->
                        <div class="form-group" id="one">
                            <label for="href"><?php echo $this->lang->line('URL'); ?></label>
                            <input type="text" class="form-control item-menu" id="href" name="href"
                                   placeholder="https://example.com">
                            <span class="text-danger" id="error_msg2"><?php echo form_error('url'); ?></span>
                        </div>


                        <!-- Page List -->
                        <div class="form-group" id="two" style="display: none;">
                            <label for="page_list"><?php echo $this->lang->line('Pages'); ?></label>
                            <select name="page_list" id="page_list" class="form-control item-menu">
                                <option value=""><?php echo $this->lang->line('select'); ?></option>
                                <?php foreach ($page_value as $singlePage) : ?>
                                    <option value="<?php echo $singlePage['id']; ?>"><?php echo $singlePage['page_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="text-danger" id="error_msg3"><?php echo form_error('page_list'); ?></span>
                        </div>

                        <!-- Module Access -->
                        <div class="form-group" style="display: none;">
                            <label for="module_access"><?php echo $this->lang->line('Module Access'); ?></label>
                            <input type="text" name="module_access" class="form-control item-menu" id="module_access">
                        </div>

                        <!-- Is Menu Manager -->
                        <div class="form-group" style="display: none;">
                            <label for="is_menu_manager"><?php echo $this->lang->line('Is Menu Manager'); ?></label>
                            <input type="text" name="is_menu_manager" class="form-control item-menu"
                                   id="is_menu_manager" value="1">
                        </div>

                        <!-- Only Admin -->
                        <div class="form-group">
                            <label for="only_admin"><?php echo $this->lang->line('Only Admin'); ?></label>
                            <select name="only_admin" id="only_admin" class="form-control item-menu">
                                <option value="1"><?php echo $this->lang->line('Yes'); ?></option>
                                <option value="0" selected="select"><?php echo $this->lang->line('No'); ?></option>
                            </select>
                        </div>


                        <!-- Only Member -->
                        <div class="form-group">
                            <label for="only_member"><?php echo $this->lang->line('Only Member'); ?></label>
                            <select name="only_member" id="only_member" class="form-control item-menu">
                                <option value="1"><?php echo $this->lang->line('Yes'); ?></option>
                                <option value="0" selected="select"><?php echo $this->lang->line('No'); ?></option>
                            </select>
                        </div>


                        <!-- Addons Id -->
                        <div class="form-group" style="display: none;">
                            <label for="add_ons_id"><?php echo $this->lang->line('Addons Id'); ?></label>
                            <input type="text" name="add_ons_id" class="form-control item-menu" id="add_ons_id">
                        </div>

                        <div class="form-group">
                            <label><?php echo $this->lang->line("Header Text"); ?></label>
                            <input type="text" class="form-control item-menu" name="header_text" id="header_text">
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-whitesmoke">
                    <button type="button" id="btnUpdate" class="btn btn-warning float-right" disabled><i
                                class="bx bx-edit"></i> <?php echo $this->lang->line('Update'); ?></button>
                    <button type="button" id="btnAdd" class="btn btn-primary float-left"><i
                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Add'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var notAllowed = '<?php echo $this->lang->line("Menu having link cannot be used as parent.") ?>';
    var three_level_allowed = '<?php echo $this->lang->line('Third level menu is not allowed.') ?>';
    var drag_drop_not_allowed = '<?php echo $this->lang->line('System default menu cannot be re-ordered.') ?>';
</script>



