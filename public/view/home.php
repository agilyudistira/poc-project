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

		<title>Agil Yudistira</title>
	</head>

	<body class="bg-light">

		<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-green">
			<div class="container">
				<a class="navbar-brand" href="#"><span><i class="fas fa-user-circle"></i> </span><?= $_SESSION['username']; ?></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="#">Generate QR</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="read.php">Read QR</a>
						</li>
					</ul>
				</div>
				<a href="../action/logout.php"><span><i class="fas fa-sign-out-alt ms-2"></i></span></a>
			</div>
		</nav>

		<section>
			<div class="container my-5">
				<div class="row">
					<div class="col-lg-6 pt-5">
						<form action="" method="post">
							<div class="mb-3 row">
								<label for="inputNim" class="col-sm-2 col-form-label">NIM</label>
								<div class="col-sm-1">:</div>
								<div class="col-sm-6">
									<input type="number" class="form-control" id="inputNim" name="nim" placeholder="001111222" required>
								</div>
							</div>
							<div class="mb-3 row">
								<label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
								<div class="col-sm-1">:</div>
								<div class="col-sm-6">
									<input type="text" class="form-control" id="inputNama" name="nama" placeholder="Muhammad Adam" required>
								</div>
							</div>
							<div class="mb-3 row">
								<label for="inputProdi" class="col-sm-2 col-form-label">Prodi</label>
								<div class="col-sm-1">:</div>
								<div class="col-sm-6">
									<select class="form-select" name="prodi" aria-label="Default select example">
										<option value="Teknik Elektro">Teknik Elektro</option>
										<option value="Teknik Mesin">Teknik Mesin</option>
										<option value="Teknik Kimia">Teknik Kimia</option>
										<option value="Informatika">Informatika</option>
										<option value="Sistem Informasi">Sistem Informasi</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-1"></div>
								<div class="col-sm-6">
									<button class="w-100 btn btn-primary" type="submit" name="tambah">Tambah</button>
								</div>
							</div>
						</form>
					</div>
					<?php if (isset($_COOKIE['flashWarning'])) : ?>
						<div class="alert alert-warning mt-3 alert-dismissible fade show" role="alert">
							<?= $_COOKIE['flashWarning']; ?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>
					<?php if (isset($_COOKIE['flashSuccess'])) : ?>
						<div class="alert alert-success mt-3 alert-dismissible fade show" role="alert">
							<?= $_COOKIE['flashSuccess']; ?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>
					<?php if (isset($_COOKIE['flashFailed'])) : ?>
						<div class="alert alert-danger mt-3 alert-dismissible fade show" role="alert">
							<?= $_COOKIE['flashFailed']; ?>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<section>
			<div class="container">
				<div class="box mb-3 shadow">
					<div class="col-lg-12">
						<form action="" method="post">
							<div class="table-responsive">
							</div>
							<table class="table table-striped caption-top text-center">
								<caption>Data mahasiswa</caption>
								<thead>
									<tr>
										<th>NIM</th>
										<th>Nama</th>
										<th>Prodi</th>
										<th>Pilih</th>
									</tr>
								</thead>

								<?php
								$view_mahasiswa = $conn->query("SELECT * FROM tb_mahasiswa");
								while ($data = $view_mahasiswa->fetch_assoc()) {
									echo "<tr>";
									echo "<td>" . $data['nim'] . "</td>";
									echo "<td>" . $data['nama'] . "</td>";
									echo "<td>" . $data['prodi'] . "</td>";
								?>
									<td><input class="form-check-input" type="checkbox" value="<?= $data['nim'] ?>" name="checkid[]"></td>
								<?php
									echo "</tr>";
								}
								?>
							</table>
							<div class="d-grid gap-2 d-md-flex justify-content-md-end">
								<button class="btn btn-primary" type="submit" name="cetak">Cetak QR Code</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="container py-3">
				<div class="row row-cols-1 row-cols-md-4 g-4">
					<?php
					if (isset($_POST['cetak'])) {
						if (!empty($_POST['checkid'])) {

							foreach ($_POST['checkid'] as $nim) {
								$sql = "SELECT qrcode FROM tb_mahasiswa WHERE nim='$nim'";
								$view_qrcode = $conn->query($sql);
								$get_qrcode = $view_qrcode->fetch_assoc();
					?>
								<div class="col mb-4">
									<div class="card h-100 shadow">
										<img src="../img/<?= $get_qrcode['qrcode'] ?>" class="card-img-top" alt="...">
										<div class="card-body">
											<p class="card-text text-center"><?= $get_qrcode['qrcode']; ?></p>
										</div>
									</div>
								</div>
					<?php
							}
						}
					}

					?>
				</div>
			</div>
		</section>

		<footer class="bg-green">
			<div class="container">
				<div class="text-center text-white py-4">
					Agil Yudistira &copy; 2022
				</div>
			</div>
		</footer>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	</body>

	</html>

<?php
} else {
	header('location:../');
}
?>