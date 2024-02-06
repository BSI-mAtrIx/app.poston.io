<?php
/*
Addon Name: Email Phone Opt-in Form Builder
Unique Name: email_optin_form_builder

Modules:
{
   "290":{
      "bulk_limit_enabled":"0",
      "limit_enabled":"1",
      "extra_text":"",
      "module_name":"Email Phone Opt-in Form Builder"
   }
}
Project ID: 47
Addon URI: https://xerochat.com
Author: Xerone IT
Author URI: http://xeroneit.net
Version: 1.5
Description: 
*/

require_once("application/controllers/Home.php"); // loading home controller

class Email_optin_form_builder extends Home
{
  public $addon_data=array();

  	public function __construct() 
  	{
      	parent::__construct();

		$function_name=$this->uri->segment(2);
		if($function_name!="webview" && $function_name!="form_submit" && $function_name != "email_optin_link.js" && $function_name != "direct_email_optin_form" && $function_name != "submit_optin_form_data" && $function_name != "send_confirmation_mail" && $function_name != "confim_optin" && $function_name != "confirm_optin_action") 
		{
			if ($this->session->userdata('logged_in')!= 1) redirect('home/login', 'location');         
		}

		// if(file_exists(APPPATH.'modules/'.strtolower($this->router->fetch_class()).'/config/messenger_bot_enhancers_config.php'))
		// $this->load->config("messenger_bot_enhancers_config");

		// getting addon information in array and storing to public variable
		// addon_name,unique_name,module_id,addon_uri,author,author_uri,version,description,controller_name,installed
		//------------------------------------------------------------------------------------------
		$addon_path=APPPATH."modules/".strtolower($this->router->fetch_class())."/controllers/".ucfirst($this->router->fetch_class()).".php"; // path of addon controller
		$addondata=$this->get_addon_data($addon_path); 
		$this->member_validity();
		$this->addon_data=$addondata;
    }


	public function index()
	{
	    if($this->session->userdata('user_type') != 'Admin' && !in_array(290,$this->module_access)) {
	    	redirect('home/login_page', 'location');
	    }

	    $data['body'] = 'form_lists';
	    $data['page_title'] = $this->lang->line('Email Phone Opt-in Form Builder');
	    $this->_viewcontroller($data);  
	}

    public function form_lists_data()
    {           
        if($this->session->userdata('user_type') != 'Admin' && !in_array(290,$this->module_access))  exit();
        $this->ajax_check();

        $search_value = isset($_POST['search']) ? $_POST['search']['value'] : null;
        $display_columns = ['id','form_name', 'form_position','interval_time', 'actions', 'contact_group','inserted_at'];
        $search_columns = ['form_name','form_position'];

        $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $limit = isset($_POST['length']) ? intval($_POST['length']) : 10;

        $sort_index = isset($_POST['order'][0]['column']) ? strval($_POST['order'][0]['column']) : 1;
        $sort = isset($display_columns[$sort_index]) ? $display_columns[$sort_index] : 'email_optin.id';
        $order = isset($_POST['order'][0]['dir']) ? strval($_POST['order'][0]['dir']) : 'DESC';
        $order_by = $sort . " " . $order;

        $where_custom = '';
        $where_custom = "user_id = ".$this->user_id;

        if ($search_value != '') 
        {
            foreach ($search_columns as $key => $value) 
            $temp[] = $value." LIKE "."'%$search_value%'";
            $imp = implode(" OR ", $temp);
            $where_custom .=" AND (".$imp.") ";
        }
            
        $table = 'email_optin';

        $group_by = 'canonical_id';
        $this->db->where($where_custom);
        $info = $this->basic->get_data($table, $where='', $select='', $join='', $limit, $start, $order_by, $group_by);

        $this->db->where($where_custom);
        $total_rows_array = $this->basic->count_row($table, $where='', $count = 'id', $join='', $group_by);
        $total_result = $total_rows_array[0]['total_rows'];

        for ($i = 0; $i < sizeof($info); $i++) {

        	$form_display_type = $info[$i]['form_position'];

		    // $info[$i]['embeded_code']='<a form_type="'.$info[$i]['form_position'].'"  embed_id="'.$info[$i]['canonical_id'].'" class="badge badge-status get_js_embed" title="'.$this->lang->line('Get Embed Code').'" style="cursor: pointer;"><i class="fas fa-code"></i> '.$this->lang->line('Js Code').'</a>';
        	if ($info[$i]['form_name']) {
        		$info[$i]['form_name'] = $this->truncate_str($info[$i]['form_name']);
        	}

            if ($info[$i]['inserted_at']) {
                $info[$i]['inserted_at'] = date('M j, Y H:i A', strtotime($info[$i]['inserted_at']));
            }

            if ($info[$i]['interval_time']) {
                $info[$i]['interval_time'] = ($this->truncate_str($info[$i]['interval_time'])/1000).' sec';
            }

            if($form_display_type == 'right') {
            	$info[$i]['form_position'] = '<div style="min-width:130px">Pop-up: Bottom-right</div>';
            } else if($form_display_type == 'center') {
            	$info[$i]['form_position'] = 'Pop-up: Center';
            } else {
            	$info[$i]['form_position'] = ucfirst($info[$i]['form_position']);
            }

            $groupids = $info[$i]['contact_group'];
            $type_id = explode(",",$groupids);

            $group_table = 'sms_email_contact_group';
            $select = array('type');

            $where_group['where_in'] = array('id'=>$type_id);
            $where_group['where'] = array('deleted'=>'0');

            $info1 = $this->basic->get_data($group_table,$where_group,$select);

            $str = '';
            foreach ($info1 as  $value1)
            {
                $str.= $value1['type'].", ";
            }

            $str = trim($str, ", ");

            $info[$i]['contact_group'] = $str;

            $actions = '<div style="min-width:180px;"><a data-toggle="tooltip" title="' . $this->lang->line('View form') . '" form_type="'.$form_display_type.'"  embed_id="'.$info[$i]['canonical_id'].'" class="btn btn-circle btn-outline-dark get_js_embed" title="'.$this->lang->line('Get Embed Code').'" style="cursor: pointer;"><i class="fas fa-code"></i></a>&nbsp;';

            $actions .= '<a data-toggle="tooltip" title="' . $this->lang->line('View form') . '" href="' . base_url("email_optin_form_builder/email_optin_form/{$info[$i]['canonical_id']}") . '" class="btn btn-circle btn-outline-primary" target="_blank"><i class="fas fa-eye"></i></a>&nbsp;';
            $actions .= '<a data-toggle="tooltip" title="' . $this->lang->line('Edit form') . '" href="' . base_url("email_optin_form_builder/edit_email_optin/{$info[$i]['canonical_id']}") . '" class="btn btn-circle btn-outline-warning"><i class="fa fa-edit"></i></a>&nbsp;';
            $actions .= '<a data-toggle="tooltip" title="' . $this->lang->line('Delete form') . '" href="" class="btn btn-circle btn-outline-danger" id="delete-optin-form" data-form-id="'. $info[$i]['canonical_id'] . '"><i class="fas fa-trash-alt"></i></a></div>';
            $actions .= "<script>$('[data-toggle=\"tooltip\"]').tooltip();</script>";
            $info[$i]['actions'] = $actions;
        }

        $data['draw'] = isset($_POST['draw']) ? (int) $_POST['draw'] + 1 : 0;
        $data['recordsTotal'] = $total_result;
        $data['recordsFiltered'] = $total_result;
        $data['data'] = $info;

        echo json_encode($data);
    }

