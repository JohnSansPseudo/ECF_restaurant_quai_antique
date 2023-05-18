<?php
session_start();
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
add_action('after_setup_theme', 'initPage');
add_action('after_setup_theme', 'quai_antique_supports');//THEME OPTIONS
add_action( 'init', 'register_my_menus' );

//NAVIGATION - MENU
add_filter('nav_menu_css_class', 'quai_antique_menu_class');
add_filter('nav_menu_link_attributes', 'quai_antique_menu_links_attr');
//FIN NAVIGATION - MENU

//BACKOFFICE - ROUTEUR AJAX
add_action('wp_ajax_root_ajax', 'root_ajax');
add_action('wp_ajax_nopriv_root_ajax', 'root_ajax');

//BACKOFFICE - GESTION DE L'ADMIN
add_action('admin_init', 'addMenu');
add_action('admin_init', 'deleteMenu');
add_action('admin_init', 'addMenuOption');
add_action('admin_init', 'deleteMenuOption');
add_action('admin_init', 'addDishType');
add_action('admin_init', 'deleteDishType');
add_action('admin_init', 'addFoodDish');
add_action('admin_init', 'deleteFoodDish');
add_action('admin_init', 'addMediaImgFile');

//FRONT
add_action('template_redirect', 'addClient');
add_action('template_redirect', 'decoClient');
add_action('template_redirect', 'connexionClient');
add_action('template_redirect', 'bookTable');

//TEST
add_action('after_setup_theme', 'testLauncher');


function testLauncher()
{
    //dbrDie($_SESSION);
    //   /!\You have to comment "header('Location:...')" in each file you need

    /*$oTestCreateAccount = new TestCreateAccount();
    $oTestCreateAccount->mainTestCreateAccount();*/

    /*$oTestConn = new TestConnexionClient();
    $oTestConn->testMainConnexionClient();*/
}

//FRONT - MENU
function register_my_menus() {
    register_nav_menus(
        array(
            'header_menu' => __( 'top-menu' ),
            'footer-menu' => __( 'bottom-menu' ),
        )
    );
}



//CREATION DES PAGES
function initPage()
{
    $oPageWorpress = new PageWordpress();
    $oPageWorpress->initPage();
}

//FRONT - GESTION DE LA NAVIGATION
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

    //LOGO
    add_theme_support('custom-logo', array('height' => 480, 'width' => 720));
    add_theme_support('title-tag');
}
// FIN GESTION DE LA NAVIGATION


/* BACKOFFICE POUR LA PAGE NB GUEST */
add_action("admin_init", "guest_max_section_settings");
function guest_max_section_settings()
{
    // Création d'une section
    add_settings_section("guest_max_section", "", null, "QuaiAntiqueParam");

    // Création de champs
    add_settings_field("guest_max_qty", "", "guest_max_qty_html", "QuaiAntiqueParam", "guest_max_section");

    // Enregistrement des champs
    register_setting("guest_max_section", "guest_max");
}

function guest_max_qty_html()
{ ?>
    <div class="elf">
        <label for="guest_max">Nombre de clients maximum</label>
        <input type="number" name="guest_max" value="<?php echo Bookings::getNbGuestsMax(); ?>">
    </div>
<?php }
/* FIN POUR LA PAGE NB GUEST */

/** BACKOFFICE - ADMIN SIDEBAR */
function sidebarAdminQuaiAntique()
{
    add_menu_page(
        'Restaurant Quai Antique Param',
        'QuaiAntiqueParam',
        'manage_options',
        'QuaiAntiqueParam',
        'root_backoffice',
        'dashicons-food');
}

/** BACKOFFICE - ADMIN TOPBAR */
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



/* AJOUT SCRIPTS & CSS */
function scriptAdmin()
{
    wp_enqueue_script('param_check', get_template_directory_uri() . '/script/tool/param/ParamCheck.js');
    wp_enqueue_script('param_check_int', get_template_directory_uri() . '/script/tool/param/ParamIntCheck.js');
    wp_enqueue_script('param_check_string', get_template_directory_uri() . '/script/tool/param/ParamStrCheck.js');
    wp_enqueue_script('param_check_object', get_template_directory_uri() . '/script/tool/param/ParamObjCheck.js');
    wp_enqueue_script('toast_alert', get_template_directory_uri() . '/script/tool/ToastAlert.js');
    wp_enqueue_script('main_script', get_template_directory_uri() . '/script/main_script.js');

    wp_enqueue_style('adminstyle', get_template_directory_uri() . '/style/styleAdmin.css');
    wp_enqueue_style('backoffice', get_template_directory_uri() . '/style/styleBackoffice.css');
    wp_enqueue_style('toast_alert', get_template_directory_uri() . '/style/ToastAlert.css');

}

