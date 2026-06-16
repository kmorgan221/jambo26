<?php
define('MyConst', TRUE);

$config = include('config2.php'); 

echo $config['online'];

$config['online']= 'changed here'; 

file_put_contents('config2.php', '<?php if(!defined(\'MyConst\')) {die(\'\'); } return ' . var_export($config, true) . '; ?>');


  ?>