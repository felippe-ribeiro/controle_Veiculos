<?php
    session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Controle de Portaria - HAS</title>

        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
<link href="css/bootstrap.min.css" rel="stylesheet">
        
</head>

<body>

  <tr>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr>
    <th scope="col">  <form method="POST" action="valida.php">
           <center> <h2>Portaria HAS</h2><br>
            <label>Usuario</label>
            <input type="text" name="email" placeholder="Usuario" required autofocus>
            <br><label>Senha&nbsp;&nbsp;</label>
            <input type="password" name="senha" placeholder="Senha" required>
            <br><br><button type="submit">Acessar</button>
        </form>
        <p>
            <?php if(isset($_SESSION['loginErro'])){
                echo $_SESSION['loginErro'];
                unset($_SESSION['loginErro']);
            }?>
        </p>
        <p>
            <?php 
            if(isset($_SESSION['logindeslogado'])){
                echo $_SESSION['logindeslogado'];
                unset($_SESSION['logindeslogado']);
            }
            ?>
	   
	   
	   </th>
  </tr>
  <tr>
    <th scope="col">&nbsp;</th>
  </tr>
  <tr>
    <th align="center" scope="col"> <!--<img src="" width="600" height="400" alt="" longdesc="#" />--></th>
  </tr>
  <tr>
    <th scope="col"><p></p>
    <p></p></th>
  </tr>
</table>
<footer>
  &#174; TI HAS<article>
</footer>
</body>
</html>
