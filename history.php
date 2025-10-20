<?php 
    require_once 'includes\config.inc.php';
    require_once 'includes\db-classes.inc.php';
    header ('Content-Type: application/json');
    echo "test";
    try { 

        if(isset($_GET['ref'])){
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS));  
            $stockgateway = new companyStockDB($conn);
            $stocks = $stockgateway->getAllForSymbol(strtoupper($_GET['ref'])); 
            print_r($stocks);
            //echo $_GET['ref'];
        }else{
            $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS)); 
            $stockgateway = new CompaniesDB($conn); 
            $stocks = $stockgateway->getAll(); 
            print_r($company);
        }
    }catch(Exception $e){
        die( $e->getMessage() ); 
    }
?>