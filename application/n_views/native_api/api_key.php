<link rel="stylesheet" type="text/css"
      href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/ui/prism.min.css?ver=<?php echo $n_config['theme_version']; ?>">
<style>
    .prism-show-language-label {
        display: none !important;
    }

</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><?php echo $this->lang->line("Native API"); ?></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/theme/message'); ?>

<div class="section-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <?php
                $text = $this->lang->line("Generate API Key");
                $get_key_text = $this->lang->line("Get Your API Key");
                if (isset($api_key) && $api_key != "") {
                    $text = $this->lang->line("Re-generate API Key");
                    $get_key_text = $this->lang->line("Your API Key");
                }
                if ($this->is_demo == '1') $api_key = 'xxxxxxxxxxxxxxxxxxxxxxxxxx';
                ?>

                <form class="form-horizontal" enctype="multipart/form-data"
                      action="<?php echo site_url() . 'native_api/get_api_action'; ?>" method="GET">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4><i class="bx bx-key"></i> <?php echo $get_key_text; ?></h4>
                    </div>
                    <div class="card-body">
                        <?php if ($api_key == "") echo $this->lang->line("Every cron url must contain the API key for authentication purpose. Generate your API key to see the cron job list."); ?>
                        <pre class="language-javascript">
                        <code class="language-javascript">
                            <?php echo $api_key; ?>
                        </code>
                      </pre>
                    </div>
                    <div class="card-footer bg-whitesmoke d-flex justify-content-between">
                        <button type="submit" name="button"
                                class="btn btn-primary btn <?php if ($this->is_demo == '1') echo 'disabled'; ?>"><i
                                    class="bx bx-redo"></i> <?php echo $text; ?></button>

                        <a class="btn btn-info " href="<?php echo base_url('api/doc'); ?>" target="_blank"><i
                                    class="bx bxs-cog"></i> <?php echo $this->lang->line("API Documentation"); ?></a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>