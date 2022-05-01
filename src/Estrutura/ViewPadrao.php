<?php
namespace Estrutura;

require_once $_SERVER['DOCUMENT_ROOT'] . '/Magazord/vendor/autoload.php';
use Estrutura\Formulario;
use Estrutura\GridDados;

/**
 * View padrão.
 * @package Estrutura
 * @author Djonatan Tristão
 * @since 28/04/2022
 */
class ViewPadrao {

    public $acao;
    public $dados;

    public function __construct() {
        $sCampo  = $this->iniciaHtml();
        $sCampo .= $this->head();
        $sCampo .= $this->iniciaBody();
        $sCampo .= $this->setConteudo();
        $sCampo .= $this->finalizaBody();
        $sCampo .= $this->finalizaHtml();

        echo $sCampo;
    }

    /**
     * Define o conteúdo que a tela irá possuir. 
     * Caso for uma ação de consultar(101), irá retornar o Grid de dados. 
     * Caso for uma ação de Incluir, Alterar ou Visualizar, irá retornar a tela de formulário.
     * @return String
     */
    public function setConteudo() {
        $sHtml = '';
        $sHtml = $this->getBotaoHome();
        if($this->acao == EnumAcao::ACAO_CONSULTAR) {
            $sHtml .= $this->getTituloRotina('Consulta');
            $sHtml .= $this->getGridDados();
        }
        else if($this->acao == EnumAcao::ACAO_INCLUIR 
            || $this->acao == EnumAcao::ACAO_ALTERAR
            || $this->acao == EnumAcao::ACAO_VISUALIZAR) {
            $sHtml .= $this->getTituloRotina('Manutenção');
            $sHtml .= $this->iniciaFormulario();
        }

        return $sHtml;
    }

    /**
     * Inicia a confecção do Grid.
     * @return String
     */
    public function getGridDados() {
        $oGrid = new GridDados();
        $oGrid->setId($this->getRotina());
        $oGrid->setAcao($this->acao);
        $oGrid->setValorCampoOculto($this->getValorCampoOculto());
        $oGrid->setCampoPesquisa($this->getUtilizaCampoPesquisa());
        $oGrid->setColunas($this->getColunasGrid());
        $oGrid->setValores([['', '<center>Clique em consultar</center>', '', 'Ações']]);
        return $oGrid->renderGrid();
    }

    /**
     * Inicia a confecção do formulário.
     * @return String
     */
    public function iniciaFormulario() {
        $oFormulario = new Formulario();
        $oFormulario->setId($this->getRotina());
        $oFormulario->setAcao($this->acao);
        $oFormulario->setTitle($this->getTitulo());
        $oFormulario->setCampos($this->getCampos());
        $oFormulario->setTituloBotaoConsultaExtra($this->getConsultaExtraFormulario());
        return $oFormulario->renderForm();
    }

    /**
     * Retorna o id da rotina.
     * @return String
     */
    protected function getRotina() {}

    /**
     * Retorna o título da rotina.
     * @return String
     */
    protected function getTitulo() {}

    /**
     * Retorna um array com os campos do formulário.
     * @return Array
     */
    protected function getCampos() {} 

    /**
     * Retorna um array com as colunas do Grid.
     * @return Array
     */
    protected function getColunasGrid() {}

    /**
     * Retorna se o formulário possuirá uma ação extra.
     * @return String
     */
    protected function getConsultaExtraFormulario() {}

    /**
     * Retorna o valor do campo oculto na tela de consulta.
     * @return String
     */
    protected function getValorCampoOculto() {}

    /**
     * Retorna o título da rotina.
     * @param String $sAcao Tipo da ação
     * @return String
     */
    protected function getTituloRotina($sAcao) {
        return '<h2><center>' . $sAcao . ' de ' . $this->getTitulo() . '</center></h2>';
    }

    /**
     * Retorna se utiliza o campo 'Pesquisa' na consulta.
     * @return Boolean
     */
    protected function getUtilizaCampoPesquisa() {
        return false;
    }

    /**
     * Inicia a tag 'html'.
     * @return String
     */
    protected function iniciaHtml() {
        return "<!doctype html>";
    }

    /**
     * Inicia a tag 'head'.
     * @return String
     */
    protected function head() {
        $sCampo  = "<head>";
        $sCampo .= "<link rel='stylesheet' type='text/css' href='assets/css/bootstrap.css'/>";
        $sCampo .= "<script src='assets/js/js_funcao.js'></script>";
        $sCampo .= "<script src='assets/js/js_jquery.min.js'></script>";
        $sCampo .= "<script>componente = [];</script>";
        $sCampo .= "</head>";

        return $sCampo;
    }

    /**
     * Inicia a tag 'body'.
     * @return String
     */
    protected function iniciaBody() {
        return '<body class="container">';
    }

    /**
     * Retorna o botão 'Página Inicial'.
     * @return String
     */
    protected function getBotaoHome() {
        return "<input type='button' class='btn btn-dark m-2' value='Página inicial' onclick='window.location.href = `" . Sistema::INDEX . "`'/>";
    }

    /**
     * Finaliza a tag 'body'.
     * @return String
     */
    protected function finalizaBody() {
        return '</body>';
    }

    /**
     * Finaliza a tag 'html'.
     * @return String
     */
    protected function finalizaHtml() {
        return '</html>';
    }

}