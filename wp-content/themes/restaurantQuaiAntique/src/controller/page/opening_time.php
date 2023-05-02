<?php

$aOpeningTime = OpeningTimes::getInstance()->getAllData(' ORDER BY day, timeDay');
require_once(get_template_directory() .'/templates/backoffice/opening_time.php');
require_once(get_template_directory() . '/templates/backoffice/layout.php');