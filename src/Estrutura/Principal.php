<?php
namespace Estrutura;

/**
 * Classe Principal para recursos básicos do sistema.
 * @author Djonatan Tristão
 * @since 28/04/2022
 * @package Estrutura
 */
class Principal {

    static private $instance;

    public function getParametroPost($xParametro) {
        if(array_key_exists($xParametro, $_POST)) {
            return $_POST[$xParametro];
        }
        return false;
    }

    public function getParametroGet($xParametro) {
        if(array_key_exists($xParametro, $_GET)) {
            return $_GET[$xParametro];
        }
        return false;
    }

    /**
     * Retorna uma instancia da classe atual.
     * @return \Principal
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}