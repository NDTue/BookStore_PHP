<?php

// update_cart_quantity.php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['bookId']) && isset($data['quantity'])) {
        $bookId = $data['bookId'];
        $quantity = (int)$data['quantity'];

        if ($quantity <= 0) {
            $quantity = 1;  // Ensure the quantity is at least 1
        }

        // Update the cart in session
        if (isset($_SESSION['cart'][$bookId])) {
            $_SESSION['cart'][$bookId] = $quantity;
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Item not found in cart']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
}
?>
