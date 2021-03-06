<?php

	session_start();
	if (isset($_SESSION['logged_in'])){
	if($_SESSION['logged_in']) 
		{
			header('Location: mainMenu.php');
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
                        <!-- col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3  -->
                        <div class="col-12 col-xl-8 offset-xl-2 fullColorBackground">
                            <div class="d-block prosHeader">
                                <h1>
									<?php

									if(isset($_SESSION['error'])) echo $_SESSION['error'];

									?>
									Korzy??ci z prowadzenia bud??etu
								</h1>
                            </div>
                            <div class="d-block budgetPros w-100">                    
                                <ul>
                                    <li><i class="icon-gamepad prosIcon"></i>Lepsza <span>kontrola</span> w??asnych wydatk??w</li>
                                    <li><i class="icon-money prosIcon"></i>Efektywne gromadzenie <span>oszcz??dno??ci</span></li>
                                    <li><i class="icon-flight prosIcon"></i>Szybsze osi??gni??cie <span>niezale??no??ci</span> finansowej</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-12 col-xl-8 offset-xl-2 my-2">
                            <div class="row decideArea">
                                <div class="col-12 col-sm-4 offset-sm-1 fullColorBackground">
                                    <div id="registerArea" class="d-block decideTile my-1">
                                        <h3>Ju?? teraz za?????? konto:</h3>
										<a href="signUp.php">
                                        <button type="button" class="btn btn-outline-secondary signUp">Rejestracja</button>
										</a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4 offset-sm-2 fullColorBackground">
                                    <div id="loginArea" class="d-block decideTile">
                                        <h3 class="d-block">Posiadasz konto:</h3>
										<a href="signIn.php">
                                        <button type="button" class="btn btn-outline-primary signIn">Logowanie</button>
										</a>
                                    </div>
                                </div>    
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