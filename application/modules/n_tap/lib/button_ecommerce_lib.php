<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

$n_tap_btn .= ' 
                    <div class="col-12 col-md-6 text-center">
                      <a id="pay_tap_new" href="#"  action_n_url="' . base_url('n_tap/n_payment_button_ecommerce/' . $store_id . '/' . $cart_id . '/' . $subscriber_id) . '"  class="list-group-item list-group-item-action flex-column align-items-start">
                      <div class="d-flex w-100 align-items-center">
                      <small class="text-muted"><img style="width:60px; padding: 10px;" src="https://websiteimages.b-cdn.net/tap_logo.svg" />
</small>
                      <h6 class="mb-1">' . $this->lang->line("Pay with tap") . '</h6>
                      </div>
                      </a>
                      </div>
                   ';


$new_checkout['tap'] = array(
    'hidden_code' => $n_tap_btn,
    'action' => 'redirect',
    'action_class' => '',
    'action_id' => 'pay_tap_new',
    'id' => 'new_tap',
    'title' => $this->lang->line("Pay with tap"),
    'description' => '',
    'href' =>  base_url('n_tap/n_payment_button_ecommerce/' . $store_id . '/' . $cart_id . '/' . $subscriber_id),
);