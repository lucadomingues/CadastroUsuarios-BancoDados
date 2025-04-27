<!DOCTYPE html>
<html lang="pt-BR">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Cadastro</title>
</head>
<body>
   <div class="container">
      <div class="container-menu">
         <h1>Cadastre-se</h1>
         <form action="cadastrando.php" method="post">
            <label for="lblCpf">
               CPF: <br>
               <input type="text" name="cpf" required>
            </label><br>
            <label for="lblNome">
               NOME:<br>
               <input type="text" name="nome" required>
            </label><br>
            <label for="lblCelular">
               CELULAR:<br>
               <input type="text" name="celular">
            </label><br>
            <label for="lblEmail">
               E-MAIL:<br>
               <input type="email" name="email">
            </label><br>
            <label for="lblLogin">
               LOGIN:<br>
               <input type="text" name="login" required>
            </label><br>
            <label for="lblSenha">
               SENHA:<br>
               <input type="password" name="senha" required>
            </label><br>

            <label for="inputEnviar">
               <input type="submit" value="Cadastrar" id="btnEnviar">
            </label>
         </form>
   </div>
</body>
</html>