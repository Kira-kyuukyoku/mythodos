<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');
?>
<div id="menu-gauche">
<h3>Navigation</h3>

<nav class="nav">
<ul>
	<!--<li><a href="index.php">Accueil</a></li>-->
	<li><a href="index.php?comp=programme">Programme</a></li>
	<li><a href="index.php?comp=circuit">Circuit</a></li>
	<li><a href="index.php?comp=banniere">Banniere</a></li>
	<li><a href="index.php?comp=commentaire">Commentaire</a></li>
	<li><a href="index.php?comp=etape">Etape</a></li>
	<li><a href="index.php?comp=pays">Pays</a></li>
	<li><a href="index.php?comp=ville">Ville</a></li>
	<li><a href="index.php?comp=monument">Monument</a></li>
	<li><a href="index.php?comp=client">Client</a></li>
	<li><a href="index.php?comp=voyageur">Voyageur</a></li>
	<li><a href="index.php?comp=reservation">Réservation</a></li>
</ul>
</nav>



<form action="index.php?comp=user" method="post">
	<p>
		<input class="btn" type="submit" value="Déconnexion" />
		<input type="hidden" name="deconnexion" value="true" />
	</p>
</form>

</div>