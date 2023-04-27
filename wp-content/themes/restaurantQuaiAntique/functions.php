<?php

//GESTION DE L'ADMIN
//add_action('template_redirect', 'addMenuForm');
add_action('admin_init', 'addMenuForm');

// FIN GESTION DE L'ADMIN

//MENU ADMIN
add_action('admin_menu', 'sidebarAdminQuaiAntique');
add_action('admin_bar_menu', 'topbarAdminQuaiAntique', 999);
//FIN MENU ADMIN

//AJOUT DE SCRIPTS ET CSS
add_action('admin_enqueue_scripts', 'scriptAdmin');
add_action('wp_enqueue_scripts', 'quai_antique_scripts');
//FIN AJOUT DE SCRIPTS ET CSS


add_action('after_setup_theme', 'includeFiles');
add_action('after_setup_theme', 'setTables');//CREATION DES TABLES PERSONNALISEES
add_action('after_setup_theme', 'quai_antique_supports'); //THEME OPTIONS


//NAVIGATION - MENU
add_filter('nav_menu_css_class', 'quai_antique_menu_class');
add_filter('nav_menu_link_attributes', 'quai_antique_menu_links_attr');
//FIN NAVIGATION - MENU


//AJAX
add_action( 'wp_ajax_switch_ajax', 'switch_ajax' );
//FIN AJAX



function dbrDie($var) { echo '<pre>'. print_r($var, true).'</pre>'; die(); }

/** ADMIN SIDEBAR */
function sidebarAdminQuaiAntique()
{
    add_menu_page(
        'Restaurant Quai Antique Param',
        'QuaiAntiqueParam',
        'manage_options',
        'QuaiAntiqueParam',
        'quaiAntiqueParamPage',
        'dashicons-food');

}
/** END OF ADMIN SIDEBAR */


/** ADMIN TOPBAR */
function topbarAdminQuaiAntique($wp_admin_bar)
{
    //TODO mettre l'ico dans la top bar du back sinon il faut la mettre dans le css additionnel du thème aussi
    //'meta' => array('html' => '<span class="dashicons  dashicons-before dashicons-food"></span>')
    $admin_topbar = array(
        'id' => 'QuaiAntique',
        'title' => 'QuaiAntiqueParam',
        'href' => admin_url('admin.php?page=QuaiAntiqueParam')
    );
    $wp_admin_bar->add_node($admin_topbar);
}
/** END OF ADMIN TOPBAR */





function addMenuForm()
{

    if(isset($_POST['add-menu-key']) && isset($_POST['add-menu'])){

        if($_POST['add-menu-key'] !== 'addMenuRestaurantBackOffice') return;
        try{
            $oRestaurantMenus = new RestaurantMenus();
            $oMenu = new RestaurantMenu($_POST['inpTitleMenu']);
            $mResult = $oRestaurantMenus->getByWhere(array('title' => $oMenu->getTitle()));
            if(is_array($mResult) && count($mResult) > 0)
            {
                dbrDie($mResult);
                //Ce menu existe déjà
            }
            else RestaurantMenus::getInstance()->add($oMenu); //On l'ajoute
        } catch(Exception $e){
            echo $e->getMessage();
            die('<br/><br/><a href="' . header(wp_get_referer()) .'">Retour</a>');
        }
    }
}





/* AJOUT SCRIPTS & CSS */
function scriptAdmin()
{
    wp_enqueue_style('adminstyle', get_template_directory_uri() . '/style/styleAdmin.css');
    wp_enqueue_style('backoffice', get_template_directory_uri() . '/style/styleBackoffice.css');

    wp_enqueue_script('main_script', get_template_directory_uri() . '/script/main_script.js');
    wp_enqueue_script('param_check', get_template_directory_uri() . '/script/param/ParamCheck.js');
    wp_enqueue_script('param_check_int', get_template_directory_uri() . '/script/param/ParamIntCheck.js');
    wp_enqueue_script('param_check_string', get_template_directory_uri() . '/script/param/ParamStrCheck.js');
    wp_enqueue_script('param_check_object', get_template_directory_uri() . '/script/param/ParamObjCheck.js');
}
function quai_antique_scripts()
{
    //JQUERY
    //On désinstalle jquery pour le remettre derrière on évite les conflits
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.4.js');

    //BOOTSTRAP
    wp_enqueue_style('bootstrapcss', "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css");
    wp_enqueue_script('bootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', array('jquery'), false, true);

    //CSS
    wp_enqueue_style('maincss', get_template_directory_uri() . '/style/style.css');
}
/* FIN SCRIPTS & CSS */

function includeFiles()
{
    //Classes utilitaires
    require_once('src/tools/JsonAnswer.php');
    require_once('src/tools/PDOSingleton.php');

    //Classes utilitaires pour les paramètres
    require_once 'src/tools/ParamCheck.php';
    require_once 'src/tools/ParamException.php';
    require_once 'src/tools/ParamArray.php';
    require_once 'src/tools/ParamBool.php';
    require_once 'src/tools/ParamFloat.php';
    require_once 'src/tools/ParamInt.php';
    require_once 'src/tools/ParamObject.php';
    require_once 'src/tools/ParamString.php';

    //Pour les requêtes AJAX
    require_once('src/ajax/admin-ajax.php');

    //Classes métiers
    require_once('src/ManagerObjTable.php');
    require_once('src/Booking.php');
    require_once('src/Bookings.php');
    require_once('src/Client.php');
    require_once('src/Clients.php');
    require_once('src/DishType.php');
    require_once('src/DishTypes.php');
    require_once('src/FoodDish.php');
    require_once('src/FoodDishes.php');
    require_once('src/OpeningTime.php');
    require_once('src/OpeningTimes.php');
    require_once('src/RestaurantMenu.php');
    require_once('src/RestaurantMenus.php');
    require_once('src/RestaurantMenuOption.php');
    require_once('src/RestaurantMenuOptions.php');

    //Controllers
    require_once('src/controller/backoffice.php');


}


//INIT TABLES BDD
function setTables()
{
    Bookings::getInstance()->createTable();
    Clients::getInstance()->createTable();
    DishTypes::getInstance()->createTable();
    FoodDishes::getInstance()->createTable();
    OpeningTimes::getInstance()->createTable();
    RestaurantMenus::getInstance()->createTable();
    RestaurantMenuOptions::getInstance()->createTable();
}
// FIN INIT TABLES BDD


//GESTION DE LA NAVIGATION
function quai_antique_menu_class($aClass)
{
    $aClass[] = 'nav-item';
    return $aClass;
}

function quai_antique_menu_links_attr($aAttr)
{
    $aAttr['class'] = 'nav-link';
    return $aAttr;
}

function quai_antique_supports()
{
    //NAV
    add_theme_support('menus');
    register_nav_menu('header', 'top-menu');

    //LOGO
    add_theme_support('custom-logo', array('height' => 480, 'width' => 720));
    add_theme_support('title-tag');
}
// FIN GESTION DE LA NAVIGATION







































