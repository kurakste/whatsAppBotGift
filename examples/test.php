<?php 

require_once '../vendor/autoload.php';
require_once '../helpers/vd.php';

use Viber\Blogica\Ymap;

$res = Viber\Blogica\Ymap::getAddresByPos(52.378141, 55.732095);