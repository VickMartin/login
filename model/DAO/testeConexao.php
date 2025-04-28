<?php

try {
    // Definir opções para a conexão PDO
    $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    // Estabelecer a conexão PDO
    $conexao = new PDO("mysql:host=localhost;dbname=EducaMentes", "root", "", $options);

    echo "Conexão realizada com sucesso";

    // Exemplo de consulta ao banco de dados
    $sql = "SELECT * FROM cadastroadm"; // Exemplo de consulta
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    // Pegar os resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Exibir os resultados
    echo "<pre>";
    print_r($resultados); // Mostra o conteúdo da tabela 'cadastroadm'
    echo "</pre>";

} catch (PDOException $exe) {
    echo "O erro é: " . $exe->getMessage();
}







?>