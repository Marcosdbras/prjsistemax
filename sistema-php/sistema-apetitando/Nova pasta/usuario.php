<?php   

if ($_SERVER['REQUEST_METHOD']=='POST'){
    

     $login = $_POST['login'];
     $senha = md5($_POST['senha']);
     $connect = mysqli_connect('localhost','root','');
     $db = mysqli_select_db('eleicoes');
  

    $data = mysqli_query("SELECT * FROM usuarios WHERE login =
    '$login' AND senha = '$senha'") or die("erro ao selecionar");
      if (mysqli_affected_rows($data)<=0){
        
            $_SESSION['Status'] =  'Erro';

            $_SESSION['id'] = 0;

            $_SESSION['erro'] = 'Usuário não encontrado!';	 		
		
            die();
			
      }else{		  

        
		while ($row = mysqli_fetch_assoc($result)) {

    		$_SESSION['Status'] =  'Sucesso';

            $_SESSION['id'] = $row["nomeusuario"];

            $_SESSION['erro'] = 'Nenhum';	      
	   
	   
        }
		
		  
		  
        //setcookie("login",$login);
        //header("Location:index.php");
      }
  

	
	
	
	
	
	
	
	//$data = json_decode($json);
	
	
	
	
	Exit();	
}

?>

<!doctype html>

<html lang="pt-br">
<head>
       
	   <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1">
	   
	   
	   <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700" rel="stylesheet">
       <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
       <link href="https://fonts.googleapis.com/css?family=Rochester" rel="stylesheet">	   
	   
	   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> 	   
	   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	   
	   

</head>
<body>
	      
	   
		<div class="col-md-6 col-offset-2">
             <div class="panel panel-primary">
                    <div class="panel-heading">Já é cadastrado?</div>
                    <div class="panel-body">
                           <!--<form action="requisicao_para_login.php" id="form_login" class="form"  method="Post"> -->
						   <form action="index.php" id="form_login" class="form"  method="Post">		   
								   <div class="form-group">									  
									  	
				
				
										<?php						 
									 
			    
											if (  isset( $_SESSION["Status"] )  ){				

												if ($_SESSION["Status"]=="Erro"){					

													echo'<div class="alert alert-danger" role="alert">';
													echo $_SESSION['erro'];
													echo'</div>';
					    

						
												} else if ($_SESSION['Status']=="Sucesso") {
							
													echo'<div class="alert alert-success" role="alert">';
													echo 'Requisição efetivada com sucesso!';
													echo'</div>';				
						
						
												}
												
												
												unset($_SESSION['Status']);

												unset($_SESSION['id']);

												unset($_SESSION['erro']);								
												
					
											}


										?>									
									  
								   </div>		
						   
                                  <div class="form-group">
                                        <label for="login">Email / Login</label>
                                        <input type="text" name="login" id="login" required class="form-control"/>
                                  </div>
								  
								  
                                  <div class="form-group">
                                        <label for="senha">Senha</label>
                                        <input type="password" name="senha" id="senha" required class="form-control"/>
                                        
								  </div>			  
								  
								  
                                  <div class="form-group">
                                        <input type="submit" class="btn btn-success" value="Acessar Cadastro"/>										
										<input type="button" class="btn btn-success" value="Esqueceu a senha" onclick="esqueceu_senha()"/>
                                  </div>							  
							   
								  
                           </form>
                    </div>
             </div>
       </div>	   
	 

	 

  
	   
	 
       <script src="jquery-2.1.4.min.js"></script>
       <script src="jquery.validate.min.js"></script>	


       
</body>
</html>
