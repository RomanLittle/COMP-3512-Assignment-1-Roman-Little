<?php
    require_once 'includes\config.inc.php';
    require_once 'includes\db-classes.inc.php';

    
    try { 

        if(isset($_GET['Symbol'])){
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS)); 
            $companyGateway = new CompaniesDB($conn); 
            $company = $companyGateway->getAllForSymbol($_GET['Symbol']); 
            $stockgateway = new companyStockDB($conn);
            $stocks = $stockgateway->getAllForSymbol($_GET['Symbol']);
            //print_r($stocks);
        }else{

        }
       
    }catch(Exception $e){
        die( $e->getMessage() ); 
    }
    
    
?>
<!DOCTYPE html>
<html lang=en>
<head>
    <title>Assignment 1 company page</title>
    <link rel="stylesheet" href="css/main-css-include.css">
    
</head>

<body >
    <header>
        <nav id="topbar">
            <div id = "header-box">
            <h1>Portfolio Project</h1>
            
            <div id="button-box">
                <a href ="index.php?">Home</a>
                <a href ="about.php?">About</a>
                <a href ="api.php?">APIs</a>
            </div>
                
            
            </div>
        </nav>
    </header>
    <main class = "container">
        <div class = "grid-container">
            <div id = "middle-box-company">
                <div id = "companyInfo">
                    <h2 id = "companyInfoTitle"> Company Info </h2>
                    <?php
                        if(isset($_GET['Symbol'])){
                            foreach ($company as $row => $innerArray){
                            echo "<div>Name: ".$innerArray["name"]."</div>";
                            echo "<div>Symbol: ".$innerArray["symbol"]."</div>";
                            echo "<div>Sector: ".$innerArray["sector"]."</div>";
                            echo "<div>Subindustry: ".$innerArray["subindustry"]."</div>";
                            echo "<div>Address: ".$innerArray["address"]."</div>";
                            echo "<div>Exchange: ".$innerArray["exchange"]."</div>";
                            echo "<div>Website: <a href =\"".$innerArray["website"]."\"> ".$innerArray["name"]. "</a></div>";
                            echo "<div>Description: ".$innerArray["description"]."</div>";
                            echo "<div>Financials: ";
                            echo "<br>";
                            $string = $innerArray["financials"];
                            if ($string ==""){
                                echo "N/A";
                            }else{
                                $modString = strtr($string,[ "a"=>"", "b"=>"", "c"=>"", "d"=>"", "e"=>"", "f"=>"", "g"=>"", "h"=>"", "i"=>"", "j"=>"", "k"=>"", "l"=>"", "m"=>"", "n"=>"", "o"=>"", "p"=>"", "q"=>"", "r"=>"", "s"=>"", "t"=>"", "u"=>"", "v"=>"", "w"=>"", "x"=>"", "y"=>"", "z"=>"", "["=>"", "]"=>"", "{"=>"", "}"=>"", ":"=>"","\"" => ""]);
                            //echo $modString;
                                echo "<table>";
                                echo "<tr>";
                                echo "<th> Year </th>";
                                echo "<th> Revenue </th>";
                                echo "<th> Earnings </th>";
                                echo "<th> Assets </th>";
                                echo "<th> Liabilities </th>";
                                echo "</tr>";

                            $modArray = explode(",", $modString);
                                echo "<tr>";
                                echo "<td> ".$modArray[0]." </td>";
                                echo "<td> $".$modArray[3]." </td>";
                                echo "<td> $".$modArray[6]." </td>";
                                echo "<td> ".$modArray[9]." </td>";
                                echo "<td> ".$modArray[12]." </td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td> ".$modArray[1]." </td>";
                                echo "<td> $".$modArray[4]." </td>";
                                echo "<td> $".$modArray[7]." </td>";
                                echo "<td> ".$modArray[10]." </td>";
                                echo "<td> ".$modArray[13]." </td>";
                                echo "</tr>";
                            
                                echo "<tr>";
                                echo "<td> ".$modArray[2]." </td>";
                                echo "<td> $".$modArray[5]." </td>";
                                echo "<td> $".$modArray[8]." </td>";
                                echo "<td> ".$modArray[11]." </td>";
                                echo "<td> ".$modArray[14]." </td>";
                                echo "</tr>";
                                echo "</table>";
                            
                            }
                            }
                            
                        }else{
                            echo "<div>Name: ";
                            echo "<div>Symbol: ";
                            echo "<div>Sector: ";
                            echo "<div>Subindustry: ";
                            echo "<div>Address: ";
                            echo "<div>Exchange: ";
                            echo "<div>Website: ";
                            echo "<div>Description: ";
                            echo "<div>Financials: ";
                        }
                        
                    ?>
                </div>
                </div>
                
                <div id = "stocks-to-display">
                    <h3 id = "historyTitle">History </h3>
                    <table id = "stocksTable">
                        <tr>
                            <th>Date</th>
                            <th>Volume</th>
                            <th>Open</th>
                            <th>Close</th>
                            <th>High</th>
                            <th>Low</th>

                        </tr>
                        <?php
                        $high =0;
                        $low = 900000000000000;
                        $totVol =0;
                        $counter =0;
                        if(isset($_GET['Symbol'])){
                            foreach ($stocks as $row => $innerArray){
                                echo "<tr>";
                                echo "<td>".$innerArray["date"]."</td>";
                                echo "<td>".$innerArray["volume"]."</td>";
                                echo "<td> $".round($innerArray["open"],2)."</td>";
                                echo "<td> $".round($innerArray["close"],2)."</td>";
                                echo "<td> $".round($innerArray["high"],2)."</td>";
                                echo "<td> $".round($innerArray["low"],2)."</td>";
                                echo "</tr>";
                                if($innerArray["high"] > $high){
                                    $high = $innerArray["high"];
                                }
                                if($innerArray["low"] < $low){
                                    $low = $innerArray["low"];
                                }
                                $totVol = $totVol + $innerArray["volume"];
                                $counter +=1;

                            }
                                
                        }

                        
                        ?>
                    </table>
                </div>

                <div id = "statsToDisplay">
                        <div id = "fancyBox">
                            <?php
                            echo "Historical Heigh: ";
                            echo "$".round($high,2)?>
                        </div>
                        <div id = "fancyBox">
                            <?php
                            echo "Historical Low: ";
                            echo "$".round($low,2)?>
                        </div>
                        <div id = "fancyBox">
                            <?php
                            echo "Total Volume: ";
                            echo $totVol?>
                        </div>
                        <div id = "fancyBox">
                            <?php
                            echo "Average Volume: ";
                            echo round($totVol/$counter)?>
                        </div>
                </div>
            </div>
            
        </div>
    </main>
</body>