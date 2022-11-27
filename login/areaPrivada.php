<?php
    require_once 'classes/Emprestimo.php';
    $e = new Emprestimo();

    require_once 'classes/usuarios.php';
    $u = new Usuario;
?>

<?php
    session_start();
    if(!isset($_SESSION['id_usuario'])){
        header("location: index.php");
        exit;
    } else {
        $id_session = $_SESSION['id_usuario'];
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset ="utf-8">
    <title>Emprestimos</title>
    <link rel="stylesheet" href="css/estilo2.css">
</head>
<body>
    <nav>
        <ul id="barra">
            <li><a id="barra-link" href="telaUsuario.php?id_session=<?php echo $id_session;?>">Usuário</a></td></li>
            <li><a id="barra-link" href="sair.php">Sair</a></li>
        </ul>
    </nav>
    <?php
        if(isset($_POST['item'])){
            if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
                $id_upd = addslashes($_GET['id_up']);
                $item = addslashes($_POST['item']);
                $pessoa = addslashes($_POST['paraqm']);
                $telefone = addslashes($_POST['telefone_paraqm']);
                $data = addslashes($_POST['data']);
                $datad = addslashes($_POST['datad']);
                if(empty($datad)){
                    $devolvido = "&#128078";
                } else{
                    $devolvido = "&#128077";
                }
                if(!empty($item) && !empty($pessoa) && !empty($telefone) && !empty($data)){
                    $e->atualizarEmprestimo($id_upd, $item, $pessoa, $telefone, $data, $datad, $devolvido);
                    header("location:areaPrivada.php");
                }else{
                    ?>
                    <div class="erro">
                        Preencha todos os campos!!
                    </div>
                    <?php
                }
            }else{
                $item = addslashes($_POST['item']);
                $pessoa = addslashes($_POST['paraqm']);
                $telefone = addslashes($_POST['telefone_paraqm']);
                $data = addslashes($_POST['data']);
                if(empty($datad)){
                    $devolvido = "&#128078";
                } else{
                    $devolvido = "&#128077";
                }
                if(!empty($item) && !empty($pessoa) && !empty($telefone) && !empty($data)){
                    $e->cadastrarEmprestimo($item, $pessoa, $telefone, $data, $devolvido);
        }else{
        ?>
        <div class="erro">
            Preencha todos os campos!!
        </div>
        <?php
            }
        }
    }
    ?>
    <?php
        if(isset($_GET['id_up'])){
            $id_update = addslashes($_GET['id_up']);
            $res = $e->buscarEmprestimo($id_update);

        }
    ?>

    <section id="esquerda">
        <form method="POST">
            <h2> CADASTRAR NOVO EMPRESTIMO</h2>
            <label for="item">Item emprestato:</label>
            <input type="text" name="item" id="item" value="<?php if(isset($res)){echo $res['nome_item'];} ?>">
            <label for="paraqm">Para quem está emprestando:</label>
            <input type="text" name="paraqm" id="paraqm" value="<?php if(isset($res)){echo $res['para_quem'];} ?>">
            <label for="tefefone_paraqm">Telefone de para quem está emprestando:</label>
            <input type="text" name="telefone_paraqm" id="tefefone_paraqm" value="<?php if(isset($res)){echo $res['telefone'];} ?>">
            <label for="data">Data do empréstimo:</label>
            <input type="date" name="data" id="data" placeholder="dd/mm/yyyy" value="<?php if(isset($res)){echo $res['data_emprestimo'];} ?>">
            <?php if(isset($res)): ?>
                <label for="data">Data de devolução:</label>
                <input type="date" name="datad" id="datad" placeholder="dd/mm/yyyy";}>
            <?php endif; ?>
            
            <input type="submit" value="<?php if(isset($res)){echo "Atualizar";} else{ echo "Cadastrar";} ?>">
            
        </form>
    </section>
    <section id="direita">
    <table>
            <tr id="titulo">
                <td>Item</td>
                <td>Destinatário</td>
                <td>Telefone do Destinatário</td>
                <td>Data do empréstimo</td>
                <td>Data de devolução</td>
                <td colspan="2">Opções:</td>
            </tr>
        <?php
            $dados = $e->buscarDados();
            if(count($dados) > 0){
                for ($i=0; $i < count($dados); $i++) { 
                    echo "<tr>";
                    foreach ($dados[$i] as $k => $v) {
                        if($k != "id"){
                            echo "<td>".$v."</td>";
                        }
                    }
                    ?>
                <td>
                <a href="areaPrivada.php?id_up=<?php echo $dados[$i]['id'];?>">Devolvido</a>
                <a href="areaPrivada.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a></td>
                <?php
                    echo "</tr>";
                }
            } else {
                ?>
                <div class="erro">
                    Ainda não foi realizado nenhum emprestimo!!
                </div>
                <?php
            }
        ?>
        </table>
    </section>
</body>
</html>

<?php

if(isset($_GET['id'])){
    $id_emprest = addslashes($_GET['id']);
    $e->excluirEmprestimo($id_emprest);
    header("location: areaPrivada.php");
}
 

?>

