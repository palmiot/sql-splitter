<?php

include('src/SqlSplitter.php');
include('src/SqlSplitterCli.php');

$work = (new Palmiot\SqlSplitter\SqlSplitterCli([]))->run();

print($work);
