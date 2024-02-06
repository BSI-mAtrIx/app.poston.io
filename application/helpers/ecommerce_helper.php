<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('mec_display_price'))
{
  function mec_display_price($original_price=0, $sell_price=0, $currency_icon = '$',$retun_type='1',$currency_position='left',$decimal_point=0,$thousand_comma='0') //$retun_type=1 means price overthrough, $retun_type=2 means purchase price, $retun_type=3 means disount, $retun_type=4 menas discount formatted
  {
    $ci = &get_instance();

    $currency_left = $currency_right = "";
    if($currency_position=='left') $currency_left = $currency_icon;
    if($currency_position=='right') $currency_right = $currency_icon;

    if($retun_type=='1')
    {
      if($sell_price>0 && ($sell_price<$original_price)) 
      {
        $return = "<span class='text-light' style='text-decoration:line-through'>".$currency_left.mec_number_format($original_price,$decimal_point,$thousand_comma).$currency_right."</span> <span class='price price_tag'><span class='text-white price'>".$currency_left.mec_number_format($sell_price,$decimal_point,$thousand_comma).$currency_right."</span></span>";
      }
      else $return = $currency_left.mec_number_format($original_price,$decimal_point,$thousand_comma).$currency_right;
    }
    else if($retun_type=='2')
    {
      if($sell_price>0 && ($sell_price<$original_price)) 
      {
        $return = mec_number_format($sell_price,$decimal_point,$thousand_comma);
      }
      else $return = mec_number_format($original_price,$decimal_point,$thousand_comma);
    }
    else
    {
      $disocunt = 0;
      if($sell_price>0 && ($sell_price<$original_price)) 
      {
        $disocunt = round((($original_price-$sell_price)/$original_price)*100);
        
        if($retun_type==4) $return = '<div class="yith-wcbsl-badge-wrapper yith-wcbsl-mini-badge"> <div class="yith-wcbsl-badge-content">-'.$disocunt.'% '.$ci->lang->line("Off").'</div></div>';
        else $return = $disocunt;
      }
      else
      {
        if($retun_type==4) $return = '';
        else $return = 0;
      }

    }

    return $return;
  }
}
if ( ! function_exists('mec_attribute_map'))
{
  function mec_attribute_map($attribute_array=array(),$attribute_str='',$retun_type='string') // makes comma seperated attributes as name string (1,2 = Color,Size)
  {
    $explode = explode(',', $attribute_str);

    $output = array();
    foreach ($explode as $value) 
    {
      if(isset($attribute_array[$value])) $output[] = $attribute_array[$value];
    }
    if($retun_type=='string') return ucfirst(strtolower(implode(' , ', $output)));
    else return $output;
  }
}

if ( ! function_exists('mec_number_format'))
{
  function mec_number_format($number,$decimal_point=0,$thousand_comma='0')
  {
      $decimal_point_count = strlen(substr(strrchr($number, "."), 1));
      if($decimal_point_count>0 && $decimal_point==0) $decimal_point = $decimal_point_count; // if setup no deciaml place but the number is naturally float, we can not just skip it

      if($decimal_point>2) $decimal_point=2;

      $number = (float)$number;
      $comma = $thousand_comma=='1' ? ',' : '';
      return number_format($number, $decimal_point,'.',$comma);
  }
}

if ( ! function_exists('mec_add_get_param'))
{
  function mec_add_get_param($url="",$param=array())
  {
    if($url=="") return "";
    if(empty($param)) return $url; 
    $final_url = $url;
    foreach ($param as $key => $value)
    {
       if($key=="" || $value=="") continue;
       if(strpos($final_url, '?') !== false) $final_url.="&".$key."=".$value;
       else $final_url.="?".$key."=".$value;
    }
    return $final_url;
  }
}


