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
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-8 w-full max-w-md relative">
            <h2 class="text-2xl text-center font-bold mb-4">Login</h2>
            <!-- Login Form -->
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 text-xl">Username</label>
                    <input type="text" class="w-full px-3 text-xl py-2 border rounded" placeholder="Enter your username">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-xl">Password</label>
                    <input type="password" class="w-full text-xl px-3 py-2 border rounded" placeholder="Enter your password">
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                    Submit
                </button>
                <button id="closeLoginModal" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-4">Cancel</button>
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
                <button id="closeRegisterModal" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-4">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        // Login Modal
        const loginButton = document.getElementById('loginButton');
        const closeLoginModal = document.getElementById('closeLoginModal');
        const loginModal = document.getElementById('loginModal');

        loginButton.addEventListener('click', function() {
            loginModal.classList.remove('hidden');
        });

        closeLoginModal.addEventListener('click', function() {
            loginModal.classList.add('hidden');
        });

        loginModal.addEventListener('click', function(e) {
            if(e.target === loginModal) {
                loginModal.classList.add('hidden');
            }
        });

        // Register Modal
        const registerButton = document.getElementById('registerButton');
        const closeRegisterModal = document.getElementById('closeRegisterModal');
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