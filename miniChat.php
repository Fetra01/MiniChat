<?php
if ((isset($_POST["pseudo"])) && (isset($_POST["message"]))){
     $pseudo=$_POST["pseudo"];
     $message=$_POST["message"];
}
else {
     $pseudo="";
     $message="";
}
/*Connection à la base de donnée*/
try {
  $bdd = new PDO('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', 'ADRAR1112', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (\Exception $e) {
  die("Erreur: ". $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="miniChat.css">
    <title>Mini-Chat</title>
  </head>
  <body>
    <header>
      <h1>MiniChat</h1>
    </header>
    <div class="hero">

        <form class="formFormul" action="miniChat.php" method="post">
          <div class="pseudoFormul">
            Pseudo  <input type="text" name="pseudo" value="" required>
          </div>
          <div class="messageFormul">
            Message  <textarea type="text" name="message" value="" required></textarea>
            <input type="submit" value="Envoyer">
          </div>

        </form>

     </div>
    <div class="">
      <table>
        <thead>
          <tr>
            <th>Pseudo</th>
            <th>message</th>
          </tr>
        </thead>
        <tbody>
          <?php

          /*Enregistrement dans la table de la base de donnée*/
          $req = $bdd -> prepare("INSERT INTO utilisateur (pseudo,message) Values (:pseudo,:message)");
          if ((isset($_POST["pseudo"])) && (isset($_POST["message"]))){
          $req -> execute(array("pseudo"=>htmlspecialchars($_POST["pseudo"]),"message"=>htmlspecialchars($_POST["message"])));
          }
          /*Récuperation des 10 derniers messages*/
          $rep = $bdd ->query("SELECT pseudo, message From utilisateur ORDER BY id DESC LIMIT 0,10");
          /*Affichage*/
          while($donnees=$rep->fetch()){
            echo"<tr>"."<td>"."<strong>".$donnees['pseudo']."</strong>"."</td>"."<td>".$donnees['message']."</td>"."</tr>";
          }
          $rep->closeCursor();

          ?>
        </tbody>
      </table>

    </div>

  </body>
</html>
