<?php
namespace Estrutura;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Classe ManageFactory para conexão com o Banco de Dados.
 * @author Djonatan Tristão
 * @since 28/04/2022
 * @package Estrutura
 */
class ManageFactory {

    public function getFactory() {
        $sPath              = __DIR__ . '/src/Includes';
        $oConfig            = Setup::createAnnotationMetadataConfiguration([$sPath], true);
        $aParametrosConexao = [
            'dbname'   => DB_NAME,
            'user'     => DB_USER,
            'password' => DB_PWD,
            'host'     => DB_HOST,
            'driver'   => DB_DRIVER,
        ];

        return EntityManager::create($aParametrosConexao, $oConfig);


    }

}