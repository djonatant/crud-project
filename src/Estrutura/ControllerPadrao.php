<?php
namespace Estrutura;

require_once $_SERVER['DOCUMENT_ROOT'] . '/Magazord/vendor/autoload.php';
use Estrutura\ManageFactory;

/**
 * Controlador padrão.
 * @package Estrutura
 * @author Djonatan Tristão
 * @since 28/04/2022
 */
class ControllerPadrao {

    public $Model;
    public $View;
    public $acao;

    /**
     * Método responsável por imprimir a tela.
     * @return String
     */
    public function imprimeTela() {
        return $this->getView();
    }

    /**
     * Retorna a conexão com o banco de dados.
     */
    public function getManageFactory() {
        $oManageFactory = new ManageFactory();
        return $oManageFactory->getFactory();
    }
    
    /**
     * Retorna o Model
     * @return Object
     */ 
    public function getModel() {}

    /**
     * Retorna a View
     * @return Object
     */ 
    public function getView() {}

    /**
     * Seta o Model
     */ 
    public function setModel() {}

    /**
     * Seta a View
     */ 
    public function setView() {}

}