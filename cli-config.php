<?php

require_once 'Config/Config.php';
require_once 'src/Estrutura/Utils.php';
require_once 'vendor/autoload.php';

$em = (new Estrutura\ManageFactory())->getFactory();
$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
$classes = array(
  $em->getClassMetadata('Includes\Model\Contato'),
  $em->getClassMetadata('Includes\Model\Pessoa')
);
$tool->createSchema($classes);