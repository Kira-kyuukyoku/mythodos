<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');
?>

	</div> <!-- Ferme id=content -->
	
<div class="clear"></div>

</div> <!-- Ferme id=page -->

	<footer><div class="site-info">Administration Mythodos. Designé et Développé par iCNAM.</div></footer>

    <script type="text/javascript" src="templates/js/jquery.js"></script>
	<script type="text/javascript" src="templates/js/jquery.ui.core.js"></script>
	<script type="text/javascript" src="templates/js/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="templates/js/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="templates/js/jquery-migrate.js"></script>
	<script type="text/javascript" src="templates/js/jquery.colorbox-min.js"></script>
    <script type="text/javascript" src="templates/js/main.js"></script>
	<script type="text/javascript" src="templates/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
	width: "90%",
	language : "fr_FR",
	
	// retire le <p> par defaut
	forced_root_block : false,
	force_br_newlines : true,
	force_p_newlines : false
 });
</script>
</body>
</html>