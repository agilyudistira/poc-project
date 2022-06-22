<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="css/styles.css">

	<title>Agil Yudistira</title>
</head>

<body class="signin">

	<main class="form-signin shadow">
		<form action="action/action.php" method="POST">
			<h1 class="mb-5 fw-bold">MASUK</h1>

			<div class="form-floating">
				<input type="text" class="form-control mb-3" id="floatingInput" name="username" placeholder="Nama pengguna" required>
				<label for="floatingInput">Nama pengguna</label>
			</div>
			<div class="form-floating">
				<input type="password" class="form-control mb-3" id="floatingPassword" name="password" placeholder="Kata sandi" required>
				<label for="floatingPassword">Kata sandi</label>
			</div>
			<button class="w-100 btn btn-lg btn-primary" type="submit" name="signin">Masuk</button>
			<?php if (isset($_COOKIE['flashDanger'])) : ?>
				<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
					<?= $_COOKIE['flashDanger']; ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>
			<p class="mt-5 mb-3 text-muted">Agil Yudistira &copy; 2022</p>
		</form>
	</main>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>