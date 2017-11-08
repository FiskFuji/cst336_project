<?php
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

$conn = getDatabaseConnection();

$itemID = $_GET['itemId'];
$namedParameters = array(":id" => $itemID);

$sql = "SELECT * FROM `items` i JOIN `item_category` c JOIN `item_ageGroup` a
		ON i.item_category = c.categoryId AND i.item_ageGroup = a.ageGroupId
		WHERE i.itemId = :id";
		
$stmt = $conn->prepare($sql);
$stmt->execute($namedParameters);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table class='table table-hover'>
			<tr>
				<th>Item Name</th>
				<th>Item Id</th>
				<th>Price</th>
				<th>Category</th>
				<th>Age Group</th>
				<th>Color</th>
				<th>Item Description</th>
			</tr>";
			
foreach($records as $r) {
	echo "<tr>";
    echo "<td>" .$r['name']. "</td>";
    echo "<td>" .$r['itemId']. "</td>";
    echo "<td> $" .$r['price']. "</td>";
    echo "<td>" .$r['categoryName']. "</td>";
    echo "<td>" .$r['ageGroup']. "</td>";
    echo "<td>" .$r['color']. "</td>";
    echo "<td>" .$r['itemDesc']. "</td>";
    echo "</tr>";
}

echo "</table>";

?>