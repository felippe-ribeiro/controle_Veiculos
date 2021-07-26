<?php

// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
  // date_default_timezone_set('America/Fortaleza');
// CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HOR�RIO DEFINIDO (BRAS�LIA)
    $dataLocal = date('d/m/Y H:i:s', time());
	
	
  /**
   * fun��o que devolve em formato JSON os dados do cliente
   */
  function retorna( $matricula, $db )
  {
    $sql = "SELECT * FROM `tb_cadastro` WHERE `matricula` = '{$matricula}' ";

    $query = $db->query( $sql );

    $arr = Array();
	
    if( $query->num_rows )
		
    {
      while( $dados = $query->fetch_object() )
      {
       // $arr['id'] = $dados->id;
        $arr['tipo'] = $dados->tipo;
	    $arr['identidade'] = $dados->identidade;
		$arr['situacao'] = $dados->situacao;
		$arr['nome'] = $dados->nome;
        $arr['placa'] = $dados->placa;
        $arr['veiculo'] = $dados->veiculo;
        $arr['cidade'] = $dados->cidade;
        $arr['uf'] = $dados->uf;			
		$arr['empresa'] = $dados->empresa;	
      }
    }
    else
      $arr['matricula'] = 'Não encontrada.';

    return json_encode( $arr );
  }
  

/* s� se for enviado o par�metro, que devolve os dados */
if( isset($_GET['matricula']) )
{
  $db = new mysqli('localhost', 'admin', 'h@5sup2017', 'controle_veiculos');
  
  echo retorna( filter ( $_GET['matricula'] ), $db );
}

function filter( $var ){
  return $var;
}
