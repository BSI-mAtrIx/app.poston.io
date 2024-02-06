<style>

    .shortLink_card > div.desc {
        min-height: 62px;
    }

    .shortLink_card > img {
        max-width: 100%;
        filter: grayscale(20%);
    }

    .shortLink_card > span {
        transform-origin: center center;
        -webkit-animation: pulse 2.1s infinite linear;
        animation: pulse 2.1s infinite linear;
    }

    .carousel-item > img {
        max-width: 100%;
        filter: grayscale(20%);
    }

    .carousel-indicators .active {
        background-color: #8a8a8a;
    }

    .carousel-indicators li {
        background-color: rgb(206 206 206 / 50%);
    }

    .carousel-control-next-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23cecece' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
    }

    .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23cecece' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
    }

    .x-button {
        padding: 0px 9px;
        border: 2px solid #3b3b3b;
        border-radius: 50px;
        font-weight: bolder;
        color: black;
    }

    .modal_tutorial_bot_settings, .modal_tutorial_auto_comment, .modal_tutorial_autobot_flow, .modal_tutorial_ecommerce {
        cursor: pointer;
    }

    .tutorial-modal > p > strong {
        color: #007bff;
    }

    .tutorial-modal > p > img {
        border: 1px solid #d0d0d0;
        padding: 10px;
        border-radius: 10px;
    }

    .modal-dialog-youtube {
        padding: 10px;
    }

    @media only screen and (min-width: 767px) {
        .shortLink_card {
            padding: 15px 10px;
        }

        .shortLink_card > h5 {
            font-size: initial;
        }
    }

    @media only screen and (max-width: 768px) {
        .shortLink_card {
            padding: 15px 10px;
        }

        .shortLink_card > h5 {
            font-size: initial;
        }

    }

    @media only screen and (max-width: 425px) {
        .shortLink_row {
            padding: 10px;
        }

        .shortLink_item {
            padding-right: 5px;
            padding-left: 5px;
        }

        .shortLink_card {
            padding: 15px 10px;
        }

        .shortLink_card > h5 {
            font-size: initial;
        }

    }

    .shortLink_row .carousel-item {
        min-height: 305px;
    }

</style>

