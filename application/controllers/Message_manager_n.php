<?php

require_once("Home.php"); // loading home controller

class message_manager_n extends Home
{
   
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');   
        if($this->session->userdata('user_type') != 'Admin' && !in_array(82,$this->module_access))
        redirect('home/login_page', 'location'); 

        if($this->session->userdata("facebook_rx_fb_user_info")==0)
        redirect('social_accounts/index','refresh');
    
        $this->load->library("fb_rx_login");
        $this->important_feature();
        $this->member_validity();        
    }

 


  public function messenger_sync_page_messages_new($page_table_id=0,$social_media="fb"){
        
        $user_id = $this->user_id;
        $where=array('where'=>array('id'=>$page_table_id)); 
        $pages_info_for_sync = $this->basic->get_data("facebook_rx_fb_page_info",$where);

        if(empty($pages_info_for_sync)) {

            return '<br><div class="alert alert-danger text-center w-100"><b class="m-0">'.$this->lang->line("Page not found.").'</b></div>';

        }

        $str = '';       

        // getting latest 200 data
        $get_concersation_info = $this->fb_rx_login->get_all_conversation_page($pages_info_for_sync[0]['page_access_token'],$pages_info_for_sync[0]['page_id'],1,'','',$social_media);


        if(isset($get_concersation_info['error'])){
            $response['error']='1';
            $response['error_message']=isset($get_concersation_info['error_msg']) ? $get_concersation_info['error_msg']:"Unknown Error Occurred";
            return $response;
        }
        $subscriber_ids = array_column($get_concersation_info, 'id');
        $get_subscriber_info = [];
        if(!empty($subscriber_ids))
        $get_subscriber_info = $this->basic->get_data("messenger_bot_subscriber",['where_in'=>['subscribe_id'=>$subscriber_ids]],'profile_pic,image_path,subscribe_id');

        $subscriber_info = [];
        foreach($get_subscriber_info as $key=>$val){
            $subscriber_info[$val['subscribe_id']] = ['profile_pic'=>$val['profile_pic'],'image_path'=>$val['image_path']];
        }



        foreach($get_concersation_info as $conversion_info)
        {

            $from_user     = $conversion_info['name'] ?? "";
            $from_user_id  = $conversion_info['id'] ?? "";
            $last_snippet  = $conversion_info['snippet'] ?? "";
            $message_count = $conversion_info['message_count'] ?? 0;
            $thread_id     = $conversion_info['thead_id'] ?? "";
            $inbox_link    = $conversion_info['link'] ?? "";
            $unread_count  = $conversion_info['unread_count'] ?? 0;

            $rand = rand(1,4);
            $default = base_url('assets/img/avatar/avatar-'.$rand.'.png');
            $profile_pic = isset($subscriber_info[$from_user_id]['profile_pic']) && $subscriber_info[$from_user_id]['profile_pic']!="" ? $subscriber_info[$from_user_id]["profile_pic"] :  $default;
            $subscriber_image =isset($subscriber_info[$from_user_id]["image_path"]) && $subscriber_info[$from_user_id]["image_path"]!="" ? base_url($subscriber_info[$from_user_id]["image_path"]) : $profile_pic;

 
            $str.='

              <li data-id="'.$from_user_id.'" class="open_conversation_contacts change_contact" thread_id="'.$thread_id.'" from_user="'.htmlspecialchars($from_user).'" from_user_id="'.$from_user_id.'" page_table_id="'.$page_table_id.'" >
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-rem  ">
                                            
                                            <img alt="image"
                                              onerror="this.onerror=null;this.src=\''.base_url('assets/img/avatar/avatar-1.png').'\'"
                                             class="mr-1 rounded-circle border" width="50" height="50" src="'.$subscriber_image.'">

                                            <span class="avatar-status-away"></span>
                                        </div>
                                        <div class="chat-sidebar-name">
                                            <h6 class="mb-0 livechat_username">'.$from_user.'</h6><span class="text-muted"> '.$from_user_id.' </span>
                                        </div>
                                    </div>
                                </li>

            ';





        }
        return $str;                
    
        
        
    }




    public function get_pages_conversation()
    {

        $this->ajax_check();
        $is_new_theme = $this->input->post('is_new_theme');

        $page_table_id = $this->input->post('page_table_id',true);
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info'),
            'bot_enabled' => '1',
            'id' => $page_table_id
            );
        $select = array('id','page_name','page_profile','page_id as fb_page_id');
        $page_list = $this->basic->get_data('facebook_rx_fb_page_info',$where,$select,'','','', $order_by='page_name asc');

        if(empty($page_list))
        {
            echo '<br><div class="alert alert-danger text-center w-100"><b class="m-0">'.$this->lang->line("You do not have any bot enabled page").'</b></div>';
            exit();
        }

        $user_info = $this->basic->get_data('users',array('where'=>array('id'=>$this->user_id)));
        if(isset($user_info[0]['time_zone']) && $user_info[0]['time_zone'] != '')
            date_default_timezone_set($user_info[0]['time_zone']);
 

        $response= $this->messenger_sync_page_messages_new($page_table_id);
            
 

        if(isset($response['error']))
        {
            echo '<br><div class="alert alert-danger text-center w-100"><b class="m-0">'.$response['error_message'].'</b></div>';
            exit();
        }
        else echo $response;
    
        
    }



    public function get_post_conversation()
    {
        $this->ajax_check();

        // for time zone checking
        $where = array();
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info')
        );

        $from_user_id = $this->input->post('from_user_id',true);
        $thread_id = $this->input->post('thread_id',true);
        $page_table_id = $this->input->post('page_table_id',true);
        $last_message_id = $this->input->post('last_message_id',true);


        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)));

        $post_access_token = $page_info[0]['page_access_token'];
        $page_name = $page_info[0]['page_name'];

        $conversations = $this->fb_rx_login->get_messages_from_thread($thread_id,$post_access_token);
        if(!isset($conversations['data'])) $conversations['data']=array();
        $conversations['data'] = array_reverse($conversations['data']);
        // echo "<pre>"; print_r($conversations['data']); exit;

        $show_after_this_index = NULL;


        if(!empty($last_message_id))
            foreach($conversations['data'] as $key=>$value)
            {
                if($value['id']==$last_message_id) {
                    $show_after_this_index = $key;
                    break;
                }
            }



        $str = '';
        foreach($conversations['data'] as $key=>$value)
        {
            if(!is_null($show_after_this_index) && $key<=$show_after_this_index) continue;

            $created_time = $value['created_time']." UTC";
            isset($value['from']['name']) ? $value['from']['name'] = $value['from']['name'] : $value['from']['name'] = '';
            if($value['from']['name'] == $page_name)
            {


                $str.='<div class="chat">
                               <div class="chat-avatar">
                                            <a class="avatar m-0">
                                                <div class="chat-avatar"><a class="avatar m-0 bg-info"><span class="avatar-content">'.$this->getInitials($value['from']['name']).'</span></a></div>
                                            </a>
                                        </div>
                                        <div class="chat-body">
                                            <div class="chat-message" message_id="'.$value['id'].'">
                                                <p>'.chunk_split($value['message'], 50, '<br>').'</p>
                                                <span class="chat-time">'.date('d M Y H:i:s',strtotime($created_time)).'</span>
                                            </div>
                                        </div>
                                    </div>';


            }else{


                $str.='
                 <div class="chat chat-left">
                                <div class="chat-avatar">
                                   <a class="avatar m-0 bg-info"><span class="avatar-content">'.$this->getInitials($value['from']['name']).'</span></a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-message" message_id="'.$value['id'].'">
                                        <p>'.chunk_split($value['message'], 50, '<br>').'</p>
                                        <span class="chat-time">'.date('d M Y H:i:s',strtotime($created_time)).'</span>
                                    </div>
                                   
                                </div>
                            </div>';


            }
        }


        echo $str;
    }

    public function subscriber_actions_modal()
    {
        $this->ajax_check();
        $this->is_drip_campaigner_exist=$this->drip_campaigner_exist();
        $this->is_sms_email_drip_campaigner_exist=$this->sms_email_drip_campaigner_exist();
        $id = $this->input->post("id",true);
        $page_table_id = $this->input->post("page_id",true);
        $subscribe_id = $this->input->post("subscribe_id",true);
        $call_from_conversation = $this->input->post("call_from_conversation",true);
        if(empty($call_from_conversation)) $call_from_conversation = '0';

        $explode_page_id = explode_page_id($page_table_id);
        $page_table_id = $explode_page_id['page_id'];
        $social_media = $explode_page_id['social_media'];

        $subscriber_info_where = !empty($id) && $id>0 ? array("where"=>array("id"=>$id,"user_id"=>$this->user_id,"social_media"=>$social_media)) : array("where"=>array("subscribe_id"=>$subscribe_id,"user_id"=>$this->user_id,"social_media"=>$social_media));

        $subscriber_info = $this->basic->get_data("messenger_bot_subscriber",$subscriber_info_where);
        if(!isset($subscriber_info[0])) exit();
        $subscriber_data = $subscriber_info[0];

        $default = base_url('assets/images/avatar/avatar-1.png');
        $profile_pic = ($subscriber_data['profile_pic']!="") ? $subscriber_data["profile_pic"] :  $default;
        $subscriber_image =($subscriber_data["image_path"]!="") ? base_url($subscriber_data["image_path"]) : $profile_pic;
        $sdk_locale = $this->sdk_locale();
        $locale = (isset($sdk_locale[$subscriber_data['locale']])) ? $sdk_locale[$subscriber_data['locale']]: $subscriber_data['locale'];
        $timezone="";
        if($subscriber_data["timezone"]!="")
        {
            if($subscriber_data["timezone"]=='0') $timezone="GMT";
            else $timezone="GMT +".$subscriber_data["timezone"];
        }

        //  label assign block
        $table_type = 'messenger_bot_broadcast_contact_group';
        $where_type['where'] = array('user_id'=>$this->user_id,"page_id"=>$page_table_id,"invisible"=>"0","social_media"=>$social_media);
        $info_type = $this->basic->get_data($table_type,$where_type,$select='', $join='', $limit='', $start='', $order_by='group_name asc');
        $label_info=array();
        foreach($info_type as $value)
        {
            $label_info[$value['id']] = $value['group_name'];
        }
        // $selected_labels = explode(',', $subscriber_data["contact_group_id"]);
        $selected_labels = [];
        $selected_labels_info = $this->basic->get_data('messenger_bot_subscribers_label',['where'=>['subscriber_table_id'=>$subscriber_data['id']]],['contact_group_id']);
        foreach($selected_labels_info as $selected_label_ids)
            array_push($selected_labels, $selected_label_ids['contact_group_id']);
        $label_dropdown = form_dropdown('subscriber_labels',$label_info,$selected_labels,'class="form-control select2" id="subscriber_labels" multiple style="width:100% !important;"');


        // subscribe unsubscribe blobk
        if($subscriber_data['permission'] == '1')
            $status ='<span class="subsribe_unsubscribe_container"><a class="text-primary">'.$this->lang->line("Subscribed").'</a> <a class="text-muted pointer client_thread_subscribe_unsubscribe" social_media="'.$subscriber_data['social_media'].'" id="'.$subscriber_data['id']."-".$subscriber_data['permission'].'">('.$this->lang->line("Unsubscribe").')</a></span>';
        else $status ='<span class="subsribe_unsubscribe_container"><a class="text-primary">'.$this->lang->line("Unsubscribed").'</a> <a class="text-muted pointer client_thread_subscribe_unsubscribe" social_media="'.$subscriber_data['social_media'].'" id="'.$subscriber_data['id']."-".$subscriber_data['permission'].'">('.$this->lang->line("Subscribe").')</a></span>';

        // bot strat stop blbok
        $start_stop = '';
        if($subscriber_data['status'] == '1')
            $start_stop = '<span class="client_thread_start_stop_container"><a href="" class="dropdown-item has-icon client_thread_start_stop" social_media="'.$subscriber_data['social_media'].'" button_id="'.$subscriber_data['id']."-".$subscriber_data['status'].'"><i class="far fa-pause-circle"></i> '.$this->lang->line("Pause Bot Reply").'</a></span>';
        else $start_stop = '<span class="client_thread_start_stop_container"><a href="" class="dropdown-item has-icon client_thread_start_stop" button_id="'.$subscriber_data['id']."-".$subscriber_data['status'].'"><i class="far fa-play-circle"></i> '.$this->lang->line("Resume Bot Reply").'</a></span>';

        $start_stop2 = '';
        if($subscriber_data['status'] == '1')
            $start_stop2 = '<span class="client_thread_start_stop_container"><a class="pointer text-primary client_thread_start_stop" call-from-conversation="1" social_media="'.$subscriber_data['social_media'].'" button_id="'.$subscriber_data['id']."-".$subscriber_data['status'].'">'.$this->lang->line("Pause Bot Reply").'</a></span>';
        else $start_stop2 = '<span class="client_thread_start_stop_container"><a class="pointer text-primary client_thread_start_stop" call-from-conversation="1" button_id="'.$subscriber_data['id']."-".$subscriber_data['status'].'">'.$this->lang->line("Resume Bot Reply").'</a></span>';


        $user_input_start_stop = '';
        if($this->addon_exist("custom_field_manager"))
        {
            if($this->session->userdata('user_type') == 'Admin'|| in_array(292,$this->module_access))
            {
                $user_input_start_stop = '<a href="" class="dropdown-item has-icon reset_user_input_flow" social_media="'.$subscriber_data['social_media'].'"  button_id ="'.$subscriber_data['id']."-".$subscriber_data['subscribe_id']."-".$subscriber_data['page_table_id'].'"><i class="fas fa-retweet"></i> '.$this->lang->line("Reset User Input Flow").'</a>';
            }
            else if($this->session->userdata('user_type') == 'Admin')
            {
                $user_input_start_stop = '<a href="" class="dropdown-item has-icon reset_user_input_flow" social_media="'.$subscriber_data['social_media'].'"  button_id ="'.$subscriber_data['id']."-".$subscriber_data['subscribe_id']."-".$subscriber_data['page_table_id'].'"><i class="fas fa-retweet"></i> '.$this->lang->line("Reset User Input Flow").'</a>';
            }
        }

        // sequence message block
        $sequence_block='';
        if($this->is_drip_campaigner_exist || $this->is_sms_email_drip_campaigner_exist)
        {
            $campaign_data=$this->basic->get_data("messenger_bot_drip_campaign",array("where"=>array("page_id"=>$page_table_id,"media_type"=>$social_media)),$select='',$join='',$limit='',$start=NULL,$order_by='created_at DESC');
            $drip_types=$this->get_drip_type();
            $option=array('0'=>$this->lang->line('Choose Message Sequence'));
            foreach ($campaign_data as $key => $value)
            {
                $option[$value['id']]="";
                if($value['campaign_name']!="") $option[$value['id']].=$value['campaign_name']." : ";
                $option[$value['id']].=$drip_types[$value['drip_type']]." - ".$value['campaign_type']." [".date("jS M, y H:i:s",strtotime($value['created_at']))."]";
            }

            $current_sequence_array=array();
            $user_sequence = $this->basic->get_data("messenger_bot_drip_campaign_assign",array("where"=>array("subscribe_id"=>$subscribe_id,"user_id"=>$this->user_id)));
            foreach ($user_sequence as $key => $value)
            {
                $current_sequence_array[] = $value['messenger_bot_drip_campaign_id'];
            }

            $sequence_dropdwon = form_dropdown('assign_campaign_id', $option, $current_sequence_array,'style="width:100%" class="form-control inline" id="assign_campaign_id" multiple');
            $last_sent_info='';
            // if($subscriber_data['messenger_bot_drip_campaign_id']!=0)
            // {
            //   $last_sent_info = '<small class="last_sent_info float-right" data-toggle="tooltip" title="'.$this->lang->line("Last Sent").'"><i class="fas fa-clock"></i> '.date("jS M Y H:i").' ('.$this->lang->line("Day").'-'.$subscriber_data['messenger_bot_drip_last_completed_day'].')</small>';
            // }
            $sequence_block='
        <br>
        <div class="section">
          <div class="section-title mt-0 mb-2">
            '.$this->lang->line("Message Sequence").'
            '.$last_sent_info.'                         
          </div>          
          '.$sequence_dropdwon.'
        </div>';
        }

        // optin block
        $show_only_fb = $social_media=='fb' ? 'd-block' : 'd-none';
        $optin_ref = '';
        $optin="DIRECT";
        $refferer_id = $subscriber_data['refferer_id'];
        if($subscriber_data['refferer_uri']!='') $refferer_id='<a href="'.$subscriber_data['refferer_uri'].'" target="_BLANK">'.$refferer_id.'</a>';
        if($subscriber_data['refferer_source']!='') $optin = str_replace('_', ' ', $subscriber_data['refferer_source']);
        if($subscriber_data['refferer_id']!='') $optin_ref='<span style="padding-left:45px;"><b>Refference : </b>'.$refferer_id.'</span>';
        $optinpop="";
        if($optin=='FB PAGE') $optin="DIRECT";
        if($optin=='DIRECT')
            $optinpop='<a href="#" data-placement="top" data-toggle="popover" data-trigger="focus" title="" data-content="'.$this->lang->line("Direct OPT-IN means the subscriber either came from your Facebook page directly or the source is unknown.").'" data-original-title="'.$this->lang->line("OPT-IN").'"><i class="fa fa-info-circle"></i> </a>';

        $print_name = ($subscriber_data['full_name']!="")?$subscriber_data['full_name']:$subscriber_data['first_name']." ".$subscriber_data['last_name'];
        if($subscriber_data['link']!="") $print_name_link = '<h4><a href="https://facebook.com/'.$subscriber_data['link'].'" target="_BLANK">'.$print_name.'</a></h4>';
        else $print_name_link = '<h4>'.$print_name.'</h4>';

        $collef_class = $call_from_conversation=='1' ? 'corder-last' : '';
        $colmid_class = $call_from_conversation=='1' ? 'order-first' : '';
        $start_row = $call_from_conversation=='1' ? '<div class="">' : '';
        $end_row = $call_from_conversation=='1' ? '</div>' : '';
        $subscriber_image_html = '<div class="pt-4"></div>';
        if($call_from_conversation=='0')
        {
            $subscriber_image_html = '
         <div class="padding-20">
            <span class="bgimage" style="background-image: url('.$subscriber_image.');"></span>
         </div>';
        }

        $mid_col_body = '
      <div class="section">
        <div class="section-title mt-0 mb-2">
          '.$this->lang->line("Labels").'
          <a class="blue float-right pointer" data-id="'.$subscriber_data['id'].'" data-social-media="'.$subscriber_data['social_media'].'"  data-page-id="'.$subscriber_data['page_table_id'].'" id="create_label"><small><i class="fas fa-plus-circle"></i> '.$this->lang->line("Create Label").'</small></a>                              
        </div>                            
        <div id="subscriber_labels_container">'.$label_dropdown.'</div>
      </div>

      '.$sequence_block.'

      <br>
      <div class="section '.$show_only_fb.'">
        <div class="section-title mt-0 mb-2">
          '.$this->lang->line("OPT-IN Through").'    
          <span class="float-right text blue">'.$optin.' '.$optinpop.'</span>
        </div>
        '.$optin_ref.'  
      </div>';

        $close_button_class = ($call_from_conversation=='1') ? 'd-none' : '';
        $save_button_class = ($call_from_conversation=='1') ? 'float-right' : '';

        // if($call_from_conversation=='1')
        // {
        //    $middle_column_content =
        //    '<div class="'.$colmid_class.' colmid" id="middle_column" style="padding:1rem 2rem 0 2rem;">'.
        //     $mid_col_body.'<a class="btn btn-primary float-left mt-4" href="" data-social-media="'.$subscriber_data['social_media'].'" data-subscribe-id="'.$subscriber_data['subscribe_id'].'" data-id="'.$subscriber_data['id'].'" data-page-id="'.$subscriber_data['page_table_id'].'" id="save_changes"><i class="fas fa-save"></i> '.$this->lang->line("Save Changes").'</a>
        //    </div>';
        // }
        // else
        // {
        $middle_column_content = '
        <div class="'.$colmid_class.' colmid" id="middle_column">
            <div class="">
              <div class=""  style="display: block;padding-top:25px;">                            
                  <div class="dropleft float-right">
                    <a href="#" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v" style="font-size:25px"></i></a>
                    <div class="dropdown-menu">
                      <div class="dropdown-title">'.$this->lang->line("Options").'</div>                        
                      <!--'.$start_stop.'-->
                      '.$user_input_start_stop.'
                      <a href="" class="dropdown-item has-icon update_user_details"  social_media="'.$subscriber_data['social_media'].'"  button_id ="'.$subscriber_data['id']."-".$subscriber_data['subscribe_id']."-".$subscriber_data['page_table_id'].'"><i class="fas fa-sync-alt"></i> '.$this->lang->line("Sync Subscriber Data").'</a>
                      <div class="dropdown-divider"></div>
                      <a href="" class="dropdown-item has-icon red delete_user_details" social_media="'.$subscriber_data['social_media'].'" button_id ="'.$subscriber_data['id']."-".$subscriber_data['page_table_id'].'"><i class="fas fa-trash"></i> '.$this->lang->line("Delete Subscriber Data").'</a>
                    </div>
                  </div>
                 '.$print_name_link.'
              </div>
              <div class="">
                '.$mid_col_body.'
              </div>

              <div class="">
                <a class="btn btn-primary float-left '.$save_button_class.'" href="" data-social-media="'.$subscriber_data['social_media'].'" data-subscribe-id="'.$subscriber_data['subscribe_id'].'" data-id="'.$subscriber_data['id'].'" data-page-id="'.$subscriber_data['page_table_id'].'" id="save_changes"><i class="fas fa-save"></i> '.$this->lang->line("Save Changes").'</a>
                <a class="btn btn-outline-secondary float-right '.$close_button_class.'" data-dismiss="modal"><i class="fas fa-times"></i> '.$this->lang->line("Close").'</a>
              </div>

            </div>               
        </div>';

        // }

        echo $start_row . $middle_column_content.'
          <div class="'.$collef_class.' collef">
            <div class="">
              <div class="padding-0">
                '.$subscriber_image_html.' 
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <i class="fas fa-check-circle subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Status').'"></i>
                    '.$status.'                    
                  </li> 
                  <li class="list-group-item">
                    <i class="fas fa-robot subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Bot Status').'"></i>
                    '.$start_stop2.'                    
                  </li>                  
                  <li class="list-group-item"><i class="fas fa-id-card subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Subscriber ID').'"></i> '.$subscribe_id.'</li>                  
                  ';

        if(!empty($subscriber_data['gender'])) echo '<li class="list-group-item"><i class="fas fa-mars subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Gender').'"></i> '.ucfirst($subscriber_data['gender']).'</li>';
        if(!empty($locale)) echo '<li class="list-group-item"><i class="fas fa-language subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Language').'"></i> '.$locale.'</li>';
        if(!empty($timezone)) echo '<li class="list-group-item"><i class="fas fa-globe subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Timezone').'"></i> '.$timezone.'</li>';

        $last_update_time = "-";
        $phone_number_entry_time = "-";
        $birthdate_entry_time ="-";
        $last_subscriber_interaction_time = ($subscriber_data['last_subscriber_interaction_time']=='0000-00-00 00:00:00') ? "-" : date('jS M Y g:i a', strtotime($subscriber_data['last_subscriber_interaction_time']));

        if($subscriber_data['email']!='')
            echo
                '<li class="list-group-item"><i class="fas fa-envelope subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Email').' - '.$this->lang->line("Last Updated").' : '.$last_update_time.'"></i>'.$subscriber_data['email'].'</li>';

        if($subscriber_data['phone_number']!='')
            echo
                '<li class="list-group-item"><i class="fas fa-phone subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Phone').' - '.$this->lang->line("Last Updated").' : '.$phone_number_entry_time.'"></i>'.$subscriber_data['phone_number'].'</li>';

        if($subscriber_data['user_location']!='')
        {
            $tmp = json_decode($subscriber_data['user_location'],true);
            if(is_array($tmp))
            {
                $country_names = $this->get_country_names();
                $user_country = isset($tmp['country']) ? $tmp['country'] : "";
                $country_name = isset($country_names[$user_country]) ? ucwords(strtolower($country_names[$user_country])) : $user_country;
                $tmp["country"] = $country_name;
                $user_loc = implode(', ', $tmp);
            }
            else $user_loc = "";
            echo
                '<li class="list-group-item"><i class="fas fa-map-marker subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Location').'"></i>'.$user_loc.'</li>';
        }

        if($subscriber_data['birthdate']!='0000-00-00')
            echo
                '<li class="list-group-item"><i class="fas fa-birthday-cake subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line('Birthday').' - '.$this->lang->line("Last Updated").' : '.$birthdate_entry_time.'"></i>'.date('jS M Y', strtotime($subscriber_data['birthdate'])).'</li>';

        if($subscriber_data['last_subscriber_interaction_time']!='0000-00-00 00:00:00')
            echo
                '<li class="list-group-item"><i class="far fa-clock subscriber_details blue" data-toggle="tooltip" title="'.$this->lang->line("Last Interacted at").'"></i>'.$last_subscriber_interaction_time.'</li>';

        echo
            '</ul>
                
              </div>
            </div>          
          </div>


          
          '.$end_row.'

          <script>
          $("#subscriber_labels").select2({
              placeholder: "'.$this->lang->line('Choose Label').'",
              allowClear: true
          });

          $("#assign_campaign_id").select2({
               placeholder: "'.$this->lang->line('Choose Sequence').'",
              allowClear: true
          });
          $(\'[data-toggle="popover"]\').popover(); 
          $(\'[data-toggle="popover"]\').on("click", function(e) {e.preventDefault(); return true;});
          $(\'[data-toggle="tooltip"]\').tooltip({placement: "bottom"});
          </script>';


    }
   

////////////////////////////////////////////////////////
////////// Instagram functions  ////////////////////////
////////////////////////////////////////////////////////


    public function instagram_message_dashboard()
    {  
        if($this->session->userdata('selected_global_media_type') == 'fb') {
            redirect('message_manager/message_dashboard');
        }

        $page_table_id = '';
        if($this->session->userdata('selected_global_page_table_id') != '') {
            $page_table_id = $this->session->userdata('selected_global_page_table_id');
        }

        $page_info = $this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("facebook_rx_fb_user_info_id"=>$this->session->userdata('facebook_rx_fb_user_info'),'bot_enabled'=>'1','has_instagram'=>'1')),array('page_name','id','bot_enabled','has_instagram','insta_username'));
        
        $data['page_info'] = $page_info;

        if($page_table_id == '') $page_table_id = isset($page_info[0]['id']) ? $page_info[0]['id']:0;

        $page_data = $this->basic->get_data("facebook_rx_fb_page_info",array("where"=>array("id"=>$page_table_id)),"page_name,insta_username,page_id");
        // if(!isset($page_data[0])) exit();

        $insta_username = $page_data[0]['insta_username'] ?? '';

        $data['page_name'] =  "<a href='https://instagram.com/".$insta_username."'>".$insta_username."</a>";

        $data['body'] = 'message_manager/instagram_message_dashboard';
        $data['page_title'] = $insta_username.' - '.$this->lang->line('Instagram Live Chat');
        $data['page_table_id'] = $page_table_id;        
        $data['tag_list'] = $this->get_broadcast_tags('ig');
        $data['postback_list'] = $page_table_id>0 ? $this->get_dropdown_postback($page_table_id,'ig') : [];
        $this->_viewcontroller($data);
    }

    public function get_pages_conversation_instagram()
    {
        $this->ajax_check();
        $page_table_id = $this->input->post('page_table_id',true);
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info'),
            'bot_enabled' => '1',
            'id' => $page_table_id
            );
        $select = array('id','page_name','page_profile','page_id as fb_page_id');
        $page_list = $this->basic->get_data('facebook_rx_fb_page_info',$where,$select,'','','', $order_by='page_name asc');

        if(empty($page_list))
        {
            echo '<br><div class="alert alert-danger text-center w-100"><b class="m-0">'.$this->lang->line("You do not have any bot enabled page").'</b></div>';
            exit();
        }

        $user_info = $this->basic->get_data('users',array('where'=>array('id'=>$this->user_id)));
        if(isset($user_info[0]['time_zone']) && $user_info[0]['time_zone'] != '')
            date_default_timezone_set($user_info[0]['time_zone']);

        $response= $this->messenger_sync_page_messages_new($page_table_id,"ig");


        if(isset($response['error']))
        {
            echo '<br><div class="alert alert-danger text-center w-100"><b class="m-0">'.$response['error_message'].'</b></div>';
            exit();
        }
        else echo $response;       
        
    }

    public function get_post_conversation_instagram()
    {
        $this->ajax_check();

        // for time zone checking
        $where = array();
        $where['where'] = array(
            'user_id' => $this->user_id,
            'facebook_rx_fb_user_info_id' => $this->session->userdata('facebook_rx_fb_user_info')
            );
       

        $from_user_id = $this->input->post('from_user_id',true);
        $thread_id = $this->input->post('thread_id',true);
        $page_table_id = $this->input->post('page_table_id',true);
        $last_message_id = $this->input->post('last_message_id',true);

        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)));

        $post_access_token = $page_info[0]['page_access_token'];
        $page_name = $page_info[0]['page_name'];

        $conversations = $this->fb_rx_login->get_messages_from_thread_instagram($thread_id,$post_access_token);     
        if(!isset($conversations['data'])) $conversations['data']=array();
        $conversations['data'] = array_reverse($conversations['data']);

        // pre($conversations['data']);

        $show_after_this_index = NULL;
        if(!empty($last_message_id))
        foreach($conversations['data'] as $key=>$value)
        {
            if($value['id']==$last_message_id) {
                $show_after_this_index = $key;
                break;
            }
        }

        $str = '';

        // echo "<pre>";
        // print_r($conversations['data']);
        // return false;

        foreach($conversations['data'] as $key=>$value)
        {
            if(!is_null($show_after_this_index) && $key<=$show_after_this_index) continue;

            $temp_from_user_id = isset($value['from']['id']) ? $value['from']['id'] :'';
            $temp_from_user_name = isset($value['from']['username']) ? $value['from']['username'] :'';
            $position_class = $from_user_id!=$temp_from_user_id ? "" : "chat-left";
            $thumbnail = $from_user_id!=$temp_from_user_id ? base_url('assets/img/icon/instagram.png') : base_url('assets/img/avatar/avatar-1.png');

            $created_time = $value['created_time']." UTC";

            $message = '';

            if(isset($value['message']) && !empty($value['message'])) $message = '<div class="chat-text">'.$value["message"].'</div>';
            if(isset($value['is_unsupported']) && $value['is_unsupported']=='1') $message = '<div class="chat-text text-muted">'.$this->lang->line('Message not supported').'</div>';
 
            $attachments='';
            if(isset($value['attachments']['data'][0]))
            {                
                if(isset($value['attachments']['data'][0]['image_data']))
                {
                     $image_url = isset($value['attachments']['data'][0]['image_data']['url']) ? $value['attachments']['data'][0]['image_data']['url'] : '';
                     $attachments .= '<img class="img-thumbnail img-fluid d-block" style="max-width:300px;" src="'.$image_url.'">';
                }
                else if(isset($value['attachments']['data'][0]['video_data']))
                {
                     $image_url = isset($value['attachments']['data'][0]['video_data']['url']) ? $value['attachments']['data'][0]['video_data']['url'] : '';
                     $attachments .= '
                     <video width="300" height="" src="'.$image_url.'" onClick=\'openTab("'.$image_url.'")\'></video>';
                }
                
            }

            if(isset($value['story']['mention']['link']))
            {
                $attachments = '';
                $attachments .= '<span class="chat-time" style="font-size: 12px !important;">'.$this->lang->line('Mentioned you in their story').'</span><br/>';
                if($value['story']['mention']['link'] != '')
                {
                    $attachments .= '<img onerror="img_video_error(this)" class="img-thumbnail img-fluid d-block" style="max-width:300px;" src="'.$value['story']['mention']['link'].'" onClick=\'openTab("'.$value['story']['mention']['link'].'")\'>';

                    $attachments .= '<video onerror="img_video_error(this)" width="300" height="" src="'.$value['story']['mention']['link'].'" onClick=\'openTab("'.$value['story']['mention']['link'].'")\'></video>';
                }
                else
                    $attachments .= '<div><i>'.$this->lang->line('Resource has expired').'</i></div>';
            }

            $str.='
                 <div class="chat '.$position_class.'" key="'.$key.'" message_id="'.$value['id'].'">
                                <div class="chat-avatar">
                                   <a class="avatar m-0 bg-info"><span class="avatar-content">'.$this->getInitials($temp_from_user_name).'</span></a>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-message" message_id="'.$value['id'].'">
                                        <p>
                                            '.$message.'
                                            '.$attachments.'
                                        </p>
                                        <span class="chat-time">'.date('d M Y H:i:s',strtotime($created_time)).'</span>
                                    </div>
                                   
                                </div>
                            </div>';
        }
        echo $str;
    }

    public function reply_to_conversation_instagram()
    {
        if($this->is_demo == '1')
        {
            echo "<div class='alert alert-danger text-center'>This feature is disabled in this demo.</div>"; 
            exit();
        }

        $from_user_id = $this->input->post('from_user_id',true);
        $page_table_id = $this->input->post('page_table_id',true);
        $reply_message = $this->input->post('reply_message',true);
        $message_tag = $this->input->post('message_tag',true);
        if($message_tag=="") $message_tag = "HUMAN_AGENT";


        $page_info = $this->basic->get_data('facebook_rx_fb_page_info',array('where'=>array('id'=>$page_table_id)));
        $post_access_token = $page_info[0]['page_access_token'] ?? '';


        $message = array
        (
            'recipient' =>array('id'=>$from_user_id),
            'message'=>array('text'=>$reply_message),
            'tag'=>$message_tag
        );
        $message = json_encode($message);

        try
        {            
            $response = $this->fb_rx_login->send_non_promotional_message_subscription($message,$post_access_token);
           
            if(isset($response['message_id']))
            {
                echo
                '<div class="chat-item chat-right" style="">
                     <div class="chat-details mr-0 ml-0" message_id="'.$response['message_id'].'">
                        <div class="chat-text">'.$reply_message.'</div>
                        <div class="chat-time">'.date('d M Y H:i:s').'</div>
                     </div>
                </div>';
            }
            else 
            {
                if(isset($response["error"]["message"])) $message_sent_id = $response["error"]["message"];  
                if(isset($response["error"]["code"])) $message_error_code = $response["error"]["code"]; 

                if(isset($message_error_code) && $message_error_code=="368") // if facebook marked message as spam 
                {
                    $error_msg=$message_sent_id;
                }

                $error_msg = $message_sent_id;
                echo "<div class='alert alert-danger text-center'>".$error_msg."</div>";

            } 
        }
        catch(Exception $e) 
        {
          echo "<div class='alert alert-danger text-center'>".$e->getMessage()."</div>";
        }
    }

    private function getInitials($string = null) {
        return array_reduce(
            explode(' ', $string),
            function ($initials, $word) {
                $str = strtoupper(sprintf('%s%s', $initials, substr($word, 0, 1)));
                $str = mb_convert_encoding($str, "UTF-8", "UTF-8");
                return $str;
            },
            ''
        );
    }




}