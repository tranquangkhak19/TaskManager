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

            <a class="btn-secondary" href="<?php echo SITEURL; ?>">Home</a>
            <a class="btn-secondary" href="<?php echo SITEURL; ?>manage-list.php">Manage List</a>


            <h3>Add List Page</h3>

            <p>
                <?php
                    //Check whether the sesstion is created or not
                    if(isset($_SESSION['add_fail']))
                    {
                        //display session message
                        echo $_SESSION['add_fail'];
                        //remove session message after displaying once
                        unset($_SESSION['add_fail']);
                    }
                ?>
            </p>

            <!-- Form to add list starts here -->
            <form method="POST" action="">
                <table class="tbl-half">
                    <tr>
                        <td>List Name: </td>
                        <td><input type="text" name="list_name" placeholder="Type list name here" required="required"/></td>
                    </tr>

                    <tr>
                        <td>List Description: </td>
                        <td><textarea name="list_description" placeholder="Type list description here"></textarea></td>
                    </tr>

                    <tr>
                        <td><input class="btn-primary btn-lg" type="submit" name="submit" value="ADD"/></td>
                    </tr>
                </table>
            </form>
            <!-- Form to add list ends here -->
        </div>
    </body>
    
</html>


<?php

    //chekc wheter the form is submitted or not
    if(isset($_POST['submit']))
    {
        //echo "Form Submitted";

        //Get the values from form and save it in variables
        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];

        //Connect Database
        //In localhost username:root and password:NULL, but in live server it's different
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error);
        
        //Check whether the database connected or not
        if($conn==true)
        {
            echo "Database Connected <br>";
        }
        
        //Select Database
        $db_select = mysqli_select_db($conn, DB_NAME);

        //Check wheter database is connected or not
        if($db_select==true)
        {
            echo "Database Selected <br>";
        }

        //SQL Query to Insert data into database
        $sql = "INSERT INTO tbl_lists SET
            list_name = '$list_name',
            list_description = '$list_description'
        ";

        //Execute Query and Insert into Database
        $res = mysqli_query($conn, $sql);

        //Check whether the query executed successfully or not
        if($res==true)
        {
            echo "Data Inserted <br>";

            //Create a SESSTION Variable to display message
            $_SESSION['add'] = "List Added Successfully";

            //Redirect to Manage List Page
            header('location:'.SITEURL.'manage-list.php');
        }
        else
        {
            echo "Failed to Insert Data <br>";

            //Create a SESSTION Variable to save message
            $_SESSION['add_fail'] = "Failed to Add List";

            //Redirect to Same Page
            header('location:'.SITEURL.'add-list.php');

        }
    }
    

?>