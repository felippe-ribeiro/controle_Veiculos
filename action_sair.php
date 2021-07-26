<?php
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
  // date_default_timezone_set('America/Fortaleza');
             //enviadata.php
             $dataLocal = date('d/m/Y');
             $data = time();  
			 $hora = date('H:i:s');
             $timestamp = mktime(date("H")-3, date("i")+4, 0);
             $data = gmdate("H:i:s", $timestamp);
?>

        	
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Sistema de saida</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
</head>
<body>
	<div class='container box-mensagem-crud'>
<?php 
		require 'conection_cadastro.php';

		// Atribui uma conexão PDO
		$conexao = conexao::getInstance();

		// Recebe os dados enviados pela submissão
		$acao  = (isset($_POST['acao'])) ? $_POST['acao'] : '';
		$id    = (isset($_POST['id'])) ? $_POST['id'] : '';
		$matricula  = (isset($_POST['matricula'])) ? $_POST['matricula'] : '';
		$tipo  = (isset($_POST['tipo'])) ? $_POST['tipo'] : '';
		$situacao  = (isset($_POST['situacao'])) ? $_POST['situacao'] : '';
		$nome  = (isset($_POST['nome'])) ? $_POST['nome'] : '';
		$identidade  = (isset($_POST['identidade'])) ? $_POST['identidade'] : '';
		$placa  = (isset($_POST['placa'])) ? $_POST['placa'] : '';
		$veiculo  = (isset($_POST['veiculo'])) ? $_POST['veiculo'] : '';
		$cidade  = (isset($_POST['cidade'])) ? $_POST['cidade'] : '';
		$uf  = (isset($_POST['uf'])) ? $_POST['uf'] : '';
		$empresa  = (isset($_POST['empresa'])) ? $_POST['empresa'] : '';
		$foto_atual		  = (isset($_POST['foto_atual'])) ? $_POST['foto_atual'] : '';
		$dataentrada  = (isset($_POST['dataentrada'])) ? $_POST['dataentrada'] : '';
		$horaentrada	  = (isset($_POST['horaentrada'])) ? $_POST['horaentrada'] : '';
		$horasaida	  = (isset($_POST['horasaida'])) ? $_POST['horasaida'] : '';	
		$resp_exit = (isset($_POST['resp_cad'])) ? $_POST['resp_cad'] : '';	


		// Valida os dados recebidos
		$mensagem = '';
		if ($acao == 'editar' && $id == ''):
		    $mensagem .= '<li>ID do registros desconhecido.</li>';
	    endif;

	   // Verifica se foi solicitada a edição de dados
		if ($acao == 'editar'):

			if(isset($_FILES['foto']) && $_FILES['foto']['size'] > 0): 

				// Verifica se a foto é diferente da padrão, se verdadeiro exclui a foto antiga da pasta
				if ($foto_atual <> 'padrao.jpg'):
					unlink("fotos/" . $foto_atual);
				endif;

				$extensoes_aceitas = array('bmp' ,'png', 'svg', 'jpeg', 'jpg');
			    $extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));

			     // Validamos se a extensão do arquivo é aceita
			    if (array_search($extensao, $extensoes_aceitas) === false):
			       echo "<h1>Extensão Inválida!</h1>";
			       exit;
			    endif;
 
			     // Verifica se o upload foi enviado via POST   
			     if(is_uploaded_file($_FILES['foto']['tmp_name'])):  
			             
			          // Verifica se o diretório de destino existe, senão existir cria o diretório  
			          if(!file_exists("fotos")):  
			               mkdir("fotos");  
			          endif;  
			  
			          // Monta o caminho de destino com o nome do arquivo  
			          $nome_foto = date('dmY') . '_' . $_FILES['foto']['name'];  
			            
			          // Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
			          if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'.$nome_foto)):  
			               echo "Houve um erro ao gravar arquivo na pasta de destino!";  
			          endif;  
			     endif;
			else:

			 	$nome_foto = $foto_atual;

			endif;

			$sql = 'UPDATE tb_entrada SET matricula=:matricula, tipo=:tipo, situacao=:situacao, nome=:nome,
			identidade=:identidade, placa=:placa, veiculo=:veiculo, cidade=:cidade, uf=:uf, empresa=:empresa,
			foto=:foto, dataentrada=:dataentrada, horaentrada=:horaentrada, horasaida=:horasaida, resp_exit=resp_exit ',;
			$sql .= ' WHERE id = :id';

			$stm = $conexao->prepare($sql);
			$stm->bindValue(':matricula', $matricula);
			$stm->bindValue(':tipo', $tipo);
			$stm->bindValue(':situacao', $situacao);
			$stm->bindValue(':nome', $nome);
			$stm->bindValue(':identidade', $identidade);
			$stm->bindValue(':placa', $placa);
			$stm->bindValue(':veiculo', $veiculo);
			$stm->bindValue(':cidade', $cidade);
			$stm->bindValue(':uf', $uf);
			$stm->bindValue(':empresa', $empresa);
			$stm->bindValue(':dataentrada', $dataentrada);
			$stm->bindValue(':horaentrada', $horaentrada);
			$stm->bindValue(':horasaida', $hora);
			$stm->bindValue(':resp_exit', $resp_exit);
			$stm->bindValue(':foto', $nome_foto);
			$stm->bindValue(':id', $id);
			
		   // echo $sql;
			
			$retorno = $stm->execute();
			

			
			if ($retorno):
				echo "<div class='alert alert-success' role='alert'>Obrigado por utilizar o sistema!, aguarde você está sendo redirecionado ...</div> ";
		    else:
		    	echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div> ";
			endif;

			echo "<meta http-equiv=refresh content='2;URL=s_sair.php'>";
		endif;


		
?>

	</div>
</body>
</html>
