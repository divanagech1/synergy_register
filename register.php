<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register_db";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if phone number already exists
    $phone_number = $_POST["phone_number"];
    $check_query = "SELECT * FROM users WHERE phone_number = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $phone_number);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    if ($result->num_rows > 0) {
        // Redirect to invalid.php if phone number already exists
        header("Location: invalid.php");
        exit();
    } else {
        // Prepare and bind SQL statement
        $sql = "INSERT INTO users (name, phone_number, Age, wereda, subcity, date, heard_from, payment_1, payment_2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $name, $phone_number, $Age, $wereda, $sub_city, $date, $heard_from, $payment_1, $payment_2); 

        $name = $_POST["name"];
        $Age = $_POST["Age"];
        $wereda = $_POST["wereda"];
        $sub_city = $_POST["sub_city"];
        $date = $_POST["date"];
        $heard_from = $_POST["heard_from"];
        $payment_1 = isset($_POST["90"]) ? 1 : 0; // true if checkbox is checked, false otherwise
        $payment_2 = isset($_POST["700"]) ? 1 : 0; // true if checkbox is checked, false otherwise

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            // Redirect to msg.php if registration is successful
            header("Location: msg.php");
            exit();
        } else {
            // Redirect to invalid.php if registration fails
            header("Location: invalid.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <img src="img/logo.jpg" alt="Logo">
                        </span>
                        <span class="title">synergy</span>
                    </a>
                </li>

                <li>
                    <a href="index.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="register.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Register Customers</span>
                    </a>
                </li>
                   
                <li>
                    <a href="list_of_customers.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">List of Customers</span>
                    </a>
                </li>

                <li>
                    <a href="Ad_login.php" id="logout">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                
                <div class="title">
                <h2>Admin Dashboard</h2>
                </div>

                <div class="user">
                <img src="img/logo.jpg" alt="Logo">
                </div>
            </div>
                
                
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <h2>Registration Form</h2>
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="phone_number">Phone Number:</label><br>
    <input type="tel" id="phone_number" name="phone_number" pattern="[0][0-9]{9}" title="Phone number must be 10 digits starting with 0" required><br><br>

        <label for="Age">Age:</label><br>
        <input type="text" id="Age" name="Age"><br><br>

        <label for="wereda">Wereda:</label><br>
        <input type="text" id="wereda" name="wereda"><br><br>

        <label for="sub_city">Sub City:</label><br>
        <input type="text" id="sub_city" name="sub_city"><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br><br>

        <label for="subsidy">subsidy:</label><br>
        <select id="subsidy" name="subsidy" required>
            <option value="" disabled selected>Select one</option>
            <option value="social_media">550</option>
            <option value="organizer">300</option>
            <option value="own">none</option>
        </select><br><br>

        <label for="heard_from">Heard From:</label><br>
        <select id="heard_from" name="heard_from" required>
            <option value="" disabled selected>Select one</option>
            <option value="social_media">Social Media</option>
            <option value="organizer">Organizer</option>
            <option value="own">Own</option>
            <option value="other">Other</option>
        </select><br><br>
        <div id="otherInput" style="display: none;">
    <label for="otherOption">Other (Please Specify):</label><br>
    <input type="text" id="otherOption" name="otherOption">
</div>

        <label for="payment"> Payment:</label><br>
        <input type="checkbox" name="90" id="90" value="90">
        <label for="90">90</label><br>
        <input type="checkbox" name="700" id="700" value="700">
        <label for="700">700</label><br><br>

        <input type="submit" name="submit" value="Register">
    </form>




            <script type="text/javascript" src="script.js"></script>
    <script src="js/main.js"></script>


    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>