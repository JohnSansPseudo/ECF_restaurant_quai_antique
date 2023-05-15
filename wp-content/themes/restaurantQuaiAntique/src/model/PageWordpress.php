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
            'position' => 1
        );
        $aPage[] = (object)array(
            'post_content' => '',
            'post_title' => 'A la carte',
            'post_name' => PageWordpress::CARTE_NAME,
            'position' => 2
        );
        $aPage[] = (object)array(
            'post_content' => '',
            'post_title' => 'Mon compte',
            'post_name' => PageWordpress::ACCOUNT_NAME,
            'position' => 3
        );
        $aPage[] = (object)array(
            'post_content' => '',
            'post_title' => 'Connexion',
            'post_name' => PageWordpress::SING_IN_NAME,
            'position' => 4
        );
        $aPage[] = (object)array(
            'post_content' => '',
            'post_title' => 'Réserver votre table',
            'post_name' => PageWordpress::BOOK_TABLE_NAME,
            'position' => 5
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
                    'post_type' => 'page'
                );

                $b = wp_insert_post($aPost);
                if(!is_int($b)){
                    throw new Exception('Error creating Wordpress pages' . var_dump($b));
                }
            }
        }
    }
}