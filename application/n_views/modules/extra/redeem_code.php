<style type="text/css">.alert a {
        text-decoration: none;
    }</style>
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>

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
                <div class="col-xs-12 hidden" id="loading">
                    <img class="loading center-block" style="margin-bottom:15px;"
                         src="<?php echo base_url("assets/pre-loader/Fading squares2.gif"); ?>" alt="">
                </div>
                <div id="response" style="margin:0 15px;"></div>
                <div class="col-xs-12 col-md-12">
                    <div class="box box-warning">

                        <div class="box-body">
                            <br>
                            <form action="#" enctype="multipart/form-data" style="padding: 0 20px 20px 20px">

                                <div class="form-group text-center">
                                    <label style="width:100%">
                                        <?php echo $this->lang->line("Enter the code"); ?> *
                                        <a href="#" data-placement="top" data-toggle="popover" data-trigger="focus"
                                           title="<?php echo $this->lang->line("website link") ?>"
                                           data-content='<?php echo $this->lang->line("Enter the code") ?>'><i
                                                    class='bx bx-info-circle'></i> </a>
                                    </label>
                                    <input type="text" name="domain_name" id="domain_name" class="form-control"
                                           placeholder="Enter the code">
                                </div>

                                <div class="box-footer text-center">
                                    <!-- <div class="col-xs-12"> -->
                                    <button style='width:100%; max-width:350px; margin-bottom:10px;'
                                            class="btn btn-primary center-block " id="get_button" name="get_button"
                                            type="button"><?php echo $this->lang->line("Redeem the code"); ?></button>
                                    <!-- </div> -->
                                </div>

                            </form>
                        </div>

                    </div>
                </div>  <!-- end of col-6 left part -->


            </div>
        </div>
    </div>
</div>




