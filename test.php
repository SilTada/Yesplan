<?php

use Yesplan\YesplanApi;

header('Content-Type: application/json; charset=utf-8');

require_once('load.php');

$clientname = 'ccdefactorij';
$api_key = '3444A9B0CB4DDAFA5246E84FCF3B2A86';
$event_id = '2015580929-1647640572';


$yesplan = new YesplanApi($clientname, $api_key);


$events = $yesplan->event->findByID($event_id);



echo json_encode($events);
