<?php
	
	session_start();
	
	// expense collumns:
	//	id	user_id	expense_category_assigned_to_user	payment_method_assigned_to_user	amount	date_of_expense	expense_comment
	
	if(!(isset($_SESSION['logged_in']))) 
	{
		header('Location: index.php');
	}
	else 
	{
		if(isset($_POST['amount']))
		{
			//zmienic id na user_id
			$user_id = $_SESSION['id'];
			$users_expense_category;
			$users_payment_methods;
			$amount = $_POST['amount'];
			$expense_date = $_POST['expense_date'];
			$payment_method = $_POST['payment_method'];
			$expense_comment = $_POST['expense_comment'];
			$expense_category = $_POST['expense_category'];	
			//TODO:
			//przypisanie numeru kategorii oraz rodzaju metody platnosci w zaleznosci od selecta
			
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
					//user id mam z sesji
					$db_connection->query("INSERT INTO expenses VALUES(NULL, '$user_id', '$expense_category', '$payment_method', '$amount', '$expense_date', '$expense_comment')");
				}
			}	
			catch(Exception $e)
			{
				echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie</span>';
				echo '<br />Informacja o błędzie: '.$e;
			}			
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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500&display=swap" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.13.0/themes/black-tie/jquery-ui.css" rel="stylesheet">
    
	<link rel="stylesheet" href="css/bootstrap.min.css">
    

    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/fontello.css" type="text/css">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	
    <script src="./js/jquery.3.4.1.js"></script>
    <script  src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js"
  integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk="
  crossorigin="anonymous"></script>
  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script src="js/site.js"></script>

