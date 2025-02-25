<?php

$state = 0;

// Process delete operation after confirmation
if (isset($_POST["name"]) && !empty($_POST["name"])) {

    $state = 1;
    // Set parameters
    $param_name = trim($_POST["name"]);

    // Include config file
    require_once "config.php";
    $name = $_POST["name"];
    // Prepare a delete statement
    $sql = "DELETE FROM games WHERE name = $name";

    $state = 2;

    try {
        if ($stmt = mysqli_prepare($link, $sql)) {
            $state = $sql;

            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "i", $param_name);
            //$state = 4;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records deleted successfully. Redirect to landing page
                header("location: ../welcome.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);

            // Close connection
            mysqli_close($link);
        }
    } catch (Exception $e) {
        $state = $e;
    }
} else {
    $state = 4;
    // Check existence of id parameter
    if (empty(trim($_GET["name"]))) {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete Game - <?php echo $state ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
    <!-- <?php echo $state ?> -->
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Delete game</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="name" value="<?php echo trim($_GET["name"]); ?>" />
                            <p>Are you sure you want to delete this game?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="../welcome.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>