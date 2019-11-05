<?php

require_once "lib/Client.php";
require_once "lib/Request.php";
foreach(glob("lib/Endpoints/*.php") as $filename)
    require_once $filename;
