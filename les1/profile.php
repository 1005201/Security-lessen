<?php
// maak een database connectie
$host = '127.0.0.1';
$db   = 'security_les1';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
     $pdo = new PDO($dsn, $user, $pass);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// als er een id is meegegeven via de get variabele
if(!empty($_GET["id"]))
{
    // Haal het profiel op van de betreffende id
    $id = $_GET["id"];

    // Voorbereide query om SQL-injectie te voorkomen
    $stmt = $pdo->prepare("SELECT * FROM profiles WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Haal het profiel op
    $profile = $stmt->fetch(PDO::FETCH_OBJ);

    if ($profile) {
        echo "<h1>{$profile->verkoper}</h1>";
        echo "<p>Woont in {$profile->woonplaats}</p>";
    } else {
        // Geen overeenkomende records gevonden
        echo "Geen profiel gevonden voor het opgegeven ID";
    }

}
else
{
	// anders een foutmelding tonen
	echo "Fout, geen ID meegegeven";
}