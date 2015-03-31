<?php
class Session{

	public function __construct(){
		session_start(); 
	}

	public function setFlash($message,$type = 'danger',$link){
		$_SESSION['flash'] = array(
			'message' => $message,
			'type'	  => $type
		);
		header('Location:'.$link);
		exit();
	}

	public function flash(){
		if(isset($_SESSION['flash'])){
			?>
			<div id="alert" class="alert alert-<?php echo $_SESSION['flash']['type']; ?>">
				<a class="close">x</a>
				<?php echo $_SESSION['flash']['message']; ?>
			</div>
			<?php
			unset($_SESSION['flash']); 
		}
	}
	
	public function saveForm(){	
		/** Garde en mémoire les valeurs POST et FILES **/
		$_SESSION['sauvegarde'] 		= $_POST;
		$_SESSION['sauvegardeFILES'] 	= $_FILES;
	}

	public function form(){
		if(isset($_SESSION['sauvegarde']) OR isset($_SESSION['sauvegardeFILES']) ){
			$_POST	= $_SESSION['sauvegarde'];
			$_FILES = $_SESSION['sauvegardeFILES'];

			unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
		}
	}
	
	public function detroyForm(){
		if(isset($_SESSION['sauvegarde']) OR isset($_SESSION['sauvegardeFILES']) ){

			unset($_SESSION['sauvegarde'], $_SESSION['sauvegardeFILES']);
		}
	}

}