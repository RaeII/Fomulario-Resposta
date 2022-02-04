$(document).ready(function() {

    $('#google_translate_element').on("click", function () {

        // Change font family and color
        $("iframe").contents().find(".goog-te-menu2-item div, .goog-te-menu2-item:link div, .goog-te-menu2-item:visited div, .goog-te-menu2-item:active div") //, .goog-te-menu2 *
        .css({
            'color': '#544F4B',
            'background-color': '#e3e3ff',
            'font-family': '"Open Sans",Helvetica,Arial,sans-serif'
        });
    
        // Change hover effects  #e3e3ff = white
        $("iframe").contents().find(".goog-te-menu2-item div").hover(function () {
            $(this).css('background-color', '#17548d').find('span.text').css('color', '#e3e3ff');
        }, function () {
            $(this).css('background-color', '#e3e3ff').find('span.text').css('color', '#544F4B');
        });
    
        // Change Google's default blue border
        $("iframe").contents().find('.goog-te-menu2').css('border', '1px solid #17548d');
    
        $("iframe").contents().find('.goog-te-menu2').css('background-color', '#e3e3ff');
    
        // Change the iframe's box shadow
        $(".goog-te-menu-frame").css({
            '-moz-box-shadow': '0 3px 8px 2px #666666',
            '-webkit-box-shadow': '0 3px 8px 2px #666',
            'box-shadow': '0 3px 8px 2px #666'
        });
    });    

});


$(".btnLimparFormulario").click(function () {
    $("#" + $(this).closest('form').attr("id")).find('input:text, input:hidden, input:password, input:file, select, textarea').val('');
});

$(".btnRemover").click(function () {
    if (confirm("Deseja remover esse registro?")) {
        var strTabela = $(this).attr("data-table"),
            intIndice = $(this).attr("data-id");

        $.ajax({
            url     : GLOBAL_URL_GERAL + "admin/index.php?acao=delete",
            data    : {
                tabela  : strTabela,
                indice  : intIndice
            },
            type    : "GET"
        }).done(function (objRetorno) {
            objRetorno = $.parseJSON(objRetorno);
            var strMensagemRetorno = "";

            if (objRetorno.sucesso == false) {
                $("#dvMensagemRetorno").html('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Erro: </strong>' + objRetorno.strMsgRetorno + '</div>');
            } else {
                $("#dvMensagemRetorno").html('<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Registro excluído com <strong>sucesso</strong>!</div>');

                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            }
        })
    }
});

function logout() {
    if (confirm("Deseja realmente sair do sistema?")) {
        $.ajax({
            url: "../admin/index.php",
            type: "GET",
            data: {var : 'logout'}
        }).done(function(retorno) {
            if (retorno == 1) {
                location.href = "index.php?var=home";
            } else {
                alert("Não foi possível sair do sistema, favor tentar novamente.");
            }
        });
    }
}
