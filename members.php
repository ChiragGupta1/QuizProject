<?php


session_start();
if (!isset($_SESSION['userdata']['username'])) {
    header('location:login.php');
}
require 'header.php';
require 'config.php';
$errors = array();
$message = '';

echo '<h1>Welcome ' . $_SESSION['userdata']['username'] . '</h1>';
$id = $_SESSION['userdata']['user_id'];


if (isset($_POST['submit'])) {
    $selected = isset($_POST['selected']) ? $_POST['selected'] : '';


    if (sizeof($errors) == 0) {
        $sql = "SELECT * FROM tests WHERE `test_id`='" . $selected . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $_SESSION['testdata'] = array('testname' => $row['testname'], 'test_id' => $row['test_id'], 'page_stat' => $row['page_stat']);
                header('Location: test.php');
            }
        } else {
            //$errors[] = array('input'=>'form','msg'=>'Invalid login details'); 
        }

        $conn->close();
    }
}
?>



<body>
    <h1>Select Test</h1>



    <form action="members.php" method="POST">
        <?php
        $sql = "SELECT * FROM tests";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
        ?>
                <input type="radio" name="selected" value="<?php echo $row['test_id'] ?>">
                <label for="selected">Test <?php echo $row['test_id'] ?> - <?php echo $row['testname'] ?> </label><br><br>

        <?php

            }
        } else {
            echo "0 results";
        }

        $conn->close();


        ?>
        <p><input type="submit" name="submit" value="Start Test"></p>
    </form>


    <p><a href="signup.php" name="signup">Logout</p>

</body>

</html>