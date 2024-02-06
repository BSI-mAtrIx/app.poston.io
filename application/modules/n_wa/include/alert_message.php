<?php if(!empty($alert_message)){ ?>
    <div class="col-12">

        <?php
        switch($alert_message['alert_type']){
            case 'success';
                echo '<div class="alert alert-success mb-2" role="alert">
                 '.$alert_message['alert_message'].'
              </div>';
            break;

            case 'danger';
                echo '<div class="alert alert-danger mb-2" role="alert">
                 '.$alert_message['alert_message'].'
              </div>';
                break;

            case 'warning';
                echo '<div class="alert alert-warning mb-2" role="alert">
                 '.$alert_message['alert_message'].'
              </div>';
                break;
        }

         ?>

    </div>
<?php } ?>