<?php
if ($this->session->flashdata('success_message') == 1) {
    echo "<div class='alert alert-success text-center'><div class='d-flex align-items-center'><i class='bx bx-check-circle'></i><span> " . $this->lang->line("Your data has been successfully stored into the database.") . "</span></div></div>";
    unset($_SESSION['success_message']);
}

if ($this->session->flashdata('warning_message') == 1) {
    echo "<div class='alert alert-warning text-center'><div class='d-flex align-items-center'><i class='bx bx-error-circle'></i><span> " . $this->lang->line("Something went wrong, please try again.") . "</span></div></div>";
    unset($_SESSION['warning_message']);
}

if ($this->session->flashdata('error_message') == 1) {
    echo "<div class='alert alert-danger text-center'><div class='d-flex align-items-center'><i class='bx bx-trash'></i><span> " . $this->lang->line("Your data was failed to stored into the database.") . "</span></div></div>";
    unset($_SESSION['error_message']);
}

if ($this->session->flashdata('delete_success_message') == 1 || $this->session->flashdata('delete_success') == 1) {
    echo "<div class='alert alert-success text-center'><div class='d-flex align-items-center'><i class='bx bx-check-circle'></i><span> " . $this->lang->line("Your data has been successfully deleted from the database.") . "</span></div></div>";
    unset($_SESSION['delete_success']);
    unset($_SESSION['delete_success_message']);
}

if ($this->session->flashdata('delete_error_message') == 1) {
    echo "<div class='alert alert-danger text-center'><div class='d-flex align-items-center'><i class='bx bx-check-circle'></i><span> " . $this->lang->line("Your was failed to delete from the database.") . "</span></div></div>";
    unset($_SESSION['delete_error_message']);
}

if ($this->session->userdata('payment_cancel') == 1) {
    echo "<div class='alert alert-warning text-center'><div class='d-flex align-items-center'><i class='bx bx-trash'></i><span> " . $this->lang->line("Payment has been cancelled.") . "</span></div></div>";
    $this->session->unset_userdata('payment_cancel');
}

if ($this->session->userdata('payment_success') == 1) {
    echo "<div class='alert alert-success text-center'><div class='d-flex align-items-center'><i class='bx bx-check-circle'></i><span> " . $this->lang->line("Payment has been processed successfully. You may need a logout to affect subscription changes. It may take few minutes to appear payment in this list.") . "</span></div></div>";
    $this->session->unset_userdata('payment_success');
}
?>

