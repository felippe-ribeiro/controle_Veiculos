<?php
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
 //   date_default_timezone_set('America/Sao_Paulo');
// CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
   
             //enviadata.php
$dataLocal = date('d/m/Y');
$hora = date('H:i');

$date20 = new DateTime();

echo $date20->format('Y-m-d H:i:s');
	
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
	$sql = 'SELECT id, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, observacoes, dataentrada, horaentrada, horasaida, resp_cad FROM tb_entrada WHERE  horasaida = "" ORDER BY id DESC';
	$stm = $conexao->prepare($sql);
	$stm->execute();
	$clientes = $stm->fetchAll(PDO::FETCH_OBJ);

else:

	// Executa uma consulta baseada no termo de pesquisa passado como parâmetro
	$conexao = conexao::getInstance();
	$sql = 'SELECT id, foto, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, observacoes, 
	dataentrada, horaentrada, horasaida, resp_cad, resp_exit FROM tb_entrada WHERE nome LIKE :nome OR matricula LIKE :matricula OR dataentrada LIKE :dataentrada ORDER BY id DESC';
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
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Relatório de Entradas</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
     <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
    .teste {
	font-size: 9px;
}
    </style>
		<script type="text/javascript" src="js/event.js"></script>
</head>
<body>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <th scope="col"><ul class="nav nav-tabs">
  <!-- <li role="presentation" class="active"><a href="index.php">INICIO</a></li>-->
  <li role="presentation"><a href="cadastro_pessoas.php">Cadastrar</a></li>
  <li role="presentation"><a href="entrada.php">Liberação de Entrada</a></li>
  <!--<li role="presentation"><a href="s_sair.php">Liberação de Saída</a></li>-->
  <li role="presentation"  class="active"><a href="r_entrada.php">Relação de Entradas</a></li>
 <!--  <li role="presentation"><a href="r_ent_sai.php">ENTRADA/SAIDA</a></li> -->
  <li role="presentation"><a href="pesquisa.php">Pesquisar Cadastros</a></li> 
  <li role="presentation"><a href="changePassword.php">Alterar Senha</a></li> 
  <?php if($_SESSION['usuarioNiveisAcessoId'] == 5){ ?>
    <li role="presentation"><a href="gerarelxls.php">Gerar Relatório XLS (Excel)</a></li> 
	<?php } ?>
</ul>&nbsp;</th>
  </tr>
</table>
<table>
	<div class='container'>
		<fieldset>

			<!-- Cabeçalho da Listagem -->
			<legend>
			<h1>Controle de Entrada e Saida</h1></legend>

			<!-- Formulário de Pesquisa -->
			<form action="" method="get" id='form-contato' class="form-horizontal col-md-10">
			<label class="col-md-2 control-label" for="termo">.</label>
				<div class='col-md-7'>
			    	<input type="text" class="form-control" id="termo" name="termo" placeholder="Informe o Nome / Matricula ou Data de Cadastro">
				</div>
			    <button type="submit" class="btn btn-primary">Pesquisar</button>
					<button type="submit" class="btn btn-primary" onclick="reset()">Limpar Pesquisa</button>
					<!--<button type="submit" class="btn btn-success" onclick="showAll()">Mostrar Todos</button>-->
			   <!--  <a href='listar_entradas.php' class="btn btn-primary">Ver Todos</a> -->
			</form>

			<!-- Link para página de cadastro
			<a href='cadastro_pessoas.php' class="btn btn-success pull-right">Cadastrar Novos</a> -->
			<div class='clearfix'></div>

			<?php if(!empty($clientes)):?>

				<!-- Tabela de Entrada -->
				<table class="table table-striped">
					<tr class='active'>
						<th>Matricula</th>
						<th>Nome</th>
                        <th>Tipo</th>
						<th>Placa</th>
						<th>Veiculo</th>
						<th>Cidade</th>
						<th>UF</th>
						<th>Empresa</th>
						<th>Observacoes</th>
						<th>Entrada</th>
						<th>Entrada</th>
						<th>Saida</th>
						<th>Liberado por:</th>
						<th>Registro da Saída::</th>
						<th>Liberar Saída</th>
						
					</tr>
					<?php foreach($clientes as $cliente):?>
						<tr>
							<td class="warning"><?=$cliente->placa?></td>
                         <!--   <img src='fotos/<?=$cliente->foto?>' height='175' width='110'> -->
                            <td><?=$cliente->nome?></td>
                            <td><?=$cliente->tipo?></td>
							<td><?=$cliente->matricula?></td>
							<td><?=$cliente->veiculo?></td>
							<td><?=$cliente->cidade?></td>
							<td><?=$cliente->uf?></td>
							<td><?=$cliente->empresa?></td>
							<td><?=$cliente->observacoes?></td>
							<td><?=$cliente->dataentrada?></td>
							<td><?=$cliente->horaentrada?></td>
							<td><?=$cliente->horasaida?></td>
							<td><?=$cliente->resp_cad?></td>
							<td><?=$cliente->resp_exit?></td>
							<td><a href='editar.php?id=<?=$cliente->id?>' class="btn btn-primary">Liberar Saída</a></td>
							
							<!-- <td class="warning">
							    
								<a href='javascript:void(0)' class="btn btn-danger link_exclusao" rel="<?=$cliente->id?>">Excluir</a> 
							</td> -->
							
						</tr>	
					<?php endforeach;?>
				</table>

			<?php else: ?>

				<!-- Mensagem caso não exista clientes ou não encontrado  -->
<h3 class="text-center text-primary">Sem dados para apresentar!</h3>
			<?php endif; ?>
		</fieldset>
	</div></table>
	<script type="text/javascript" src="js/custom.js"></script>
</body>
<footer>
  &#174; TI HAS<article>
</footer>
</html>
