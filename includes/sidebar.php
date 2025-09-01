<div class="row rogen ">
	<div class="box box-solid">
		<div class="box-header with-border">
			<h3 class="box-title text-center"><b>Most Viewed Today</b></h3>
		</div>
		<div class="box-body">
			<ul id="trending">
				<?php
				$now = date('Y-m-d');

				$query = "SELECT * FROM products WHERE date_view = '$now' AND delete_flag = 0 ORDER BY counter DESC LIMIT 10";
				$result = mysqli_query($conn, $query);

				if (!$result) {
					die("Query failed: " . mysqli_error($conn));
				}

				while ($row = mysqli_fetch_assoc($result)) {
					echo "<li><a href='product.php?product=" . $row['slug'] . "'>" . $row['name'] . "</a></li>";
				}

				?>

				<ul>
		</div>
	</div>
</div>