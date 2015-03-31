<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');
?>

<div id="comment">
<h4>Commentaires</h4>
<?php
	if( !count($liste_comment) )
	{
		echo '<p>Aucun commentaire pour ce circuit. Soyez le premier à donner votre avis.</p>';
	}
	else
	{

		foreach ($liste_comment as $item) : 
			$num_com 		= intval($item['num_com']);
			$purifier 		= new HTMLPurifier();
			$mess_com 		= $purifier->purify($item['mess_com']);
			$pseudo_com 	= stripslashes(htmlspecialchars( $item['pseudo_com'] ));
			$date_com 		= stripslashes(htmlspecialchars( $item['date_com'] ));
?>
	#<?php echo $num_com . ' - ' . $pseudo_com; ?><br />
	<b>Commentaire : </b><?php echo $mess_com; ?> <br />
	<b>Date :</b> <?php echo $date_com; ?><br /><br />

<?php
		endforeach;
} // fin else commentaire
?>

<h3>Donner votre avis</h3>
     <div id="formulaire">
     <form method="post" action="index.php?mod=<?php echo $mod; ?>&amp;id=<?php echo $id; ?>&amp;action=postComment">
                 <p><label>* Pseudo : </label>
                 <input type="text" size="25" name="pseudo_com" /></p>

                 <p><label>* Commentaire : </label></td>  
                 <textarea name="mess_com" rows="8" cols="40"></textarea></p>
				 
                 <p><label>* Vérification : </label>
                 <input type="text" size="25" name="captcha" maxlength="5" />
			     <img src="includes/captcha/captcha.php" width="85" height="25" class="captcha" alt="Captcha" /></p>
				 
				 <input type="hidden" name="num_cir" value="<?php echo $id; ?>" />
                 <input type="submit" value="Envoyer" />
                 <input type="reset" name="reset" value="Effacer" />
     </form>
     </div>

</div>

</div> <!-- ferme singlerectangle --> 