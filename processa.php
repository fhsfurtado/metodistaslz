<?php
    require_once('connect.php');
    $nome = filter_input(INPUT_POST, 'inputNome', FILTER_SANITIZE_STRING);
    $bet = filter_input(INPUT_POST, 'inlineRadioOptions', FILTER_SANITIZE_STRING);
    $stmt = $bd->prepare('INSERT INTO usuarios(nome,data_aposta,bet) VALUES (:nome,NOW(),:bet);');
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':bet', $bet, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: index.php');
?>
