<?php

require_once "Lib/Client.php";
require_once "Lib/Request.php";
foreach(glob("Lib/Endpoints/*.php") as $filename)
    require_once $filename;
