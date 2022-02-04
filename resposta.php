<?php
session_start();
require_once 'lib/php/sql.php';
$id = $_GET['acao'];
$objSql = new sql();
$result = $objSql->loadItem('sujestao',$id,'id');
if(!empty($_GET['respondido'])){
    $strQuery2 = "SELECT * FROM resposta WHERE sujestao = $id";
    $resposta = $objSql->executaQuery($strQuery2);
    $resposta =  $resposta[0]['descricao'];
}else{
    $resposta= ""; 
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Resposta</title>
</head>
<header>
    <div class="menu">
        <a href="index">Home</a>
        <a href="admin">Admin</a></div>
</header>
<body>
    <form action="<?=$resposta == '' ?  'database.php?acao=cadastraResp' : 
    'database.php?acao=alterResp' ?>" method="post" enctype="" id="frmCadastro" class="form form_resp">
        <div>
            <div class="form-group">
                <label class="" for="txtCampo2">Nome:<?=$result['name']?></label>
                <div class="">
                    <div class=" resp resposta">
                        <?=$result['descricao']?>
                    </div>
                </div>
            </div>
        </div>
        <span class="space"></span>
        <div>
            <div class="">
                <label class="" for="">Resposta: </label>
                <div class="">
                    <textarea class="txt_area txt_res" required  id="txt_area" name="item[descricao]" rows="10" cols="1" wrap="hard"><?=$resposta?></textarea>
                  
                      
                </div>
            </div>
            <input type="hidden" name="item[sujestao]" value="<?=$id?>">
            <button type="submit" class="" id="">Enviar</button>
        </div>
    </form>
    <script>
        
    </script>
</body>

</html>