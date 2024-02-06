<?php
$include_upload = 0;  //upload_js
$include_datatable = 0; //datatables
$include_datetimepicker = 0; //datetimepicker, daterange, moment
$include_emoji = 0;
$include_summernote = 0;
$include_emoji = 0;
$include_colorpicker = 0;
$include_select2 = 0;
$include_jqueryui = 0;
$include_mCustomScrollBar = 0;
$include_dropzone = 0;
$include_tagsinput = 0;
$include_alertify = 0;
$include_morris = 0;
$include_chartjs = 0;
$include_owlcar = 0;
$include_prism = 1
?>


<?php

function _link($uri, $domain = '')
{
    $custom = false;
    if ($domain != '') {
        $domain = $domain . '/';
        $custom = true;
    }

    if ($custom == true) {
        if (strpos($uri, 'store') == false) {
            return 'https://' . $domain . str_replace('ecommerce/', '', $uri);
        } else {
            return 'https://' . $domain;
        }


    } else {
        return base_url($uri);
    }
}

$n_cd_data = $this->basic->get_data("n_custom_domain", array("where" => array(
    "custom_id" => $current_store_data['id'],
    "user_id" => $this->user_id,
    'active' => 1
)
));


if (empty($n_cd_data)) {
    $custom_domain_set = '';
} else {
    if ($n_cd_data[0]['active'] == 1) {
        $custom_domain_set = $n_cd_data[0]['host_url'];
    } else {
        $custom_domain_set = '';
    }

}


$store_code = array(0 => array("title" => $this->lang->line("Store Page"), "url" =>
    _link("ecommerce/store/" . $current_store_data['store_unique_id'], $custom_domain_set)
));
$category_copy = array();
$order_code = array(0 => array("title" => $this->lang->line("Buyer's Orders Page"), "url" =>
    _link("ecommerce/my_orders/" . $current_store_data['id'], $custom_domain_set)
));
$product_copy = array();
foreach ($category_list as $key => $value) {
    if (empty($n_cd_data)) {
        $cat_for = base_url("ecommerce/category/" . $key . '_' . url_title($value));
    } else {
        $cat_for = _link("category/" . $key . '_' . url_title($value), $custom_domain_set);
    }

    $store_code[] = array("title" => $this->lang->line("Store Page") . " - " . $this->lang->line("Category") . " : " . $value, "url" => $cat_for);
}
$product_list_assoc = array();
foreach ($product_list as $key => $value) {
    if (empty($n_cd_data)) {
        $prod_for = base_url("ecommerce/product/" . $value['id']);
    } else {
        $prod_for = _link("product/" . $value['id'] . '_' . url_title($value['product_name']), $custom_domain_set);
    }
    $product_copy[] = array("title" => $this->lang->line("Product Page") . " : " . $value["product_name"], "url" => $prod_for);
}
?>

