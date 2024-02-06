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
        <?php if (file_exists(APPPATH . 'modules/marketing/controllers/Marketing.php')) { ?>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-chart"></i> <?php echo $this->lang->line("Interest Explorer"); ?></h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Facebook Hidden Interest Explorer for ADS targeting"); ?></p>
                        <div class="dropdown">
                            <a href="<?php echo base_url('marketing/get_interest'); ?>"
                               class="no_hover"><?php echo $this->lang->line("Interest Explorer"); ?> <i
                                        class="bx bx-chevron-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i
                                class="bx bx-adjust"></i> <?php echo $this->lang->line("Website Comparison"); ?></h5>
                </div>
                <div class="card-body">
                    <p><?php echo $this->lang->line("Social existency (share, like, comment...)"); ?></p>
                    <div class="dropdown">
                        <a href="<?php echo base_url('search_tools/comparision'); ?>"
                           class="no_hover"><?php echo $this->lang->line("Actions"); ?> <i
                                    class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-lg-6">
              <div class="card">
              <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                  <h5 class="card-title"><i class="bx bx-map-pin"></i> <?php echo $this->lang->line("Place Search"); ?></h5>
              </div>
                  <div class="card-icon text-primary"><i class=""></i></div>
                  <div class="card-body">
                      <p><?php echo $this->lang->line("Page, website, mobile, address..."); ?></p>
                      <div class="dropdown">
                          <a href="<?php echo base_url('search_tools/place_search'); ?>" class="no_hover"><?php echo $this->lang->line("Actions"); ?> <i class="bx bx-chevron-right"></i></a>
                      </div>
                  </div>
              </div>
          </div> -->
        <?php if ($this->config->item('instagram_reply_enable_disable')) : ?>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><i
                                    class="bx bx-purchase-tag-alt"></i> <?php echo $this->lang->line("Hashtag Search"); ?>
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo $this->lang->line("Search Top & Recent media with hashtag in Instagram"); ?></p>
                        <a href="<?php echo base_url("instagram_reply/hashTag_search"); ?>"
                           class="card-cta d-inline-flex align-items-center"><?php echo $this->lang->line("Actions"); ?>
                            <i class="bx bx-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>