</head>
<body>
    <div class="d-flex flex-column vh-100 overflow-hidden p-0">
      <header>
          <div class="brandTop d-flex flex-row">
              <div class="logo d-block">
                  <a href="mainMenu.php">
                      <div class="logoIcon"><i class="icon-chart-bar"> </i></div>
                      <div class="logoText">
                          <div class="textPart d-xl-inline d-block">Personal</div>
                          <div class="textPart d-xl-inline d-block">Budget</div>
                      </div> 
                  </a>                       
              </div>
              <div class="navigationArea">
                  <nav class="navbar navbar-expand-lg navbar-light bg-light">
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                      </button>                      
                      <div class="collapse navbar-collapse navi" id="navbarTogglerDemo03">
                      <ul class="navbar-nav mt-2 mt-lg-0">
                          <li class="nav-item">
                            <a class="nav-link" href="#">
                              <div class="d-flex iconMenuItem">
                                <i class="icon-down-open"></i>Dodaj <span>Przychód</span>
                              </div>
                            </a>
                          </li>
                          <li class="nav-item active">
                            <a class="nav-link " href="#">
                              <div class="d-flex iconMenuItem">
                                <i class="icon-up-open"></i>Dodaj <span>Wydatek</span>
                              </div>
                            </a>
                          </li>
                          <li class="nav-item dropdown">
                            <div class="d-flex iconMenuItem">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                  
                                <span class="icon-list-alt"></span><span class="blankLine">Przeglądaj</span><span class="blankLine">Bilans</span> 
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="#">Bieżący miesiąc</a>
                                  <a class="dropdown-item" href="#">Poprzedni miesiąc</a>
                                  <a class="dropdown-item" href="#">Bieżący rok</a>
                                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#anyPeriodModal">Dowolny okres</a>
                              </div>
                            </div>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">
                              <div class="d-flex iconMenuItem">
                                <i class="icon-sliders"></i>Ustawienia
                              </div>
                            </a>
                          </li>
                          <li class="nav-item signOutItem">
                          <a class="nav-link" href="#">Wyloguj</a>
                          </li>
                          <li class="nav-item signOut">
							<a href="logout.php">
							<button type="button" class="btn btn-outline-warning"><i class="icon-off"></i> Wyloguj</button>
							</a>
                          </li>
                      </ul>
                      </div>     
                  </nav>
              </div> 
          </div>  
      </header>
        <div class="col-12 mh-100 overflow-auto py-2 imageBackground">
            <main>
                <div class="centralArea">
                    <div class="row">
                        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 fullColorBackground">
                            <div class="d-block prosHeader">
                                <h1><i class="icon-up-open"></i>Dodaj wydatek<i class="icon-up-open"></i></h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 fullColorBackground my-4 px-4 pb-3">
                          <form method="post">
                            <div class="input-group inputControl w-100">
                                <div class="input-group-prepend w-25">
                                    <div class="input-group-text w-100 justify-content-center"><i class="icon-money"></i></div>
                                </div>
                                <input name="amount" type="number" class="form-control " min="0.0" step=".01" placeholder="Kwota">
                            </div>
                            <div class="input-group inputControl w-100">
                                <div class="input-group-prepend w-25">
                                  <label class="input-group-text w-100 justify-content-center"><span class="datePrependLabel">Data</span> <i class="icon-calendar"></i></label>
                                </div>
                                <input name="expense_date" type = "text" id = "datepicker-13" class="form-control datepicker">
                            </div>  
                            <div class="input-group mb-3 inputControl w-100">
                                <div class="input-group-prepend w-25">
                                  <div class="input-group-text justify-content-center w-100">
                                    <i class="icon-money"></i>
                                    <i class="icon-credit-card"></i>
                                    <i class="icon-euro"></i>
                                  </div>
                                </div>
                                <select name="payment_method" class="custom-select" id="inputGroupSelect01">
                                  <option selected>Forma płatności</option>
                                  <option value="1">Gotówka</option>
                                  <option value="2">Karta kredytowa</option>
                                  <option value="3">Karta debetowa</option>
                                  <option value="4">Przelew</option>
                                </select>
                            </div>
                            <div class="input-group mb-3 inputControl w-100">
                                <div class="input-group-prepend w-25">
                                  <div class="input-group-text w-100 justify-content-center"><i class="icon-th"></i></div>
                                </div>
                                <select name="expense_category" class="custom-select" id="inputGroupSelect02">
                                  <option selected>Kategoria</option>
                                  <option value="1">Jedzenie</option>
                                  <option value="2">Mieszkanie</option>
                                  <option value="3">Transport</option>
                                  <option value="4">Telekomunikacja</option>
                                  <option value="5">Opieka zdrowotna</option>
                                  <option value="6">Ubrania</option>
                                  <option value="7">Higiena</option>
                                  <option value="8">Dzieci</option>
                                  <option value="9">Rozrywka</option>
                                  <option value="10">Wycieczka</option>
                                  <option value="11">Szkolenia</option>
                                  <option value="12">Ksiązki</option>
                                  <option value="13">Oszczędności</option>
                                  <option value="14">Emerytura</option>
                                  <option value="15">Długi</option>
                                  <option value="16">Darowizna</option>
                                  <option value="17">Inne</option>
                                </select>
                            </div>
                            <div class="input-group mb-3 inputControl w-100">
                                <div class="input-group-prepend w-25">
                                  <div class="input-group-text w-100 justify-content-center"><i class="icon-edit"></i></div>
                                </div>
								<textarea id="expense_comment" name="expense_comment" rows="2" cols="50" class="form-control">Opisz swój wydatek</textarea>
                            </div>
                            <div class="buttonArea d-flex">
                              <button type="submit" class="btn btn-outline-primary w-50 mx-auto"><i class="icon-up-open"></i>Dodaj</button>
                            </div>    
                          </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="anyPeriodModal" tabindex="-1" role="dialog" aria-labelledby="anyPeriodModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="anyPeriodModalLabel">Zdefiniuj okres</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" >
                        <div class="input-group d-flex">
                            <label class=" justify-content-center">
                             <span class="datePrependLabel"></span><i class="icon-calendar"></i> Od:</label>
                          <div class="modal-body">
                            <input type="text" id="startBalancePeriod" class="form-control datepicker" data-toggle="datepicker">
                          </div> 
                        </div>
                        <div class="input-group d-flex">
                            <label class=" justify-content-center">
                             <span class="datePrependLabel"></span><i class="icon-calendar"></i> Do:</label>
                          <div class="modal-body">
                            <input type="text" id="endtBalancePeriod" class="form-control datepicker" data-toggle="datepicker">
                          </div> 
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                        <button type="button" class="btn btn-primary">Wyświetl bilans</button>
                      </div>
                    </div>
                  </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>