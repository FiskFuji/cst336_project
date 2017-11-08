<?php
session_start();
//fuck im so sorry
$maxCartSize = 10;

$_SESSION['Cart'] = $_GET;


echo $_SESSION['Cart'];
function displayCart() {
    $sql = "SELECT * FROM `items` i JOIN `item_category` c JOIN `item_ageGroup` a
			ON i.item_category = c.categoryId AND i.item_ageGroup = a.ageGroupId
			AND i.itemId = ". $_SESSION['Cart']['itemId'] ."";
    $stmt = $conn->prepare($sql);
	$stmt->execute($namedParameters);
	
	$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo "<table class='table table-hover'>
			<tr>
				<th>Item Name</th>
				<th>Price</th>
				<th>Category</th>
				<th>Age Group</th>
			</tr>";
			
	foreach($records as $r) {
		echo "<tr>";
        echo "<td><a target='itemInfo' href='itemInfo.php?itemId=".$r['itemId']."'>".$r['name']."</a></td>";
        echo "<td> $" .$r['price']. "</td>";
        echo "<td>" .$r['categoryName']. "</td>";
        echo "<td>" .$r['ageGroup']. "</td>";
        echo "</tr>";
	}
	
	echo "</table>";
}

?>

<html>
    <head>
    <meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Shopping Cart Bonanza</title>
        <link  href="css/styles.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	</head>
    
    <body>
        <a href="index.php" >Home</a>
    </body>
</html>