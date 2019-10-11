<?php

use app\worker_im\scws\Pscws;

$config_path = 'scws' . DIRECTORY_SEPARATOR;
$pscws = new Pscws();
$pscws->set_dict($config_path . 'dict.utf8.xdb');
$pscws->set_rule($config_path . 'rules.utf8.ini');
$pscws->set_ignore(true);
$pscws->send_text('2017年岁修工程欧阳公寓装修项目');
$words = $pscws->get_tops(100);


$start = true;
$words1 = [];
while ($start) {
    $temp = $pscws->get_result();
    if ($temp) {
        $words1[] = $temp;
    } else {
        $start = false;
        $pscws->close();
    }
}