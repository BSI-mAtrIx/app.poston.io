<style>
    .card-profile img {
        height: 100px;
        object-fit: cover;
    }

    .card-profile{
        text-align: center;
    }
    .profile-image-wrapper{
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
    .profile-image-wrapper .profile-image{
        position: absolute;
        top: 2rem;
        padding: .5rem;
        border-radius: 50%;
        background-color: #FFF;
        box-shadow: 0 0 8px 0 rgb(34 41 47 / 14%);
        margin-bottom: 1.15rem;
    }
    .card-profile h3{
        margin-top: 35px;
    }
</style>
<?php $is_demo=$this->is_demo;?>

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



        <div class="row mb-2">
            <div class="col-12">
                <a href="<?php echo base_url('addons/upload');?>" class="btn btn-primary mb-1">
                    <i class="bx bx-cloud-upload"></i> <?php echo $this->lang->line('Install Add-on');?>
                </a>
            </div>
        </div>


    <?php $this->load->view('admin/theme/message'); ?>
<?php if ($this->session->flashdata('addon_uplod_success') != "") echo "<div class='alert alert-success text-center'><i class='bx bx-check'></i> " . $this->session->flashdata('addon_uplod_success') . "</div>"; ?>

    <div class="section-body">
        <?php
        if(!empty($add_on_list))
        {
            $i=0;
            echo "<div class='row match-height'>";
            foreach($add_on_list as $value)
            {
                $i++;
                //(removing .php from controller name, that makes moduleFolder/controller name)
                $module_controller=str_replace('.php','',strtolower($value['controller_name']));
                ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <?php
                    $asset_path=$module_controller.'/thumb.png';
                    $thumb = get_addon_asset($type="image",$asset_path,$css_class="img-fluid card-img-top","",$style="");
                    if($thumb=="") $thumb ='<img src="'.base_url('assets/img/addon.jpg').'"  class="img-fluid card-img-top" alt="Profile Cover Photo">';

                    $thumb_avatar = get_addon_asset($type="image",$asset_path,$css_class="","",$style="");
                    if($thumb_avatar=="") $thumb_avatar ='<img src="'.base_url('assets/img/addon.jpg').'"  class="" alt="Profile Cover Photo">';


                    ?>

                    <div class="card card-profile">
                        <?php echo $thumb; ?>
                        <div class="card-body">
                            <div class="profile-image-wrapper">
                                <div class="profile-image">
                                    <div class="avatar">
                                        <?php echo $thumb_avatar; ?>
                                    </div>
                                </div>
                            </div>
                            <h3><?php echo $value['addon_name'];?></h3>
                            <h6 class="text-muted"><?php
                                if($value['installed']=="0") echo "<span class='badge badge-light'><i class='bx bx-block'></i>".$this->lang->line("Inactive")."</span>";
                                else echo "<span class='badge badge-light'><i class='bx bx-check-circle'></i> ".$this->lang->line("Active")."</span>";
                                ?> </h6>
                            <div class="badge badge-light-primary profile-badge">version <?php echo $value["version"]; ?></div>
                            <hr class="mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class=" text-center" style="padding-top: 10px;">

                                    <?php if($value['installed'] == '0'): ?>
                                        <a title="<?php echo $this->lang->line("activate"); ?>" class="btn btn-outline-primary activate_action" data-i='<?php echo $i; ?>' href="" data-href="<?php echo $module_controller.'/activate';?>"><i class="bx bx-check"></i> <?php echo $this->lang->line('activate');?></a>
                                    <?php endif; ?>

                                    <?php if($value['installed'] == '1'): ?>
                                        <a title="<?php echo $this->lang->line("deactivate"); ?>" class="<?php if($this->is_demo=='1') echo 'disabled'; ?> btn btn-outline-dark deactivate_action" href="#" data-i='<?php echo $i; ?>' data-href="<?php echo $module_controller.'/deactivate';?>"><i class="bx bx-block"></i> <?php echo $this->lang->line('deactivate');?></a>
                                    <?php endif; ?>
                                    <a title="<?php echo $this->lang->line("delete"); ?>" class="<?php if($this->is_demo=='1') echo 'disabled'; ?> btn btn-outline-danger delete_action" href="" data-i='<?php echo $i; ?>' data-href="<?php echo $module_controller.'/delete';?>"><i class="bx bx-trash"></i> <?php echo $this->lang->line('delete');?></a>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>




                <?php
            }
            echo "</div>";
        }
        else
        { ?>
            <div class="card">
                <div class="card-header">
                <h4><i class="bx bx-question-mark"></i> <?php echo $this->lang->line("No add-on uploaded"); ?></h4>
                </div>
                <div class="card-body">
                    <div class="empty-state" data-height="400" style="height: 400px;">
                        <div class="empty-state-icon">
                        <i class="bx bx-question-mark"></i>
                        </div>
                        <h2><?php echo $this->lang->line("System could not find any add-on."); ?></h2>
                        <p class="lead">
                            <?php echo $this->lang->line("No add-on found. Your add-on will display here once uploaded."); ?>

                        </p>
                        <a class="btn btn-primary" href="<?php echo base_url('addons/upload');?>"><i class="bx bx-cloud-upload"></i> <?php echo $this->lang->line('Upload Add-on');?></a>
                    </div>
                </div>
            </div>

            <?php
        }
        ?>
    </div>







<style type="text/css">
           .profile-widget .profile-widget-picture {margin-top: -25px;} !important;
</style>

<div class="modal fade" tabindex="-1" role="dialog" id="activate_action_modal" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog" role="document">
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