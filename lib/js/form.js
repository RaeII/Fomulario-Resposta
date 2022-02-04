$(document).ready(function() {

    $.ajax({
        method  : "GET",
        url     : GLOBAL_LINK + "index.php?acao=busca-permissao",
        data    : {
            
        }
    }).done(function (retorno) {
        retorno = $.parseJSON(retorno);
        if(retorno.sucesso == true){
           $.each(retorno.permissao, function( index, value ) {
                //console.log(index + ' - ' + value.menu);
                $(".menu_"+value.menu).removeClass("hide");
                $(".acao_"+value.acao).removeClass("hide");
           });
        }
    });

    $(".remove").on("click", function () {
        if (confirm("Deseja realmente remover esse registro?")) {
            var objRequisicao = {
                intId 		: $(this).attr('data-id'),
                strTabela 	: $(this).attr('data-table'),
                strAction	: 'DELETE'
            }

            $.ajax({
                method  : "POST",
                url     : GLOBAL_LINK + "lib/php/delete.php",
                data    : {
                    requisicao : objRequisicao
                }
            })
            .done(function (retorno) {
                if (retorno == 1) {
                    location.reload();
                } else {
                    alert("Erro ao remover registro, favor verificar.");
                }
            });
        }
    });
    
    $(".liBanner").click(function () {
        if ($(this).attr("data-href") != "") {
            window.location = $(this).attr("data-href"); 
        }
    });
});

function redirect(strUrl) {
    if (strUrl != "") {
        window.setTimeout(function () {
            window.location = strUrl;
        }, 2000);
    }
}

$("#frmNewsletter").on("submit", function () {
    event.stopPropagation();
    event.preventDefault();
    var objFormData = {"nome" : $("#name").val(), "email" : $("#email").val()};
    $.ajax({
        method  : "GET",
        url     : GLOBAL_LINK + "index.php",
        data    : {
            acao        : "addNewsletter",
            requisicao  : objFormData
        }
    })
    .done(function (retorno) {
        if (retorno) {
            $("#name, #email").val("");
            $("#dvMensagemEmail").html("<div class='alert alert-success'>E-mail adicionado com sucesso!</div>");
        } else {
            $("#dvMensagemEmail").html("<div class='alert alert-danger'>Erro ao adicionar, favor tentar novamente.</div>");
        }
    });
});

$("#contactForm").on("submit", function () {
    event.stopPropagation();
    event.preventDefault();
    var objFormData = {
                        "nome" : $("#yourname").val(), 
                        "email" : $("#youremail").val(), 
                        "assunto" : $("#subject").val(), 
                        "mensagem" : $("#message").val()
                    };
    $.ajax({
        method  : "GET",
        url     : GLOBAL_LINK + "index.php",
        data    : {
            acao        : "enviaContato",
            requisicao  : objFormData
        }
    })
    .done(function (retorno) {
        retorno = $.parseJSON(retorno);
        if (retorno.sucesso) {
            $("#yourname, #youremail, #subject, #message").val("");
            $("#dvMensagemEmail").html("<div class='alert alert-success'>Contato enviado com sucesso!</div>");
        } else {
            $("#dvMensagemEmail").html("<div class='alert alert-danger'>Erro ao enviar contato, favor tentar novamente.</div>");
        }
    });
});

