<?php

function testTables()
{
    //CLIENT
    //$oClients = new Clients();
    //$oClients->createTable();
    //$oClient = new client('jojo@test.fr', 'test', 'Teyssier', 'Jonathan', '0606060606', 'Oui jai des allergies');
    //$oClient = $oClients->add($oClient);
    //$oClients->updateById($oClient->getId(), array('firstName' => 'toto', 'tel' => '0102030405'));
    //$aClient = $oClients->getAllData('Client');
    //$oClients->deleteById(76);
    //$aClient = $oClients->getAllData('Client');
    //dbrDie($aClient);

    //OPENING TIMES
    $oOpenings = new OpeningTimes();
    //$oOpenings->createTable(); //TABLE
    //$oOpenings->initTable(); //ADD => Faire un if de si c'est déjà ajouter avec count de getAllData()
    //$oOpenings->updateById(4, array('startTimeDay' => '12:15:00')); //UPDATE
    //$aData = $oOpenings->getAllData();//GET
    //dbrDie($aData);
    //PAS DE DELETE ON NE PEUT PAS SUPPRIMER UN JOUR DE LA SEMAINE ON NE PEUT QUE LE METTRE à NULL

    $oBookings = new Bookings();
    //$oBookings->createTable();
    //$oBook = new Booking(30, 'jojo@ttti.lo', 'FirstName', 'LastName', '0566050320', null, 5, '12:15:00', '2023-04-20');
    //dbrDie($oBook);
    //$oBookings->add($oBook);
    //$oBookings->updateById(4, array('firstName' => 'Teyssier'));
    //$oBookings->deleteById(4);
    //dbrDie($oBookings->getAllData());

    $oMenus = new RestaurantMenus();
    $oMenus->createTable();
    //$oMenu = new RestaurantMenu('FabuleuxXXX');
    //$oMenus->add($oMenu);
    //$oMenus->updateById(4, array('title' => 'rrooozz'));
    //$oMenus->deleteById(4);
    //dbrDie($oMenus->getAllData());

    $oMenusOption = new RestaurantMenuOptions();
    $oMenusOption->createTable();
    $oOption = new RestaurantMenuOption(1, 'option 1', 'Ma descritpion option 1', 12.50);
    //$oMenusOption->add($oOption);
    //$oMenusOption->updateById(2, array('title' => 'option 1.1'));
    //dbrDie($oMenusOption->getAllData());
    //$oMenusOption->deleteById(5);


    $oDishTypes = new DishTypes();
    //$oDishTypes->createTable();
    //$oDisheType = new DishType('Entrées');
    //$oDishTypes->add($oDisheType);
    //$oDishTypes->updateById(1, array('title' => 'Entrée'));
    //dbrDie($oDishTypes->getAllData());
    //$oDishTypes->deleteById(1);

    $oFoodDishes = new FoodDishes();
    $oFoodDishes->createTable();
    $oFood = new FoodDish(2, 'Caviar', 'Cavaiar d\'aubergine', 45.50);
    //$oFoodDishes->add($oFood);
    //$oFoodDishes->updateById(1, array('title' => 'Caviars'));
    //dbrDie($oFoodDishes->getAllData());
    //$oFoodDishes->deleteById(1);


}