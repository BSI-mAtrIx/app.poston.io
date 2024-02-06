<?php
$uriSegment = $this->uri->segment(2);

$aff_dashboard = $get_link = $earnings = $visitor_reports = $withdrawal_method = $withdrawal_requests = '';

if ($uriSegment == 'affiliate_link') $get_link = 'active';
if ($uriSegment == 'earnings' || $uriSegment == '') $earnings = 'active';
if ($uriSegment == 'visitor_reports') $visitor_reports = 'active';
if ($uriSegment == 'withdrawal_method') $withdrawal_method = 'active';
if ($uriSegment == 'withdrawal_requests') $withdrawal_requests = 'active';

?>
<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/logo.png"
                                                     alt='<?php echo $this->config->item("product_short_name"); ?>'></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/favicon.png"
                                                     alt='<?php echo $this->config->item("product_short_name"); ?>'></a>
        </div>
        <ul class="affiliate_sidebar sidebar-menu">
            <li class="menu-header">&nbsp;</li>
            <li class="<?php echo $earnings; ?>">
                <a class="nav-link" href="<?php echo base_url('affiliate_system/earnings'); ?>"><i
                            class="bx bx-dollar-circle"></i>
                    <span><?php echo $this->lang->line('Earnings'); ?></span></a>
            </li>
            <li class="<?php echo $get_link; ?>">
                <a class="nav-link " href="<?php echo base_url('affiliate_system/affiliate_link'); ?>"><i
                            class="bx bx-link"></i> <span><?php echo $this->lang->line('Get Affiliate Link'); ?></span></a>
            </li>
            <li class="<?php echo $visitor_reports; ?>">
                <a class="nav-link" href="<?php echo base_url('affiliate_system/visitor_reports'); ?>"><i
                            class="bx bx-user"></i>
                    <span><?php echo $this->lang->line('Visitor Reports'); ?></span></a>
            </li>
            <li class="<?php echo $withdrawal_method; ?>">
                <a class="nav-link" href="<?php echo base_url('affiliate_system/withdrawal_method'); ?>"><i
                            class="bx bx-slider-alt"></i>
                    <span><?php echo $this->lang->line('Withdrawal Methods'); ?></span></a>
            </li>
            <li class="<?php echo $withdrawal_requests; ?>">
                <a class="nav-link" href="<?php echo base_url('affiliate_system/withdrawal_requests'); ?>"><i
                            class="bx bx-help-circle"></i>
                    <span><?php echo $this->lang->line('Withdrawal Requests'); ?></span></a>
            </li>
        </ul>

    </aside>
</div>
