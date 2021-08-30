<?php
    include('config/constants.php');
    //include and require are same, but they have some differents
    //include: when include file has error -> current file can run normally
    //require: when include file has error -> current file error
?>

<html>
    <head>
        <title>Task Manager with PHP and MySQL</title>
    </head>

    <body>
        <h1>TASK MANAGER</h1>

        <a href="<?php echo SITEURL; ?>">Home</a>

        <h3>Manage Lists Page</h3>

        <p>
            <?php
                //Check if the session is set
                if(isset($_SESSION['add']))
                {
                    //display message
                    echo $_SESSION['add'];
                    //remove the message after displaying once
                    unset($_SESSION['add']);
                }
                
                //Check Session Message for Update
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }

                //Check the session for Delete
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                //Check for Delete Fail
                if(isset($_SESSION['delete_fail']))
                {
                    echo $_SESSION['delete_fail'];
                    unset($_SESSION['delete_fail']);
                }
            ?>
        </p>

        <!-- Table to display lists starts here -->
        <div class="all-lists">
            <a href="<?php echo SITEURL; ?>add-list.php">Add List</a>

            <table>
                <tr>
                    <th>S.N.</th>
                    <th>List Name</th>
                    <th>Actions</th>
                </tr>

                
                <?php

                    //connect the database
                    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                    //select database
                    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                    //SQL query to display all data from database
                    $sql = "SELECT * FROM tbl_lists";

                    //Execue the Query
                    $res = mysqli_query($conn, $sql);

                    //check whether the query is executed successfully or not
                    if($res==true)
                    {
                        //work on displaying data
                        //echo "Executed";

                        //Count the rows of data in database
                        echo $count_rows = mysqli_num_rows($res);

                        //Create Serial number variable
                        $sn = 1;

                        //Check whether there is data in database or not
                        
                        if($count_rows>0)
                        {
                            //There's data in database -> display in table
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //getting the data from database
                                $list_id = $row['list_id'];
                                $list_name = $row['list_name'];
                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $list_name; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>update-list.php?list_id=<?php echo $list_id; ?>">Update</a>
                                            <a href="<?php echo SITEURL; ?>delete-list.php?list_id=<?php echo $list_id; ?>">Delete</a>
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
                                <td colspan="3">No List Added yet</td>
                            </tr>

                            <?php
                        }

                    }

                ?>

            </table>
        </div>
        
        <!-- Table to display lists ends here -->

    </body>
</html>