<?php

/**
 * Verifica se é um Cpf válido
 * @return Boolean
 */
function getCpfIsValido($cpf) {
 
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;

}

/**
 * Dispara um alerta na interface e finaliza o programa.
 */
function disparaErro($msg = '') {
    if(array_key_exists('CONTENT_TYPE', $_SERVER)) {
        echo json_encode('<script>alert("' . $msg . '")</script>'); die;
    }
    echo '<script>alert("' . $msg . '")</script>'; die;
}