<?php
    require_once 'classes/usuarios.php';
    $u = new Usuario;
?>

<html lang ="pt-br>
<head>
    <meta charset="utf-8"/>
    <title>Emprestimos Login</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div id="form-body">
        <h1>Entrar</h1>
        <form method="POST">
            <input type="email" placeholder="Usuário" name="email">
            <input type="password" placeholder="Senha" name="senha">
            <input type="submit" value="Acessar">
            <a href="cadastrar.php">Ainda não é inscrito?<strong> Cadastre-se!</strong>
        </form>
    </div>
    <?php
    if(isset($_POST['email'])){
        $email = addslashes($_POST['email']);
        $senha = addslashes($_POST['senha']);

        if(!empty($email) && !empty($senha)){
            $u->conectar();
            if($u->msgErro==""){
                if($u->logar($email, $senha)){
                    $_SESSION["uruario_logado"] = array('id_usuario');
                    header("location: areaPrivada.php");
                }else{
                    ?>
                    <div class="erro">
                        Email e/ou senha incorretos!!
                    </div>
                    <?php
                }
            }else{
                ?>
                <div class="erro">
                    <?php echo "Erro: ".$u->msgErro; ?>
                </div>
                <?php
            }
        }else{
            ?>
            <div class="erro">
                Preencha todos os campos!!
            </div>
            <?php
        }
    }

    ?>
</body>
</html>