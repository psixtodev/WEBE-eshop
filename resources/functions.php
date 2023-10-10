<?php
use LDAP\Result;

/*****************************************************************************/
/***************************** HELPER FUNCTIONS ******************************/
/*****************************************************************************/

function last_id() {

    global $connection;

    return mysqli_insert_id($connection);
    
}

function set_message($msg) {
    
    if (!empty($msg)) {
        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
}

function display_message() {

    if (isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);

    }
}

function redirect($location) {
    header("Location: $location");
}

function query($sql) {
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result) {
    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

//avoid sql injection
function escape_string($string) {
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result){
    return mysqli_fetch_array($result);
}

/******************************************************************************/
/*************************** FRONT END FUNCTIONS ******************************/
/******************************************************************************/

function get_products() {

    $query = query("SELECT * FROM products WHERE product_quantity >= 1");
    confirm($query);

    //fetch() is used to fetch rows from the database and store them as an array
    while($row = fetch_array($query)) {

        $product_image = display_image($row['product_image']);

        //no spaces after 'DELIMETER'
        $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
            <div class="thumbnail">
                <a href="item.php?id={$row['product_id']}"><img src="../resources/{$product_image}" alt=""></a>
                <div class="caption">
                    <h4 class="pull-right">{$row['product_price']}&#8364;</h4>
                    <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                    </h4>
                    <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                    <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to cart</a>
                </div>
            </div>
        </div>
        DELIMETER;

        echo $product;
    }
}


function get_catagories() {
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = mysqli_fetch_array($query)) {
        $catagories_links = <<<DELIMETER
            <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
        DELIMETER;
        echo $catagories_links;
        
    }
}


function get_products_in_cat_page() {

    $query = query("SELECT * FROM products WHERE product_category_id = ". escape_string($_GET['id']) ." ");
    confirm($query);

    while($row = fetch_array($query)) {

        $product_image = display_image($row['product_image']);

        $feature = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
        </div>
        DELIMETER;
        echo $feature;
    }
}

function get_products_in_shop_page() {

    $query = query("SELECT * FROM products  WHERE product_quantity >= 1");
    confirm($query);

    while($row = fetch_array($query)) {
        
        $product_image = display_image($row['product_image']);

        $feature = <<<DELIMETER
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resources/{$product_image}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
        </div>
        DELIMETER;
        echo $feature;
    }
}

//isset — Determine if a variable is declared and is different than null
function login_user() {

    if (isset($_POST['submit'])) {

        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        confirm($query);

        if(mysqli_num_rows($query) == 0) {

            set_message("Your password or username are wrong");
            redirect(("login.php"));
        
        } else {

            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $row_user = mysqli_fetch_array($query);
            if ($row_user['admin_user'] == 1) {    
                //set_message("Welcome {$username}");
                redirect("admin");
            } else
                redirect("normaluser");
        }
    }
}

function send_message() {

    if (isset($_POST['submit'])) {

        
        $to         = "myEmailAddres@gmail.com";
        $from_name  = $_POST['name'];
        $subject    = $_POST['subject'];
        $email      = $_POST['email'];
        $message    = $_POST['message'];

        $additional_headers = "From: {$from_name} {$email}";

        //this use of this function is not highly recommend because the mails
        //are usually filtered or redirect to the junkmail by the email providers
        $result = mail($to, $subject, $message, $additional_headers); // True or False

        if (!$result) {
            set_message("Sorry, your message couldn't be sent");
            redirect("contact.php");
        } else {
            set_message("Your message has been sent");
        }
    }

}

/*****************************************************************************/
/*************************** BACK END FUNCTIONS ******************************/
/*****************************************************************************/

function display_orders() {

    $query = query("SELECT * FROM orders");
    confirm($query);

    while($row = fetch_array($query)) {

        $orders = <<<DELIMETER
        <tr>
           <td>{$row['order_id']}</td>
           <td>{$row['order_amount']}</td>
           <td>{$row['order_transaction']}</td>
           <td>{$row['order_currency']}</td>
           <td>{$row['order_status']}</td>
           <td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}">
               <span class="glyphicon glyphicon-remove"></span></a>
               </td>

        </tr>
        DELIMETER;
        echo $orders;

    }

}
/******************************************/
/************* ADMIN PRODUCTS *************/
/******************************************/
function display_image($picture) {

    return "uploads" . DS . $picture;
}


function get_products_in_admin() {

    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)) {

        $category = show_product_cat_title($row['product_category_id']);
        $product_image = display_image($row['product_image']);

        $product = <<<DELIMETER
        <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']}<br>
              <a href="index.php?edit_product&id={$row['product_id']}"><img width=150 src="../../resources/$product_image" alt="">
            </td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}">
               <span class="glyphicon glyphicon-remove"></span></a>
               </td>
        </tr>
        DELIMETER;

        echo $product;
    }
}

//relate cat_title(categories table) with product_categorie_id (products table)
function show_product_cat_title($product_category_id) {

    $category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}'");
    confirm($category_query);

    while($category_row = fetch_array($category_query)) {

        return $category_row['cat_title'];
    }

}



/************* ADD PRODUCTS *************/

