<?php

include __DIR__ . '/services.php';

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

$services = new services();

$redirect_to = $services->$action();

header('location: ' . $redirect_to);
exit();
