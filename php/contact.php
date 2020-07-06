<?php

$array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => "false");
$emailTo = "py.gil.ludovic@outlook.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $array["firstname"] = verifyInput($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["email"] = verifyInput($_POST["email"]);
    $array["phone"] = verifyInput($_POST["phone"]);
    $array["message"] = verifyInput($_POST["message"]);
    $array["isSuccess"] = true;
    $emailText = "";

    if (empty($array["firstname"])) {
        $array["firstnameError"] = "Il me faut ton prénom !!";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "First Name : {$array["firstname"]}\n";
    }
    if (empty($array["name"])) {
        $array["nameError"] = "Ton nom !! Il me faut ton nom !!";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Name : {$array["name"]}\n";
    }
    if (!isEmail($array["email"])) {
        $array["emailError"] = "T'essaies de me rouler ? C'est pas un email ça !";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Email : {$array["email"]}\n";
    }
    if (!isPhone($array["phone"])) {
        $array["phoneError"] = "Que des chiffres et des lettres, stp...";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Phone : {$array["phone"]}\n";
    }
    if (empty($array["message"])) {
        $array["messageError"] = "Alors désolé mais je suis pas devin... Ecris ce que tu veux me dire...";
        $array["isSuccess"] = false;
    } else {
        $emailText .= "Message : {$array["message"]}\n";
    }
    if ($array["isSuccess"]) {
        $headers = "From : {$array["firsname"]} {$array["name"]} <{$array["email"]}>\r\nReply-To : {$array["email"]}";
        mail($emailTo, "Un message de votre site", $emailText, $headers);
    }
    echo json_encode($array);
}
function isEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function verifyInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function isPhone($phone)
{
    return preg_match("/^[0-9 ]*$/", $phone);
}
