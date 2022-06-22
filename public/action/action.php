<?php

declare(strict_types=1);

session_start();
include 'connection.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Libern\QRCodeReader\QRCodeReader;

require_once('./../../vendor/autoload.php');

$options = new QROptions(
	[
		'eccLevel' => QRCode::ECC_L,
		'outputType' => QRCode::OUTPUT_IMAGE_PNG,
		'version' => 5,
	]
);


if (isset($_POST['signin'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM tb_pengguna WHERE username='$username' AND password=md5('$password')";
	$get_pengguna = $conn->query($sql);

	if ($get_pengguna->num_rows > 0) {
		session_start();
		$_SESSION['signin'] = 'berhasil';
		$_SESSION['username'] = $username;
		header('location:../view/home.php');
	} else {
		$message = "Username atau password salah.";
		setcookie('flashDanger', $message, time() + (5), "/");
		header('location:../');
	}
}

if (isset($_POST['tambah'])) {

	$nim = $_POST['nim'];
	$nama = $_POST['nama'];
	$prodi = $_POST['prodi'];

	$sql = "SELECT nim FROM tb_mahasiswa WHERE nim='$nim'";
	$get_nim = $conn->query($sql);

	if ($get_nim->num_rows > 0) {
		$message = "NIM telah terdaftar.";
		setcookie('flashWarning', $message, time() + (5), "/");
		header('location:../view/home.php');
	} else {
		$qrcode = (new QRCode($options))->render($nim);
		file_put_contents('../img/' . $nim . '.png', file_get_contents($qrcode));

		$sql = 'INSERT INTO tb_mahasiswa VALUES (' . $nim . ', "' . $nama . '", "' . $prodi . '", "' . $nim . '.png")';

		if ($conn->query($sql) === TRUE) {
			$message = "Data berhasil ditambahkan.";
			setcookie('flashSuccess', $message, time() + (5), "/");
			header('location:../view/home.php');
		} else {
			$message = "Data gagal ditambahkan.";
			setcookie('flashFailed', $message, time() + (5), "/");
			header('location:../view/home.php');
		}
	}
}

if (isset($_POST['scan'])) {
	$qr = $_FILES['foto']['tmp_name'];

	$QRCodeReader = new QRCodeReader();
	$qrText = $QRCodeReader->decode($qr);

	$sql = "SELECT nim FROM tb_mahasiswa WHERE nim='$qrText'";
	$get_nim = $conn->query($sql);

	if ($get_nim->num_rows > 0) {
		header('location:../view/read.php?qr=' . $qrText);
	} else {
		$message = "Tidak ada data mahasiswa dari kode QR tersebut.";
		setcookie('flashDanger', $message, time() + (5), "/");
		header('location:../view/read.php');
	}
}
