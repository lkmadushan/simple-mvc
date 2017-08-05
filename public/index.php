<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\{Router, Request};

Router::start()->direct(Request::uri(), Request::method());
