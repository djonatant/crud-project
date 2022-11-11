/**
 * Método responsável pela criação de botões da tela.
 * @param {String} name 
 * @param {String|Boolean} click 
 * @param {String} sRotina 
 * @param {Integer} iAcao 
 * @param {String|Boolean} xChave 
 */
var Botao = function(name, click, sRotina = '', iAcao = 0, xChave = false) {
    var oBotao = document.getElementsByName(name)[0];
    oBotao.addEventListener('click', click);
    oBotao.rotina   = sRotina;
    oBotao.acao     = iAcao;
    oBotao.new      = `index.php?rot=${sRotina}&aca=102`;
    oBotao.consulta = `index.php?rot=${sRotina}&aca=101`;
    oBotao.edit     = `index.php?rot=${sRotina}&aca=103`;
    oBotao.read     = `index.php?rot=${sRotina}&aca=105`;
    oBotao.contato  = `index.php?rot=Contato&aca=101`;
    oBotao.chave    = xChave;
};

/**
 * Método responsável por submeter as informações dos campos input da tela.
 * @param {Object} param 
 */
var submit = function(param) {
    var iTime           = new Date();
    var aDados          = $(`#${param.currentTarget.rotina}`).serialize();
    aDados              = `${aDados}&rot=${param.currentTarget.rotina}`;
    aDados              = `${aDados}&aca=${param.currentTarget.acao}`;
    var iTime           = Math.round((new Date()).getTime()/1000);
    $.post( "index.php?requisicaoAjax=t&temp=" + iTime, aDados, function( xRetorno ) {
        window.history.back();
    });
};

/**
 * Método responsável por requisitar os dados da consulta.
 * @param {Object} param 
 */
var consultar = function(param) {
    var sRotina        = param.currentTarget.rotina;
    var aDados         = `rot=${sRotina}&aca=${param.currentTarget.acao}`;
    var sCampoPesquisa = $(`[name='campo_pesquisa']`).val();
    if(sCampoPesquisa == undefined) {
        sCampoPesquisa = $(`[name='chave_parent']`).val();
    }
    var iTime          = Math.round((new Date()).getTime()/1000);

    if(sCampoPesquisa != '' && sCampoPesquisa != undefined) {
        aDados += `&findBy=${sCampoPesquisa}`;
    }

    buscaDadosPesquisa(iTime, aDados, sRotina);
};

/**
 * Executa a requisição de consulta
 * @param {Integer} iTime 
 * @param {JSON} aDados 
 */
const buscaDadosPesquisa = (iTime, aDados, sRotina) => {
    $.post("index.php?requisicaoAjax=t&temp=" + iTime, aDados, function( xRetorno ) {
        xRetorno = JSON.parse(xRetorno);
        for(var i = 0; i < xRetorno.length; i++) {
            xRetorno[i].push(`
                <button class='btn btn-warning m-1' name='alterar_${i}' type='button'>Gerenciar</button>
            `);
        }
        var sHtml = '';
        for(var i = 0; i < xRetorno.length; i++) {
            sHtml += `<tr>`;
            for(var x = 0; x < xRetorno[i].length; x++) {
                sHtml += `<th>${xRetorno[i][x]}</th>`;
            }
            sHtml += `</tr>`;
        }
        if(xRetorno.length < 1) {
            sHtml += `<tr><th>Não há registros para mostrar.</th><tr>`;
        }
        $('#consulta_linhas').html(sHtml);
        for(var i = 0; i < xRetorno.length; i++) {
            componente[sRotina]  = new Botao(`alterar_${i}`, redirectAlterar, sRotina, 103, xRetorno[i][0]);
        }
    });
};

/**
 * Método utilizado para redirecionar à página de Inclusão da rotina atual.
 * @param {Object} param 
 */
var redirectInsere = function(param) {
    var sLinkInsere   = param.currentTarget.new;
    var xChave        = $(`[name='chave_parent']`).val();
    gotoUrl(sLinkInsere, {chave_parent: xChave}, 'POST');
}

/**
 * Método utilizado para redirecionar à página de Alteração da rotina atual.
 * @param {Object} param 
 */
var redirectAlterar = function(param) {
    var sLinkConsulta = param.currentTarget.edit;
    var xChave        = param.currentTarget.chave;
    var xChaveParent  = $(`[name='chave_parent']`).val();
    gotoUrl(sLinkConsulta, {chave: xChave, chave_parent: xChaveParent}, 'POST');
}

/**
 * Método utilizado para redirecionar à página de Gerenciar Contato.
 * @param {Object} param 
 */
var redirectContato = function(param) {
    var sLinkConsulta = param.currentTarget.contato;
    var xCampoChave       = $(`[name='chave']`).val();
    var xChaveParent      = $(`[name='chave_parent']`).val();
    if(!xChaveParent) {
        xChaveParent = xCampoChave;
    }

    gotoUrl(sLinkConsulta, {chave_parent: xChaveParent}, 'POST');
}

/**
 * Função utilizada para redirecionar para outra URL passando parametros POST|GET
 * @param {String} path URL
 * @param {JSON} params JSON
 * @param {String} method GET|POST
 */
 function gotoUrl(path, params, method) {
    method = method || "post";
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    if (typeof params === 'string') {
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", 'data');
        hiddenField.setAttribute("value", params);
        form.appendChild(hiddenField);
    }
    else {
        for (var key in params) {
            if (params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                if(typeof params[key] === 'object'){
                    hiddenField.setAttribute("value", JSON.stringify(params[key]));
                }
                else{
                    hiddenField.setAttribute("value", params[key]);
                }
                form.appendChild(hiddenField);
            }
        }
    }

    document.body.appendChild(form);
    form.submit();
}