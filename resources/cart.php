<?php require_once("config.php"); ?>

<?php 

    if(isset($_SESSION['username'])) {
        $query_user = query("SELECT * FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}' ");
	    confirm($query_user);
	
	    $row_user = mysqli_fetch_array($query_user);
	    $GLOBALS['a'] = $row_user['user_id'];
    } else {
        $GLOBALS['a'] = 0;
    }

    if(isset($_GET['add'])) {

    $query = query("SELECT * FROM products WHERE product_id = ". escape_string($_GET['add']) ." ");
    confirm($query);

    while ($row = fetch_array($query)) {
        
        // INCREMENTING OUR PRODUCTS IN THE SAY OF OUR SESSION
        //if the number of cartProducts and sessionProducts are different 
        //we will try to increment it through  '. $_GET['add']]'
        if ($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]) {

            $_SESSION['product_' . $_GET['add']] += 1;
            redirect("../public/checkout.php");

        } else {

            set_message("We only have " . $row['product_quantity'] . " " . "{$row['product_title']}" . " available");            
            redirect("../public/checkout.php");
        }
    }   
}

if(isset($_GET['remove'])) {
        
    $_SESSION['product_' . $_GET['remove']]--;
    
    if ($_SESSION['product_' . $_GET['remove']] < 1 ) {
        
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("../public/checkout.php");

    } else {

        redirect("../public/checkout.php");

    }
}


if(isset($_GET['delete'])) {
    
    $_SESSION['product_' . $_GET['delete']] = '0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);

    redirect("../public/checkout.php");

}


//WE need the product_id which is on session with the information that we need
function cart() {

    $total = 0;
    $item_quantity = 0;
    $item_name = 1;
    $item_number = 1;
    $amount = 1;
    $quantity = 1;

    //separating the key and the value example "product_1(key) = 1(value)"
    foreach ($_SESSION as $name => $value) {
        
        if ($value > 0) {
            //substr - return part of the string
            if (substr($name, 0, 8) == "product_") {

                $length = strlen($name) - 8;
                $id = substr($name, 8, $length);

                $query = query("SELECT * FROM products WHERE product_id = " .escape_string($id). " ");
                confirm($query);

                while($row = fetch_array($query)) {

                    $sub = $row['product_price'] * $value;
                    $item_quantity += $value;

                    $product_image = display_image($row['product_image']);

                    $product = <<<DELIMETER
                    <tr>
                        <td>{$row['product_title']}<br>
                        <img width='100' src='../resources/{$product_image}'>
                        </td>
                        <td>{$row['product_price']}&#8364;</td>
                        <td>{$value}</td>
                        <td>{$sub}&#8364;</td>
                        <td><a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a>   <a class='btn btn-success'href="../resources/cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></a></td>
                        <td><a class='btn btn-danger' href="../resources/cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-trash'></a></td>

                        <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                        <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                        <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                        <input type="hidden" name="quantity_{$quantity}" value="{$value}">

                    </tr>
                    DELIMETER;

                    echo $product;
                    $item_name ++;
                    $item_number ++;
                    $amount ++;
                    $quantity ++;
                }
                $_SESSION['item_total'] = $total += $sub;
                $_SESSION['item_quantity'] = $item_quantity;
            }
        }
    }
}

function proccess_transaction() {

    //check valid transaction and params
    if(isset($_GET['tx'])) {
        
        $amount = $_GET['amt'];
        $currency = $_GET['cc'];
        $transaction = $_GET['tx'];
        $status = $_GET['st'];
        $total = 0;
        $item_quantity = 0;

        foreach ($_SESSION as $name => $value) {

            if ($value > 0) {
                //substr - return part of the string
                if (substr($name, 0, 8) == "product_") {

                    $length = strlen($name) - 8;
                    $id = substr($name, 8, $length);

                    //It needs to be here to no create a product table row each time
                    //we access the thank_you page, only when there is some products in checkout
                    $send_order = query("INSERT INTO orders (order_amount, order_transaction, 
                    order_status, order_currency) VALUES('{$amount}', '{$transaction}',
                     '{$status}', '{$currency}')");
                    $last_order_id = last_id();
                    confirm($send_order);

                    $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . " ");
                    confirm($query);

                    while ($row = fetch_array($query)) {

                        $product_price = $row['product_price'];
                        $product_title = $row['product_title'];
                        $sub = $product_price * $value;
                        $item_quantity += $value;

                        $insert_report = query("INSERT INTO reports (user_id, product_id, order_id, product_price, 
                        product_title, product_quantity) VALUES('{$GLOBALS['a']}', '{$id}', '{$last_order_id}', '{$product_price}',
                        '{$product_title}', '{$value}')");

                        confirm($insert_report);

                        $item_quantity = $row['product_quantity'] - $value;
                        //decrease the product_quantity
                        $query_update = "UPDATE products SET ";
                        //query concatenated
                        $query_update .= "product_title        = '{$row['product_title']}'        , ";
                        $query_update .= "product_category_id  = '{$row['product_category_id']}'  , ";
                        $query_update .= "product_price        = '{$row['product_price']}'        , ";
                        $query_update .= "product_quantity     = '{$item_quantity}'               , ";
                        $query_update .= "product_description  = '{$row['product_description']}'  , ";
                        $query_update .= "short_desc           = '{$row['short_desc']}'           , ";
                        $query_update .= "product_image        = '{$row['product_image']}'          ";
                        $query_update .= "WHERE product_id="  . escape_string($id);

                        $send_update_query = query($query_update);
                        confirm($send_update_query);

                    }

                    $total += $sub;
                    //$item_quantity = $row['product_quantity'] - $value;
                }
            }
        }
        session_destroy();

    } else {
        redirect("index.php");
    }

}


function show_paypal() {

    if (isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1) {

        $paypal_button = <<<DELIMETER
        <input type="image" name="upload" 
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" 
        alt="PayPal - The safer, easier way to pay online">
        DELIMETER;

        return $paypal_button;
    }
}

?>