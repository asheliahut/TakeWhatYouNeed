<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->map(['POST', 'OPTIONS'], '/graph', 'GraphQlController:handle');
