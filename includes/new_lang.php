<?php
session_start();
if(isSet($_GET['lang']))
{
    $lang = $_GET['lang'];
    // register the session and set the cookie
    $_SESSION['lang'] = $lang;
    setcookie("lang", $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']))
{
    $lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['lang']))
{
    $lang = $_COOKIE['lang'];
}
else
{
    $lang = 'ge';
}
switch ($lang) {
    case 'en':
        //English
        $lang_file = 'lang_en.php';
        break;

    case 'ru':
        //Russia
        $lang_file = 'lang_ru.php';
        break;

    case 'ge':
        //Georgian
        $lang_file = 'lang_ge.php';
        break;

    // Default Georgian
    default:
        $lang_file = 'lang_ge.php';

}

include_once 'language/'.$lang_file;
?>
