<style type="text/css">
    /*---------------------------------
    My Account Page
----------------------------------*/
    .my-account .breadcrumb-nav {
        margin-bottom: 3.2rem;
    }

    .my-account .tab-vertical .nav {
        width: 24.41%;
        border: none;
    }

    .my-account .tab-content {
        width: 75.59%;
        padding-left: 1.5rem;
        border: none;
    }

    .my-account .nav-link,
    .my-account .link-item {
        margin-bottom: 0;
        padding: 1.7rem 0 1.6rem;
        font-size: 1.6rem;
        text-transform: none;
        border-bottom: 1px solid #eee;
    }

    .my-account .link-item {
        font-weight: 600;
        color: #333;
        line-height: 1;
    }

    .my-account .link-item a {
        color: inherit;
    }

    .my-account .link-item:hover {
        color: #336699;
    }

    .my-account .tab-pane p {
        font-size: 1.4rem;
        line-height: 1.8;
    }

    .my-account .icon-box.text-center i {
        display: block;
        font-size: 6rem;
        color: #333;
        transition: transform 0.4s;
    }

    .my-account .text-center .icon-box-icon {
        margin-bottom: 1.9rem;
    }

    .my-account .icon-box.text-center:hover .icon-box-icon i {
        color: #336699;
        transform: scale(1.1);
    }

    .my-account .icon-box.text-center:hover p {
        text-decoration: underline;
    }

    .my-account .icon-box.icon-box-side .icon-orders, .my-account .icon-box.icon-box-side .icon-map-marker {
        margin-right: 1rem;
    }

    .my-account .icon-box.icon-box-side .w-icon-download {
        font-size: 2.4rem;
    }

    .my-account .icon-box.icon-box-side .icon-account {
        margin-right: 0.8rem;
    }

    .my-account .form-control {
        transition: border-color 0.4s;
    }

    .my-account .form-control:focus {
        border-color: #336699;
    }

    .my-account .icon-box-light {
        display: inline-flex;
    }

    .my-account .icon-box-light i {
        font-size: 2.5rem;
        color: #999;
    }

    .my-account .icon-box-light .icon-box-title {
        font-size: 2rem;
    }

    .my-account .order:not(th) {
        padding-top: 0.9rem;
    }

    .my-account .order:not(th) .order-table {
        padding: 1.1rem 2.9rem 0;
    }

    #account-dashboard.tab-pane {
        padding-top: 1.5rem;
    }

    #account-dashboard p.greeting {
        font-size: 1.6rem;
    }

    #account-dashboard p a:hover {
        text-decoration: underline;
    }

    #account-dashboard .icon-box {
        padding: 4rem 2rem;
        border: 1px solid #eee;
        border-radius: 3px;
        transition: all 0.4s;
    }

    #account-dashboard .icon-box:hover {
        box-shadow: 1px 1px 10px rgba(0, 0, 0, 0.1);
    }

    #account-dashboard .icon-box:hover p {
        color: #336699;
    }

    #account-dashboard .icon-box p {
        margin-bottom: 0;
        font-size: 1.4rem;
        color: #666;
        transition: color;
    }

    #account-dashboard .icon-box-title {
        font-size: 1.8rem;
        text-transform: capitalize;
    }

    #account-downloads.tab-pane {
        padding-top: 0.9rem;
    }

    #account-downloads .icon-box-side .w-icon-download {
        font-size: 2.5rem;
        margin-top: -0.5rem;
    }

    #account-downloads .icon-box {
        margin-bottom: 1.4rem;
    }

    #account-orders.tab-pane {
        padding-top: 0.8rem;
    }

    #account-orders .icon-box {
        margin-bottom: 1.8rem;
    }

    #account-orders .account-orders-table th {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    #account-orders .account-orders-table td {
        padding-top: 2.1rem;
        padding-bottom: 2.1rem;
    }

    #account-orders .account-orders-table .order-id {
        padding-left: 1rem;
        width: 20.77%;
    }

    #account-orders .account-orders-table .order-date {
        width: 20.1%;
    }

    #account-orders .account-orders-table .order-status {
        width: 20%;
    }

    #account-orders .account-orders-table .order-total {
        width: 25.48%;
    }

    #account-orders .account-orders-table .order-action {
        width: 13.78%;
        padding-right: 1rem;
    }

    #account-orders .account-orders-table td.order-total {
        letter-spacing: 0;
    }

    #account-orders .order-action .btn {
        color: #333;
        border-color: #ccc;
        transition: color 0.4s, border-color 0.4s, background-color 0.4s;
    }

    #account-orders .order-action .btn:hover {
        background-color: #333;
        border-color: #333;
        color: #fff;
    }

    #account-details.tab-pane {
        padding-top: 0.9rem;
    }

    #account-details.tab-pane .w-icon-user {
        margin-bottom: 0.3rem;
    }

    #account-details .icon-box {
        margin-bottom: 1.4rem;
    }

    #account-details .account-details-form label {
        color: #666;
        font-size: 1.4rem;
        line-height: 2.3;
    }

    #account-details .account-details-form .form-control {
        margin-bottom: 1.6rem;
        border-radius: 0.3rem;
        font-size: 1.4rem;
        color: #666;
    }

    #account-details .account-details-form p {
        font-size: 1.2rem;
        letter-spacing: -0.015em;
        line-height: 2.1;
    }

    #account-details .card {
        border: 1px solid #eee;
    }

    #account-details .title-password {
        font-size: 1.8rem;
    }

    #account-addresses.tab-pane {
        padding-top: 0.8rem;
    }

    #account-addresses.tab-pane p {
        margin-bottom: 2.1rem;
        line-height: 1.6;
    }

    #account-addresses .title {
        font-size: 1.5rem;
        margin-bottom: 1.7rem;
        padding-bottom: 1.4rem;
    }

    #account-addresses .title-underline::after {
        background-color: #e5e5e5;
    }

    #account-addresses address {
        font-style: normal;
    }

    #account-addresses .address-table th, #account-addresses .address-table td {
        padding: 0.3rem 0;
    }

    #account-addresses .address-table th {
        font-weight: normal;
        text-align: left;
        width: 100px;
        color: #999;
    }

    #account-addresses .address-table td {
        color: #333;
    }

    @media (max-width: 767px) {
        .my-account .tab-vertical .nav-tabs, .my-account .tab-vertical .tab-content {
            width: 100%;
        }

        #account-orders .account-orders-table td {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            word-break: break-all;
        }

        #account-orders .account-orders-table .order-id {
            width: 10%;
            padding-left: 0;
        }

        #account-orders .order-action .btn {
            padding: 0;
            border: none;
            text-align: left;
        }

        #account-orders .order-action .btn:hover, #account-orders .order-action .btn:active, #account-orders .order-action .btn:focus {
            background-color: transparent;
            border: none;
            color: #336699;
        }
    }

    .login-page .login-popup {
        margin: 4.2rem auto 5rem;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .login-page .checkbox-round + label::before {
        border-radius: 50%;
        border: 1px solid #ccc;
        background: transparent;
    }

    .login-page .checkbox-round + label::after {
        content: "";
        width: 0.8rem;
        height: 0.8rem;
        background-color: #333;
        position: absolute;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        left: 5px;
        opacity: 0;
    }

    .login-page .checkbox-round.active + label::after {
        opacity: 1;
    }

    .login-page .login-vendor {
        display: none;
    }

    /*-------------------------
        Order Page
    -------------------------*/
    .order .shop-breadcrumb {
        margin-bottom: 2.2rem;
    }

    .order .order-table {
        padding: 0.6rem 3rem 3rem;
        border: 1px solid #e1e1e1;
        border-collapse: separate;
    }

    .order .order-table thead th {
        padding-bottom: 1.7rem;
        font-size: 1.8rem;
    }

    .order .order-table thead th,
    .order .order-table tfoot th,
    .order .order-table tfoot td {
        border-bottom: 1px solid #e1e1e1;
    }

    .order .order-table td {
        border: none;
    }

    .order .order-table tbody td:first-child {
        min-width: 16rem;
        padding-top: 3rem;
        padding-bottom: 0;
    }

    .order .order-table tbody a {
        color: #336699;
    }

    .order .order-table tbody a:hover {
        text-decoration: underline;
    }

    .order .order-table tbody strong {
        color: #333;
    }

    .order .order-table tfoot {
        font-size: 1.6rem;
    }

    .order .order-table tfoot th, .order .order-table tfoot td {
        padding-top: 1.5rem;
        padding-bottom: 1.8rem;
        font-weight: 600;
    }

    .order .order-table tfoot th {
        color: #333;
    }

    .order .order-table .total td {
        font-weight: 700;
        font-size: 2rem;
        color: #333;
    }

    .order .alert {
        border: 1px dashed #e5e5e5;
    }

    .order .alert i {
        color: #799b5a;
    }

    .order .address-table td {
        color: #666 !important;
    }

    .order #billing-account-addresses {
        border-bottom: 1px solid #e1e1e1;
    }

    .order #billing-account-addresses .email td {
        padding-top: 3.5rem;
    }

    .order .btn-back {
        padding: 0.85em 1.4em;
    }

    .order-success {
        padding: 3.6rem 1.5rem;
        border: 2px solid #e1e1e1;
        font-size: 2.4rem;
    }

    .order-success i {
        font-size: 28px;
        vertical-align: middle;
        margin-right: 0.8rem;
    }

    .order-view {
        padding: 0;
        display: flex;
        align-items: center;
        margin: 3.2rem 0;
    }

    .order-view li {
        flex-grow: 1;
        padding: 1rem;
        text-align: center;
        font-size: 1.8rem;
    }

    .order-view strong {
        color: #333;
        display: block;
    }

    .order-subtable thead tr {
        border-bottom: 1px solid #e1e1e1;
    }

    .order-subtable thead th {
        padding-bottom: 2rem;
        font-size: 1.8rem;
        color: #333;
        text-align: left;
        font-weight: 600;
    }

    .order-subtable td {
        white-space: nowrap;
    }

    .order-subtable tbody td {
        border: none;
        padding: 1.5rem 0;
    }

    .order-subtable strong {
        display: block;
        color: #333;
    }

    .order-subtable .order {
        width: 12.5%;
    }

    .order-subtable .date {
        width: 21.13%;
    }

    .order-subtable .status {
        width: 14.11%;
    }

    .order-subtable .total {
        width: 32%;
        color: #333;
    }

    .order-subtable .action {
        text-align: right;
    }

    .order-subtable tbody tr:first-child td {
        padding-top: 3.4rem;
    }

    .order-subtable tbody .order {
        color: #336699;
    }

    .order-subtable tbody .btn {
        padding: 0.72em 1.2em;
        color: #333;
        border-color: #eee;
        background-color: #eee;
    }

    .order-subtable tbody .btn:hover, .order-subtable tbody .btn:active, .order-subtable tbody .btn:focus {
        color: #fff;
        border-color: #333;
        background-color: #333;
    }

    .order-subtable thead th:not(:last-child),
    .order-subtable tbody td:not(:last-child) {
        padding-right: 1rem;
    }

    @media (max-width: 767px) {
        .order-view {
            display: block;
        }

        .order-view li {
            display: flex;
            text-align: left;
        }

        .order-view label {
            max-width: 50%;
            flex: 0 0 50%;
            padding-right: 1rem;
        }
    }

    @media (max-width: 767px) {
        .order-subtable {
            display: block;
            overflow-x: auto;
            min-width: 100%;
        }
    }

    @media (max-width: 479px) {
        .order-view li {
            font-size: 1.5rem;
        }

        .order .order-table {
            padding-left: 2rem;
            padding-right: 2rem;
        }
    }
