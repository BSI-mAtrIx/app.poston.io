<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
$n_year = '';
foreach (range(date('Y'), date('Y') + 15) as $year) {
    $n_year .= '<option>' . $year . '</option>';
}
$n_paymongo_btn = '';

if ($n_paymongo_enabled == '1') {

    $n_paymongo_btn_card = ' 
                    <div class="col-12 col-md-6 text-center button_checkout_hide">
                      <a href="#" class="list-group-item list-group-item-action flex-column align-items-start paymongo_pay_card">
                      <div class="d-flex w-100 align-items-center">
                      <small class="text-muted"><img class="rounded" style="padding: 10px;" width="60" height="60" src="https://assets-global.website-files.com/60411749e60be86afb89d2f0/6041194a54fc8f4dfc8730bd_Paymongo_Final_Main_Logo_2020_RGB_green_horizontal.svg"></small>
                      <h6 class="mb-1">' . $this->lang->line("Pay with Paymongo (Card)") . '</h6>
                      </div>
                      </a>
                      </div>
                   ';




    if ($payment_amount >= 100) {
        $n_paymongo_btn_card .= '
                         <div class="card mt-5 paymongo_card_loader" style="display: none;">
                        <div class="card-header">
                            <strong>' . $this->lang->line("Paymongo Credit Card") . '</strong>
                            <small>' . $this->lang->line("processing") . '</small>
                        </div>
                        <div class="card-body text-center mt-5">
                            <i class="fas fa-sync fa-spin fa-3x"></i>
                        </div>
                    </div>
                    
                     <form name="checkoutForm" method="POST" action="' . base_url('n_paymongo/card_eco/' . $store_id . '/' . $cart_id . '/' . $subscriber_id ) . '" class="paymongo_card_details needs-validation" style="display:none;">
                     <input type="hidden" name="csrf_token" id="csrf_token" value="' . $this->session->userdata('csrf_token_session') . '">
    
                 
                    <div class="card mt-5">
                        <div class="card-header">
                            <strong>' . $this->lang->line("Paymongo Credit Card") . '</strong>
                            <small>' . $this->lang->line("enter your card details") . '</small>
                        </div>
                        <div class="card-body">
                                       <div class="alert alert-icon alert-warning alert-bg alert-inline show-code-action" id="paymongo_error" style="display: none;">
                                        <h4 class="alert-title">
                                            <i class="w-icon-exclamation-triangle"></i></h4>
                                        <span class="paymongo_error"></span>
                                    </div>
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="paymongo_name">' . $this->lang->line("Name") . '</label>
                                        <input class="form-control" id="paymongo_name" type="text" placeholder="Enter your name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="paymongo_ccnumber">' . $this->lang->line("Credit Card Number") . '</label>
                                            <input required id="paymongo_ccnumber" name="paymongo_ccnumber" class="form-control" placeholder="0000 0000 0000 0000" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-sm-4">
                                    <label for="paymongo_ccmonth">' . $this->lang->line("Month") . '</label>
                                    <select class="form-control" id="paymongo_ccmonth" required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="paymongo_ccyear">' . $this->lang->line("Year") . '</label>
                                    <select class="form-control" id="paymongo_ccyear" required>
            
                                    ' . $n_year . '
        
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="paymongo_cvv">' . $this->lang->line("CVV/CVC") . '</label>
                                        <input class="form-control" id="paymongo_cvv" type="text" placeholder="123" required>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <div class="card-footer">
                          <button type="submit" id="n_paymongo_pay_with_card" class="btn btn-block btn-dark btn-icon-right btn-rounded btn-checkout place-order btn-next" id="paymongo-checkout-button">' . $this->lang->line("PAY WITH CARD") . ' <i class="w-icon-long-arrow-right"></i></button>
                        </div>
                    </div>
                    </form>
        ';
    } else {

        $n_paymongo_btn_card .= '
                             <div class="card mt-5 paymongo_card_details" style="display: none;">
                        <div class="card-header">
                            <strong>' . $this->lang->line('Paymongo Credit Card') . '</strong>
                        </div>
                        <div class="card-body text-center mt-5">
                            <div class="alert alert-icon alert-warning alert-bg alert-inline show-code-action" id="paymongo_error">
                                        <h4 class="alert-title">
                                            <i class="w-icon-exclamation-triangle"></i></h4>
                                        <span>' . $this->lang->line('Pay with Paymongo allow only for payment amount higher than 100 PHP') . '</span>
                                    </div>
                        </div>
                    </div>
        ';
    }

    $n_paymongo_btn .= $n_paymongo_btn_card;

    $new_checkout['paymongo_card'] = array(
        'hidden_code' => $n_paymongo_btn_card,
        'modal' => 1,
        'action' => 'onlick',
        'action_class' => 'paymongo_pay_card',
        'action_id' => '',
        'id' => 'new_paymongo_card',
        'title' => $this->lang->line("Pay with Paymongo (Card)"),
        'description' => '',
        'href' => '',
    );

}

