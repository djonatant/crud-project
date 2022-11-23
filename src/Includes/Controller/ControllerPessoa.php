<?php
namespace Includes\Controller;

use Estrutura\ControllerPadrao;
use Includes\View\ViewPessoa;
use Includes\Model\Pessoa;
use Estrutura\EnumAcao;

/**
 * Controlador para classe de Pessoa.
 * @package Includes
 * @author Djonatan Tristão
 * @since 28/04/2022
 */
class ControllerPessoa extends ControllerPadrao {

    public function __construct($iAcao = false) {
        $this->acao = $iAcao;
    }

    /**
     * Método responsável por realizar busca de dados no banco.
     * @param Boolean|String $sFindBy Valor da coluna a ser utilizada na condição do SQL.
     * @return Array
     */
    public function buscaDados($xFindBy) {
        $oManageFactory = $this->getManageFactory();
        $oRepositorio   = $oManageFactory->getRepository('Includes\Model\Pessoa');
        
        if($xFindBy == false) {
            $aRegistros = $oRepositorio->findAll();
        } else {
            $aRegistros = $oRepositorio->createQueryBuilder('pessoa')
                                    ->where('pessoa.nome LIKE :nome')
                                    ->setParameter('nome', '%'.$xFindBy.'%')
                                    ->getQuery()
                                    ->getResult();
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
            $aRetorno[] = [
                $oRegistro->getId(),
                $oRegistro->getNome(),
                $oRegistro->getCpf()
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
        $oModel->setNome($aDados['nome']);
        $oModel->setCpf($aDados['cpf']);
        
        if(getCpfIsValido($oModel->getCpf())) {
            $oManageFactory = $this->getManageFactory();
            $oManageFactory->persist($oModel);
            $oManageFactory->flush();
        } else {
            disparaErro('CPF inválido.');
        }
    }

    /**
     * Monta um modelo com os parametros e altera no banco de dados.
     * @param Array $aDados Dados com as informações a serem persistidas.
     */
    public function altera($aDados) {
        $oModel = $this->getModel();
        $oModel->setId($aDados['chave']);
        $oModel->setNome($aDados['nome']);
        $oModel->setCpf($aDados['cpf']);
        
        if(getCpfIsValido($oModel->getCpf())) {
            $oManageFactory = $this->getManageFactory();
            $oManageFactory->merge($oModel);
            $oManageFactory->flush();
        } else {
            disparaErro('CPF inválido.');
        }
    }

    /**
     * Monta um modelo com os parametros e exclui do banco de dados.
     * @param Array $aDados Dados com as informações a serem persistidas.
     */
    public function delete($aDados) {
        $oModel = $this->getModel();
        $oModel->setId($aDados['chave']);
        $oModel->setNome($aDados['nome']);
        $oModel->setCpf($aDados['cpf']);
        
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
        $this->Model = new Pessoa;
    }

    /**
     * {@inheritdoc}
     */
    public function getView()
    {
        $xDados = false;
        if($this->acao == EnumAcao::ACAO_ALTERAR 
            || $this->acao == EnumAcao::ACAO_VISUALIZAR) {
            $oManageFactory = $this->getManageFactory();
            $oRepositorio = $oManageFactory->getRepository('Includes\Model\Pessoa');
            if(array_key_exists('chave', $_POST)) {
                $xDados = $oRepositorio->find($_POST['chave']);
            }
        }
        if(!isset($this->View)) {
            $this->View = new ViewPessoa($this->acao, $xDados);
        }
        return $this->View;
    }

}