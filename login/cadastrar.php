<?php
    require_once 'classes/usuarios.php';
    $u = new Usuario;
?>

<html lang ="pt-br">
<head>
    <meta charset="utf-8">
    <title>Emprestimos Login</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div id="form-body">
        <h1>Cadastrar</h1>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome Completo" maxlength="30">
            <input type="text" name="telefone" placeholder="Telefone" maxlength="30">
            <input type="email" name="email" placeholder="E-mail"maxlength="40">
            <input type="password" name="senha" placeholder="Senha"maxlength="15">
            <input type="password" name="confSenha" placeholder="Confirmar senha"maxlength="15">
            <input type="submit" value="Cadastrar">
            <li><a href="index.php">Voltar</a></li>
        </form>
    </div>
    <?php
    if(isset($_POST['nome'])){
            $nome = addslashes($_POST['nome']);
            $telefone = addslashes($_POST['telefone']);
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);
            $confirmarSenha = addslashes($_POST['confSenha']);

            if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confirmarSenha)){
                $u->conectar();
                if($u->msgErro == ""){
                    if($senha == $confirmarSenha){
                        if($u->cadastrar($nome, $telefone, $email, $senha)){
                            ?>
                            <div id="sucesso">
                                Cadastrado com sucesso! Acesse para entrar
                            </div>
                            <?php
                        }else{
                            ?>
                            <div class="erro">
                                Email já cadastrado!
                            </div>
                            <?php
                        }
                    }else{
                        ?>
                        <div class="erro">
                            Senha e confirmar senha não corerespondem!
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
            }else {
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