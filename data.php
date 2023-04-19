<?php  
	// koneksi database
	require 'lib/functions.php';

	$jdph = 15;
	$jd = count(tampil("SELECT * FROM tb_plta"));
	$jh = ceil($jd/$jdph);
	$ha = (isset($_GET["page"])) ? $_GET['page'] : 1;
	$ad = ($jdph * $ha) - $jdph;

	$data = tampil("SELECT * FROM tb_plta LIMIT $ad, $jdph");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style/data_style.css">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
	<title>ALL DATA PLTA</title>
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
			<h2>DATA PLTA</h2>
		</div>
		<div class="tabel">
			<div class="header">
				<div class="no">NO</div>
				<div class="date">DATE</div>
				<div class="tegangan">TEGANGAN</div>
				<div class="arus">ARUS</div>
				<div class="rpm">RPM</div>
			</div>
			<?php $i = $ad + 1; ?>
			<?php foreach($data as $row ) : ?>
			<div class="isi">	
				<div class="no">
					<?= $i;  ?>			
				</div>	
				<div class="date">
					<p><?php echo $row["date"]; ?></p>
				</div>
				<div class="tegangan">
					<p><?php echo $row["tegangan"]; ?> V</p> 
				</div>
				<div class="arus">
					<p><?php echo $row["arus"]; ?> A</p>
				</div>
				<div class="rpm">
					<p><?php echo $row["rpm"]; ?></p>
				</div>
			</div>
			<?php $i++; ?>
			<?php endforeach; ?>
		</div>	
	</div>

	<div class="pagination">
		<div class="previous">
			<?php if($ha>1) : ?>
				<a href="?page=<?= $ha - 1 ?>">&laquo;</a>
			<?php endif; ?>
		</div>

		<div class="last">
			<?php if($ha == 1) : ?>
				<a href="?page=<?= $jh ?>">Last Page</a>
			<?php endif; ?>
		</div>

		<div class="page">
			<?php if($ha == 1) : ?>
				<?php for($i = 1; $i<= $ha+4; $i++ )  : ?>
					<?php if($i == $ha) : ?>
						<p class="active"><?= $i ?></p>
					<?php else : ?>
						<a href="?page=<?= $i ?>"><?= $i ?></a>
					<?php endif; ?>
				<?php endfor; ?>
			<?php elseif($ha == 2) : ?>
				<?php for($i = 1; $i<= $ha+3; $i++ )  : ?>
					<?php if($i == $ha) : ?>
						<p class="active"><?= $i ?></p>
					<?php else : ?>
						<a href="?page=<?= $i ?>"><?= $i ?></a>
					<?php endif; ?>
				<?php endfor; ?>	
			<?php elseif($ha == $jh) : ?>
				<?php for($i = $jh-4; $i<=$jh; $i++ )  : ?>
					<?php if($i == $ha) : ?>
						<p class="active"><?= $i ?></p>
					<?php else : ?>
						<a href="?page=<?= $i ?>"><?= $i ?></a>
					<?php endif; ?>
				<?php endfor; ?>
			<?php elseif($ha == $jh-1) : ?>
				<?php for($i = $jh-4; $i<=$jh; $i++ )  : ?>
					<?php if($i == $ha) : ?>
						<p class="active"><?= $i ?></p>
					<?php else : ?>
						<a href="?page=<?= $i ?>"><?= $i ?></a>
					<?php endif; ?>
				<?php endfor; ?>
			<?php elseif($ha == $jh-2) : ?>
				<?php for($i = $jh-4; $i<=$jh; $i++ )  : ?>
					<?php if($i == $ha) : ?>
						<p class="active"><?= $i ?></p>
					<?php else : ?>
						<a href="?page=<?= $i ?>"><?= $i ?></a>
					<?php endif; ?>
				<?php endfor; ?>	
			<?php else : ?>
				<?php for($i = $ha - 2; $i<=$ha+2; $i++ )  : ?>
					<?php if($i == $ha) : ?>
						<p class="active"><?= $i ?></p>
					<?php else : ?>
						<a href="?page=<?= $i ?>"><?= $i ?></a>
					<?php endif; ?>
				<?php endfor; ?>
			<?php endif; ?>
		</div>

		<div class="first">
			<?php if($ha == $jh) : ?>
				<a href="?page=<?= 1 ?>">First Page</a>
			<?php endif; ?>
		</div>

		<div class="next">
			<?php if($ha< $jh) : ?>
				<a href="?page=<?= $ha + 1 ?>">&raquo;</a>
			<?php endif; ?>
		</div>			
	</div>
</body>
</html>