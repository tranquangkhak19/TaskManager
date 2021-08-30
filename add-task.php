<?php
    include('config/constants.php');
?>

<html>
    <head>
        <title>Task Manager with PHP and MySQL</title>
    </head>

    <body>
        <h1>TASK MANAGER</h1>

        <a href="<?php echo SITEURL; ?>">Home</a>

        <h3>Add Task Page</h3>

        <p>
            <?php
                if(isset($_SESSION['add_fail']))
                {
                    echo $_SESSION['add_fail'];
                    unset($_SESSION['add_fail']);
                }
            ?>
        </p>

        <form method="POST" action="">
            <table>
                <tr>
                    <td>Task Name: </td>
                    <td><input type="text" name="task_name" placeholder="Type your Task Name" required="required"/></td>
                </tr>

                <tr>
                    <td>Task Description: </td>
                    <td><textarea name="task_description" placeholder="Type task description"></textarea></td>
                </tr>

                <tr>
                    <td>Select List: </td>
                    <td>
                        <select name="list_id">
                            <?php echo
                                //Connect database
                                $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                                //Select database
                                $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                                //SQL qury to get the list from table
                                $sql = "SELECT * FROM tbl_lists";

                                //Execute query
                                $res = mysqli_query($conn, $sql);

                                //Check whether the query executed or not
                                if($res==true)
                                {
                                    //Create variable to count rows
                                    echo $count_rows = mysqli_num_rows($res);

                                    //if there is data in database then display all in dropdown else display None as options
                                    if($count_rows>0)
                                    {
                                        //display all lists on dropdown from database
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            $list_id = $row['list_id'];
                                            $list_name = $row['list_name'];
                                            ?>
                                            <option value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>
                                            <?php

                                        }
                                    }
                                    else
                                    {
                                        //Display None as option
                                        ?>
                                        <option value="0">None</option>
                                        <?php    
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Priority: </td>
                    <td>
                        <select name="priority">
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Deadline: </td>
                    <td><input type="date" name="deadline"/></td>
                </tr>

                <tr>
                    <td>
                        <input type="submit" name="submit" value="SAVE"/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>



<?php
    //Check whether the SAVE button is clicked ỏ not
    if(isset($_POST['submit']))
    {
        //Get all the values from Form
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $list_id = $_POST['list_id'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];

        //Connect database
        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //Select database
        $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

        //Create SQL query to insert data into databse
        $sql2 = "INSERT INTO tbl_tasks SET
                task_name = '$task_name',
                task_description = '$task_description',
                list_id = $list_id,
                priority = '$priority',
                deadline = '$deadline'
                ";
        
        //Execute query
        $res2 =  mysqli_query($conn2, $sql2);

        //Check whether the query executed successfully or not
        if($res2==true)
        {
            //Query executed and task inserted successfully
            $_SESSION['add'] = "Task Added Successfully";

            //Redirect to Homepage
            header('location:'.SITEURL);
        }
        else
        {
            //Failed to add task
            $_SESSION['add_fail'] = "Failed to Add Task";

            //Redirect to Add Task Page
            header('location'.SITEURL.'add-task.php');
        }


    }
?>