<?php



session_start();
if (!isset($_SESSION['userdata']['username'])) {
    header('location:login.php');
}

require 'header.php';
require 'config.php';
$errors = array();
$message = '';

echo '<h1>Welcome </h1>' . $_SESSION['userdata']['username'];
$id = $_SESSION['userdata']['user_id'];




if (isset($_POST['submit'])) {
    $testname = isset($_POST['testname']) ? $_POST['testname'] : '';
    $page_stat = isset($_POST['page_stat']) ? $_POST['page_stat'] : '';


    $sql = "INSERT INTO tests (`testname`, `page_stat`) VALUES ('" . $testname . "', '" . $page_stat . "')";

    if ($conn->query($sql) === true) {


        header('Location: addquestions.php');
        //echo "New record created successfully.";
        //echo "New record created successfully";
    } else {
        //$errors[] = array('input'=>'form','msg'=>$conn->error);
        //echo "Error: " . $sql . "<br>" . $conn->error;
    }



    $conn->close();
}



?>

<body>

    <h1>Create Test</h1>
    <form id="signupForm" action="welcome.php" method="POST">
        <label for="testname">Test name <input type="text" name="testname"></label>
        <label for="page">Page buttons <select name="page_stat">

                <option value="0">Disable</option>
                <option value="1">Enable</option>

            </select>
        </label>
        <p><input type="submit" name="submit" value="Submit"></p>

    </form>
    <p><a href="signup.php" name="signup">Logout</p>
</body>

</html>