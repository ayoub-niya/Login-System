<?php
require_once('connect.php');

session_start();

if (isset($_SESSION['user'])) {
    header('Location: welcome.php');
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $date = date('Y-m-d H:i:s');

    if (empty($name)) {
        $errors[] = "Name is required!";
    }

    if (empty($email)) {
        $errors[] = "Email is required!";
    }

    if (empty($password)) {
        $errors[] = "Password is required!";
    }

    if (!empty($password) && strlen($password) < 8) {
        $errors[] = "Password must be alteast 8 characters long.";
    }

    if (empty($errors)) {
        $query = "SELECT name, email FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count > 0) {
            echo "<p class=alert alert-danger>Another account with the same email already exists</p>";
            header('Location: '. $_SERVER['REQUEST_URI']);
        }
        $query = "INSERT INTO users(name, email, password, created_at) VALUES(:name, :email, :password, :date)";
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $password);
        $stmt->bindValue(":date", $date);
        $stmt->execute();

        header('Location: index.php');
        exit();
    }

}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create New Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body class="bg-dark">
    <div class="container bg-warning w-50 p-4 my-5 rounded">
        <h1 class="text-center mb-4">Create New Account</h1>
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger text-black">
                <?php foreach ($errors as $error) : ?>
                    <?php echo $error."<br>" ; ?>
                <?php endforeach; ?>
            </div>
        <?php endif;?>
		<form method="post">
			<div class="mb-3">
				<label for="name" class="form-label text-dark">Name</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Jhon Doe">
			</div>
			<div class="mb-3">
				<label for="eamil" class="form-label text-dark">Email address</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="jhondoe@email.com">
			</div>
			<div class="mb-3">
				<label for="password" class="form-label text-dark">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="password">
			</div>
			<button type="submit" class="btn btn-dark mb-3">Create Account</button>
			<p>Already have an account? <a href="index.php">Log in</a>.</p>
		</form>
	</div>
</body>
</html>