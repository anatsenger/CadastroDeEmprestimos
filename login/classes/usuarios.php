<?php
Class Usuario{

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

    public function conectar(){
        global $pdo;
        try {
            $pdo = new PDO('mysql:host=localhost;port=8111;dbname=projeto_emprestimos;charset=utf8','root','',array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ));
        } catch (PDOException $e) {
            $msgErro = $e->getMessage();

        }
    }

    public function cadastrar($nome, $telefone, $email, $senha){
        global $pdo;
        //verifica se já existe o email cadastrado;
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
        $sql->bindValue(":e", $email);
        $sql->execute();
        if($sql->rowCount() > 0){
            return false;
        }else{
            $sql = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":t", $telefone);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", $senha);
            $sql->execute();
            return true;
        }
    }

    public function logar($email, $senha){
        global $pdo;
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":s", $senha);
        $sql->execute();
        if($sql->rowCount() > 0){
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true;
        } else {
            return false;
        }
    }


    public function buscarUsuId($id){
        global $pdo;
        $res = array();
        $cmd = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    public function buscarUsu(){
        global $pdo;
        $res = array();
        $cmd = $pdo->query("SELECT * FROM usuarios ORDER BY nome");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    public function atualizarUsuario($id, $nome, $telefone, $email, $senha){
        global $pdo;
        $cmd = $pdo->prepare("UPDATE usuarios SET nome = :n, telefone = :t, email = :e, senha = :s WHERE id_usuario = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":e", $email);
        $cmd->bindValue(":s", $senha);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function excluirUsuario($id){
        global $pdo;
        $cmd = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

}

?>