if ($n_paymongo_grab_en == '1') {
    $n_paymongo_btn_grab = ' 
                    <div class="col-12 col-md-6 text-center">
                      <a href="' . base_url('n_paymongo/n_payment_button_another_ecommerce/' . $store_id . '/' . $cart_id . '/' . $subscriber_id . '/grab_pay') . '" class="list-group-item list-group-item-action flex-column align-items-start">
                      <div class="d-flex w-100 align-items-center">
                      <small class="text-muted"><img class="rounded" style="padding: 10px;" width="60" height="60" src="https://assets-global.website-files.com/60411749e60be86afb89d2f0/61813aa32092e2ae96b79636_GrabPay.svg"></small>
                      <h6 class="mb-1">' . $this->lang->line("Pay with GrabPay") . '</h6>
                      </div>
                      </a>
                      </div>
                   ';

    $n_paymongo_btn .= $n_paymongo_btn_grab;

    $new_checkout['grabpay'] = array(
        'hidden_code' => '',
        'action' => 'redirect',
        'action_class' => '',
        'action_id' => '',
        'id' => 'new_grabpay',
        'title' => $this->lang->line("Pay with GrabPay"),
        'description' => '',
        'href' => base_url('n_paymongo/n_payment_button_another_ecommerce/' . $store_id . '/' . $cart_id . '/' . $subscriber_id  . '/grab_pay'),
    );
}

if ($n_paymongo_paymaya_en == '1') {
    $n_paymongo_btn .= ' 
                    <div class="col-12 col-md-6 text-center">
                      <a href="' . base_url('n_paymongo/n_payment_button_paymaya_ecommerce/' . $store_id . '/' . $cart_id . '/' . $subscriber_id) . '" class="list-group-item list-group-item-action flex-column align-items-start">
                      <div class="d-flex w-100 align-items-center">
                      <small class="text-muted"><img class="rounded" style="padding: 10px;" width="60" height="60" src="https://assets-global.website-files.com/60411749e60be86afb89d2f0/61813aa32092e23be8b79637_PayMaya.svg"></small>
                      <h6 class="mb-1">' . $this->lang->line("Pay with PayMaya") . '</h6>
                      </div>
                      </a>
                      </div>
                   ';

    $new_checkout['paymaya'] = array(
        'hidden_code' => '',
        'action' => 'redirect',
        'action_class' => '',
        'action_id' => '',
        'id' => 'new_paymaya',
        'title' => $this->lang->line("Pay with PayMaya"),
        'description' => '',
        'href' => base_url('n_paymongo/n_payment_button_paymaya_ecommerce/' . $store_id . '/' . $cart_id . '/' . $subscriber_id),
    );

}

if ($n_paymongo_gcash_en == '1') {
    $n_paymongo_btn .= ' 
                    <div class="col-12 col-md-6 text-center">
                      <a href="' . base_url('n_paymongo/n_payment_button_another_ecommerce/' . $store_id . '/' . $cart_id . '/' . $subscriber_id . '/gcash') . '" class="list-group-item list-group-item-action flex-column align-items-start">
                      <div class="d-flex w-100 align-items-center">
                      <small class="text-muted"><img class="rounded" style="padding: 10px;" width="60" height="60" src="https://assets-global.website-files.com/60411749e60be86afb89d2f0/61813aa32092e2e51bb79638_gcash.png"></small>
                      <h6 class="mb-1">' . $this->lang->line("Pay with GCash") . '</h6>
                      </div>
                      </a>
                      </div>
                   ';

    $new_checkout['gcash'] = array(
        'hidden_code' => '',
        'action' => 'redirect',
        'action_class' => '',
        'action_id' => '',
        'id' => 'new_gcash',
        'title' => $this->lang->line("Pay with GCash"),
        'description' => '',
        'href' => base_url('n_paymongo/n_payment_button_another_ecommerce/' . $store_id . '/' . $cart_id . '/' . $subscriber_id  . '/gcash'),
    );
}