if ( ! function_exists('mec_header'))
{
 function mec_header($store_data=array(),$subscriber_id='',$current_cart=array(),$ecommerce_config=array())
  {
    $ci = &get_instance();
    $pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';
    $current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
    $cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
    $current_cart_url = base_url("ecommerce/cart/".$current_cart_id);
    $current_cart_url = mec_add_get_param($current_cart_url,array("subscriber_id"=>$subscriber_id,"pickup"=>$pickup));
    $provider_mapping = base_url("ecommerce/store/".$store_data['store_unique_id']);
    $provider_mapping = mec_add_get_param($provider_mapping,array("subscriber_id"=>$subscriber_id,"pickup"=>$pickup));  
    $href=$terms=$refund='';    
    if($subscriber_id!="" && $current_cart_id!=0) $href = 'href="'.$current_cart_url.'"';
    $store_id = isset($store_data['store_id']) ? $store_data['store_id'] : $store_data['id'];
    $hide_add_to_cart = isset($ecommerce_config['hide_add_to_cart']) ? $ecommerce_config['hide_add_to_cart'] : '0';
    $hide_buy_now = isset($ecommerce_config['hide_buy_now']) ? $ecommerce_config['hide_buy_now'] : '0';
    
    $purchase_off = $hide_add_to_cart=='1' && $hide_buy_now =='1' ? true : false;
    
    $my_orders_link = base_url("ecommerce/my_orders/".$store_id);
    $my_orders_link = mec_add_get_param($my_orders_link,array("subscriber_id"=>$subscriber_id,"pickup"=>$pickup));
    
    if($ci->session->userdata($store_id."ecom_session_subscriber_id")!='')
    $logout_menu  = '<a href="" class="pointer" id="logout"><i class="feather icon-power"></i> '.$ci->lang->line("Logout").'</a>';


    $store_link = base_url("ecommerce/store/".$store_data['store_unique_id']);
    if($subscriber_id!='') $store_link.='?subscriber_id='.$subscriber_id;
    $store_name_logo = ($store_data['store_logo']!='') ? '<img alt="'.$store_data['store_name'].'" height="60" width="60" class="round"  src="'.base_url("upload/ecommerce/".$store_data['store_logo']).'">' : '';
    $first_menu = !empty($store_name_logo) ? '
     <a class="notification-toggle nav-link dropdown-user-link nav-link-user" href="#" data-toggle="dropdown">
                                      <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">
                                    '.$store_data['store_name'].'</span><span class="user-status">'.$ci->lang->line("Available").'</span></div> 
                                    <span class="avatar avatar-xl">'.$store_name_logo.'</span></a>  
    
    ' : '';

    $my_orders_menu = $more_menu = '';
    $login_menu  = '
     <ul class="nav navbar-nav mobile-show">
                            <li class="nav-item mobile-menu d-xl-none mr-auto user">
                            <a class="nav-link menu-toggle" id="login_form" data-toggle="tooltip" data-placement="top" title="" data-original-title="Login">
                                    <i class="ficon feather icon-user"></i></a>    
                            
                            </li>
                        </ul>
      <ul class="nav navbar-nav ">
                            <li class="nav-item">
                            <a class="nav-link menu-toggle" id="login_form" data-toggle="tooltip" data-placement="top" title="" data-original-title="Login">
                                    <i class="ficon feather icon-user"></i></a>  
                            
                            </li>
                            </ul>
    ';

    if($subscriber_id!="")
    {
      if(!$purchase_off)
      {
      $my_orders_menu = '
      <li class="nav-item "><a class="dropdown-user-link nav-link" href="'.$my_orders_link.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="My Orders"><i class="ficon feather icon-package"></i></a></li>
      ';
      
       
      $more_menu = '
      <ul class="nav navbar-nav">
        <li class="dropdown dropdown-user nav-item user" >
            <a class="notification-toggle nav-link dropdown-user-link nav-link-user menu-toggle" href="#" data-toggle="dropdown">
                                     <i class="ficon feather icon-user"></i>
                                    
                                    </a>                     
       <div class="dropdown-menu dropdown-menu-right">
                                <a id="showProfile" class="dropdown-item" href=""><i class="feather icon-user"></i> '.$ci->lang->line("Edit profile").'</a>
                                   <a id="showAddress" class="dropdown-item" href=""><i class="fas fa-truck"></i>'.$ci->lang->line("Delivery Address").' </a>
                               
                                <div class="dropdown-divider"></div>
                                <a href="" class="dropdown-item pointer" id="logout"><i class="feather icon-power"></i> '.$ci->lang->line("Logout").'</a>
                                </div> 
                                </li>
            </ul>
      ';
      $login_menu = '';
    }
 }
 $hide_cart = $purchase_off ? 'd-none' : '';
    $ret =  '
    <nav class="bg-primary header-navbar navbar-expand-lg navbar navbar-with-menu navbar-light navbar-shadow d-none d-lg-block">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
       
        <div class="mr-auto float-left d-flex align-items-center">
                        <ul class="nav navbar-nav mobile-show">
                            <li  class="nav-item mobile-menu d-xl-none mr-auto">
                            <a class="nav-link dropdown-user-link nav-menu-main menu-toggle hidden-xs" href="'.$store_link.'">
                            <span class="avatar avatar-xl">'.$store_name_logo.'</span>
                             <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">
                                    '.$store_data['store_name'].'</span><span class="user-status">Available</span></div> 
                            </a>
                            
                            </li>
                        </ul>
                        <ul class="nav navbar-nav ">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link dropdown-user-link" href="'.$store_link.'" data-toggle="tooltip" data-placement="top" title="Home">
                             <span class="avatar avatar-xl">'.$store_name_logo.'</span>
                             <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">
                                    '.$store_data['store_name'].'</span><span class="user-status">Available</span></div> 
                            </a>
                            
                            </li>
                            <li class="dropdown dropdown-notification nav-item '.$hide_cart.'">
                            <a class="nav-link nav-link-label" '.$href.'>
                            <span><i class="ficon feather icon-shopping-cart"></i><span id="cart_count_display" class="badge badge-pill badge-primary badge-up cart-item-count">'.$cart_count.'</span></span></a>
                           
                        </li>
                        <li class="nav-item "><a class="nav-link nav-link-label nav-link-style"><i class="ficon feather icon-moon"></i> <i class="ficon feather icon-sun" style="display: none"></i></a></li>  
                            </ul>
                    </div>
                    <div class="float-right bookmark-wrapper d-flex align-items-right">
                    <div class="nav navbar-nav  bookmark-icons">
                       <ul class="nav navbar-nav ">
                        '.$my_orders_menu.'
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" id="showAddress" href="#" data-toggle="tooltip" data-placement="top" title="Delivery Address"><i class="ficon fa fa-truck"></i></a></li>
                        
                        </ul>
                        '.$more_menu.'
                        '.$login_menu.'
                        
                    </div>
                    </div>
            </div>
            </div>
        </div>
    </nav>';

    return $ret;
      
  }
}

