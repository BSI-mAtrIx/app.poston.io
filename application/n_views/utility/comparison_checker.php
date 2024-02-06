<style type="text/css">
    .waiting {
        height: 100%;
        width: 100%;
        display: table;
    }

    .waiting i {
        font-size: 60px;
        display: table-cell;
        vertical-align: middle;
        padding: 10px 0;
    }

    @media (max-width: 575.98px) {

        .card .card-stats .card-stats-item {
            padding: 5px 10px !important;
        }

        .card .card-stats .card-stats-item .card-stats-item-count {
            font-size: 12px !important;
        }

    }
</style>
<?php
//todo: icons
//todo: labels
//todo: 00000000 before release - style results
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
                                href="<?php echo base_url('search_tools/index'); ?>"><?php echo base_url('search_tools/index'); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card main_card">

                <div class="card-body">

                    <div class="row">
                        <div class="form-group col-12 col-md-5" style="padding: 10px;">
                            <label>
                                <?php echo $this->lang->line("Website"); ?>
                            </label>
                            <input class="form-control" id="domain_name1" autocomplete="off" type="text"
                                   placeholder="https://example.com">
                        </div>
                        <div class="form-group col-12 col-md-5" style="padding: 10px;">
                            <label>
                                <?php echo $this->lang->line("Competitor Website"); ?>
                            </label>
                            <input type="text" autocomplete="off" id="domain_name2" class="form-control"
                                   placeholder="https://example2.com">
                        </div>

                        <div class="form-group col-12 col-md-2 text-center" style="padding: 10px;margin-top: 28px">
                            <button class="btn btn-primary action_button" style="padding: 0.55rem 2.5rem;"><i
                                        class="bx bx-search"></i> <?php echo $this->lang->line("Search"); ?></button>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
    <div id="custom_spinner"></div>
    <div class="row">


        <div class="col-lg-6 col-md-6 col-sm-12 one">

        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 two">
        </div>


    </div>

</div>








