<?php
header_remove("X-Powered-By");
require __DIR__ . '/../App/Application.php';

# we keep the main application OUTSIDE the public folder. this way even if your webserver goes fucked
# you dont bleed anything
# this just loads up the Application.php file that by rights should be an object but fuck that. baby steps