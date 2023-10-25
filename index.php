<?php

	include 'connect.php';

	session_start();

	if (isset($_SESSION['user'])) {

		header('Location: welcome.php');

	}

	$errors = [];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$email = $_POST['email'];
		$password = $_POST['password'];
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		if (empty($email)) {

			$errors[] = "Email is required!";

		}
		
		if (empty($password)) {

			$errors[] = "Password is required!";

		}

		if (empty($errors)) {

			$query = "SELECT * FROM users WHERE email = :email AND password = :password";
			$stmt = $pdo->prepare($query);
			$stmt->bindValue(":email", $email);
			$stmt->bindValue(":password", $hashed_password);
			$stmt->execute();
			$credentials = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();

			if ($count > 0) {

				$_SESSION['user']['id'] = $credentials['id'];
				$_SESSION['user']['name'] = $credentials['name'];
				$_SESSION['user']['email'] = $credentials['email'];

				header('Location: welcome.php');
			}
		}

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body class="bg-dark">
	<div class="container bg-warning w-50 p-4 my-5 rounded">
		<h1 class="text-center mb-4">Log in</h1>
		<?php if (!empty($errors)) : ?>
            <h1 class="text-center mb-4">Log in</h1>
            <div class="alert alert-danger text-black">
                <?php foreach ($errors as $error) : ?>
                    <?php echo $error."<br>" ; ?>
                <?php endforeach; ?>
            </div>
        <?php endif;?>
		<form method="post">
			<div class="mb-3">
				<label for="email" class="form-label text-dark">Email address</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="example@email.com">
			</div>
			<div class="mb-3">
				<label for="password" class="form-label text-dark">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="password">
			</div>
			<button type="submit" class="btn btn-dark mb-3">Log in</button>
			<p>Don't have an account? <a href="register.php">Register here</a>.</p>
		</form>
	</div>
</body>
</html>