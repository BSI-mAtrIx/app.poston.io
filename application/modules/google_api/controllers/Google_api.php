<?php
/*
Addon Name: Google API
Unique Name: google_api
Project ID: 149
Addon URI: https://marketplace.bcheckin.com
Author: Mike TMD
Author URI: https://bcheckin.com
Version: 1.0.1
Description:
*/

require_once("application/controllers/Home.php");

class Google_api extends Home {

    public function index()
    {
       
       //$this->dashboard();
       redirect('/google_api/google_sheet_integrations', 'location');
    }
    
    
    public function google_sheet_integrations()
    {
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');

        $this->member_validity();

        $data['body'] = 'google_sheet_integrations';
        $data['page_title'] = $this->lang->line("Google Sheet Integrations");
        $this->_viewcontroller($data);
    }
    
    
    public function activate()
    {
        
        $this->ajax_check();
        
        unlink(FCPATH."application/modules/google_api/install.txt");
        
        $menu_exists = $this->db->query(" SELECT id FROM `menu` where url LIKE '%google_api%' ")->row_array();
        if(!$menu_exists){
            try{
                $sql = "INSERT INTO `menu` (`name`, `icon`, `url`, `serial`, `module_access`, `have_child`, `only_admin`, `only_member`, `add_ons_id`, `is_external`, `header_text`)
                VALUES ('Google Api', 'fab fa-google', 'google_api', 50, '', '0', '0', '0', 0, '0', '');" ;
                $this->db->query($sql);
            }catch(Exception $e){

            }
        }
        
        echo json_encode(array('status'=>'1','message'=>$this->lang->line('Add-on has been activated successfully.')));exit();
        
    }
    
    public function deactivate()
    {
        
        $this->ajax_check();
        $addon_controller_name=ucfirst($this->router->fetch_class());
        $install_txt_path=APPPATH."modules/".strtolower($addon_controller_name)."/install.txt";
        if(!file_exists($install_txt_path)) // putting install.txt
        fopen($install_txt_path, "w");
        
        $menu = $this->db->query(" SELECT id FROM `menu` where url LIKE '%google_api%' ")->row_array();
        if($menu){
                $menu_id = $menu['id'];
                $this->db->query(" DELETE FROM `menu` WHERE `menu`.`id` = $menu_id ");   
        }
            
        echo json_encode(array('status'=>'1','message'=>$this->lang->line('Add-on has been deactivated successfully.')));exit();
        
    }
    
    
    public function delete(){
        
        
        // Delete Menu in SQL
        $menu = $this->db->query(" SELECT id FROM `menu` where url LIKE '%google_api%' ")->row_array();
        if($menu){
                $menu_id = $menu['id'];
                $this->db->query(" DELETE FROM `menu` WHERE `menu`.`id` = $menu_id ");   
        }
            
        // Delete Add-on folder
        $addon_controller_name = 'google_api';
        $addon_path = APPPATH."modules/".$addon_controller_name;
        $this->delete_directory($addon_path);
        
        echo json_encode(array('status'=>'1','message'=>$this->lang->line('add-on has been deleted successfully.')));  exit();  
        
    }
    
    
    public function get_user_pages_ext(){

        //$this->ajax_check();
        $user_id  =  $this->session->userdata('user_id');
        
        echo json_encode($this->get_user_pages($user_id));
        
    }
    
