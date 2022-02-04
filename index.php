<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Prime Sugestão</title>
</head>

<header>
    <div class="menu">
        <a href="index">Home</a>
        <a href="admin">Admin</a></div>
</header>

<body class="index">

    <?php
       if (!empty($_SESSION['sucess'])) {
            echo '<div class="msg-sucess">' . $_SESSION['sucess'] . '</div>';
            $_SESSION['sucess'] = '';
        } 
    ?>

    <h1>O Núcleo Quer Ouvir Você!</h1>
    <p><span>aaaaaa</span>Para crescer precisamos sempre estar juntos.
Queremos cada vez mais encontrar formas de melhorar a cada dia, você faz parte desse processo!
Pensando nisso, criamos este espaço para que você possa deixar sua ideia, opinião ou sugestão.
A sua participação é muito importante para nós e ficaremos muito contentes com sua contribuição!</p>
    <div class="container-icon">
        <a href="sugestao"><img class="icon-suges" title="Sugestão Prime" src='images/sugestao.png'></a>
        <div class="shadown-icon"></div>
    </div>
</body>

</html>