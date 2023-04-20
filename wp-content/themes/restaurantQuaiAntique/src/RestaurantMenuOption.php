<?php


class RestaurantMenuOption
{
    private int $id;
    private int $idMenu;
    private string $title;
    private string $description;
    private float $price;

    /**
     * RestaurantMenuOption constructor.
     * @param int $iId
     * @param int $iIdMenu
     * @param string $sTitle
     * @param string $sDescription
     * @param float $fPrice
     */
    public function __construct(int $iIdMenu, string $sTitle, string $sDescription, float $fPrice, int $iId=0)
    {
        $this->setId($iId);
        $this->setIdMenu($iIdMenu);
        $this->setTitle($sTitle);
        $this->setDescription($sDescription);
        $this->setPrice($fPrice);
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $iId
     * @return RestaurantMenuOption
     */
    public function setId(int $iId): RestaurantMenuOption
    {
        $this->id = $iId;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdMenu(): int
    {
        return $this->idMenu;
    }

    /**
     * @param int $iIdMenu
     * @return RestaurantMenuOption
     */
    public function setIdMenu(int $iIdMenu): RestaurantMenuOption
    {
        $this->idMenu = $iIdMenu;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $sTitle
     * @return RestaurantMenuOption
     */
    public function setTitle(string $sTitle): RestaurantMenuOption
    {
        $this->title = $sTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $sDescription
     * @return RestaurantMenuOption
     */
    public function setDescription(string $sDescription): RestaurantMenuOption
    {
        $this->description = $sDescription;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $fPrice
     * @return RestaurantMenuOption
     */
    public function setPrice(float $fPrice): RestaurantMenuOption
    {
        $this->price = $fPrice;
        return $this;
    }




}