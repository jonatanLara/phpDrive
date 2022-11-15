<?php
	error_reporting(E_ALL); // Error/Exception engine, always use E_ALL

	ini_set('ignore_repeated_errors', TRUE); // always use TRUE

	ini_set('display_errors', FALSE); // Error/Exception display, use FALSE only in production environment or real server. Use TRUE in development environment

	ini_set('log_errors', TRUE); // Error/Exception file logging engine.

	ini_set("error_log", "php-error.log");
	error_log( "Hello, errors!" );

	include 'api-google/vendor/autoload.php';
	include_once 'GoogleDrive.php';
	$App = new GoogleDrive();
	$App->setPathJASON('phpdrive-368701-c0942e79f987.json');
	$App->createFolder('T1-FN-PROS-DDV-EST-0001');
	echo "<br/> El nombre de la carpeta es: ".$App->getNombreCarpeta();
	echo "<br/> link word: ".$App->getWord();
	echo "<br/> link excel: ".$App->getExcel();
	echo "<br/> link mapa: ".$App->getMapa();
	echo "<br/> link capa: ".$App->getCapa();
	echo "<br/> total de achivos: ".$App->getListFile();

 ?>