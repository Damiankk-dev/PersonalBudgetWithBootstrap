<?php

	session_start();
	function cashflow_query($start_date, $end_date, $cashflow_type, $db_connection)
	{	
		$user_id = $_SESSION['id'];
		$cashflow_date_column = "date_of_".substr($cashflow_type, 0, -1);
		return sprintf("SELECT * FROM %s WHERE user_id='%s'
		AND %s BETWEEN '%s' AND '%s' ORDER BY %s",
		mysqli_real_escape_string($db_connection, $cashflow_type),
		mysqli_real_escape_string($db_connection, $user_id),
		mysqli_real_escape_string($db_connection, $cashflow_date_column),
		mysqli_real_escape_string($db_connection, $start_date),
		mysqli_real_escape_string($db_connection, $end_date),
		mysqli_real_escape_string($db_connection, $cashflow_date_column));		
	}
	function cashflow_sum($start_date, $end_date, $cashflow_type, $db_connection)
	{	
		$cashflow_date_column = "date_of_".substr($cashflow_type, 0, -1);
		$user_id = $_SESSION['id'];
		return sprintf("SELECT SUM(amount) AS sum FROM %s WHERE user_id='%s'
		AND %s BETWEEN '%s' AND '%s'",
		mysqli_real_escape_string($db_connection, $cashflow_type),
		mysqli_real_escape_string($db_connection, $user_id),
		mysqli_real_escape_string($db_connection, $cashflow_date_column),
		mysqli_real_escape_string($db_connection, $start_date),
		mysqli_real_escape_string($db_connection, $end_date));		
	}
	function get_casflow_table($db_connection, $cashflow_query)
	{
		if($connection_result = @$db_connection->query($cashflow_query))
		{
			$no_of_records = $connection_result->num_rows;
			if ($no_of_records > 0)
			{
				$cashflow_data_rows = $connection_result->fetch_all(MYSQLI_ASSOC);
				return $cashflow_data_rows;
			}
		}
		else return null;	
	}
	function get_cashflow_sum($db_connection, $sum_cashflow_query)
	{		
		if($connection_result_sum = @$db_connection->query($sum_cashflow_query))
		{	
			$cashflow_sum_row = mysqli_fetch_row($connection_result_sum);
			$sum_expense = $cashflow_sum_row[0];
			return $sum_expense;
		}
		else return 0;
	}
	function get_balance($db_connection, $start_date, $end_date)
	{		
		$expense_query = cashflow_query($start_date, $end_date, 'expenses', $db_connection);
		$sum_expense_query = cashflow_sum($start_date, $end_date, 'expenses', $db_connection);
		$income_query = cashflow_query($start_date, $end_date, 'incomes', $db_connection);
		$sum_income_query = cashflow_sum($start_date, $end_date, 'incomes', $db_connection);
		$_SESSION['expenses_table'] = get_casflow_table($db_connection, $expense_query);
		$_SESSION['expenses_sum'] = get_cashflow_sum($db_connection, $sum_expense_query);
		$_SESSION['incomes_table'] = get_casflow_table($db_connection, $income_query);
		$_SESSION['incomes_sum'] = get_cashflow_sum($db_connection, $sum_income_query);
	}
	// expense collumns:
	//	id	user_id	expense_category_assigned_to_user	payment_method_assigned_to_user	expense_amount	date_of_expense	expense_comment
	
	if(!(isset($_SESSION['logged_in']))) 
	{
		header('Location: index.php');
	}
	else 
	{
		require_once "dbconnect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try
		{
			$balance_type = htmlspecialchars($_GET["balance_type"]);
			$user_id = $_SESSION['id'];
			$start_date;
			$end_date;
			$expense_query;
			$expense_sum;
			$db_connection = new mysqli($host, $db_user, $db_password, $database);
			
			if ($db_connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else 
			{
				switch($balance_type)
				{
					case "Actual_month":
						$end_date = date('Y-m-d');
						$start_date = date('Y-m-01');
						get_balance($db_connection, $start_date, $end_date);						
						break;				
					case "Previous_month":
						$end_date = date('Y-m-d', strtotime('last day of previous month'));
						$start_date = date('Y-m-d', mktime(0, 0, 0, date('m')-1 ,1 ,date('Y')));
						get_balance($db_connection, $start_date, $end_date);	
						break;
					case "Actual_year":
						$end_date = date('Y-m-d');
						$start_date = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')));
						get_balance($db_connection, $start_date, $end_date);	
						break;
					case "Custom":
						$end_date = $_POST['endBalancePeriod'];
						$start_date = $_POST['startBalancePeriod'];
						get_balance($db_connection, $start_date, $end_date);	
						break;	
					default:
						echo "Invalid query";
				}
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
                            <a class="nav-link" href="income.php">
                              <div class="d-flex iconMenuItem">
                                <i class="icon-down-open"></i>Dodaj <span>Przychód</span>
                              </div>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="expense.php">
                              <div class="d-flex iconMenuItem">
                                <i class="icon-up-open"></i>Dodaj <span>Wydatek</span>
                              </div>
                            </a>
                          </li>
                          <li class="nav-item dropdown">
                            <div class="d-flex iconMenuItem">
                              <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">                                  
                                <span class="icon-list-alt"></span><span class="blankLine">Przeglądaj</span><span class="blankLine">Bilans</span> 
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="balance.php?balance_type=Actual_month">Bieżący miesiąc</a>
                                  <a class="dropdown-item" href="balance.php?balance_type=Previous_month">Poprzedni miesiąc</a>
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
                        <div class="col-12 fullColorBackground">
                            <div class="d-block prosHeader">
                                <h1><i class="icon-chart-bar"></i>Twój bilans<i class="icon-chart-bar"></i></h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 fullColorBackground my-4 px-4 pb-3 d-flex justify-content-center">                          
                          <div class="main_wrapper_balance d-flex flex-column w-100">
                            <div class="container_cashflow_wrapper px-2 justify-content-around">
                              <div class="container_cashflow_col d-flex flex-column align-items-center">
                                <div class="balance_header_tile">
                                    <h3>Przychody</h3>
                                </div>
                                <div class="cashflow_table_wrap my-1">
									<table  class="income_table cashflow_table">
										<th>Wartość</th>
										<th>Data</th>
										<th>Opis</th>
										<?php
										
										if (isset($_SESSION['incomes_table']))
										{
											$expense_data_rows = $_SESSION['incomes_table'];
											foreach ($expense_data_rows as $row)
											{
												echo "<tr><td>".$row['amount']."</td>"."<td>".$row['date_of_income']."</td>"."<td>".$row['income_comment']."</td></tr>";
											}
										}
										
										?>
									</table>
                                </div>								
                                <div class="balance_footer_tile">
                                    <h5>SUMA: 
									<?= $_SESSION['incomes_sum']; ?>
									</h5>
                                </div>                               
                              </div>
                              <div class="container_cashflow_col d-flex flex-column align-items-center">
                                <div class="balance_header_tile">
                                    <h3>Wydatki</h3>
                                </div>
                                <div class="cashflow_table_wrap my-1">
									<table  class="expense_table cashflow_table">
										<th>Wartość</th>
										<th>Data</th>
										<th>Opis</th>
										<?php
										
										if (isset($_SESSION['expenses_table']))
										{
											$expense_data_rows = $_SESSION['expenses_table'];
											foreach ($expense_data_rows as $row)
											{
												echo "<tr><td>".$row['amount']."</td>"."<td>".$row['date_of_expense']."</td>"."<td>".$row['expense_comment']."</td></tr>";
											}
										}
										
										?>
									</table>
                                </div>								
                                <div class="balance_footer_tile">
                                    <h5>SUMA: 
									<?= $_SESSION['expenses_sum']; ?>
									</h5>
                                </div>
                              </div>
                            </div>
                            <div class="container_balance_row d-flex flex-column px-2 align-items-center">
                              <div class="balance_header_tile">
                                  <h3>Bilans</h3>
                              </div> 
                              <div id="registerArea" class=" my-1">
                              </div>                           
                            </div>
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
					  <form action="balance.php?balance_type=Custom" method="post">
						  <div class="modal-body" >
							<div class="input-group d-flex">
								<label class=" justify-content-center">
								 <span class="datePrependLabel"></span><i class="icon-calendar"></i> Od:</label>
							  <div class="modal-body">
								<input type="text" name="startBalancePeriod" class="form-control datepicker" data-toggle="datepicker">
							  </div> 
							</div>
							<div class="input-group d-flex">
								<label class=" justify-content-center">
								 <span class="datePrependLabel"></span><i class="icon-calendar"></i> Do:</label>
							  <div class="modal-body">
								<input type="text" name="endBalancePeriod" class="form-control datepicker" data-toggle="datepicker">
							  </div> 
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
							<button type="submit" class="btn btn-primary">Wyświetl bilans</button>
						  </div>					  
					  </form>
                    </div>
                  </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>