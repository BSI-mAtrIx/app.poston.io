<ul class="nav nav-pills">

    <li class="nav-item">
        <?php $name_tab = 'PayPal'; ?>
        <a class="nav-link active" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>


    <?php
    $n_stripe_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_stripe/controllers/N_stripe.php')) {
        $n_stripe_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'Stripe_New'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <li class="nav-item">
        <?php $name_tab = 'Stripe'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab.' (Old)'); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'SenangPay'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'Instamojo'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'Sslcommerz'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'MercadoPago'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'Mollie'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'Xendit'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'Toyyibpay'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'Paymaya'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'Myfatoorah'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'Razorpay'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <li class="nav-item">
        <?php $name_tab = 'Paystack'; ?>
        <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
    </li>

    <?php if ($xdata2['store_type'] == 'physical') : ?>
        <li class="nav-item">
            <?php $name_tab = 'Manual'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>

        <li class="nav-item">
            <?php $name_tab = 'CoD'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>

    <?php endif; ?>

    <?php
    $omise_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_omise/controllers/N_omise.php')) {
        $omise_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'Omise'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $paymongo_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_paymongo/controllers/N_paymongo.php')) {
        $paymongo_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'Paymongo'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $paymentwall_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_paymentwall/controllers/N_paymentwall.php')) {
        $paymentwall_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'Paymentwall'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $payu_latam_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_payu_latam/controllers/N_payu_latam.php')) {
        $payu_latam_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'PayULATAM'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $coinbase_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_coinbase/controllers/N_coinbase.php')) {
        $coinbase_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'Coinbase'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>


    <?php
    $n_moamalat_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_moamalat/controllers/N_moamalat.php')) {
        $n_moamalat_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'MOAMALAT'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $n_sadad_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_sadad/controllers/N_sadad.php')) {
        $n_sadad_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'SADAD'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $n_tdsp_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_tdsp/controllers/N_tdsp.php')) {
        $n_tdsp_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'TDSP'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $n_mastercard_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_mastercard/controllers/N_mastercard.php')) {

        $n_mastercard_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'mastercard'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $n_epayco_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_epayco/controllers/N_epayco.php')) {

        $n_epayco_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'ePayco'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $n_sellix_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_sellix/controllers/N_sellix.php')) {

        $n_sellix_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'Sellix'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $n_chapa_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_chapa/controllers/N_chapa.php')) {

        $n_chapa_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'Chapa'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $n_zaincash_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_zaincash/controllers/N_zaincash.php')) {

        $n_zaincash_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'ZainCash'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

    <?php
    $n_tap_hide = 'd-none';
    if (file_exists(APPPATH . 'modules/n_tap/controllers/N_tap.php')) {

        $n_tap_hide = '';
        ?>
        <li class="nav-item">
            <?php $name_tab = 'tap'; ?>
            <a class="nav-link" id="<?php echo $name_tab; ?>-tab" data-toggle="pill" href="#<?php echo $name_tab; ?>" aria-expanded="true"><?php echo $this->lang->line($name_tab); ?></a>
        </li>
    <?php } ?>

</ul>

