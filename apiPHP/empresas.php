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
    $stmt = $conn->prepare("SELECT * FROM empresas");
    $stmt->execute();
    $empresas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($empresas);
}

//Rota para criar filme
if ($_SERVER ['REQUEST_METHOD'] === 'POST'){
    $empresa = $_POST['empresa'];



    $stmt = $conn->prepare("INSERT INTO empresas (empresa) VALUES (:empresa)");

    $stmt->bindParam(":empresa", $empresa);


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
    $nome = $_PUT['empresa'];


    $stmt = $conn->prepare("UPDATE empresas SET empresa = :empresa WHERE id = :id");

    $stmt->bindParam(":empresa", $empresa);
    
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "reserva atualizado com sucesso!";
    } else {
        echo"erro ao atualizar reserva";
    }

}


