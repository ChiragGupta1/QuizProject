<?php


session_start();
if (!isset($_SESSION['userdata']['username'])) {
    header('location:login.php');
}
require 'header.php';
require 'config.php';
$errors = array();
$message = '';

echo '<h1 class="text-center">Welcome ' . $_SESSION['userdata']['username'] . '</h1>';


if (isset($_POST['submitTest'])) {

    if (!empty($_POST['answer'])) {
        $count = count($_POST['answer']);
        echo '<br><p class="text-center"> You answered' . $count . ' questions out of 10.</p><br>';

        $corrected = 0;
        $i = 1;
        $selected = $_POST['answer'];


        //$sql = "SELECT COUNT(*) as `total` FROM questions WHERE `correct_ans` LIKE '%$selected[$i]%'";
        $sql = "SELECT * FROM questions";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $total = $row['correct_ans'] == $selected[$i] && $row['test_id'] == $_SESSION['testdata']['test_id'];

                if ($total) {

                    $corrected++;
                } else {
                    //
                }
                $i++;
            }
            echo '<h3 class="text-center">' . $_SESSION['userdata']['username'] . ' your total score is: ' . $corrected;
            if ($corrected >= 5) {
                echo '<h3 class="text-center card"> Congratulations, You have passed the exam</h3>.';
            }
        } else {
            echo '<h3 class="text-center"> Try again, You have not passed the exam</h3>.';
        }

        $conn->close();
    }
}
?>
<p><a href="signup.php" name="signup">Logout</p>