<div class="section-body">
    <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab2" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#home2" role="tab"
                   aria-controls="home" aria-selected="true"><?php echo $this->lang->line("Store URL"); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                   aria-controls="profile" aria-selected="false"><?php echo $this->lang->line("Order URL"); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#contact2" role="tab"
                   aria-controls="contact" aria-selected="false"><?php echo $this->lang->line("Product URL"); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="legal-tab2" data-toggle="tab" href="#legal2" role="tab" aria-controls="legal"
                   aria-selected="false"><?php echo $this->lang->line("Legal URL"); ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="embed-tab2" data-toggle="tab" href="#embed2" role="tab" aria-controls="embed"
                   aria-selected="false"><?php echo $this->lang->line("Widget"); ?></a>
            </li>
        </ul>
        <div class="tab-content tab-bordered" id="myTab3Content">

            <div class="tab-pane fade show active bg-body" id="home2" role="tabpanel" aria-labelledby="home-tab2">
                <?php
                foreach ($store_code as $key => $value) { ?>
                    <div class="card mb-0">
                        <div class="card-header pb-0">
                            <h4 class="font-medium-2"><i class="bx bx-circle"></i>
                                <a href="<?php echo $value["url"]; ?>"
                                   target="_BLANK"><?php echo $value['title']; ?></a>
                            </h4>
                        </div>
                        <div class="card mb-0">
                            <pre class="language-javascript"><code class="language-javascript"><span
                                            class="token keyword"><?php echo $value["url"]; ?></span></code></pre>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="tab-pane fade bg-body" id="profile2" role="tabpanel" aria-labelledby="profile-tab2">
                <?php
                foreach ($order_code as $key => $value) { ?>
                    <div class="card mb-0">
                        <div class="card-header pb-0">
                            <h4 class="font-medium-2"><i class="bx bx-circle"></i>
                                <a href="<?php echo $value["url"]; ?>"
                                   target="_BLANK"><?php echo $value['title']; ?></a>
                            </h4>
                        </div>
                        <div class="card mb-0">
                            <pre class="language-javascript"><code class="language-javascript"><span
                                            class="token keyword"><?php echo $value["url"]; ?></span></code></pre>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="tab-pane fade bg-body" id="contact2" role="tabpanel" aria-labelledby="contact-tab2">
                <?php
                foreach ($product_copy as $key => $value) { ?>
                    <div class="card mb-0">
                        <div class="card-header pb-0">
                            <h4 class="font-medium-2"><i class="bx bx-circle"></i>
                                <a href="<?php echo $value["url"]; ?>"
                                   target="_BLANK"><?php echo $value['title']; ?></a>
                            </h4>
                        </div>
                        <div class="card mb-0">
                            <pre class="language-javascript"><code class="language-javascript"><span
                                            class="token keyword"><?php echo $value["url"]; ?></span></code></pre>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="tab-pane fade bg-body" id="legal2" role="tabpanel" aria-labelledby="legal-tab2">
                <div class="card mb-0">
                    <div class="card-header pb-0">
                        <h4 class="font-medium-2"><i class="bx bx-circle font"></i>
                            <?php $legal_url1 = _link("ecommerce/terms/" . $current_store_data['store_unique_id'], $custom_domain_set); ?>
                            <a href="<?php echo $legal_url1; ?>"
                               target="_BLANK"><?php echo $this->lang->line("Terms of service"); ?></a>
                        </h4>
                    </div>
                    <div class="card mb-0">
                        <pre class="language-javascript"><code class="language-javascript"><span
                                        class="token keyword"><?php echo $legal_url1; ?></span></code></pre>
                    </div>
                </div>
                <div class="card mb-0">
                    <div class="card-header pb-0">
                        <h4 class="font-medium-2"><i class="bx bx-circle"></i>
                            <?php $legal_url2 = _link("ecommerce/refund_policy/" . $current_store_data['store_unique_id'], $custom_domain_set); ?>
                            <a href="<?php echo $legal_url2; ?>"
                               target="_BLANK"><?php echo $this->lang->line("Refund policy"); ?></a>
                        </h4>
                    </div>
                    <div class="card mb-0">
                        <pre class="language-javascript"><code class="language-javascript"><span
                                        class="token keyword"><?php echo $legal_url2; ?></span></code></pre>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade bg-body" id="embed2" role="tabpanel" aria-labelledby="embed-tab2">
                <div class="card mb-0">
                    <div class="card-header pb-0">
                        <h4 class="font-medium-2"><i class="bx bx-circle"></i>
                            <?php $embed_url = isset($store_code[0]['url']) ? $store_code[0]['url'] : '';


                            ?>
                            <a href="<?php echo $embed_url; ?>"
                               target="_BLANK"><?php echo $this->lang->line("Embed Code"); ?></a>
                        </h4>
                    </div>
                    <div class="card mb-0">
                        <pre class="language-javascript"><code class="language-javascript"><span
                                        class="token keyword"><?php echo htmlspecialchars('<iframe width="100%" height="800" src="' . $embed_url . '" frameborder="0"  gesture="media" allow="encrypted-media" allowfullscreen></iframe>'); ?></span></code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
