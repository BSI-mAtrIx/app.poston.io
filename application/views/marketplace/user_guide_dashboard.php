<style>
    
    .ani_growDown { animation: growDown 300ms ease-in-out forwards; transform-origin: top right; }
    @keyframes growDown { 0% { transform: scaleY(0) } 80% { transform: scaleY(1.1) } 100% { transform: scaleY(1) } }
    .shortLink_card > div.desc { min-height: 62px; }
    .shortLink_card > img { max-width: 100%; filter: grayscale(20%);}
    .shortLink_card > span { transform-origin: center center; -webkit-animation: pulse 2.1s infinite linear; animation: pulse 2.1s infinite linear; }
    
    .carousel-item > img { max-width: 100%; filter: grayscale(20%); }
    .carousel-indicators .active { background-color: #8a8a8a; }
    .carousel-indicators li { background-color: rgb(206 206 206 / 50%); }
    .carousel-control-next-icon { background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23cecece' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E"); }
    .carousel-control-prev-icon { background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23cecece' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E"); }
    
    .x-button { padding: 0px 9px; border: 2px solid #3b3b3b; border-radius: 50px; font-weight: bolder; color: black; } 
    .modal_tutorial_bot_settings, .modal_tutorial_auto_comment, .modal_tutorial_autobot_flow {cursor: pointer;}
    .tutorial-modal > p> strong {color: #007bff;}
    .tutorial-modal > p > img { border: 1px solid #d0d0d0; padding: 10px; border-radius: 10px; }
    .modal-dialog-youtube {padding: 10px;}
    .cursor_pointer { cursor: pointer; }
    @media only screen and (min-width: 767px) {
        .shortLink_card { padding: 15px 10px; }
        .shortLink_card > h5 { font-size: initial; }
    }
    
    @media only screen and (max-width: 768px) {
        .shortLink_card { padding: 15px 10px; }
        .shortLink_card > h5 { font-size: initial; }
        
    }
    
    @media only screen and (max-width: 425px) {
        .shortLink_row { padding: 10px; } 
        .shortLink_item { padding-right: 5px; padding-left: 5px; }
        .shortLink_card { padding: 15px 10px; }
        .shortLink_card > h5 { font-size: initial; }
        
    }
    
    
</style>


<div class="row shortLink_row">

    <div class="col-lg-12 col-md-12 col-sm-12 col-12 shortLink_item">
        <div class="card card-statistic-2">
          
          <div class="card-icon shadow-primary bg-primary">
            <i class="far fa-question-circle"></i>
          </div>
          
          <div class="card-wrap">
            <div class="card-header">
              <h4 style="color: #f12828"><?=$this->lang->line('bcb_1002')?></h4>
              <p><?=$this->lang->line('bcb_1003')?> <span onclick="ShowAndHide('user_guide_dashboard_block')" style="color: #f12828"><?=$this->lang->line('bcb_1061')?></span></p>
            </div>
          </div>
          
        </div>
    </div>
    

    
    <div class="ani_growDown row mx-1" id="user_guide_dashboard_block" style="display:none">
    
    <div class="col-lg-3 col-md-3 col-sm-6 col-6 shortLink_item">
        <div class="card card-statistic-2">
          <div class="text-center shortLink_card">
            
            <span style=" position: absolute; background: #6777ef; padding: 2px 4px; font-size: 14px; border-radius: 4px; color: white; z-index: 1; letter-spacing: 2px; left: 10px;">1/3</span>
            <span style="position: absolute;background: #ca403d;padding: 0px 4px;font-size: 14px;border-radius: 4px;color: white;z-index: 1;letter-spacing: 2px;right: 10px;"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" style=" fill: aliceblue; "><path d="M0 0h24v24H0z" fill="none"></path><path d="M8 5v14l11-7z"></path></svg></span>
            
            <div id="AutoBotSliderA" class="carousel slide carousel-fade" data-ride="carousel">
            
              <!-- Indicators -->
              <ul class="carousel-indicators">
                <li data-target="#AutoBotSliderA" data-slide-to="0" class="active"></li>
                <li data-target="#AutoBotSliderA" data-slide-to="1"></li>
                <li data-target="#AutoBotSliderA" data-slide-to="2"></li>
              </ul>
              
              <!-- The slideshow -->
              <div class="carousel-inner <?php if ( $this->lang->line('bcb_youtubeA') !== '00' ) { echo "modal_tutorial_block_A cursor_pointer"; };?>">
                <div class="carousel-item active">
                  <img src="<?=$this->lang->line('bcb_SliderA_1')?>" class="mx-auto mb-4">
                </div>
                <div class="carousel-item">
                  <img src="<?=$this->lang->line('bcb_SliderA_2')?>" class="mx-auto mb-4">
                </div>
                <div class="carousel-item">
                  <img src="<?=$this->lang->line('bcb_SliderA_3')?>" class="mx-auto mb-4">
                </div>
              </div>
              
              <!-- Left and right controls -->
              <a class="carousel-control-prev" href="#AutoBotSliderA" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </a>
              <a class="carousel-control-next" href="#AutoBotSliderA" data-slide="next">
                <span class="carousel-control-next-icon"></span>
              </a>
            </div>
            
            <h5 class="mb-2"><?=$this->lang->line('bcb_1004')?></h5>
            <div class="desc"><?=$this->lang->line('bcb_1005')?> <a target="_blank" href="<?=$this->lang->line('bcb_LinkA')?>"><?=$this->lang->line('bcb_1012')?></a></div>
          </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-6 col-6 shortLink_item">
        <div class="card card-statistic-2">
          <div class="text-center shortLink_card">
            
            <span style=" position: absolute; background: #6777ef; padding: 2px 4px; font-size: 14px; border-radius: 4px; color: white; z-index: 1; letter-spacing: 2px; left: 10px;">2/3</span>
            <span style="position: absolute;background: #ca403d;padding: 0px 4px;font-size: 14px;border-radius: 4px;color: white;z-index: 1;letter-spacing: 2px;right: 10px;"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" style=" fill: aliceblue; "><path d="M0 0h24v24H0z" fill="none"></path><path d="M8 5v14l11-7z"></path></svg></span>
            
            <div id="AutoBotSliderB" class="carousel slide carousel-fade" data-ride="carousel">
            
              <!-- Indicators -->
              <ul class="carousel-indicators">
                <li data-target="#AutoBotSliderB" data-slide-to="0" class="active"></li>
                <li data-target="#AutoBotSliderB" data-slide-to="1"></li>
                <li data-target="#AutoBotSliderB" data-slide-to="2"></li>
              </ul>
              
              <!-- The slideshow -->
              <div class="carousel-inner <?php if ( $this->lang->line('bcb_youtubeB') !== '00') { echo "modal_tutorial_block_B cursor_pointer"; };?>">
                <div class="carousel-item active">
                  <img src="<?=$this->lang->line('bcb_SliderB_1')?>" class="mx-auto mb-4">
                </div>
                <div class="carousel-item">
                  <img src="<?=$this->lang->line('bcb_SliderB_2')?>" class="mx-auto mb-4">
                </div>
                <div class="carousel-item">
                  <img src="<?=$this->lang->line('bcb_SliderB_3')?>" class="mx-auto mb-4">
                </div>
              </div>
              
              <!-- Left and right controls -->
              <a class="carousel-control-prev" href="#AutoBotSliderB" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </a>
              <a class="carousel-control-next" href="#AutoBotSliderB" data-slide="next">
                <span class="carousel-control-next-icon"></span>
              </a>
            </div>
            
            
            <h5 class="mb-2"><?=$this->lang->line('bcb_1006')?></h5>
            <div class="desc"><?=$this->lang->line('bcb_1007')?> <a target="_blank" href="<?=$this->lang->line('bcb_LinkB')?>"><?=$this->lang->line('bcb_1012')?></a></div>
          </div>
        </div>
    </div>  
    
    <div class="col-lg-3 col-md-3 col-sm-6 col-6 shortLink_item">
        <div class="card card-statistic-2">
          <div class="text-center shortLink_card">
            
            <span style=" position: absolute; background: #6777ef; padding: 2px 4px; font-size: 14px; border-radius: 4px; color: white; z-index: 1; letter-spacing: 2px; left: 10px;">3/3</span>
            <span style="position: absolute;background: #ca403d;padding: 0px 4px;font-size: 14px;border-radius: 4px;color: white;z-index: 1;letter-spacing: 2px;right: 10px;"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" style=" fill: aliceblue; "><path d="M0 0h24v24H0z" fill="none"></path><path d="M8 5v14l11-7z"></path></svg></span>
            
            <div id="AutoBotSliderC" class="carousel slide carousel-fade" data-ride="carousel">
            
              <!-- Indicators -->
              <ul class="carousel-indicators">
                <li data-target="#AutoBotSliderC" data-slide-to="0" class="active"></li>
                <li data-target="#AutoBotSliderC" data-slide-to="1"></li>
                <li data-target="#AutoBotSliderC" data-slide-to="2"></li>
              </ul>
              
              <!-- The slideshow -->
              <div class="carousel-inner <?php if (  $this->lang->line('bcb_youtubeC') !== '00' ) { echo "modal_tutorial_block_C cursor_pointer";}?>">
                <div class="carousel-item active">
                  <img src="<?=$this->lang->line('bcb_SliderC_1')?>" class="mx-auto mb-4">
                </div>
                <div class="carousel-item">
                  <img src="<?=$this->lang->line('bcb_SliderC_2')?>" class="mx-auto mb-4">
                </div>
                <div class="carousel-item">
                  <img src="<?=$this->lang->line('bcb_SliderC_3')?>" class="mx-auto mb-4">
                </div>
              </div>
              
              <!-- Left and right controls -->
              <a class="carousel-control-prev" href="#AutoBotSliderC" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </a>
              <a class="carousel-control-next" href="#AutoBotSliderC" data-slide="next">
                <span class="carousel-control-next-icon"></span>
              </a>
            </div>
            
            <h5 class="mb-2"><?=$this->lang->line('bcb_1008')?></h5>
            <div class="desc"><?=$this->lang->line('bcb_1009')?> <a target="_blank" href="<?=$this->lang->line('bcb_LinkC')?>"><?=$this->lang->line('bcb_1012')?></a></div>
          </div>
        </div>
    </div>
      
    <div class="col-lg-3 col-md-3 col-sm-6 col-6 shortLink_item">
        <div class="card card-statistic-2">
          <div class="text-center shortLink_card">
            
            <span style=" position: absolute; background: #6777ef; padding: 2px 4px 2px 6px; font-size: 14px; border-radius: 4px; color: white; z-index: 1; letter-spacing: 2px;  left: 10px;">Opt</span>
            <span style="position: absolute;background: #ca403d;padding: 0px 4px;font-size: 14px;border-radius: 4px;color: white;z-index: 1;letter-spacing: 2px;right: 10px;"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" style=" fill: aliceblue; "><path d="M0 0h24v24H0z" fill="none"></path><path d="M8 5v14l11-7z"></path></svg></span>
            
            <div id="AutoBotSliderD" class="carousel slide carousel-fade" data-ride="carousel">
            
              <!-- Indicators -->
              <ul class="carousel-indicators">
                <li data-target="#AutoBotSliderD" data-slide-to="0" class="active"></li>
                <li data-target="#AutoBotSliderD" data-slide-to="1"></li>
                <li data-target="#AutoBotSliderD" data-slide-to="2"></li>
              </ul>
              
              <!-- The slideshow -->
              <div class="carousel-inner <?php if (  $this->lang->line('bcb_youtubeD') !== '00' ) { echo "modal_tutorial_block_D cursor_pointer";}?>">
                <div class="carousel-item active">
                  <img src="<?=$this->lang->line('bcb_SliderD_1')?>" class="mx-auto mb-4">
                </div>
                <div class="carousel-item">
                  <img src="<?=$this->lang->line('bcb_SliderD_2')?>" class="mx-auto mb-4">
                </div>
                <div class="carousel-item">
                  <img src="<?=$this->lang->line('bcb_SliderD_3')?>" class="mx-auto mb-4">
                </div>
              </div>
              
              <!-- Left and right controls -->
              <a class="carousel-control-prev" href="#AutoBotSliderD" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </a>
              <a class="carousel-control-next" href="#AutoBotSliderD" data-slide="next">
                <span class="carousel-control-next-icon"></span>
              </a>
            </div>
            
            
            <h5 class="mb-2"><?=$this->lang->line('bcb_1010')?></h5>
            <div class="desc"><?=$this->lang->line('bcb_1011')?> <a target="_blank" href="<?=$this->lang->line('bcb_LinkD')?>"><?=$this->lang->line('bcb_1012')?></a> </div>
          </div>
        </div>
    </div>
      
    </div>
      
</div>




<script type="text/javascript">
  $("document").ready(function(){

    $(document).on('click','.modal_tutorial_block_A',function(e){
        e.preventDefault();
        $("#modal_tutorial_block_A").modal();
      });
    
    $(document).on('click','.modal_tutorial_block_B',function(e){
        e.preventDefault();
        $("#modal_tutorial_block_B").modal();
      });
      
    $(document).on('click','.modal_tutorial_block_C',function(e){
        e.preventDefault();
        $("#modal_tutorial_block_C").modal();
      });
      
    $(document).on('click','.modal_tutorial_block_D',function(e){
        e.preventDefault();
        $("#modal_tutorial_block_D").modal();
      });
      
    
      
  });
</script>


<div class="modal fade" id="modal_tutorial_block_A" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?=$this->lang->line('bcb_youtubeA')?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="modal-dialog-youtube <?php if ( $this->lang->line('bcb_1030') == NULL ) { echo "d-none"; };?>" allowfullscreen></iframe>
      <div class="container">
	 <?php if ( $this->lang->line('bcb_youtubeA') == 1) { ?>

	    <nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page">How to change this video clip?</li>
		  </ol>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page">
		    <div class="mb-2">System → Your Language →  Bcheckin_user_guide... </div>
		    <div class="mb-2"><i class="fas fa-search"></i>  Bcb_youtubeA → Your Youtube ID </div>
		    <div class="mb-2"><i class="fas fa-search"></i> Bcb_youtubeA → 0 (Turn off Poup) </div>
		    
		    </li>
		  </ol>
		  
	    </nav>
	 <?php } ?>  
      </div>
      <div class="modal-header mt-5">
        <h5 class="modal-title"><i class="far fa-lightbulb mr-3 shadow-primary bg-primary" style="background: #6777ef; border-radius: 4px; color: #fff; padding-top: 15px; padding-right: 18px; padding-bottom: 15px; padding-left: 18px;"></i> <?=$this->lang->line('bcb_1013')?></h5>
        
        <button type="button" class="btn btn-outline-secondary btn-circle btn-sm" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        
      </div>

      <div class="modal-body pt-0">    
        <div class="section tutorial-modal">                
          <h2 class="section-title mb-1"><?=$this->lang->line('bcb_1004')?></h2>
          <q><?=$this->lang->line('bcb_1014a')?></q>
          
          <div class="container mt-2">
            <div class="row justify-content-md-center">
              <button class="btn btn-outline-primary btn-lg btn-block collapsed mb-5" type="button" data-toggle="collapse" data-target="#collapse_tutorial_block_A" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-plus"></i> <?=$this->lang->line('bcb_1062')?>
              </button>
            </div>
          </div>    
          
          <div class="collapse" id="collapse_tutorial_block_A">
            <div class="tutorial-modal">
                
                
                
                
                
                    <p><?=$this->lang->line('bcb_1014')?><br>
    <img src=<?=$this->lang->line('bcb_1015')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1016')?><br>
    <img src=<?=$this->lang->line('bcb_1017')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1018')?><br>
    <?=$this->lang->line('bcb_1019')?><br>
    <img src=<?=$this->lang->line('bcb_1020')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1021')?><br>
    <img src=<?=$this->lang->line('bcb_1022')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1023')?><br>
    <img src=<?=$this->lang->line('bcb_1024')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1025')?><br>
    <img src=<?=$this->lang->line('bcb_1026')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1027')?><br>
    <img src=<?=$this->lang->line('bcb_1028')?> width=100%><br>
        <?=$this->lang->line('bcb_1029')?><br>
    </p>
                
                
                
                
                
                
                
                
                
            </div>
          </div>
          
        </div>
      </div>

      <div class="modal-footer">
        <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i class="fas fa-times"></i> Close</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_tutorial_block_B" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?=$this->lang->line('bcb_youtubeB')?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="modal-dialog-youtube <?php if ( $this->lang->line('bcb_1030') == NULL ) { echo "d-none"; };?>" allowfullscreen></iframe>
	 
      <div class="container">
	 <?php if ( $this->lang->line('bcb_youtubeB') == 1) { ?>

	    <nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page">How to change this video clip?</li>
		  </ol>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page">
		    <div class="mb-2">System → Your Language →  Bcheckin_user_guide... </div>
		    <div class="mb-2"><i class="fas fa-search"></i>  Bcb_youtubeB → Your Youtube ID </div>
		    <div class="mb-2"><i class="fas fa-search"></i> Bcb_youtubeB → 0 (Turn off Poup) </div>
		    
		    </li>
		  </ol>
		  
	    </nav>
	 <?php } ?>   
	     
      </div>
	       
      <div class="modal-header mt-5">
        <h5 class="modal-title"><i class="far fa-lightbulb mr-3 shadow-primary bg-primary" style="background: #6777ef; border-radius: 4px; color: #fff; padding-top: 15px; padding-right: 18px; padding-bottom: 15px; padding-left: 18px;"></i> <?=$this->lang->line('bcb_1013')?></h5>
        
        <button type="button" class="btn btn-outline-secondary btn-circle btn-sm" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        
      </div>

      <div class="modal-body pt-0">    
        <div class="section tutorial-modal">                
          <h2 class="section-title mb-1"><?=$this->lang->line('bcb_1006')?></h2>
          <q><?=$this->lang->line('bcb_1040')?></q>
          
          <div class="container mt-2">
            <div class="row justify-content-md-center">
              <button class="btn btn-outline-primary btn-lg btn-block collapsed mb-5" type="button" data-toggle="collapse" data-target="#collapse_tutorial_block_B" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-plus"></i> <?=$this->lang->line('bcb_1062')?>
              </button>
            </div>
          </div>    
          
          <div class="collapse" id="collapse_tutorial_block_B">
            <div class="tutorial-modal">
                
                               
    <p><?=$this->lang->line('bcb_1031')?><br> 
    <?=$this->lang->line('bcb_1032')?><br>
    <img src=<?=$this->lang->line('bcb_1033')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1034')?><br>
    <img src=<?=$this->lang->line('bcb_1035')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1036')?><br>
    <img src=<?=$this->lang->line('bcb_1037')?> width=100%></p>
    <?=$this->lang->line('bcb_1038')?><br><br>
    
    <?=$this->lang->line('bcb_1039')?>
    </p>               
                
                
                
                
            </div>
          </div>
          
        </div>
      </div>

      <div class="modal-footer">
        <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i class="fas fa-times"></i> Close</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal_tutorial_block_C" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?=$this->lang->line('bcb_youtubeC')?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="modal-dialog-youtube <?php if ( $this->lang->line('bcb_1030') == NULL ) { echo "d-none"; };?>" allowfullscreen></iframe>
	 
      <div class="container">
	 <?php if ( $this->lang->line('bcb_youtubeC') == 1) { ?>

	    <nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page">How to change this video clip?</li>
		  </ol>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page">
		    <div class="mb-2">System → Your Language →  Bcheckin_user_guide... </div>
		    <div class="mb-2"><i class="fas fa-search"></i>  Bcb_youtubeC → Your Youtube ID </div>
		    <div class="mb-2"><i class="fas fa-search"></i> Bcb_youtubeC → 0 (Turn off Poup) </div>
		    
		    </li>
		  </ol>
		  
	    </nav>
	 <?php } ?>  
	     
      </div>
	          
      <div class="modal-header mt-5">
        <h5 class="modal-title"><i class="far fa-lightbulb mr-3 shadow-primary bg-primary" style="background: #6777ef; border-radius: 4px; color: #fff; padding-top: 15px; padding-right: 18px; padding-bottom: 15px; padding-left: 18px;"></i> <?=$this->lang->line('bcb_1013')?></h5>
        
        <button type="button" class="btn btn-outline-secondary btn-circle btn-sm" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        
      </div>

      <div class="modal-body pt-0">    
        <div class="section tutorial-modal">                
          <h2 class="section-title mb-1"><?=$this->lang->line('bcb_1008')?></h2>
          <q><?=$this->lang->line('bcb_1058')?></q>
          
          <div class="container mt-2">
            <div class="row justify-content-md-center">
              <button class="btn btn-outline-primary btn-lg btn-block collapsed mb-5" type="button" data-toggle="collapse" data-target="#collapse_tutorial_block_C" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-plus"></i> <?=$this->lang->line('bcb_1062')?>
              </button>
            </div>
          </div>    
          
          <div class="collapse" id="collapse_tutorial_block_C">
            <div class="tutorial-modal">




    <p><?=$this->lang->line('bcb_1041')?><br>
    <img src=<?=$this->lang->line('bcb_1042')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1043')?><br>
    <img src=<?=$this->lang->line('bcb_1044')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1045')?><br>
    <img src=<?=$this->lang->line('bcb_1046')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1047')?><br>
    <img src=<?=$this->lang->line('bcb_1048')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1049')?><br>
    <img src=<?=$this->lang->line('bcb_1050')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1051')?><br>
    <img src=<?=$this->lang->line('bcb_1052')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1053')?><br>
    <img src=<?=$this->lang->line('bcb_1054')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1055')?><br>
    <img src=<?=$this->lang->line('bcb_1056')?> width=100%><br><br>
    <?=$this->lang->line('bcb_1057')?></b>.
    </p> 
    
    
    
            </div>
          </div>
          
        </div>
      </div>

      <div class="modal-footer">
        <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i class="fas fa-times"></i> Close</a>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="modal_tutorial_block_D" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <iframe width="100%" height="315" src="https://www.youtube.com/embed/<?=$this->lang->line('bcb_youtubeD')?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" class="modal-dialog-youtube <?php if ( $this->lang->line('bcb_1030') == NULL ) { echo "d-none"; };?>" allowfullscreen></iframe>
	 
      <div class="container">
	 <?php if ( $this->lang->line('bcb_youtubeD') == 1) { ?>

	    <nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page">How to change this video clip?</li>
		  </ol>
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item active" aria-current="page">
		    <div class="mb-2">System → Your Language →  Bcheckin_user_guide... </div>
		    <div class="mb-2"><i class="fas fa-search"></i>  Bcb_youtubeD → Your Youtube ID </div>
		    <div class="mb-2"><i class="fas fa-search"></i> Bcb_youtubeD → 0 (Turn off Poup) </div>
		    
		    </li>
		  </ol>
		  
	    </nav>
	 <?php } ?>  
	     
      </div>
	          
      <div class="modal-header mt-5">
        <h5 class="modal-title"><i class="far fa-lightbulb mr-3 shadow-primary bg-primary" style="background: #6777ef; border-radius: 4px; color: #fff; padding-top: 15px; padding-right: 18px; padding-bottom: 15px; padding-left: 18px;"></i> <?=$this->lang->line('bcb_1013')?></h5>
        
        <button type="button" class="btn btn-outline-secondary btn-circle btn-sm" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        
      </div>

      <div class="modal-body pt-0">    
        <div class="section tutorial-modal">                
          <h2 class="section-title mb-1"><?=$this->lang->line('bcb_1010')?></h2>
          <q><?=$this->lang->line('bcb_1011')?></q>
          
          <div class="container mt-2">
            <div class="row justify-content-md-center">
              <button class="btn btn-outline-primary btn-lg btn-block collapsed mb-5" type="button" data-toggle="collapse" data-target="#collapse_tutorial_block_D" aria-expanded="false" aria-controls="collapseExample">
                <i class="fas fa-plus"></i> <?=$this->lang->line('bcb_1062')?>
              </button>
            </div>
          </div>    
          
          <div class="collapse" id="collapse_tutorial_block_D">
            <div class="tutorial-modal">




    <p><?=$this->lang->line('bcb_1079')?><br>
    <img src=<?=$this->lang->line('bcb_1080')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1081')?><br>
    <img src=<?=$this->lang->line('bcb_1082')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1083')?><br>
    <img src=<?=$this->lang->line('bcb_1084')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1085')?><br>
    <img src=<?=$this->lang->line('bcb_1086')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1087')?><br>
    <img src=<?=$this->lang->line('bcb_1088')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1089')?><br>
    <img src=<?=$this->lang->line('bcb_1090')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1091')?><br>
    <img src=<?=$this->lang->line('bcb_1092')?> width=100%></p>
    
    <br><br>
    
    <p><?=$this->lang->line('bcb_1093')?><br>
    <img src=<?=$this->lang->line('bcb_1094')?> width=100%><br><br>
    <?=$this->lang->line('bcb_1095')?></b>.
    </p> 
    
    
    
            </div>
          </div>
          
        </div>
      </div>

      <div class="modal-footer">
        <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i class="fas fa-times"></i> Close</a>
      </div>
    </div>
  </div>
</div>


<hr>
<hr style=" border-top: 1px solid rgb(255 255 255 / 0%); ">


<script>

        <?php // Query User Infomation
            $bck_join = array('package'=>"users.package_id=package.id,left");
            $bck_profile_info = $this->basic->get_data("users",array("where"=>array("users.id"=>$this->session->userdata("user_id"))),"users.*,package_name",$bck_join);
            $bck_add_date= isset($bck_profile_info[0]["add_date"]) ? $bck_profile_info[0]["add_date"] : ""; 
        ?>

        // Check Admin
        var user_group = '';
        <?php if($this->session->userdata('user_type') == "Admin"){ echo "var user_group = 'admin';";  } ?>
        
        // Check Date.Now < Created Account + 3days -> Show Popover ID=btn_Myknowledge;...
        var x = new Date('<?=$bck_add_date?>');
        var y = new Date();
        var isGreater = +y < x.setDate(x.getDate() + <?=$this->lang->line('Show_User_Guide')?>);
        
        if (isGreater == true || user_group == 'admin' )
          {
            
            // Show - USER GUIDE 
            
            // Show - Hide Question Button
            setTimeout(function(){ document.getElementById("user_guide_dashboard_block").style.display = 'inherit' }, 2000);
            
          }
          
        function ShowAndHide(id) {
            var x = document.getElementById(id);
            if (x.style.display == 'none') {
                x.style.display = 'inherit';
            } else {
                x.style.display = 'none';
            }
        }
</script>