    public function get_user_pages($user_id){
        $table_type = 'facebook_rx_fb_page_info';
        $where_type['where'] = array('user_id'=>$user_id,"bot_enabled"=>"1");
        $info_type = $this->basic->get_data($table_type,$where_type);
        return $info_type;
    }
    
    
  public function campaign_list_data()
  { 
    $this->ajax_check();
    $searching = $this->input->post('searching',true);
    $display_columns = array("#","id","flow_name","page_name","actions");

    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 2;
    $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'flow_name';
    $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'asc';
    $order_by=$sort." ".$order;

    $where_simple = array();
    $where_simple['user_input_flow_campaign.user_id'] = $this->user_id;

    $sql = '';
    if($searching != '') $where_simple['flow_name LIKE'] = "%".$searching."%";

    $where = array("where"=> $where_simple);
    $table="user_input_flow_campaign";
    $join = ['facebook_rx_fb_page_info'=>'user_input_flow_campaign.page_table_id=facebook_rx_fb_page_info.id,left'];
    $select = ['user_input_flow_campaign.*','page_name'];
    $info = $this->basic->get_data($table,$where,$select,$join,$limit,$start,$order_by,$group_by='');

    $total_rows_array=$this->basic->count_row($table,$where,$count=$table.".id",$join,$group_by='');
    $total_result=$total_rows_array[0]['total_rows'];
    
    $user_id = $this->session->userdata("user_id");
    
    $user_password = $this->db->select('password')
        ->get_where('users', array('id' => $user_id))
        ->row()->password;
	        		
    for($i=0;$i<count($info);$i++) 
    {
      $info[$i]['flow_name'] = $info[$i]['flow_name'];
      $info[$i]['page_name'] = $info[$i]['page_name'];
      $info[$i]['actions'] = "<i class='fas fa-mouse-pointer'></i> <button class='btn btn-primary btn-sm' onclick='copy_custom_field(flow_id_". $info[$i]['id'] .")' >Copy URL &amp; Start</button> <input id='flow_id_". $info[$i]['id'] ."' tyle='text' style='width: 20px; opacity: 0.0;' value='=IMPORTDATA(".'"'.base_url()."google_api/get_all_custom_field?x=". $info[$i]['id'] ."&y=".$this->session->userdata("user_id")."&z=".md5($info[$i]['id'].$user_password)."".'"'.")'>";
    }

    $data['draw'] = (int)$_POST['draw'] + 1;
    $data['recordsTotal'] = $total_result;
    $data['recordsFiltered'] = $total_result;
    $data['data'] = convertDataTableResult($info, $display_columns ,$start,$primary_key="user_input_flow_campaign.id");

    echo json_encode($data);
  }
  


  // Get All Custom Field Input by Flow_ID, Page_ID, Password & User_ID
  public function get_all_custom_field() {

        $flow_id = $this->input->get('x');
        if(!$flow_id){
            $response="Missing Flow ID";
            echo json_encode($response);
            exit;
        }
        
        if (!$this->input->get('limit')) {$limit = "50";} else { $limit = $this->input->get('limit'); };
        
        $user_id = $this->input->get('y');
        if(!$user_id){
            $response="Missing User ID";
            echo json_encode($response);
            exit;
        }

        
        $user_password = $this->db->select('password')
	        		->get_where('users', array('id' => $user_id))
	        		->row()->password;
	        		
     
        
        $key_id = $this->input->get('z');
        if(!$key_id){
            $response="Missing Key Number";
            echo json_encode($response);
            exit;
        }

        $md5_key_input = $this->input->get('z');
        
        $md5_private_key=md5($flow_id.$user_password);
        
        if( $md5_key_input == NULL OR $md5_key_input != $md5_private_key ){
            $response="Wrong Key field";
            echo json_encode($response);
            exit;
        }


        $page_table_info = $this->basic->get_data('user_input_flow_campaign',['where'=>['user_input_flow_campaign.id'=>$flow_id,'user_input_flow_campaign.user_id'=>$user_id]],['page_id'],['facebook_rx_fb_page_info'=>'user_input_flow_campaign.page_table_id=facebook_rx_fb_page_info.id,left']);
        $fb_page_id = isset($page_table_info[0]['page_id']) ? $page_table_info[0]['page_id'] : 0;


        $where = [
          'where' => [
            'user_input_flow_questions_answer.flow_campaign_id' => $flow_id,
            'user_input_flow_questions_answer.page_id' => $fb_page_id,
            'messenger_bot_subscriber.page_id' => $fb_page_id,
          ],
        ];

        $join = [
          'messenger_bot_subscriber' => 'messenger_bot_subscriber.subscribe_id = user_input_flow_questions_answer.subscriber_id, left',
        ];

        $select = [
          'user_input_flow_questions_answer.subscriber_id',
          'user_input_flow_questions_answer.user_answer',
          'user_input_flow_questions_answer.question_id',
          'messenger_bot_subscriber.first_name',
          'messenger_bot_subscriber.last_name',
        ];

        $order_by = 'user_input_flow_questions_answer.flow_campaign_id asc,user_input_flow_questions_answer.subscriber_id asc,user_input_flow_questions_answer.answer_time asc';

        $data = $this->basic->get_data('user_input_flow_questions_answer', $where, $select, $join, $limit='', $start=NULL, $order_by);

        $new_data = [];
        foreach($data as $value)
        {
          $new_data[$value['subscriber_id']]['first_name'] = $value['first_name'];
          $new_data[$value['subscriber_id']]['last_name'] = $value['last_name'];
          $new_data[$value['subscriber_id']]['question'][$value['question_id']] = $value['user_answer'];
        }


        // Exits displaying error if there is no data to be exported
        if (! count($data) > 0) {
          echo json_encode('No Data');
          exit;
        }

        // Sets the csv file name
        $filename = 'flowdata_' . time() . '.csv';

        $question_info = $this->basic->get_data('user_input_flow_campaign',['where'=>['user_input_flow_campaign.id'=>$flow_id,'user_input_flow_campaign.user_id'=>$user_id]],['flow_name','question','user_input_flow_questions.id as question_id'],['user_input_flow_questions'=>'user_input_flow_campaign.id=user_input_flow_questions.flow_campaign_id,left'],'',NULL,'serial_no asc');

        // Prepares headers for csv file
        $csv_headers = [
          'Subscriber ID',
          'First Name',
          'Last Name',
        ];

        $question_table_ids = [];

        foreach($question_info as $value)
        {
          array_push($csv_headers, $value['question']);
          array_push($question_table_ids, $value['question_id']);
        }


        // Writes into output buffer using php output stream
        $fp = fopen('php://output', 'w');

        if ($fp) {
          // Sets headers for making csv file downloadable
                header('Expires: 0');
                header('Pragma: no-cache');
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                
                // Puts headers into csv file
                fputcsv($fp, $csv_headers);

                // Preapares values for csv file
          foreach ($new_data as $key => $values) {
            $csv_values = [];
            $csv_values[] = $key;
            $csv_values[] = $values['first_name'];
            $csv_values[] = $values['last_name'];
            foreach($question_table_ids as $single_question)
            {
              if(isset($values['question'][$single_question]))
                $csv_values[] = $values['question'][$single_question];
              else
                $csv_values[] = '';
            }
            // Puts values into csv file
            fputcsv($fp, $csv_values);
          }
        }

        // Closes the file pointer
        fclose($fp);


      }
      
      
    
    
    
