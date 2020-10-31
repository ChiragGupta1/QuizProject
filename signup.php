<?php

/**
 * Register user in database
 *
 * PHP version 7.2.33.0
 *
 * @category PHP
 * @package  PHP_CodeSniffer
 * @author   CHIRAG <chirag26oct@gmail.com>
 * @license  https://github.com/License.txt License
 * @link     http://localhost/html/
 */
session_start();

session_destroy();


require 'header.php';
require 'config.php';
$errors = array();
$message = '';

if (isset($_POST['submit'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $repassword = isset($_POST['repassword']) ? $_POST['repassword'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';

    if ($password != $repassword) {
        $errors[] = array('input' => 'password', 'msg' => 'password does not match');
    }

    $sql = "SELECT * FROM users WHERE 
        `email`='" . $email . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $errors[] = array('input' => 'username', 'msg' => 'User already exists.');
        }
    }

    if (sizeof($errors) == 0) {
        $sql = "INSERT INTO users (`username`, `password`, `email`, `role`) 
        VALUES ('" . $username . "', '" . $password . "', '" . $email . "', '" . $role . "')";

        if ($conn->query($sql) === true) {
            $last_id = $conn->insert_id;
            echo "Registered successfully. Account ID: " . $last_id;
            //echo "New record created successfully";
        } else {
            $errors[] = array('input' => 'form', 'msg' => $conn->error);
            //echo "Error: " . $sql . "<br>" . $conn->error;
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
        <?php if (sizeof($errors) > 0) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error['msg']; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <h1>Register Page</h1>
    <form id="signupForm" action="signup.php" method="POST">
        <label for="username">Username <input type="text" name="username" required></label>
        <label for="password">Password <input type="password" name="password" required>
        </label>
        <label for="repassword">Re-password <input type="password" name="repassword" required>
        </label>
        <label for="role">User Role <select name="role">
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select> </label>


        <label for="email">Email <input type="text" name="email" required></label>
        <p><input type="submit" name="submit" value="Submit"></p>

    </form>
    <p><a href="login.php" name="login">Login Here</a></p>
</body>

</html>