<?php
session_start();
include 'config.php';

$user_id = $_SESSION['user_id'] ?? null;
if(!$user_id) {
    header('location:login.php');
    exit;
}

function setMessage($msg) {
    $_SESSION['message'] = $msg;
}

if(isset($_GET['logout'])){
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");
    session_destroy();
    header('location:login.php'); 
    exit;
}

if(isset($_POST['add_to_cart'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE name='$product_name' AND user_id='$user_id'");
    if(mysqli_num_rows($select_cart) > 0){
        setMessage('Product already added to cart!');
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, name, price, image, quantity) VALUES ('$user_id','$product_name','$product_price','$product_image','$product_quantity')");
        setMessage('Product added to the cart!');
    }
    header('location:index.php');
    exit;
}

if(isset($_POST['update_cart'])){
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];
    mysqli_query($conn, "UPDATE cart SET quantity='$update_quantity' WHERE id='$update_id'");
    setMessage('Cart quantity updated successfully!');
    header('location:index.php');
    exit;
}

if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM cart WHERE id='$remove_id'");
    setMessage('Item is removed  from cart!');
    header('location:index.php');
    exit;
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");
    setMessage('All items are deleted from cart!');
    header('location:index.php');
    exit;
}

$select_user = mysqli_query($conn, "SELECT * FROM user_form WHERE id='$user_id'");
$fetch_user = mysqli_fetch_assoc($select_user);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart</title>
<link rel="stylesheet" href="sss.css">
<style>
.message { position: fixed; top: 20px; right: 20px; padding: 10px 15px; border-radius: 5px; z-index: 9999; cursor: pointer; box-shadow: 0 3px 8px rgba(0,0,0,0.3); }
.message-success { background: #28a745; color: white; }
.message-info { background: #17a2b8; color: white; }
.message-error { background: #dc3545; color: white; }
#pynow {
    transition: background-color 0.3s ease, transform 0.3s ease;
}
#pynow:hover {
    background-color: yellow;
    transform: scale(1.05); /* slightly enlarge on hover */
}
</style>
</head>
<body>

<?php
if(isset($_SESSION['message'])){
    $msg = $_SESSION['message'];
    $class = 'message-success';
    if(stripos($msg,'updated')!==false) $class='message-info';
    if(stripos($msg,'remove')!==false || stripos($msg,'delete')!==false) $class='message-error';
    echo "<div class='message $class' onclick='this.remove()'>$msg</div>";
    unset($_SESSION['message']);
}
?>

<div class="container">
    <div class="user-profile">
        <p>Username: <span><?php echo htmlspecialchars($fetch_user['name']); ?></span></p>
        <p>Email: <span><?php echo htmlspecialchars($fetch_user['email']); ?></span></p>
        <div class="flex">
            <a href="login.php" class="btn">Login</a>
            <a href="register.php" class="option-btn">Register</a>
            <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to logout?');" class="delete-btn">Logout</a>
        </div>
    </div>

    <div class="products">
        <h1 class="heading">Latest Products</h1>
        <div class="box-container">
            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM products");
            while($fetch_product = mysqli_fetch_assoc($select_product)){
            ?>
            <form method="post" action="index.php" class="box">
                <img src="images/<?php echo $fetch_product['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_product['name']; ?></div>
                <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
                <input type="number" min="1" name="product_quantity" value="1">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
            </form>
            <?php } ?>
        </div>
    </div>

    <div class="shopping-cart">
        <h1 class="heading">Shopping Cart</h1>
        <table>
            <thead>
                <tr>
                    <th>Image</th><th>Name</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $cart_query = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id'");
            $grand_total = 0;
            if(mysqli_num_rows($cart_query) > 0){
                while($fetch_cart = mysqli_fetch_assoc($cart_query)){
                    $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
                    $grand_total += $sub_total;
            ?>
            <tr>
                <td><img src="images/<?php echo $fetch_cart['image']; ?>" height="80"></td>
                <td><?php echo $fetch_cart['name']; ?></td>
                <td>$<?php echo number_format($fetch_cart['price'],2); ?></td>
                <td>
                    <form action="index.php" method="post">
                        <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                        <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                        <input type="submit" name="update_cart" value="Update" class="option-btn">
                    </form>
                </td>
                <td>$<?php echo number_format($sub_total,2); ?></td>
                <td>
                    <a href="index.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure to remove this item?')">Remove</a>
                </td>
            </tr>
            <?php } } else {
                echo '<tr><td colspan="6">No items in cart</td></tr>';
            } ?>
            <tr>
                <td colspan="4">Grand Total:</td>
                <td>$<?php echo number_format($grand_total,2); ?></td>
                <td>
                    <a href="index.php?delete_all" 
                    class="delete-btn <?php echo ($grand_total>0)?'':'disabled'; ?>" 
                    onclick="return confirm('Are you sure you want to delete all items in the cart?');">
                    Delete All
                    </a>               
            </td>
            </tr>
            </tbody>
        </table>

        <?php if($grand_total>0): ?>
        <form action="payment.php" method="post" style="margin-left:500px;">
            <input type="hidden" name="amount" value="<?php echo $grand_total; ?>">
            <input type="submit" value="Pay Now" class="btn" style="background-color:green;" id="pynow">
        </form>
        <?php endif; ?>
    </div>
</div>

<script>
window.addEventListener("beforeunload", function () {
  localStorage.setItem("scrollPosition", window.scrollY);
});

window.addEventListener("load", function () {
  const scrollPosition = localStorage.getItem("scrollPosition");
  if (scrollPosition !== null) {
    window.scrollTo(0, parseInt(scrollPosition));
    localStorage.removeItem("scrollPosition");
  }

  const messages = document.querySelectorAll('.message');
  messages.forEach(msg => {
    setTimeout(() => { msg.style.display='none'; }, 2000);
  });
});
</script>

</body>
</html>