    // Get All Orders by Store ID & User_ID
    public function get_all_order_demo() {        
          
          $store_id = 700;
          $limit = 10;
          $select="ecommerce_cart.id as order_id,subscriber_id,buyer_first_name,buyer_last_name,buyer_email,buyer_mobile,buyer_country,buyer_city,buyer_state,buyer_address,buyer_zip,coupon_code,coupon_type,discount,payment_amount,currency,ordered_at,transaction_id,card_ending,payment_method,manual_additional_info,paid_at,ecommerce_cart.status as payment_status";
          $where['where']['store_id']= $store_id;
          $packages= $this->basic->get_data("ecommerce_cart",$where,$select,"",$limit,"","id asc");
            
          if( $packages == NULL ){
                $response['status']='error';
                $response['message']="You do not have any Orders";
                echo json_encode($response);
                exit;
          }
            
          $response=json_encode($packages);
          echo $response;
            
    }
  
    // Get All Subscriber by Pages ID & User_ID
    public function get_all_subscriber() {

        $page_id = $this->input->get('x');
        if(!$page_id){
            $response['status']='error';
            $response['message']="Missing Pages ID";
            echo json_encode($response);
            exit;
        }
        
        if (!$this->input->get('limit')) {$limit = "50";} else { $limit = $this->input->get('limit'); };
        
        $user_id = $this->input->get('y');
        if(!$user_id){
            $response['status']='error';
            $response['message']="Missing User ID";
            echo json_encode($response);
            exit;
        }

        
        $user_password = $this->db->select('password')
	        		->get_where('users', array('id' => $user_id))
	        		->row()->password;
	        		
     
        
        $key_id = $this->input->get('z');
        if(!$key_id){
            $response['status']='error';
            $response['message']="Missing Key Number";
            echo json_encode($response);
            exit;
        }

        $md5_key_input = $this->input->get('z');
        
        $md5_private_key=md5($page_id.$user_password);
        
        if( $md5_key_input == NULL OR $md5_key_input != $md5_private_key ){
            $response['status']='error';
            $response['message']="Wrong Key field";
            echo json_encode($response);
            exit;
        }
        
        $select="page_id,subscribe_id,first_name,last_name,gender,email,phone_number,user_location,subscribed_at,last_subscriber_interaction_time";
        $where['where']['page_id']=$page_id;
        $packages= $this->basic->get_data("messenger_bot_subscriber",$where,$select,"",$limit,"","subscribed_at DESC");

        if( $packages == NULL ){
            $response['status']='error';
            $response['message']="You do not have any subscribers";
            echo json_encode($response);
            exit;
        }
        
        $response=json_encode($packages);
        echo $response;
    }
    
    


}    









