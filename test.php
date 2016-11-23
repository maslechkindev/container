<?php

require_once(__DIR__.'/ContainerFactory.php');

use container\ContainerFactory;

//$iniObj  = new ContainerFactory('ini', 'some path ini', []);
//$xmlObj  = new ContainerFactory('xml', 'some path xml', []);

$container  = new ContainerFactory();
$container->setAll('xml', __DIR__.'/files/container.xml', []);
$container->setAll('ini', __DIR__.'/files/container.ini', []);
$container->setAll('array', null, ['one_array'=>'array 1','two_array'=>2,'three_array'=>['three_assoc_array' => '3', 'four_assoc_array' => '4']]);
$container->setAll('array', null, ['one_array'=>'array 2','five_array'=>5,'seven_array'=>7]);
$container->setAll('json', null, '{"one_json":"one","two_json":"two"}');
$container->set('once', 'once_value');

//$container->getAll('xml');
//$container->getAll('ini');
//var_dump($container->getAll('array'));
//var_dump($container->getAll('json'));

//var_dump($container->get('one_xml'));



