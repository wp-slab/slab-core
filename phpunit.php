<?php

include 'vendor/autoload.php';

include 'src/Autoloader.php';
(new Slab\Core\Autoloader)->registerNamespace('Slab\Core', __DIR__ . '/src');