</style>

<!-- Start of Main -->
<main class="main my-account">

    <nav class="breadcrumb-nav">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="<?php e_link($store_home_url); ?>"><?php echo $l->line('Home'); ?></a></li>
                <li><?php echo $l->line('My account'); ?></li>
            </ul>
        </div>
    </nav>

    <!-- Start of PageContent -->
    <div class="page-content pt-2">
        <div class="container">
            <div class="tab tab-vertical row gutter-lg">
                <ul class="nav nav-tabs mb-6" role="tablist">
                    <li class="nav-item">
                        <a href="#account-dashboard" class="nav-link active"><?php echo $l->line('Dashboard'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#account-orders" class="nav-link"><?php echo $l->line('Orders'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#account-addresses" class="nav-link"><?php echo $l->line('Addresses'); ?></a>
                    </li>
                    <li class="link-item">
                        <a href="<?php echo $logout_ntheme; ?>" class="logout_btn"><?php echo $l->line('Logout'); ?></a>
                    </li>
                </ul>
                <?php
                if (empty($n_subscriber_info['full_name'])) {
                    $n_subscriber_info['full_name'] = $n_subscriber_info['first_name'] . ' ' . $n_subscriber_info['last_name'];
                }
                ?>

                <div class="tab-content mb-6">
                    <div class="tab-pane active in" id="account-dashboard">
                        <p class="greeting">
                            <?php echo $l->line('Hello'); ?>
                            <span class="text-dark font-weight-bold"><?php echo $n_subscriber_info['full_name']; ?></span>
                            (<?php echo $l->line('not'); ?>
                            <span class="text-dark font-weight-bold"><?php echo $n_subscriber_info['full_name']; ?></span>?
                            <a href="<?php echo $logout_ntheme; ?>"
                               class="text-primary logout_btn"><?php echo $l->line('Logout'); ?></a>)
                        </p>

                        <p class="mb-4">
                            <?php echo $l->line('From your account dashboard you can view your'); ?> <a
                                    href="#account-orders"
                                    class="text-primary link-to-tab"><?php echo $l->line('recent orders'); ?></a>,
                            <?php echo $l->line('manage your'); ?> <a href="#account-addresses"
                                                                      class="text-primary link-to-tab"><?php echo $l->line('shipping and billing addresses'); ?></a>, <?php echo $l->line('and'); ?>
                            <a href="#account-details"
                               class="text-primary link-to-tab"><?php echo $l->line('edit your password and account details'); ?>
                                .</a>
                        </p>

                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                <a href="#account-orders" class="link-to-tab">
                                    <div class="icon-box text-center">
                                                <span class="icon-box-icon icon-orders">
                                                    <i class="w-icon-orders"></i>
                                                </span>
                                        <div class="icon-box-content">
                                            <p class="text-uppercase mb-0"><?php echo $l->line('Orders'); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                <a href="#account-addresses" class="link-to-tab">
                                    <div class="icon-box text-center">
                                                <span class="icon-box-icon icon-address">
                                                    <i class="w-icon-map-marker"></i>
                                                </span>
                                        <div class="icon-box-content">
                                            <p class="text-uppercase mb-0"><?php echo $l->line('Addresses'); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                <a href="<?php echo $logout_ntheme; ?>" class="logout_btn">
                                    <div class="icon-box text-center">
                                                <span class="icon-box-icon icon-logout">
                                                    <i class="w-icon-logout"></i>
                                                </span>
                                        <div class="icon-box-content">
                                            <p class="text-uppercase mb-0"><?php echo $l->line('Logout'); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane mb-4" id="account-orders">
                        <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-orders"></i>
                                    </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title text-capitalize ls-normal mb-0"><?php echo $l->line('Orders'); ?></h4>
                            </div>
                        </div>

                        <?php
                        $status_list[''] = $this->lang->line("Status");
                        echo
                            '<div class="input-group mb-3" id="searchbox">
              <div class="input-group-prepend d-none">
                <input type="text" value="' . $store_id . '" name="search_store_id" id="search_store_id">
                <input type="text" value="' . $subscriber_id . '" name="search_subscriber_id" id="search_subscriber_id">
                <input type="text" value="' . $pickup . '" name="search_pickup" id="search_pickup">
              </div>
              <div class="input-group-prepend d-none">
                ' . form_dropdown('search_status', $status_list, '', 'class="select2 form-control" id="search_status"') . '
              </div>
              <input type="text" class="form-control rounded-left" id="search_value" autofocus name="search_value" placeholder="' . $this->lang->line("Search...") . '">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="search_action"><i class="w-icon-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>
              </div>
            </div>'; ?>

                        <table class="shop-table account-orders-table mb-6" id="order_table"
                               style="width: 100%!important;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Input</th>
                                <th class="order-id"><?php echo $l->line('Order'); ?></th>
                                <th class="order-date"><?php echo $l->line('Date'); ?></th>
                                <th class="order-status"><?php echo $l->line('Status'); ?></th>
                                <th class="order-total"><?php echo $l->line('Total'); ?></th>
                                <th class="order-actions"><?php echo $l->line('Actions'); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>

                    <div class="tab-pane" id="account-addresses">
                        <div class="icon-box icon-box-side icon-box-light">
                                    <span class="icon-box-icon icon-map-marker">
                                        <i class="w-icon-map-marker"></i>
                                    </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title mb-0 ls-normal"><?php echo $l->line('Addresses'); ?></h4>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-sm-6 mb-6">
                                <div class="ecommerce-address billing-address pr-lg-8">
                                    <h4 class="title title-underline ls-25 font-weight-bold"><?php echo $l->line('Billing Address'); ?></h4>

                                    <a href="#"
                                       class="btn btn-link btn-underline btn-icon-right text-primary"
                                       id="showProfile"><?php echo $l->line('Edit your billing address'); ?><i
                                                class="w-icon-long-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-6">
                                <div class="ecommerce-address shipping-address pr-lg-8">
                                    <h4 class="title title-underline ls-25 font-weight-bold"><?php echo $l->line('Shipping Address'); ?></h4>

                                    <a href="#"
                                       class="btn btn-link btn-underline btn-icon-right text-primary"
                                       id="showAddress"><?php echo $l->line('Edit your shipping address'); ?><i
                                                class="w-icon-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End of PageContent -->
</main>
<!-- End of Main -->