if ( ! function_exists('mec_header_mobile'))
{
 function mec_header_mobile($store_data=array(),$subscriber_id='',$current_cart=array(),$ecommerce_config=array())
  {
    $ci = &get_instance();
    $pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';
    $current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
    $cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
    $current_cart_url = base_url("ecommerce/cart/".$current_cart_id);
    $current_cart_url = mec_add_get_param($current_cart_url,array("subscriber_id"=>$subscriber_id,"pickup"=>$pickup));
    $provider_mapping = base_url("ecommerce/store/".$store_data['store_unique_id']);
    $provider_mapping = mec_add_get_param($provider_mapping,array("subscriber_id"=>$subscriber_id,"pickup"=>$pickup));  
    $href=$terms=$refund='';    
    if($subscriber_id!="" && $current_cart_id!=0) $href = 'href="'.$current_cart_url.'"';
    $store_id = isset($store_data['store_id']) ? $store_data['store_id'] : $store_data['id'];
    $hide_add_to_cart = isset($ecommerce_config['hide_add_to_cart']) ? $ecommerce_config['hide_add_to_cart'] : '0';
    $hide_buy_now = isset($ecommerce_config['hide_buy_now']) ? $ecommerce_config['hide_buy_now'] : '0';
    
    $purchase_off = $hide_add_to_cart=='1' && $hide_buy_now =='1' ? true : false;
    
    $my_orders_link = base_url("ecommerce/my_orders/".$store_id);
    $my_orders_link = mec_add_get_param($my_orders_link,array("subscriber_id"=>$subscriber_id,"pickup"=>$pickup));
    
    if($ci->session->userdata($store_id."ecom_session_subscriber_id")!='')
    $logout_menu  = '<a href="" class="pointer" id="logout"><i class="feather icon-power"></i> '.$ci->lang->line("Logout").'</a>';


    $store_link = base_url("ecommerce/store/".$store_data['store_unique_id']);
    if($subscriber_id!='') $store_link.='?subscriber_id='.$subscriber_id;
    $store_name_logo = ($store_data['store_logo']!='') ? '<img alt="'.$store_data['store_name'].'" height="60" width="60" class="round"  src="'.base_url("upload/ecommerce/".$store_data['store_logo']).'">' : '';
    $first_menu = !empty($store_name_logo) ? '
     <a class="notification-toggle nav-link dropdown-user-link nav-link-user" href="#" data-toggle="dropdown">
                                      <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">
                                    '.$store_data['store_name'].'</span><span class="user-status">'.$ci->lang->line("Available").'</span></div> 
                                    <span class="avatar avatar-xl">'.$store_name_logo.'</span></a>  
    
    ' : '';

    $ret =  '
    <nav class="bg-primary shadow navbar-light navbar-shadow text-center header-navbar navbar-expand-mobile navbar navbar-with-menu mobile-show">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
       
                  <div class="align-items-center">
                        <ul class="nav navbar-nav" style="margin-left: -25px">
                            <li  class="nav-item mobile-menu d-xl-none mr-auto">
                            <a class="nav-link dropdown-user-link nav-menu-main menu-toggle " href="'.$store_link.'">
                            <span class="avatar avatar-xl">'.$store_name_logo.'</span>
                             <div class="ml-2 user-nav d-sm-flex d-xl-none"><span class="user-name text-bold-600">
                                    '.$store_data['store_name'].'</span><span class="user-status">Available</span></div> 
                            </a>
                            </li>
                            <li  class="nav-item mobile-menu d-xl-none float-rigt">
                            <a class="mr-2 nav-link nav-link-label nav-link-style"><i class="ficon feather icon-moon"></i> <i class="ficon feather icon-sun" style="display: none"></i></a>
          
                            </li>
                        </ul>
                   </div>  
                </div>
            </div>
        </div>
    </nav>';

    return $ret;   
  }
}