function add_product() {

    if(isset($_POST['publish'])) {

        $product_title =        escape_string($_POST['product_title']);
        $product_category_id =  escape_string($_POST['product_category_id']);
        $product_price =        escape_string($_POST['product_price']);
        $product_quantity =     escape_string($_POST['product_quantity']);
        $product_description =  escape_string($_POST['product_description']);
        $short_desc =           escape_string($_POST['short_desc']);
        //for the media file (image)
        $product_image = ($_FILES['file']['name']);
        $image_temp_location = ($_FILES['file']['tmp_name']);

        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

        //insert all the information inside the DB
        $query = query("INSERT INTO products(product_title, product_category_id, product_price, product_description, short_desc, product_quantity, product_image)
                        VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$short_desc}', '{$product_quantity}', '{$product_image}')");
        $last_id = last_id();
        confirm($query);

        set_message("New Product with id '{$last_id}' was added");
        redirect("index.php?products");

    }

}

function show_catagories_add_product() {
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = mysqli_fetch_array($query)) {
        $catagories_options = <<<DELIMETER
            <option value="{$row['cat_id']}">{$row['cat_title']}</option>
        DELIMETER;
        echo $catagories_options;
        
    }
}

/************* UPDATE PRODUCTS *************/
function update_product() {

    if(isset($_POST['update'])) {

        $product_title =        escape_string($_POST['product_title']);
        $product_category_id =  escape_string($_POST['product_category_id']);
        $product_price =        escape_string($_POST['product_price']);
        $product_quantity =     escape_string($_POST['product_quantity']);
        $product_description =  escape_string($_POST['product_description']);
        $short_desc =           escape_string($_POST['short_desc']);
        $product_image =        escape_string($_FILES['file']['name']);
        $image_temp_location =  escape_string($_FILES['file']['tmp_name']);

        if(empty($product_image)) {
            $get_pic = query("SELECT product_image FROM products WHERE product_id =" .escape_string($_GET['id']. ""));
            confirm($get_pic);

            while($pic = fetch_array($get_pic)) {
                $product_image = $pic['product_image'];
            }
        }
        move_uploaded_file($image_temp_location, UPLOAD_DIRECTORY . DS . $product_image);

        
        $query = "UPDATE products SET ";
        //query concatenated
        $query .= "product_title        = '{$product_title}'        , ";
        $query .= "product_category_id  = '{$product_category_id}'  , ";
        $query .= "product_price        = '{$product_price}'        , ";
        $query .= "product_quantity     = '{$product_quantity}'     , ";
        $query .= "product_description  = '{$product_description}'  , ";
        $query .= "short_desc           = '{$short_desc}'           , ";
        $query .= "product_image        = '{$product_image}'          ";
        $query .= "WHERE product_id="  . escape_string($_GET['id']);

        $send_update_query = query($query);
        confirm($send_update_query);

        set_message("Product has been updated");
        redirect("index.php?products");
    }
}

/************* Categories *************/

function show_categories_in_admin() {

    $category_query = query("SELECT * FROM categories");
    confirm($category_query);

    while($row = fetch_array($category_query)) {

        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        $category = <<<DELIMETER
            <tr>
                <td>$cat_id</td>
                <td>$cat_title</td>
                <td><a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$row['cat_id']}">
                <span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
        DELIMETER;

        echo $category;
    }
}

function add_category() {

    if (isset($_POST['add_category'])) {
        $cat_title = escape_string($_POST['cat_title']);

        if (empty($cat_title) || $cat_title == " ") {
            set_message("Invalid category title");
        } else {

            $insert_cat = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}') ");
            confirm($insert_cat);

            echo "<h3 class='bg-success'>New category created</h3>";
        }
    }
}

/************* Users *************/

function display_users() {

    $user_query = query("SELECT * FROM users");
    confirm($user_query);

    while($row = fetch_array($user_query)) {

        $user_id = $row['user_id'];
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];

        $user = <<<DELIMETER
            <tr>
                <td>$user_id</td>
                <td>$username</td>
                <td>$email</td>
                <td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$row['user_id']}">
                <span class="glyphicon glyphicon-remove"></span></a>
                </td>
            </tr>
        DELIMETER;

        echo $user;
    }
}

function add_user() {

    if(isset($_POST['add_user'])) {

        $username   = escape_string($_POST['username']);
        $email      = escape_string($_POST['email']);
        $password   = escape_string($_POST['password']);
    
        $query = query("INSERT INTO users(username,email,password) VALUES('{$username}','{$email}','{$password}')");
        confirm($query);

        set_message("USER CREATED");

        redirect("index.php?users");

    }

}

function signup() {

    if(isset($_POST['signup'])) {

        $username   = escape_string($_POST['username']);
        $email      = escape_string($_POST['email']);
        $password   = escape_string($_POST['password']);
        $admin_user = 0;
    
        $query = query("INSERT INTO users(username,email,password,admin_user) VALUES('{$username}','{$email}','{$password}', '{$admin_user}')");
        confirm($query);

        $_SESSION['username'] = $username;
        redirect("admin");

    }

}

/************* Reports *************/

function get_reports() {

    $query = query("SELECT * FROM reports");
    confirm($query);

    //user_id == 0 means non registered
    while($row = fetch_array($query)) {

        $report = <<<DELIMETER
        <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['user_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_title']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}">
               <span class="glyphicon glyphicon-remove"></span></a>
               </td>
        </tr>
        DELIMETER;

        echo $report;
    }
}

function get_reports_normaluser($username,$passwd) {

    $query_user = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$passwd}' ");
    confirm($query_user);
    $row_user = mysqli_fetch_array($query_user);
    $user_id = $row_user['user_id'];
    
    $query = query("SELECT * FROM reports WHERE user_id = " . escape_string($user_id) . " ");
    confirm($query);

    //user_id == 0 means non registered
    while($row = fetch_array($query)) {

        $report = <<<DELIMETER
        <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_title']}</td>
            <td>{$row['product_quantity']}</td>
        </tr>
        DELIMETER;

        echo $report;
    }
}

?>