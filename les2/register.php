<?php
// Start a session to store the CAPTCHA value
session_start();

// Generate a random CAPTCHA word
function generateRandomWord($length = 6)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomWord = '';
    for ($i = 0; $i < $length; $i++) {
        $randomWord .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomWord;
}

$correctCaptcha = generateRandomWord();

// maak een database connectie
$host = '127.0.0.1';
$db   = 'security_les2';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (!empty($_POST)) {
    // Check if 'captcha' is set in $_POST
    if (isset($_POST['captcha'])) {
        // Verify the CAPTCHA value
        if ($_POST['captcha'] === $_SESSION['captcha']) {
            // CAPTCHA is correct, proceed with the form submission
            $stmt = $pdo->prepare("INSERT INTO profiles (verkoper, woonplaats) VALUES (:verkoper, :woonplaats)");
            $stmt->bindValue('verkoper', $_POST["verkoper"]);
            $stmt->bindValue('woonplaats', $_POST['woonplaats']);
            $stmt->execute();
            echo "<h1>Registreren</h1>";
            echo "Registration successful!";
        } else {
            // CAPTCHA is incorrect, show an error message
            echo "<h1>Registreren</h1>";
            echo "CAPTCHA verification failed. Please try again.";
        }
    } else {
        // 'captcha' is not set in $_POST
        echo "<h1>Registreren</h1>";
        echo "CAPTCHA value is missing. Please try again.";
    }
}

// Display the CAPTCHA challenge in the form
echo "<h1>Registreren</h1>";
echo "<form method=\"POST\">
Uw naam<br />
<input type=\"text\" name=\"verkoper\"><br />
Uw plaats<br />
<input type=\"text\" name=\"woonplaats\"><br />
CAPTCHA: Enter the following word: <strong>$correctCaptcha</strong> <input type=\"text\" name=\"captcha\"><br />
<input type=\"submit\">
</form>";

// Store the correct CAPTCHA value in the session
$_SESSION['captcha'] = $correctCaptcha;
?>
