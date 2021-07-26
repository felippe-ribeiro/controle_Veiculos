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
if (! isset($_SESSION["usuarioNome"]) and ! isset($_SESSION["usuarioNome"])) {
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

// Recebe o id do cliente do cliente via GET
$id_cliente = (isset($_GET['id'])) ? $_GET['id'] : '';

// Valida se existe um id e se ele é numérico
if (! empty($id_cliente) && is_numeric($id_cliente)) :
    
    // Captura os dados do cliente solicitado
    $conexao = conexao::getInstance();
    $sql = 'SELECT id, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, foto, datacadastro FROM tb_cadastro WHERE id = :id';
    $stm = $conexao->prepare($sql);
    $stm->bindValue(':id', $id_cliente);
    $stm->execute();
    $cliente = $stm->fetch(PDO::FETCH_OBJ);

	/* if(!empty($cliente)):

		// Formata a data no formato nacional
		$array_data     = explode('-', $cliente->data_nascimento);
		$data_formatada = $array_data[2] . '/' . $array_data[1] . '/' . $array_data[0];

	   endif; */

endif;

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Editar de Cadastros</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container'>
		<fieldset>
			<legend>
				<h1>Editar Cadastros</h1>
			</legend>
			
			<?php if(empty($cliente)):?>
				<h3 class="text-center text-danger">Cliente não encontrado!</h3>
			<?php else: ?>
				<form action="action_cadastros.php" method="post" id='form-contato'
				enctype='multipart/form-data'>
				<div class="row">
					<label for="nome">Alterar Foto</label>
					<div class="col-md-2">
						<a href="#" class="thumbnail"> <img
							src="fotos/<?=$cliente->foto?>" height="190" width="150"
							id="foto-cliente">
						</a>
					</div>
					<input type="file" name="foto" id="foto" value="foto">
				</div>

				<div class="form-group">
					<label for="matricula">Matrícula:</label> <input type="placa"
						class="form-control" id="placa" name="placa"
						value="<?=$cliente->placa?>" placeholder="Informe a Matricula">

				</div>

				<div class="form-group">
					<label for="tipo">Tipo:</label> <select type="tipo"
						class="form-control" id="tipo" name="tipo">
						<option value="Acompanhante">Acompanhante</option>
						<option value="Funcionario">Funcionário</option>
						<option value="Terceiro">Terceiro</option>
						<option value="Visitante">Visitante</option>

					</select>
					<!--<input type="tipo"  class="form-control" id="tipo" name="tipo" value="<?=$cliente->tipo?>"placeholder="Informe o Tipo">-->

				</div>
				<div class="form-group">
					<label for="nome">Nome:</label> <input type="nome"
						class="form-control" id="nome" maxlength="30" name="nome"
						value="<?=$cliente->nome?>" placeholder="Informe o Nome">

				</div>
				<div class="form-group">
					<label for="identidade">RG:</label> <input type="identidade"
						class="form-control" id="identidade" maxlength="25"
						name="identidade" value="<?=$cliente->identidade?>"
						placeholder="Informe o RG">

				</div>

				<div class="form-group">
					<label for="placa">Placa:</label> <input type="matricula"
						class="form-control" id="matricula" maxlength="12"
						name="matricula" value="<?=$cliente->matricula?>"
						placeholder="Informe a Placa">

				</div>
				<div class="form-group">
					<label for="veiculo">Veículo:</label> <input type="veiculo"
						class="form-control" id="veiculo" maxlength="20" name="veiculo"
						value="<?=$cliente->veiculo?>" placeholder="Informe o Veiculo">

				</div>
				<div class="form-group">
					<label for="cidade">Cidade:</label> <input type="cidade"
						class="form-control" id="cidade" maxlength="13" name="cidade"
						value="<?=$cliente->cidade?>" placeholder="Informe a Cidade">

				</div>
				<div class="form-group">
					<label for="uf">UF:</label> <input type="uf" class="form-control"
						id="uf" maxlength="2" name="uf" value="<?=$cliente->uf?>"
						placeholder="Informe o Estado">

				</div>
				<div class="form-group">
					<label for="empresa">Empresa:</label> <input type="empresa"
						class="form-control" id="empresa" maxlength="25" name="empresa"
						value="<?=$cliente->empresa?>" placeholder="Informe a Empresa">

				</div>


				<div class="form-group">
					<label for="datacadastro">Data Cadastro:</label> <input
						type="datacadastro" class="form-control" id="datacadastro"
						maxlength="10" name="datacadastro"
						value="<?=$cliente->datacadastro?>" placeholder="Informe a Data">

				</div>



				<div class="form-group">
					<label for="acesso">Acesso Liberado: </label> <label
						class="radio-inline"> <input type="radio" name="situacao"
						value="1" Checked> <span class="label label-success">SIM</span>
					</label> <label class="radio-inline"> <input type="radio"
						name="situacao" value="2"> <span class="label label-danger">NAO</span>
					</label>

				</div>
				<input type="hidden" name="acao" value="editar"> <input
					type="hidden" name="id" value="<?=$cliente->id?>"> <input
					type="hidden" name="foto_atual" value="<?=$cliente->foto?>">
				<button type="submit" class="btn btn-primary" id='botao'>Gravar</button>
				<a href='pesquisa.php' class="btn btn-danger">Cancelar</a>
			</form>
			<?php endif; ?>
		</fieldset>

	</div>
	<script type="text/javascript" src="js/custom.js"></script>
</body>
</html>

