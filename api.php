<?php 
    require_once 'includes\config.inc.php';
    require_once 'includes\db-classes.inc.php';
    
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
            <div id = "api-middle-box">
            <h3 id = "apiTitle">API List</h3>
            <table id = apiTable>
                <tr>
                    <th>URL</th>
                    <th>Description</th>
                </tr>
                <tr>
                    <td><a href = "companies.php">/api/companies.php</a></td>
                    <td>Returns all the companies/stocks</td>
                </tr>
                <tr>
                    <td><a href = "companies.php?ref=ADS">/api/companies.php?ref=ads</a></td>
                    <td>Returns just a specific company/stock</td>
                </tr>
                <tr>
                    <td><a href = "portfolio.php?ref=8">/api/portfolio.php?ref=8"</a></td>
                    <td>Returns all the portfolios for a specific sample customer</td>
                </tr>
                <tr>
                    <td><a href = "history.php?ref=ads">/api/history.php?ref=ads</a></td>
                    <td>Returns the history information for a specific sample company</td>
                </tr>

            </table>
            </div>
        </div>
    </main>
</body>