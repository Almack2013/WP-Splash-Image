<?php

/**
 * @author Benjamin Barbier
 *
 */
class WsiFront {

	/**
	 * Singleton
	 */
	private static $_instance = null;
	private function __construct() {}
	/**
	 * @return WsiFront
	 */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new WsiFront();
		} return self::$_instance;
	}
	
	/**
	 * @var int : value of cookie 'last_display' before update.
	 */
	private $last_display;
	
	/**
	 * Plug : Hooks functions to actions and filters.
	 * This is the only function to use to set up the back.
	 */
	public function plug() {
		add_action ( 'init',                array(&$this, 'wp_splash_image_front_init'));
		add_action ( 'wp_head',             array(&$this, 'wsi_addSplashImageWpHead' ));
		add_action ( 'wp_footer',           array(&$this, 'wsi_addSplashImageWpFooter' ));
		
		// custom hook for adding the "first load mode" to the template
		add_action ( 'wsi_first_load_mode', array($this, 'wsi_first_load_mode_div'));
	}
	
	/**
	 *
	 */
	public function wsi_first_load_mode_div() {

		// Chargement des données en base
		$siBean = SplashImageManager::getInstance()->get(1);
		
		// Si le plugin n'est pas activé dans ses options, on ne fait rien
		if($siBean->isSplash_active()!='true') return;
		
		// If not in First Load Mode, exit the function
		if ($siBean->isWsi_first_load_mode_active()!='true') return;
		
		// Si on est pas en "mode test", on effectue quelques tests supplémentaires
		if($siBean->isSplash_test_active()!='true') {
		
			// Si la Splash Image n'est pas dans sa plage de validité, on ne fait rien
			if (WsiCommons::getdate_is_in_validities_dates() == "false") return;
		
			// Si l'utilisateur n'a pas été inactif assez longtemps, on ne fait rien
			if(WsiCommons::enough_idle_to_splash($this->last_display)==false) return;
		
		}
		
		require("splash/noConflict.inc.php");
		require("splash/overlay.inc.php");
		require("splash/content.inc.php");
		
	}
	
	/**
	 * Init du Front end (Scripts + style)
	 */
	public function wp_splash_image_front_init() {
	
		if (!is_admin()) {
	
			// On stocke le timestamp du dernier affichage et on le met à jour.
			$this->last_display = $_COOKIE['last_display'];
			setCookie('last_display',time(),time()+24*3600);
			
			// Déclaration des styles de la partie front end.
			wp_register_style('overlay-basic', WsiCommons::getURL().'/style/jqueryTools/overlay-basic.css'); /*Style pour la splash image */
	
			// Déclaration des scripts de la partie front end.
			wp_register_script('jquery.tools.front', WsiCommons::getURL().'/js/jQueryTools/jquery.tools.min.wp-front.js'); /*[overlay, toolbox.expose]*/
	
			// JQuery (wordpress version)
			wp_enqueue_script('jquery');
			
			// JQuery Tools
			wp_enqueue_script('jquery.tools.front', false, array('jquery'));
			
			// Chargement des styles du front end.
			wp_enqueue_style('overlay-basic');
	
		}
		
	}
	
	/**
	 * Fontion utililée dans le blog (dans le head)
	 */
	public function wsi_addSplashImageWpHead() {
		
		// Chargement des données en base
		$siBean = SplashImageManager::getInstance()->get(1);
		
		// Si le plugin n'est pas activé dans ses options, on ne fait rien
		if($siBean->isSplash_active()!='true') return;
		
		// If not in First Load Mode, exit the function
		if ($siBean->isWsi_first_load_mode_active()=='true') return;
		
		// Si on est pas en "mode test", on effectue quelques tests supplémentaires
		if($siBean->isSplash_test_active()!='true') {

			// Si la Splash Image n'est pas dans sa plage de validité, on ne fait rien
			if (WsiCommons::getdate_is_in_validities_dates() == "false") return;
			
			// Si l'utilisateur n'a pas été inactif assez longtemps, on ne fait rien
 			if(WsiCommons::enough_idle_to_splash($this->last_display)==false) return;
			
		}

		require("splash/noConflict.inc.php");
		require("splash/overlay.inc.php");
		
	}
	
	/**
	 * Fontion utililée dans le blog (dans le footer)
	 */
	public function wsi_addSplashImageWpFooter() {
	
		// Chargement des données en base
		$siBean = SplashImageManager::getInstance()->get(1);
		
		// Si le plugin n'est pas activé dans ses options, on ne fait rien
		if($siBean->isSplash_active()!='true') return;
		
		// If not in First Load Mode, exit the function
		if ($siBean->isWsi_first_load_mode_active()=='true') return;
	
		// Si on est pas en "mode test", on effectue quelques tests supplémentaires
		if($siBean->isSplash_test_active()!='true') {
		
			// Si la Splash Image n'est pas dans sa plage de validité, on ne fait rien
			if (WsiCommons::getdate_is_in_validities_dates() == "false") return;
	
			// Si l'utilisateur n'a pas été inactif assez longtemps, on ne fait rien
 			if(WsiCommons::enough_idle_to_splash($this->last_display)==false) return;
	
		}

		require("splash/content.inc.php");
		
	}
} 
?>