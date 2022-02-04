<?php
session_start();
require_once 'lib/php/sql.php';
$objSql = new sql();
$strQuery = "SELECT * FROM sujestao ORDER BY id DESC";
$arrRetornoConsulta = $objSql->executaQuery($strQuery);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Admin</title>
</head>
<header>
    <div class="menu">
        <a href="index">Home</a>
        <a href="admin">Admin</a></div>
</header>
<body class="admin">
   <?php 
    
    if (!empty($_SESSION['sucess'])) {
            echo '<div class="msg-sucess">' . $_SESSION['sucess'] . '</div>';
            $_SESSION['sucess'] = '';
     } 
    ?> 
 <?php    foreach ($arrRetornoConsulta as $resultado) : 
    $strQuery2 = 'SELECT * FROM resposta WHERE sujestao ='.$resultado['id'].'';
    $arrRespondidos = $objSql->executaQuery($strQuery2);
    if($arrRespondidos != "") :
?>
     
        <div class="resposta form">
            <p><?=$resultado['name']?></p>
            <h3><?=$resultado['titulo']?></h3>
            <p class="date"><?=$resultado['date']?></p>
            <p class="resp"><?=$resultado['descricao']?>
            </p>
            <a href="resposta.php?acao=<?=$resultado['id']?>&respondido=yes"><button type="submit" class="btn-respondido" id="">Respondido</button></a>
        </div>
    <?php else: ?> 
    <div class="resposta form">
            
            <p><?=$resultado['name']?></p>
            <h3><?=$resultado['titulo']?></h3>
            <p class="date"><?=$resultado['date']?></p>
            <p class="resp"><?=$resultado['descricao']?>
            </p>
            <a href="resposta.php?acao=<?=$resultado['id']?>"><button type="submit" class="" id="">Responder</button></a>
        </div>

   <?php 
   endif;
endforeach; ?> 
</body>

</html>