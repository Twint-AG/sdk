<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests;

use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$env = new Dotenv();
$env->load(__DIR__ . '/../.env');
