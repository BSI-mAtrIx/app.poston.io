<?php
$pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';
$store_unique_id = isset($store_data['store_unique_id']) ? $store_data['store_unique_id'] : "";
$currency = isset($ecommerce_config['currency']) ? $ecommerce_config['currency'] : "USD";
$currency_icon = isset($currency_icons[$currency]) ? $currency_icons[$currency] : "$";

$form_action = base_url('ecommerce/store/' . $store_data['store_unique_id']);
$subscriber_id = $this->session->userdata($store_id . "ecom_session_subscriber_id");
if ($subscriber_id == "") $subscriber_id = isset($_GET['subscriber_id']) ? $_GET['subscriber_id'] : "";
$form_action = mec_add_get_param($form_action, array("subscriber_id" => $subscriber_id, "pickup" => $pickup));
?>
<?php $this->load->view('admin/theme/message'); ?>

    <style type="text/css">
        @media (max-width: 575.98px) {
            #search_store_id {
                width: 75px;
            }

            #search_status {
                width: 80px;
            }

            #select2-search_store_id-container, #select2-search_status-container, #search_value {
                padding-left: 8px;
                padding-right: 5px;
            }
        }

        #mytable .d-inline-flex {
            display: block !important;
        }

        #mytable td {
            padding-left: 15px !important;
            padding-right: 15px !important;
            padding-top: 15px !important;
        }
    </style>
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css?ver=<?php echo $n_config['theme_version']; ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo base_url(); ?>n_assets/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css?ver=<?php echo $n_config['theme_version']; ?>">


    <div class="row pt-3 pl-3 pr-3 pb-0">
        <div class="col-12 p-0">
            <div class="card shadow-none mb-0">
                <div class="card-body data-card">
                    <div class="row">
                        <div class="col-6 col-md-4">
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
                <button class="btn btn-primary" type="button" id="search_action"><i class="bx bx-search"></i> <span class="d-none d-sm-inline">' . $this->lang->line("Search") . '</span></button>
              </div>
            </div>'; ?>
                        </div>

                        <div class="col-6 col-md-8 text-right">

                            <?php
                            echo $drop_menu = '<a href="javascript:;" id="search_date_range" class="btn btn-outline-primary icon-left btn-icon"><i class="bx bx-calendar"></i> ' . $this->lang->line("Choose Date") . '</a><input type="hidden" id="search_date_range_val">';
                            ?>


                        </div>
                    </div>

                    <div class="table-responsive2">
                        <input type="hidden" id="put_page_id">
                        <table class="table table-striped" id="mytable" style="width: 100%;">
                            <thead class="d-none">
                            <tr>
                                <th>#</th>
                                <th style="vertical-align:middle;width:20px">
                                    <input class="regular-checkbox" id="datatableSelectAllRows" type="checkbox"/><label
                                            for="datatableSelectAllRows"></label>
                                </th>
                                <th><?php echo $this->lang->line("Order ID") ?></th>
                                <th><?php echo $this->lang->line("Coupon") ?></th>
                                <th><?php echo $this->lang->line("Transaction ID") ?></th>
                                <th><?php echo $this->lang->line("My Data") ?></th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <style type="text/css">
        a[aria-expanded="false"]::before, a[aria-expanded="true"]::before {
            content: '' !important;
        }
    </style>


    <div class="modal fade" tabindex="-1" role="dialog" id="manual-payment-modal" data-backdrop="static"
         data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><i
                                class="bx bx-receipt"></i> <?php echo $this->lang->line("Manual Payment Information"); ?>
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="bx bx-chevron-left"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
<?php include(APPPATH . "n_views/ecommerce/common_style.php"); ?>