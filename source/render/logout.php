<?php session_start(); 
 
if (isset($_SESSION['username'])){
    unset($_SESSION['username']); 
}
?>
<meta http-equiv="refresh" content="0;URL=http://localhost/ProjetIPS/" />
<a href="http://localhost/ProjetIPS/">Page d'aceuil</a>