<?php

session_start();

$env = parse_ini_file("secrets.ini");

$clientId = $env["clientId"];
$clientSecret = $env["clientSecret"];
$redirectUri = 'http://localhost:8000/dc.php';
$guildId = $env["guildId"];

$authorizationUrl = 'https://discord.com/api/oauth2/authorize';
$tokenUrl = 'https://discord.com/api/oauth2/token';
$userApiUrl = 'https://discord.com/api/users/@me';

if(isset($_SESSION["user"])) {
    header("Location: /");
    exit;
}

if (isset($_SESSION['access_token'])) {
    $accessToken = $_SESSION['access_token'];
    $headers = array(
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/x-www-form-urlencoded'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $userApiUrl."/guilds");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    $serverData = json_decode($response, true);

    $isMember = false;

    foreach($serverData as $data) {
        if ($data["id"] == $guildId) {
            $isMember = true;
        }
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $userApiUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    $userData = json_decode($response, true);

    if ($isMember) {
        $_SESSION["user"] = $userData["id"];
        $_SESSION["avatar"] = $userData["avatar"];
        $_SESSION["username"] = $userData["username"];
        header('Location: /?toast=login');
    } else {
        echo "Sorry, you are not a member of the server kekvland.";
        session_reset();
    }
} elseif (isset($_GET['code'])) {
    $code = $_GET['code'];
    $params = array(
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirectUri
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_URL, $tokenUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    $response = curl_exec($ch);
    curl_close($ch);

    $tokenData = json_decode($response, true);

    var_dump($tokenData);

    $_SESSION['access_token'] = $tokenData['access_token'];

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
} else {
    $authorizationLink = "{$authorizationUrl}?client_id={$clientId}&redirect_uri=" . urlencode($redirectUri) . "&response_type=code&scope=identify%20guilds";
    header('Location: ' . $authorizationLink);    
}
