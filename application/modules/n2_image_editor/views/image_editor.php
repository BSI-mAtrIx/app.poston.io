<style type="text/css">
       .fullscreen_ie {    position: absolute; width: 100%; z-index: 99999999999; height: 100vh; top: 0;left: 0; }
        iframe{height:calc(100vh - 250px);}
       .fullscreen_ie iframe{height:calc(100vh - 76px)!important;}
</style>

<section class="section section_custom" id="editormain">
  <div class="section-header">
    <h1><i class="fa fa-search-location"></i> <?php echo $page_title;?></h1>
    <div class="section-header-button">
      <a class="btn btn-primary" id="fullscreen_switch" href="#" >
        <i class="fa fa-expand"></i> <?php echo $this->lang->line('Toggle Full Screen'); ?>      </a> 
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="<?php echo base_url('n2_image_editor'); ?>"><?php echo $this->lang->line('image_editor'); ?></a></div>
      <div class="breadcrumb-item"><?php echo $page_title;?></div>
    </div>
  </div>



<div class="section-body">

	<iframe style="width:100%;  border:0;" id="miniPaint" src="<?= base_url() ?>plugins/miniPaint/"></iframe>


</div>
</section>



<script>


// $('body').append('<div id="fullscreen_ie"></div>');
// $('#fullscreen_ie').hide();

var fullscreen = 0;

$("#fullscreen_switch").click(function(e){
    e.preventDefault();

         $("#editormain").toggleClass("fullscreen_ie");

   

    
});

</script>