<?php
    include('config/constants.php');
    //include and require are same, but they have some differents
    //include: when include file has error -> current file can run normally
    //require: when include file has error -> current file error
?>

<html>
    <head>
        <title>Task Manager with PHP and MySQL</title>
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
    </head>

    <body>
    <div class="wrapper">
        <h1>TASK MANAGER</h1>

        <!-- Menu Starts Here -->
        <div class="menu">
            <a href="<?php echo SITEURL; ?>">Home</a>

            <?php
                //Display lists from database in our Menu
                $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
                $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());
                $sql2 = "SELECT * FROM tbl_lists";
                $res2 = mysqli_query($conn2, $sql2);

                if($res2==true)
                {
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        $list_id = $row2['list_id'];
                        $list_name = $row2['list_name'];

                        ?>
                        <a href="<?php echo SITEURL; ?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>
                        <?php
                    }
                }
            ?>

            <a href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
        </div>
        <!-- Menu End Here -->

        <p>
            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['delete-fail']))
                {
                    echo $_SESSION['delete-fail'];
                    unset($_SESSION['delete-fail']);
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

            ?>
        </p>

        <!-- Tasks Starts Here -->
        <div class="all-tasks">
            <a class="btn-primary" href="<?php SITEURL; ?>add-task.php">Add Task</a>
            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Task Name</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Actions</th>
                </tr>

                <?php
                    //Connect Database
                    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                    //Select database
                    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                    //Create SQL query to get data from database
                    $sql = "SELECT * FROM tbl_tasks";

                    //Execute Query
                    $res = mysqli_query($conn, $sql);

                    //Check whether the query executed or not
                    if($res==true)
                    {
                        //Display task from database

                        $count_rows = mysqli_num_rows($res);

                        //create serial number
                        $sn = 1;

                        //Check there is task on database or not
                        if($count_rows)
                        {
                            //Data is in database
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $task_id = $row['task_id'];
                                $task_name = $row['task_name'];
                                $priority = $row['priority'];
                                $deadline = $row['deadline'];

                                ?>
                                    <tr>
                                        <td><?php echo $sn++; ?>.</td>
                                        <td><?php echo $task_name; ?></td>
                                        <td><?php echo $priority; ?></td>
                                        <td><?php echo $deadline; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Update</a>
                                            <a href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                                        </td>

                                    </tr>
                                <?php

                            }
                        }
                        else
                        {
                            //No data in database
                            ?>
                            <tr>
                                <td colspan="5">No Task Added Yet.</td>
                            </tr>
                            <?php
                        }
                    }
                ?>

            </table>
        </div>
        <!-- Tasks Starts Here -->

    </div>
    </body>
</html>