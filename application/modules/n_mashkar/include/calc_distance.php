<?php
$mash_delivery_id = $details[0]['delivery_methods'][$delivery_id];
include(FCPATH . 'application/n_views/config.php');

if($mash_delivery_id['active']=='1'){

    $origin_delivery = $this->basic->get_data("ecommerce_dm", array('where' => array('id' => $delivery_id)));

    if(!empty($origin_delivery[0]['mashkor'])){
        $origin_delivery[0]['mashkor'] = json_decode($origin_delivery[0]['mashkor'],true);

        $mashkar_type = 0;
        $mashkar_on = false;
        if($origin_delivery[0]['mashkor']['mashkor_cod_cash']=='on'){
            $mashkar_on = true;
            $mashkar_type = 1;
        }
        if($origin_delivery[0]['mashkor']['mashkor_cod_card']=='on'){
            $mashkar_on = true;
            $mashkar_type = 2;
        }
        if($origin_delivery[0]['mashkor']['mashkor_online']=='on'){
            $mashkar_on = true;
            $mashkar_type = 3;
        }



        $ecom_store = $this->basic->get_data("ecommerce_store", array('where' => array('id' => $details[0]['store_id'])));

        if(!empty($ecom_store[0]['mashkor']) AND $mashkar_on){
            $ecom_store[0]['mashkor'] = json_decode($ecom_store[0]['mashkor'],true);

            $api_key_google = $ecom_store[0]['mashkor']['config']['google_api_2'];

            // Destination coordinates
            $dest_lat = $this->input->post("lat");
            $dest_lng = $this->input->post("lng");

            // Origin coordinates
            $origin_lat = $ecom_store[0]['mashkor']['pickup']['latitude'];
            $origin_lng = $ecom_store[0]['mashkor']['pickup']['longitude'];


            // Google Maps Directions API endpoint
            $api_url = 'https://maps.googleapis.com/maps/api/directions/json?';
            $api_params = 'origin='.$origin_lat.','.$origin_lng.'&destination='.$dest_lat.','.$dest_lng.'&mode=driving&key='.$api_key_google;


            // Get API response
            $response = file_get_contents($api_url . $api_params);

            // Decode the response to an associative array
            $response_data = json_decode($response, true);

            // Check if the request was successful
            if ($response_data['status'] == 'OK') {
                // The directions are in the 'routes' element of the response
                $directions = $response_data['routes'][0]['legs'][0];
                $distance = $directions['distance']['value'];
                $value_in_km = $distance / 1000;
                $ch = curl_init();

                // API parameters
                if($ecom_store[0]['mashkor']['config']['sandbox']=='on'){
                    $url = 'https://kw-ppd-api-services.mashkor.com/v1/b/ig/get-distance-based-delivery-fee-estimate';
                }else{
                    $url = 'https://kw-api-services.mashkor.com/v1/b/ig/get-distance-based-delivery-fee-estimate';
                }

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);

                curl_setopt($ch, CURLOPT_POST, TRUE);

                $check_auth = array(
                    'branch_id' => $ecom_store[0]['mashkor']['config']['branch_id'],
                    'distance' => $value_in_km
                );

                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($check_auth));
                        
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                          "Content-Type: application/json",
                            "Authorization: Bearer ".$n_config['mashkor_auth_key'],
                            "x-api-key: ".$n_config['mashkor_api_key']
                        ));

                $response = curl_exec($ch);
                curl_close($ch);

                $response = json_decode($response,true);

                if(!empty($response['message'])){
                    $error_json = array(
                        'status' => 0,
                        'message' => $response,
                        'mashkor' => 1
                    );
                    echo json_encode($error_json);
                    exit;
                }

                $del_price=$response['data']['vendor_delivery_fee'];

                $this->db->set('mashkor_delivery', $mashkar_type, FALSE);

                $mash_landmark = $this->input->post("mash_landmark");
                $mash_block = $this->input->post("mash_block");
                $mash_building = $this->input->post("mash_building");
                $mash_room_number = $this->input->post("mash_room_number");

                $mashkor_details = array(
                    'lat' => $dest_lat,
                    'lng' => $dest_lng,
                    'mash_landmark' => $mash_landmark,
                    'mash_block' => $mash_block,
                    'mash_building' => $mash_building,
                    'mash_room_number' => $mash_room_number,
                );

            } else {
                $error_json = array(
                    'status' => 0,
                    'message' => $response_data,
                    'mashkor' => 1
                );
                echo json_encode($error_json);
                exit;
            }

        }
    }
}