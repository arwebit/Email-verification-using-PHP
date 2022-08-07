    <?php
error_reporting(1);
include "./db.php";
include "./cust-func.php";

if (isset($_POST['verifyMail'])) {
    $sent = "";
    $className = "";
    $senderName = "<your name/company name>";
    $senderEmail = "<your email from which you want to send the mail>";
    $recipientEmail = mysqli_real_escape_string($connection, trim($_POST['email_id']));
    $folderPath = "PHP_small_projects/Email_verification/verify_email.php?email=$recipientEmail";
    $subject = "Please verify your mail";
    $msgContent = "Please verify your mail by clicking <a href='" . getHostLink($folderPath) . "'>here</a>";
    $attachment = null;

    $sql = "INSERT INTO email_list VALUES(default,'$recipientEmail',0)";
    if (mysqli_query($connection, $sql)) {
        if (emailSending($senderName, $senderEmail, $recipientEmail, $subject, $msgContent, $attachment)) {
            $msgSend = "A verification link is being sent to your email.";
            $className = "success";
        } else {
            $msgSend = "Could not sent verification link to your email";
            $className = "danger";
        }
    } else {
        $msgSend = "Cannot insert";
        $className = "danger";
    }
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Email verification</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="./style.css" />
    </head>
    <body>
    <div class="main-block">
        <h1>Email verification</h1>
        <form action="" method="post">
            <input type="email" name="email_id" id="email_id" placeholder="Email" required class="form-control"/>
            <b class="text-<?php echo $className; ?>"><?php echo $msgSend; ?></b><br>
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="verifyMail" id="verifyMail">
        Verify email
    </button>
        </form>
        <div style="padding: 20px;">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
$selectQuery = "SELECT * FROM email_list";
$fetch = mysqli_query($connection, $selectQuery);
while ($row = mysqli_fetch_assoc($fetch)) {
    ?>
    <tr>
                    <td>
                    <?php
echo $row['email_id'];
    ?>
                    </td>
                    <td>
<?php
echo $row['status'] == 0 ? "Not verified" : "Verified";
    ?>
                    </td>
                </tr>
        <?php
}
?>

            </tbody>
        </table>
        </div>
        </div>


    </html>