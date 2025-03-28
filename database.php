<?php
    session_start();

    if(isset($_POST['Delete']))
    {
        if(!empty($_POST['check_list']))
        {
            $tasks = $_POST['check_list'];
            $length = count($tasks);
            for ($i = 0; $i < $length; $i++) {
                deleteTodoItem($_SESSION['username'], $tasks[$i]);
            }
        }
    }
    else if(isset($_POST['Save']))
    {
        $conn = connectdatabase();
        $sql = "UPDATE todo_application.tasks SET done = 0";
        $result = mysqli_query($conn, $sql); 
        mysqli_close($conn);

        if(!empty($_POST['check_list']))
        {
            $tasks = $_POST['check_list'];
            $length = count($tasks);
            if($length > 0) {
                for ($i = 0; $i < $length; $i++) {
                    updateDone($tasks[$i]);
                }
            }
        }
    }

    function connectdatabase() {
        return mysqli_connect("localhost", "root", "12345", "todo_application");
    }

    function loggedin() {
        return isset($_SESSION['username']);
    }

    function logout() {
        $_SESSION['error'] = "<br> &nbsp; <span class='error-message'>Successfully logged out. </span>";
        unset($_SESSION['username']);
    }

    function spaces($n) {
        for($i=0; $i<$n; $i++)
            echo "&nbsp;";
    }

    function userexist($username) 
    {
        $conn = connectdatabase();
        $sql = "SELECT * FROM todo_application.users WHERE username = '".$username."'"; 
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        return ($result && mysqli_num_rows($result) > 0);
    }

    function validuser($username, $password) 
    {
        $conn = connectdatabase();
        $sql = "SELECT * FROM todo_application.users WHERE username = '".$username."'AND password = '".$password."'"; 
        $result = mysqli_query($conn,$sql);
        mysqli_close($conn);

        return ($result && mysqli_num_rows($result) > 0);
    }

    function error() 
    {
        if(isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
    }

    function updatepassword($username, $password) {
        $conn = connectdatabase();
        $sql = "UPDATE todo_application.users SET password = '".$password."' WHERE username = '".$username."';";
        mysqli_query($conn, $sql);
        mysqli_close($conn);

        $_SESSION['error'] = "<br> &nbsp; <span class='error-message'>Password updated. Continue to login.</span>";
        header('location:todo.php');
        exit;
    }

    function deleteaccount($username) {
        $conn = connectdatabase();
        mysqli_query($conn, "DELETE FROM todo_application.tasks WHERE username = '".$username."';");
        mysqli_query($conn, "DELETE FROM todo_application.users WHERE username = '".$username."';");
        mysqli_close($conn);

        $_SESSION['error'] = "<br> &nbsp; <span class='error-message'>Account deleted. </span>";
        unset($_SESSION['username']);
        header('location:login.php');
        exit;
    }

    function createUser($username, $password)
    {
        if(!userexist($username))
        {
            $conn = connectdatabase();
            $sql = "INSERT INTO todo_application.users (username, password) VALUES ('".$username."','".$password."')";
            mysqli_query($conn, $sql);
            mysqli_close($conn);

            $_SESSION["username"] = $username;
            header('location:todo.php');
            exit;
        }
        else
        {
            $_SESSION['error'] = "<br> &nbsp; <span class='error-message'>User already exists. Please login instead. </span>";
            header('location:newuser.php');
            exit;
        }
    }
    
    function isValid($username, $password, $usercaptcha)
    {
        if (!isset($_SESSION['captcha']) || strcmp($usercaptcha, $_SESSION['captcha']) !== 0) {
            $_SESSION['error'] = "<br> &nbsp; <span class='error-message'>Invalid captcha code. </span>";
            header('location:login.php');
            exit;
        }

        if(validuser($username, $password))
        {
            $_SESSION["username"] = $username;
            header('location:todo.php');
        }
        else
        {
            $_SESSION['error'] = "<br> &nbsp; <span class='error-message'>Incorrect Username or Password. Try again. </span>";
            header('location:login.php');
        }
        exit;
    }
    
    function getTodoItems($username) {

        $conn = connectdatabase();
        $sql = "SELECT * FROM tasks WHERE username = '".$username."'";
        $result = mysqli_query($conn, $sql);

        echo "<form method='POST'>";
        echo "<pre>";
        if ($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                spaces(34);
                echo "<input type='checkbox' class='largerCheckbox' name='check_list[]' value='".$row["taskid"] ."' ".($row['done'] ? "checked" : "").">";
                echo "<td> " . $row["task"] . "</td>";
                echo "<br>";
            }
        }
        echo "</pre> <br>";
        spaces(35);
        echo "<input type='submit' name='Delete' value='Delete' style='margin-right: 0px; margin-left: 545px; color: #D94F70; cursor: pointer; border: 1px solid #1E3A8A;'/> ";
        spaces(10);
        echo "<input type='submit' name='Save' value='Save' style='color: #D94F70; cursor: pointer; border: 1px solid #1E3A8A;'/>";
        echo "</form>";
        echo "<br><br>";
        mysqli_close($conn);
    }

    function addTodoItem($username, $todo_text) 
    {
        $conn = connectdatabase();
        $sql = "INSERT INTO todo_application.tasks(username, task, done) VALUES ('".$username."','".$todo_text."',0);";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }
    
    function deleteTodoItem($username, $todo_id) 
    {
        $conn = connectdatabase();
        $sql = "DELETE FROM todo_application.tasks WHERE taskid = ".$todo_id." and username = '".$username."';";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }

    function updateDone($todo_id) 
    {
        $conn = connectdatabase();
        $sql = "UPDATE todo_application.tasks SET done = '1' WHERE (taskid = '".$todo_id."');";
        mysqli_query($conn, $sql);   
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <style type="text/css" media="screen">
        input.largerCheckbox { 
            width: 20px; 
            height: 20px; 
            cursor: pointer;
        } 
    </style>
</head>
</html>
