<?php
namespace Includes\Controller;

use Estrutura\ControllerPadrao;
use Estrutura\EnumAcao;
use Includes\View\ViewContato;
use Includes\Model\Contato;

/**
 * Controlador para classe de Contato.
 * @package Includes
 * @author Djonatan Tristão
 * @since 28/04/2022
 */
class ControllerContato extends ControllerPadrao {

    public function __construct($iAcao = false) {
        $this->acao = $iAcao;
    }

    /**
     * Método responsável por realizar busca de dados no banco.
     * @param Boolean|String $sFindBy Valor da coluna a ser utilizada na condição do SQL.
     * @param String $sColuna         Coluna a ser consultada na condição do SQL.
     * @return Array
     */
    public function buscaDados($xFindBy, $sColuna = 'idPessoa') {
        $oManageFactory = $this->getManageFactory();
        $oRepositorio   = $oManageFactory->getRepository('Includes\Model\Contato');
        
        if($xFindBy == false) {
            $aRegistros = $oRepositorio->findAll();
        } else {
            $aRegistros = $oRepositorio->findBy([$sColuna => $xFindBy]);
        }

        return $aRegistros;
    }

    /**
     * Realiza a busca de dados da consulta.
     * @param Boolean|String $sFindBy Valor da coluna a ser utilizada na condição do SQL.
     * @return Array
     */
    public function select($xFindBy = false) {
        $aRegistros = $this->buscaDados($xFindBy);
        
        $aRetorno   = [];
        foreach($aRegistros as $oRegistro) {
            $iTipo = $oRegistro->getTipo();
            $sTipo = 'Email';
            if(!$iTipo) {
                $sTipo = 'Telefone';
            }
            $aRetorno[] = [
                $oRegistro->getId(),
                $sTipo,
                $oRegistro->getDescricao()
            ];
        }
        return $aRetorno;
    }

    /**
     * Monta um modelo com os parametros e insere no banco de dados.
     * @param Array $aDados Dados com as informações a serem persistidas.
     */
    public function insere($aDados) {
        $oModel = $this->getModel();
        $oModel->setId(0);
        $oModel->setTipo($aDados['tipo']);
        $oModel->setDescricao($aDados['descricao']);
        $oModel->setIdPessoa($aDados['chave_parent']);

        $oManageFactory = $this->getManageFactory();
        $oManageFactory->persist($oModel);
        return $oManageFactory->flush();
    }

    /**
     * Monta um modelo com os parametros e altera no banco de dados.
     * @param Array $aDados Dados com as informações a serem persistidas.
     */
    public function altera($aDados) {
        $oModel = $this->getModel();
        $oModel->setId($aDados['chave']);
        $oModel->setTipo($aDados['tipo']);
        $oModel->setDescricao($aDados['descricao']);
        $oModel->setIdPessoa($aDados['chave_parent']);
        $oManageFactory = $this->getManageFactory();
        $oManageFactory->merge($oModel);
        return $oManageFactory->flush();
    }

    /**
     * Monta um modelo com os parametros e exclui do banco de dados.
     * @param Array $aDados Dados com as informações a serem persistidas.
     */
    public function delete($aDados) {
        $oModel = $this->getModel();
        $oModel->setId($aDados['chave']);
        $oModel->setTipo($aDados['tipo']);
        $oModel->setDescricao($aDados['descricao']);
        $oModel->setIdPessoa($aDados['chave_parent']);
        
        $oManageFactory = $this->getManageFactory();
        $oModelToDelete = $oManageFactory->merge($oModel);
        $oManageFactory->remove($oModelToDelete);
        $oManageFactory->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        if(!isset($this->Model)) {
            $this->setModel();
        }
        return $this->Model;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setModel() {
        $this->Model = new Contato;
    }

    /**
     * {@inheritdoc}
     */
    public function getView()
    {
        $xDadoContato = false;
        if($this->acao == EnumAcao::ACAO_ALTERAR 
            || $this->acao == EnumAcao::ACAO_VISUALIZAR) {
            $oManageFactory = $this->getManageFactory();
            $oRepositorio = $oManageFactory->getRepository('Includes\Model\Contato');
            if(array_key_exists('chave', $_POST)) {
                $xDadoContato = $oRepositorio->find($_POST['chave']);
            } 
            else if(array_key_exists('chave_parent', $_POST)) {
                $xDadoContato = $oRepositorio->find($_POST['chave_parent']);
            }
        }
        if(!isset($this->View)) {
            $this->View = new ViewContato($this->acao, $xDadoContato);
        }
        return $this->View;
    }
    
}