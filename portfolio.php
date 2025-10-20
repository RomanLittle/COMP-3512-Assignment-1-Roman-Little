<?php 
    require_once 'includes\config.inc.php';
    require_once 'includes\db-classes.inc.php';
    header ('Content-Type: application/json');
    echo "test";
    try { 
        $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS)); 
        $customerGateway = new CustomersDB($conn); 
        $customer = $customerGateway->getAll();
        if(isset($_GET['ref'])){
            $portfolioGateway = new userPortfolios($conn);
            $portfolio = $portfolioGateway->getAllForUser($_GET['ref']);
            print_r($portfolio);
        }else{
            $portfolioGateway = new userPortfolios($conn);
            $portfolio = $portfolioGateway->getAll();
            print_r($portfolio);
        }
        
    }catch(Exception $e){
        die( $e->getMessage() ); 
    }
?>