<?php

namespace App;

require_once __DIR__ . '/vendor/autoload.php';

$app = new App();
$app->firstTransport();
$app->secondTransport();
$app->thirdTransport();