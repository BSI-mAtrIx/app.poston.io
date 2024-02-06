<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a
                                href="<?php echo base_url("ecommerce"); ?>"><?php echo $this->lang->line("E-commerce"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-none">
                <div class="card-header">
                    <h4 class="card-title">Domains to activate</h4>
                </div>
                <div class="card-body">
                    <p>If you want check all custom domains use PHPMyAdmin in table n_custom_domain</p>
                    <div class="row">
                        <?php
                        if (empty($n_cd_data)) {
                            echo '<p>No domains to activate</p>';
                        } else {
                            foreach ($n_cd_data as $k => $v) {

                                if ($v['active'] == 0) {


                                    ?>
                                    <div class="col-6">
                                        <button class="btn btn-primary confirm_app_n" data-id="<?php echo $v['id']; ?>"
                                                data-host="<?php echo $v['host_url']; ?>"
                                                csrf_token="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                                            Activate: <?php echo $v['host_url']; ?></button>
                                    </div>
                                    <?php
                                }

                                if ($v['active'] == 2) {


                                    ?>
                                    <div class="col-6">
                                        <button class="btn btn-danger delete_app_n" data-id="<?php echo $v['id']; ?>"
                                                data-host="<?php echo $v['host_url']; ?>"
                                                csrf_token="<?php echo $this->session->userdata('csrf_token_session'); ?>">
                                            Delete: <?php echo $v['host_url']; ?></button>
                                    </div>
                                    <?php
                                }

                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


