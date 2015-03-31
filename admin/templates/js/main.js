jQuery(function($){

	// ALERTE
	var alert = $('#alert'); 
	if(alert.length > 0){
		alert.hide().slideDown(500);
		alert.find('.close').click(function(e){
			e.preventDefault();
			alert.slideUp();
		})
	}
	
	// Lightbox
	$(".colorbox").colorbox({rel:'colorbox', transition:"fade"});
	
	
	// CALENDRIER
	// Traduction calendrier
	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: 'Précédent',
		nextText: 'Suivant',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin',
		'Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
		monthNamesShort: ['Janv.','Févr.','Mars','Avril','Mai','Juin',
		'Juil.','Août','Sept.','Oct.','Nov.','Déc.'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim.','Lun.','Mar.','Mer.','Jeu.','Ven.','Sam.'],
		dayNamesMin: ['D','L','M','M','J','V','S'],
		weekHeader: 'Sem.',
		dateFormat: 'dd-mm-yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
		// Initialisation calendrier
		$( ".datepicker" ).datepicker({
			showOn: "button",
			buttonImage: "../images/calendar.gif",
			buttonImageOnly: true
		});

});



   /**** Verification Js pour formulaire ****/
	/** Regex de controle email **/
	var myRegex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
	var dateFrRegex = /^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$/;


function verifProgramme(formulaire) {
	var valid = true;
	var message = "<b>Erreur pour les champs suivants : </b><ul>";
	
		if (formulaire.date_dep.value == '' ) { 
			valid = false;
			message += "<li>La date doit être renseigner.</li>";
		} 
		if ( !dateFrRegex.test(formulaire.date_dep.value) ) { 
			valid = false;
			message += "<li>Le format de la date n'est pas valide.</li>";
		} 
		if ( !isNaN(formulaire.nb_places.value) && formulaire.nb_places.value == '' ) { 
			valid = false;
			message += "<li>Veillez préciser le nombre de place.</li>";
		}
		if (formulaire.num_cir.value == 0 ) { 
			valid = false;
			message += "<li>Vous devez séléctionner un circuit.</li>";
		}

		// Affichage du/des message(s)
		if (valid) {
				return true;
			}
		if (!valid) {
				document.getElementById("resultat").innerHTML = message + "</ul>";
				return false;
			}
}
	