if ( ! function_exists('mec_new_fixfooter'))
{
 function mec_new_fixfooter($store_data=array(),$subscriber_id='',$current_cart=array(),$ecommerce_config=array())
  {
    $ci = &get_instance();
    $pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';
    $current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
    $cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
    $current_cart_url = base_url("ecommerce/cart/".$current_cart_id);
    $current_cart_url = mec_add_get_param($current_cart_url,array("subscriber_id"=>$subscriber_id,"pickup"=>$pickup));
    $provider_mapping = base_url("ecommerce/store/".$store_data['store_unique_id']);
    $provider_mapping = mec_add_get_param($provider_mapping,array("subscriber_id"=>$subscriber_id,"pickup"=>$pickup));  
    $fhref=$terms=$refund='';    
    if($subscriber_id!="" && $current_cart_id!=0) $fhref = 'href="'.$current_cart_url.'"';
  
    $store_id = isset($store_data['store_id']) ? $store_data['store_id'] : $store_data['id'];
    $hide_add_to_cart = isset($ecommerce_config['hide_add_to_cart']) ? $ecommerce_config['hide_add_to_cart'] : '0';
    $hide_buy_now = isset($ecommerce_config['hide_buy_now']) ? $ecommerce_config['hide_buy_now'] : '0';
    
    $purchase_off = $hide_add_to_cart=='1' && $hide_buy_now =='1' ? true : false;
    
    $my_orders_link = base_url("ecommerce/my_orders/".$store_id);
    $my_orders_link = mec_add_get_param($my_orders_link,array("subscriber_id"=>$subscriber_id,"pickup"=>$pickup));
    
    if($ci->session->userdata($store_id."ecom_session_subscriber_id")!='')
    $logout_menu  = '<a href="" class="pointer" id="logout"><i class="feather icon-power"></i> '.$ci->lang->line("Logout").'</a>';


    $store_link = base_url("ecommerce/store/".$store_data['store_unique_id']);
    if($subscriber_id!='') $store_link.='?subscriber_id='.$subscriber_id;
    $store_name_logo = ($store_data['store_logo']!='') ? '<img alt="'.$store_data['store_name'].'" height="60" width="60" class="round"  src="'.base_url("upload/ecommerce/".$store_data['store_logo']).'">' : '';
    $first_menu = !empty($store_name_logo) ? '
     <a class="notification-toggle nav-link dropdown-user-link nav-link-user" href="#" data-toggle="dropdown">
                                      <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">
                                    '.$store_data['store_name'].'</span><span class="user-status">'.$ci->lang->line("Available").'</span></div> 
                                    <span class="avatar avatar-xl">'.$store_name_logo.'</span></a>  
    
    ' : '';

    $my_orders_menu = $more_menu = '';
    $login_menu  = '
     <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto user">
                            <a class="nav-link menu-toggle" id="login_form" data-toggle="tooltip" data-placement="top" title="" data-original-title="Login">
                                    <i class="ficon feather icon-user"></i></a>    
                            
                            </li>
                        </ul>
      <ul class="nav navbar-nav mobile-show">
                            <li class="nav-item">
                            <a class="nav-link menu-toggle" id="login_form" data-toggle="tooltip" data-placement="top" title="" data-original-title="Login">
                                    <i class="ficon feather icon-user"></i></a>  
                            
                            </li>
                            </ul>
    ';
    if($subscriber_id!="")
    {
      $my_orders_menu = '
      <li class="nav-item "><a class="dropdown-user-link nav-link" href="'.$my_orders_link.'" data-toggle="tooltip" data-placement="top" title="" data-original-title="My Orders"><i class="ficon feather icon-package"></i></a></li>
      ';
      
       
      $more_menu = '
      <ul class="nav navbar-nav">
        <li class="dropdown dropdown-user nav-item user" >
            <a class="notification-toggle nav-link dropdown-user-link nav-link-user menu-toggle" href="#" data-toggle="dropdown">
                                     <i class="ficon feather icon-user"></i>
                                    
                                    </a>                     
       <div class="dropdown-menu dropdown-menu-right">
                                <a id="showProfile" class="dropdown-item" href=""><i class="feather icon-user"></i> '.$ci->lang->line("Edit profile").'</a>
                                   <a id="showAddress" class="dropdown-item" href=""><i class="fas fa-truck"></i>'.$ci->lang->line("Delivery Address").' </a>
                               
                                <div class="dropdown-divider"></div>
                                <a href="" class="dropdown-item pointer" id="logout"><i class="feather icon-power"></i> '.$ci->lang->line("Logout").'</a>
                                </div> 
                                </li>
            </ul>
      ';
      $login_menu = '';
    }
$hide_cart = $purchase_off ? 'd-none' : '';
    $ret =  '
  <div class="bottom-appbar">
    <div class="tabs">
        <a class="tab tab1" href="'.$store_link.'">
          <i class="ficon feather icon-home"></i>
        <span>'.$ci->lang->line("Home").'</span>
      </a>
      <a href="'.$my_orders_link.'" class="tab tab--left">
          <i class="ficon fas fa-truck"></i>
		  <span>'.$ci->lang->line("Order").'</span>
      </a>
      <a class="tab tab--fab" href="'.$store_link.'">
        <div class="top">
          <div class="fab-logo avatar avatar-xl" style="margin: 0;"> '.$store_name_logo.'</div>
        </div>
      </a>
      
      <a class="tab tab--right" '.$fhref.'>
       <i class="ficon feather icon-shopping-cart"></i>
       <div style="font-size: 12px"> '.$ci->lang->line("Cart").'(<span id="fcart_count_display">'.$cart_count.'</span>)</div>
      </a>
    <a class="tab tab2" id="sidebarCollapse">
         <i class="ficon feather icon-user"></i>
        <span>'.$ci->lang->line("Account").'</span>
      </a>
    </div>
  </div>
  ';

    return $ret;
      
  }
}

