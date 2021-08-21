<?php
use Slim\App as App;
use \Firebase\JWT\JWT;
use Tuupola\Middleware\HttpBasicAuthentication as Auth;

require "vendor/autoload.php";

$app = new App([
    'settings' => [
        'displayErrorDetails' => true,
    ],

]);

$app->add(new Auth([
    "users" => [
        "root" => "t00r"
    ],
    "realm" => "Protected",
    "path" => "/",
    "secure" => false
]));

$app->get("/",function($req,$res){
    echo "something";
});

$app->get("/getTokens",function($req,$res){
    $tokens = JWT::encode([
        "iss" => "http://example.org",
        "aud" => "http://example.com",
        "iat" => 1356999524,
        "nbf" => 1357000000,
        "content" => "user-pass"
    ],"helloworld");
    echo $tokens;
});


$app->get("/decodeToken/{tokens}",function($req,$res,$args){
    $tokens = $args["tokens"];
    $payloads = JWT::decode($tokens,"helloworld",array_keys(JWT::$supported_algs));

    var_dump($payloads);
});

$app->run();