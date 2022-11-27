<?php
require_once 'classes/usuarios.php';
Class Emprestimo{

    private $pdo;
    public $msgErro ="";

    public function __construct(){
        global $pdo;
        try {
            $pdo = new PDO('mysql:host=localhost;port=8111;dbname=projeto_emprestimos;charset=utf8','root','',array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ));
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();

        }
    }

    public function buscarDados(){
        global $pdo;
        $res = array();
        $cmd = $pdo->query("SELECT * FROM emprestimos ORDER BY devolvido DESC");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function cadastrarEmprestimo($item, $pessoa, $telefone, $data, $devolvido){
        global $pdo;
        $cmd = $pdo->prepare("INSERT INTO emprestimos (nome_item, para_quem, telefone, data_emprestimo, devolvido) VALUES(:n, :p, :t, :d, :e)");
        $cmd->bindValue(":n", $item);
        $cmd->bindValue(":p", $pessoa);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":d", $data);
        $cmd->bindValue(":e", $devolvido);
        $cmd->execute();
        return true;
    }

    public function excluirEmprestimo($id){
        global $pdo;
        $cmd = $pdo->prepare("DELETE FROM emprestimos WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function buscarEmprestimo($id){
        global $pdo;
        $res = array();
        $cmd = $pdo->prepare("SELECT * FROM emprestimos WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function atualizarEmprestimo($id, $item, $nome, $telefone, $data, $datad, $devolvido){
        global $pdo;
        $cmd = $pdo->prepare("UPDATE emprestimos SET nome_item = :i, para_quem = :p, telefone = :t, data_emprestimo = :d, data_devolucao =:m, devolvido = :e WHERE id = :id");
        $cmd->bindValue(":i", $item);
        $cmd->bindValue(":p", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":d", $data);
        $cmd->bindValue(":m", $datad);
        $cmd->bindValue(":e", $devolvido);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }
}