if ( ! function_exists('mec_footer'))
{
  function mec_footer($store_data=array(),$subscriber_id='',$current_cart=array())
  {
    $ci = &get_instance();
    $current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
    $cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
    $current_cart_url = base_url("ecommerce/cart/".$current_cart_id); 
    if($subscriber_id!="") $current_cart_url = $current_cart_url."?subscriber_id=".$subscriber_id;
    $provider_mapping = base_url("ecommerce/store/".$store_data['store_unique_id']);
    if($subscriber_id!="") $provider_mapping .= "?subscriber_id=".$subscriber_id;   
    $href=$terms=$refund='';    
    if($subscriber_id!="" && $current_cart_id!=0) $href = 'href="'.$current_cart_url.'"';
    $store_id = isset($store_data['store_id']) ? $store_data['store_id'] : $store_data['id'];
    
    $my_orders_link = base_url("ecommerce/my_orders/".$store_id);
    if($subscriber_id!='') $my_orders_link.='?subscriber_id='.$subscriber_id; 
    
    $store_link = base_url("ecommerce/store/".$store_data['store_unique_id']);
    if($subscriber_id!='') $store_link.='?subscriber_id='.$subscriber_id;
    $store_name_logo = ($store_data['store_favicon']!='') ? '<img alt="'.$store_data['store_name'].'" class="rounded-circle" style="width:40px;height:40px;" src="'.base_url("upload/ecommerce/".$store_data['store_favicon']).'">' : '';
    $first_menu = !empty($store_name_logo) ? '<li class="breadcrumb-item"><a href="'.$store_link.'">'.$store_name_logo.'</a></li>' : '';

    $my_orders_menu = $more_menu = '';
    $login_menu  = '<li class="breadcrumb-item"><a href="" class="pointer" id="login_form"><i class="fas fa-sign-in-alt"></i> <div>'.$ci->lang->line("Login").'</div></a></li>';
    if($subscriber_id!="")
    {
      $my_orders_menu = '<li class="breadcrumb-item"><a href="'.$my_orders_link.'"><i class="fas fa-calendar-check"></i> <div>'.$ci->lang->line("My Orders").'</div></a></li>';
      $more_menu = '<li class="breadcrumb-item"><a class="text-primary pointer" id="sidebarCollapse"><i class="fas fa-bars"></i> <div>'.$ci->lang->line("More").'</div></a></li>';
      $login_menu = '';
    }

    $ret =  '
    <div class="footer-pc row col-12 text-center" style="padding: 40px">
                            <ul class=" col-12 text-dark">
                        <a style="margin: 0 10px;" class="text-dark" href="#" data-toggle="modal" data-target="#TermsModal"><i class="feather icon-shield"></i> '.$ci->lang->line("Term").' </a> 
                        <a  class="text-dark" href="#" data-toggle="modal" data-target="#RefundModal"><i class="feather icon-repeat"></i> '.$ci->lang->line("Refund").' </a> 
                        </ul>
                           <div class="col-12 section-header text-dark"> '.$ci->lang->line("Copyright").' 
            ©'.date('Y').' '.$store_data['store_name'].' . '.$ci->lang->line("All rights reserved").'  
  </div>  
                        
                        
                        </div>';

    return $ret;
      
  }
}


