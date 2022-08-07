<?php
include "./db.php";
include "./cust-func.php";

if (isset($_GET['email'])) {
    $sql = "UPDATE email_list SET status=1 WHERE email_id='" . $_GET['email'] . "'";
    if (mysqli_query($connection, $sql)) {
        header("location:" . getHostLink("PHP_small_projects/Email_verification/index.php") . "?email=" . $_GET['email'] . "&&verified");
    } else {
        $msgSend = "Cannot update";
    }
}
