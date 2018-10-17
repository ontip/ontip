<?php
// Settings
$name        = "Erik";
$email       = "noreply@gmail.com";
$to          = "erik.hendrikx@gmail.com";
$from        = "OnTip ";
$subject     = "Here is your attachment";

// this is the real Main body of the mail
$mainMessage = "Hi, here's the file.\n";





$fileatt     = "../site2015/pdf/interne_09022016.pdf";
$fileatttype = "application/pdf";

// Pdf name as shown in mail
$fileattname = "newname.pdf";
$headers     = "From: $from";

// File
$file = fopen($fileatt, 'rb');
$data = fread($file, filesize($fileatt));
fclose($file);



// This attaches the file
$semi_rand     = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
$headers      .= "\nMIME-Version: 1.0\n" .
"Content-Type: multipart/mixed;\n" .
" boundary=\"{$mime_boundary}\"";
$message = "This is a multi-part message in MIME format.\n\n" .
"--{$mime_boundary}\n" .
"Content-Type: text/plain; charset=\"iso-8859-1\n" .
"Content-Transfer-Encoding: 7bit\n\n" .
$mainMessage . "\n\n";

$data = chunk_split(base64_encode($data));
$message .= "--{$mime_boundary}\n" .
"Content-Type: {$fileatttype};\n" .
" name=\"{$fileattname}\"\n" .
"Content-Disposition: attachment;\n" .
" filename=\"{$fileattname}\"\n" .
"Content-Transfer-Encoding: base64\n\n" .
$data . "\n\n" .
"-{$mime_boundary}-\n";

// Send the email
if(mail($to, $subject, $message, $headers)) {

    echo "The email was sent.";

}
else {

    echo "There was an error sending the mail.";

}