if ( ! function_exists('mec_sticky_footer'))
{
  function mec_sticky_footer($store_data=array(),$subscriber_id='',$current_cart=array())
  {
    $ci = &get_instance();
    $current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
    $cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
    $current_cart_url = base_url("ecommerce/cart/".$current_cart_id); 
    if($subscriber_id!="") $current_cart_url = $current_cart_url."?subscriber_id=".$subscriber_id;
    $provider_mapping = base_url("ecommerce/store/".$store_data['store_unique_id']);
    if($subscriber_id!="") $provider_mapping .= "?subscriber_id=".$subscriber_id;   
    $href=$terms=$refund='';    
    if($subscriber_id!="" && $current_cart_id!=0) $href = 'href="'.$current_cart_url.'"';
    $store_id = isset($store_data['store_id']) ? $store_data['store_id'] : $store_data['id'];
    
    $my_orders_link = base_url("ecommerce/my_orders/".$store_id);
    if($subscriber_id!='') $my_orders_link.='?subscriber_id='.$subscriber_id; 
    
    $store_link = base_url("ecommerce/store/".$store_data['store_unique_id']);
    if($subscriber_id!='') $store_link.='?subscriber_id='.$subscriber_id;
    $store_name_logo = ($store_data['store_favicon']!='') ? '<img alt="'.$store_data['store_name'].'" class="rounded-circle" style="width:40px;height:40px;" src="'.base_url("upload/ecommerce/".$store_data['store_favicon']).'">' : '';
    $first_menu = !empty($store_name_logo) ? '<li class="breadcrumb-item"><a href="'.$store_link.'">'.$store_name_logo.'</a></li>' : '';

    $my_orders_menu = $more_menu = '';
    $login_menu  = '<li class="breadcrumb-item"><a href="" class="pointer" id="login_form"><i class="fas fa-sign-in-alt"></i> <div>'.$ci->lang->line("Login").'</div></a></li>';
    if($subscriber_id!="")
    {
      $my_orders_menu = '<li class="breadcrumb-item"><a href="'.$my_orders_link.'"><i class="fas fa-calendar-check"></i> <div>'.$ci->lang->line("My Orders").'</div></a></li>';
      $more_menu = '<li class="breadcrumb-item"><a class="text-primary pointer" id="sidebarCollapse"><i class="fas fa-bars"></i> <div>'.$ci->lang->line("More").'</div></a></li>';
      $login_menu = '';
    }

    $ret =  '
    <div style="height: 80px"></div>
    <nav aria-label="breadcrumb" class="m-0 w-100 d-print-none" id="sticky-footer">
      <ol class="breadcrumb m-0 justify-content-center bg-white">
       '.$first_menu.'
        <li class="breadcrumb-item"><a href="'.$store_link.'" class="text-center"><i class="fas fa-home"></i> <div>'.$ci->lang->line("Home").'</div></a></li>
        '.$my_orders_menu.'
        <li class="breadcrumb-item"><a '.$href.'><i class="fas fa-shopping-cart"></i> <div>'.$ci->lang->line("Cart").' (<span id="cart_count_display">'.$cart_count.'</span>)</div></a></li>
        '.$more_menu.'
        '.$login_menu.'
      </ol>
    </nav>';

    return $ret;
      
  }
}

