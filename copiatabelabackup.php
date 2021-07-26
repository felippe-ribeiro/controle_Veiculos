<?php
// variáveis para conexão em LOCALHOST
  $conexao = mysqli_connect('localhost', 'admin', 'h@5sup2017', 'controle_veiculos');
 
   if (mysqli_connect_errno()){
      echo "falha ao conectar: ". mysqli_connect_error();
   die();
   }

$sql = 'INSERT INTO tb_backupentrada (id, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, dataentrada, horaentrada, horasaida, foto)
SELECT id, matricula, tipo, situacao, nome, identidade, placa, veiculo, cidade, uf, empresa, dataentrada, horaentrada, horasaida, foto
FROM tb_entrada';

$resultado = mysqli_query($conexao, $sql);

$sql2 = 'DELETE FROM tb_entrada';

$resultado2 = mysqli_query($conexao, $sql2);

?>
