<?php
    require_once 'includes\config.inc.php';
    require_once 'includes\db-classes.inc.php';
    header_remove();
    
    try { 
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS)); 
        $customerGateway = new CustomersDB($conn); 
        $customer = $customerGateway->getAll();
        if(isset($_GET['id'])){
            $portfolioGateway = new userPortfolios($conn);
            $portfolio = $portfolioGateway->getAllForUser($_GET['id']);
            //print_r($portfolio);
        } 
        
    }catch(Exception $e){
        die( $e->getMessage() ); 
    }
    
?>
<!DOCTYPE html>
<html lang=en>
<head>
    <title>Assignment 1</title>
    <link rel="stylesheet" href="css/main-css-include.css">
    
</head>

<body >
    <header>
        <nav id="topbar">
            <div id = "header-box">
            <h1 id = "title">Portfolio Project</h1>
            
            <div id="button-box">
                <a href ="index.php?" id = "links">Home</a>
                <a href ="about.php?">About</a>
                <a href ="api.php?">APIs</a>
            </div>
                
            
            </div>
        </nav>
    </header>
    <main class = "container">
        <div class = "grid-container">
            <div id = "left-box">
               <div id = "customers">
                    <h2>Customers</h2>
                    <h3>Name</h3>
                    <?php
                        
                        foreach($customer as $row => $innerArray){

                            
                            echo $innerArray["firstname"];
                            echo ", ";
                            echo $innerArray["lastname"];
                            echo ": ";
                            echo "<a href = \"index.php?id=".$innerArray['id']."\"> Portfolio</a>";
                            //echo "<button class = \"". $innerArray["firstname"]."\" type = \"submit\"> Portfolio </button>"; button didnt work so its a link now
                            echo "<br> </br>";

                        }
                    ?>
               </div> 
            </div>
            <div id = "right-box">
                <?php
                if(isset($_GET['id'])){
                    echo "<div id = \"Portfolio-Summary\" >";
                    echo "<h3>Portfolio Summary</h3>";
                    $companyCount =0;
                    $shareTotal =0;
                    $totalValue =0;
                    foreach($portfolio as $row => $innerArray){
                        $companyCount +=1;
                        $shareTotal +=$innerArray['amount'];
                        $stockgateway = new companyStockDB($conn);
                        $stocks = $stockgateway->getAllForSymbol($innerArray['symbol']);
                        //print_r($stocks);
                        $array1 = $stocks[0];
                        //print_r ($array1);
                        $monetaryValuePerStock = $array1['close'];
                        //echo $monetaryValuePerStock;
                        $monetaryValue = $monetaryValuePerStock * $innerArray['amount'];
                        //echo "$".$monetaryValue;
                        $totalValue += ($monetaryValue * $innerArray['amount']);
                    }

                    echo "<div id = companyCountBox>";
                    echo "<h4> Companies </h4>";
                    echo "<h3>".$companyCount."</h3>";
                    echo "</div>";

                    echo "<div id = shareTotalBox>";
                    echo "<h4> Total Shares </h4>";
                    echo "<h3>".$shareTotal."</h3>";
                    echo "</div>";

                    echo "<div id = totalValueBox>";
                    echo "<h4> Total Value </h4>";
                    echo "<h3> $".round($totalValue,2)."</h3>";
                    echo "</div>";
                    




                    echo "</div>";
                    echo "<div id = \"Portfolio-Details\" >";
                    echo "<h3>Portfolio Details</h3>";

                    echo "<table>";
                        echo"<tr>";
                            echo "<th> Symbol </th>";
                            echo "<th> Name </th>";
                            echo "<th> Sector </th>";
                            echo "<th> Amount </th>";
                            echo "<th> Value </th>";
                        echo"</tr>";
                        foreach($portfolio as $row => $innerArray){
                            echo "<tr>";
                            echo "<td> <a href = \"companyPage.php?Symbol=".$innerArray['symbol']."\">".$innerArray['symbol']."</td>";
                            $stockgateway = new companyStockDB($conn);
                            $stocks = $stockgateway->getAllForSymbol($innerArray['symbol']);
                             //print_r($stocks);
                            $array1 = $stocks[0];
                            //print_r ($array1);
                            $monetaryValuePerStock = $array1['close'];
                            //echo $monetaryValuePerStock;
                            $monetaryValue = $monetaryValuePerStock * $innerArray['amount'];
                            //echo "$".$monetaryValue;
                            $totalValue += ($monetaryValue * $innerArray['amount']);

                            $companyGateway = new CompaniesDB($conn); 
                            $company = $companyGateway->getAllForSymbol($innerArray['symbol']);
                            foreach ($company as $row => $innerArray2){
                            //name
                                echo "<td> ".$innerArray2['name']."</td>";
                                //sector
                                echo "<td> ".$innerArray2['sector']."</td>";
                            }
                            //sector
                            echo "<td> ".$innerArray['amount']."</td>";
                            echo "<td> $".round($totalValue,2)."</td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                    echo "</div>";
                }else{
                    echo "<h3 id = \"selectUserPlease\">Please Select A User</h3>";
                }
                ?>

                
            
            </div>
        </div>
    </main>
</body>
