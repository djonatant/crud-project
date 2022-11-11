<?php
namespace Includes\View;

use Estrutura\Principal;
use Estrutura\ViewPadrao;
use Estrutura\Rotina;

/**
 * View da rotina de Contato.
 * @package Includes
 * @author Djonatan Tristão
 * @since 28/04/2022
 */
class ViewContato extends ViewPadrao {

    public function __construct($iAcao, $xDados) {
        $this->acao = $iAcao;
        $this->dados = $xDados;

        return parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function getRotina() {
        return Rotina::CONTATO;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTitulo() {
        return 'Contatos';
    }

    /**
     * {@inheritdoc}
     */
    protected function getCampos() {
        return [
              0 => [
                'campo' => $this->getCampoCodigo()
                ]
            , 1 => [
                'campo' => $this->getCampoTipo()
                ]
            , 2 => [
                'campo' => $this->getCampoDescricao()
                ]
            , 3 => [
                'campo' => $this->getCampoPessoa()
                ]
        ];
    }

    /**
     * Retorna o campo Código.
     * @return String
     */
    protected function getCampoCodigo() {
        $sValor = '';
        if($this->dados !== false) {
            if(method_exists($this->dados, 'getId')) {
                $sValor = $this->dados->getId();
            }
        }

        return "<input type='hidden' class='text-dark font-weight-bold form-control' name='chave' maxlength='11' value='" . $sValor . "' placeholder='Nome da pessoa'>";
    }

    /**
     * Retorna o campo Tipo.
     * @return String
     */
    protected function getCampoTipo() {
        $sValor = '';
        if($this->dados !== false) {
            if(method_exists($this->dados, 'getTipo')) {
                $sValor = $this->dados->getTipo();
            }
        }

        $sCampo  = '';
        $sCampo .= "<div class='col-3'>";
        $sCampo .= "<label for='tipo' class='float-left'><strong class='text-danger'>Tipo de contato:</strong></label>";
        $sCampo .= "<select class='form-select font-weight-bold' name='tipo' placehoder='Tipo de contato'>";
        $sCampo .= "<option value='0' " . (($sValor == 0) ? 'selected' : '') . ">Telefone</option>";
        $sCampo .= "<option value='1' " . (($sValor == 1) ? 'selected' : '') . ">Email</option>";
        $sCampo .= "</select>";
        $sCampo .= "<div class='valid-feedback'></div>";
        $sCampo .= "</div>";

        return $sCampo;
    }

    /**
     * Retorna o campo Descrição
     * @return String
     */
    protected function getCampoDescricao() {
        $sValor = '';
        if($this->dados !== false) {
            if(method_exists($this->dados, 'getDescricao')) {
                $sValor = $this->dados->getDescricao();
            }
        }

        $sCampo  = '';
        $sCampo .= "<div class='col-5'>";
        $sCampo .= "<label for='descricao' class='float-left'><strong class='text-danger'>Descrição do contato:</strong></label>";
        $sCampo .= "<input type='text' class='text-dark font-weight-bold form-control' name='descricao' maxlength='255' value='" . $sValor . "' placeholder='Descrição do contato'>";
        $sCampo .= "<div class='valid-feedback'></div>";
        $sCampo .= "</div>";

        return $sCampo;
    }

    /**
     * Retorna o campo Pessoa.
     * @return String
     */
    protected function getCampoPessoa() {
        $sValor = '';
        if($this->dados !== false) {
            if(method_exists($this->dados, 'getIdPessoa')) {
                $sValor = $this->dados->getIdPessoa();
            } 
        } else {
            $sValor = $_POST['chave_parent'];
        }

        return "<input type='hidden' class='text-dark font-weight-bold form-control' name='chave_parent' maxlength='11' value='" . $sValor . "' placeholder='Código da pessoa'>";
    }

    /**
     * {@inheritdoc}
     */
    protected function getColunasGrid() {
        return ['Código', 'Tipo', 'Descrição', 'Ações'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getValorCampoOculto() {
        return Principal::getInstance()->getParametroPost('chave_parent');
    }

}