<?php 
    include('database.php');
    include('default.html');

    if(loggedin()) {
        header("location:todo.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Register on TaskX </title>
        <style>
            body {
                background-color: #2e2e2e;
                color: white;
            }
            input[type='text'], input[type='password'] {
                padding: 10px;
                border: 4px solid black;
                border-radius: 5px;
                outline: none;
                width: 90%;
            }
            input[type='submit'],[type='reset'] {
            padding: 5px 30px;
            margin-top: 25px; 
            background: #cce6ff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            }
            td {
                padding: 0px 0;
            }
        </style>
    </head>
    <body>
        
        <?php error(); ?>

        <br><br>
        <form action="adduser.php" method="POST">
            <center>
            <fieldset>
            <div style="border: 2px solid #D94F70; background: #ffe6ea; padding: 15px; border-radius: 10px; display: flex; align-items: center; justify-content: center; gap: 10px; max-width: 500px; max-height: 470px; margin: auto; box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.15); flex-direction: column;">
            <legend style="color: #1E3A8A; font-size: 35px; text-align: center; display: block; padding-top: 15px; margin-bottom: 0px;"> 
    	    NEW USER
	        </legend>
                <table>
                    <tr>
                        <td> <pre style="color: #D94F70;">USERNAME </pre> </td>
                        <td> <input type="text" name="username" placeholder="Select a username" autocomplete="off" required style="border-radius: 6px; padding: 10px 15px; background: rgb(255, 255, 255); border: 1px solid #D94F70; flex: 1; max-width: 300px;"> </td>
                    </tr>
                    <tr>
                        <td> <pre style="color: #D94F70;">PASSWORD </pre> </td>
                        <td> <input type="password" required name="password1" placeholder="*******" style="border-radius: 6px; padding: 10px 15px; background: rgb(255, 255, 255); border: 1px solid #D94F70; flex: 1; max-width: 300px;"> </td>
                    </tr>
                    <tr>
                        <td> <pre style="color: #D94F70;">CONFIRM PASS </pre></td>
                        <td> <input type="password" required name="password2" placeholder="*******" style="border-radius: 6px; padding: 10px 15px; background: rgb(255, 255, 255); border: 1px solid #D94F70; flex: 1; max-width: 300px;"> </td>
                    </tr>
                    <tr>
                        <td>
                            <?php                            
                                $capcode = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";
                                $capcode = substr(str_shuffle($capcode), 0, 6);
                                $_SESSION['captcha'] = $capcode;
                                echo '<div class = "unselectable">'.$capcode.'</div>';
                            ?>
                        </td>
                        <td style="padding-top: 15px;">
                            <input type="text" name="captcha" placeholder=" Enter captcha"  autocomplete="off" required style="border-radius: 6px; padding: 10px 15px; background: rgb(255, 255, 255); border: 1px solid #D94F70; flex: 1; max-width: 300px;">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <input type="reset" value="Reset" style="color: #D94F70; margin-right: 40px; border: 1px solid #1E3A8A;"> 
                            <input type="submit" value="Submit" style="color: #D94F70; border: 1px solid #1E3A8A;"> 
                        </td>
                    </tr>
                </table>
        </div>
            </fieldset>
            <p style="white-space:pre; color: #1E3A8A;">  Already have an account?  <a href="login.php" title="Login" style="color: #D94F70; text-decoration: underline">Login to it</a>. </p>
            </center>
        </form>
    </body>
</html>
