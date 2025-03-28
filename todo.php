<?php 
    include('database.php');
    include('default.html');

    if(!loggedin()){
        header("location:login.php");
        exit(); // Always exit after header redirect
    }

    $username = $_SESSION['username'];

    // Handle task submission BEFORE any output
    if(isset($_POST['addtask']))
    {
        if(!empty($_POST['description']))
        {
            addTodoItem($username, $_POST['description']);
            header("Location: todo.php"); // Redirect properly
            exit(); // Prevent further execution
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>TaskX Dashboard</title>
</head>
<body>
    <br>
    <center id="welcome">Welcome,</center>
    <center id="user"><?php echo ucwords($username); ?></center>

    <form action="todo.php" method="POST">
        <?php spaces(65); ?>
		<div style="border: 2px solid #D94F70; background: #ffe6ea; padding: 15px; border-radius: 10px; display: flex; align-items: center; justify-content: center; gap: 10px; max-width: 900px; margin: auto; box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.15);">
    		<input type="text" size="35" placeholder="Enter your task..." name="description" autocomplete="off" 
           		style="border-radius: 6px; padding: 10px 15px; background: rgb(255, 255, 255); border: 1px solid #D94F70; flex: 1; min-width: 200px;"/>    

    		<input type="submit" name="addtask" value="Add Task" 
           		style="border-radius: 6px; padding: 10px 15px; background: #cce6ff; border: 1px solid #1E3A8A; color: #D94F70; margin-bottom: 8px; cursor: pointer;"/>
		</div>
	</form>

    <?php getTodoItems($username); ?>

    <br><br><br>
    <br> <a href="logout.php" align="right" title="Logout" style="color: #D94F70; text-decoration: none">&nbsp; Logout </a>
	<a align="right" title="|" style="color: #1E3A8A; text-decoration: none">&nbsp; | </a>
    <a href="changepassword.php" align="right" title="change password" style="color: #D94F70; text-decoration: none">&nbsp; Change Password </a>
	<a align="right" title="|" style="color: #1E3A8A; text-decoration: none">&nbsp; | </a>
    <a href="deleteaccount.php" align="right" title="delete account" style="color: #D94F70; text-decoration: none">&nbsp; Delete Account </a> <br>

    <?php error(); ?>
</body>
</html>
