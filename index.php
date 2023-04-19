<?php  
// koneksi database
require 'lib/functions.php';
$data = tampil("SELECT * FROM tb_plta ORDER BY ID DESC LIMIT 1");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="refresh" content="5">
	<link rel="stylesheet" type="text/css" href="style/try style.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
	<title>MONITORING PLTA</title>
</head>

<body>
	<nav>
		<div class="logo">
			<h4>Tri Ulia Sari</h4>
		</div>

		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="data.php">All Data</a></li>
		</ul>

	</nav>

	<div class="conteiner">
		<div class="judul">
			<h2>MONITORING PLTA</h2>
		</div>
		<div class="content">
			<div class="tegangan">
				<div class="hasilT">
					<?php foreach($data as $row ) : ?>
						<p><?php echo $row["tegangan"]; ?></p>
					<?php endforeach; ?>
				</div>
				<div class="jtegangan">
					<h1>TEGANGAN</h1>
				</div>
			</div>
			<div class="arus">
				<div class="hasilA">
					<?php foreach($data as $row ) : ?>
						<p><?php echo $row["arus"]; ?> </p>
					<?php endforeach; ?>
				</div>
				<div class="jarus">
					<h1>ARUS</h1>
				</div>
			</div>
			<div class="rpm">
				<div class="hasilR">
					<?php foreach($data as $row ) : ?>
						<p><?php echo $row["rpm"]; ?></p>
					<?php endforeach; ?>
				</div>
				<div class="jrpm">
					<h1>RPM</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="ig">
			<p>@tri.ull</p>
			<img src="gambar/ig.png">
		</div>
		<div class="cp">
			<p>Contact Person : 0823 8955 7148</p>
		</div>
	</div>
</body>
</html>