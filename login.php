<?php


session_start();
require 'header.php';
require 'config.php';
$errors = array();
$message = '';

if (isset($_POST['submit'])) {
    $email = isset($_POST['email'])?$_POST['email']:'';
    $password = isset($_POST['password'])?$_POST['password']:'';
    $role = isset($_POST['role'])?$_POST['role']:'';


    if (sizeof($errors)==0) {
        $sql = "SELECT * FROM users WHERE 
        `email`='".$email."' AND `password`='".$password."' AND `role`='".$role."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
              // output data of each row
            while ($row = $result->fetch_assoc()) {
                $_SESSION['userdata'] = array('username'=>$row['username'], 'password'=>$row['password'], 'role'=>$row['role'], 'email'=>$row['email'], 'user_id'=>$row['user_id']);
                if ($role=='Admin') {
                    header('Location: welcome.php');
                    exit();
                }
                header('Location: members.php');
            }
        } else {
             $errors[] = array('input'=>'form','msg'=>'Invalid login details'); 
        }

        $conn->close();
    }



    
}
?>


<body>
    <div id="message">
        <?php echo $message; ?>
    </div>
    <div id="errors">
        <?php if (sizeof($errors)>0) : ?>
            <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error['msg']; ?></li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?> 
    </div>
    <h1>Login Page</h1>
    <form id="signupForm" action="login.php" method="POST">
        <label for="email">Email <input type="text" name="email" required></label>
        <label for="password">Password <input type="password" name="password" required>
        </label>

        <label for="role">User Role <select name="role">
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select> 
        </label>

        <p><input type="submit" name="submit" value="Submit"></p>
    </form>
    <p><a href="signup.php" name="signup">Register Here</a></p>
</body>
</html>
