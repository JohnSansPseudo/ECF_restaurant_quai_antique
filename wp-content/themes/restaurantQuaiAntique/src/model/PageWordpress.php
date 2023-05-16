<?php


class PageWordpress
{
    CONST HOME_NAME = 'home';
    CONST CARTE_NAME = 'a-la-carte';
    CONST ACCOUNT_NAME = 'create-account';
    CONST SING_IN_NAME = 'sign-in';
    CONST BOOK_TABLE_NAME = 'book-table';


    private function getArrayPage()
    {
        $aPage = array();
        $aPage[] = (object)array(
            'post_content' => '',
            'post_title' => 'Accueil',
            'post_name' => PageWordpress::HOME_NAME,
            'guid' => get_site_url() . '/' . PageWordpress::HOME_NAME,
            'menu_order' => 1
        );
        $aPage[] = (object)array(
            'post_content' => '',
            'post_title' => 'A la carte',
            'post_name' => PageWordpress::CARTE_NAME,
            'guid' => get_site_url() . '/' . PageWordpress::CARTE_NAME,
            'menu_order' => 2
        );
        $aPage[] = (object)array(
            'post_content' => '',
            'post_title' => 'Mon compte',
            'post_name' => PageWordpress::ACCOUNT_NAME,
            'guid' => get_site_url() . '/' . PageWordpress::ACCOUNT_NAME,
            'menu_order' => 3
        );
        $aPage[] = (object)array(
            'post_content' => '',
            'post_title' => 'Connexion',
            'post_name' => PageWordpress::SING_IN_NAME,
            'guid' => get_site_url() . '/' . PageWordpress::SING_IN_NAME,
            'menu_order' => 4
        );
        $aPage[] = (object)array(
            'post_content' => '',
            'post_title' => 'Réserver votre table',
            'post_name' => PageWordpress::BOOK_TABLE_NAME,
            'guid' => get_site_url() . '/' . PageWordpress::BOOK_TABLE_NAME,
            'menu_order' => 5
        );
        return $aPage;
    }

    public function initPage()
    {
        $aPage = $this->getArrayPage();
        foreach($aPage as $oPage)
        {
            //Vérifier l'existence de la page
            $args = array(
                'post_type' => 'page',
                'post_name__in' => array($oPage->post_name));
            $get_posts = new WP_Query();
            $a = $get_posts->query($args);
            //Si la page n'a pas été créée alors on la créée
            if(count($a) < 1)
            {
                $aPost = array(
                    'post_content' => $oPage->post_content,
                    'post_title' => $oPage->post_title,
                    'post_name' => $oPage->post_name,
                    'post_status' => 'publish',
                    'post_author' => 1,
                    'post_type' => 'page',
                    'menu_order' =>$oPage->menu_order,
                    'guid' => $oPage->guid
                );

                $b = wp_insert_post($aPost);
                if(!is_int($b)){
                    throw new Exception('Error creating Wordpress pages' . var_dump($b));
                }
            }
        }
    }
}