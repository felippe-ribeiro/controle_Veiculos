<?php
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
//date_default_timezone_set('America/Fortaleza');
// enviadata.php
$dataLocal = date('d/m/Y');
$data = time();
$hora = date('H:i:s');
$timestamp = mktime(date("H") - 3, date("i") + 4, 0);
$data = gmdate("H:i:s", $timestamp);

session_start();
$userID = $_SESSION['usuarioId'];
if (!isset($_SESSION["usuarioNome"]) and ! isset($_SESSION["usuarioNome"])) {
    header("Location:index.php");
    exit();
} else {
    echo "Usuario: " . $_SESSION['usuarioNome'];
	
}

?>
<br>
<a href="sair.php">Sair</a>


<?php
require 'conection_cadastro.php';


?>
<!DOCTYPE html>
<html>
<head>


<meta charset="utf-8">
<title>Editar de Cadastros</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<script type="text/javascript">
	function validatePassword(){
		var campo1 = formUser.senha.value;
		var campo2 = formUser.csenha.value;
				
		if (campo1 == campo2){
			document.getElementById('resultado').style.color = "#008B45";
			document.getElementById('resultado').innerHTML = "Senhas digitadas Conferem";
			document.getElementById('botao').disabled = false
			if(campo1.length <=5){
				document.getElementById('resultado2').style.color = "#FF6347";
				document.getElementById('resultado2').innerHTML = "Senhas deve conter mais que 5 caracteres";
				document.getElementById('botao').disabled = true
				return false;
			}else{
				document.getElementById('resultado2').innerHTML = "";
			}
			
		}else{
			document.getElementById('resultado').style.color = "#FF6347";
			document.getElementById('resultado').innerHTML = "Senhas não correspondem";
			document.getElementById('botao').disabled = true
			if(campo1.length <=5){
				document.getElementById('resultado2').style.color = "#FF6347";
				document.getElementById('resultado2').innerHTML = "Senhas deve conter mais que 5 caracteres";
				document.getElementById('botao').disabled = true
				return false;
			}else{
				document.getElementById('resultado2').innerHTML = "";
			}
		return false;
		
		}
		

	}
			
			
	</script>
<body>
	<div class='container'>
		<fieldset>
			<legend>
				<h1>Editar Cadastros</h1>
			</legend>
			
			<?php if (!isset($_SESSION["usuarioNome"]) and ! isset($_SESSION["usuarioNome"])):?>
				<h3 class="text-center text-danger">Por Favor Faça Login</h3>
			<?php else: ?>
			<form name="formUser" action="action_cadastros.php" method="post" id='form-contato'
				enctype='multipart/form-data'>
				<div class="row">
			

				<div class="form-group">
					<label for="matricula">Usuário:</label> <input type="Dados"
						class="form-control" value="<?=$_SESSION['usuarioNome']?>" disabled>
				</div>
				<div class="form-group">
					<label for="matricula">Login:</label> <input type="Dados"
						class="form-control" value="<?=$_SESSION['usuarioEmail']?>" disabled>
				</div>

				
				<div class="form-group">
					<label for="nome">Senha:</label> <input type="password"
						class="form-control" id="senha" maxlength="30" name="senha"
						value="<?=$cliente->nome?>" placeholder="Informe a nova senha">

				</div>
				<div class="form-group">
					<label for="nome">Confirmar Senha:</label> <input type="password"
						class="form-control" id="csenha" maxlength="30" name="csenha"
						value="<?=$cliente->nome?>" placeholder="Repita a nova senha" onkeyup="validatePassword();">
					<span id="resultado">&nbsp;</span></br>
					<span id="resultado2">&nbsp;</span>
				</div>
				
				<input type="hidden" name="acao" value="psw">
				<input type="hidden" name="idUserOnline" value="<?=$userID?>">
				
				<button type="submit" class="btn btn-primary" id='botao' disabled>Gravar</button>
				<a href='entrada.php' class="btn btn-danger">Cancelar</a>
			</form>
			
			<?php endif; ?>
		</fieldset>

	</div>
	<script type="text/javascript" src="js/custom.js"></script>
</body>
</html>

