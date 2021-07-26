<?php
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
   // date_default_timezone_set('America/Fortaleza');
// CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
   
    //enviadata.php
$dataLocal = date('d/m/Y');
$hora = date('H,i');
$date20 = new DateTime();
echo $date20->format('Y-m-d H:i:s');;
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
	$sql = 'SELECT id, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, datacadastro, foto, resp_cad FROM tb_cadastro';
	$stm = $conexao->prepare($sql);
	//$stm->execute();
	$clientes = $stm->fetchAll(PDO::FETCH_OBJ);
    
else:

	// Executa uma consulta baseada no termo de pesquisa passado como parâmetro
	$conexao = conexao::getInstance();
	$sql = 'SELECT id, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, datacadastro, foto, resp_cad FROM tb_cadastro WHERE nome LIKE :nome OR matricula LIKE :matricula OR datacadastro LIKE :datacadastro OR empresa LIKE :empresa OR cidade LIKE :cidade OR uf LIKE :uf';
	
	$stm = $conexao->prepare($sql);
	$stm->bindValue(':nome', $termo.'%');
	$stm->bindValue(':matricula', $termo.'%');
	$stm->bindValue(':datacadastro', $termo.'%');
	$stm->bindValue(':empresa', $termo.'%');
	$stm->bindValue(':cidade', $termo.'%');
	$stm->bindValue(':uf', $termo.'%');
	//$stm->bindValue(':datacadastro', $termo.'%');
	//$stm->bindValue(':datacadastro', $termo.'%');
	$stm->execute();
	$clientes = $stm->fetchAll(PDO::FETCH_OBJ);

endif;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Listagem de Cadastros</title>
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
  <!--<li role="presentation"><a href="s_sair.php">Liberação de Saída</a></li>-->
  <li role="presentation"><a href="r_entrada.php">Relação de Entradas</a></li>
 <!--  <li role="presentation"><a href="r_ent_sai.php">ENTRADA/SAIDA</a></li> -->
  <li role="presentation" class="active"><a href="pesquisa.php">Pesquisar Cadastros</a></li> 
  <li role="presentation"><a href="changePassword.php">Alterar Senha</a></li> 
</ul>&nbsp;</th>
  </tr>
</table>

	<div class='container'>
		<fieldset>

			<!-- Cabeçalho da Listagem -->
			<legend><h1>Listagem de Cadastros</h1></legend>

			<!-- Formulário de Pesquisa -->
			<form action="" method="get" id='form-contato' class="form-horizontal col-md-10">
				<label class="col-md-2 control-label" for="termo">Pesquisar</label>
				<div class='col-md-7'>
			    	<input type="text" class="form-control" id="termo" name="termo" placeholder="Informe o Nome / Matricula ou Data de Cadastro">
				</div>
			    <button type="submit" class="btn btn-primary">Pesquisar</button>
			    <a href='mostra_todos.php' class="btn btn-primary">Ver Todos</a>
			</form>

			<!-- Link para página de cadastro -->
			<a href='cadastro_pessoas.php' class="btn btn-success pull-right">Cadastrar Novos</a>
			<div class='clearfix'></div>

			<?php if(!empty($clientes)):?>

				<!-- Tabela de Cadastros -->
				<table class="table table-striped">
					<tr class='active'>
						<th>Foto</th>
						<th>Matricula</th>
                        <th>Tipo</th>
						<th>Nome</th>
						<th>Placa</th>
						<th>Veiculo</th>
						<th>Cidade</th>
						<th>UF</th>
						<th>Empresa</th>
						<th>Data Cadastro</th>
						<th>Resp. Cadastro</th>
						<th>Editar</th>
						<!-- <th>Ação</th> -->
					</tr>
					<?php foreach($clientes as $cliente):?>
						<tr>
							<td><img src='fotos/<?=$cliente->foto?>' height='177' width='133'></td>
							<td><?=$cliente->placa?></td>
                            <td><?=$cliente->tipo?></td>
							<td><?=$cliente->nome?></td>
							<td><?=$cliente->matricula?></td>
							<td><?=$cliente->veiculo?></td>
							<td><?=$cliente->cidade?></td>
							<td><?=$cliente->uf?></td>
							<td><?=$cliente->empresa?></td>
							<td><?=$cliente->datacadastro?></td>
							<td><?=$cliente->resp_cad?></td>
							<td><a href='editarcadastros.php?id=<?=$cliente->id?>' class="btn btn-primary">Editar</a></td>
							 							
							<!--<a href='javascript:void(0)' class="btn btn-danger link_exclusao" rel="<?=$cliente->id?>">Excluir</a>-->
							 
						</tr>	
					<?php endforeach;?>
				</table>

			<?php else: ?>

				<!-- Mensagem caso não exista clientes ou não encontrado  -->
				<h3 class="text-center text-primary">Não existem dados cadastrados!</h3>
			<?php endif; ?>
		</fieldset>
	</div>
	<script type="text/javascript" src="js/custom.js"></script>
</body>
<footer>
  &#174; TI HAS<article>
</footer>
</html>
