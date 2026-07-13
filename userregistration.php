<?php
include('database.php');
$msg = null;
if (isset($_POST['register'])) {
	if (!empty($_POST['name']) && !empty($_POST['cnic']) && !empty($_POST['mobile']) && !empty($_POST['city']) && !empty($_POST['password']) && !empty($_POST['confirmpassword'])) {
		$name = $_POST['name'];
		$cnic = $_POST['cnic'];
		$adress = $_POST['address'];
		$contact = $_POST['mobile'];
		$city = $_POST['city'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirmpassword'];

		if ($password === $confirm_password) {
			$query = "INSERT INTO user (user_Fullname,user_cnic,user_address,user_city,user_contact,user_email,user_password)
		VALUES ('$name','$cnic','$adress ','$city','$contact','$email','$password')";
			$results = mysqli_query($connection, $query);
			if ($results) {
				$msg = "User Registration Successful";
			} else {
				$msg = "Registration failed. Try again.";
			}
		} else {
			$msg = "Passwords do not match!";
		}

	} else {
		$msg = "Fill all input fields";
	}
}
?>
<?php include('navbar.php'); ?>

<?php include('regForm.php'); ?>

<?php if (isset($msg)): ?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			Swal.fire({
				icon: '<?php echo (strpos($msg, "Successful") !== false) ? "success" : "error"; ?>',
				title: 'Registration Info',
				text: '<?php echo addslashes($msg); ?>',
				confirmButtonColor: '#2563EB'
			}).then((result) => {
				<?php if (strpos($msg, "Successful") !== false): ?>
					window.location.href = 'login.php';
				<?php endif; ?>
			});
		});
	</script>
<?php endif; ?>

<?php include('footer.php'); ?>