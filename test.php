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
$test_id = $_SESSION['testdata']['test_id'];



?>



<body>
    <h1 class="card"><?php echo '<h1>Test: ' . $_SESSION['testdata']['testname'] . '</h1>'; ?></h1>


    <form action="result.php" method="POST">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
        $per_page = 10;
        $start_from = ($page - 1) * $per_page;
        $j = 1;


        $sql = "SELECT * FROM questions WHERE `test_id`='" . $test_id . "' LIMIT $start_from,$per_page";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="card-header">
                    <p><b><?php echo $j ?>: <?php echo $row['q_desc'] ?></b></p>
                    <input type="radio" name="answer[<?php echo $row['q_id'] ?>]" value="<?php echo $row['opt_1'] ?>" required> <?php echo $row['opt_1'] ?><br>

                    <input type="radio" name="answer[<?php echo $row['q_id'] ?>]" value="<?php echo $row['opt_2'] ?>"> <?php echo $row['opt_2'] ?><br>

                    <input type="radio" name="answer[<?php echo $row['q_id'] ?>]" value="<?php echo $row['opt_3'] ?>"> <?php echo $row['opt_3'] ?><br>
                    <input type="radio" name="answer[<?php echo $row['q_id'] ?>]" value="<?php echo $row['opt_4'] ?>"> <?php echo $row['opt_4'] ?></td>

                </div>
        <?php
                $j++;
            }
        } else {
            //echo "0 results";
        }



        ?>

        <?php

        if ($_SESSION['testdata']['page_stat'] == 0) {
            $page_stat = 'disabled';
        } else {
            $page_stat = null;
        }
        $sql = "SELECT * FROM questions WHERE `test_id`='" . $test_id . "'";
        $result = $conn->query($sql);
        $totalrows = mysqli_num_rows($result);
        $totalpages = ceil($totalrows / $per_page);

        if ($result->num_rows > 0) {
            // output data of each row

            echo "<ul class='pagination'>";
            echo "<span class=".$page_stat."><a href='test.php?page=" . ($page - 1) . "'><< Previous</a><span>";

            for ($i = 1; $i <= $totalpages; $i++) {
                echo "<li> || <a href='test.php?page=" . $i . "'>" . $i . "</a> || </li>";
            };

            echo "<button><a href='test.php?page=" . ($page + 1) . "'>NEXT >></a></button>";
            echo "</ul>";
        } else {
            echo "0 results";
        }

        ?>


        <p>
            <input class="btn btn-dark" type="submit" <?php if ($page != 10 && $page > 1) { ?> disabled="disabled" <?php } ?> name="submitTest" value="Submit" />
        </p>
    </form>

    <p><a href="signup.php" name="signup">Logout</p>
</body>

</html>