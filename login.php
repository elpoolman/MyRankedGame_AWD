<?php

$client_id = '515224722556-31hs5sfvrdlepio5cpjkf6qkuhebr0n2.apps.googleusercontent.com';
$redirect_uri = 'http://localhost/php/oauth2callback.php';  
$scope = urlencode('https://www.googleapis.com/auth/gmail.send');
$state = 'security_token_' . bin2hex(random_bytes(16)); 


session_start();
$_SESSION['oauth2state'] = $state;

$url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    'client_id' => $client_id,
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'scope' => $scope,
    'access_type' => 'offline',
    'state' => $state,
    'prompt' => 'consent',
]);

header("Location: $url");
exit();
