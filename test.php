<?php
// Include the file where the User class is defined

use App\Models\User;// Adjust the path to where your User class file is located

// Test Configuration
$testUsername = 'joestarslayer'; // Replace this with a username that exists in your database

try {
    // Initialize the User class
    $userModel = new User();

    // Call the function
    $user = $userModel->getUserByUsername($testUsername);

    // Check if user was found and display the result
    if ($user) {
        echo "User found:\n";
        print_r($user);
    } else {
        echo "No user found with username: " . htmlspecialchars($testUsername) . "\n";
    }
} catch (Exception $e) {
    // Catch and display any errors
    echo "An error occurred: " . $e->getMessage();
}
