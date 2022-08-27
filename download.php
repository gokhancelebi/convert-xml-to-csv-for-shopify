<?php

$file = __DIR__ . '/files/'.$_GET["file"] .'.csv';


ignore_user_abort(true);

header('Content-type: text/csv');
header('Content-Length: ' . filesize($file));
header('Content-Disposition: attachment; filename="'.$_GET["file"] .'.csv"');

readfile($file);


unlink($file);