if ( ! function_exists('mec_sidebar'))
{
  function mec_sidebar($store_data=array(),$subscriber_id='',$current_cart=array())
  {
    $ci = &get_instance();
    $current_cart_id = isset($current_cart['cart_id']) ? $current_cart['cart_id'] : 0;
    $cart_count = isset($current_cart['cart_count']) ? $current_cart['cart_count'] : 0;
    $current_cart_url = base_url("ecommerce/cart/".$current_cart_id); 
    if($subscriber_id!="") $current_cart_url = $current_cart_url."?subscriber_id=".$subscriber_id;
    $provider_mapping = base_url("ecommerce/store/".$store_data['store_unique_id']);
    if($subscriber_id!="") $provider_mapping .= "?subscriber_id=".$subscriber_id;
    $footer_copyright = "<a href='".$provider_mapping."'>".$store_data['store_name']."</a>";
    $footer_terms_use_link = $store_data['terms_use_link'];
    $footer_refund_link = $store_data['refund_policy_link'];
    $href=$terms=$refund='';    
    if($subscriber_id!="" && $current_cart_id!=0) $href = 'href="'.$current_cart_url.'"';
    $store_id = isset($store_data['store_id']) ? $store_data['store_id'] : $store_data['id'];
    
    $my_orders_link = base_url("ecommerce/my_orders/".$store_id);
    if($subscriber_id!='') $my_orders_link.='?subscriber_id='.$subscriber_id; 

    $contact = '<a href="#" data-toggle="modal" data-target="#contactModal"><i class="fas fa-paper-plane"></i> '.$ci->lang->line("Contact").'</a>';
    
    if(isset($footer_terms_use_link) && !empty($footer_terms_use_link)) $terms = '<a class="text-dark" href="#" data-toggle="modal" data-target="#TermsModal">'.$ci->lang->line("Terms").'</a>';

    if(isset($footer_refund_link) && !empty($footer_refund_link)) $refund = '&nbsp;&nbsp;|&nbsp;&nbsp;<a class="text-dark" href="#" data-toggle="modal" data-target="#RefundModal">'.$ci->lang->line("Refund").'</a>';
    
    $store_link = base_url("ecommerce/store/".$store_data['store_unique_id']);
    if($subscriber_id!='') $store_link.='?subscriber_id='.$subscriber_id;
    $store_name_logo = ($store_data['store_logo']!='') ? '<img alt="'.$store_data['store_name'].'" class="avatar avatar-xl" style="width:80px;height:80px" src="'.base_url("upload/ecommerce/".$store_data['store_logo']).'">' : '';
    $first_menu = !empty($store_name_logo) ? '<a class="p-0" href="'.$store_link.'">'.$store_name_logo.'</a>' : $store_data['store_name'];

    $login_menu = $logout_menu = '';
    if($subscriber_id=="")
    $login_menu  = '<li class="list-group-item d-flex justify-content-between align-items-center"><a href="" class="pointer" id="login_form"><i class="ficon feather icon-user"></i>  '.$ci->lang->line("Login").'</a></li>';

    if($ci->session->userdata($store_id."ecom_session_subscriber_id")!='')
    $logout_menu  = '<li class="list-group-item d-flex justify-content-between align-items-center"><a href="" class="pointer" id="logout"><i class="feather icon-power"></i> '.$ci->lang->line("Logout").'</a></li>';

    $ret =  '

    <nav id="sidebar" class="nicescroll nobg-white">
        <div class="sidebar-header nobg-white">
        <a class="float-right nav-link nav-link-label nav-link-style"><i class="ficon feather icon-moon"></i> <i class="ficon feather icon-sun" style="display: none"></i></a>
           
            <h6 class="text-primary m-0 text-center" style="line-height:0">'.$first_menu.'</h6>            
        </div>

        <ul class="list-group list-group-flush m-0 mt-4 p-0">
            <li id="showProfile" class="list-group-item d-flex justify-content-between align-items-center"><a href="" class=""><i class="ficon feather icon-user"></i> '.$ci->lang->line("Profile").'</a></li>
            <li id="showAddress" data-close="0" class="list-group-item d-flex justify-content-between align-items-center"><a href="" class=""><i class="ficon feather icon-map"></i> '.$ci->lang->line("Delivery Address").'</a></li>
            <li class="list-group-item d-flex justify-content-between align-items-center"><a href="'.$my_orders_link.'" class=""><i class="ficon feather icon-package"></i> '.$ci->lang->line("My Orders").'</a></li>
            '.$login_menu.'
            '.$logout_menu.'
        </ul>

        <div class="pt-2 text-center"><span class="text-small text-dark"><i class="feather icon-shield"></i> '.$terms.'  <i class="feather icon-repeat"></i> '.$refund.'</span></div>                 
    <div class="pt-2 text-center"> '.$ci->lang->line("Copyright").' 
            ©'.date('Y').' '.$store_data['store_name'].' . '.$ci->lang->line("All rights reserved").'  
  </div>  
                        
   
    </nav>';

    return $ret;
      
  }
}


