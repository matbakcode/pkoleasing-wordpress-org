<?php
//init Timber
$site = new Timber\Timber();

// init App
$app = new WCD\AppController($site, $config);

// wrap user (if app is more than just the webiste)
$currentUser = new WCD\User();
