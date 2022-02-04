<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Sugestão Prime</title>
</head>
<header>
    <div class="menu">
        <a href="index">Home</a>
        <a href="admin">Admin</a></div>
</header>
<body>
    <form action="database.php?acao=cadastrarForm" method="post" enctype="" id="frmCadastro" class="form">

        <div class="form-group">
            <label class="" for="txtCampo2">Nome:</label>
            <div class="">
                <input autocomplete="none" type="text" required name="item[name]" class="txt_area" value="" required>
            </div>
        </div>
        <div class="form-group">
            <label class="" for="txtCampo2">Titulo:</label>
            <div class="">
                <input autocomplete="none" type="text" required name="item[titulo]" class="txt_area " value="" required>
            </div>
        </div>
        <div class="">
            <label class="" for="">Mensagem: </label>
            <div class="">
                <textarea class="txt_area txt-resposta" required id="txt_area" name="item[descricao]" rows="10" cols="1" wrap="hard">
              </textarea>
            </div>
        </div>
        <div></div>
        <button type="submit" class="" id="">Enviar</button>
        </div>
    </form>

    <script>
        var txtArea = document.getElementById('txt_area')
        txtArea.value = "";
    </script>
</body>

</html>
<?php
