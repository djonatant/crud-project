<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Magazord/vendor/autoload.php';

use Estrutura\Rotina;
use Estrutura\EnumAcao;
use Estrutura\Principal;
use Estrutura\Sistema;
use Includes\Controller\ControllerPessoa;
use Includes\Controller\ControllerContato;

if(array_key_exists('requisicaoAjax', $_GET) && array_key_exists('temp', $_GET)) {
    $sRequisicaoAjax = Principal::getInstance()->getParametroGet('requisicaoAjax');
    $iTimeRequest    = Principal::getInstance()->getParametroGet('temp');
    $bAjaxValido     = ($sRequisicaoAjax == 't');
    
    if($bAjaxValido) {
        $sRotina     = Principal::getInstance()->getParametroPost('rot');
        $iAcao       = Principal::getInstance()->getParametroPost('aca');
        $xFindBy     = Principal::getInstance()->getParametroPost('findBy');
        $sController = Sistema::PATH_INC_CONTROLLER . $sRotina;
        $oController = new $sController($iAcao);

        if($iAcao == EnumAcao::ACAO_CONSULTAR) {
            echo json_encode($oController->select($xFindBy));
        } else if($iAcao == EnumAcao::ACAO_INCLUIR) {
            $oController->insere($_POST);
        } else if($iAcao == EnumAcao::ACAO_ALTERAR) {
            $oController->altera($_POST);
        } else if($iAcao == EnumAcao::ACAO_EXCLUIR) {
            $oController->delete($_POST);
        }
    }
    else {
        die();
    }
} 
else if(array_key_exists('rot', $_GET) && array_key_exists('aca', $_GET)) {
    $iRotina = Principal::getInstance()->getParametroGet('rot');
    if($iRotina == Rotina::PESSOA) {
        $oClasseInicio = new ControllerPessoa(Principal::getInstance()->getParametroGet('aca'));
        $oClasseInicio->imprimeTela();
    } 
    else  if($iRotina == Rotina::CONTATO) {
        $oClasseInicio = new ControllerContato(Principal::getInstance()->getParametroGet('aca'));
        $oClasseInicio->imprimeTela();
    } 
    else {
        echo 'Rotina não informada';
    }
}
?>

