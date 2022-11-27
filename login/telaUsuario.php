<?php
    require_once 'classes/usuarios.php';
    $u = new Usuario;
?>

<!DOCTYPE html>
<html lang ="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Pessoas Cadastradas</title>
        <link rel="stylesheet" href="css/estilo3.css">
    </head>

    <body>
    <nav>
        <ul id="barra">
            <li><a id="barra-link" href="areaPrivada.php">Voltar</a></td></li>
            <li><a id="barra-link" href="sair.php">Sair</a></li>
        </ul>
    </nav>
        <section>
        <table>
                <tr id="titulo">
                    <td>Nome</td>
                    <td>Telefone</td>
                    <td>Email</td>
                    <td>Opções:</td>
                </tr>
            <?php
            if(isset($_GET['id_session']) && !empty($_GET['id_session'])){
                $dados = $u->buscarUsuId($_GET['id_session']);
                        echo "<tr><td>".$dados['nome']."</td><td>".$dados['telefone']."</td><td>".$dados['email']."</td>"
                        ?>
                        <td>
                        <a href='formularioUsuario.php?id_upd=<?php echo $dados['id_usuario'];?>'>Editar</a>
                        <a href='telaUsuario.php?id=<?php echo $dados['id_usuario'];?>'>Excluir</a></td></tr>
                        <?php
                        echo "</tr>";
                            }

            ?>
    
            </table>
        </section>
    </body>
</html>

<?php
    if(isset($_GET['id'])){
        $id_usuario = addslashes($_GET['id']);
        $u->excluirUsuario($id_usuario);
        header("location: telaUsuario.php");
    }
?>
