<?php

/**
 * @author Benjamin Barbier
 *
 */
class SplashImageManager {
	
	/**
	 * Singleton
	 */
	private static $_instance = null;
	private function __construct() {}
	/**
	 * @return SplashImageManager instance
	 */
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new SplashImageManager();
		} return self::$_instance;
	}
	
	private $splashImageBean;
	
	/**
	 * @param SplashImageBean $splashImageBean
	 */
	public function save(SplashImageBean $splashImageBean) {
		
		update_option('url_splash_image',        $splashImageBean->getUrl_splash_image());
		update_option('splash_image_width',      $splashImageBean->getSplash_image_width());
		update_option('splash_image_height',     $splashImageBean->getSplash_image_height());
		update_option('splash_color',            $splashImageBean->getSplash_color());
		update_option('datepicker_start',        $splashImageBean->getDatepicker_start());
		update_option('datepicker_end',          $splashImageBean->getDatepicker_end());
		update_option('wsi_display_time',        $splashImageBean->getWsi_display_time());
		update_option('wsi_picture_link_url',    $splashImageBean->getWsi_picture_link_url());
		update_option('wsi_picture_link_target', $splashImageBean->getWsi_picture_link_target());
		update_option('wsi_type',                $splashImageBean->getWsi_type());
		update_option('wsi_opacity',             $splashImageBean->getWsi_opacity());
		update_option('wsi_idle_time',           ($splashImageBean->getWsi_idle_time()=='')?0:$splashImageBean->getWsi_idle_time());
		
		// Gestion des booleans
		update_option('splash_active',             ($splashImageBean->isSplash_active())?'true':'false');
		update_option('splash_test_active',        ($splashImageBean->isSplash_test_active())?'true':'false');
		update_option('wsi_close_esc_function',    ($splashImageBean->isWsi_close_esc_function())?'true':'false');
		update_option('wsi_hide_cross',            ($splashImageBean->isWsi_hide_cross())?'true':'false');
		update_option('wsi_disable_shadow_border', ($splashImageBean->isWsi_disable_shadow_border())?'true':'false');
		update_option('wsi_youtube_autoplay',      ($splashImageBean->isWsi_youtube_autoplay())?'true':'false');
		update_option('wsi_youtube_loop',          ($splashImageBean->isWsi_youtube_loop())?'true':'false');
		update_option('wsi_fixed_splash',          ($splashImageBean->isWsi_fixed_splash())?'true':'false');
		
		// Valeurs des onglets
		update_option('wsi_youtube',     $splashImageBean->getWsi_youtube());
		update_option('wsi_yahoo',       $splashImageBean->getWsi_yahoo());
		update_option('wsi_dailymotion', $splashImageBean->getWsi_dailymotion());
		update_option('wsi_metacafe',    $splashImageBean->getWsi_metacafe());
		update_option('wsi_swf',         $splashImageBean->getWsi_swf());
		update_option('wsi_html',        $splashImageBean->getWsi_html());
		
	}
	
	/**
	 * @return SplashImageBean with "esc_attr" security on each property.
	 */
	public function get() {
		
		if (!isset($splashImageBean)) {
			
			$splashImageBean = new SplashImageBean();
			
			$splashImageBean->setUrl_splash_image(          esc_attr(get_option('url_splash_image')));
			$splashImageBean->setSplash_image_width(        esc_attr(get_option('splash_image_width')));
			$splashImageBean->setSplash_image_height(       esc_attr(get_option('splash_image_height')));
			$splashImageBean->setSplash_color(              esc_attr(get_option('splash_color')));
			$splashImageBean->setDatepicker_start(          esc_attr(get_option('datepicker_start')));
			$splashImageBean->setDatepicker_end(            esc_attr(get_option('datepicker_end')));
			$splashImageBean->setWsi_display_time(          esc_attr(get_option('wsi_display_time')));
			$splashImageBean->setWsi_picture_link_url(      esc_attr(get_option('wsi_picture_link_url')));
			$splashImageBean->setWsi_picture_link_target(   esc_attr(get_option('wsi_picture_link_target')));
			$splashImageBean->setWsi_type(                  esc_attr(get_option('wsi_type')));
			$splashImageBean->setWsi_opacity(               esc_attr(get_option('wsi_opacity')));
			$splashImageBean->setWsi_idle_time(             esc_attr(get_option('wsi_idle_time')));
			$splashImageBean->setSplash_active(             esc_attr(get_option('splash_active')));
			$splashImageBean->setSplash_test_active(        esc_attr(get_option('splash_test_active')));
			$splashImageBean->setWsi_close_esc_function(    esc_attr(get_option('wsi_close_esc_function')));
			$splashImageBean->setWsi_hide_cross(            esc_attr(get_option('wsi_hide_cross')));
			$splashImageBean->setWsi_disable_shadow_border( esc_attr(get_option('wsi_disable_shadow_border')));
			$splashImageBean->setWsi_youtube_autoplay(      esc_attr(get_option('wsi_youtube_autoplay')));
			$splashImageBean->setWsi_youtube_loop(          esc_attr(get_option('wsi_youtube_loop')));
			$splashImageBean->setWsi_fixed_splash(          esc_attr(get_option('wsi_fixed_splash')));
			$splashImageBean->setWsi_youtube(               esc_attr(get_option('wsi_youtube')));
			$splashImageBean->setWsi_yahoo(                 esc_attr(get_option('wsi_yahoo')));
			$splashImageBean->setWsi_dailymotion(           esc_attr(get_option('wsi_dailymotion')));
			$splashImageBean->setWsi_metacafe(              esc_attr(get_option('wsi_metacafe')));
			$splashImageBean->setWsi_swf(                   esc_attr(get_option('wsi_swf')));
			$splashImageBean->setWsi_html(                  esc_attr(get_option('wsi_html')));
			
		}
		return $splashImageBean;
	}
	
	/**
	 * @return string
	 */
	public function getInfos() {
		$wsiInfos;
		foreach (WsiCommons::getOptionsList() as $option) {
			$wsiInfos.= $option.": ".get_option($option)."\n";
		}
		return $wsiInfos;
	}
	
	/**
	 * Remise de toutes les options aux valeurs par défaut
	 */
	public function reset() {
		foreach (WsiCommons::getDefaultValues() as $option => $defaultValue) {
			update_option($option, $defaultValue);
		}
	}
	
	/**
	 * Supprime les options du plugin.
	 * TODO: use this method in UninstallAction 
	 */
	public function delete() {
		foreach (WsiCommons::getOptionsList() as $option) {
			delete_option($option);
		}
	}
	
}

?>