<?php

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
	add_action('admin_notices', function() {
		echo '<div class="error"><p>Timber not installed. Make sure you run a composer install in the theme directory</p></div>';
	});
	return;
	exit;
}
else {
	require_once(__DIR__ . '/vendor/autoload.php');
}

$loader = new Nette\Loaders\RobotLoader;

$directories = glob(get_stylesheet_directory().'/app/*' , GLOB_ONLYDIR);
foreach($directories as $directory)
	$loader->addDirectory($directory);

$loader->setTempDirectory(get_stylesheet_directory().'/app/temp');
$loader->register(); // Run the RobotLoader

global $slug;
$slug = 'wecode';

$config = [];

require_once(__DIR__."/config/config.php");
require_once(__DIR__."/app/app.php");


@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );