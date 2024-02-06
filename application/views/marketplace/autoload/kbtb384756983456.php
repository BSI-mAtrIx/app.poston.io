    <div id="tl_myknowledge" class="tl_myknowledge">
        <span href="javascript:void(0)" class="rb_closebtn" onclick="close_Myknowledge()" style="cursor: pointer;">&times;</span>
        <iframe height="100%" style="width: 100%;" scrolling="auto" title="3D CSS Tardis" src="<?=$this->lang->line('bca_1021')?>" frameborder="no"  allowtransparency="true" allowfullscreen="true"></iframe>
    </div>

    <style>
            .tl_myknowledge {
              height: 100%;
              width: 0;
              position: fixed;
              z-index: 999;
              top: 0;
              right: -20px;
              background-color: #fff;
              overflow-x: hidden;
              transition: 0.5s;
              box-shadow: rgba(0, 0, 0, 0.18) -10px 0px 8px 1px;
              border-left: 5px solid rgb(205, 205, 205);
            }
            
            .tl_myknowledge_open {
                width : 380px;
            }
            
    </style>
    <script>
        function open_Myknowledge() {
              document.getElementById("tl_myknowledge").style.width = "380px";
              setTimeout(function(){ $("#btn_Myknowledge").popover('hide') }, 2000);
            }
            
            function close_Myknowledge() {
              document.getElementById("tl_myknowledge").style.width = "0";
        }
            
        // Add Question Button | Top Bar
        <?php if ( $this->lang->line('bca_1021') != NULL ) { ?>
        
        $("ul.navbar-right").first().prepend("<li class=''><a href='#' onclick='open_Myknowledge()' id='btn_Myknowledge' data-toggle='popover' data-content='<?=$this->lang->line('bca_1020')?>' data-trigger='hover' data-placement='bottom'  class='nav-link notification-toggle nav-link-lg '><i class='far fa-question-circle'></i></a> </li><a href='/simplesupport/tickets' class='nav-link nav-link-lg '><i class='fa fa-headset'></i></a>");
        
        
        <?php } ?>
        
    </script>