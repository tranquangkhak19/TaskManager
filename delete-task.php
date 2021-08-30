<?php
    include('config/constants.php');

    //Check task_id in URL
    if(isset($_GET['task_id']))
    {
        //Delete the task from database

        //Get task_id
        $task_id = $_GET['task_id'];

        //Connect database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //Select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

        //SQL query
        $sql = "DELETE FROM tbl_tasks WHERE task_id=$task_id";

        //Execute query
        $res = mysqli_query($conn, $sql);

        //Check if the query executed successfully or not
        if($res==true)
        {
            //Query executed successfully and task deleted
            $_SESSION['delete'] = "Task Deleted Successfully";

            //Redirect to Homepage
            header('location:'.SITEURL);
        }
        else
        {
            //Failed to delete task
            $_SESSION[delete_fail] = "Failed to Delete Task";

            //Redirect to homepage
            header('location:'.SITEURL);
        }
    }
    else
    {
        //Redirect to Home
        header('location:'.SITEURL);
    }
?>