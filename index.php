<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Online Shopping Catalog</title>
	</head>

	<body>
		<div class="jumbotron">
			<h1>Online Shopping Catalog</h1>
		</div>
		
		<div id="content">
			<form>
				<strong>Search: </strong> <input type="text" name="name"/>
				<input type="submit" name="go" value="Search"/>
				&nbsp;
				
				<br/>
				
				<strong>Filter By: </strong>
				<input type="radio" name="filter" value="byName" id="fName"><label for="fName">Name</label>
				<input type="radio" name="filter" value="byPrice" id="fPrice"><label for="fPrice">Price</label>
				<input type="radio" name="filter" value="byType" id="fType"><label for="fType">Type</label>
			</form>
			
			<form action="cart.php">
				<input type="submit" name="cart" value="My Cart"/>
			</form>
		</div>
	</body>
</html>
