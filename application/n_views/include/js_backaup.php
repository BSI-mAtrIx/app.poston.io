<?php
  <?php if(!isset($iframe) || (isset($iframe) && $iframe!='1'))
  {
//      include(APPPATH."views/include/fb_px.php");
//      include(APPPATH."views/include/google_code.php");
  }
  ?>

<!--
<script type="text/javascript">
  <?php
  if($this->session->userdata("is_mobile")=='1') echo 'var areWeUsingScroll = false;';
  else echo 'var areWeUsingScroll = true;';
  ;?>
</script>



<script src="<?php echo base_url(); ?>assets/modules/jquery.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/moment.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/chart.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/owlcarousel2/dist/owl.carousel.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<!~~ General JS Scripts ~~>
<!~~ <script src="<?php echo base_url(); ?>assets/modules/jquery.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script> ~~>
<script src="<?php echo base_url(); ?>assets/modules/popper.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/tooltip.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/bootstrap/js/bootstrap.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/nicescroll/jquery.nicescroll.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script src="<?php echo base_url(); ?>assets/js/stisla.js?ver=<?php echo $n_config['theme_version']; ?>"></script>


<!~~ JS Libraies ~~>

<script src="<?php echo base_url(); ?>assets/modules/jquery.sparkline.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script src="<?php echo base_url(); ?>assets/modules/chocolat/dist/js/jquery.chocolat.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script src="<?php echo base_url(); ?>assets/modules/simple-weather/jquery.simpleWeather.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/jquery.vmap.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/maps/jquery.vmap.world.js?ver=<?php echo $n_config['theme_version']; ?>"></script>


<script src="<?php echo base_url(); ?>assets/modules/jquery-ui/jquery-ui.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script src="<?php echo base_url(); ?>assets/js/page/clipboard.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/prism/prism.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script src="<?php echo base_url(); ?>assets/modules/sticky-kit.js?ver=<?php echo $n_config['theme_version']; ?>"></script>





<script src="<?php echo base_url(); ?>assets/modules/jqvmap/dist/maps/jquery.vmap.indonesia.js?ver=<?php echo $n_config['theme_version']; ?>"></script>



<script src="<?php echo base_url(); ?>assets/modules/cleave-js/dist/cleave.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/cleave-js/dist/addons/cleave-phone.us.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/jquery-pwstrength/jquery.pwstrength.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/bootstrap-daterangepicker/daterangepicker.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/select2/dist/js/select2.full.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/jquery-selectric/jquery.selectric.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>


<script src="<?php echo base_url(); ?>assets/modules/codemirror/lib/codemirror.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/codemirror/mode/javascript/javascript.js?ver=<?php echo $n_config['theme_version']; ?>"></script>


<script src="<?php echo base_url(); ?>assets/modules/gmaps.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<script src="<?php echo base_url(); ?>assets/modules/fullcalendar/fullcalendar.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>



<script src="<?php echo base_url(); ?>assets/modules/datatables/datatables.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>



<script src="<?php echo base_url(); ?>assets/modules/izitoast/js/iziToast.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>



<script src="<?php echo base_url(); ?>assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js?ver=<?php echo $n_config['theme_version']; ?>"></script>



<!~~ <script src="http://maps.google.com/maps/api/js?key=AIzaSyB55Np3_WsZwUQ9NS7DP-HnneleZLYZDNw&amp;sensor=true"></script> ~~>

<!~~ js for ajax multiselect [zilani 02-07-2019] ~~>
<link rel="stylesheet" href="<?php echo base_url();?>plugins/multiselect_tokenize/jquery.tokenize.css" type="text/css" />
<script src="<?php echo base_url();?>plugins/multiselect_tokenize/jquery.tokenize.js" type="text/javascript"></script>

<!~~ Scrollbar ~~>
<script src="<?php echo base_url();?>plugins/scrollbar/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script>

<!~~ Emoji Library~~>
<script src="<?php echo base_url();?>plugins/emoji/dist/emojionearea.js" type="text/javascript"></script>


<!~~ Custom Universal JS ~~>
<script>

  // $("document").ready(function(){
  //   $('.modal').on('shown.bs.modal', function () {
  //     $(this).find('.table-responsive').attr('style','overflow','scroll !important;');
  //   });
  // });



  $(document).ready(function() {

    $('[data-toggle="popover"]').popover();
    $('[data-toggle="popover"]').on('click', function(e) {e.preventDefault(); return true;});









</script>


<!~~ scrollbar ~~>
<!~~ theme:"rounded-dark",
theme: "dark", "light",
theme: "light-2", "dark-2",
theme: "light-thick", "dark-thick",
theme: "light-thin", "dark-thin",
theme "rounded", "rounded-dark", "rounded-dots", "rounded-dots-dark",
theme "3d", "3d-dark", "3d-thick", "3d-thick-dark",
theme: "minimal", "minimal-dark",
theme "light-3", "dark-3",
theme "inset", "inset-dark", "inset-2", "inset-2-dark", "inset-3", "inset-3-dark", ~~>
<script>


  <?php if($this->session->userdata("is_mobile")=='0') : ?>
  $(document).ready(function() {

      $(".xscroll").mCustomScrollbar({
        autoHideScrollbar:true,
        theme:"rounded-dark",
        axis: "x"
      });
      $(".yscroll").mCustomScrollbar({
        autoHideScrollbar:true,
        theme:"rounded-dark"
      });
      $(".xyscroll").mCustomScrollbar({
        autoHideScrollbar:true,
        theme:"rounded-dark",
        axis:"yx"
      });

      $("div:not(.data-card) > .table-responsive").niceScroll();

      $(".nicescroll,.makeNiceScroll").niceScroll();
      $(".makeNiceScroll").niceScroll();
      $(".makeScroll,.video-widget-info,.account_list").mCustomScrollbar({
        autoHideScrollbar:true,
        theme:"rounded-dark"
      });

      $('#xxx').on('hide.bs.dropdown', function (e) {
          if (e.clickEvent) {
            e.preventDefault();
          }
      })
  });
<?php endif; ?>

</script>





<!~~ Template JS File ~~>
<script src="<?php echo base_url(); ?>assets/js/scripts.js?ver=<?php echo $n_config['theme_version']; ?>"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.js?ver=<?php echo $n_config['theme_version']; ?>"></script>

<!~~ sidebar collapse by default ~~>
<script type="text/javascript">
  $(document).ready(function() {
    var controller_name = '<?php echo $this->uri->segment(1); ?>';
    var function_name = '<?php echo $this->uri->segment(2); ?>';
    var is_mobile =  '<?php echo $this->session->userdata("is_mobile");?>';

      if(is_mobile=='0' && ( (controller_name=="gmb" && (function_name=="location_list" || function_name=="")) || (controller_name=="ecommerce" && (function_name=="store_list" || function_name=="")) || (controller_name=="appointment_booking" && (function_name=="dashboard" || function_name=="")) || (controller_name=="comment_automation" && (function_name=="index" || function_name=="")) ||(controller_name=="messenger_bot" && (function_name=="bot_list")) || (controller_name=="subscriber_manager" && (function_name=="sync_subscribers")) ||(function_name=="tree_view") || (controller_name=="instagram_poster" && (function_name=="image_video_edit_auto_post" || function_name=="image_video_poster"))))
        setTimeout(function(){ $("#collapse_me_plz").click();}, 100);
  });
</script>


<!~~ HTML search ~~>