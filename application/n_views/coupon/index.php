<style>
    .generate_coupons {
        color: grey;
    }

    .generate_coupons label {
        color: black !important;
        font-weight: 600 !important;
    }

    .export_block div {
        background: white;
        padding: 15px;
        margin-bottom: 1px;
        position: relative;
    }

    .export_block div select {
        height: 44px;
        font-size: 15px;
    }

    .export_block .export_type {
        padding: 30px;
    }

    .export_block-title {
        color: black;
        font-weight: bold !important;
    }
</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo "Generate Coupons"; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo "Generate Coupons"; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="row" style="display: flex;justify-content: center;align-items: center;margin-top: 50px;">
        <div class="col-md-12 generate_coupons">

            <div class="col-md-12" style="background: white; padding:30px;">
                <input type="hidden" id="hidden_id" value="<?php echo $user_id; ?>">
                <div class="col-md-12">
                    <label for="packageList" class="css-label">Package</label>
                    <select name="packageList" id="packageList" class="form-control  pull-left"
                            style="width:100%;height:40px;margin-top:5px; font-size:14px;">
                        <?php if (isset($packages)) {
                            foreach ($packages as $key => $value) { ?>
                                <option value="<?php echo $value['id'] ?>"><?php echo $value['package_name']; ?></option>
                            <?php } ?>
                        <?php } else { ?>
                            <option value="empty">Empty</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="" class="css-label">No of coupons</label>
                    <input id="count_of_coupons" type="text" value="1" class="form-control  pull-left"
                           style="width:100%;height:40px;margin-top:5px; font-size:14px;">
                </div>
                <div class="col-md-12" style="margin-top: 20px; padding: 0; background: white;">
                    <ul class="treeview-menu menu-open">
                        <li>Select packages from dropdown, and enter number of coup[ons to generate. Then click save.
                        </li>
                        <li>It will generate coupons with unique code and will be displayed below.</li>
                        <li>No of coupons should be between 0 and 2000</li>
                    </ul>
                </div>

                <div class="col-md-12 export_block">
                    <form action="<?php echo $export_generated_coupons; ?>" method='POST'>
                        <div class="col-md-12">
                            <h5 class="text-center export_block-title"><?php echo $this->lang->line("Exports Coupons"); ?> </h5>
                        </div>
                        <div class="col-md-12" class="export_type">
                            <input type="hidden" id="last_generated_value" name='couponsCount' value="0">
                            <input type="hidden" name="hidden_id" value="<?php echo $user_id; ?>">
                            <p id="last_generated_info">After generating coupons you can export them</p>
                        </div>
                        <div class="col-md-12 export_button_block text-center" style="padding: 25px; display: none;">
                            <button class="btn btn-secondary "> <?php echo $this->lang->line("EXPORT"); ?> </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12 text-center" style="margin-top: 2px; padding: 0;">
                    <button class="btn btn-primary btn-default generate-coupon-btn">SAVE</button>
                </div>
            </div>
        </div>

        <!-- Show coupons list -->
        <div class="row" style="display: flex;justify-content: center;align-items: center;margin-top: 50px;">
            <div class="couponsInfo card">
                <div class="couponsInfo-info card-header" style="margin-bottom: 2px; background: white">
                    <h4>Coupons</h4>
                </div>
                <div class="couponsInfo-body card-body" style="background: white;">
                    <table class="table table-hover table-striped" id="packagesList">
                        <thead>
                        <tr>
                            <th>Package</th>
                            <th>Code</th>
                            <th>Created on</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($allCoupons)) {
                            foreach ($allCoupons as $key => $value) { ?>
                                <tr data-coupon-id="<?php echo $value['id']; ?>">
                                    <td> <?php echo $value['package_name']; ?></td>
                                    <td> <?php echo $value['code']; ?></td>
                                    <td> <?php echo $value['created_on']; ?></td>
                                    <td> <?php echo $value['status']; ?></td>
                                </tr>
                                <?php ;
                            }
                        } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


