<?php

    //------------------------------------------------------------------------//
    define("ONLINE_DIR","http://viper.ussecurity.biz");
    define("CUR_DIR","/");
	
    define("APP_TITLE"     , "Viper System");
    define("DOCUMENT_ROOT" , $_SERVER['DOCUMENT_ROOT']);    
    define("IMG_URL"       , CUR_DIR . "images" );
    define("CSS_URL"       , CUR_DIR . "css" );
    define("JS_URL"        , CUR_DIR . "lib" );
    define("SSI_URL"       , CUR_DIR . "lib" );
    define("ADM_URL"       , CUR_DIR . "xnt-secure" );
    define("DIR"           , $_SERVER['DOCUMENT_ROOT']);
    define("IMG_DIR"       , DIR . IMG_URL);
    define("CSS_DIR"       , DIR . CSS_URL);
    define("JS_DIR"        , DIR . JS_URL);
    define("SSI_DIR"       , DIR . SSI_URL);
	

	define("DB_HOST"      , "localhost");
    define("DB_USER"      , "root");
    define("DB_PASS"      , "");
    define("DB_NAME"      , "ussecuri_viper");

   
/*     define("DB_HOST"      , "localhost");
    define("DB_USER"      , "ussecuri_viper");
    define("DB_PASS"      , "gfzq!F^Zu6#f");
    define("DB_NAME"      , "ussecuri_viper");
 */

    

    define("RSS_URL"		 , "http://feeds.reuters.com/reuters/businessNews");
	define("LOGO_IMAGE", IMG_URL . "logo.png");
	
    define("MAIL_CONT"    , "contacto@secmg.net");
    define("MAIL_PAGO"    , "pagos@secmg.net");
    define("MAIL_PARA"    , "info@secmg.net");
    define("MAIL_DE"      , "info@secmg.net");

    //------------------------------------------------------------------------//

    $DOCUMENT_ROOT 	= DOCUMENT_ROOT;
    $_APP_TITLE    	= APP_TITLE;
?>
