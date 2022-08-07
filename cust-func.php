<?php
/* ***************************** EMAIL SENDING ***************************** */

function emailSending($senderName = "", $senderEmail = "", $recipientEmail = "", $subject = "", $msgContent = "", $attachment = null)
{
    $separator = md5(time());
    $eol = "\r\n";
    $headers = "From: " . $senderName . " <" . $senderEmail . ">" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;
    $body = "--" . $separator . $eol;
    $body .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
    $body .= "Content-Transfer-Encoding: 8bit" . $eol;
    $body .= $msgContent . $eol;
    $body .= "--" . $separator . $eol;
    if ($attachment != null) {
        $encodedString = $attachment['EncodedString'];
        $filename = $attachment['FileName'];
        $content = $encodedString;
        $body .= "Content-Type:application/octet-stream; name=\"" . $filename . "\"" . $eol;
        $body .= "Content-Transfer-Encoding: base64" . $eol;
        $body .= "Content-Disposition: attachment" . $eol;
        $body .= $content . $eol;
        $body .= "--" . $separator . "--";
    }
    if (mail($recipientEmail, $subject, $body, $headers)) {
        $sendMail = true;
    } else {
        $sendMail = false;
    }
    return $sendMail;
}
function getHostLink($folderPath = "")
{
    $link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . ltrim($folderPath, "/");
    return rtrim($link, "/");
}
/* ***************************** EMAIL SENDING ***************************** */
