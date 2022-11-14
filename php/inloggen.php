<?php
session_start();
require_once 'functions.php';
require_once '../html/header.html';

if (!isset($_SESSION['voornaam'])) {
    if (isset($_POST['verzenden'])) {
        if ($_POST['verzenden'] == "inloggen") {
            $methode = 0;
            $voornaam_inloggen = $_POST['voornaam_inloggen'];
            $achternaam_inloggen = $_POST['achternaam_inloggen'];
            $wachtwoord_inloggen = $_POST['wachtwoord_inloggen'];
            $inlog_array = array($voornaam_inloggen, $achternaam_inloggen);
            if (ingevuld_check(variabelen_strip_trim($inlog_array), $wachtwoord_inloggen, $methode) == TRUE) {
                if (wachtwoord_controle($_POST['wachtwoord_inloggen'], $_POST['voornaam_inloggen'], conn()) == TRUE) {
                    $_SESSION['voornaam'] = $_POST['voornaam_inloggen'];
                    $_SESSION['achternaam'] = $_POST['achternaam_inloggen'];
                    $_SESSION['wachtwoord'] = $_POST['wachtwoord_inloggen'];
                    header('location:inloggen.php');
                } else {
                    echo "Incorrecte gebruikersnaam, achternaam of wachtwoord";
                    require_once '../html/inloggen.html';
                }
            }
        }

        if ($_POST['verzenden'] == "aanmelden") {
            $methode = 1;
            $voornaam_aanmelden = $_POST['voornaam_aanmelden'];
            $achternaam_aanmelden = $_POST['achternaam_aanmelden'];
            $wachtwoord_aanmelden = $_POST['wachtwoord_aanmelden'];
            $email_aanmelden = $_POST['email_aanmelden'];
            $variabelen_array_aanmelden = array($voornaam_aanmelden, $achternaam_aanmelden, $email_aanmelden);
            if (ingevuld_check(variabelen_strip_trim($variabelen_array_aanmelden), $wachtwoord_aanmelden, $methode) == TRUE) {
                aanmelden(conn(), variabelen_strip_trim($variabelen_array_aanmelden), encriptie($wachtwoord_aanmelden));
                $_SESSION['voornaam'] = $voornaam_aanmelden;
                $_SESSION['achternaam'] = $achternaam_aanmelden;
                header('location:inloggen.php');
            } else {
                require_once '../html/aanmelden.html';
            }
        }
    } else {
        require_once '../html/inloggen.html';
        require_once '../html/aanmelden.html';
    }
} else {
    echo 'Welkom: ' . $_SESSION['voornaam'] . ' ' . $_SESSION['achternaam'];
    $session_array = array($_SESSION['voornaam'], $_SESSION['achternaam']);
    if(admin_check(conn(), $session_array)){
        echo '<br> Admin account: ' . $_SESSION['voornaam'] . '.';
    }
    require_once '../html/ingelogd.html';
    if (isset($_POST['uitloggen'])) {
        session_destroy();
        header('location:inloggen.php');
    }
}
?>