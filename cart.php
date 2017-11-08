<?php

session_start();


function getDatabaseConnection() {
    $host = 'localhost';
    $dbname = 'tcp';
    $username = 'root';
    $password = '';
    
    if(strpos($_SERVER['HTTP_HOST'], 'herokuapp') !== false) {
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $host = $url["host"];
        $dbname = substr($url["path"], 1);
        $username = $url["user"];
        $password = $url["pass"];
    }
    
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $dbConn;
}



function displayItems(){
    $totalPrice = 0;
    
    if(isset($_SESSION['currentCart'])){
         echo "<table class='table table-hover' border = '1'>
        			<tr>
        				<th>Item Name</th>
        				<th>Price</th>
        			</tr>";
    foreach($_SESSION['currentCart'] as $elements){
         $conn = getDatabaseConnection();


        $namedParameters = array(":id" => $elements);
        
        $sql = "SELECT * FROM `items` i JOIN `item_category` c JOIN `item_ageGroup` a
        		ON i.item_category = c.categoryId AND i.item_ageGroup = a.ageGroupId
        		WHERE i.itemId = :id";
        		
        $stmt = $conn->prepare($sql);
        $stmt->execute($namedParameters);
        
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
       
        			
        foreach($records as $r) {
        	echo "<tr>";
            echo "<td>" .$r['name']. "</td>";
            echo "<td> $" .$r['price']. "</td>";
            $totalPrice += $r['price'];
            echo "</tr>";
        }
        
    
    
        
    }
     echo "</table>";
     
     echo "<table class='table table-hover' border = '2'>";
    	echo "<tr>";
        echo "<td>Total Price</td>";
        echo "<td> $". $totalPrice. "</td>";
        echo "</tr>";
   echo "</table>"; 
    
}
else{
    echo "<h2>Cart is Empty </h2>";
}
}

function clearData(){
    session_unset();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Checkout Page </title>
        <meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link  href="css/styles.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	</head>
    </head>
    <body>
        <div id = "Cart">
            <h1>Checkout Items</h1>
            <?=displayItems()?>
    
        
       <form action = "clearCart.php">
           <button type='submit'>Clear Cart</button>
       </form>
       
       <form action = "index.php">
           <input type = "submit" value = "Continue Shopping">
       </form>
       
       </div>

    </body>
</html>