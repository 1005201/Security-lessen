<?php
//injection voorbeeld: http://127.0.0.1/security/les2/profile.php?id=3;DELETE FROM profiles;
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

// als er een id is meegegeven via de get variabele
if(!empty($_GET["id"]))
{
	// haal het profiel op van betreffende id
	//$stmt = $pdo->query("SELECT * FROM profiles WHERE id = {$_GET["id"]}"); 
	$stmt = $pdo->prepare("SELECT * FROM profiles WHERE id = :id");
	$stmt->bindValue('id', $_GET["id"]);
	$stmt->execute();
	$profile = $stmt->fetch(PDO::FETCH_OBJ);

	echo "<h1>{$profile->verkoper}</h1>";
	echo "<p>Woont in {$profile->woonplaats}</p>";
}
else
{
	// anders een foutmelding tonen
	echo "Fout, geen ID meegegeven";
}