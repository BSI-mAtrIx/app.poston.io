<style>
    .card {
        padding-top: 0 !important;
    }

    .card .media-body .media-title {
        margin-bottom: 0px !important;
    }

    .card .media-body .page_email {
        line-height: 12px !important;
    }

    .card .page_delete {
        margin-top: 10px;
        margin-right: 10px;
        padding: .1rem .5rem !important;
    }

    .card .right-button {
        margin-top: 10px;
        margin-right: 10px;
        padding: .1rem .5rem !important;
    }

    .card .enable_webhook {
        margin-top: 10px;
        padding: .1rem .5rem !important;
    }

    .card .disable_webhook {
        margin-top: 10px;
        padding: .1rem .5rem !important;
    }

    .profile-widget-header .delete_account {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .profile-widget .profile-widget-items:after {
        position: relative;
    }

    .list-unstyled .media {
        padding-right: 10px;
    }

    .list-unstyled-border li {
        border-bottom: none;
    }

    /* .profile-widget-item{border:none;} */
    .btn-circle {
        margin: 0 !important;
    }

    @media (max-width: 575.98px) {
        .profile-widget {
            margin-top: 0 !important;
        }
    }

</style>
<style type="text/css">

    span.label {
        font-family: serif;
        font-weight: normal;
    }

    span.icon {
        background: url('<?php echo base_url("assets/img/google-sm.png"); ?>') transparent 5px 50% no-repeat;
        vertical-align: middle;
        width: 42px;
        height: 42px;
        display: none;
    }

    .btn-social {
        font-family: 'Roboto', sans-serif;
        font-size: 14px;
        padding-bottom: 10px;
        padding-top: 10px;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
    }

    .btn-social > :first-child {
        line-height: 44px;
    }
</style>

<?php $is_demo = $this->is_demo; ?>

<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"><?php echo $this->lang->line("Business Accounts") ?></h5>
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


<?php
if ($this->session->userdata('success_message') == 'success') {
    echo "<div class='text-info text-center' style='font-size : 20px;'><i class='bx bx-check-circle'></i> " . $this->lang->line('Your account has been imported successfully.') . "</div><br/>";
    $this->session->unset_userdata('success_message');
}

if ($this->session->userdata('limit_cross') != '') {
    echo "<div class='text-danger text-center' style='font-size : 20px;'><i class='bx bx-trash'></i> " . $this->session->userdata('limit_cross') . "</div><br/>";
    $this->session->unset_userdata('limit_cross');
}

if ($this->session->userdata('gmb_login_msg') != '') {
    echo "<div class='text-danger text-center' style='font-size : 20px;'><i class='bx bx-trash'></i> " . $this->session->userdata('gmb_login_msg') . "</div><br/>";
    $this->session->unset_userdata('gmb_login_msg');
}
?>

<?php if ($google_login_button) : ?>
    <div class="section-body">

        <div class="">

            <div class="row  justify-content-center">
                <?php
                if ($is_demo && $this->session->userdata("user_type") == "Admin")
                    echo '<div class="alert alert-danger text-center"><i class="bx bx-time-five"></i>Account import has been disabled in admin account because you will not be able to unlink the Google account you import as admin. If you want to test with your own accout then <a href="' . base_url('home/sign_up') . '" target="_BLANK">sign up</a> to create your own demo account then import your Google account there.</div>'; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($google_login_button) : ?>
    <?php if ($existing_accounts != '0') : ?>

        <div class="content-body" id="stacked-pill">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card bg-transparent shadow-none">
                        <div class="row pills-stacked">
                            <div class="col-md-3 col-sm-12 pl-0 pr-0">
                                <ul class="nav nav-pills flex-column text-center text-md-left">
                                    <li class="nav-item mb-1">
                                        <?php
                                        $google_login_button = str_replace('id="gSignInWrapper"', 'id="gSignInWrapper" class="btn  btn-primary"', $google_login_button);
                                        ?>

                                        <?php if ($this->config->item('developer_access') != '1') echo $google_login_button; ?>
                                    </li>
                                    <?php $i = 0;
                                    foreach ($existing_accounts as $value) : $profile_photo = $value['profile_photo']; ?>
                                        <li class="nav-item pr-0 mr-0">
                                            <a class="nav-link active" id="stacked-pill-1" data-toggle="pill"
                                               href="#vertical-pill-1"
                                               aria-expanded="true">
                                                <div class="card-title-details d-flex align-items-center ">
                                                    <div class="avatar bg-rgba-primary p-25 mr-2 ml-0 width-35-per">
                                                        <img class="img-fluid" src="<?php echo $profile_photo; ?>"
                                                             alt="img placeholder" height="70" width="70"/>
                                                    </div>
                                                    <div class="width-65-per">
                                                        <h4 class="font-small-3 white bold line-ellipsis"><?php echo $value['account_display_name']; ?></h4>
                                                        <div class="font-small-1 line-ellipsis"><?php echo $value['email']; ?>
                                                            <br/>
                                                            <?php echo $this->lang->line("Locations"); ?>
                                                            : <?php echo count($value['location_list']); ?>
                                                        </div>
                                                        <div class="mt-1">
                                                            <button class="delete_account btn-circle btn btn-danger btn-sm"
                                                                    table_id="<?php echo $value['useraccount_table_id']; ?>"
                                                                    data-toggle="tooltip" data-placement="bottom"
                                                                    title="<?php echo $this->lang->line("Do you want to remove this account from our database? you can import again."); ?>">
                                                                <i class="bx bx-trash-alt"></i></button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>

                                </ul>
                            </div>
                            <div class="col-md-9 col-sm-12">
                                <div class="tab-content">
                                    <?php $i = 0;
                                    foreach ($existing_accounts as $value) : $profile_photo = $value['profile_photo']; ?>

                                        <div role="tabpanel" class="tab-pane active" id="vertical-pill-1"
                                             aria-labelledby="stacked-pill-1"
                                             aria-expanded="true">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12 col-xl-12">
                                                    <div class="card-body py-1">

                                                        <div class="main-wrapper-content">
                                                            <div class="wrapper-content"
                                                                 data-earnings="facebook-groups">
                                                                <div class="widget-earnings-scroll table-responsive">
                                                                    <h4 class="card-title"><?php echo $this->lang->line('Location list') ?></h4>
                                                                    <?php if ($this->config->item('facebook_poster_group_enable_disable') == '1') : ?>
                                                                        <div class="card-title-details d-flex align-items-center">

                                                                            <div class="table-responsive">
                                                                                <table class="table table-borderless">
                                                                                    <tbody>

                                                                                    <?php
                                                                                    foreach ($value['location_list'] as $location_info) :
                                                                                        $location_profile_photo = $location_info['profile_google_url'];
                                                                                        if ($location_profile_photo == '') $location_profile_photo = base_url('assets/img/product-4-50.png');
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td class="width-15-per p-0">
                                                                                                <div class="avatar bg-rgba-primary p-25 ml-0">
                                                                                                    <img class="img-fluid"
                                                                                                         src="<?php echo $location_profile_photo; ?>"
                                                                                                         alt="img placeholder"
                                                                                                         height="70"
                                                                                                         width="70">
                                                                                                </div>
                                                                                            </td>
                                                                                            <td class="pl-0">
                                                                                                <div>
                                                                                                    <a target="_BLANK"
                                                                                                       href="<?php echo $location_info['map_url']; ?>">
                                                                                                        <h5 class="font-small-3 bold"><?php echo $location_info['location_display_name']; ?></h5>
                                                                                                    </a>
                                                                                                    <div class="font-small-1">                                                         <?php
                                                                                                        $address_info = json_decode($location_info['address'], true);
                                                                                                        echo isset($address_info['postalCode']) ? $address_info['postalCode'] : "";
                                                                                                        echo ", ";
                                                                                                        echo isset($address_info['locality']) ? $address_info['locality'] : "";
                                                                                                        ?>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </td>
                                                                                            <td class="width-40-per ">
                                                                                                <div class="float-right">

                                                                                                    <a style="margin-top:10px;margin-right:5px;"
                                                                                                       href="#"
                                                                                                       class="btn-circle btn btn-outline-info location_insight"
                                                                                                       redirect_url="<?php echo base_url('gmb/location_insights_basic/') . $location_info['id']; ?>"
                                                                                                       table_id="<?php echo $location_info['id']; ?>"
                                                                                                       title="<?php echo $this->lang->line("Location insight"); ?>"
                                                                                                       data-placement="left"
                                                                                                       data-toggle="tooltip">
                                                                                                        <i class="bx bx-line-chart"></i>
                                                                                                    </a>


                                                                                                    <a style="margin-top:10px;margin-right:5px;"
                                                                                                       href="#"
                                                                                                       class="btn-circle btn btn-outline-danger location_delete"
                                                                                                       table_id="<?php echo $location_info['id']; ?>"
                                                                                                       title="<?php echo $this->lang->line("Delete this location from database."); ?>"
                                                                                                       data-placement="left"
                                                                                                       data-toggle="tooltip">
                                                                                                        <i class="bx bx-trash-alt"></i>
                                                                                                    </a>

                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    <?php endforeach; ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>


                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $i++; endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="card" id="nodata">
            <div class="card-body">
                <div class="empty-state text-center">
                    <img class="img-fluid" style="height: 200px"
                         src="<?php echo base_url('assets/img/drawkit/drawkit-nature-man-colour.svg'); ?>" alt="image">
                    <h2 class="mt-0"><?php echo $this->lang->line("You haven not connected any account yet.") ?></h2>
                    <br/>
                    <h4>
                        <?php echo $google_login_button; ?>
                    </h4>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php else : ?>
    <div class="section-body">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="hero bg-primary text-white">
                    <div class="hero-inner text-center">
                        <h2><?php echo $this->lang->line('Something missing!'); ?></h2>
                        <p class="lead"><?php echo $this->lang->line('No Google APP is configured yet, Admin needs to configure at least one APP.'); ?></p>
                        <?php if ($this->session->userdata('user_type') == 'Admin') : ?>
                            <div class="mt-4">
                                <a href="<?php echo base_url('social_apps/google_settings'); ?>"
                                   class="btn btn-outline-white  btn-icon icon-left"><i
                                            class="bx bx-help-circle"></i> <?php echo $this->lang->line('Setup Google APP'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<div class="modal fade" id="delete_confirmation" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center"><i
                            class="bx bx-flag"></i> <?php echo $this->lang->line("Deletion Report") ?></h4>
            </div>
            <div class="modal-body" id="delete_confirmation_body">

            </div>
        </div>
    </div>
</div>

<?php
$location_delete_confirmation = $this->lang->line("If you delete this location, all the campaigns corresponding to this location will also be deleted. Do you want to delete this location from database?");
$account_delete_confirmation = $this->lang->line("If you delete this account, all the locations and all the campaigns corresponding to this account will also be deleted form database. do you want to delete this account from database?");

?>


