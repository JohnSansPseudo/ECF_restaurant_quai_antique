<?php


//add_action('template_redirect', 'addMenuForm');
add_action('admin_init', 'addMenuForm');

//MENU ADMIN
add_action('admin_menu', 'sidebarAdminQuaiAntique');
add_action('admin_bar_menu', 'topbarAdminQuaiAntique', 999);

//CSS ADMIN
add_action('admin_enqueue_scripts', 'styleAdmin');
add_action('login_enqueue_scripts', 'styleAdmin');
//FIN CSS ADMIN

add_action('wp_enqueue_scripts', 'quai_antique_scripts');
add_action('after_setup_theme', 'quai_antique_supports'); //THEME OPTIONS
add_action('after_setup_theme', 'includeFiles');
add_action('after_setup_theme', 'setTables');//CREATION DES TABLES PERONNALISEES

//NAVIGATION - MENU
add_filter('nav_menu_css_class', 'quai_antique_menu_class');
add_filter('nav_menu_link_attributes', 'quai_antique_menu_links_attr');




function dbrDie($var) { echo '<pre>'. print_r($var, true).'</pre>'; die(); }

/** ADMIN SIDEBAR */
function sidebarAdminQuaiAntique()
{
    add_menu_page('Restaurant Quai Antique Param', 'QuaiAntiqueParam', 'manage_options', 'QuaiAntiqueParam', 'quaiAntiqueParamPage', 'dashicons-food');
}
function quaiAntiqueParamPage()
{
    echo restaurantQuaiAntiqueSectionMenu();
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



/**
 * @var $oMenu RestaurantMenu
 * @return string
 */
function restaurantQuaiAntiqueSectionMenu()
{
    //OPtion du select pour ajouter un option à un menu
    $sOptionAddOption = '';
    $aMenu = RestaurantMenus::getInstance()->getAllData();
    foreach($aMenu as $oMenu)
    {
        $sOptionAddOption .= '<option value="' . $oMenu->getId() . '">' . $oMenu->getTitle() . '</option>';
    }

    //Liste de tous les menus
    $sTrMenu = '';
    foreach($aMenu as $oMenu)
    {
        $sTrMenu .= '<tr data-id="' . $oMenu->getId() . '">
                        <td data-title=""><input id="inpTitleMenuUpdate" type="text" value="' . $oMenu->getTitle(). '"></td>
                        <td><span class="dashicons dashicons-trash dashicons-action mHover"></span></td>
                    </tr>';
    }

    return '<div class="backOfficeSection-Menu">


                    <!-- Menu management -->
                    <div class="SubSection">
                        <div class="head">
                            <h4>Ajouter un menu</h4>
                            <hr/>
                        </div>
                        <div class="body">
                            <form method="post" action="#">
                                <div id="cntAddMenu">
                                    <input type="hidden" name="add-menu-key" value="addMenuRestaurantBackOffice">
                                    <div class="elf">
                                        <label for="inpTitleMenu">Titre du menu</label>
                                        <input type="text" id="inpTitleMenu" name="inpTitleMenu" min="3" max="50"/>
                                    </div>
                                    <button type="submit" id="btnAddMenu" name="add-menu">Ajouter le menu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="SubSection">
                        <div class="head">
                            <h4>Gérer les menus</h4>
                            <hr/>
                        </div>
                        <div class="body">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Titre du menu</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody> ' . $sTrMenu . ' </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                    
                    
                    <!-- Menu option management -->
                    <div class="SubSection">
                        <div class="head">
                            <h4>Ajouter une option de menu</h4>
                            <hr/>
                        </div>
                        <div class="body">
                            <div id="ctnAddOPtionMenu">
                                 <div class="elf">
                                    <label for="selOptionMenu">Menu de l\'option</label>
                                    <select id="selOptionMenu" name="selOptionMenu">' . $sOptionAddOption . '</select>
                                </div>
                                
                                <div class="elf">
                                    <label for="inpTitleOption">Titre de l\'option</label>
                                    <input type="text" id="inpTitleOption" name="inpTitleOption" />
                                </div>
                                
                                <div class="elf">
                                    <label for="inpDescOption">Description</label>
                                    <input type="text" id="inpDescOption" name="inpDescOption" />
                                </div>
                                
                                <div class="elf">
                                    <label for="inpPriceOption">Prix</label>
                                    <input type="text" id="inpPriceOption" name="inpPriceOption" />
                                </div>
                                
                                <button type="submit" class="btn" >Créer et ajouter l\'option au menu</button>
                            </div>
                        </div>
                    </div>
                </div>';
}

function addMenuForm()
{
    if(isset($_POST['add-menu-key']) && isset($_POST['add-menu'])){

        if($_POST['add-menu-key'] !== 'addMenuRestaurantBackOffice') return;

        try{
            $oRestaurantMenus = new RestaurantMenus();
            $oMenu = new RestaurantMenu($_POST['inpTitleMenu']);
            $aResult = $oRestaurantMenus->getByWhere(array('title' => $oMenu->getTitle()));
            if(count($aResult) > 0)
            {
                //Ce menu existe déjà
            }
            else RestaurantMenus::getInstance()->add($oMenu); //On l'ajoute
        } catch(Exception $e){
            echo $e->getMessage();
            die('<br/><br/><a href="' . header(wp_get_referer()) .'">Retour</a>');
        }
    }
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

function styleAdmin()
{
    wp_enqueue_style('adminstyle', get_template_directory_uri() . '/style/styleAdmin.css');
    wp_enqueue_style('backoffice', get_template_directory_uri() . '/style/styleBackoffice.css');

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

function includeFiles()
{
    require_once('src/PDOSingleton.php');
    require_once('src/MotherObjTable.php');
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
}


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







































