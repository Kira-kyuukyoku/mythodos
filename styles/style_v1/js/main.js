jQuery(function($){
				// Carousel jquery
				$('#slider').carouFredSel({
					width: '100%',
					align: false,
					items: 5,
					items: {
						width: $('#wrapper').width() * 0.15,
						height: 500,
						visible: 1,
						minimum: 1
					},
					scroll: {
						items: 1,
						timeoutDuration : 10000,
						onBefore: function(data) {
			
							//	find current and next slide
							var currentSlide = $('.slide.active', this),
								nextSlide = data.items.visible,
								_width = $('#wrapper').width();
			
							//	resize currentslide to small version
							currentSlide.stop().animate({
								width: _width * 0.15
							});		
							currentSlide.removeClass( 'active' );
			
							//	hide current block
							data.items.old.add( data.items.visible ).find( '.slide-block' ).stop().fadeOut();					
			
							//	animate clicked slide to large size
							nextSlide.addClass( 'active' );
							nextSlide.stop().animate({
								width: _width * 0.7
							});						
						},
						onAfter: function(data) {
							//	show active slide block
							data.items.visible.last().find( '.slide-block' ).stop().fadeIn();
						}
					},
					onCreate: function(data){
			
						//	clone images for better sliding and insert them dynamacly in slider
						var newitems = $('.slide',this).clone( true ),
							_width = $('#wrapper').width();

						$(this).trigger( 'insertItem', [newitems, newitems.length, false] );
			
						//	show images 
						$('.slide', this).fadeIn();
						$('.slide:first-child', this).addClass( 'active' );
						$('.slide', this).width( _width * 0.15 );
			
						//	enlarge first slide
						$('.slide:first-child', this).animate({
							width: _width * 0.7
						});
			
						//	show first title block and hide the rest
						$(this).find( '.slide-block' ).hide();
						$(this).find( '.slide.active .slide-block' ).stop().fadeIn();
					}
				});
			
				//	Handle click events
				$('#slider').children().click(function() {
					$('#slider').trigger( 'slideTo', [this] );
				});
			
				//	Enable code below if you want to support browser resizing
				$(window).resize(function(){
			
					var slider = $('#slider'),
						_width = $('#wrapper').width();
			
					//	show images
					slider.find( '.slide' ).width( _width * 0.15 );
			
					//	enlarge first slide
					slider.find( '.slide.active' ).width( _width * 0.7 );
			
					//	update item width config
					slider.trigger( 'configuration', ['items.width', _width * 0.15] );
				});
				
				
				

	// ALERTE
	var alert = $('#alert'); 
	if(alert.length > 0){
		alert.hide().slideDown(500);
		alert.find('.close').click(function(e){
			e.preventDefault();
			alert.slideUp();
		})
	}
	
	// SLIDESHOW
	$(".colorbox").colorbox({rel:'colorbox', slideshow:true});
	
	
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
			buttonImage: "./images/calendar.gif",
			buttonImageOnly: true
		});

});


   /**** Verification Js pour formulaire ****/
	/** Regex de controle email **/
	var myRegex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;


function verifContact(formulaire) {
	var valid = true;
	var message = "<b>Erreur pour les champs suivants : </b><ul>";
	
	// Fonction Tiny MCE qui bascule le contenu de l'iframe vers mon textarea
	tinyMCE.triggerSave(true, true);
	
		if(formulaire.objet.value == '' ) { // Si le champ n'est pas renseigner
			valid = false;
			message += "<li>Le champ objet doit être rempli.</li>";
		} 
		if (formulaire.pseudo.value == '' ) { 
			valid = false;
			message += "<li>Le champ pseudo doit être rempli.</li>";
		} 
		if (formulaire.email.value == '' ) { 
			valid = false;
			message += "<li>Le champ email doit être rempli.</li>";
		} 
		if ( !myRegex.test(formulaire.email.value) ) { 
			valid = false;
			message += "<li>L'email n'est pas valide.</li>";
		} 
		if (formulaire.des.value == 0 || formulaire.des.value == '' ) { 
			valid = false;
			message += "<li>Vous devez renseigner la personne à contacter.</li>";
		}
		if (formulaire.message.value.length < 6 ) { 
			valid = false;
			message += "<li>Le champ message est vide !</li>";
		}
		if (formulaire.code.value == '' ) { 
			valid = false;
			message += "<li>Le captcha doit être renseigner.</li>";
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
	
	
function verifClient(formulaire) {
	var valid = true;
	var message = "<b>Erreur pour les champs suivants : </b> <ul>";
	
		if (formulaire.civ_cli.value != 1 || formulaire.civ_cli.value != 2 ) { 
			valid = false;
			message += "<li>Vous devez renseigner le champ civilité.</li>";
		}
		if(formulaire.nom_cli.value == '' ) { // Si le champ n'est pas renseigner
			valid = false;
			message += "<li>Le champ nom doit être rempli.</li>";
		} 
		if (formulaire.pren_cli.value == '' ) { 
			valid = false;
			message += "<li>Le champ prénom doit être rempli.</li>";
		} 
		if (formulaire.tel_cli.value == '' ) { 
			valid = false;
			message += "<li>Le champ téléphone doit être rempli.</li>";
		} 
		if (formulaire.mail_cli.value == '' || !myRegex.test(formulaire.mail_cli.value) ) { 
			valid = false;
			message += "<li>Le champ email doit être rempli avec une adresse valide.</li>";
		} 
		if (formulaire.emailConfirm.value.length == '' || ! emailValid(formulaire.emailConfirm.value) || formulaire.mail_cli.value != formulaire.emailConfirm.value) {
			valid = false;
			message += "<li>L'email de confirmation n'est pas valide.</li>";
		}
		if (formulaire.ad_cli.value == '' || formulaire.ville_cli.value == '' || formulaire.cp_cli.value == '' || formulaire.pays_cli.value == '') { 
			valid = false;
			message += "<li>Vous devez renseigner votre adresse compléte.</li>";
		}
		if (formulaire.paiement.value != 1 || formulaire.paiement.value != 2 ) { 
			valid = false;
			message += "<li>Vous devez présiser votre mode de réglement.</li>";
		} 
		
		
	if ( !formulaire.cgv.checked) {
			valid = false;
			message += "<li>Vous devez accepter les conditions générales de vente.</li>";
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
