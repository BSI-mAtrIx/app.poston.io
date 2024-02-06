<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $page_title; ?></h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <form id="spComment" class="marketplace_main_app mr-1 float-left"
              action="<?php echo base_url('marketplace/install'); ?>" method="post"><input name="current_version"
                                                                                           value="0000" type="hidden">
            <input name="latest_version" value="0000" type="hidden"><input type="hidden" name="purchase_code"
                                                                           value="000000"><input type="hidden"
                                                                                                 name="module_name"
                                                                                                 value="marketplace_main_app<?php if (file_exists(FCPATH . "application/views/marketplace/router.php")) {
                                                                                                     echo "_update";
                                                                                                 } else {
                                                                                                     echo "";
                                                                                                 }; ?>">
            <button type="submit" class="btn btn-primary mb-1" href="#"><i class='bx bx-cloud-upload'></i></button>
        </form>
        <a title="Xerochat Marketplace by BCheckin" href="https://marketplace.bcheckin.com/account/" target="_blank">
            <button type="submit" class="btn btn-primary mb-1"><i class="bx bx-key"></i> Account</button>
        </a>
    </div>
</div>


<div class="section-header">
    <h1>

        <div class="section-header-button">

        </div>


        <button onclick="open_mkp_accountmanager()" type="submit" class="btn btn-primary ml-2 d-none" href="#"><i
                    class="bx bx-key"></i> Account
        </button>


</div>


<div class="section-body">
    <div class="row">

        <?php
        function get_content_url($URL)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $URL);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        $items_json = get_content_url('https://marketplace.bcheckin.com/update/items_list');
        $items_obj = json_decode($items_json, TRUE);

        $this->load->helper('file');

        foreach ($items_obj as $filename => $parameter) {

            $parameter = explode("|", $parameter);
            $latest_version = $parameter[0];
            $original_Price = $parameter[1];
            $new_Price = $parameter[2];
            $last_Update = $parameter[3];
            $author = $parameter[4];
            $html = $parameter[5];

            $file_txt = read_file(FCPATH . "application/views/marketplace/" . $filename . ".txt");
            $file_txt_explode = explode(",", $file_txt);
            if ($file_txt == FALSE) {
                $file_text_version = "101";
            } else {
                $file_text_version = $file_txt_explode[0];
            }
            if ($file_txt == FALSE) {
                $file_text_purchase_code = "";
            } else {
                $file_text_purchase_code = $file_txt_explode[1];
            }


            ?>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img src="https://marketplace.bcheckin.com/cdn/items/<?= $filename ?>/avatar.png"
                             class="img-thumbnail profile-widget-picture">
                        <div class="profile-widget-items">

                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">
                                    <span class="badge badge-light">v.<?= $latest_version ?></span>
                                </div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-value">
                                    <span class="badge badge-light"><i
                                                class="bx bx-calendar"></i> <?= $last_Update ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="<?= $filename ?>" class="carousel slide carousel-fade" data-ride="carousel">
                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            <li data-target="#<?= $filename ?>" data-slide-to="0" class="active"></li>
                            <li data-target="#<?= $filename ?>" data-slide-to="1"></li>
                            <li data-target="#<?= $filename ?>" data-slide-to="2"></li>
                            <li data-target="#<?= $filename ?>" data-slide-to="3"></li>
                        </ul>
                        <!-- The slideshow -->
                        <div class="carousel-inner" data-toggle="modal" data-target="#modal_<?= $filename ?>">
                            <div class="carousel-item active">
                                <img src="https://marketplace.bcheckin.com/cdn/items/<?= $filename ?>/banner_a1.png"
                                     class="mx-auto mb-4">
                            </div>
                            <div class="carousel-item">
                                <img src="https://marketplace.bcheckin.com/cdn/items/<?= $filename ?>/banner_a2.png"
                                     class="mx-auto mb-4">
                            </div>
                            <div class="carousel-item">
                                <img src="https://marketplace.bcheckin.com/cdn/items/<?= $filename ?>/banner_a3.png"
                                     class="mx-auto mb-4">
                            </div>
                            <div class="carousel-item">
                                <img src="https://marketplace.bcheckin.com/cdn/items/<?= $filename ?>/banner_a4.png"
                                     class="mx-auto mb-4">
                            </div>

                        </div>
                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#<?= $filename ?>" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#<?= $filename ?>" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>


                    <div class="profile-widget-description" style="padding-bottom: 0;">
                        <div class="profile-widget-name text-center text-capitalize"><?= str_replace("_", " ", $filename) ?></div>
                    </div>
                    <div class="card-footer text-center" style="padding-top: 10px;">

                        <div class="input-group justify-content-md-center">
                            <form id="spComment" action="<?php echo base_url('marketplace/install'); ?>" method="post"
                                  style="display: inherit;">
                                <div class="custom-file">
                                    <input name="purchase_code" value="<?= $file_text_purchase_code ?>"
                                           placeholder="Purchase Code" class="form-control" type="text" required>
                                    <input name="module_name" value="<?= $filename ?><?php if ($file_txt) {
                                        echo "_update";
                                    } else {
                                        echo "";
                                    }; ?>" type="hidden">
                                    <input name="current_version" value="<?= $file_text_version ?>" type="hidden">
                                    <input name="latest_version" value="<?= $latest_version ?>" type="hidden">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-outline-primary ml-1"> <?php if ($file_txt) {
                                            echo "<i class='bx bx-sync'></i> Update";
                                        } else {
                                            echo "<i class='bx bx-check-circle'></i> Install";
                                        }; ?></button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- The Modal -->
            <div class="modal" id="modal_<?= $filename ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <div class="profile-widget-name text-center text-capitalize">
                                <h4><?= str_replace("_", " ", $filename) ?></h4></div>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <?= $html ?>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>


        <?php } ?>


        <?php
        foreach (glob(FCPATH . "application/modules/marketplace/views/autoload/*.php") as $filename) {
            include $filename;
        }
        ?>

    </div>
