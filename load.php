<?php

require_once "Lib/Client.php";
require_once "Lib/Request.php";
require_once "Lib/Filter.php";
foreach(glob(realpath(__DIR__)."/Lib/Endpoints/*.php") as $filename)
    require_once $filename;
