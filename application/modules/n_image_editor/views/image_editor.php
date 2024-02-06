<style type="text/css">
    .alert a{text-decoration: none;}
    .main-content image-editor .canvas-wrapper { min-height: 900px!important; }
    .main-content pixie-editor .tool-panel-container .cancel-button{width:90px!important;}
    .fullscreen_ie {    position: absolute; width: 100%; z-index: 99999999999; height: 100vh; top: 0;left: 0; }
    .fullscreen_ie image-editor .canvas-wrapper {    height: calc(100vh - 236px)!important; }

</style>
<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>
<section class="section section_custom" id="editormain">
  <div class="section-header">
    <h1><i class="fa fa-search-location"></i> <?php echo $page_title;?></h1>
    <div class="section-header-button">
      <a class="btn btn-primary" id="fullscreen_switch" href="#" >
        <i class="fa fa-expand"></i> <?php echo $this->lang->line('Toggle Full Screen'); ?>      </a> 
    </div>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item"><a href="<?php echo base_url('n_image_editor'); ?>"><?php echo $this->lang->line('image_editor'); ?></a></div>
      <div class="breadcrumb-item"><?php echo $page_title;?></div>
    </div>
  </div>



    <div class="section-body">
        <iframe style="width:100%; min-height: 700px;  border:0;" id="miniPaint" src="<?= base_url() ?>n_image_editor/editor"></iframe>
    </div>
</section>

<?php $n_current_language = isset($language_info[$this->language]) ? $language_info[$this->language] : $this->lang->line("Language"); ?>

<script>

         var fullscreen = 0;

         jQuery("#fullscreen_switch").click(function(e){
             e.preventDefault();

             if($('body').hasClass('sidebar-mini')==false){
                 $("#collapse_me_plz").click();
             }


         });


         // function(e){
         //     e.preventDefault();
         //     $("#editormain").toggleClass("fullscreen_ie");
         //
         //
         // }
</script>