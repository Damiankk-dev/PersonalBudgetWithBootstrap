<?php 
	session_start();
	if(!($_SESSION['logged_in'])) 
	{
		header('Location: index.php');
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
  <link href="https://code.jquery.com/ui/1.13.0/themes/black-tie/jquery-ui.css" rel="stylesheet">
  
<link rel="stylesheet" href="css/bootstrap.min.css">
  

  <link href="./css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/fontello.css" type="text/css">

  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

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
                          <a class="nav-link" href="income.php">
                            <div class="d-flex iconMenuItem">
                              <i class="icon-down-open"></i>Dodaj <span>Przychód</span>
                            </div>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link " href="expense.php">
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
                                <a class="dropdown-item" href="balance.php?balance_type=Actual_month">Bieżący miesiąc</a>
                                <a class="dropdown-item" "balance.php?balance_type=Previous_month">Poprzedni miesiąc</a>
                                <a class="dropdown-item" href="balance.php?balance_type=Actual_year">Bieżący rok</a>
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
                        <div class="col-12 col-xl-10 offset-xl-1 quoteArea">
                            <div id="quote">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                    Commodi molestiae nobis omnis.</p>
                                <div id="author">Autor Cytatu</div>
                            </div>
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
						<a href="balance.php?balance_type=Custom">
                        <button type="button" class="btn btn-primary">Wyświetl bilans</button>
						</a>
                      </div>
                    </div>
                  </div>
                </div>
            </main>
        </div>
    </div>

    <script src="./js/jquery.3.4.1.js"></script>
    <script  src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js"
  integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk="
  crossorigin="anonymous"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/site.js"></script>
</body>
</html>