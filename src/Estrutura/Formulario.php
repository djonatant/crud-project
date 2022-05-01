<?php
namespace Estrutura;

/**
 * Classe para criação de formulários.
 * @author Djonatan Tristão
 * @since 28/04/2022
 * @package Estrutura
 */
class Formulario {
    
    private $id = 'form'; 
    private $acao;
    private $title;
    private $campos = [];
    private $mensagemAfterProcessa = '';
    private $mensagemTipo = 'success';
    private $fnAfter = 'false';
    private $fnOnError = 'false';
    private $fnOnSuccess = 'false';
    private $fnMessageYes = 'false';
    private $fnMessageNo  = 'false';
    private $limpaCamposAfterProcessa = 'true';
    private $imprimeTitulo = false;
    private $tituloBotaoConsultaExtra = false;
    private $script = [];
    
    /**
     * Renderiza o formulário na tela.
     * @return String
     */
    public function renderForm($bConfirma = true, $bLimpaCampos = true) {
        $sCampo  = $this->init();
        $sCampo .= $this->setDataForm();
        $sCampo .= $this->renderButtonsDefault($bConfirma, $bLimpaCampos);
        $sCampo .= $this->close();
        $sCampo .= $this->renderScript();
        return $sCampo;
    }
    
    /**
     * Inicia a construção do formulário.
     * @return String
     */
    public function init() {
        $sCampo = '';
        if($this->getImprimeTitulo()) {
            $sCampo .= "<h4 class='header-title'>" . $this->getTitle() . "</h4>";
        }
        $sCampo .=  "<form class='needs-validation border container' id='" . $this->getId() . "'>";

        return $sCampo;
    }    
    
    /**
     * Seta os componentes dentro do formulário.
     * @return String
     */
    public function setDataForm() {
        $aCampos = $this->getCampos();
        $sCampo  = '';

        for($i = 0; $i < count($aCampos); $i++) {
            $aComponente = $aCampos[$i];
            $sCampo .=  "<div class='row m-2'>";
            $sCampo .=  $aComponente['campo'];
            $sCampo .=  "</div>";
        }
        return $sCampo;
    }
    
    /**
     * Finaliza o formulário.
     * @return String
     */
    public function close() {
        return "</form>";
    }
    
    /**
     * Renderiza os botões da tela.
     * @param Boolean $bConfirma Utiliza botão de Confirmar
     * @param Boolean $bLimpaCampos Utiliza botão de Limpar os campos
     * @return String
     */
    public function renderButtonsDefault($bConfirma, $bLimpaCampos) {
        $sCampo = '';
        if($this->acao != EnumAcao::ACAO_VISUALIZAR) {
            if($bConfirma) {
                $sCampo .= $this->renderButtonConfirma();
            }
            $sCampo .= "&nbsp;";
            if($bLimpaCampos) {
                $sCampo .= $this->renderButtonLimpaCampos();
            }
            if($this->acao != EnumAcao::ACAO_INCLUIR) {
                $sCampo .= $this->renderButtonExcluir();
            }
            if($this->getTituloBotaoConsultaExtra()) {
                $sCampo .= $this->renderButtonConsultaExtra();
            }
            $sCampo .= $this->renderButtonVoltar();
        } else {
            $sCampo .= $this->renderButtonVoltar();
        }
        
        return $sCampo;
    }
    
    /**
     * Renderiza o botão de 'Confirmar'.
     * @return String
     */
    public function renderButtonConfirma() {
        $sScript = "componente['" . $this->getId() . "']['submit'] = new Botao('submit_form', submit, '" . $this->getId() . "', '" . $this->getAcao() . "')";
        $this->adicionaScript($sScript);
        return "<button class='btn btn-primary m-1' name='submit_form' type='button'>Confirmar</button>";
    }

    /**
     * Renderiza o botão de 'Excluir'.
     * @return String
     */
    public function renderButtonExcluir() {
        $sScript = "componente['" . $this->getId() . "']['submit'] = new Botao('submit_form_exclusao', submit, '" . $this->getId() . "', '" . EnumAcao::ACAO_EXCLUIR . "')";
        $this->adicionaScript($sScript);
        return "<button class='btn btn-danger m-1' name='submit_form_exclusao' type='button'>Excluir registro</button>";
    }
    
    /**
     * Renderiza o botão extra.
     * @return String
     */
    public function renderButtonConsultaExtra() {
        if($this->acao != EnumAcao::ACAO_INCLUIR) {
            $sScript = "componente['" . $this->getId() . "']['submit'] = new Botao('submit_form_extra', redirectContato, '" . $this->getId() . "', '" . EnumAcao::ACAO_CONSULTAR . "')";
            $this->adicionaScript($sScript);
            return "<button class='btn btn-warning m-1' name='submit_form_extra' type='button'>" . $this->getTituloBotaoConsultaExtra() . "</button>";
        }
    }

    /**
     * Renderiza o botão de 'Limpar campos'.
     * @return String
     */
    public function renderButtonLimpaCampos() {
        return "<input type='reset' class='btn btn-primary m-1' value='Limpar campos'>";
    }

    /**
     * Renderiza o botão de 'Voltar'.
     * @return String
     */
    public function renderButtonVoltar() {
        return "<input type='button' class='btn btn-primary m-1' value='Voltar' onclick='window.history.back();'>";
    }

    /**
     * Retorna os scripts da tela.
     * @return Array
     */
    public function getScript() {
        return $this->script;
    }
    
    /**
     * Adiciona um novo script na tela.
     * @param String $sScript
     */
    public function adicionaScript($sScript) {
        $this->script[] = $sScript;
    }

    /**
     * Confecciona os scripts da tela.
     * @return String
     */
    public function renderScript() {
        $aScript = $this->getScript();
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
     * Retorna o título do botão extra da consulta
     * @return String
     */
    public function getTituloBotaoConsultaExtra() {
        return $this->tituloBotaoConsultaExtra;
    }

    /**
     * Seta o título do botão extra da consulta
     * @param String $sTitulo
     */
    public function setTituloBotaoConsultaExtra($sTitulo) {
        $this->tituloBotaoConsultaExtra = $sTitulo;
    }

    /**
     * Retorna se o título deve ser impresso.
     * @return Boolean
     */
    public function getImprimeTitulo() {
        return $this->imprimeTitulo;
    }

    /**
     * Seta se deve imprimir o título do formulário.
     * @param Boolean $imprimeTitulo
     */
    public function setImprimeTitulo($imprimeTitulo) {
        $this->imprimeTitulo = $imprimeTitulo;
    }
    
    /**
     * Retorna o ID do formulário.
     * @return String
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Seta o ID do formulário
     * @param String $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Retorna o título do formulário.
     * @return String
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Seta o título do formulário
     * @param String $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }
    
    /**
     * Retorna os campos do formulário.
     * @return Array
     */
    public function getCampos() {
        return $this->campos;
    }

    /**
     * Seta os campos do formulário
     * @param Array $title
     */
    public function setCampos($campos) {
        $this->campos = $campos;
    }
    
    public function getMensagemAfterProcessa() {
        return $this->mensagemAfterProcessa;
    }

    /**
     * Retorna a ação do formulário.
     * @return Integer
     */
    public function getAcao() {
        return $this->acao;
    }

    /**
     * Seta a ação do formulário.
     * @param Integer $acao
     */
    public function setAcao($acao) {
        $this->acao = $acao;

        return $this;
    }

}
