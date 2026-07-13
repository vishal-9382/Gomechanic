<?php
include('database.php');
$msg = null;
if (isset($_POST['login'])) {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		if (!empty($_POST['username']) && !empty($_POST['password'])) {

			$username = $_POST['username'];
			$password = $_POST['password'];
			$usertype = $_POST['usertype'];

			if ($usertype == 'Admin') {
				$query = "SELECT * FROM admin WHERE admin_username = '$username' AND admin_password = '$password'";
				$results = mysqli_query($connection, $query);
				if ($results && mysqli_num_rows($results) > 0) {
					$row = mysqli_fetch_object($results);
					session_start();
					$_SESSION["user_id"] = $row->admin_id;
					$_SESSION["user_name"] = $row->admin_name;
					header('Location: admin/adminhome.php');
					exit();
				} else {
					$msg = "Incorrect Username Or Password";
				}
			} elseif ($usertype == 'machanic') {
				$query = "SELECT * FROM professional WHERE mechanic_email = '$username' AND password = '$password'";
				$results = mysqli_query($connection, $query);
				if ($results && mysqli_num_rows($results) > 0) {
					$row = mysqli_fetch_object($results);
					session_start();
					$_SESSION["proff_id"] = $row->mechanic_id;
					$_SESSION["proff_name"] = $row->mechanic_Fullname;
					$_SESSION["professionid"] = $row->profession;
					header('Location: machanic/professionalhome.php');
					exit();
				} else {
					$msg = "Incorrect Username Or Password";
				}
			} elseif ($usertype == 'User') {
				$query = "SELECT * FROM user WHERE user_email = '$username' AND user_password = '$password'";
				$results = mysqli_query($connection, $query);
				if ($results && mysqli_num_rows($results) > 0) {
					$row = mysqli_fetch_object($results);
					session_start();
					$_SESSION["user_id"] = $row->user_id;
					$_SESSION["user_name"] = $row->user_Fullname;
					header('Location: user/userhome.php');
					exit();
				} else {
					$msg = "Incorrect Username Or Password";
				}
			}
		} else {
			$msg = "Fill all input fields";
		}
	} else {
		$msg = "Please log in properly.";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GoMechanic - Login</title>
	<!-- Bootstrap 5.3.3 CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<!-- Font Awesome 6.4.0 CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<!-- SweetAlert 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- Core Style System -->
	<link rel="stylesheet" href="style.css">
</head>
<body style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at 10% 20%, rgba(37, 99, 235, 0.08) 0%, rgba(6, 182, 212, 0.04) 90%); padding: 20px;">

	<div class="card p-4" style="max-width: 420px; width: 100%; border-radius: 20px !important;">
		<div class="text-center mb-4">
			<a href="index.php">
				<img src="images/logo.png" alt="GoMechanic" style="max-height: 45px; border-radius: 6px;">
			</a>
			<h4 class="mt-3 fw-bold">Welcome Back</h4>
			<p class="text-secondary small">Please enter your credentials to login</p>
		</div>

		<form method="post" action="">
			<div class="mb-3">
				<label for="username">Email or Username</label>
				<div class="input-group">
					<span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-envelope text-secondary"></i></span>
					<input type="text" name="username" id="username" class="form-control border-start-0" placeholder="name@example.com" required style="border-radius: 0 10px 10px 0 !important;">
				</div>
			</div>

			<div class="mb-3">
				<label for="password">Password</label>
				<div class="input-group password-wrapper">
					<span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-lock text-secondary"></i></span>
					<input type="password" name="password" id="password" class="form-control border-start-0" placeholder="••••••••" required style="border-radius: 0 10px 10px 0 !important; padding-right: 45px !important;">
				</div>
			</div>

			<div class="mb-4">
				<label for="usertype">Role / User Type</label>
				<div class="input-group">
					<span class="input-group-text bg-transparent border-end-0" style="border-color: var(--border-color); border-radius: 10px 0 0 10px;"><i class="fas fa-user-tag text-secondary"></i></span>
					<select name="usertype" id="usertype" class="form-control border-start-0" required style="border-radius: 0 10px 10px 0 !important;">
						<option selected disabled value="">Select Type</option>
						<option value="Admin">🛡️ Admin</option>
						<option value="machanic">🔧 Mechanic</option>
						<option value="User">👤 User</option>
					</select>
				</div>
			</div>

			<button type="submit" value="Login" name="login" class="btn btn-custom w-100 py-3 fw-bold mb-3">
				<i class="fas fa-sign-in-alt me-2"></i> Log In
			</button>

			<div class="text-center">
				<a href="userregistration.php" class="small text-secondary">Don't have an account? Sign Up</a>
			</div>
		</form>
	</div>

	<!-- SweetAlert error triggers -->
	<?php if (isset($msg)): ?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				Swal.fire({
					icon: 'error',
					title: 'Login Error',
					text: '<?php echo addslashes($msg); ?>',
					confirmButtonColor: '#2563EB'
				});
			});
		</script>
	<?php endif; ?>

	<!-- Bootstrap Bundle JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Theme and Toggle behaviors -->
	<script src="js/modern.js"></script>
</body>
</html>

