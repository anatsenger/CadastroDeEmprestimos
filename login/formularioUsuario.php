<?php
    require_once 'classes/usuarios.php';
    $u = new Usuario;
?>

<!DOCTYPE html>
<html lang ="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Cadastro Pessoa</title>
        <link rel="stylesheet" href="css/estilo4.css">
    </head>

    <body>
    <nav>
        <ul id="barra">
            <li><a id="barra-link" href="telaUsuario.php">Voltar</a></td></li>
            <li><a id="barra-link" href="sair.php">Sair</a></li>
        </ul>
    </nav>

    
<?php
    if(isset($_GET['id_upd'])){
        $id_upd = $_GET['id_upd'];
        $res = $u->buscarUsuId($id_upd);
    }

    if(isset($_POST['nome'])){
        if(isset($_GET['id_upd']) && !empty($_GET['id_upd'])){
            $id_updu = addslashes($_GET['id_upd']);
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);
            if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha)){
                $u->atualizarUsuario($id_updu, $nome, $telefone, $email, $senha);
                header('location: telaUsuario.php?id_session='.$id_updu);
            }else {
                echo "Preencha todos os dados!!";
            }
        }
    }
?>
        <section>
            <form method="POST">
                <h2>Alterar Dados do Usuário:</h2>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value ="<?php if(isset($res)){echo $res['nome'];} ?>">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" value ="<?php if(isset($res)){echo $res['telefone'];} ?>">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value ="<?php if(isset($res)){echo $res['email'];} ?>">
                <label for="senha">Senha</label>
                <input type="text" name="senha" id="senha" value ="<?php if(isset($res)){echo $res['senha'];} ?>">
                <input type="submit" value="Atualizar">
            </form>
        </section>
    </body>

</html>

