<?php

function conn()
{
    $host = 'localhost';
    $dbname = 'website';
    $user = 'root';
    $passwordDb = '';

    return $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $passwordDb);
}

function aanmelden($conn, $variabelen_array_aanmelden, $wachtwoord)
{
    $sql = "INSERT INTO gebruikers(`Voornaam`, `Achternaam`,`Emailadres` , `Wachtwoord`)
            VALUES (:voornaam_aanmelden, :achternaam_aanmelden, :email_aanmelden, :wachtwoord_aanmelden)";

    $data = $conn->prepare($sql);
    $data->bindValue('voornaam_aanmelden', $variabelen_array_aanmelden[0]);
    $data->bindValue('achternaam_aanmelden', $variabelen_array_aanmelden[1]);
    $data->bindValue('wachtwoord_aanmelden', $wachtwoord);
    $data->bindValue('email_aanmelden', $variabelen_array_aanmelden[2]);

    $data->execute();
}

function variabelen_strip_trim($variabelen_array)
{
    foreach ($variabelen_array as $var) {
        $var = trim($var);
        $var = strip_tags($var);
    }
    return $variabelen_array;
}

function ingevuld_check($variabelen_array, $wachtwoord, $methode)
{
    $juist_ingevuld = TRUE;
    $melding = "";

    if ($methode == 0 || $methode == 1) {
        if (strlen($variabelen_array[0]) < 1) {
            $melding .= "Voer uw <strong>voornaam</strong> in. <br>";
            $juist_ingevuld = FALSE;
        }
        if (strlen($variabelen_array[1]) < 1) {
            $melding .= "Voer uw <strong>achternaam</strong> in. <br>";
            $juist_ingevuld = FALSE;
        }

        if (strlen($wachtwoord) < 1) {
            $melding .= "Voer uw <strong>wachtwoord</strong> in. <br>";
            $juist_ingevuld = FALSE;
        }
    }
    if ($methode == 1) {
        if (strlen($variabelen_array[2]) < 1) {
            $melding .= "Voer uw <strong>Email-adres</strong> in. <br>";
            $juist_ingevuld = FALSE;
        }
    }

    if ($juist_ingevuld == TRUE) {
        return TRUE;
    } else {
        echo $melding;
        require_once '../html/inloggen.html';
    }
}

function encriptie($wachtwoord) {
    $hash = password_hash($wachtwoord, PASSWORD_BCRYPT);
    return $hash;
}

function wachtwoord_controle($input_gebruiker, $gebruiker, $conn)
{

    $sql = "SELECT `Wachtwoord` FROM gebruikers WHERE `Voornaam` = '$gebruiker'";
    $data = $conn->prepare($sql);
    $data->execute();
    $gebruikers_wachtwoord = $data->fetch();

    if (password_verify($input_gebruiker, $gebruikers_wachtwoord['Wachtwoord']) == TRUE) {
        return TRUE;
    } else {
        echo 'Combinatie van voornaam, achternaam en wachtwoord onjuist!';
        return FALSE;
    }
}

function admin_check($conn, $variabelen_array_sessions)
{
    $sql = "SELECT `Status` FROM gebruikers WHERE `Voornaam` = ? AND `Achternaam` = ?";
    $data = $conn->prepare($sql);
    $data->execute([$variabelen_array_sessions[0], $variabelen_array_sessions[1]]);
    $status = $data->fetch()["Status"];

    if ($status == 1) {
        return TRUE;
    } else {
        return FALSE;
    }

}

?>