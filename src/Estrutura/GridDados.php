<?php

namespace Estrutura;

/**
 * Classe de geração do grid de dados.
 * @package Estrutura
 * @author Djonatan Tristão
 * @since 28/04/2022
 */
class GridDados {

    private $id;
    private $colunas = [];
    private $valores = [];
    private $script  = [];
    private $campoPesquisa = false;
    private $valorCampoOculto;
    private $acao;
    
    /**
     * Retorna o grid dados.
     * @return String
     */
    public function renderGrid() {
        $sHtml  = $this->setHead();
        $sHtml .= $this->setBody();
        $sHtml .= $this->closeTags();
        $sHtml .= $this->renderScript();
        return $sHtml;
    }

    /**
     * Seta o head do grid.
     * @return String
     */
    protected function setHead() {
        $sHtml  = "<div class='container border'>";
        $sHtml .= "<table class='table table-striped table-bordered'>";
        $sHtml .= "<thead>";
        $sHtml .= "<tr>";
        $sHtml .= $this->montaCabecalho();
        $sHtml .= $this->renderCampoOculto();
        $sHtml .= $this->renderBotaoInserir() . $this->renderBotaoConsultar();
        if($this->getCampoPesquisa()) {
            $sHtml .= $this->renderCampoPesquisa();
        }
        $sHtml .= "</tr>";
        $sHtml .= "</thead>";

        return $sHtml;
    }

    /**
     * Seta o body do grid.
     * @return String
     */
    public function setBody() {
        $sHtml  = "<tbody id='consulta_linhas'>";
        $sHtml .= $this->montaLinhas();
        $sHtml .= "</tbody>";

        return $sHtml;
    }

    /**
     * Seta a área de títulos do grid.
     * @return String
     */
    protected function montaCabecalho() {
        $aColunas = $this->getColunas();
        $sColunas = '';
        foreach($aColunas as $sColuna) {
            $sColunas .= '<th>' . $sColuna . '</th>';
        }
        return $sColunas;
    }

    /**
     * Seta as linhas do grid.
     * @return String
     */
    protected function montaLinhas() {
        $aValores = $this->getValores();
        $sValores = '';
        foreach($aValores as $aValor) {
            $sValores .= '<tr>';
            foreach($aValor as $sValor) {
                $sValores .= '<th>' . $sValor . '</th>';
            }
            $sValores .= '</tr>';
        }
        return $sValores;
    }

    /**
     * Fecha as tags do grid.
     * @return String
     */
    public function closeTags() {
        $sHtml  = "</table>";
        $sHtml .= "</div>";

        return $sHtml;
    }

    /**
     * Retorna o botão de Consultar.
     * @return String
     */
    public function renderBotaoConsultar() {
        $sScript = "componente['" . $this->getId() . "'] = new Botao('consultar', consultar, '" . $this->getId() . "', '" . $this->getAcao() . "')";
        $this->adicionaScript($sScript);
        return "<button class='btn btn-primary m-1' name='consultar' type='button'>Consultar</button>";
    }

    /**
     * Retorna o campo de pesquisa.
     * @return String
     */
    public function renderCampoPesquisa() {
        $sCampo  = '';
        $sCampo .= "<div class='col-5 mb-2'>";
        $sCampo .= "<label for='nome' class='float-left'><strong class='text-danger'>Pesquisar por nome</strong></label>";
        $sCampo .= "<input type='text' class='text-dark font-weight-bold form-control' name='campo_pesquisa' maxlength='255' placeholder='Digite e clique em consultar'>";
        $sCampo .= "<div class='valid-feedback'></div>";
        $sCampo .= "</div>";

        return $sCampo;
    }

    /**
     * Retorna o campo oculto.
     * @return String
     */
    public function renderCampoOculto() {
        return "<input type='hidden' class='col-2 text-dark font-weight-bold form-control' name='chave_parent' value='" . $this->getValorCampoOculto() . "'>";
    }

    /**
     * Retorna o botão de Inserir.
     * @return String
     */
    public function renderBotaoInserir() {
        $sScript = "componente['" . $this->getId() . "'] = new Botao('insere', redirectInsere, '" . $this->getId() . "', '" . $this->getAcao() . "')";
        $this->adicionaScript($sScript);
        return "<button class='btn btn-success m-1' name='insere' type='button'>Inserir novo</button>";
    }

    /**
     * Retorna o script da tela.
     * @return Array
     */
    public function getScript() {
        return $this->script;
    }
    
    /**
     * Adiciona um novo script na tela.
     */
    public function adicionaScript($sScript) {
        $this->script[] = $sScript;
    }

    /**
     * Confecciona os scripts da tela.
     * @return String
     */
    public function renderScript() {
        $aScript    = $this->getScript();
        $sCodigoJS  = '';
        $sCodigoJS .= '<script>';
        $sCodigoJS .= "componente['" . $this->getId() . "'] = [];";
        foreach($aScript as $sScript) {
            $sCodigoJS .= '
            ';
            $sCodigoJS .= $sScript;
        }
        $sCodigoJS .= '</script>';
        return $sCodigoJS;
    }

    /**
     * Retorna o ID do grid.
     * @return String
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Seta ID do grid.
     * @param String $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Retorna as colunas do grid.
     * @return Array
     */
    public function getColunas()
    {
        return $this->colunas;
    }

    /**
     * Seta as colunas do grid.
     * @param Array $colunas
     */
    public function setColunas($colunas)
    {
        $this->colunas = $colunas;

        return $this;
    }

    /**
     * Retorna os valores do grid.
     * @return Array
     */
    public function getValores()
    {
        return $this->valores;
    }

    /**
     * Seta as linhas do grid.
     * @param Array $valores
     */
    public function setValores($valores)
    {
        $this->valores = $valores;

        return $this;
    }

    /**
     * Retorna a ação atual.
     */
    public function getAcao() {
        return $this->acao;
    }

    /**
     * Seta a ação do grid.
     * @param Integer $acao
     */
    public function setAcao($acao) {
        $this->acao = $acao;

        return $this;
    }

    /**
     * Retorna o campo de pesquisa do grid.
     * @return String
     */
    public function getCampoPesquisa() {
        return $this->campoPesquisa;
    }

    /**
     * Seta se vai utilizar campo pesquisa.
     * @param Boolean $bCampoPesquisa
     */
    public function setCampoPesquisa($bCampoPesquisa) {
        $this->campoPesquisa = $bCampoPesquisa;
    }

    /**
     * Retorna o valor do campo oculto.
     * @return String
     */
    public function getValorCampoOculto() {
        return $this->valorCampoOculto;
    }

    /**
     * Seta o valor do campo oculto.
     * @param String $sValorCampoOculto Valor do campo oculto.
     */
    public function setValorCampoOculto($sValorCampoOculto) {
        $this->valorCampoOculto = $sValorCampoOculto;
    }

}