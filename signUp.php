<?php
	session_start();
	if ( isset($_POST['email'])){		
		
		$isValidationProper = true;
		
		$username = $_POST['username'];
		//sprawdzenie długosci nicka
		if ((strlen($username) < 3) || (strlen($username)>20)){
			$isValidationProper=false;
			$_SESSION['e_username']="Podaj realne imię, bez polskich znaków";
		}
		
		if (ctype_alnum($username)==false){
			$isValidationProper=false;
			$_SESSION['e_username']="Podaj realne imię, bez polskich znaków";
		}
		
		//email
		$email = $_POST['email'];
		$email_safe = filter_var($email, FILTER_SANITIZE_EMAIL);
		if ((filter_var($email_safe, FILTER_VALIDATE_EMAIL) == false) || ($email != $email_safe))
		{
			$isValidationProper = false;
			$_SESSION['e_email']="Proszę podać właściwy adres e-mail.";
		}
		
		//password
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		if ((strlen($password1) < 8 ) || (strlen($password1) > 20 ) )
		{
			$isValidationProper = false;
			$_SESSION['e_password']="Poprawne hasło powinno zawierać od 8 do 20 znaków";
		}
		
		if ( strlen($password1) != strlen($password2) )
		{
			$isValidationProper = false;
			$_SESSION['e_password']="Podane hasła nie są jednakowe";
		}
		
		$passwordHasCapital = false;
		$passwordHasSpecialSign = false;
		for ($i = 0; $i < strlen($password1); $i++)
		{
			if ( ctype_upper($password1[$i]) ) 
			{
				$passwordHasCapital = true;
			}
			
			if ( !(ctype_alpha($password1[$i])) )
			{
				$passwordHasSpecialSign = true;
			}
		}
		if ( $passwordHasCapital == false  || $passwordHasSpecialSign == false )
		{
			$isValidationProper = false;
			$_SESSION['e_password']="Hasło powinno zawierać przynajmniej jedną wielką literę i przynajmniej jeden znak specjalny lub numeryczny";			
		}
		
		$password_hash = password_hash($password1, PASSWORD_DEFAULT);
		
		//regulamin
		if (!(isset($_POST['rules'])))
		{
			$isValidationProper = false;
			$_SESSION['e_rule'] = "Potwierdź akceptację regulaminu";
		}
		
		//captcha
		//zapamietanie wprowadzonych danych
		$_SESSION['m_username'] = $username;
		$_SESSION['m_email'] = $email;
		$_SESSION['m_password1'] = $password1;
		$_SESSION['m_password2'] = $password2;
		if (isset($_POST['rules'])) $_SESSION['m_rules'] = true;
		
		require_once "dbconnect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$db_connection = new mysqli($host, $db_user, $db_password, $database);
			if ($db_connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$connectionResult = $db_connection->query("SELECT id FROM users WHERE email='$email'");
				if (!$connectionResult) throw new Exception($db_connection->error);
				$numberOfEmails = $connectionResult->num_rows;
				
				if ($numberOfEmails>0){
					$isValidationProper=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do podanego adresu e-mail";
				}
				
				if ($isValidationProper)
				{
					if ($db_connection->query("INSERT INTO users VALUES(NULL, '$username', '$password_hash', '$email')"))
					{
						$_SESSION['signUpCompleted'] = true;
						$_SESSION['signUpMessage'] = "<h3>Gratulacje, udało Ci się zrobić pierwszy krok do zadbania o finanse!</h3>";
						header('Location: signIn.php');
					}
					else 
					{
						throw new Exception($db_connection->error);
					}
				}
				
				$db_connection->close();
				
			}
		}
		
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie</span>';
			echo '<br />Informacja o błędzie: '.$e;
		}
		
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500&display=swap" rel="stylesheet">
    
	<link rel="stylesheet" href="css/bootstrap.min.css">

    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/fontello.css" type="text/css">