	public function create_email_optin_form() 
	{
		if($this->session->userdata('user_type') != 'Admin' && !in_array(290,$this->module_access))  redirect('home/login_page', 'location');

		$data = [];
		$table = 'sms_email_contact_group';
		$where['where'] = array('user_id'=>$this->user_id);

		$info = $this->basic->get_data($table,$where);
		
		$phonecodes = $this->get_country_iso_phone_currecncy('phonecode');
		$country = $this->get_country_iso_phone_currecncy('country');
		$formatted_country_codes = array();

		foreach ($country as $key1 => $value1) {
			$country_name = $value1;

			foreach ($phonecodes as $key2 => $value2) {
				if($key1 == $key2) $formatted_country_codes[$key2.'-'.$value2] = $country_name.' ('.$value2.')';
			}
		}

		$data['formatted_country_codes'] = $formatted_country_codes;

		foreach ($info as $key => $value) 
		{
		    $result = $value['id'];
		    $data['contact_group_lists'][$result] = $value['type'];
		}

		$data['sequence_sms_campaign_lists'] = $this->basic->get_data("messenger_bot_drip_campaign",["where"=>["campaign_type"=>"sms","user_id"=>$this->user_id]]);
		$data['sequence_email_campaign_lists'] = $this->basic->get_data("messenger_bot_drip_campaign",["where"=>["campaign_type"=>"email","user_id"=>$this->user_id]]);

		$where_simple = array();
		$temp_userid = $this->user_id;

		/***get sms config***/
		$apiAccess = $this->config->item('sms_api_access');
		if($this->config->item('sms_api_access') == "") $apiAccess = "0";

		if(isset($apiAccess) && $apiAccess == '1' && $this->session->userdata("user_type") == 'Member')
		{
		    $join = array('users' => 'sms_api_config.user_id=users.id,left');
		    $select = array('sms_api_config.*','users.id AS usersId','users.user_type');
		    $where_in = array('sms_api_config.user_id'=>array('1',$temp_userid),'users.user_type'=>array('Admin','Member'));
		    $where = array('where'=> array('sms_api_config.status'=>'1'),'where_in'=>$where_in);
		    $sms_api_config=$this->basic->get_data('sms_api_config', $where, $select, $join, $limit='', $start='', $order_by='phone_number ASC', $group_by='', $num_rows=0);
		} else
		{
		    $where = array("where" => array('user_id'=>$temp_userid,'status'=>'1'));
		    $sms_api_config=$this->basic->get_data('sms_api_config', $where, $select='', $join='', $limit='', $start='', $order_by='phone_number ASC', $group_by='', $num_rows=0);
		}

		$sms_api_config_option=array();
		foreach ($sms_api_config as &$info) {

		    $info['gateway_name'] = ($info['gateway_name'] == 'custom') ? $this->lang->line('Custom API')." : ".$info['custom_name'] : $info['gateway_name'];
		    
		    $id=$info['id'];

		    if($info['phone_number'] !="")
		        $sms_api_config_option[$id]=$info['gateway_name'].": ".$info['phone_number'];
		    else
		        $sms_api_config_option[$id]=$info['gateway_name'];

		}
		unset($info);



		$email_api_access = $this->config->item('email_api_access');
		if($this->config->item('email_api_access') == '') $email_api_access = '0';

		if($email_api_access == '1' && $this->session->userdata("user_type") == 'Member')
		{                                                            
		    /***get smtp  option***/
		    $join = array('users'=>'email_smtp_config.user_id=users.id,left');
		    $select = array('email_smtp_config.*','users.id AS usersID','users.user_type');
		    $where_in = array('email_smtp_config.user_id'=>array('1',$this->user_id),'users.user_type'=>array('Admin','Member'));
		    $where = array('where'=> array('email_smtp_config.status'=>'1'),'where_in'=>$where_in);
		    $smtp_info=$this->basic->get_data('email_smtp_config', $where, $select, $join, $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
		    
		    $smtp_option=array();
		    foreach ($smtp_info as $info) {
		        $id="smtp_".$info['id'];
		        $smtp_option[$id]="SMTP: ".$info['email_address'];
		    }
		    
		    /***get mandrill option***/
		    $join = array('users'=>'email_mandrill_config.user_id=users.id,left');
		    $select = array('email_mandrill_config.*','users.id AS usersID','users.user_type');
		    $where_in = array('email_mandrill_config.user_id'=>array('1',$this->user_id),'users.user_type'=>array('Admin','Member'));
		    $where = array('where'=> array('email_mandrill_config.status'=>'1'),'where_in'=>$where_in);
		    $smtp_info=$this->basic->get_data('email_mandrill_config', $where, $select, $join, $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
		    
		    foreach ($smtp_info as $info) {
		        $id="mandrill_".$info['id'];
		        $smtp_option[$id]="Mandrill: ".$info['email_address'];
		    }

		    /***get sendgrid option***/
		    $join = array('users'=>'email_sendgrid_config.user_id=users.id,left');
		    $select = array('email_sendgrid_config.*','users.id AS usersID','users.user_type');
		    $where_in = array('email_sendgrid_config.user_id'=>array('1',$this->user_id),'users.user_type'=>array('Admin','Member'));
		    $where = array('where'=> array('email_sendgrid_config.status'=>'1'),'where_in'=>$where_in);
		    $smtp_info=$this->basic->get_data('email_sendgrid_config', $where, $select, $join, $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
		    
		    foreach ($smtp_info as $info) {
		        $id="sendgrid_".$info['id'];
		        $smtp_option[$id]="SendGrid: ".$info['email_address'];
		    }

		    /***get mailgun option***/
		    $join = array('users'=>'email_mailgun_config.user_id=users.id,left');
		    $select = array('email_mailgun_config.*','users.id AS usersID','users.user_type');
		    $where_in = array('email_mailgun_config.user_id'=>array('1',$this->user_id),'users.user_type'=>array('Admin','Member'));
		    $where = array('where'=> array('email_mailgun_config.status'=>'1'),'where_in'=>$where_in);
		    $smtp_info=$this->basic->get_data('email_mailgun_config', $where, $select, $join, $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
		    
		    foreach ($smtp_info as $info) {
		        $id="mailgun_".$info['id'];
		        $smtp_option[$id]="Mailgun: ".$info['email_address'];
		    }

		} else
		{
		    /***get smtp  option***/
		    $where=array("where"=>array('user_id'=>$this->user_id,'status'=>'1'));
		    $smtp_info=$this->basic->get_data('email_smtp_config', $where, $select='', $join='', $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
		    
		    $smtp_option=array();
		    foreach ($smtp_info as $info) {
		        $id="smtp_".$info['id'];
		        $smtp_option[$id]="SMTP: ".$info['email_address'];
		    }
		    
		    /***get mandrill option***/
		    $where=array("where"=>array('user_id'=>$this->user_id,'status'=>'1'));
		    $smtp_info=$this->basic->get_data('email_mandrill_config', $where, $select='', $join='', $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
		    
		    foreach ($smtp_info as $info) {
		        $id="mandrill_".$info['id'];
		        $smtp_option[$id]="Mandrill: ".$info['email_address'];
		    }

		    /***get sendgrid option***/
		    $where=array("where"=>array('user_id'=>$this->user_id,'status'=>'1'));
		    $smtp_info=$this->basic->get_data('email_sendgrid_config', $where, $select='', $join='', $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
		    
		    foreach ($smtp_info as $info) {
		        $id="sendgrid_".$info['id'];
		        $smtp_option[$id]="SendGrid: ".$info['email_address'];
		    }

		    /***get mailgun option***/
		    $where=array("where"=>array('user_id'=>$this->user_id,'status'=>'1'));
		    $smtp_info=$this->basic->get_data('email_mailgun_config', $where, $select='', $join='', $limit='', $start='', $order_by='email_address ASC', $group_by='', $num_rows=0);
		    
		    foreach ($smtp_info as $info) {
		        $id="mailgun_".$info['id'];
		        $smtp_option[$id]="Mailgun: ".$info['email_address'];
		    }
		}

		$data['email_option'] = $smtp_option;
		$data['sms_option'] = $sms_api_config_option;

        $data['user_id'] = $this->user_id;
        $data['body'] = "optin_form_view";
        $data['page_title'] = $this->lang->line("Create Opt-in Form");
        $this->_viewcontroller($data);   
	}


	public function add_contact_group_action()
	{
	    if($this->session->userdata('user_type') != 'Admin' && count(array_intersect($this->module_access, array('263','264')))==0) exit;

	    $this->ajax_check();
	    $group_name = trim(strip_tags($this->input->post("group_name",true)));
	    $in_data = array(
	        'user_id' => $this->user_id,
	        'type' => $group_name,
	        'created_at' => date("Y-m-d H:i:s")
	    );

	    $is_exists = $this->basic->get_data("sms_email_contact_group",['where'=>["user_id"=>$this->user_id,"type"=>$group_name]]);

	    if(isset($is_exists[0]))
	    {
	        $insert_id = $is_exists[0]['id'];
	        $group_name = $is_exists[0]['type'];

	    } else {

	    	$this->basic->insert_data("sms_email_contact_group", $in_data);
	    	$insert_id = $this->db->insert_id();   
	    }

	    echo json_encode(array('id'=>$insert_id,"text"=>$group_name));
	}
   

	public function save_form_data() 
	{
		// Kicks out if not an AJAX request
		// if($this->session->userdata('user_type') != 'Admin' && !in_array(261,$this->module_access))  exit();

		if($this->session->userdata('user_type') != 'Admin' && !in_array(290,$this->module_access)) {
			exit;
		}

		if (! $this->input->is_ajax_request()) {
			$message = $this->lang->line('Bad Request');
			return $this->customJsonResponse($message);
		}
		if(!empty($this->input->post('contact_group')))
		{
			$contact_group=implode(",", $this->input->post('contact_group'));
		}
		
		else
		{
			$this->form_validation->set_rules('contact_group', $this->lang->line('Contact'), 'required');
		}
		// Sets validation rules
		$this->form_validation->set_rules('user_id', $this->lang->line('User ID'), 'required|alpha_numeric');
		$this->form_validation->set_rules('form_name', $this->lang->line('Form name'), 'trim|required');
		$this->form_validation->set_rules('sequence_email_campaign_id', $this->lang->line('Email Sequence'), 'numeric');
		$this->form_validation->set_rules('sequence_sms_campaign_id', $this->lang->line('SMS Sequence'), 'numeric');
		$this->form_validation->set_rules('form_position', $this->lang->line('Form Display Type'), 'required');

		if($this->input->post("form_position") == "popup") {
			$this->form_validation->set_rules('popup_type', $this->lang->line('Pop-up Position'), 'trim|required');
		}

		$this->form_validation->set_rules('response_type', $this->lang->line('Response Type'), 'trim|required');

		if($this->input->post("response_type") == "success_message_type") {
			$this->form_validation->set_rules('success_message', $this->lang->line('Success Message'), 'required|trim');
		}

		if($this->input->post("response_type") == "redirect_url_type") {
			$this->form_validation->set_rules('redirect_url', $this->lang->line('Redirect URL'), 'required');			
		}

		$this->form_validation->set_rules('enable_country_code', $this->lang->line('Enable Country Code'), 'trim');
		$this->form_validation->set_rules('is_double_optin', $this->lang->line('Enable Double Optin'), 'trim');
		$this->form_validation->set_rules('country_code_for_phone', $this->lang->line('Country Code For Phone'), 'trim');
		$this->form_validation->set_rules('interval_time', $this->lang->line('Pop-up Delay'), 'required|numeric');
		$this->form_validation->set_rules('form_data', $this->lang->line('Form data'), 'required|min_length[230]|max_length[5000]');

		// Checks whether data are valid
		if (false === $this->form_validation->run()) {
			$message = '';
			if ($this->form_validation->error('user_id')) {
				$message = $this->form_validation->error('user_id');
			} elseif ($this->form_validation->error('form_name')) {
				$message = $this->form_validation->error('form_name');
			} elseif ($this->form_validation->error('contact_group')) {
				$message = $this->form_validation->error('contact_group');
			}elseif ($this->form_validation->error('form_position')) {
				$message = $this->form_validation->error('form_position');
			}elseif ($this->form_validation->error('popup_type')) {
				$message = $this->form_validation->error('popup_type');
			}elseif ($this->form_validation->error('form_data')) {
				$message = $this->form_validation->error('form_data');
			}elseif ($this->form_validation->error('response_type')) {
				$message = $this->form_validation->error('response_type');
			}elseif ($this->form_validation->error('success_message')) {
				$message = $this->form_validation->error('success_message');
			}elseif ($this->form_validation->error('redirect_url')) {
				$message = $this->form_validation->error('redirect_url');
			}elseif ($this->form_validation->error('interval_time')) {
				$message = $this->form_validation->error('interval_time');
			}elseif ($this->form_validation->error('country_code_for_phone')) {
				$message = $this->form_validation->error('country_code_for_phone');
			}

			return $this->customJsonResponse(strip_tags($message));
		}

		// Extracts vars
		$user_id = $this->input->post('user_id');
		$form_name = strip_tags($this->input->post('form_name'));
		$contact_group = $contact_group;
		$sequence_email_campaign_id = (int) $this->input->post('sequence_email_campaign_id');
		$sequence_sms_campaign_id = (int) $this->input->post('sequence_sms_campaign_id');
		$form_position = (string) $this->input->post('form_position');
		$response_type = strip_tags(trim($this->input->post("response_type",true)));
		$success_message = strip_tags(trim($this->input->post("success_message",true)));
		$redirect_url = strip_tags(trim($this->input->post("redirect_url",true)));
		$popup_type = trim($this->input->post("popup_type",true));
		$form_data = $this->input->post('form_data');
		$interval_time = $this->input->post('interval_time');
		$success_message = str_replace(["'",'"'],"`", $success_message);
		$is_double_optin = $this->input->post("is_double_optin",true);

		$attachement = $this->session->userdata("attachment_file_path_name_scheduler");
		$image_link = $this->session->userdata("attachment_filename_scheduler");

		$enable_country_code = $this->input->post('enable_country_code');
		$country_code_for_phone = $this->input->post('country_code_for_phone',true);

		if($enable_country_code == '') $enable_country_code = '0';
		if($is_double_optin == '') $is_double_optin = '0';

		if ($user_id !== md5($this->user_id)) {
			$message = $this->lang->line('Bad request');
			return $this->customJsonResponse($message);
		}

		// Checks if the JSON data is valid
		$valid_form_data = $this->validate_and_strip_tags_json_form_data($form_data);
		if (false === $valid_form_data) {
			$message = $this->lang->line('Invalid JSON data provided');
			return $this->customJsonResponse($message);
		}

		// Checks if there is a button tag in form data
		if (false === $this->checks_button_tag_in_json_form_data($valid_form_data)) {
			$message = $this->lang->line('You forgot to choose a button field');
			return $this->customJsonResponse($message);
		}

		$uri_canonical_id = $this->input->post('uri_canonical_id');
		$real_canonical_id = $this->input->post('real_canonical_id');
		$data = $this->session->userdata('edit_webview_form_data');

		if (($uri_canonical_id && ! $real_canonical_id) 
			|| ($real_canonical_id && ! $uri_canonical_id)
			|| ('' === $uri_canonical_id && '' === $real_canonical_id)
		) {
			$message = $this->lang->line('Bad request');
			return $this->customJsonResponse($message); 
		}

		// Tries update webview form data
		if ($uri_canonical_id && $real_canonical_id) {
			$session_canonical_id = (is_array($data) && isset($data['canonical_id'])) ? md5($data['canonical_id']) : null;
			if (($uri_canonical_id != $session_canonical_id)
				|| ($real_canonical_id != $session_canonical_id)
			) {
				$message = $this->lang->line('Bad request');
				return $this->customJsonResponse($message); 
			}

			$form_id = (is_array($data) && isset($data['form_id'])) ? $data['form_id'] : null;
			$where = [
				'id' => $form_id,
			];

			/* Getting the existing attachment if available */
			$existed_attachment   = $this->basic->get_data("email_optin", array('where'=>array('id'=>$form_id,'user_id'=>$this->user_id)),array('image_link'));
			// remove old attachment from upload/attachment directory
			if((isset($attachement) && $attachement != '') && (isset($image_link) && $image_link != '')) {
			    if(isset($existed_attachment[0]['image_link']) && !empty($existed_attachment[0]['image_link'])) {
			        $file = FCPATH."upload/email_optin_bg_image/".$existed_attachment[0]['image_link'];
			        if(file_exists($file))
			        {
			            unlink($file);
			        }
			    } 
			}

			$this->session->unset_userdata("attachment_file_path_name_scheduler");
			$this->session->unset_userdata("attachment_filename_scheduler");

			if($image_link == "") {
			    $image_link = $existed_attachment[0]['image_link'];
			}

			if($form_position === "popup") {
				$form_position = $popup_type;
				$interval_time = $interval_time;
			} else {
				$interval_time = "0";
			}

			if($response_type === "success_message_type") {
				$success_message = $success_message;
				$redirect_url = "";
			}

			if($response_type === "redirect_url_type") {
				$redirect_url = $redirect_url;
				$success_message = "";
			}


			$data = [
				'form_name' => $form_name,
				'contact_group' => $contact_group,
				'sequence_email_campaign_id' => $sequence_email_campaign_id,
				'sequence_sms_campaign_id' => $sequence_sms_campaign_id,
				'form_position' => $form_position,
				'response_type' => $response_type,
				'success_message' => isset($success_message) ? $success_message:"",
				'redirect_url' => isset($redirect_url) ? $redirect_url:"",
				'image_link'=> isset($image_link) ? $image_link : "",
				'interval_time'=>$interval_time,
				'enable_country_code'=> $enable_country_code,
				'is_double_optin'=> $is_double_optin,
				'country_code_for_phone'=>isset($country_code_for_phone) ? $country_code_for_phone:"",
				'form_data' => json_encode($valid_form_data),
				'updated_at' => date('Y-m-d H:i:s'),
			];

			return $this->update_form_data('email_optin', $where, $data);
		} 

		if ((null === $uri_canonical_id) && (null === $real_canonical_id)) {
			// Generates canonical id for form if from form title
			$canonical_id = $this->generate_canonical_id($form_name);
			if (empty($canonical_id)) {
				$message = $this->lang->line('Something went wrong! Please try again later');
				return $this->customJsonResponse($message);
			}

			if($form_position === "popup") {
				$form_position = $popup_type;
				$interval_time = $interval_time;
			} else {
				$interval_time = "0";
			}

			if($response_type === "success_message_type") {
				$success_message = $success_message;
				$redirect_url = "";
			}

			if($response_type === "redirect_url_type") {
				$redirect_url = $redirect_url;
				$success_message = "";
			}

			$data = [
				'canonical_id' => $canonical_id,
				'user_id' => $this->user_id,
				'form_name' => $form_name,
				'contact_group' => $contact_group,
				'sequence_email_campaign_id' => $sequence_email_campaign_id,
				'sequence_sms_campaign_id' => $sequence_sms_campaign_id,
				'form_position' => $form_position,
				'response_type' => $response_type,
				'success_message' => isset($success_message) ? $success_message:"",
				'redirect_url' => isset($redirect_url) ? $redirect_url:"",
				'image_link'=>isset($image_link) ? $image_link : "",
				'interval_time'=>$interval_time,
				'enable_country_code'=> $enable_country_code,
				'is_double_optin'=> $is_double_optin,
				'country_code_for_phone'=> isset($country_code_for_phone) ? $country_code_for_phone:"",
				'form_data' => json_encode($valid_form_data),
				'inserted_at' => date('Y-m-d H:i:s'),
			];

			
			return $this->insert_form_data('email_optin', $data);
		}

		$message = $this->lang->line('Something went wrong. Please try again later!');
		return $this->customJsonResponse($message);
	}
    
	public function export_form_data() 
	{
		// Fixes out-of-memory issue
		if (ob_get_level()) {
			ob_end_clean();
		}

		// Determines request method
		$method = $this->input->method();

		// Handles POST request
		if ('post' == strtolower($method)) {
			if (! $this->input->is_ajax_request()) {
                $message = $this->lang->line('Bad request.');
                echo json_encode(['msg' => $message]);
                exit;				
			}

			$this->form_validation->set_rules('form_id', 'Form ID', 'required');

			if (false === $this->form_validation->run()) {
				if ($this->form_validation->error('form_id')) {
					$message = $this->form_validation->error('form_id');
				} else {
					$message = $this->lang->line('Bad request.');
				}

				echo json_encode(['error' => strip_tags($message)]);
				exit;
			}

			// Holds form ID
			$form_id = filter_var($this->input->post('form_id'), FILTER_SANITIZE_STRING);

			$where = [
				'where' => [
					'web_view_form_canonical_id' => $form_id,
				],
			];
			$select = ['web_view_form_canonical_id'];

			$form = $this->basic->get_data('messenger_bot_user_custom_form_webview_data', $where, $select, [], 1);		

			// Exits displaying error if there is no data to be exported
			if (1 != sizeof($form)) {
				$message = $this->lang->line('No form data to be exported.');
				echo json_encode(['info' => $message]);
				exit;
			}

			// Sets form ID into session
			$this->session->set_userdata('webview_export_form_data_form_id', $form[0]['web_view_form_canonical_id']);
			
			// Sends success response
			echo json_encode(['status' => 'ok']);
			exit;

		} elseif ('get' == strtolower($method)) {
			$form_id = $this->session->userdata('webview_export_form_data_form_id');

			// Exits from here if we've no form ID in session
			if (! $form_id) {
				$message = $this->lang->line('No form data to be exported.');
				echo json_encode(['error' => $message]);
				exit;
			}

			$where = [
				'where' => [
					'messenger_bot_user_custom_form_webview_data.web_view_form_canonical_id' => $form_id,
				],
			];

			$join = [
				'messenger_bot_subscriber' => 'messenger_bot_user_custom_form_webview_data.subscriber_id = messenger_bot_subscriber.subscribe_id, left',
			];

			$select = [
				'messenger_bot_subscriber.first_name',
				'messenger_bot_subscriber.last_name',
				'messenger_bot_user_custom_form_webview_data.subscriber_id',
				'messenger_bot_user_custom_form_webview_data.web_view_form_canonical_id',
				'messenger_bot_user_custom_form_webview_data.data',
			];

			$form_data = $this->basic->get_data('messenger_bot_user_custom_form_webview_data', $where, $select, $join);

			// Exits displaying error if there is no data to be exported
			if (! count($form_data) > 0) {
				$message = $this->lang->line('No form data to be exported.');
				echo json_encode(['error' => $message]);
				exit;
			}

			// Grabs form data
			$data = isset($form_data[0]['data']) ? $form_data[0]['data'] : '';

			// Exits displaying error if there is no data to be exported
			if (! is_array($data = json_decode($data, true))) {
				$message = $this->lang->line('No form data to be exported.');
				echo json_encode(['error' => $message]);
				exit;
			}

			// Sets the csv file name
			$filename = 'webview_' . $data['webview_form_id'] . '.csv';

			// Prepares headers for csv file
			$csv_headers = [
				'PSID',
				'First Name',
				'Last Name',
			];

			// Prepares csv headers
			foreach ($data as $key => $header) {
				if ('subscriber_id' == $key || 'webview_form_id' == $key) {
					continue;
				}

				array_push($csv_headers, $key);
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
				foreach ($form_data as $key => $values) {
					$csv_values = [];
					$csv_values[] = $values['subscriber_id'];
					$csv_values[] = $values['first_name'];
					$csv_values[] = $values['last_name'];

					$tmp_data = json_decode($values['data'], true);
					if (null !== $tmp_data && is_array($tmp_data)) {
						foreach ($tmp_data as $key => $value) {
							if ('subscriber_id' == $key || 'webview_form_id' == $key) {
								continue;
							}

							array_push($csv_values, $value);
						}
					}					
					
					// Puts values into csv file
					fputcsv($fp, $csv_values);
				}
			}

			// Closes the file pointer
			fclose($fp);

			// Unsets form ID from session
            $this->session->unset_userdata('webview_export_form_data_form_id');
            exit;
		}
	}

    public function edit_email_optin($id = null)
    {
    	if($this->session->userdata('user_type') != 'Admin' && !in_array(290,$this->module_access))  redirect('home/login_page', 'location');

		$data = [];
    	// Gets webview form data using id
    	$form = $this->get_single_optin_form_by_id($id);
    	$data['contact_ids'] = explode(",", $form[0]['contact_group']);

		// Shows 404 if webview not found
		if (count($form) < 1) {
			redirect('error_404', 'location');
        	exit();
		}

		$this->session->unset_userdata("attachment_file_path_name_scheduler");
		$this->session->unset_userdata("attachment_filename_scheduler");

		$user_id = isset($form[0]['user_id']) ? $form[0]['user_id'] : null;
		if ($user_id != $this->user_id) {
			redirect('error_404', 'location');
        	exit();
		}
		$table = 'sms_email_contact_group';
		$where['where'] = array('user_id'=>$this->user_id);

		$info = $this->basic->get_data($table,$where);

		foreach ($info as $key => $value) 
		{
		    $result = $value['id'];
		    $data['contact_group_lists'][$result] = $value['type'];
		}

		$data['sequence_sms_campaign_lists'] = $this->basic->get_data("messenger_bot_drip_campaign",["where"=>["campaign_type"=>"sms","user_id"=>$this->user_id]]);
		$data['sequence_email_campaign_lists'] = $this->basic->get_data("messenger_bot_drip_campaign",["where"=>["campaign_type"=>"email","user_id"=>$this->user_id]]);

		$data['form_id'] = isset($form[0]['form_id']) ? $form[0]['form_id'] : null;
		$data['canonical_id'] = isset($form[0]['canonical_id']) ? $form[0]['canonical_id'] : null;
		$data['form_name'] = isset($form[0]['form_name']) ? $form[0]['form_name'] : '';
		$data['contact_group'] = isset($form[0]['contact_group']) ? $form[0]['contact_group'] : '';
		$data['sequence_email_campaign_id'] = isset($form[0]['sequence_email_campaign_id']) ? $form[0]['sequence_email_campaign_id'] : '';
		$data['sequence_sms_campaign_id'] = isset($form[0]['sequence_sms_campaign_id']) ? $form[0]['sequence_sms_campaign_id'] : '';

		$data['uri_canonical_id'] = md5($id);
		$data['real_canonical_id'] = $form[0]['canonical_id'] ? md5($form[0]['canonical_id']) : '';
		$data['form_position'] = isset($form[0]['form_position']) ? $form[0]['form_position'] : '';	
		$data['interval_time'] = isset($form[0]['interval_time']) ? $form[0]['interval_time'] : '';
		$data['response_type'] =$form[0]['response_type'];
		$data['success_message'] = isset($form[0]['success_message']) ? $form[0]['success_message'] : '';
		$data['redirect_url'] = isset($form[0]['redirect_url']) ? $form[0]['redirect_url'] : '';
    	$data['user_id'] = $this->user_id;
    	// $data['form_data'] = json_encode($decoded_form_data);
    	$data['form_data'] = isset($form[0]['form_data']) ? $form[0]['form_data'] : '';

    	$data['enable_country_code'] = $form[0]['enable_country_code'];
    	$data['is_double_optin'] = $form[0]['is_double_optin'];
    	$data['country_code_for_phone'] = isset($form[0]['country_code_for_phone']) ? $form[0]['country_code_for_phone'] : '';
    	$phonecodes = $this->get_country_iso_phone_currecncy('phonecode');
    	$country = $this->get_country_iso_phone_currecncy('country');
    	$formatted_country_codes = array();

    	foreach ($country as $key1 => $value1) {
    		$country_name = $value1;

    		foreach ($phonecodes as $key2 => $value2) {
    			if($key1 == $key2) $formatted_country_codes[$key2.'-'.$value2] = $country_name.' ('.$value2.')';
    		}
    	}
    	$data['formatted_country_codes'] = $formatted_country_codes;

    	// Sets canonical ID in session
    	$this->session->set_userdata('edit_webview_form_data', [
    		'form_id' => isset($form[0]['form_id']) ? $form[0]['form_id'] : null,
    		'canonical_id' => isset($form[0]['canonical_id']) ? $form[0]['canonical_id'] : null,
    	]);

    	$data['body'] = 'edit';
    	$data['page_title'] = $this->lang->line('Edit Email opt-in form');
    	$this->_viewcontroller($data);
    }	

    public function embeded_js_code()
    {
		$this->ajax_check();

       	$id = $this->input->post("embed_id",true);
       	$form_type = $this->input->post("form_type",true);

       	if($form_type != "direct") {
       		$plugin_data = $this->basic->get_data("email_optin",array("where"=>array("canonical_id"=>$id,"user_id"=>$this->user_id)));
       		$link_code = isset($plugin_data[0]["canonical_id"]) ? $plugin_data[0]["canonical_id"]:"";              

       		$read_me_text = $this->lang->line("Copy the code below and paste inside the html element of your webpage where you want to display this plugin.");

       	  	$js_url=base_url('email_optin_form_builder/email_optin_link.js?code='.$link_code);
       	  	$js_code='<div class="bg-modal" id="x_embedded_optin_form_builder_yz" style="display:none;"></div><script type="text/javascript" src="'.$js_url.'"></script>';

       	} else {

       		$plugin_data = $this->basic->get_data("email_optin",array("where"=>array("canonical_id"=>$id,"user_id"=>$this->user_id)));
       		$link_code = isset($plugin_data[0]["canonical_id"]) ? $plugin_data[0]["canonical_id"]:"";     
       		$js_code = base_url("email_optin_form_builder/direct_email_optin_form/".$link_code);
       		$read_me_text = $this->lang->line("Copy the below URL and paste it into your browser tab to get your Page.");
       	}

       	echo json_encode(array("str1"=>$js_code,"read_me_text"=>$read_me_text));
    }

    private function render_form_html($alldata) 
	{
		$alldata = $alldata;
		$bg_image = $alldata->image_link;
		$canonical_id = $alldata->canonical_id;
		$contact_group = $alldata->contact_group;
		$form_position = $alldata->form_position;
		$user_id = $alldata->user_id;
		$form_name = $alldata->form_name;
		$sequence_sms_campaign_id = $alldata->sequence_sms_campaign_id;
		$sequence_email_campaign_id = $alldata->sequence_email_campaign_id;
		$response_type = $alldata->response_type;
		$success_message = $alldata->success_message;
		$redirect_url = $alldata->redirect_url;
		$enable_country_code = $alldata->enable_country_code;
		$is_double_optin = $alldata->is_double_optin;
		$country_code_for_phone = isset($alldata->country_code_for_phone) ? $alldata->country_code_for_phone:"";

		$phonecodes = $this->get_country_iso_phone_currecncy('phonecode');
		$country = $this->get_country_iso_phone_currecncy('country');
		$formatted_country_codes = array();

		foreach ($country as $key1 => $value1) {
			$country_name = $value1;
			$formatted_country_codes[''] = $this->lang->line("Select Country Code");
			foreach ($phonecodes as $key2 => $value2) {
				if($key1 == $key2) $formatted_country_codes[$key2.'-'.$value2] = '('.$value2.') '.$country_name;
			}
		}

		$form_data = json_decode($alldata->form_data,true);

		if (! sizeof($form_data) > 0) {
			return null;
		}

		if($bg_image != '') {
			$bg_image = base_url("upload/email_optin_bg_image/{$bg_image}");
		}

		// Holds dynamically generated dom elements
		$output = '<div class="embeded_newsletter_card" style="background-image:url('.$bg_image.');background-repeat:no-repeat;background-size:cover;background-position:center center">';
		$output .= '<div><span id="close_newsletter" onClick="this.parentNode.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode.parentNode);">&times;</span></div>';
		$output .= '<div id="i_optin_error_msg_div" class="i_optin_alert i_optin_alert_danger" style="display:none;text-align:center;font-size:14px;"><span id="i_optin_error_msg"></span></div>';
		$output .= '<form id="optin_form">';

		$output .= '<input type="hidden" name="contact_group" id="contact_group" value="'.$contact_group.'">';
		$output .= '<input type="hidden" name="sequence_sms_campaign_id" id="sequence_sms_campaign_id" value="'.$sequence_sms_campaign_id.'">';
		$output .= '<input type="hidden" name="sequence_email_campaign_id" id="sequence_email_campaign_id" value="'.$sequence_email_campaign_id.'">';
		$output .= '<input type="hidden" name="user_id" id="user_id" value="'.$user_id.'">';
		$output .= '<input type="hidden" name="response_type" id="response_type" value="'.$response_type.'">';
		$output .= '<input type="hidden" name="success_message" id="success_message" value="'.$success_message.'">';
		$output .= '<input type="hidden" name="redirect_url" id="redirect_url" value="'.$redirect_url.'">';

		$output .= '<input type="hidden" name="enable_country_code" id="enable_country_code" value="'.$enable_country_code.'">';
		$output .= '<input type="hidden" name="is_double_optin" id="is_double_optin" value="'.$is_double_optin.'">';
		$output .= '<input type="hidden" name="country_code_for_phone" id="country_code_for_phone" value="'.$country_code_for_phone.'">';

		// Holds button index
		$button_index = null;

		$field_info = [];
		// echo "<pre>"; print_r($form_data); exit;
		// Loop through form_data and build dom elements
		foreach ($form_data as $key => $form) {

			// Determines button index
			if ('button' == $form['type']) {
				$button_index = $key;
				continue;
			}

			$type = isset($form['type']) ? strip_tags($form['type']) : '';
			$subtype = isset($form['subtype']) ? strip_tags($form['subtype']) : '';
			$label = isset($form['label']) ? str_replace(["'",'"'],'`',$form['label']) : '';
			$description = isset($form['description']) ? strip_tags($form['description']) : '';
			$name = isset($form['name']) ? strip_tags($form['name']) : '';
			$classname = isset($form['className']) ? strip_tags($form['className']) : '';
			$placeholder = isset($form['placeholder']) ? strip_tags($form['placeholder']) : '';
			//file new by ronok
			$file = isset($form['file']) ? strip_tags($form['file']) : '';
			$maxlength = isset($form['maxlength']) ? (int) $form['maxlength'] : 200;

			$multiple = (isset($form['multiple']) && 1 == $form['multiple']) ? 'multiple' : null;
			$required = (isset($form['required']) && 1 == $form['required']) ? 'required' : null;

			$required_icon = "";
			if(null != $required) $required_icon = "*";

			switch ($form['type']) {
				case 'header':
					$allowed_tags = ['h1', 'h2', 'h3', 'h4','h5','h6'];

					if (in_array($subtype, $allowed_tags)) {
						$header = '<%1$s>%2$s</%3$s>';
						$output .= '<div class="embeded_header">';
						$output .= sprintf($header, $subtype, $label, $subtype);
						$output .= '</div>';
					}
				break;

				case 'paragraph':
					$allowed_tags = ['p','output'];

					if (in_array($subtype, $allowed_tags)) {
						if($subtype === 'output') {
							$output .= '<div class="embeded_form_group">';
							$str = '<input name="agreement_check" id="email_optin_form_checkbox" type="checkbox" value="agreement_checkbox" class="agreement_check" data-required="required" /><span style="margin-left:5px;font-size:12px;">%2$s</span>';
							$output .= sprintf($str, $subtype,$label,$subtype);
							$output .= '</div>';
						} else {

							$paragraph = '<div class="embeded_min_p_contents">%2$s</div>';
							$output .= sprintf($paragraph, $subtype, $label, $subtype);

						}
						
					}
				break;
				
				case 'text':
					$allowed_subtypes = ['text', 'password', 'email', 'color', 'tel'];


					if (in_array($subtype, $allowed_subtypes)) {

						$output .= '<div class="embeded_form_group">';

						if ($label) {
							$label_str = '<label class="embeded_label">%s'.$required_icon.'</label>';
							$output .= sprintf($label_str, $label);
						}

						if ($description) {
							$tooltip_str = '<a href="#" data-toggle="tooltip" title="" data-original-title="%1$s"><i class="fas fa-info"></i></a>';
							$output .= sprintf($tooltip_str, $description);
						}						

						if($subtype == "tel" && $name=="phone_number") {
							
							if(isset($enable_country_code) && $enable_country_code == '1') {
								$input = '<div class="embeded_code_input_group">'.form_dropdown('country_code_for_phone', $formatted_country_codes, $country_code_for_phone,'class="embeded_form_control" id="country_code_for_phone" title="Country Code"').'<input name="%1$s" id="%1$s" type="%2$s" class="embeded_form_control" maxlength="%4$d" placeholder="%5$s" %6$s data-required="%6$s" /></div>';
							} else {
								$input = '<input name="%1$s" id="%1$s" type="%2$s" class="embeded_form_control" maxlength="%4$d" placeholder="%5$s" %6$s data-required="%6$s" />';
							}

						} else {
							$input = '<input name="%1$s" id="%1$s" type="%2$s" class="embeded_form_control" maxlength="%4$d" placeholder="%5$s" %6$s data-required="%6$s" />';

						}
						$output .= sprintf($input, $name, $subtype, $classname, $maxlength, $placeholder, $required);

						$output .= '</div>';					
					}

					break;

				case 'checkbox-group':
					$values = isset($form['values']) ? $form['values'] : [];
					$checkbox_options = '';

					if (sizeof($values) > 0) {
						$radio_str = '<label class="embeded_label"><input name="%1$s" id="email_optin_form_checkbox" type="checkbox" value="%2$s" class="" %3$s data-required="%4$s" /><span class="">&nbsp; %5$s</span></label>';
						foreach ($values as $key => $value) {
							$checkbox_options .= sprintf(
								$radio_str,
								$name,
								(isset($value['value']) ? strip_tags($value['value']) : null),
								((isset($value['selected']) && 1 == $value['selected']) ? 'checked' : null),
								(isset($value['required']) ? strip_tags($value['required']) : null),
								(isset($value['label']) ? strip_tags($value['label']) : null)
							);
						}
					}

					$output .= '<div class="embeded_form_group">';

					// if ($label) {
					// 	$label_str = '<label>%s</label>';
					// 	$output .= sprintf($label_str, $label);
					// }

					if ($description) {
						$tooltip_str = '<a href="#" data-toggle="tooltip" title="" data-original-title="%1$s"><i class="fas fa-info"></i></a>';
						$output .= sprintf($tooltip_str, $description);
					}				

					$output .= '<div class="">';
					$output .= $checkbox_options;
					$output .= '</div>';

					$output .= '</div>';

					break;																
				default:
					break;
			}
		}

		// Adds button element at the very end of the dom elements
		if (null !== $button_index 
			&& (isset($form_data[$button_index]['type']) 
				&& 'button' == $form_data[$button_index]['type'])
		) {
			if(isset($form['className'])) {
				if($form['className'] === "btn-default btn" || $form['className'] ==='form-control btn-default btn') {
					$btn_classname = 'emb_opt_btn emb_opt_btn_default';

				} else if($form['className'] === "btn-danger btn" || $form['className'] ==='form-control btn-danger btn') {

					$btn_classname = 'emb_opt_btn emb_opt_btn_danger';

				} else if($form['className'] === "btn-info btn" || $form['className'] ==='form-control btn-info btn') {
					$btn_classname = 'emb_opt_btn emb_opt_btn_info';

				} else if($form['className'] === "btn-primary btn" || $form['className'] ==='form-control btn-primary btn') {
					$btn_classname = 'emb_opt_btn emb_opt_btn_primary';

				} else if($form['className'] === "btn-success btn" || $form['className'] ==='form-control btn-success btn') {
					$btn_classname = 'emb_opt_btn emb_opt_btn_success';

				} else if($form['className'] === "btn-warning btn" || $form['className'] ==='form-control btn-warning btn') {
					$btn_classname = 'emb_opt_btn emb_opt_btn_warning';

				}

			} else {
				$btn_classname = 'emb_opt_btn emb_opt_btn_primary';
			}

			$alignment = isset($form['alignment']) ? strip_tags($form['alignment']) : '';
			$output .= '<div class="embeded_card_footer">';
			
			$form = $form_data[$button_index];
			$input_str = '<button class="embeded_button '.$btn_classname.'">%1$s</button>';
			$output .= sprintf(
				$input_str,
				(isset($form['label']) ? strip_tags($form['label']) : '')
			);
			
			$output .= '</div>';
		} else {
			$output .= '<div class="embeded_form_group">';
			$output .= '<button class="embeded_button">Submit</button>';
			$output .= '</div>';
		}
        
        $output.='</form></div><div class="embeded_clearfix"></div>';
		return $output;
	}

    // email optin link  my code
    public function email_optin_link()
    {
    	header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/javascript');

        $domain_code=$this->input->get('code', TRUE);
        $q = $this->db->select('*')->from('email_optin')->where(['canonical_id'=>$domain_code])->get();
        $result = $q->row();
        $form_data = $this->render_form_html($result);
        $html = $result->form_data;
        $interval_time = $result->interval_time;
        $decoded_form_data = json_decode($html, true);
        $type = $result->form_position;
        $html= '';

        // file_put_contents("textsss.txt", $form_data);

        if($type == 'right')
        {
         	$html.=str_replace("\n", "", $form_data);
         	$source_code ="
         	var base_url = '".base_url()."';
         	var oppssomethingwrong = '".$this->lang->line('Oops! Something went wrong.')."';
         	var confirmation_msg = '".$this->lang->line('We have sent a confirmation email to your email address.')."';
         	var cannotbeempty = '".$this->lang->line('can not be empty')."';
         	var thisfieldcannotbeempty = '".$this->lang->line('This field can not be empty')."';
         	var providevalidemail = '".$this->lang->line('Please provide an valid email address')."';
         	var phonemustbenumeric = '".$this->lang->line('Phone number must be numeric.')."';
         	var checkthecheckbox = '".$this->lang->line('Please check the checkbox')."';
         	var enabledoubleoptin = '".$this->lang->line('Please check the confirmation mail sending.')."';

         	setTimeout(x_callTo_embedded_form_loading_zy, $interval_time);

         	setTimeout(function(){ document.getElementById('x_embedded_optin_form_builder_yz').style.display = 'block' }, 2000);

         	function x_callTo_embedded_form_loading_zy()
         	{
         		var load_css = '".base_url()."plugins/email_optin_form/css/embeded_code_right_css.css';
         		var elem = document.createElement('link');
         		elem.rel = ' stylesheet';
         		elem.href= load_css; // Link of the css file
         		document.head.appendChild(elem);

         		var load_css2 = 'https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css';
         		var elem = document.createElement('link');
         		elem.rel = ' stylesheet';
         		elem.href= load_css2; // Link of the css file
         		document.head.appendChild(elem);

         		// included js
         		var jQueryScript = document.createElement('script');  
         		jQueryScript.setAttribute('src','".base_url()."plugins/email_optin_form/js/submit_form.js');
         		document.head.appendChild(jQueryScript);

         		// included js
         		var izitoasetercdn = document.createElement('script');  
         		izitoasetercdn.setAttribute('src','https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js');
         		document.head.appendChild(izitoasetercdn);

         		document.getElementById('x_embedded_optin_form_builder_yz').innerHTML = '".$html."';
         	}

         	";

         	echo $source_code;

        }
        else if ($type=='center')
        {
         	$html.=str_replace("\n", "", $form_data);;
         	$source_code ="
         	var base_url = '".base_url()."';
         	var oppssomethingwrong = '".$this->lang->line('Oops! Something went wrong.')."';
         	var confirmation_msg = '".$this->lang->line('We have sent a confirmation email to your email address.')."';
         	var cannotbeempty = '".$this->lang->line('can not be empty')."';
         	var thisfieldcannotbeempty = '".$this->lang->line('This field can not be empty')."';
         	var providevalidemail = '".$this->lang->line('Please provide an valid email address')."';
         	var phonemustbenumeric = '".$this->lang->line('Phone number must be numeric.')."';
         	var checkthecheckbox = '".$this->lang->line('Please check the checkbox')."';
         	var enabledoubleoptin = '".$this->lang->line('Please check the confirmation mail sending.')."';

         	setTimeout(x_callTo_embedded_form_loading_zy, $interval_time);

         	setTimeout(function(){ document.getElementById('x_embedded_optin_form_builder_yz').style.display = 'block' }, 2000);

         	function x_callTo_embedded_form_loading_zy()
         	{
         		var load_css = '".base_url()."plugins/email_optin_form/css/embeded_code_center_css.css';
         		var elem = document.createElement('link');
         		elem.rel = ' stylesheet';
         		elem.href= load_css; // Link of the css file
         		document.head.appendChild(elem);

         		var load_css2 = 'https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css';
         		var elem = document.createElement('link');
         		elem.rel = ' stylesheet';
         		elem.href= load_css2; // Link of the css file
         		document.head.appendChild(elem);

         		// included js
         		var jQueryScript = document.createElement('script');  
         		jQueryScript.setAttribute('src','".base_url()."plugins/email_optin_form/js/submit_form.js');
         		document.head.appendChild(jQueryScript);

         		// included js
         		var izitoasetercdn = document.createElement('script');  
         		izitoasetercdn.setAttribute('src','https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js');
         		document.head.appendChild(izitoasetercdn);

         		document.getElementById('x_embedded_optin_form_builder_yz').innerHTML = '".$html."';
         	}
         	";

         	echo $source_code;
     	}
     	else if ($type == "fixed")
     	{
         	$html.=str_replace("\n", "", $form_data);;
         	$source_code ="
         	var base_url = '".base_url()."';
         	var oppssomethingwrong = '".$this->lang->line('Oops! Something went wrong.')."';
         	var confirmation_msg = '".$this->lang->line('We have sent a confirmation email to your email address.')."';
         	var cannotbeempty = '".$this->lang->line('can not be empty')."';
         	var thisfieldcannotbeempty = '".$this->lang->line('This field can not be empty')."';
         	var providevalidemail = '".$this->lang->line('Please provide an valid email address')."';
         	var phonemustbenumeric = '".$this->lang->line('Phone number must be numeric.')."';
         	var checkthecheckbox = '".$this->lang->line('Please check the checkbox')."';
         	var enabledoubleoptin = '".$this->lang->line('Please check the confirmation mail sending.')."';

         	setTimeout(x_callTo_embedded_form_loading_zy, $interval_time);

         	setTimeout(function(){ document.getElementById('x_embedded_optin_form_builder_yz').style.display = 'block' }, 2000);

         	function x_callTo_embedded_form_loading_zy()
         	{
         		var load_css = '".base_url()."plugins/email_optin_form/css/embeded_code_fixed_css.css';
         		var elem = document.createElement('link');
         		elem.rel = ' stylesheet';
         		elem.href= load_css; // Link of the css file
         		document.head.appendChild(elem);

         		var load_css2 = 'https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css';
         		var elem = document.createElement('link');
         		elem.rel = ' stylesheet';
         		elem.href= load_css2; // Link of the css file
         		document.head.appendChild(elem);

         		// included js
         		var jQueryScript = document.createElement('script');  
         		jQueryScript.setAttribute('src','".base_url()."plugins/email_optin_form/js/submit_form.js');
         		document.head.appendChild(jQueryScript);

         		// included js
         		var izitoasetercdn = document.createElement('script');  
         		izitoasetercdn.setAttribute('src','https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js');
         		document.head.appendChild(izitoasetercdn);

         		document.getElementById('x_embedded_optin_form_builder_yz').innerHTML = '".$html."';
         	}";

         	echo $source_code;
        }
         
    }

    public function email_optin_form($id = null) 
    {
    	if (is_null($id) || ! is_string($id) || strlen($id) < 10) {
			redirect('error_404', 'location');
        	exit();
    	}

    	$domain_code=$id;

    	$q = $this->db->select('*')->from('email_optin')->where(['canonical_id'=>$domain_code])->get();
    	$result = $q->row();

    	$form_data = $this->render_form_html($result);

		$data['form_id'] = $id;
		$title = $result->form_name;

		if(isset($form[0])) $data['form']= $form[0]; 
		else $data['form']['form_name'] = $title.' | '.$this->config->item('product_short_name');

		$data['is_direct'] = 0; 
		$data['form_data'] = $form_data;
        $data['body'] = 'view';
        $data['page_title'] = $this->lang->line('Form Details');

        $this->load->view('bare-theme', $data);  
    }

    public function direct_email_optin_form($id = null) 
    {
    	if (is_null($id) || ! is_string($id) || strlen($id) < 10) {
			redirect('error_404', 'location');
        	exit();
    	}

    	$domain_code=$id;

    	$q = $this->db->select('*')->from('email_optin')->where(['canonical_id'=>$domain_code])->get();
    	$result = $q->row();

    	if(empty($result)) {
			redirect('error_404', 'location');
        	exit();
    	}

    	$form_data = $this->render_form_html($result);

		$data['form_id'] = $id;
		$title = $result->form_name;

		// Preapares vars for view
		$data['form']['form_name'] = $title.' | '.$this->config->item('product_short_name');

		$data['is_direct'] = 1; 
		$data['form_data'] = $form_data;
        $data['body'] = 'view';
        $data['page_title'] = $this->lang->line('Form Details');

        $this->load->view('bare-theme', $data);  
    }


    private function send_confirmation_mail($email='',$url='')
    {
    	$mask=$this->config->item("product_name");
    	$email= $email;
    	$app_url = site_url();

    	$get_email_template = $this->basic->get_data("email_template_management",array('where'=>array('template_type'=>'double_optin')),array('subject','message'));

    	if(isset($get_email_template[0]) && $get_email_template[0]['subject'] != '' && $get_email_template[0]['message'] != '') {

    		$subject = str_replace('#APP_NAME#',$mask,$get_email_template[0]['subject']);
    		$message =str_replace(array("#APP_NAME#","#APP_URL#","#OPTIN_URL#"),array($mask,$app_url,$url),$get_email_template[0]['message']);

    	} else {

    		$subject= $this->lang->line("Confirm Email")." | ".$mask;
    		$message = "<b><h2>".$this->lang->line("Confrim your Subscription")."</h2></b>
    		<p>You received this email because you opted in for our email updates. Click the below button to confirm the subscription.</p><br>
    		<p><a style='padding:14px 40px;background:#479a55;color:#ffffff;text-decoration: none;font-size: 14px;border-radius:50px;' href='".$url."'>Confirm Your Email</a></p><br>
    		<p>If you do not know what it means, just ignore this email.</p><br><br>
    		Thank You,<br>
    		<a href='".$app_url."'></a>{$mask} Team";

    	}

    	$from=$this->config->item('institute_email');
    	$to = $email;
    	$html = 1;

    	@$this->_mail_sender($from, $to, $subject, $message, $mask, $html);
    
}
    public function confim_optin()
    {

    	$action = $_GET['action'] ?? '';
    	$uid = $_GET['uid'] ?? 0;

    	if($action !='confirm' || $uid=='') {
    		redirect('error_404','refresh');
    	}


    	$decrypt_ids = base64_decode($uid);
    	$separate_ids = explode("-",$decrypt_ids);
    	$contact_id = isset($separate_ids[0]) ? $separate_ids[0]:0;
    	$user_id = isset($separate_ids[1]) ? $separate_ids[1]:0;
    	if(!$this->basic->is_exist("sms_email_contacts",['id'=>$contact_id,'user_id'=>$user_id])) {
    		redirect('error_404','refresh');
    	}

    	$data['action'] = $action;
    	$data['contact_id'] = $contact_id;
    	$data['user_id'] = $user_id;
    	$get_sequences = $this->basic->get_data("sms_email_contacts",['where'=>["id"=>$contact_id,"user_id"=>$user_id]],['sms_email_sequence_campaign_ids','status']);

    	$data['sequence_ids'] = $get_sequences[0]['sms_email_sequence_campaign_ids'];
    	$data['status'] = $get_sequences[0]['status'];
    	$data['page_title'] = $this->lang->line("Confirm Email");
    	$this->load->view("confirm_subscription",$data);
    }


    public function confirm_optin_action()
    {
    	$this->ajax_check();

    	$user_id = $this->input->post("user_id",true);
    	$contact_id = $this->input->post("contact_id",true);
    	$sequence_ids = $this->input->post("sequence_ids",true);

    	if($sequence_ids != "") {
    		$ex_sequence_id = explode(",",$sequence_ids);

    		foreach ($ex_sequence_id as $value) {
                $this->assign_drip_messaging_id("custom","0","0",$contact_id,$value);
            }
    	}

    	if($this->basic->update_data("sms_email_contacts",['id'=>$contact_id,'user_id'=>$user_id],["status"=>'1'])) {
    		echo "1";	
    	}

    }


    public function submit_optin_form_data()
    {
		header('Access-Control-Allow-Origin: *');
	    header('Content-Type: application/json');

	    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	        redirect('home/access_forbidden', 'location');
	    }

    	$user_id = $this->input->post('user_id',true);
    	$first_name = strip_tags(trim($this->input->post('first_name',true)));
    	$last_name = strip_tags(trim($this->input->post('last_name',true)));
    	$email = strip_tags(trim($this->input->post('email',true)));
    	$phone_number = strip_tags(trim($this->input->post('phone_number',true)));
    	$sequence_sms_campaign_id = strip_tags(trim($this->input->post('sequence_sms_campaign_id',true)));
    	$sequence_email_campaign_id = strip_tags(trim($this->input->post('sequence_email_campaign_id',true)));
    	$contact_group = strip_tags(trim($this->input->post('contact_group',true)));
    	$new_contact_groups = explode(',', $contact_group);
    	$is_double_optin = $this->input->post("is_double_optin",true);

    	$response_type = strip_tags(trim($this->input->post('response_type',true)));
    	$success_message = strip_tags(trim($this->input->post('success_message',true)));
    	$redirect_url = strip_tags(trim($this->input->post('redirect_url',true)));
    	$country_code_for_phone = strip_tags(trim($this->input->post('country_code_for_phone')));

    	$sequence_campaign_ids = [];
    	array_push($sequence_campaign_ids, $sequence_sms_campaign_id,$sequence_email_campaign_id);

    	if($email) {
    		if(! filter_var($email, FILTER_VALIDATE_EMAIL)) {
    			echo json_encode(['error' => true,'message'=>$this->lang->line("Email is not valid a email.")]); 
    			exit;
    		}
    	}

    	if($phone_number) {
    		if(! preg_match("/^\+?[0-9]+$/", $phone_number)) {
    			echo json_encode(['error'=> true,'message'=>$this->lang->line("Phone number is not valid.")]); 
    			exit;
    		}

    		if($country_code_for_phone != '') {
    			$country_code_for_phone = explode('-', $country_code_for_phone);
    			$country_code_for_phone = $country_code_for_phone[1];
    			$phone_number = $country_code_for_phone.$phone_number;
    		}
    	}

    	// new
    	$processed_data = [];
    	$processed_data['user_id'] = $user_id;
    	$processed_data['deleted'] = '0';

    	if($first_name != '') $processed_data['first_name'] = $first_name;
    	if($last_name != '') $processed_data['last_name'] = $last_name;
    	if($email != '') $processed_data['email'] = $email;
    	if($phone_number != '') $processed_data['phone_number'] = $phone_number;



    	$observed_email = $email;
    	$observed_phone = $phone_number;
    	$temp = '';
    	$old_sequence_ids = '';
    	$uid = $subscriber_id = '';
    	$redirectUrl = base_url("email_optin_form_builder/confim_optin?action=confirm");

    	if($observed_email != '' && $observed_phone != '') { // if email and phone number both are present

    		$or_where = array("email"=> $observed_email, "phone_number" => $observed_phone);

    		$sql = "(user_id ='".$user_id."' AND (phone_number='".$observed_phone."' OR email='".$observed_email."'))";
    		$this->db->where($sql);
    		$db_data = $this->basic->get_data("sms_email_contacts");

    		if(count($db_data) > 0) {

    			$temp = $new_contact_groups;
    			$contact_groups_new = explode(",",$db_data[0]['contact_type_id']);

    			foreach ($contact_groups_new as $new_group_id) {

    			    array_push($temp, $new_group_id);
    			}

    			$newGroups = array_unique($temp);
    			$processed_data['contact_type_id'] = implode(",",$newGroups);

    			$subscriber_id = $db_data[0]['id'];

    			if($is_double_optin=='1') {

    				$subscriber_id .= "-".$user_id;
    				$subscriber_id = base64_encode($subscriber_id);
    				$redirectUrl .= "&uid=".$subscriber_id;

			        $old_sequence_ids = $db_data[0]['sms_email_sequence_campaign_ids'];
			       	if(!empty($old_sequence_ids)) {

						$old_sequence_ids = explode(",",$old_sequence_ids);
						foreach($old_sequence_ids as $old_sequence) {
			       			array_push($sequence_campaign_ids,$old_sequence);
						}
			       	}

			       	$sequence_campaign_ids = array_unique($sequence_campaign_ids);
			       	$sequence_campaign_ids = implode(",", $sequence_campaign_ids);
			       	$processed_data['sms_email_sequence_campaign_ids'] = $sequence_campaign_ids;
    			}


		        if($observed_phone == $db_data[0]['phone_number']) {
		            $this->basic->update_data("sms_email_contacts",array("user_id"=>$user_id,"phone_number"=>$observed_phone), $processed_data);
		        }
		        else {
		            $this->basic->update_data("sms_email_contacts",array("user_id"=>$user_id,"email"=>$observed_email), $processed_data);
		        }

		        if($is_double_optin=='1') {
		        	$this->send_confirmation_mail($observed_email,$redirectUrl);

		        } else {
		        	if(!empty($sequence_campaign_ids)) {

		        	    foreach ($sequence_campaign_ids as $value) {
		        	        $this->assign_drip_messaging_id("custom","0","0",$subscriber_id,$value);
		        	    }
		        	}
		        }

    		} else {

    			// $processed_data['status'] = '0';
    		    $processed_data['sms_email_sequence_campaign_ids'] = implode(",",$sequence_campaign_ids);
    		    $processed_data['contact_type_id'] = implode(",",$new_contact_groups);
    		    $this->basic->insert_data("sms_email_contacts",$processed_data);

    		    $subscriber_id = $this->db->insert_id();

    		    if($is_double_optin=='1') {
    		    	$this->basic->update_data("sms_email_contacts",['id'=>$subscriber_id],['status'=>'0']);
    		    	$subscriber_id .= "-".$user_id;
    		    	$subscriber_id = base64_encode($subscriber_id);
    		    	$redirectUrl .= "&uid=".$subscriber_id;

    		    	$this->send_confirmation_mail($observed_email,$redirectUrl);

    		    } else {
    		    	if(!empty($sequence_campaign_ids)) {

    		    	    foreach ($sequence_campaign_ids as $value) {
    		    	        $this->assign_drip_messaging_id("custom","0","0",$subscriber_id,$value);
    		    	    }
    		    	}
    		    }
    		}

    		if($response_type === "success_message_type") {
    			echo json_encode(['success'=>true,'type'=>$response_type,"message"=>$success_message]);

    		} else if($response_type === "redirect_url_type") {

    			echo json_encode(['success'=>true,'type'=>$response_type,"url"=>$redirect_url]);
    		}


    	} else if($observed_email != '') { // If only email comes through the form

            if($this->basic->is_exist("sms_email_contacts", array("user_id"=>$user_id,"email"=>$observed_email))) {

                $contactWithEmail = $this->basic->get_data("sms_email_contacts",array("where"=>array("user_id"=>$user_id,"email"=>$observed_email)));
                $temp3 = $new_contact_groups;
                $contact_groups_new = explode(",",$contactWithEmail[0]['contact_type_id']);

                foreach ($contact_groups_new as $new_group_id) {

                    array_push($temp3, $new_group_id);
                }

                $newGroups = array_unique($temp3);
                $processed_data['contact_type_id'] = implode(",",$newGroups);
                $subscriber_id = $contactWithEmail[0]['id'];

                if($is_double_optin == '1') {
        	        $old_sequence_ids = $contactWithEmail[0]['sms_email_sequence_campaign_ids'];
        	       	if(!empty($old_sequence_ids)) {

        				$old_sequence_ids = explode(",",$old_sequence_ids);
        				foreach($old_sequence_ids as $old_sequence) {
        	       			array_push($sequence_campaign_ids,$old_sequence);

        				}
        	       	}
        	       	$sequence_campaign_ids = array_unique($sequence_campaign_ids);
        	       	$sequence_campaign_ids = implode(",", $sequence_campaign_ids);
        	       	$processed_data['sms_email_sequence_campaign_ids'] = $sequence_campaign_ids;
                }

                $this->basic->update_data("sms_email_contacts", array("user_id"=>$user_id,"email" => $observed_email), $processed_data);

                if($is_double_optin=='1') {

                	$subscriber_id .= "-".$user_id;
                	$subscriber_id = base64_encode($subscriber_id);
                	$redirectUrl .= "&uid=".$subscriber_id;

                	$this->send_confirmation_mail($observed_email,$redirectUrl);

                } else {
                	if(!empty($sequence_campaign_ids)) {

                	    foreach ($sequence_campaign_ids as $value) {
                	        $this->assign_drip_messaging_id("custom","0","0",$subscriber_id,$value);
                	    }
                	}
                }

            } else {

        		// $processed_data['status'] = '0';
        	    $processed_data['sms_email_sequence_campaign_ids'] = implode(",",$sequence_campaign_ids);
                $processed_data['contact_type_id'] = implode(",",$new_contact_groups);
                $this->basic->insert_data("sms_email_contacts",$processed_data);

                $subscriber_id = $this->db->insert_id();

                if($is_double_optin=='1') {
                	$this->basic->update_data("sms_email_contacts",['id'=>$subscriber_id],['status'=>'0']);
                	$subscriber_id .= "-".$user_id;
                	$subscriber_id = base64_encode($subscriber_id);
                	$redirectUrl .= "&uid=".$subscriber_id;

                	$this->send_confirmation_mail($observed_email,$redirectUrl);

                } else {
                	if(!empty($sequence_campaign_ids)) {

                	    foreach ($sequence_campaign_ids as $value) {
                	        $this->assign_drip_messaging_id("custom","0","0",$subscriber_id,$value);
                	    }
                	}
                }
            }

            if($response_type === "success_message_type") {
            	echo json_encode(['success'=>true,'type'=>$response_type,"message"=>$success_message]);

            } else if($response_type === "redirect_url_type") {

            	echo json_encode(['success'=>true,'type'=>$response_type,"url"=>$redirect_url]);
            }


        } else if($observed_phone != '') { // If only phone number comes through the form

        	if($this->basic->is_exist("sms_email_contacts", array("user_id"=>$user_id,"phone_number"=>$observed_phone))) {

        	    $contactWithPhone = $this->basic->get_data("sms_email_contacts",array("where"=>array("user_id"=>$user_id,"phone_number"=>$observed_phone)));

        	    $temp2 = $new_contact_groups;
        	    $contact_groups_new = explode(",",$contactWithPhone[0]['contact_type_id']);
        	    foreach ($contact_groups_new as $new_group_id) {

        	        array_push($temp2, $new_group_id);
        	    }

        	    $newGroups = array_unique($temp2);
        	    $processed_data['contact_type_id'] = implode(",",$newGroups);

        	    $this->basic->update_data("sms_email_contacts", array("user_id"=>$user_id,"phone_number" => $observed_phone), $processed_data);

        	    $subscriber_id = $contactWithPhone[0]['id'];

        	    if(!empty($sequence_campaign_ids)) {

        	        foreach ($sequence_campaign_ids as $value) {
        	            $this->assign_drip_messaging_id("custom","0","0",$subscriber_id,$value);
        	        }
        	    }

        	} else {

        	    $processed_data['contact_type_id'] = implode(",",$new_contact_groups);
        	    $this->basic->insert_data("sms_email_contacts",$processed_data);

        	    $subscriber_id = $this->db->insert_id();

        	    if(!empty($sequence_campaign_ids)) {

        	        foreach ($sequence_campaign_ids as $value) {
        	            $this->assign_drip_messaging_id("custom","0","0",$subscriber_id,$value);
        	        }
        	    }

        	}

            if($response_type === "success_message_type") {
            	echo json_encode(['success'=>true,'type'=>$response_type,"message"=>$success_message]);

            } else if($response_type === "redirect_url_type") {

            	echo json_encode(['success'=>true,'type'=>$response_type,"url"=>$redirect_url]);
            }
        }
    }


    public function ajax_attachment_upload()
    {

       if ($_SERVER['REQUEST_METHOD'] === 'GET') exit();

       $ret = array();
       $output_dir = FCPATH."upload/email_optin_bg_image/";

       if(!file_exists($output_dir))
       {
           mkdir($output_dir,0777,true);
       }

       if (isset($_FILES["file"])) {

           $error = $_FILES["file"]["error"];

           $post_fileName = $_FILES["file"]["name"];
           $post_fileName_array = explode(".", $post_fileName);
           $ext = array_pop($post_fileName_array);
           $filename = implode('.', $post_fileName_array);
           $filename = $filename."_".$this->user_id."_".time().substr(uniqid(mt_rand(), true), 0, 6).".".$ext;

           $allow = ".png,.jpg,.jpeg";
           $allow = str_replace('.', '', $allow);
           $allow = explode(',', $allow);
           if(!in_array(strtolower($ext), $allow)) 
           {
               echo json_encode("Are you kidding???");
               exit;
           }

           move_uploaded_file($_FILES["file"]["tmp_name"], $output_dir.'/'.$filename);
           $ret[]= $filename;
           $this->session->set_userdata("attachment_file_path_name_scheduler", $output_dir.'/'.$filename);
           $this->session->set_userdata("attachment_filename_scheduler", $filename);
           echo json_encode($filename);
       } 
    }

    public function delete_attachment()
    {
        unlink($this->session->userdata("attachment_file_path_name_scheduler"));
        $this->session->unset_userdata("attachment_file_path_name_scheduler");
        $this->session->unset_userdata("attachment_filename_scheduler");
    }

    public function handle_form_details_data() 
    {

		// Kicks out if not an AJAX request
		if (! $this->input->is_ajax_request()) {
			$message = 'Bad Request';
			return $this->customJsonResponse($message);
		}

		$this->form_validation->set_rules('form_id', 'Form ID', 'required|alpha_numeric|min_length[10]|max_length[45]');

		if (false === $this->form_validation->run()) {
			$message = $this->form_validation->error('form_id');
			return $this->customJsonResponse($message);
		}

		$form_id = (string) $this->input->post('form_id');
 
        $table = 'email_optin';

        $select = [
        	'email_optin.id', 
        	'email_optin.canonical_id', 
        	'email_optin.user_id',  
        	'email_optin.inserted_at', 
        	'email_optin.updated_at',
        	// 'messenger_bot_drip_campaign.campaign_name', 
        ];

        $where = [
        	'where' => [
        		'email_optin.canonical_id' => $form_id,
        	]
        ];

        $form_details = $this->basic->get_data($table, $where, $select);

		if (count($form_details) < 1) {
			redirect('error_404', 'location');
        	exit();
		}

		$user_id = isset($form_details[0]['user_id']) ? $form_details[0]['user_id'] : null;
		if ($user_id != $this->user_id) {
			$message = 'You do not have permission to view the form.';
			return $this->customJsonResponse($message);
		}

  		// Modifies date format
        if (isset($form_details[0]['inserted_at'])) {
        	$form_details[0]['inserted_at'] = date('jS M y H:i', strtotime($form_details[0]['inserted_at']));
        } 

        // Adds group_name with different formatted values 
        $form_details[0]['group_name'] = $group_names;

        if (isset($form_details[0]['id'])) {
        	unset($form_details[0]['id']); 
        }
   
        if (isset($form_details[0]['user_id'])) {
        	unset($form_details[0]['user_id']);
        }

        echo json_encode($form_details[0]);
    }


    public function delete_form_data() 
	{
		if($this->session->userdata('user_type') != 'Admin' && !in_array(290,$this->module_access))  exit();
		// Kicks out if not an AJAX request
		if (! $this->input->is_ajax_request()) {
			$message = 'Bad Request';
			return $this->customJsonResponse($message);
		}

		// Validates form ID
		$this->form_validation->set_rules('form_id', 'Form ID', 'required|max_length[45]');
		if (false == $this->form_validation->run()) {
			$message = $this->form_validation->error('form_id');
			return $this->customJsonResponse($message);
		}

		// Gets the form 
    	$form_id = (string) $this->input->post('form_id');
    	$form = $this->get_single_optin_form_by_id($form_id);

		if (count($form) < 1) {
			$message = 'Bad Request';
			return $this->customJsonResponse($message);
		}

		// References user ID
		$user_id = isset($form[0]['user_id']) ? $form[0]['user_id'] : null;

		// Denies if the request doesn't come from owner or admin
		if ($user_id != $this->user_id) {
			$message = 'You do not have permission to delete the form.';
			return $this->customJsonResponse($message);			
		}

		// Attempts to delete the form data
		$form_id = isset($form[0]['form_id']) ? $form[0]['form_id'] : null;
		if ($this->basic->delete_data('email_optin', ['id' => $form_id,'user_id'=>$this->user_id])) {

			$this->_delete_usage_log($module_id=290,$request=1);

			$message = $this->lang->line('The form has been deleted successfully');
			return $this->customJsonResponse($message, true);
		} else {
			$message = $this->lang->line('Something went wrong, please try again!');
			return $this->customJsonResponse($message);		
		}
    }

	/**
	 * Produces custom json response
	 *
	 * @param string $message
	 * @param bool $success
	 * @return void
	 */
	protected function customJsonResponse($message, $success = false) 
	{
		echo json_encode([
			'error' => $success ? false : true,
			'success' => $success,
			'message' => $message
		]);
	}

	/**
	 * Fetches single form data by id
	 *
	 * @param int $id
	 * @return array
	 */
	private function get_single_optin_form_by_id($id) 
	{
		// Prepares sql statements and clauses
		$where = [
			'where' => [
				'email_optin.canonical_id' => $id,
				'email_optin.deleted' => '0',
				'users.deleted' => '0'
			]
		];
		$select = ['email_optin.id as form_id', 'email_optin.canonical_id','email_optin.contact_group', 'email_optin.sequence_email_campaign_id','email_optin.sequence_sms_campaign_id','email_optin.form_name','email_optin.interval_time', 'email_optin.form_data','email_optin.inserted_at','email_optin.image_link','email_optin.form_position' ,'email_optin.response_type','email_optin.success_message','email_optin.redirect_url','email_optin.enable_country_code','email_optin.country_code_for_phone','email_optin.is_double_optin','users.id as user_id', 'users.name'];
		$join = ['users' => 'email_optin.user_id=users.id,left'];

		// Executes query
		return $this->basic->get_data('email_optin', $where, $select, $join, 1);
	}

	/**
	* Inserts data into database
	*
	* @param string $table_name The name of database
	* @param array $where An array with specified fields for data update 
	* @param array $data The data to be inserted
	* @return null|string
	*/
	private function update_form_data($table_name, $where, $data)
	{
		if ($this->basic->update_data($table_name, $where, $data)) {
			$this->session->unset_userdata('edit_webview_form_data');
			echo json_encode([
				'success' => true,
				'data' => $data,
				'message' => 'The form has been updated successfully'
			]);
			return;
		} else {
			$message = 'Something went wrong, please try again!';
			return $this->customJsonResponse($message); 
		}
	}

	/**
	 * Inserts data into database
	 *
	 * @param string $table_name The name of database
	 * @param array $data The data to be inserted
	 * @return null|string
	 */
	private function insert_form_data($table_name, $data) 
	{
		if ($this->basic->insert_data($table_name, $data)) {

			$this->_insert_usage_log($module_id=290,$request=1);

			echo json_encode([
				'success' => true,
				'data' => $data,
				'message' => 'The form has been created successfully'
			]);

			return;
		} else {
			$message = 'Something went wrong, please try again!';
			return $this->customJsonResponse($message); 
		}
	}

	/**
	 * Generates hash from title
	 *
	 * @param string The form title
	 * @return string
	 */
	private function generate_canonical_id($title) 
	{
		$canonical_id = '';

		try {
			$canonical_id = $this->generate_hash($title);
		} catch (Exception $e) {
			// Logs error
			log_message('error', 'Could not generate hash while saving webview form in the ' . __METHOD__ . ' method.');
		}

		return $canonical_id;
	}

	/**
	 * Checks whether a button exists in form data
	 *
	 * @param string $json_data JSON form data
	 * @return bool
	 */
	private function checks_button_tag_in_json_form_data($json_data) 
	{
		$button_found = false;
		foreach ($json_data as $key => $value) {
			if (isset($value['type']) && 'button' === $value['type']) {
				$button_found = true;
				break;
			}
		}

		return (bool) $button_found;
	}

	/**
	 * Validates and strip tags from json form data
	 * 
	 * @param string $form_data JSON formatted string data
	 * @return bool|string
	 */
	private function validate_and_strip_tags_json_form_data($json_data) 
	{
		// Strips tags
		$stripped_form_data = (string) strip_tags(html_entity_decode($json_data));

		// Decodes and gets an array of form data
		$decoded_form_data = json_decode($stripped_form_data, true);

		// Checks if the JSON data is valid
		if (null === $decoded_form_data || ! is_array($decoded_form_data)) {
			return false;
		}

		return $decoded_form_data;
	}

	/**
	 * Generates cryptographically secured hash
	 * 
	 * @param int|string $hash_me The string to be hashed
	 * @param int $length The hash length
	 * @param string $algorithm The algorithm to be used for the hash
	 * @return string
	 */
	private function generate_hash($hash_me, $length = 10, $algorithm = 'ripemd256') 
	{
		// Generates random numbers
		$salt = mt_rand(10000000, 999999999);

		// The number of internal iterations to perform for the derivation
		$iterations = 1000;
		
		$hash = hash_pbkdf2($algorithm, $hash_me, $salt, $iterations, $length);

		return $hash;
	}


	public function truncate_str ($str, $delimiter = '...', $encoding = 'UTF-8') 
	{
	    $truncated_str = mb_substr($str, 0, 60, $encoding);
	    
	    if (mb_strlen($truncated_str) < 60) {
	    	$delimiter = '';
	    }

		if (" " === mb_substr($truncated_str, -1, null, $encoding)) {
			return mb_substr($str, 0, 59, $encoding) . $delimiter;
		}

	    return $truncated_str . $delimiter;
	}


	/* 
	===============================================
	Email Phone Opt-in Form BUILDER
	***********************************************
	*/


	public function activate()
    {
        $this->ajax_check();

        $addon_controller_name=ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]
        $purchase_code=$this->input->post('purchase_code');
        $this->addon_credential_check($purchase_code,strtolower($addon_controller_name)); // retuns json status,message if error
                  
        //this addon system support 2-level sidebar entry, to make sidebar entry you must provide 2D array like below
        $sidebar=array(); 
        // mysql raw query needed to run, it's an array, put each query in a seperate index, create table query must should IF NOT EXISTS
        $sql=array
        (
	        1=> "
	            CREATE TABLE IF NOT EXISTS `email_optin` (
	              `id` int(11) NOT NULL AUTO_INCREMENT,
	              `canonical_id` varchar(255) NOT NULL,
	              `user_id` int(11) NOT NULL,
	              `contact_group` varchar(55) NOT NULL,
	              `form_position` varchar(45) NOT NULL,
	              `form_name` varchar(255) NOT NULL,
	              `form_data` text NOT NULL,
	              `deleted` enum('0','1') NOT NULL,
	              `inserted_at` datetime NOT NULL,
	              `updated_at` datetime NOT NULL,
	              `image_link` varchar(255) NOT NULL,
	              `interval_time` varchar(255) NOT NULL,
	              `response_type` enum('success_message_type','redirect_url_type') NOT NULL,
	              `success_message` mediumtext NOT NULL,
	              `redirect_url` mediumtext NOT NULL,
	              `sequence_email_campaign_id` int(11) NOT NULL,
	              `sequence_sms_campaign_id` int(11) NOT NULL,
	              `enable_country_code` enum('0','1') NOT NULL DEFAULT '0',
	              `country_code_for_phone` varchar(100) NOT NULL,
	              `is_double_optin` enum('0','1') NOT NULL DEFAULT '0',
	              PRIMARY KEY (`id`)
	            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;",
	        2 => "INSERT INTO `email_template_management` (`id`, `title`, `template_type`, `subject`, `message`, `icon`, `tooltip`, `info`) VALUES (NULL, 'Double Opt-in Confirmation Email', 'double_optin', '#APP_NAME# | Email Activation', '<b><h2>Confrim your Subscription</h2></b>\r\n<p>You received this email because you opted in for our email updates. Click the below confirmation link to confirm the subscription.</p><br>\r\n<a href=\"#OPTIN_URL#\">Confirm Your Email<a><br>\r\nThank you,<br/>\r\n<a href=\"#APP_URL#\">#APP_NAME#</a> Team', 'fas fa-check-double', '#APP_NAME#,#APP_URL#,#OPTIN_URL#', 'When a new user submit an email through opt-in form');"
        ); 
        //send blank array if you does not need sidebar entry,send a blank array if your addon does not need any sql to run
        $this->register_addon($addon_controller_name,$sidebar,$sql,$purchase_code);
    }


    public function deactivate()
    {        
        $this->ajax_check();

        $addon_controller_name=ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]
        // only deletes add_ons,modules and menu, menu_child1 table entires and put install.txt back, it does not delete any files or custom sql
        $this->unregister_addon($addon_controller_name);         
    }

    public function delete()
    {        
        $this->ajax_check();

        $addon_controller_name=ucfirst($this->router->fetch_class()); // here addon_controller_name name is Comment [origianl file is Comment.php, put except .php]

        // mysql raw query needed to run, it's an array, put each query in a seperate index, drop table/column query should have IF EXISTS
        $sql=array
        (       
          1=> "DROP TABLE IF EXISTS `email_optin`;"
        );  
        
        // deletes add_ons,modules and menu, menu_child1 table ,custom sql as well as module folder, no need to send sql or send blank array if you does not need any sql to run on delete
        $this->delete_addon($addon_controller_name,$sql);         
    }


}