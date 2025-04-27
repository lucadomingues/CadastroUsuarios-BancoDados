<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Usuarios</title>
</head>
<body>
    <div class="container">
        <div class="container-menu">
            <?php
                require_once 'classes/Db.class.php';
                require_once 'classes/Usuario.php';

                // Conecta ao banco
                $db = new Db();
                $db->conectar();
                $db->setTabela("usuarios"); // define a tabela

                // PEGAR a conexão manualmente com reflection
                $reflection = new ReflectionClass($db);
                $prop = $reflection->getProperty('conexao');
                $prop->setAccessible(true);
                $conn = $prop->getValue($db); // Aqui temos o PDO

                // Função para buscar usuário por ID
                function buscarUsuario($db, $id) {
                    $reflection = new ReflectionClass($db);
                    $prop = $reflection->getProperty('conexao');
                    $prop->setAccessible(true);
                    $conn = $prop->getValue($db); // Aqui temos o PDO

                    $sql = "SELECT * FROM usuarios WHERE idusuarios = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute([$id]);
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }

                // Excluir usuário
                if (isset($_GET['excluir'])) {
                    $id = $_GET['excluir'];
                    $sql = "DELETE FROM usuarios WHERE idusuarios = ?";
                    $stmt = $conn->prepare($sql);
                    $ok = $stmt->execute([$id]);

                    echo $ok ? "<p style='color:green;'>Usuário excluído com sucesso!</p>" : "<p style='color:red;'>Erro ao excluir usuário.</p>";
                }

                // Atualizar dados se formulário foi enviado
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idusuarios'])) {
                    $id = $_POST['idusuarios'];
                    $cpf = $_POST['cpf'];
                    $nome = $_POST['nome'];
                    $celular = $_POST['celular'];
                    $email = $_POST['email'];
                    $login = $_POST['login'];
                    $senha = $_POST['senha']; // você pode aplicar hash aqui, se quiser

                    $sql = "UPDATE usuarios SET cpf = ?, nome = ?, celular = ?, email = ?, login = ?, senha = ? WHERE idusuarios = ?";
                    $stmt = $conn->prepare($sql);
                    $ok = $stmt->execute([$cpf, $nome, $celular, $email, $login, $senha, $id]);

                    echo $ok ? "<p style='color:green;'>Usuário atualizado com sucesso!</p>" : "<p style='color:red;'>Erro ao atualizar.</p>";
                }

                // Se for edição
                if (isset($_GET['editar'])) {
                    $usuario = buscarUsuario($db, $_GET['editar']);

                    if ($usuario) {
                        ?>
                        <h2>Editar Usuário</h2><br>
                        <form method="POST">
                            <input type="hidden" name="idusuarios" value="<?= $usuario['idusuarios'] ?>">
                            <label>CPF: <br><input type="text" name="cpf" value="<?= $usuario['cpf'] ?>"></label><br>
                            <label>Nome: <br><input type="text" name="nome" value="<?= $usuario['nome'] ?>"></label><br>
                            <label>Celular: <br></b><input type="text" name="celular" value="<?= $usuario['celular'] ?>"></label><br>
                            <label>Email: <br><input type="email" name="email" value="<?= $usuario['email'] ?>"></label><br>
                            <label>Login: <br><input type="text" name="login" value="<?= $usuario['login'] ?>"></label><br>
                            <label>Senha: <br><input type="password" name="senha" value="<?= $usuario['senha'] ?>"></label><br>
                            <input type="submit" id="btnEnviar" value="Salvar">
                        </form>
                            <a href="editar_usuarios.php" class="linkRetornar">Voltar</a>
                        <?php
                    } else {
                        echo "<p>Usuário não encontrado.</p>";
                    }

                } else {
                    // Lista os usuários
                    $sql = "SELECT * FROM usuarios";
                    $stmt = $conn->query($sql);
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    echo "<h2>Lista de Usuários</h2><ul>";
                    foreach ($usuarios as $u) {
                        echo "<li>{$u['nome']} ({$u['email']}) - <a href='editar_usuarios.php?editar={$u['idusuarios']}' class='btnEditar'>Editar</a> | <a href='editar_usuarios.php?excluir={$u['idusuarios']}' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\");' class='btnExcluir'>Excluir</a></li>";
                    }
                    echo "</ul>";

                    echo "<a href='index.php' class='linkRetornar'>Novo Cadastro</a>";
                }
            ?>
        </div>
    </div>
</body>
</html>