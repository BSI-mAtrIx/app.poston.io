<div class="content-header-left col-12 mb-2 mt-1">
    <div class="breadcrumbs-top">
        <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("User login section") ?></h5>
        <div class="breadcrumb-wrapper d-none d-sm-block">
            <ol class="breadcrumb p-0 mb-0 pl-1">
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item"><a
                            href="<?php echo base_url('social_accounts/account_import'); ?>"><?php echo $this->lang->line("Import Account"); ?></a>
                </li>
                <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
            </ol>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="card" id="nodata">
        <div class="card-body text-center">
            <div class="empty-state">
                <?php
                if (isset($message)) :
                    if (isset($error) && $error == 1) :
                        ?>
                        <img class="img-fluid" style="height: 300px"
                             src="<?php echo base_url('assets/img/drawkit/drawkit-full-stack-man-colour.svg'); ?>"
                             alt="image">
                        <h2 class="mt-0 text-danger"><?php echo $message; ?></h2>
                        <br/>
                    <?php else : ?>
                        <h2 class="mt-0 text-success text-info"><?php echo $message; ?></h2>
                        <br/>
                    <?php
                    endif;
                endif;
                ?>
                <center><a href="<?php echo base_url("social_accounts/account_import"); ?>"><i
                                class="bx bx-left-arrow-circle"></i> <?php echo $this->lang->line("go back"); ?></a>
                </center>
            </div>
        </div>
    </div>
</div>