if ( ! function_exists('mec_display_rating_starts'))
{
  function mec_display_rating_starts($rating_point=0,$class='')
  {
    if($rating_point<1) return "";
    $ret="";
    $loop=0;
    for($i=1;$i<=$rating_point;$i++)
    {
      $loop++;
      $ret.='<i class="fa fa-star orange '.$class.'"></i>';
    }
    $start_bank = 5-$loop;
    if($start_bank>0)
    for($i=1;$i<=$start_bank;$i++)
    {
      $ret.='<i class="fa fa-star text-muted '.$class.'"></i>';
    }
    return $ret;
  }
}

if ( ! function_exists('mec_display_rating'))
{
  function mec_display_rating($rating_point=0,$review_count=0)
  {     
     if($rating_point==0 || $review_count==0) return "";
     if($review_count<3) return "";
     $value=$rating_point/$review_count;

     if($value>5) $value=5;

     $return="";
     if(is_integer($value))
     {
       for ($i=1; $i <=$value ; $i++) 
       { 
         $return.= "<i class='fa fa-star orange'></i>";
       }
     }
     else
     {
        $exp=explode('.', $value);
        $before=$exp[0];
        $after='.'.round($exp[1],1); //.35 => .4, .34=>.3

        for ($i=1; $i <=$before ; $i++) 
        { 
         $return.= "<i class='fa fa-star orange'></i>";
        }

        if($after>.20 && $after<=.7) $return.= "<i class='fa fa-star-half-alt orange'></i>";
        else if($after>.7 && $after<=1) $return.= "<i class='fa fa-star orange'></i>";

     }
     return $return;
     
  }
}

if ( ! function_exists('mec_average_rating'))
{
  function mec_average_rating($rating_point=0,$review_count=0)
  {     
     if($rating_point==0 || $review_count==0) return "";
     if($review_count<1) return "";
     $value=$rating_point/$review_count;     
     return round($value,2);
     
  }
}