</div>

<hr/>
<section class="section mt-5">
    <div class="section-header py-2">

        <i class="bx bx-bulb mr-1"></i> <a target="_blank" href="https://marketplace.bcheckin.com/">Xerochat Marketplace
            | Bridge for developers</a>
        <div class="section-header-breadcrumb"><i class="bx bx-question-mark mr-1"></i> <a target="_blank"
                                                                                           href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=info@bcheckin.com&su=I'm interested in the Add-on for Xerochat Marketplace documentation&body=Hi, I'm a developer, I have a good Add-on that I want to share with everyone through Marketplace.&tf=1">Quickstart:
                How to publish your Add-on to Xerochat Marketplace? </a></div>

    </div>
    <div class="row">
        <div class="container text-center">
            <p>
            <blockquote>Xerochat is a very flexible platform with huge potential to create strategic marketing
                services.
            </blockquote>
            </p>
        </div>
    </div>
</section>


<style> body {
        background: #e9e9e9;
    } </style>
<script>
    $(document).ready(function () {
        $('form#spComment').submit(function () {
            $.ajax({
                data: $(this).serialize(),
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                success: function (data) {
                    if (data['error'] == false) {
                        var msg = 'We got your flag. Our moderators will now look into it. You may close the window now!';
                        alert(msg);

                    } else {
                        setTimeout(function () {
                            location.reload()
                        }, 2000);
                        alert(data);
                    }
                },
                error: function (data) {
                    var r = jQuery.parseJSON(data.responseText);
                    alert("Message: " + r.Message);
                    alert("StackTrace: " + r.StackTrace);
                    alert("ExceptionType: " + r.ExceptionType);
                }
            });
            return false;
        });
    });

    // Auto check for new updates Main App
    //$(function(){$('.marketplace_main_app').submit();});
</script>

<?= file_get_contents('https://marketplace.bcheckin.com/update/notifications') ?>

<div id="mkp_accountmanager" class="mkp_accountmanager">
    <span href="javascript:void(0)" class="rb_closebtn" onclick="close_mkp_accountmanager()"
          style="cursor: pointer; right:75px;">&times;</span>
    <iframe height="100%" style="width: 100%;" scrolling="auto" src="https://marketplace.bcheckin.com/account/"
            frameborder="no" allowtransparency="true" allowfullscreen="true"></iframe>
</div>

<style>
    .mkp_accountmanager {
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

    .rb_closebtn {
        position: absolute;
        top: 0;
        right: 45px;
        font-size: 36px;
        margin-left: 50px;
    }


</style>
<script>
    function open_mkp_accountmanager() {
        document.getElementById("mkp_accountmanager").style.width = "380px";
    }

    function close_mkp_accountmanager() {
        document.getElementById("mkp_accountmanager").style.width = "0";
    }

</script>


