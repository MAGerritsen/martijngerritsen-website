<?php 
if(isset($_POST['submit'])){
    $to = "mail@martijngerritsen.online";
    $from = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $subject = "Form submission";
    $subject2 = "Copy of your form submission";
    $message = $first_name . " " . $last_name . " heeft het volgende geschreven:" . "\n\n" . $_POST['message'];
    $message2 = "Hier is een kopie van uw bericht " . $first_name . "." . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2);
    echo "Mail verzonden! Bedankt voor uw bericht " . $first_name . "\n" . "! Ik zal zo snel mogelijk proberen te reageren.";
    }
?>