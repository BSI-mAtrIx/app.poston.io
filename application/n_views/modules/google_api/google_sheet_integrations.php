<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0">Google Sheet Integrations</h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>dashboard"><i
                                    class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active">Google Sheet Integrations</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="section-body">
    <div class="card" id="nodata">

        <div class="card-body">

            <div class="empty-state hide_in_iframe <?php if ($this->input->get('page_id', TRUE)) {
                echo "d-none";
            } ?>">
                <img class="img-fluid border p-1 mb-5" style="/* max-width: 90%; */"
                     src="https://marketplace.bcheckin.com/cdn/items/google_sheet_integrations/google_sheet_banner_a.png"
                     alt="image">
                <h2 class="mt-0 title">Select your Pages</h2>
                <form action="" id="carform">
                    <div class="form-group">
                        <select class="form-control" id="pageList" name="page_id"></select>
                    </div>
                    <p><input type="submit" value="Continue" class="btn btn-primary iframed"></p>
                </form>
            </div>

            <?php if ($this->input->get('page_id', TRUE)) {
                $page_id = $this->input->get('page_id');

                // Get User Info
                $bck_join = array('package' => "users.package_id=package.id,left");
                $bck_profile_info = $this->basic->get_data("users", array("where" => array("users.id" => $this->session->userdata("user_id"))), "users.*,package_name", $bck_join);
                $bck_user_password = isset($bck_profile_info[0]["password"]) ? $bck_profile_info[0]["password"] : "";
                $bck_md5_pageID_userPWD = md5($page_id . $bck_user_password);

                $google_sheet_fx = '=Google_Sheet_Integration("' . base_url() . 'google_api/get_all_subscriber?x=' . $page_id . '&y=' . $this->session->userdata('user_id') . '&z=' . $bck_md5_pageID_userPWD . '","","noInherit, noTruncate")';


                ?>


                <div class="container">
                    <h2>1. Choose your template</h2>
                    <br>
                    <!-- Nav pills -->
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item mr-3">
                            <a class="google_sheet_img_template" data-toggle="pill" href="#template_a"><img
                                        src="https://marketplace.bcheckin.com/cdn/items/google_sheet_integrations/gg_subscriber.png"
                                        width="200px">
                                <p><i class="bx bx-user-account"></i> Subscriber</p></a>
                        </li>
                        <li class="nav-item mr-3 d-none">
                            <a class="google_sheet_img_template" data-toggle="pill" href="#template_b"><img
                                        src="https://marketplace.bcheckin.com/cdn/items/google_sheet_integrations/gg_dashboard.png"
                                        width="200px">
                                <p><i class="bx bx-line-chart"></i> Dashboard</p></a>
                        </li>
                        <li class="nav-item mr-3 d-none">
                            <a class="google_sheet_img_template" data-toggle="pill" href="#template_c"><img
                                        src="https://marketplace.bcheckin.com/cdn/items/google_sheet_integrations/gg_order.png"
                                        width="200px">
                                <p><i class="bx bxs-cart-add"></i> Order/Booking</p></a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="template_a" class="container tab-pane"><br>
                            <h3>2. Download template</p></h3>

                            <blockquote class="blockquote">
                                <p class="mb-3"><i class="bx bx-pointer"></i> <a target="_blank"
                                                                                 href="https://docs.google.com/spreadsheets/d/1qEBEsGV4b49Vj8yZFd3nOfxmFVIAYFhhakJgWu9qpt8/edit?usp=sharing"
                                                                                 class="btn btn-primary btn-sm"
                                                                                 id="copyButton_Sub">Copy URL &
                                        Start</a></p>

                                <i class="bx bx-pointer"></i>
                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm google_sheet_img_button border">File
                                </button>
                                <i class="bx bxs-chevron-right"></i>
                                <button type="button" class="btn btn-outline-secondary btn-sm border">Make a copy
                                </button>
                                <i class="bx bxs-chevron-right"></i>
                                <button type="button" class="btn btn-outline-secondary btn-sm border">OK</button>
                                <i class="bx bxs-chevron-right"></i>
                                <button type="button" class="btn btn-outline-secondary btn-sm border">Paste URL</button>
                                <input class="form-control" type="text" id="copyTarget_Sub" style="opacity: 0;"
                                       value='<?= $google_sheet_fx ?>'
                            </blockquote>
                            <script>
                                async function paste(input) {
                                    const text = await navigator.clipboard.readText();
                                    input.value = text;
                                }
                            </script>


                        </div>
                        <div id="template_b" class="container tab-pane fade"><br>
                            <h3>Dashboard</h3>
                            <p><a target="_blank" href="https://www.facebook.com/mike.tmd.50/">Contact the author.</a>
                            </p>
                        </div>
                        <div id="template_c" class="container tab-pane fade"><br>
                            <h3>Order/Booking</h3>
                            <p><a target="_blank" href="https://www.facebook.com/mike.tmd.50/">Contact the author.</a>
                            </p>
                        </div>
                    </div>
                </div>

                <style>

                    .google_sheet_img_template {
                        text-align: center;
                        color: gray;
                    }

                    .google_sheet_img_template img {
                        border: 1px solid #c9c9c9b0;
                        padding: 5px;
                        border-radius: 5px;
                        margin-bottom: 20px;
                    }

                    .google_sheet_img_template:hover {
                        text-decoration: none;
                    }

                    .google_sheet_img_template.active {
                        text-align: center;
                    }

                    .google_sheet_img_template.active img {
                        border: 1px solid #08a763;
                        padding: 5px;
                        border-radius: 5px;
                        box-shadow: 4px 4px 0px 1px hsl(0deg 0% 5% / 11%);
                    }

                    .google_sheet_img_button {
                        background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACIAAAAiCAMAAAANmfvwAAAAk1BMVEURs0b////4+Pj09PT29vYNmD319fXz8/P39/f8/Pzu7u4AsDkAlDEAlC7q6uqv3bmizrjw9//E4Nue2KyRx6nX7dzG5s2Bv5jv+fG83NPq9P+X0qX08PPi8+a42sDA3Mey0LkAjA0AjxxFp2EwoVKVxKGm2LGq0rYArCcut1WHz5dpxoIApgBesHlAu2Hg8PdcwnVkr41VAAABzklEQVQ4jX2U7VbbMAyGbVm1LadJgULoijugY/0Ig+3+r26S1Sah6fbkxD983iO9smSbhkKwjU1IvEBMtiEnG8GXDUjWUIgxUCZAm20EyjbzPiXAQImco2Rc9D7iYrfbyc/s97sNlF0HDtFFE8A7ag9VT11X1SaD8zFAQAxgJF9uK9MzmxnDGsJgEwVJxMaC/X4hEc1g92oU0YAUV6IUL5MorHmgoNUaj4gwjSIawEI5lyuJ1A85L3bpml3VrP5rt0j2Um1jkrTka5Qz9XOWphk5ZCxRTqc7V0TyQt5DGCTHpXKvvA2S0k1OVC2scqvc1JwogJzL2S5LFl3XgX0Uborkhe1S0xfNkvfD4dfKvm6329cPjZL7kTpF2bRtS/abcLcuUXSkPLKl9tLLukieuQUe+zaypPv8PK7sD+FRE2G8sDvxwnbHI8USYqz9XViP7EqUMPayVkZRRl6mRfPdYC9uqKg7Hs3Kvgknu1JR1Ks2Kfr2lKicSz9Sfx6UO+Vj/sVuHg9Drcxn2iMdKffPkdJOy7zE8YWd92xlXqIrkgDLp6clf8zy54CD80jxK8EvhjwbJIuFyAsCL+XBMXpvG/Ll3XFykWPZwCQbPFJ/AaJiMdoMI2p+AAAAAElFTkSuQmCC);
                        background-size: 20px;
                        background-position: left;
                        background-repeat: no-repeat;
                        padding-left: 25px !important;
                    }

                </style>

            <?php } ?>

        </div>
    </div>
</div>
      
            