<div class="row shortLink_row">

    <div class="col-lg-12 col-md-12 col-sm-12 col-12 shortLink_item">
        <div class="card card-statistic-2">


            <div class="card-wrap">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-1">
                            <div class="card-icon shadow-primary bg-primary ml-auto mr-auto" style="width: 75px;
    height: 75px;
    text-align: center;">
                                <i class="bx bx-help-circle white" style="font-size: 30px; padding-top: 22px;"></i>
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <h4 class="pb-0" style="color: #f12828"><?= $this->lang->line('bca_1002') ?></h4>
                            <p><?= $this->lang->line('bca_1003') ?>
                                <style>
                                    .shortLink_card > span {
                                        transform-origin: center center;
                                        -webkit-animation: pulse 2.1s infinite linear;
                                        animation: pulse 2.1s infinite linear;
                                    }

                                    .carousel-vid-control-next, .carousel-vid-control-prev {
                                        position: absolute;
                                        top: 0;
                                        bottom: 0;
                                        display: flex;
                                        -ms-flex-align: center;
                                        align-items: center;
                                        -ms-flex-pack: center;
                                        justify-content: center;
                                        width: 5%;
                                        color: #fff;
                                        text-align: center;
                                        opacity: .5
                                    }

                                    .carousel-vid-control-next:focus, .carousel-vid-control-next:hover, .carousel-vid-control-prev:focus, .carousel-vid-control-prev:hover {
                                        color: #000;
                                        text-decoration: none;
                                        outline: 0;
                                        opacity: 10
                                    }

                                    .carousel-vid-control-prev {
                                        left: 0
                                    }

                                    .carousel-vid-control-next {
                                        right: 0
                                    }

                                    .carousel-vid-control-next-icon, .carousel-vid-control-prev-icon {
                                        display: inline-block;
                                        width: 30px;
                                        height: 50px;
                                        background: transparent no-repeat center center;
                                        background-size: 100% 100%
                                    }

                                    .carousel-vid-control-prev-icon {
                                        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E")
                                    }

                                    .carousel-vid-control-next-icon {
                                        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E")
                                    }


                                </style>


                                <span id="demoVids" class="red flex items-center" style="cursor: pointer;"><i
                                            class="las la-play" style="font-size: 35px;"></i><span
                                            class="modal_demo-videos">Watch More Tutorials <i
                                                class="bx bx-play-circle"></i></span></span></p>
                        </div>

                    </div>


                    <div class="modal fade" id="modal_demo-videos" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div id="DemoVidsA" class="carousel slide">

                                    <!-- The slideshow -->
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="modal-header mt-1">
                                                <h5 class="modal-title"><i
                                                            class="bx bx-play-circle mr-3 shadow-primary bg-primary"
                                                            style="font-size: 30px; background: #6777ef; border-radius: 4px; color: #fff; padding-top: 12px; padding-right: 14px; padding-bottom: 12px; padding-left: 14px;"></i> <?= $this->lang->line('bca_1030') ?>
                                                </h5>

                                                <button type="button" class="btn btn-outline-danger btn-circle btn-sm"
                                                        data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                                                </button>
                                            </div>

                                            <iframe width="100%" height="409"
                                                    src="https://www.youtube.com/embed/<?= $this->lang->line('bca_1031') ?>"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    class="modal-dialog-youtube" allowfullscreen></iframe>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="modal-header mt-1">
                                                <h5 class="modal-title"><i
                                                            class="bx bx-play-circle mr-3 shadow-primary bg-primary"
                                                            style="font-size: 30px; background: #6777ef; border-radius: 4px; color: #fff; padding-top: 12px; padding-right: 14px; padding-bottom: 12px; padding-left: 14px;"></i> <?= $this->lang->line('bca_1032') ?>
                                                </h5>

                                                <button type="button" class="btn btn-outline-danger btn-circle btn-sm"
                                                        data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                                                </button>
                                            </div>

                                            <iframe width="100%" height="409"
                                                    src="https://www.youtube.com/embed/<?= $this->lang->line('bca_1033') ?>"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    class="modal-dialog-youtube" allowfullscreen></iframe>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="modal-header mt-1">
                                                <h5 class="modal-title"><i
                                                            class="bx bx-play-circle mr-3 shadow-primary bg-primary"
                                                            style="font-size: 30px; background: #6777ef; border-radius: 4px; color: #fff; padding-top: 12px; padding-right: 14px; padding-bottom: 12px; padding-left: 14px;"></i> <?= $this->lang->line('bca_1034') ?>
                                                </h5>

                                                <button type="button" class="btn btn-outline-danger btn-circle btn-sm"
                                                        data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                                                </button>
                                            </div>

                                            <iframe width="100%" height="409"
                                                    src="https://www.youtube.com/embed/<?= $this->lang->line('bca_1035') ?>"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    class="modal-dialog-youtube" allowfullscreen></iframe>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="modal-header mt-1">
                                                <h5 class="modal-title"><i
                                                            class="bx bx-play-circle mr-3 shadow-primary bg-primary"
                                                            style="font-size: 30px; background: #6777ef; border-radius: 4px; color: #fff; padding-top: 12px; padding-right: 14px; padding-bottom: 12px; padding-left: 14px;"></i> <?= $this->lang->line('bca_1036') ?>
                                                </h5>

                                                <button type="button" class="btn btn-outline-danger btn-circle btn-sm"
                                                        data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                                                </button>
                                            </div>

                                            <iframe width="100%" height="409"
                                                    src="https://www.youtube.com/embed/<?= $this->lang->line('bca_1037') ?>"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    class="modal-dialog-youtube" allowfullscreen></iframe>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="modal-header mt-1">
                                                <h5 class="modal-title"><i
                                                            class="bx bx-play-circle mr-3 shadow-primary bg-primary"
                                                            style="font-size: 30px; background: #6777ef; border-radius: 4px; color: #fff; padding-top: 12px; padding-right: 14px; padding-bottom: 12px; padding-left: 14px;"></i> <?= $this->lang->line('bca_1008') ?>
                                                </h5>

                                                <button type="button" class="btn btn-outline-danger btn-circle btn-sm"
                                                        data-dismiss="modal" aria-label="Close"><i class="bx bx-x"></i>
                                                </button>
                                            </div>

                                            <iframe width="100%" height="409"
                                                    src="https://www.youtube.com/embed/<?= $this->lang->line('bca_1033') ?>"
                                                    frameborder="0"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    class="modal-dialog-youtube" allowfullscreen></iframe>
                                        </div>


                                    </div>

                                    <!-- Left and right controls -->
                                    <a class="carousel-vid-control-prev" href="#DemoVidsA" data-slide="prev">
                                        <span class="carousel-vid-control-prev-icon"></span>
                                    </a>
                                    <a class="carousel-vid-control-next" href="#DemoVidsA" data-slide="next">
                                        <span class="carousel-vid-control-next-icon"></span>
                                    </a>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-6 shortLink_item">
        <div class="card card-statistic-2">
            <div class="text-center shortLink_card">

                <span style=" position: absolute; background: #970079; padding: 2px 4px; font-size: 14px; border-radius: 4px; color: white; z-index: 1; letter-spacing: 2px; left: 10px;">1/3</span>
                <span style="position: absolute;background: #ca403d;padding: 0px 4px;font-size: 14px;border-radius: 4px;color: white;z-index: 1;letter-spacing: 2px;right: 10px;"><svg
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                            style=" fill: aliceblue; "><path d="M0 0h24v24H0z" fill="none"></path><path
                                d="M8 5v14l11-7z"></path></svg></span>

                <div id="AutoBotSliderA" class="carousel slide" data-ride="carousel">

                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <li data-target="#AutoBotSliderA" data-slide-to="0" class="active"></li>
                        <li data-target="#AutoBotSliderA" data-slide-to="1"></li>
                        <li data-target="#AutoBotSliderA" data-slide-to="2"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner modal_tutorial_bot_settings">
                        <div class="carousel-item active">
                            <img src="assets/img/banner_a5.png" class="mx-auto mb-4" width="56.5%">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/banner_a6.png" class="mx-auto mb-4" width="56.5%">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/banner_a3.png" class="mx-auto mb-4" width="56.5%">
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

                <h5 class="mb-2"><?= $this->lang->line('bca_1004') ?></h5>
                <div class="desc"><?= $this->lang->line('bca_1005') ?> <a target="_blank"
                                                                          href="/messenger_bot/bot_list"><?= $this->lang->line('bca_1012') ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-6 shortLink_item">
        <div class="card card-statistic-2">
            <div class="text-center shortLink_card">

                <span style=" position: absolute; background: #970079; padding: 2px 4px; font-size: 14px; border-radius: 4px; color: white; z-index: 1; letter-spacing: 2px; left: 10px;">2/3</span>
                <span style="position: absolute;background: #ca403d;padding: 0px 4px;font-size: 14px;border-radius: 4px;color: white;z-index: 1;letter-spacing: 2px;right: 10px;"><svg
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                            style=" fill: aliceblue; "><path d="M0 0h24v24H0z" fill="none"></path><path
                                d="M8 5v14l11-7z"></path></svg></span>

                <div id="AutoBotSliderB" class="carousel slide" data-ride="carousel">

                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <li data-target="#AutoBotSliderB" data-slide-to="0" class="active"></li>
                        <li data-target="#AutoBotSliderB" data-slide-to="1"></li>
                        <li data-target="#AutoBotSliderB" data-slide-to="2"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner modal_tutorial_auto_comment">
                        <div class="carousel-item active">
                            <img src="assets/img/banner_a2.png" class="mx-auto mb-4">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/banner_a3.png" class="mx-auto mb-4" width="56.5%">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/banner_a1.png" class="mx-auto mb-4">
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


                <h5 class="mb-2"><?= $this->lang->line('bca_1006') ?></h5>
                <div class="desc"><?= $this->lang->line('bca_1007') ?> <a target="_blank"
                                                                          href="/comment_automation/template_manager"><?= $this->lang->line('bca_1012') ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-6 shortLink_item">
        <div class="card card-statistic-2">
            <div class="text-center shortLink_card">

                <span style=" position: absolute; background: #970079; padding: 2px 4px; font-size: 14px; border-radius: 4px; color: white; z-index: 1; letter-spacing: 2px; left: 10px;">3/3</span>
                <span style="position: absolute;background: #ca403d;padding: 0px 4px;font-size: 14px;border-radius: 4px;color: white;z-index: 1;letter-spacing: 2px;right: 10px;"><svg
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                            style=" fill: aliceblue; "><path d="M0 0h24v24H0z" fill="none"></path><path
                                d="M8 5v14l11-7z"></path></svg></span>

                <div id="AutoBotSliderC" class="carousel slide" data-ride="carousel">

                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <li data-target="#AutoBotSliderC" data-slide-to="0" class="active"></li>
                        <li data-target="#AutoBotSliderC" data-slide-to="1"></li>
                        <li data-target="#AutoBotSliderC" data-slide-to="2"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner modal_tutorial_autobot_flow">
                        <div class="carousel-item active">
                            <img src="assets/img/banner_a3.png" class="mx-auto mb-4" width="56.5%">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/banner_a1.png" class="mx-auto mb-4">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/banner_a2.png" class="mx-auto mb-4">
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

                <h5 class="mb-2"><?= $this->lang->line('bca_1008') ?></h5>
                <div class="desc"><?= $this->lang->line('bca_1009') ?> <a target="_blank"
                                                                          href="/messenger_bot/template_manager"><?= $this->lang->line('bca_1012') ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-6 shortLink_item">
        <div class="card card-statistic-2">
            <div class="text-center shortLink_card">

                <span style=" position: absolute; background: #970079; padding: 2px 4px; font-size: 14px; border-radius: 4px; color: white; z-index: 1; letter-spacing: 2px; left: 10px;">Opt</span>
                <span style="position: absolute;background: #ca403d;padding: 0px 4px;font-size: 14px;border-radius: 4px;color: white;z-index: 1;letter-spacing: 2px;right: 10px;"><svg
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"
                            style=" fill: aliceblue; "><path d="M0 0h24v24H0z" fill="none"></path><path
                                d="M8 5v14l11-7z"></path></svg></span>

                <div id="AutoBotSliderD" class="carousel slide" data-ride="carousel">

                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <li data-target="#AutoBotSliderD" data-slide-to="0" class="active"></li>
                        <li data-target="#AutoBotSliderD" data-slide-to="1"></li>
                        <li data-target="#AutoBotSliderD" data-slide-to="2"></li>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner modal_tutorial_ecommerce">
                        <div class="carousel-item active">
                            <img src="assets/img/banner_a8.png" class="mx-auto mb-4" width="56.5%">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/banner_a7.png" class="mx-auto mb-4" width="56.5%">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/banner_a4.png" class="mx-auto mb-4" width="56.5%">
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

                <h5 class="mb-2"><?= $this->lang->line('bca_1010') ?></h5>
                <div class="desc"><?= $this->lang->line('bca_1011') ?> <a target="_blank"
                                                                          href="/ecommerce"><?= $this->lang->line('bca_1012') ?></a>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="modal_tutorial_bot_settings" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <iframe width="100%" height="409" src="https://www.youtube.com/embed/<?= $this->lang->line('bca_1031') ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    class="modal-dialog-youtube" allowfullscreen></iframe>

            <div class="modal-header mt-5">
                <h5 class="modal-title"><i class="bx bx-bulb mr-3 shadow-primary bg-primary"
                                           style="background: #6777ef; border-radius: 4px; color: #fff; padding-top: 15px; padding-right: 18px; padding-bottom: 15px; padding-left: 18px;"></i> <?= $this->lang->line('bca_1013') ?>
                </h5>

                <button type="button" class="btn btn-outline-danger btn-circle btn-sm" data-dismiss="modal"
                        aria-label="Close"><i class="bx bx-x"></i></button>

            </div>

            <div class="modal-body pt-0">
                <div class="section tutorial-modal">
                    <h2 class="section-title mb-1"><?= $this->lang->line('bca_1004') ?></h2>
                    <q><?= $this->lang->line('bca_1015') ?></q>

                    <div class="container mt-2">
                        <div class="row justify-content-md-center">
                            <button class="btn btn-outline-primary btn-block collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseExample_bot_settings"
                                    aria-expanded="false" aria-controls="collapseExample">
                                <i class="bx bx-plus"></i> <?= $this->lang->line('bca_1029') ?>
                            </button>
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample_bot_settings">
                        <div class="tutorial-modal">
                            <p><?= $this->lang->line('bca_1014') ?></p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i class="bx bx-x"></i> Close</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tutorial_auto_comment" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <iframe width="100%" height="409" src="https://www.youtube.com/embed/<?= $this->lang->line('bca_1033') ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    class="modal-dialog-youtube" allowfullscreen></iframe>

            <div class="modal-header mt-5">
                <h5 class="modal-title"><i class="bx bx-bulb mr-3 shadow-primary bg-primary"
                                           style="background: #6777ef; border-radius: 4px; color: #fff; padding-top: 15px; padding-right: 18px; padding-bottom: 15px; padding-left: 18px;"></i> <?= $this->lang->line('bca_1013') ?>
                </h5>

                <button type="button" class="btn btn-outline-danger btn-circle btn-sm" data-dismiss="modal"
                        aria-label="Close"><i class="bx bx-x"></i></button>

            </div>

            <div class="modal-body pt-0">
                <div class="section tutorial-modal">
                    <h2 class="section-title mb-1"><?= $this->lang->line('bca_1017') ?></h2>
                    <q><?= $this->lang->line('bca_1018') ?></q>

                    <div class="container mt-2">
                        <div class="row justify-content-md-center">
                            <button class="btn btn-outline-primary btn-block collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseExample_auto_comment"
                                    aria-expanded="false" aria-controls="collapseExample">
                                <i class="bx bx-plus"></i> <?= $this->lang->line('bca_1029') ?>
                            </button>
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample_auto_comment">
                        <div class="tutorial-modal">
                            <p><?= $this->lang->line('bca_1019') ?></p>
                        </div>
                    </div>

                    <h2 class="section-title mb-1"><?= $this->lang->line('bca_1020') ?></h2>
                    <q><?= $this->lang->line('bca_1021') ?></q>

                    <div class="container mt-2">
                        <div class="row justify-content-md-center">
                            <button class="btn btn-outline-primary btn-block collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseExample_insta_auto_comment"
                                    aria-expanded="false" aria-controls="collapseExample">
                                <i class="bx bx-plus"></i> <?= $this->lang->line('bca_1029') ?>
                            </button>
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample_insta_auto_comment">
                        <div class="tutorial-modal">
                            <p><?= $this->lang->line('bca_1022') ?></p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i class="bx bx-x"></i> Close</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_tutorial_autobot_flow" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <iframe width="100%" height="409" src="https://www.youtube.com/embed/<?= $this->lang->line('bca_1035') ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    class="modal-dialog-youtube" allowfullscreen></iframe>

            <div class="modal-header mt-5">
                <h5 class="modal-title"><i class="bx bx-bulb mr-3 shadow-primary bg-primary"
                                           style="background: #6777ef; border-radius: 4px; color: #fff; padding-top: 15px; padding-right: 18px; padding-bottom: 15px; padding-left: 18px;"></i> <?= $this->lang->line('bca_1013') ?>
                </h5>

                <button type="button" class="btn btn-outline-danger btn-circle btn-sm" data-dismiss="modal"
                        aria-label="Close"><i class="bx bx-x"></i></button>

            </div>

            <div class="modal-body pt-0">
                <div class="section tutorial-modal">
                    <h2 class="section-title mb-1"><?= $this->lang->line('bca_1008') ?></h2>
                    <q><?= $this->lang->line('bca_1023') ?></q>

                    <div class="container mt-2">
                        <div class="row justify-content-md-center">
                            <button class="btn btn-outline-primary btn-block collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseExample_autobot_flow"
                                    aria-expanded="false" aria-controls="collapseExample">
                                <i class="bx bx-plus"></i> <?= $this->lang->line('bca_1029') ?>
                            </button>
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample_autobot_flow">
                        <div class="tutorial-modal">
                            <p><?= $this->lang->line('bca_1024') ?></p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i class="bx bx-x"></i> Close</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_tutorial_ecommerce" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <iframe width="100%" height="409" src="https://www.youtube.com/embed/<?= $this->lang->line('bca_1037') ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    class="modal-dialog-youtube" allowfullscreen></iframe>

            <div class="modal-header mt-5">
                <h5 class="modal-title"><i class="bx bx-bulb mr-3 shadow-primary bg-primary"
                                           style="background: #6777ef; border-radius: 4px; color: #fff; padding-top: 15px; padding-right: 18px; padding-bottom: 15px; padding-left: 18px;"></i> <?= $this->lang->line('bca_1013') ?>
                </h5>

                <button type="button" class="btn btn-outline-danger btn-circle btn-sm" data-dismiss="modal"
                        aria-label="Close"><i class="bx bx-x"></i></button>

            </div>

            <div class="modal-body pt-0">
                <div class="section tutorial-modal">
                    <h2 class="section-title mb-1"><?= $this->lang->line('bca_1010') ?></h2>
                    <q><?= $this->lang->line('bca_1025') ?></q>

                    <div class="container mt-2">
                        <div class="row justify-content-md-center">
                            <button class="btn btn-outline-primary btn-block collapsed" type="button"
                                    data-toggle="collapse" data-target="#collapseExample_ecommerce"
                                    aria-expanded="false" aria-controls="collapseExample">
                                <i class="bx bx-plus"></i> <?= $this->lang->line('bca_1029') ?>
                            </button>
                        </div>
                    </div>

                    <div class="collapse" id="collapseExample_ecommerce">
                        <div class="tutorial-modal">
                            <p><?= $this->lang->line('bca_1026') ?></p>
                        </div>
                    </div>

                </div>
            </div>


            <div class="modal-footer">
                <a class="btn btn-outline-secondary float-right" data-dismiss="modal"><i class="bx bx-x"></i> Close</a>
            </div>
        </div>
    </div>
</div>


<hr>
<hr style=" border-top: 1px solid rgb(255 255 255 / 0%); ">



