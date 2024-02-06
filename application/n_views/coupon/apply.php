<style>
    .apply_coupon {
        color: grey;
    }

    .apply_coupon label {
        color: black !important;
        font-weight: 600 !important;
    }

    .applu_coupon_code:hover {
        background: #2399ed4d !important;
        border-top: 1px solid #2399ede0 !important;
    }
</style>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo "Apply coupon code"; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>

                    <li class="breadcrumb-item active"><?php echo "Apply coupon code"; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="section-body">
    <div class="row" style="display: flex;justify-content: center;align-items: center;margin-top: 50px;">
        <div class="col-md-9 apply_coupon">

            <?php if (null !== $this->session->flashdata('info')) {

                $info = $this->session->flashdata('info');
                if (count($info)) {
                    $class = $info['type'];
                    ?>
                    <div class="col-md-10 alert alert-<?= $class; ?>"> <?= $info['msg']; ?> </div>
                <?php }
            } ?>

            <div class="col-md-10" style="background: white; padding:30px;">
                <form action="<?php echo $apply_coupons_url; ?>" method="post">
                    <input type="hidden" id="hidden_id" name="hidden_id" value="<?php echo $user_id; ?>">
                    <div class="col-md-8">
                        <label for="" class="css-label">Coupon code</label>
                        <input id="coupon_code" name="coupon_code" type="text" value="" class="form-control  pull-left"
                               style="width:100%;height:40px;margin-top:5px; font-size:14px;">
                    </div>
                    <div class="col-md-12" style="margin-top: 20px; padding: 0; background: white;">
                        <ul class="treeview-menu menu-open">
                            <li>Coupon code is case-insensitive.</li>
                            <li>Once coupon is applied, it will activate the associated package.</li>
                            <li>If you have higher package available, don't apply coupon that associated with lower
                                package.
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-10 text-center" style="margin-top: 2px; padding: 0;">
                        <button class="btn btn-primary btn-default applu_coupon_code">APPLY</button>
                    </div>
            </div>


            </form>
        </div>
    </div>
</div>
