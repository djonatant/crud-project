<?php
require_once '../Config/Config.php';
require_once PATH_SISTEMA . '/src/Estrutura/Utils.php';
require_once PATH_SISTEMA . '/vendor/autoload.php';

use Estrutura\Rotina;
use Estrutura\EnumAcao;
use Estrutura\Principal;
use Estrutura\Sistema;

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
else {
    $xRotina = Principal::getInstance()->getParametroGet('rot');
    $xAcao   = Principal::getInstance()->getParametroGet('aca');

    if($xRotina === false) {
        $xRotina = Rotina::DEFAULT;
    }
    if($xAcao === false) {
        $xAcao = EnumAcao::DEFAULT;
    }
    
    $sRotina = Sistema::PATH_INC_CONTROLLER . $xRotina;
    $oClasseInicio = new $sRotina($xAcao);
    $oClasseInicio->imprimeTela();
    
}
?>

