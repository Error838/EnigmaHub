<?php
function getName(){
    require('config.php');

    $sql = "SELECT * FROM users WHERE id='{$_SESSION["user_id"]}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        $data = mysqli_fetch_assoc($result);
        echo $data['full_name'];
    }
};
function printDate(){
    require('config.php');

    $sql = "SELECT * FROM users WHERE id='{$_SESSION["user_id"]}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        $data = mysqli_fetch_assoc($result);
        echo $data['create_date'];
    }
};
function callEmail(){
    require('config.php');

    $sql = "SELECT * FROM users WHERE id='{$_SESSION["user_id"]}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) 
    {
        $data = mysqli_fetch_assoc($result);
        $email = $data['email'];
    }
};




function printProducts(){
    require('config.php');
    
    $sql = "SELECT registeration.product_name, registeration.serial_no, registeration.purchase_date FROM users  INNER JOIN  registeration
    ON users.email = registeration.email WHERE users.id = '{$_SESSION["user_id"]}' ";
    if($result = mysqli_query($conn, $sql)){
        if(mysqli_num_rows($result) > 0){
            echo "<table>";
                echo "<tr>";
                    echo "<th>Product Name</th>";
                    echo "<th>             &nbsp;               &nbsp;               &nbsp;               &nbsp;</th>";
                    echo "<th>Serial Number</th>";
                    echo "<th>             &nbsp;               &nbsp;               &nbsp;               &nbsp;</th>";
                    echo "<th>Date of Purchase</th>";
                    
                echo "</tr>";
            while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<th>             &nbsp;               &nbsp;               &nbsp;               &nbsp;</th>";
                    echo "<td>" . $row['serial_no'] . "</td>";
                    echo "<th>             &nbsp;               &nbsp;               &nbsp;               &nbsp;</th>";
                    echo "<td>" . $row['purchase_date'] . "</td>";
            
                echo "</tr>";
            }
            echo "</table>";
            
            mysqli_free_result($result);
        } else{
            echo "You have no products registered";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
};
