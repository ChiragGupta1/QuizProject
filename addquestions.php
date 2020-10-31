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

    $test_id = isset($_POST['test_id']) ? $_POST['test_id'] : '';
    $q_desc = isset($_POST['q_desc']) ? $_POST['q_desc'] : '';
    $opt_1 = isset($_POST['opt_1']) ? $_POST['opt_1'] : '';
    $opt_2 = isset($_POST['opt_2']) ? $_POST['opt_2'] : '';
    $opt_3 = isset($_POST['opt_3']) ? $_POST['opt_3'] : '';
    $opt_4 = isset($_POST['opt_4']) ? $_POST['opt_4'] : '';
    $correct_ans = isset($_POST['correct_ans']) ? $_POST['correct_ans'] : '';


    if (sizeof($errors) == 0) {
        $sql = "INSERT INTO questions (`test_id`, `q_desc`, `opt_1`, `opt_2`, `opt_3`, `opt_4`, `correct_ans`) 
        VALUES ('" . $test_id . "', '" . $q_desc . "', '" . $opt_1 . "', '" . $opt_2 . "', '" . $opt_3 . "', '" . $opt_4 . "', '" . $correct_ans . "')";

        if ($conn->query($sql) === true) {
            $last_id = $conn->insert_id;
            //echo "Registered successfully. Account ID: " . $last_id;
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
    <h1>Add Questions</h1>
    <form id="signupForm" action="addquestions.php" method="POST">

        <label for="testname">Test Name <select name="test_id">
                <?php
                $sql = "SELECT * FROM tests";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <option value="<?php echo $row['test_id'] ?>"><?php echo $row['testname'] ?></option>
                <?php
                    }
                } else {
                    // echo "0 results";
                }
                ?>
            </select>
        </label>

        <label for="q_desc">
            <h3>Question </h3><input type="text" name="q_desc" id="question" required>
        </label>
        <label for="opt_1">Option 1 <input type="text" name="opt_1" required>
        </label>
        <label for="opt_2">Option 2 <input type="text" name="opt_2" required>
        </label>
        <label for="opt_3">Option 3 <input type="text" name="opt_3" required>
        </label>
        <label for="opt_4">Option 4 <input type="text" name="opt_4" required>
        </label>
        <label for="correct_ans">Correct Answer <input type="text" name="correct_ans" required>
        </label><br><br>






        <p><input type="submit" name="submit" value="Submit"></p>




    </form>
    <p><a href="signup.php" name="signup">Logout</p>
</body>

</html>