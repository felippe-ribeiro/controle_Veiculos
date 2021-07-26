<?php
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
    //date_default_timezone_set('America/Fortaleza');
             //enviadata.php
             $dataLocal = date('d/m/Y');
             $data = time();  
			 $hora = date('H:i:s');
             $timestamp = mktime(date("H")-3, date("i")+4, 0);
             $data = gmdate("H:i:s", $timestamp);
			 
 session_start();
 $usuarioLogado = $_SESSION['usuarioNome'];
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

// Recebe o id do cliente do cliente via GET
$id_cliente = (isset($_GET['id'])) ? $_GET['id'] : '';

// Valida se existe um id e se ele é numérico
if (!empty($id_cliente) && is_numeric($id_cliente)):

	// Captura os dados do cliente solicitado
	$conexao = conexao::getInstance();
	$sql = 'SELECT id, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, dataentrada, horaentrada, horasaida FROM tb_entrada WHERE id = :id';
	$stm = $conexao->prepare($sql);
	$stm->bindValue(':id', $id_cliente);
	$stm->execute();
	$cliente = $stm->fetch(PDO::FETCH_OBJ);
	$valueIdentity = $cliente->matricula;
	//echo $valueIdentity;
	//echo $cliente->matricula;
	$conexao2 = conexao::getInstance();
	$sql2 = "SELECT id, foto, matricula FROM tb_cadastro WHERE matricula = '$valueIdentity' ";
	$stm2 = $conexao2->prepare($sql2);
	$stm2->bindValue(':id', $id_cliente);
	$stm2->execute();
	$cliente2 = $stm2->fetch(PDO::FETCH_OBJ);
	//echo "cliente2: " . $cliente2->foto;
	
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
	<title>Editar Cadastros</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container'>
		<fieldset>
			<legend><h1>Saída</h1></legend>
			
			<?php if(empty($cliente)):?>
				<h3 class="text-center text-danger">Não encontrado!</h3>
			<?php else: ?>
				  <form action="action_foto.php" method="post" id='form-contato' enctype='multipart/form-data'>
					<div class="row">
						<label for="nome" hidden>Alterar Foto</label> 
				      	<div class="col-md-2">
						    <a href="#" class="thumbnail">
						       <img src="fotos/<?=$cliente2->foto?>" height="190" width="150" id="foto-cliente"> 
						    </a> 
					  	</div>
					  	<input type="hidden" name="foto" id="foto" value="foto" >
				  	</div>
 
				    <div class="form-group">
					<label for="placa">Matricula:</label>
					<input type="placa" readonly="readonly" class="form-control" id="placa" name="placa" value="<?=$cliente->placa?>"placeholder="Informe a Matricula">
        
                    </div>

			    <div class="form-group">
			      <label for="tipo">Tipo:</label>
                  <input type="tipo" readonly="readonly" class="form-control" id="tipo" name="tipo" value="<?=$cliente->tipo?>"placeholder="Informe o Tipo">
		
	            </div>
			    <div class="form-group">
			      <label for="nome">Nome:</label>
			      <input type="nome" readonly="readonly"  class="form-control" id="nome" maxlength="30" name="nome" value="<?=$cliente->nome?>"placeholder="Informe o Nome">
		
	            </div>
			    <div class="form-group">
			      <label for="identidade">RG:</label>
			      <input type="identidade" readonly="readonly"  class="form-control" id="identidade" maxlength="25" name="identidade" value="<?=$cliente->identidade?>"placeholder="Informe o RG">
		
	            </div>

			    <div class="form-group">
			      <label for="matricula">Placa:</label>
			      <input type="matricula" readonly="readonly"  class="form-control" id="matricula" maxlength="12" name="matricula" value="<?=$cliente->matricula?>"placeholder="Informe a Placa">
		
	            </div>
			    <div class="form-group">
			      <label for="veiculo">Veículo:</label>
			      <input type="veiculo" readonly="readonly" class="form-control" id="veiculo" maxlength="20" name="veiculo" value="<?=$cliente->veiculo?>"placeholder="Informe o Veiculo">
		
	            </div>
                <div class="form-group">
			      <label for="cidade">Cidade:</label>
			      <input type="cidade" readonly="readonly" class="form-control" id="cidade" maxlength="13" name="cidade" value="<?=$cliente->cidade?>"placeholder="Informe a Cidade">
		
	            </div>
			    <div class="form-group">
			      <label for="uf">UF:</label>
			      <input type="uf" readonly="readonly" class="form-control" id="uf" maxlength="3" name="uf" value="<?=$cliente->uf?>"placeholder="Informe o Estado">
		
	            </div>
			    <div class="form-group">
			      <label for="empresa">Empresa:</label>
			      <input type="empresa" readonly="readonly" class="form-control" id="empresa" maxlength="25" name="empresa" value="<?=$cliente->empresa?>"placeholder="Informe a Empresa">
		
		        </div>
			
	
			    <div class="form-group">
			      <label for="dataentrada">Data Entrada:</label>
			      <input type="dataentrada" readonly="readonly" class="form-control" id="dataentrada" maxlength="10" name="dataentrada" value="<?=$cliente->dataentrada?>"placeholder="Informe a Data">
		
		        </div>
				
				<div class="form-group">
			      <label for="horaentrada">Hora Entrada:</label>
			      <input type="horaentrada" readonly="readonly" class="form-control" id="horaentrada" maxlength="10" name="horaentrada" value="<?=$cliente->horaentrada?>"placeholder="Informe a Hora de entrada">
		
		        </div>
				
				<div class="form-group">
			      <label for="horasaida">Hora de Saida:</label>
			      <input type="horasaida" readonly="readonly" class="form-control" id="horasaida" maxlength="10" name="horasaida" value="<?=$cliente->horasaida?>"placeholder="<?=$data?>">
		
		        </div>				
			
                <div class="form-group">
                        <label for="acesso">Acesso Liberado:  </label>
			            <label class="radio-inline"> 
						<input type="radio"  name="situacao" value="1" Checked>
						<span class="label label-success">SIM</span> 
	                   </label>
                     
                 	   <label class="radio-inline"> 
						<input type="radio" name="situacao" value="2">
						<span class="label label-danger">NAO</span> 
	                   </label>
					   <input type="resp_exit" id="resp_exit" name="resp_exit" value="<?=$usuarioLogado?>" hidden>

               </div>
				    <input type="hidden" name="acao" value="editar">
				    <input type="hidden" name="id" value="<?=$cliente->id?>">
				    <input type="hidden" name="foto_atual" value="<?=$cliente->foto?>">
				    <button type="submit" class="btn btn-primary" id='botao'> 
				      Gravar
				    </button>
				    <a href='r_entrada.php' class="btn btn-danger">Cancelar</a>
				</form>
			<?php endif; ?>
		</fieldset>

	</div>
	<script type="text/javascript" src="js/custom.js"></script>
	<footer>
  &#174; TI HAS<article>
</footer>
</body>

</html>