function quai_antique_scripts()
{
    //JS
    //JQUERY
    //On désinstalle jquery pour le remettre derrière on évite les conflits
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.4.js');

    //BOOTSTRAP
    wp_enqueue_script('bootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap-datepicker', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js');

    wp_enqueue_style('bootstrapcss', "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css");
    wp_enqueue_style('bootstrap-datepicker', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css');

    //CSS
    wp_enqueue_style('maincss', get_template_directory_uri() . '/style.css');

    //JS
    wp_enqueue_script('param_check', get_template_directory_uri() . '/script/tool/param/ParamCheck.js');
    wp_enqueue_script('param_check_int', get_template_directory_uri() . '/script/tool/param/ParamIntCheck.js');
    wp_enqueue_script('param_check_string', get_template_directory_uri() . '/script/tool/param/ParamStrCheck.js');
    wp_enqueue_script('param_check_object', get_template_directory_uri() . '/script/tool/param/ParamObjCheck.js');
    wp_enqueue_script('toast_alert', get_template_directory_uri() . '/script/tool/ToastAlert.js');
    wp_enqueue_script('date', get_template_directory_uri() . '/script/tool/Date.js');
    wp_enqueue_script('main_front', get_template_directory_uri() . '/script/main_front.js');
}
/* FIN SCRIPTS & CSS */


function includeFiles()
{
    //Classes utilitaires
    require_once('src/tools/HtmlSelectOption.php');
    require_once('src/tools/JsonAnswer.php');
    require_once('src/tools/PDOSingleton.php');
    require_once('src/tools/ManagerObjTable.php');

    //Classes utilitaires - paramètres
    require_once 'src/tools/ParamCheck.php';
    require_once 'src/tools/ParamException.php';
    require_once 'src/tools/ParamArray.php';
    require_once 'src/tools/ParamBool.php';
    require_once 'src/tools/ParamFloat.php';
    require_once 'src/tools/ParamInt.php';
    require_once 'src/tools/ParamObject.php';
    require_once 'src/tools/ParamString.php';
    require_once 'src/tools/ParamNumeric.php';

    //Router Pour les requêtes AJAX
    require_once('src/controllers/ajax/root_ajax.php');

    //Controllers action admin
    require_once('src/root_backoffice.php');
    require_once('src/controllers/form/add_menu.php');
    require_once('src/controllers/form/add_menu_option.php');
    require_once('src/controllers/form/delete_menu_option.php');
    require_once('src/controllers/form/delete_menu.php');
    require_once('src/controllers/form/add_dish_type.php');
    require_once('src/controllers/form/delete_dish_type.php');
    require_once('src/controllers/form/add_food_dish.php');
    require_once('src/controllers/form/delete_food_dish.php');
    require_once('src/controllers/form/add_media_img_file.php');

    //Controller front_page
    require_once('src/controllers/form/add_client.php');
    require_once('src/controllers/form/deco_client.php');
    require_once('src/controllers/form/connexion_client.php');
    require_once('src/controllers/form/book_table.php');

    //Classes métiers
    require_once('src/model/business_logic/Booking.php');
    require_once('src/model/business_logic/Bookings.php');
    require_once('src/model/business_logic/Client.php');
    require_once('src/model/business_logic/Clients.php');
    require_once('src/model/business_logic/DishType.php');
    require_once('src/model/business_logic/DishTypes.php');
    require_once('src/model/business_logic/FoodDish.php');
    require_once('src/model/business_logic/FoodDishes.php');
    require_once('src/model/business_logic/OpeningTime.php');
    require_once('src/model/business_logic/OpeningTimes.php');
    require_once('src/model/business_logic/RestaurantMenu.php');
    require_once('src/model/business_logic/RestaurantMenus.php');
    require_once('src/model/business_logic/RestaurantMenuOption.php');
    require_once('src/model/business_logic/RestaurantMenuOptions.php');
    require_once('src/model/business_logic/Gallery.php');
    require_once('src/model/business_logic/ImageGallery.php');

    //
    require_once('src/model/ClientConnection.php');
    require_once('src/model/PageWordpress.php');


    //TEST
    require_once('test/test_main.php');
}


//INIT TABLES BDD
function setTables()
{
    $bOptionInitTheme = get_option('init_theme');

    if(!$bOptionInitTheme)  add_option(Bookings::GUEST_MAX_OPTION);
    else if(intval($bOptionInitTheme) === 1) return; //Le thème est déjà chargée si l'option est configurée

    try{
        RestaurantMenus::getInstance()->createTable();
        RestaurantMenuOptions::getInstance()->createTable();
        DishTypes::getInstance()->createTable();
        FoodDishes::getInstance()->createTable();
        Clients::getInstance()->createTable();
        OpeningTimes::getInstance()->createTable();
        Bookings::getInstance()->createTable();
        Gallery::getInstance()->createTable();

        $iNbGuestMax = Bookings::getNbGuestsMax();
        if($iNbGuestMax === 0){
            add_option(Bookings::GUEST_MAX_OPTION, 50);
        }

        add_option('init_theme', 1);

    }catch(Exception $e){
        echo($e->getMessage());
        dbr($e->getTrace());
        echo($e->getFile());
        die();
    }
}
// FIN INIT TABLES BDD



function dbr($var) { echo '<pre>'. print_r($var, true).'</pre>'; }
function dbrDie($var) { dbr($var); die(); }




































