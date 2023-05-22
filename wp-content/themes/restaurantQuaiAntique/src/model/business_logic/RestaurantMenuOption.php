<?php


class RestaurantMenuOption
{
    private int $id;
    private int $idMenu;
    private string $title;
    private string $description;
    private $price;
    private array $aErr = array();

    /**
     * @return array
     */
    public function getErrArray(): array
    {
        return $this->aErr;
    }

    /**
     * @return string[]
     */
    static public function getArrayField()
    {
        return array(1 => 'idMenu', 2 => 'title', 3 => 'description', 4 => 'price');
    }

    /**
     * RestaurantMenuOption constructor.
     * @param int $iId
     * @param int $iIdMenu
     * @param string $sTitle
     * @param string $sDescription
     * @param float $fPrice
     */
    public function __construct(int $idMenu, string $title, string $description, float $price, int $id=0)
    {
        if($id) $this->setId($id);
        $this->setIdMenu($idMenu);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setPrice($price);
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
        $oParam = new ParamInt($iId, self::Class . ' id ', 1);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else  $this->id = $iId;
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
        $oParam = new ParamInt($iIdMenu, self::Class . ' idMenu ', 1);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else  $this->idMenu = $iIdMenu;
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
        $oParam = new ParamString($sTitle, self::Class . ' title ', 3, 50);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->title = $sTitle;
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
        $oParam = new ParamString($sDescription, self::Class . ' description ', 3, 250);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->description = $sDescription;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param  int |double $fPrice
     * @return RestaurantMenuOption
     */
    public function setPrice($fPrice): RestaurantMenuOption
    {
        $oParam = new ParamFloat($fPrice, self::Class . ' price ', 1);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->price = $fPrice;
        return $this;
    }

}