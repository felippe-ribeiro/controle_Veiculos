<?php
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
   date_default_timezone_set('America/Fortaleza');
// CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
   

$dataLocal = date('d/m/Y');
$hora = date('H,i');
echo '<br>';
echo $dataLocal . " " . $hora;
echo '<br>';   
session_start();
if(!isset($_SESSION["usuarioNome"]) and !isset($_SESSION["usuarioNome"]))
{
	header("Location:index.php");exit;
	}else {
	echo "Usuario: ". $_SESSION['usuarioNome'];
	}
?>
<br> <a href="sair.php">Sair</a>
<?php

require 'conection_cadastro.php';

// Recebe o termo de pesquisa se existir
$termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';

// Verifica se o termo de pesquisa está vazio, se estiver executa uma consulta completa
if (empty($termo)):

	$conexao = conexao::getInstance();
	$sql = 'SELECT id, foto, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, dataentrada, horaentrada, horasaida FROM tb_entrada';
	$stm = $conexao->prepare($sql);
//	$stm->execute();
	$clientes = $stm->fetchAll(PDO::FETCH_OBJ);

else:

	// Executa uma consulta baseada no termo de pesquisa passado como parâmetro
	$conexao = conexao::getInstance();
	$sql = 'SELECT id, foto, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, 
	dataentrada, horaentrada, horasaida FROM tb_entrada WHERE nome LIKE :nome OR matricula LIKE :matricula OR dataentrada LIKE :dataentrada';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(':nome', $termo.'%');
	$stm->bindValue(':matricula', $termo.'%');
	$stm->bindValue(':dataentrada', $termo.'%');
	$stm->execute();
	$clientes = $stm->fetchAll(PDO::FETCH_OBJ);

endif;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Liberar Saída</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
     <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
    .teste {
	font-size: 9px;
}
    </style>
</head>
<body>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <th scope="col"><ul class="nav nav-tabs">
   <!-- <li role="presentation" class="active"><a href="index.php">INICIO</a></li> -->
  <li role="presentation"><a href="cadastro_pessoas.php">Cadastrar</a></li>
  <li role="presentation"><a href="entrada.php">Liberação de Entrada</a></li>
  <li role="presentation" class="active"><a href="s_sair.php">Liberação de Saída</a></li>
  <li role="presentation"><a href="r_entrada.php">Relação de Entradas</a></li>
 <!--  <li role="presentation"><a href="r_ent_sai.php">ENTRADA/SAIDA</a></li> -->
  <li role="presentation" ><a href="pesquisa.php">Pesquisar Cadastros</a></li> 
</ul>&nbsp;</th>
  </tr>
</table>
	<div class='container'>
		<fieldset>

			<!-- Cabeçalho da Listagem -->
			<legend>
			<h1>Liberar Saída</h1></legend>

			<!-- Formulário de Pesquisa -->
			<form action="" method="get" id='form-contato' class="form-horizontal col-md-10">
				<label class="col-md-2 control-label" for="termo">Pesquisar</label>
				<div class='col-md-7'>
			    	<input type="text" class="form-control" id="termo" name="termo" placeholder="Informe a Placa, Nome ou Data de Entrada">
				</div>
			    <button type="submit" class="btn btn-primary">Pesquisar</button>
			    <!-- <a href='listar_entradas.php' class="btn btn-primary">Ver Todos</a> -->
			</form>

			<!-- Link para página de cadastro -->
			<!-- <a href='cadastro_pessoas.php' class="btn btn-success pull-right">Cadastrar Novos</a> -->
			<div class='clearfix'></div>

			<?php if(!empty($clientes)):?>

				<!-- Tabela de Entrada -->
				<table class="table table-striped">
					<tr class='active'>
						<th>Foto</th>
						<th>Matricula</th>
						<th>Nome</th>
						<th>Placa</th>
						<th>Veiculo</th>
						<th>Cidade</th>
						<th>UF</th>
						<th>Empresa</th> 
						<th>Data Entrada</th>
						<th>Hora Entrada</th>
						<th>Hora Saida</th>
						
					</tr>
					<?php foreach($clientes as $cliente):?>
						<tr>
							<td class="warning"><img src='fotos/<?=$cliente->foto?>' height='177' width='133' id="foto-cliente"></td>
                            <td><?=$cliente->placa?></td>
							<td><?=$cliente->nome?></td>
                            
						    <td><?=$cliente->matricula?></td>
							<td><?=$cliente->veiculo?></td>
							<td><?=$cliente->cidade?></td>
							<td><?=$cliente->uf?></td>
							<td><?=$cliente->empresa?></td>
                            
							<td><?=$cliente->dataentrada?></td>
							<td><?=$cliente->horaentrada?></td>
							<td><?=$cliente->horasaida?></td>
							<td class="warning">
							    <a href='s_sair_libera.php?id=<?=$cliente->id?>' class="btn btn-primary">Liberar Saída</a>
								<!-- <a href='javascript:void(0)' class="btn btn-danger link_exclusao" rel="<?=$cliente->id?>">Excluir</a> -->
							</td>
							
						</tr>	
					<?php endforeach;?>
				</table>

			<?php else: ?>

				<!-- Mensagem caso não exista clientes ou não encontrado  -->
				<h3 class="text-center text-primary">Por favor digite a Matrícula, Nome, ou Data de entrada.</h3>
			<?php endif; ?>
		</fieldset>
	</div>
	<script type="text/javascript" src="js/custom.js"></script>
</body>
</html>
<footer>
  &#174; TI HAS<article>
</footer>
