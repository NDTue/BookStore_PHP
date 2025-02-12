<?php

// cart.php

session_start();  // Start the session

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Controllers\BookController;

// Database connection using MySQLi
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'quanlysach';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Instantiate the controller with the MySQLi connection
$bookController = new BookController();

// Fetch cart items
$cartItems = $bookController->getCartItems();

// Close the MySQLi connection
$conn->close();

?>

<?php $title = 'Shopping Cart'; // Set the title for the page ?>

<?php ob_start(); ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Shopping Cart</h1>

    <?php if (empty($cartItems)): ?>
        <div class="alert alert-warning text-center">
            Your cart is empty.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover custom-cart-table">
                <thead>
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Book Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><img src="<?='http://localhost/Fin/'. htmlspecialchars($item->getAnh()); ?>" class="img-thumbnail cart-item-image" alt="<?= htmlspecialchars($item->getTensach()); ?>" width="60"></td>
                            <td><?= htmlspecialchars($item->getTensach()); ?></td>
                            <td><?= htmlspecialchars($item->getTacgia()); ?></td>
                            <td><?= htmlspecialchars($item->getGia()); ?> VND</td>
                            <td>
                                <div class="quantity-control">
                                    <button class="btn btn-sm btn-secondary decrease-quantity" data-book-id="<?= htmlspecialchars($item->getMasach()); ?>">-</button>
                                    <input type="text" class="form-control quantity-input" data-book-id="<?= htmlspecialchars($item->getMasach()); ?>" value="<?= $_SESSION['cart'][$item->getMasach()]; ?>" readonly>
                                    <button class="btn btn-sm btn-secondary increase-quantity" data-book-id="<?= htmlspecialchars($item->getMasach()); ?>">+</button>
                                </div>
                            </td>
                            <td class="item-total">
                                <?= $_SESSION['cart'][$item->getMasach()] * $item->getGia(); ?> VND
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm remove-item" data-book-id="<?= htmlspecialchars($item->getMasach()); ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Grand Total Section -->
        <div class="grand-total">
            <h4>Grand Total: 
                <?php 
                    $grandTotal = 0;
                    foreach ($cartItems as $item) {
                        $grandTotal += $_SESSION['cart'][$item->getMasach()] * $item->getGia();
                    }
                    echo $grandTotal . " VND";
                ?>
            </h4>
        </div>

        <div class="row justify-content-between">
            <div class="col-auto">
                <a href="/Fin/" class="btn btn-primary">Continue Shopping</a>
            </div>
            <div class="col-auto">
                <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Handle item removal
document.querySelectorAll('.remove-item').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const bookId = this.getAttribute('data-book-id');
        console.log('Remove button clicked for book ID:', bookId);

        // Send request to remove the item from the cart
        fetch('/Fin/src/cart-handling/remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ bookId: bookId }),
        })
        .then(response => response.json())  // Expecting JSON response
        .then(data => {
            if (data.status === 'success') {
                // Successfully removed, update the cart display
                location.reload();  // Reload the page to update cart
            } else {
                alert(data.message || 'Failed to remove item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

    // Handle quantity change with buttons
    document.querySelectorAll('.increase-quantity').forEach(function(button) {
        button.addEventListener('click', function(event) {
            const bookId = this.getAttribute('data-book-id');
            const quantityInput = document.querySelector(`.quantity-input[data-book-id="${bookId}"]`);
            let quantity = parseInt(quantityInput.value);

            // Increment quantity and update the display
            quantity++;
            quantityInput.value = quantity;

            // Send request to update the cart
            fetch('/Fin/src/cart-handling/update_cart_quantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ bookId: bookId, quantity: quantity }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Reload the page to update cart
                    location.reload();  // Reload the page to reflect updated quantity
                } else {
                    console.error('Failed to update quantity');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    document.querySelectorAll('.decrease-quantity').forEach(function(button) {
        button.addEventListener('click', function(event) {
            const bookId = this.getAttribute('data-book-id');
            const quantityInput = document.querySelector(`.quantity-input[data-book-id="${bookId}"]`);
            let quantity = parseInt(quantityInput.value);

            // Decrement quantity if greater than 1
            if (quantity > 1) {
                quantity--;
                quantityInput.value = quantity;

                // Send request to update the cart
                fetch('/Fin/src/cart-handling/update_cart_quantity.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ bookId: bookId, quantity: quantity }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Reload the page to reflect updated quantity
                        location.reload();  // Reload the page to update cart
                    } else {
                        console.error('Failed to update quantity');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    });


    // Update the item total price after quantity change
    function updateItemTotal(bookId, quantity) {
        const price = document.querySelector(`.item-total[data-book-id="${bookId}"]`);
        const unitPrice = parseFloat(price.getAttribute('data-unit-price'));  // Get the unit price from data attribute
        const newTotal = unitPrice * quantity;
        price.textContent = `${newTotal} VND`;  // Update the item total price
    }

    // Update the grand total after any item quantity update
    function updateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.item-total').forEach(function(item) {
            grandTotal += parseFloat(item.textContent);
        });
        document.querySelector('.grand-total h4').textContent = `Grand Total: ${grandTotal} VND`;
    }
</script>

<?php $content = ob_get_clean(); ?>

<?php include(__DIR__ . '/../../../templates/layout.php'); ?>
