<?php
session_start();
require_once 'lib/php/sql.php';
$acao = $_GET['acao'];
$item = $_POST['item'];
print_r($item);
$obSJql = new sql();
if (!empty($item)) {
   switch ($acao) {
      case 'cadastrarForm':

         $timezone = new DateTimeZone('America/Sao_Paulo');
         $agora = new DateTime('now', $timezone);
         $item['date'] = $agora->format('d/m/Y');

         $result = $obSJql->executaInsert($item, 'sujestao', 1);
         if($result){
            $_SESSION['sucess'] = 'Sua sugestão foi cadastrada com sucesso!';
         }else{
            $_SESSION['sucess'] = 'Falha ao cadastrar sua sugestão!';
         }
         
         header('location:index.php');
         break;

      case 'cadastraResp':
         $result = $obSJql->executaInsert($item, 'resposta', 1);
         if($result){
            $_SESSION['sucess'] = 'Sua resposta foi cadastrada com sucesso!';
         }else{
            $_SESSION['sucess'] = 'Falha ao cadastrar sua resposta!';
         }
         header('location:admin.php');
         break;
      case 'alterResp':
         $result = $obSJql->executaUpdate($item,'resposta','sujestao');
         if($result){
            $_SESSION['sucess'] = 'Sua resposta foi alterada com sucesso!';
         }else{
            $_SESSION['sucess'] = 'Falha ao alteradar sua resposta!';
         }
         header('location:admin.php');
         break;
   }
}
//header('location:index.php');