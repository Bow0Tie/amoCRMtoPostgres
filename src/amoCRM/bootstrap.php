<?php

use AmoCRM\Client\AmoCRMApiClient;
use Symfony\Component\Dotenv\Dotenv;

// include_once base_path() . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(base_path() . '/.env');

$clientId = $_ENV['CLIENT_ID'];
$clientSecret = $_ENV['CLIENT_SECRET'];
$redirectUri = $_ENV['CLIENT_REDIRECT_URI'];

$apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);

$var1 = 'xxx';


include_once __DIR__ . '/token_actions.php';
include_once __DIR__ . '/error_printer.php';