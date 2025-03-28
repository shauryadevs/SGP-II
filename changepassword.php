<?php 
    include('default.html');
    include('database.php');

    if(!loggedin()) {
    	header("location:login.php");
    }

	$username = $_SESSION['username'];
	echo "<br> <center id='welcome'> Welcome, </center>";
	echo "<center id='user'>".ucwords($username)."</center>";

    error();
	if(isset($_POST['change']))
	{
		$old = $_POST['oldpass'];
		$new = $_POST['newpass'];

		$conn = connectdatabase();
	    $sql = "SELECT password FROM users WHERE username = '".$username."'"; 
	    $result = mysqli_query($conn,$sql);

    	$row = mysqli_fetch_assoc($result);
	    $actual = $row['password'];
	   
	   	if(strcmp($old,$actual)==0) {
	   		updatepassword($username, $new);
	   	}
	   	else {
            $_SESSION['error'] = "<br> &nbsp; <span class='error-message'>Invalid old password. </span>";
	        header("Refresh:0");
	   	}
	    mysqli_close($conn);
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Change TaskX Password </title>
</head>
<body>
	<center>
	<fieldset>
		<br>
	<div style="border: 2px solid #D94F70; background: #ffe6ea; padding: 15px; border-radius: 10px; display: flex; align-items: center; justify-content: center; gap: 10px; max-width: 700px; max-height: 280px; margin: auto; box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.15);">
	    <form method="POST">
		<legend style="color: #1E3A8A; font-size: 35px; text-align: center; display: block; padding-top: 40px; margin-bottom: 30px;"> 
    	Change Password 
	</legend>
	        <table>
	            <tbody>
	                <tr>
	                     <td> <pre>Old Password </pre> </td>
	                     <td> <input size="17" type="password" name="oldpass" placeholder=" ******"  autocomplete="off" required style="border-radius: 6px; border: 1px solid #D94F70;"></td>
	                </tr>
	                <tr>
	                     <td> <pre>New Password </pre> </td>
	                     <td> <input size="17" type="password" name="newpass" placeholder=" ******" required style="border-radius: 6px; border: 1px solid #D94F70;"></td>
	                </tr>
	                <tr>
	                    <td> <input type="reset" value="Reset" style='color: #D94F70; margin-left: 125px; margin-top: 25px; cursor: pointer; border: 1px solid #1E3A8A;;'> </td>
	                    <td> <input type="submit" name="change" value="Change" style='color: #D94F70; margin-left: 50px; margin-top: 25px; cursor: pointer; border: 1px solid #1E3A8A;;'> </td>
	                </tr>
	            </tbody>
	        </table>
	</div>
	    </form>
	</fieldset>
	</center>
</body>
</html>


<?php 
	echo '<br><br><br><br><br><br><br>';
    echo '<br> <a href="todo.php" align="right" style="color: #D94F70; text-decoration: none">&nbsp; Back to TaskX Dashboard </a>';
?>