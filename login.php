<?php
	session_start();
	
	if ( !(isset($_POST['email'])) || !(isset($_POST['password'])) )
	{
		header('Location: index.php');
		exit();
	}	

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PersonalBudget - app for organizing personal finances </title>
</head>
<body>
<?php

	require_once "dbconnect.php";
	
	try
	{
		$connection = @new mysqli($host, $db_user, $db_password, $database);
		
		if ($connection->connect_errno != 0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{	
			
			echo '<span style="color:lightgreen;">Polaczono z baza</span>';
			$email = $_POST['email'];
			$password = $_POST['password'];
			
			$email = htmlentities($email, ENT_QUOTES, "UTF-8");
			
			if($connection_result = @$connection->query(
			sprintf("SELECT * FROM users WHERE email='%s'",
			mysqli_real_escape_string($connection, $email)
			))){
				
				echo '</br><span style="color:lightgreen;">Zapytanie z baza</span>';
				echo '<span style="color:lightgreen;">Przed num rows</span>';
				$users_count = $connection_result->num_rows;
				echo '<span style="color:lightgreen;">Po num rows</span>';
				if($users_count > 0){
					echo '<span style="color:lightgreen;">Przed fetch</span>';
					$data_row = $connection_result->fetch_assoc();
					
					echo '<span style="color:lightgreen;">Pobranie z bazy</span>';
					if ( password_verify($password, $data_row['password'])){
						echo '</br><span style="color:lightgreen;">Jest User</span>';
						$_SESSION['logged_in'] = true;
						$_SESSION['id'] = $data_row['id'];
						$_SESSION['username'] = $data_row['username'];
						
						unset($_SESSION['error']);
						
						$connection_result->close();
						header('Location: mainMenu.php');
					}
					else{
						echo '</br><span style="color:red;">Nie ma usera</span>';
						$_SESSION['error'] = '<span style="color:red;">Nieprawidłowy email lub hasło!</span>';
						header('Location: index.php');
					}
					
				}else{
					echo '</br><span style="color:red;">Nie ma usera</span>';
					$_SESSION['error'] = '<span style="color:red;">W bazie nie ma użytkownika zarejestrownaego na ten adres email!</span>';
					header('Location: index.php');
				}
			}
			$connection->close();			
		}
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Prosimy spróbować później</span>';
	}
	

?>
</body>
</html>