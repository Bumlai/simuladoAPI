<?php
//hotel.php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    exit;   
}

include 'conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $stmt = $conn->prepare("SELECT * FROM alocacao");
    $stmt->execute();
    $alocacao = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($alocacao);
}

//Rota para criar filme
if ($_SERVER ['REQUEST_METHOD'] === 'POST'){
    $Galpao = $_POST['Galpao'];
    $produto = $_POST['produto'];
    $empresa = $_POST['empresa'];
    $quantidade = $_POST['quantidade'];


    $stmt = $conn->prepare("INSERT INTO alocacao (Galpao, produto, empresa, quantidade) VALUES (:Galpao, :produto, :empresa, :quantidade)");

    $stmt->bindParam(":Galpao", $Galpao);
    $stmt->bindParam(":produto",$produto);
    $stmt->bindParam(":empresa", $empresa);
    $stmt->bindParam(":quantidade",$quantidade);

    //Outros bindParams ...

    if($stmt->execute()){
        echo "reserva criado com sucesso!!";
    }else{
        echo "error ao criar reserva!!";
    }
}

//rota para excluir um filme
// if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])){
//     $id = $_GET['id'];
//     $stmt = $conn->prepare("DELETE FROM alocacao WHERE id = :id");
//     $stmt->bindParam(':id', $id);

//     if($stmt->execute()){
//         echo "reserva excluido com sucesso!!";
//     } else {
//         echo"erro ao excluir reserva";
//     }
// }

//Rota para atualizar um filme existente
if($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])){
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_GET['id'];
    $Galpao = $_PUT['Galpao'];
    $produto = $_PUT['produto'];
    $empresa = $_PUT['empresa'];
    $quantidade = $_PUT['quantidade'];

    $stmt = $conn->prepare("UPDATE alocacao SET Galpao = :Galpao, produto = :produto, empresa = :empresa, quantidade = :quantidade WHERE id = :id");
    $stmt->bindParam(":Galpao", $Galpao);
    $stmt->bindParam(":produto",$produto);
    $stmt->bindParam(":empresa", $empresa);
    $stmt->bindParam(":quantidade", $quantidade);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "reserva atualizado com sucesso!";
    } else {
        echo"erro ao atualizar reserva";
    }

}


