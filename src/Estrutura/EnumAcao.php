<?php

namespace Estrutura;

/**
 * Classe dos enumerados de Açoes padrão.
 * @package Estrutura
 * @author Djonatan Tristão
 * @since 28/04/2022
 */
class EnumAcao {

    const DEFAULT = self::ACAO_CONSULTAR;

    const ACAO_CONSULTAR    = 101;
    const ACAO_INCLUIR      = 102;
    const ACAO_ALTERAR      = 103;
    const ACAO_VISUALIZAR   = 104;
    const ACAO_EXCLUIR      = 105;

}