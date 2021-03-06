<?php
	session_start();
	//dodanie odpowiedniego formularza
	//porownanie maila z baza danych
	//porownanie hasla z tym przypisanym do hasla
	//owarunkowanie zachiwania formularza
	//niepoprawne haslo
	//niepoprawny email
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
								<form action="login.php" method="post">
								<?php
									if (isset($_SESSION['signUpMessage'])){echo $_SESSION['signUpMessage'];}
									unset($_SESSION['signUpMessage']);
								?>
                                <h1><i class="icon-flight prosIcon"></i>Logowanie</h1>
                                <div class="input-group w-75 mx-auto">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="icon-at"></i></div>
                                    </div>
                                    <input name="email" type="email" class="form-control " id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Podaj email"
									/>
                                </div>
                                <div class="input-group w-75 mx-auto">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="icon-lock"></i></div>
                                    </div>
                                    <label for="exampleInputPassword1"></label>
                                    <input name="password" type="password" class="form-control" id="exampleInputPassword" placeholder="Has??o">
                                </div>                         
                                <button type="submit" class="btn btn-outline-primary signIn my-4 w-50">Zaloguj si??!</button>
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 fullColorBackground my-5">
                            <div class="d-block prosHeader">
                                <h1>Nie masz jeszcze konta?</h1>
								<a href="signUp.php">
									<button type="button" class="btn btn-outline-secondary signIn my-4 w-50">Zarejestruj si??!</button>
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