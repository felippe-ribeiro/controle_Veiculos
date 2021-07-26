<?php
//date_default_timezone_set('America/Fortaleza');
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
// CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
$dataLocal = date('d/m/Y');
$hora = date('H,i');
$date20 = new DateTime();

echo $date20->format('Y-m-d H:i:s');
echo '<br>';

session_start();
$usuarioLogado = $_SESSION['usuarioNome'];
if (! isset($_SESSION["usuarioNome"]) and ! isset($_SESSION["usuarioNome"])) {
    header("Location:index.php");
    exit();
} else {
    echo "Usuario: " . $_SESSION['usuarioNome'];
	
}
?>
<br>
<a href="sair.php">Sair</a>

<!DOCTYPE html>
<html>
<head>
<title>Cadastro</title>

<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!--<link rel="stylesheet" href="css/style.css">-->
<link rel="stylesheet" type="text/css" href="css/custom.css">
<style type="text/css">
.teste {
	font-size: 9px;
}
</style>


<body>
	<table width="100%" border="0" cellspacing="1" cellpadding="1">
		<tr>
			<th scope="col"><ul class="nav nav-tabs">
					<!--<li role="presentation" class="active"><a href="index.php">Início</a></li>-->
					<li role="presentation" class="active"><a
						href="cadastro_pessoas.php">Cadastrar</a></li>
					<li role="presentation"><a href="entrada.php">Liberação de Entrada</a></li>
					<!--<li role="presentation"><a href="s_sair.php">Liberação de Saída</a></li>-->
					<li role="presentation"><a href="r_entrada.php">Relação de Entradas</a></li>
					<!--  <li role="presentation"><a href="r_ent_sai.php">ENTRADA/SAIDA</a></li> -->
					<li role="presentation"><a href="pesquisa.php">Pesquisar Cadastros</a></li>
					<li role="presentation"><a href="changePassword.php">Alterar Senha</a></li>
				</ul>&nbsp;</th>
		</tr>
	</table>
	<div class='container'>
		<fieldset>
			<legend>
				<h1>Formulário de Cadastros</h1>
			</legend>

			<form action="action_foto.php" method="post" id='form-contato'
				enctype='multipart/form-data'>
				<div class="row">
					<label for="nome">Selecionar Foto</label>
					<div class="col-md-2">
						<a href="#" class="thumbnail"> <img src="fotos/padrao.jpg"
							height="190" width="150" id="foto-cliente">
						</a>
					</div>
					<input type="file" name="foto" id="foto" value="foto">
					
				</div>

				<div class="form-group">
					<label for="placa">Matrícula:</label> <input type="placa"
						class="form-control" id="placa" name="placa"
						placeholder="Informe a Matricula (Se não possuir deixar em branco)">

				</div>

				<div class="form-group">
					<label for="tipo">Tipo de Visitante:</label> 
					<select type="tipo" class="form-control" id="tipo" name="tipo" >
						<option value= "Acompanhante">Acompanhante</option>
						<option value="Funcionario">Funcionário</option>
						<option value="Terceiro">Terceiro</option>
						<option value="Visitante">Visitante</option>

					</select>
					<!-- <input type="tipo" class="form-control" id="tipo" name="tipo" placeholder="Informe o Tipo do visitante (funcionário, terceiro, etc)" required maxlength="30"> -->

				</div>
				<div class="form-group">
					<label for="empresa">Empresa:</label> <input type="empresa"
						class="form-control" id="empresa" maxlength="25" name="empresa"
						placeholder="Informe a Empresa" required>

				</div>

				<div class="form-group">
				<label for="nome">Nome:</label>
					 <input type="nome"
						class="form-control" id="nome" maxlength="40" name="nome"
						placeholder="Informe o Nome (Letras Maiúsculas sem acento)" pattern="[A-Z0-9 ]+" title="Apenas Letras Maíusculas sem acento" required>
						<input type="resp_cad" id="resp_cad" name="resp_cad" value="<?=$usuarioLogado?>" hidden>
						
						
					
				</div>
				
				<div class="form-group">
					<label for="identidade">RG:</label> <input type="identidade"
						class="form-control" id="identidade" maxlength="13"
						name="identidade" pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}-[0-9]{1}"
						placeholder="Informe o RG(11.111.111-1)" title="Ex: 11.111.111-1" required>

				</div>
				<legend>
					<h3>Dados do Veículo</h3>
				</legend>
				<div class="form-group">
					<label for="matricula">Placa:</label> <input type="matricula"
						class="form-control" id="matricula" maxlength="8" name="matricula"
						pattern="[A-Z]{3}-[A-Z0-9]{4}" placeholder="Informe a Placa" required
						title="Ex: XXX-0000 (Letras Maiúsculas">

				</div>
				<div class="form-group">
					<label for="veiculo">Veículo:</label> <input type="veiculo"
						class="form-control" id="veiculo" maxlength="20" name="veiculo"
						placeholder="Informe o Veiculo (Letras Maiúsculas sem acento)" pattern="[A-Z0-9 ]+" title="Apenas Letras Maíusculas sem acento" required>

				</div>
				<div class="form-group">
					<label for="cidade">Cidade:</label> <input type="cidade"
						class="form-control" id="cidade" maxlength="13" name="cidade"
						placeholder="Informe a Cidade" required>

				</div>
				<div class="form-group">
					<label for="uf">UF:</label> <input type="uf" class="form-control"
						id="uf" maxlength="2" name="uf" placeholder="Informe o Estado"
						required pattern="[A-Z]{2}" title="Letras Maiusculas, EX: SP">

				</div>


				<div>
					<div class="form-group">

						<input type="datacadastro" name="datacadastro" id="datacadastro"
							disabled value=$dataLocal size="15" style="display: none">

					</div>
					<div class="form-group">
						<label for="acesso">Acesso Liberado: </label> <label
							class="radio-inline"> <input type="radio" name="situacao"
							value="1"> <span class="label label-success">SIM</span>
						</label> <label class="radio-inline"> <input type="radio"
							name="situacao" value="2"> <span class="label label-danger">NAO</span>
						</label>

					</div>

					<input type="hidden" name="acao" value="incluir">
					<button type="submit" class="btn btn-primary" id='botao'>Gravar</button>
					<a href='cadastro_pessoas.php' class="btn btn-danger">Cancelar</a>
			
			</form>
		</fieldset>
	</div>
	<script type="text/javascript" src="js/custom.js"></script>
	</div>
</body>
</head>
<footer>
	&#174; TI HAS
	<article>

</footer>