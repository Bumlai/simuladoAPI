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
    $stmt = $conn->prepare("SELECT * FROM produtos");
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($produtos);
}

//Rota para criar filme
if ($_SERVER ['REQUEST_METHOD'] === 'POST'){
    $Descricao = $_POST['Descricao'];
    $preco = $_POST['preco'];



    $stmt = $conn->prepare("INSERT INTO produtos (Descricao, preco) VALUES (:Descricao, :preco)");

    $stmt->bindParam(":Descricao", $Descricao);
    $stmt->bindParam(":preco", $preco);


    //Outros bindParams ...

    if($stmt->execute()){
        echo "reserva criado com sucesso!!";
    }else{
        echo "error ao criar reserva!!";
    }
}

// //rota para excluir um filme
// if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])){
//     $id = $_GET['id'];
//     $stmt = $conn->prepare("DELETE FROM clientes WHERE id = :id");
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
    $Descricao = $_PUT['Descricao'];
    $preco = $_PUT['preco'];


    $stmt = $conn->prepare("UPDATE produtos SET Descricao = :Descricao, preco = :preco WHERE id = :id");

    $stmt->bindParam(":Descricao", $Descricao);
    $stmt->bindParam(":preco", $preco);
    
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "reserva atualizado com sucesso!";
    } else {
        echo"erro ao atualizar reserva";
    }

}


