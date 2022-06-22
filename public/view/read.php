<?php
include "../action/action.php";

if ($_SESSION['signin'] == 'berhasil') {
?>

	<!doctype html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
		<link rel="stylesheet" href="../css/styles.css">

		<title>Read QR - Agil Yudistira</title>
	</head>

	<body class="bg-light overflow-hidden">

		<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-green">
			<div class="container">
				<a class="navbar-brand" href="#"><span><i class="fas fa-user-circle"></i> </span><?= $_SESSION['username']; ?></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="home.php">Generate QR</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="#">Read QR</a>
						</li>
					</ul>
				</div>
				<a href="../action/logout.php"><span><i class="fas fa-sign-out-alt ms-2"></i></span></a>
			</div>
		</nav>

		<section>
			<div class="container my-5">
				<div class="row align-items-center">
					<div class="col-lg-5 pt-5">
						<div class="row">
							<form action="../action/action.php" method="post" enctype="multipart/form-data">
								<div class="input-group mb-3">
									<input type="file" class="form-control" name="foto" aria-label="Upload" onchange="previewFile()" required>
									<button class="btn btn-primary" type="submit" name="scan">Scan</button>
								</div>
							</form>
						</div>
						<div class="row">
							<div class="container text-center">
								<img src="http://via.placeholder.com/400x400" class="img-thumbnail t400 shadow" alt="QRcode">
							</div>
						</div>
					</div>
					<div class="col-lg-7 pt-5">
						<?php if (isset($_COOKIE['flashDanger'])) : ?>
							<div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
								<?= $_COOKIE['flashDanger']; ?>
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>
						<?php endif; ?>
						<div class="box mb-3 shadow">
							<div class="row align-items-center">
								<?php
								if (isset($_GET['qr'])) {
									$nim = $_GET['qr'];
									$view_mhs = $conn->query("SELECT * FROM tb_mahasiswa WHERE nim='$nim'");
									while ($mhs = $view_mhs->fetch_assoc()) {
								?>
										<div class="col-md-2">
											<img src="../img/<?= $mhs['qrcode'] ?>" class="img-thumbnail" alt="QRcode">
										</div>
										<div class="col-md-10">
											<div class="table-responsive">
											</div>
											<table class="table table-striped caption-top">
												<caption>Data mahasiswa</caption>
												<tr>
													<th width="25%">NIM</th>
													<td width="10%">:</td>
													<td><?= $mhs['nim']; ?></td>
												</tr>
												<tr>
													<th>Nama</th>
													<td>:</td>
													<td><?= $mhs['nama']; ?></td>
												</tr>
												<tr>
													<th>Prodi</th>
													<td>:</td>
													<td><?= $mhs['prodi']; ?></td>
												</tr>
											</table>
										</div>
									<?php
									}
								} else {
									?>
									<div class="col-md-2">
										<img src="http://via.placeholder.com/100x100" class="img-thumbnail" alt="QRcode">
									</div>
									<div class="col-md-10">
										<div class="table-responsive">
										</div>
										<table class="table table-striped caption-top">
											<caption>Data mahasiswa</caption>
											<tr>
												<th width="25%">NIM</th>
												<td width="10%">:</td>
												<td>.....</td>
											</tr>
											<tr>
												<th>Nama</th>
												<td>:</td>
												<td>.....</td>
											</tr>
											<tr>
												<th>Prodi</th>
												<td>:</td>
												<td>.....</td>
											</tr>
										</table>
									</div>
								<?php
								}
								?>

							</div>
						</div>
					</div>
				</div>
		</section>

		<footer class="fixed-bottom bg-green">
			<div class="container">
				<div class="text-center text-white py-4">
					Agil Yudistira &copy; 2022
				</div>
			</div>
		</footer>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

		<script>
			function previewFile() {
				var preview = document.querySelector('img');
				var file = document.querySelector('input[type=file]').files[0];
				var reader = new FileReader();

				reader.onloadend = function() {
					preview.src = reader.result;
				}

				if (file) {
					reader.readAsDataURL(file);
				} else {
					preview.src = "";
				}
			}
		</script>

	</body>

	</html>

<?php
} else {
	header('location:../');
}
?>