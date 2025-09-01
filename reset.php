<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'includes/session.php';

if (isset($_POST['reset'])) {
	$email = $_POST['email'];

	$sql = "SELECT *, COUNT(*) AS numrows FROM users WHERE email='$email'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	if ($row['numrows'] > 0) {
		//generate code
		$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$code = substr(str_shuffle($set), 0, 15);
		$update_sql = "UPDATE users SET reset_code='$code' WHERE id=" . $row['id'];

		if ($conn->query($update_sql) === TRUE) {
			$message = "
					<h2>Password Reset</h2>
					<p>Your Account:</p>
					<p>Email: " . $email . "</p>
					<p>Please click the link below to reset your password.</p>
					<a href='http://localhost/pawprint_final/password_reset.php?code=" . $code . "&user=" . $row['id'] . "'>Reset Password</a>
				";

			//Load phpmailer
			require 'vendor/autoload.php';

			$mail = new PHPMailer(true);
			try {
				//Server settings
				$mail->isSMTP();
				$mail->Host = 'smtp.gmail.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'phernan667@gmail.com';
				$mail->Password = 'rfhx segu iuth eybb';
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
				$mail->SMTPSecure = 'ssl';
				$mail->Port = 465;

				$mail->setFrom('phernan667@gmail.com');

				//Recipients
				$mail->addAddress($email);
				$mail->addReplyTo('phernan667@gmail.com');

				//Content
				$mail->isHTML(true);
				$mail->Subject = 'ECommerce Site Password Reset';
				$mail->Body = $message;

				$mail->send();

				$_SESSION['success'] = 'Password reset link sent';

			} catch (Exception $e) {
				$_SESSION['error'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
			}
		} else {
			$_SESSION['error'] = 'Something went wrong. Please try again.';
		}
	} else {
		$_SESSION['error'] = 'Email not found';
	}

	$conn->close();

} else {
	$_SESSION['error'] = 'Input email associated with account';
}

header('location: password_forgot.php');
?>