</head>
<body>
    <div class="d-flex flex-column vh-100 overflow-hidden container-fluid p-0">
        <header>
            <div class="brandTop d-flex flex-row">
                <div class="logo d-block">
                    <a href="index.php">
                        <div class="logoIcon"><i class="icon-chart-bar"> </i></div>
                        <div class="logoText">
                            <div class="textPart d-xl-inline d-block">Personal</div>
                            <div class="textPart d-xl-inline d-block">Budget</div>
                        </div> 
                    </a>                       
                </div>
                <div class="topBarButtons">
                    <div class="buttonsGroup">					
						<a href="signUp.php">
							<button type="button" class="btn btn-outline-secondary signUp d-block d-sm-inline">Rejestracja</button>
						</a>						
						<a href="signIn.php">
							<button type="button" class="btn btn-outline-primary signIn my-2 d-block d-sm-inline">Logowanie</button>
						</a>
                    </div>
                </div>
            </div>
        </header>
        <div class="col-12 mh-100 overflow-auto py-2 imageBackground">
            <main>
                <div class="centralArea">
                    <div class="row">
                        <div class="col-md-6 offset-md-3 fullColorBackground">
                            <div class="d-block prosHeader">
								<form method="post">
									<h1><i class="icon-gamepad prosIcon"></i>Rejestracja</h1>
									<div class="input-group w-75 mx-auto">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="icon-user"></i></div>
										</div>
										<input name="username" class="form-control " id="username"  placeholder="Podaj imię" value="<?php
															if (isset($_SESSION['m_username']))
															{
																echo $_SESSION['m_username'];
																unset($_SESSION['m_username']);
															}
														?>"/>
										
											<?php
											
												if (isset($_SESSION['e_username'])){
													echo '<div class="error w-100">'.$_SESSION['e_username'].'</div>';
													unset($_SESSION['e_username']);
												}
											
											?>
											
									</div>
									<div class="input-group w-75 mx-auto">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="icon-at"></i></div>
										</div>
										<input name="email" type="email" class="form-control " id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Podaj email" value="<?php
															if (isset($_SESSION['m_email']))
															{
																echo $_SESSION['m_email'];
																unset($_SESSION['m_email']);
															}
														?>"/>
										
											<?php
											
												if (isset($_SESSION['e_email'])){
													echo '<div class="error w-100">'.$_SESSION['e_email'].'</div>';
													unset($_SESSION['e_email']);
												}
											
											?>
											
									</div>
									<div class="input-group w-75 mx-auto">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="icon-lock"></i></div>
										</div>
										<label for="exampleInputPassword1"></label>
										<input name="password1" type="password" class="form-control" id="exampleInputPassword1" placeholder="Hasło" value="<?php
												if (isset($_SESSION['m_password1']))
												{
													echo $_SESSION['m_password1'];
													unset($_SESSION['m_password1']);
												}
											?>"/>										
										<?php
										
											if (isset($_SESSION['e_password'])){
												echo '<div class="error w-100">'.$_SESSION['e_password'].'</div>';
												unset($_SESSION['e_password']);
											}	
											
										?>
										
									</div>   
									<div class="input-group w-75 mx-auto">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="icon-docs"></i></div>
										</div>
										<label for="exampleInputPassword2"></label>
										<input name="password2" type="password" class="form-control" id="exampleInputPassword2" placeholder="Powtórz hasło" value="<?php
												if (isset($_SESSION['m_password2']))
												{
													echo $_SESSION['m_password2'];
													unset($_SESSION['m_password2']);
												}
											?>"/>									
										<?php
										
											if (isset($_SESSION['e_password'])){
												echo '<div class="error w-100">'.$_SESSION['e_password'].'</div>';
												unset($_SESSION['e_password']);
											}	
											
										?>
										
									</div>  
									<div class="w-75 mx-auto py-2">
										<label>
										<input type="checkbox" name="rules" <?php
											if (isset($_SESSION['m_rules'])){
												echo "checked";
												unset($_SESSION['m_rules']);
											}
										?>
										/> Akceptuję regulamin
										</label>
										<?php
										
											if (isset($_SESSION['e_rule'])){
												echo '<div class="error w-100">'.$_SESSION['e_rule'].'</div>';
												unset($_SESSION['e_rule']);
											}
										
										?>		
										
									</div>									
									<button type="submit" class="btn btn-outline-secondary signIn my-4 w-50">Zarejestruj się!</button> 									
								</form>
                            </div>
							
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 fullColorBackground my-5">
                            <div class="d-block prosHeader">
                                <h1>Posiadasz już konto?</h1>
								<a href="signIn.php">
									<button type="button" class="btn btn-outline-primary signIn my-4 w-50">Zaloguj się!</button>
								</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="./js/jquery.3.4.1.js"></script>

    <script src="./js/bootstrap.min.js"></script>
</body>
</html>