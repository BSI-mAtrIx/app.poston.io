<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url('integration'); ?>"><?php echo $this->lang->line("Integration"); ?></a>
                    </li>

                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("woocommerce_integration"); ?>"><?php echo $this->lang->line("WooCommerce Integration"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <a href="<?php echo base_url("woocommerce_integration/add_woocommerce_settings"); ?>"
           class="btn btn-primary mb-1">
            <i class="bx bx-plus-circle"></i> <?php echo $this->lang->line("Connect WooCommerce API"); ?>
        </a>
    </div>
</div>

<?php
$this->load->view('admin/theme/message');
if ($this->session->flashdata('error_message_woocommerce') != '')
    echo "<div class='alert alert-danger text-center'><i class='bx bx-trash'></i> " . $this->session->flashdata('error_message_woocommerce') . "</div>";
?>

<div class="section-body">

    <?php
    if (!empty($info)) {
        echo "<div class='row'>";
        foreach ($info as $value) { ?>
            <div class="col-12 col-sm-6">
                <div class="card profile-widget mt-4">
                    <div class="profile-widget-header">
                        <div class="profile-widget-items d-flex px-2 py-1">
                            <div class="profile-widget-item mx-1">
                                <div class="profile-widget-item-value">
                                    <a target='_BLANK'
                                       href="<?php echo base_url("woocommerce_integration/store/" . $value["id"]); ?>"
                                       class='btn btn-outline-info ' data-toggle='tooltip' data-placement='top'
                                       title="<?php echo $this->lang->line('Visit Store Webview'); ?>"><i
                                                class='bx bx-show'></i> <?php echo $this->lang->line('Store Webview'); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="profile-widget-item mx-1">
                                <div class="profile-widget-item-value">
                                    <a href='' data-site="<?php echo $value["home_url"]; ?>"
                                       data-id="<?php echo $value['id']; ?>"
                                       class='btn btn-outline-primary show_product' data-toggle='tooltip'
                                       data-placement='top' title="<?php echo $this->lang->line('Product List'); ?>"><i
                                                class='bx bx-box'></i> <?php echo $this->lang->line('Products'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description" style="padding-bottom: 0;">
                        <div class="profile-widget-name text-center"><a href='<?php echo $value["home_url"]; ?>'
                                                                        target="_BLANK"><i
                                        class='bx bx-wordpress'></i> <?php echo $value["home_url"]; ?></a></div>
                        <div class="profile-widget-name text-center">
                            <small data-toggle='tooltip' data-placement='top'
                                   title="<?php echo $this->lang->line('Consumer Key'); ?>"><i
                                        class='bx bx-key'></i> <?php echo (!$this->is_demo) ? $value["consumer_key"] : "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"; ?>
                            </small><br>
                            <small data-toggle='tooltip' data-placement='top'
                                   title="<?php echo $this->lang->line('Consumer Secret'); ?>"><i
                                        class='bx bx-face-mask'></i> <?php echo (!$this->is_demo) ? $value["consumer_secret"] : "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"; ?>
                            </small><br>
                            <small data-toggle='tooltip' data-placement='top'
                                   title="<?php echo $this->lang->line('Last Updated'); ?>"><i
                                        class='bx bx-time'></i> <?php echo date("M j, y H:i", strtotime($value["last_updated_at"])); ?>
                            </small>
                        </div>
                    </div>
                    <div class="card-footer text-center" style="padding-top: 10px;">

                        <a href='#' csrf_token="<?php echo $this->session->userdata('csrf_token_session'); ?>"
                           class='mt-2 btn btn-outline-danger delete_app' table_id="<?php echo $value['id']; ?>"
                           data-toggle='tooltip' data-placement='top'
                           title="<?php echo $this->lang->line('Delete'); ?>"><i
                                    class='bx bx-trash-alt'></i> <?php echo $this->lang->line('Delete'); ?></a>

                        <a href="<?php echo base_url('woocommerce_integration/edit_woocommerce_settings/') . $value['id']; ?>"
                           class='mt-2 btn btn-outline-primary' data-toggle='tooltip' data-placement='top'
                           title="<?php echo $this->lang->line('Update'); ?>"><i
                                    class='bx bx-edit'></i> <?php echo $this->lang->line('Update'); ?></a>

                        <a href="" class='mt-2 btn btn-outline-dark copy_url' data-id="<?php echo $value['id']; ?>"
                           data-toggle='tooltip' data-placement='top'
                           title="<?php echo $this->lang->line('Copy URL'); ?>"><i
                                    class='bx bx-copy'></i> <?php echo $this->lang->line('Copy URL'); ?></a>

                        <a href="<?php echo base_url('woocommerce_integration/sync_woocommerce_data/') . $value['id']; ?>"
                           class='mt-2 btn btn-warning' data-toggle='tooltip' data-placement='top'
                           title="<?php echo $this->lang->line('Re-sync Data'); ?>"><i
                                    class='bx bx-sync-alt'></i> <?php echo $this->lang->line('Re-sync Data'); ?></a>

                    </div>
                </div>

            </div>
            <?php
        }
        echo "</div>";
    } else { ?>
        <div class="card">
            <div class="card-body">
                <div class="empty-state" data-height="400" style="height: 400px;">
                    <div class="empty-state-icon">
                        <i class="bx bx-time"></i>
                    </div>
                    <h2><?php echo $this->lang->line("No WooCommerce Integration found."); ?></h2>
                    <p>&nbsp;</p>
                    <a class="btn btn-primary"
                       href="<?php echo base_url('woocommerce_integration/add_woocommerce_settings') ?>"><i
                                class="bx bx-plus-circle"></i> <?php echo $this->lang->line('Connect WooCommerce API'); ?>
                    </a>
                </div>
            </div>
        </div>

        <?php
    }
    ?>

</div>


<div class="modal fade" role="dialog" id="show_products_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-box"></i> <?php echo $this->lang->line("Products"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bx bx-x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%"></iframe>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" role="dialog" id="copy_url_modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="bx bx-copy"></i> <?php echo $this->lang->line("Copy URL"); ?></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="bx bx-x"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%"></iframe>

            </div>
        </div>
    </div>
</div>


<style type="text/css">.profile-widget .profile-widget-items:after {
        left: 0;
    }</style>