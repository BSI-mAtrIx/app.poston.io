<?php $this->load->view('admin/theme/message'); ?>
<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>
<section class="section section_custom">
    <div class="section-header">
        <h1><i class='bx bx-menu'></i> <?php echo $page_title; ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <form method="POST" action="<?php echo base_url("campaigns/post_insights/{$post_name}"); ?>">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class='bx bx-calendar'></i>
                            </div>
                        </div>
                        <input type="text" class="form-control datepicker" value="<?php echo $from_date; ?>"
                               id="from_date" name="from_date" style="width:115px">
                        <input type="text" class="form-control datepicker" value="<?php echo $to_date; ?>" id="to_date"
                               name="to_date" style="width:115px">
                        <input type="hidden" class="form-control" value="<?php echo $post_name; ?>" name="post_name">
                        <button class="btn btn-outline-primary" style="margin-left:1px" type="submit"><i
                                    class='bx bx-search'></i> <?php echo $this->lang->line("Search"); ?></button>
                    </div>
                </form>
            </div>
        </div>
        <h3 id="section-header-title" class="text-capitalize"></h3>
    </div>

    <div class="section-body">

        <!-- starts QUERIES_DIRECT and QUERIES_INDIRECT -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Queries Direct'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the resource was shown when searching for the location directly."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="queries_direct" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Queries Indirect'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-original-title="<?php echo $this->lang->line("The number of times the resource was shown as a result of a categorical search (for example, restaurant)."); ?>"
                                    data-toggle="tooltip"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="queries_indirect" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts QUERIES_CHAIN chain and VIEWS_MAPS -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Queries Chain'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("	The number of times a resource was shown as a result of a search for the chain it belongs to, or a brand it sells. For example, Starbucks, Adidas. This is a subset of QUERIES_INDIRECT."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="queries_chain" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Views Maps'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the resource was viewed on Google Maps."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="views_maps" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts VIEWS_SEARCH and ACTIONS_WEBSITE -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Views Search'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the resource was viewed on Google Search."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="views_search" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Actions Website'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the website was clicked."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="actions_website" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts ACTIONS_PHONE and ACTIONS_DRIVING_DIRECTIONS -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Actions Phone'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the phone number was clicked."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="actions_phone" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Actions Driving Directions'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times driving directions were requested."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="actions_driving_directions" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts ACTIONS_PHONE and ACTIONS_DRIVING_DIRECTIONS -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Photos Views Merchant'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of views on media items uploaded by the merchant."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="photos_views_merchant" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Photos Views Customers'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of views on media items uploaded by customers."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="photos_views_customers" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts PHOTOS_COUNT_MERCHANT and PHOTOS_COUNT_CUSTOMERS -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Photos Count Merchant'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The total number of media items that are currently live that have been uploaded by the merchant."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="photos_count_merchant" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Photos Count Customers'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The total number of media items that are currently live that have been uploaded by customers."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="photos_count_customers" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

        <!-- starts LOCAL_POST_VIEWS_SEARCH and LOCAL_POST_ACTIONS_CALL_TO_ACTION -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Local Post Views Search'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the local post was viewed on Google Search."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="local_post_views_search" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <?php echo $this->lang->line('Local Post Actions Call To Action'); ?>
                            &nbsp;<i
                                    class="bx bx-info-circle"
                                    data-toggle="tooltip"
                                    data-original-title="<?php echo $this->lang->line("The number of times the call to action button was clicked on Google."); ?>"
                            ></i>
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="local_post_actions_call_to_action" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- ends ./row -->

    </div>
</section>
