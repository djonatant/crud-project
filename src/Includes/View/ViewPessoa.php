<?php
namespace Includes\View;

require_once $_SERVER['DOCUMENT_ROOT'] . '/Magazord/vendor/autoload.php';
use Estrutura\ViewPadrao;
use Estrutura\Rotina;

/**
 * View da rotina de Pessoa.
 * @package Includes
 * @author Djonatan Tristão
 * @since 28/04/2022
 */
class ViewPessoa extends ViewPadrao {

    public function __construct($iAcao, $xDados) {
        $this->acao = $iAcao;
        $this->dados = false;
        $this->dados = $xDados;
        return parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function getRotina() {
        return Rotina::PESSOA;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTitulo() {
        return 'Pessoa';
    }

    /**
     * {@inheritdoc}
     */
    protected function getCampos() {
        return [
              0 => [
                'campo' => $this->getCampoNome(), 'dados' => ['nomeCampo' => 'nome']
                ]
            , 1 => [
                'campo' => $this->getCampoCpf(), 'dados' => ['nomeCampo' => 'cpf']
                ]
            , 2 => [
                'campo' => $this->getCampoCodigo(), 'dados' => ['nomeCampo' => 'chave'], 
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
     * Retorna o campo Nome.
     * @return String
     */
    protected function getCampoNome() {
        $sValor = '';
        if($this->dados !== false) {
            if(method_exists($this->dados, 'getNome')) {
                $sValor = $this->dados->getNome();
            }
        }

        $sCampo  = '';
        $sCampo .= "<div class='col-3'>";
        $sCampo .= "<label for='nome' class='float-left'><strong class='text-danger'>Nome da pessoa:</strong></label>";
        $sCampo .= "<input type='text' class='text-dark font-weight-bold form-control' name='nome' maxlength='255' value='" . $sValor . "' placeholder='Nome da pessoa'>";
        $sCampo .= "<div class='valid-feedback'></div>";
        $sCampo .= "</div>";

        return $sCampo;
    }

    /**
     * Retorna o campo CPF.
     * @return String
     */
    protected function getCampoCpf() {
        $sValor = '';
        if($this->dados !== false) {
            if(method_exists($this->dados, 'getCpf')) {
                $sValor = $this->dados->getCpf();
            }
        }

        $sCampo  = '';
        $sCampo .= "<div class='col-3'>";
        $sCampo .= "<label for='cpf' class='float-left'><strong class='text-danger'>CPF da pessoa:</strong></label>";
        $sCampo .= "<input type='text' class='text-dark font-weight-bold form-control' name='cpf' maxlength='255' value='" . $sValor . "' placeholder='CPF da pessoa'>";
        $sCampo .= "<div class='valid-feedback'></div>";
        $sCampo .= "</div>";

        return $sCampo;
    }

    /**
     * {@inheritdoc}
     */
    protected function getColunasGrid() {
        return ['Código', 'Nome', 'CPF', 'Ações'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getUtilizaCampoPesquisa() {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getConsultaExtraFormulario() {
        return 'Gerenciar contatos';
    }

}