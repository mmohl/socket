<?php

require_once 'Socket.php';

$socket = new Socket($argv);

$socket->connect();

//Socket::dump();
