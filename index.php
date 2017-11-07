<?php
session_start();
$conn = getDatabaseConnection();

// do other stuff

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

function getItemTypes() {
	global $conn;
	
	$sql = "SELECT * FROM `item_category` WHERE 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	
	$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($records as $r) {
		echo "<option> " . $r['categoryName'] . " </option>";
	}
}

function getItemGroups() {
	global $conn;
	
	$sql = "SELECT * FROM `item_ageGroup` WHERE 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	
	$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($records as $r) {
		echo "<option> " . $r['ageGroup'] . " </option>";	
	}
}

function displayItems() {
	global $conn;
	
	$sql = "SELECT * FROM `items` i JOIN `item_category` c JOIN `item_ageGroup` a
			ON i.item_category = c.categoryId AND i.item_ageGroup = a.ageGroupId
			WHERE 1";
	
	if(isset($_GET['go'])) {
		if(!empty($_GET['name'])) {
			$sql .= " AND i.name LIKE :itemName";
			$namedParameters[':itemName'] = "%" . $_GET['name'] . "%";
		}
		
		if(!empty($_GET['category'])) {
			$sql .= " AND c.categoryName = :itemCat";
			$namedParameters[':itemCat'] = $_GET['category'];
		}
		
		if(!empty($_GET['agegroup'])) {
			$sql .= " AND a.ageGroup = :age";
			$namedParameters[':age'] = $_GET['agegroup'];
		}
		
		if($_GET['price'] == "low") {
			$sql .= " ORDER BY i.price";
		}
		
		if($_GET['price'] == "high") {
			$sql .= " ORDER BY i.price DESC";
		}
	}
	
	if(!isset($_GET['price'])) {
		$sql .= " ORDER BY i.name";
	}
	
	$stmt = $conn->prepare($sql);
	$stmt->execute($namedParameters);
	
	$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo "<table>
			<tr>
				<th>Item Name</th>
				<th>Price</th>
				<th>Category</th>
				<th>Age Group</th>
			</tr>";
			
	foreach($records as $r) {
		echo "<tr>";
        echo "<td>" .$r['name']. "</td>";
        echo "<td>" .$r['price']. "</td>";
        echo "<td>" .$r['categoryName']. "</td>";
        echo "<td>" .$r['ageGroup']. "</td>";
        echo "</tr>";
	}
	
	echo "</table>";
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Online Shopping Catalog</title>
	</head>

	<body>
		<div class="jumbotron">
			<h1>Online Shopping Catalog</h1>
			<form action="cart.php">
				<input type="submit" name="cart" value="My Cart"/>
			</form>
		</div>
		
		<div id="content">
			<br/>
			
			<form>
				<table>
					<tr>
						<td><strong>Search: </strong></td>
						<td><input type="text" name="name"/></td>
						<td><input type="submit" name="go" value="Search"/></td>
					</tr>

					<tr>				
						<td><strong>Category:</strong></td>
						<td>
							<select name="category">
								<option value="">Select One</option>
								<?=getItemTypes()?>
							</select>
						</td>
					</tr>
					
					<tr>
						<td><strong>Age Group:</strong></td>
						<td>
							<select name="agegroup">
								<option value="">Select One</option>
								<?=getItemGroups()?>
							</select>
						</td>
					</tr>
					
					<tr>
						<td><strong>By Price:</strong></td>
						<td><input type="radio" name="price" value="low" id="lowToHigh"><label for="lowToHigh">Lowest First</label></td>
						<td><input type="radio" name="price" value="high" id="highToLow"><label for="highToLow">Highest First</label></td>
					</tr>
				</table>
			</form>
			
			<hr>
			
			<?=displayItems()?>
		</div>
	</body>
</html>
