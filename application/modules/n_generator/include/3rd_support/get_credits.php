<?php
$return_get_credits = 0;
if ($this->bot_admin_is == 'Admin') {
    $return_get_credits = 999999999999;
}else{
    if (!empty($this->monthly_limit)) {
        if (!empty($this->monthly_limit[3232]) and $this->monthly_limit[3232] > 0) {
            $status=$this->_check_usage(3232,$this->monthly_limit[3232]);
            if($status==1){
                $this->_insert_usage_log(3232, $this->monthly_limit[3232]);


                $update_data = array();
                //$update_data['n_credits'] = $package[3232];
                $this->db->set('n_credits', 'n_credits+'.$this->monthly_limit[3232], FALSE);
                $this->basic->update_data("users", array('id' => $this->bot_data['user_id']), $update_data);
            }

        }

        $user_info = $this->basic->get_data('users', ['where' => ['id' => $this->bot_data['user_id']]]);
        $return_get_credits = $user_info[0]['n_credits'];
    }
}


