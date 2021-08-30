<?php
    include('config/constants.php');

    //Check the task_id
    if(isset($_GET['task_id']))
    {
        $task_id = $_GET['task_id'];
    }
    else
    {
        header('location:'.SITEURL);
    }

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
    $sql = "SELECT * FROM tbl_tasks WHERE task_id=$task_id";
    $res = mysqli_query($conn, $sql);

    if($res==true)
    {
        $row = mysqli_fetch_assoc($res);
        
        $task_name = $row['task_name'];
        $task_description = $row['task_description'];
        $list_id = $row['list_id'];
        $priority = $row['priority'];
        $deadline = $row['deadline'];
    }

?>

<html>
    <head>
        <title>Task Manager with PHP and MySQL</title>
    </head>

    <body>
        <h1>TASK MANAGER</h1>

        <p>
            <a href="<?php echo SITEURL; ?>">Home</a>
        </p>

        <h3>Update Task Page</h3>

        <p>
            <?php
                if(isset($_SESSION['update_fail']))
                {
                    echo $_SESSION['update_fail'];
                    unset($_SESSION['update_fail']);
                }
            ?>
        </p>

        <form method="POST" action="">
            <table>
                <tr>
                    <td>Task Name: </td>
                    <td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required="required"/></td>
                </tr>

                <tr>
                    <td>Task Description: </td>
                    <td>
                        <textarea name="task_description">
                        <?php echo $task_description; ?>
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td>Select List: </td>
                    <td>
                        <select name="list_id">
                            <?php
                                $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
                                $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());
                                $sql2 = "SELECT * FROM tbl_lists";
                                $res2 = mysqli_query($conn2, $sql2);

                                if($res2==true)
                                {
                                    $count_rows2 = mysqli_num_rows($res2);

                                    if($count_rows2>0)
                                    {
                                        while($row2=mysqli_fetch_assoc($res2))
                                        {
                                            $list_id2 = $row2['list_id'];
                                            $list_name2 = $row2['list_name'];

                                            ?>

                                                <option <?php if($list_id2==$list_id){echo "selected='selected'";} ?> value="<?php echo $list_id2 ?>"><?php echo $list_name2; ?></option>
                                            
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                        <option <?php if($list_id==0){echo "selected='selected'";} ?> value="0">None</option>
                                        <?php 
                                    }
                                }
                            ?>
                            <option value="1">Doing</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Priority: </td>
                    <td>
                        <select name="priority">
                            <option <?php if($priority=="High"){echo "selected='selected'";} ?> value="High">High</option>
                            <option <?php if($priority=="Medium"){echo "selected='selected'";} ?> value="Medium">Medium</option>
                            <option <?php if($priority=="Low"){echo "selected='selected'";} ?> value="Low">Low</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Deadline: </td>
                    <td><input type="date" name="deadline" value="<?php echo $deadline; ?>"/></td>
                </tr>

                <tr>
                    <td><input type="submit" name="submit" value="UPDATE"/></td>
                </tr>

            </table>
        </form>
    </body>
</html>


<?php
    //Check if the button is clicked
    if(isset($_POST['submit']))
    {
        //Get the value from form
        $task_name_update = $_POST['task_name'];
        $task_description_update = $_POST['task_description'];
        $list_id_update = $_POST['list_id'];
        $priority_update = $_POST['priority'];
        $deadline_update = $_POST['deadline'];

        //update database
        $conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());
        $db_select3 = mysqli_select_db($conn3, DB_NAME) or die(mysqli_error());
        $sql3 = "UPDATE tbl_tasks SET
                task_name = '$task_name_update',
                task_description = '$task_description_update',
                list_id = '$list_id_update',
                priority = '$priority_update',
                deadline = '$deadline_update'
                WHERE
                task_id = $task_id;
                ";
        $res3 = mysqli_query($conn, $sql3);

        //check the query executed or not
        if($res3==true)
        {
            $_SESSION['update'] = "Task Updated Successfully";
            header('location:'.SITEURL);
        }
        else
        {
            $_SESSION['update_fail'] = "Failed to Update Task";
            header('location:'.SITEURL.'update-task.php?task_id='.$task_id);
        }
    }
?>