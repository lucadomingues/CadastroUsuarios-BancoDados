<?php
   include ("classes/Db.class.php");
   include ("classes/Usuario.php");

   // criar um objeto do tipo banco de dados
   $db = new Db();

   // conectar o banco de dados 
   $db -> conectar();

   // informar a tabela que vai usar
   $db->setTabela("usuarios");

   // Pegando a conexão com Reflection
   $reflection = new ReflectionClass($db);
   $prop = $reflection->getProperty('conexao');
   $prop->setAccessible(true);
   $conn = $prop->getValue($db);

   $cpf = $_POST['cpf'];
   // VERIFICA SE O CPF JÁ ESTÁ CADASTRADO
   $sqlVerifica = "SELECT * FROM usuarios WHERE cpf = ?";
   $stmtVerifica = $conn->prepare($sqlVerifica);
   $stmtVerifica->execute([$cpf]);

   if ($stmtVerifica->rowCount() > 0) {
      echo "<p style='color:red;'>Erro: Este CPF já está cadastrado!</p>";
      echo "<a href='index.php'>Voltar para o formulário</a>";
      exit;
   }

//Os dados usados deve vir de uma tela de cadastro, aqui é um exemplo fixo

   $senha = md5("1"); //criação de senha criptografada

   $usuario = new Usuario($_POST['cpf'],
                        $_POST['nome'],
                        $_POST['celular'],
                        $_POST['email'],
                        $_POST['login'],
                        $_POST['senha']);

   $usuario->gravar($db);

   //C(R)UD - Read (ou Recovery) leitura/recuperação de dados

   echo"<hr>";

   $campos = "cpf, nome, email";
   $where = "cpf = '11122233302'";


   $dados = $usuario-> consultar($db, $campos, $where);

   /*
   echo"<pre>";
   print_r($dados);
   */

   if(!empty($dados)){
      foreach($dados as $umUsuario){
         echo "cpf: ".$umUsuario['cpf'];
         echo "<br>nome: ".$umUsuario['nome'];
         echo "<br>email: ".$umUsuario['email'];
      }
   }else{
      header("Location: editar_usuarios.php");
   }

   echo "<hr>";
?>