<?php
$return_get_credits = 0;

$info = $this->CI->basic->get_data('users', array('where' => array('id'=>$this->CI->user_id)), '','', 1);

if(!empty($info)){
    if ($info[0]['user_type'] == 'Admin') {
        $return_get_credits = 999999999999;
    }else{
        $package_info = $this->CI->basic->get_data("package", $where=array("where"=>array("id"=>$info[0]["package_id"])),'','', 1);
        if (!empty($package_info[0]['monthly_limit'])) {
            $package = $package_info[0]['monthly_limit'];
            $package = json_decode($package, true);
            if (!empty($package[3232]) and $package[3232] > 0) {
                $status=$this->CI->_check_usage(3232,$package[3232]);
                if($status==1){
                    $this->CI->_insert_usage_log(3232, $package[3232]);


                    $update_data = array();
                    //$update_data['n_credits'] = $package[3232];
                    $this->CI->db->set('n_credits', 'n_credits+'.$package[3232], FALSE);
                    $this->CI->basic->update_data("users", array('id' => $this->CI->user_id), $update_data);
                }

            }

            $user_info = $this->CI->basic->get_data('users', ['where' => ['id' => $this->CI->user_id]]);
            $return_get_credits = $user_info[0]['n_credits'];
        }

    }
}