<?php
// Database connection
$host = 'localhost';
$port = '3307';
$dbname = 'hr3';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Login process
    if (isset($_POST['login'])) {
        $user = $_POST['login_username'];
        $pass = $_POST['login_password'];
        
        $sql = "SELECT * FROM user WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['password'])) {
                echo "<script>alert('Login successful!');</script>";
                // Redirect or set session variables as needed
                echo "<script>window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Incorrect password!');</script>";
            }
        } else {
            echo "<script>alert('User not found!');</script>";
        }
        $stmt->close();
    }

    // Registration process
    if (isset($_POST['register'])) {
        $user = $_POST['username'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $user, $email, $pass);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register Page</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center" style="background: url('logo.png') no-repeat center center;">
    <div style="width:50%; min-height:100%;" class="bg-white bg-opacity-50 border">
        <div class="grid grid-cols-4 text-center font-bold rounded-md" style="height: max-content;">
            <div class="col-start-1 shadow-lg col-span-2 p-10 flex justify-center items-center grid grid-rows-2 grid-cols-3 gap-4">
                <div class="col-start-2 text-2xl">Login</div>
                <div class="col-span-3">
                    <button id="loginButton" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold text-xl p-4 rounded">
                        Login
                    </button>
                </div>
            </div>
            <div class="col-start-3 shadow-lg col-span-2 flex justify-center items-center grid grid-rows-2 grid-cols-3 gap-4 p-10">
                <div class="col-start-2 text-2xl">Register</div>
                <div class="col-span-3 flex justify-center items-center">
                    <button id="registerButton" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold text-xl p-4 rounded">
                        Register
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-8 w-full max-w-md relative">
            <h2 class="text-2xl text-center font-bold mb-4">Login</h2>
            <!-- Login Form -->
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-gray-700 text-xl">Username</label>
                    <input type="text" name="login_username" class="w-full px-3 text-xl py-2 border rounded" placeholder="Enter your username" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-xl">Password</label>
                    <input type="password" name="login_password" class="w-full text-xl px-3 py-2 border rounded" placeholder="Enter your password" required>
                </div>
                <button type="submit" name="login" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                    Submit
                </button>
                <button id="closeLoginModal" type="button" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-4">
                    Cancel
                </button>
            </form>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-full max-w-md relative">
            <h2 class="text-2xl text-center font-bold mb-4">Register</h2>
            <!-- Register Form -->
            <form method="POST" action="">
                <div class="mb-4">
                    <label class="block text-gray-700 text-xl">Username</label>
                    <input type="text" name="username" class="w-full px-3 text-xl py-2 border rounded" placeholder="Choose a username" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-xl">Email</label>
                    <input type="email" name="email" class="w-full px-3 text-xl py-2 border rounded" placeholder="Enter your email" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-xl">Password</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border rounded" placeholder="Choose a password" required>
                </div>
                <button type="submit" name="register" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 mb-4 px-4 rounded">
                    Register
                </button>
                <button id="closeRegisterModal" type="button" class="w-full bg-red-500 hover:bg
        const registerModal = document.getElementById('registerModal');

        registerButton.addEventListener('click', function() {
            registerModal.classList.remove('hidden');
        });

        closeRegisterModal.addEventListener('click', function() {
            registerModal.classList.add('hidden');
        });

        registerModal.addEventListener('click', function(e) {
            if(e.target === registerModal) {
                registerModal.classList.add('hidden');
            }
        });
    </script>
</body>
</html>