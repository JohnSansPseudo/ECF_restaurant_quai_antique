<?php


class FoodDish
{
    private int $id;
    private int $idDishType;
    private string $title;
    private string $description;
    private float $price;
    private array $aErr = array();

    /**
     * @return array
     */
    public function getErrArray(): array
    {
        return $this->aErr;
    }


    /**
     * FoodDish constructor.
     * @param int $iId
     * @param int $iIdDishType
     * @param string $sTitle
     * @param string $sDescription
     * @param float $sPrice
     */
    public function __construct(int $iIdDishType, string $sTitle, string $sDescription, float $fPrice, int $iId=0)
    {
        if($iId) $this->setId($iId);
        $this->setIdDishType($iIdDishType)
            ->setTitle($sTitle)
            ->setDescription($sDescription)
            ->setPrice($fPrice);
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
     * @return FoodDish
     */
    public function setId(int $iId): FoodDish
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
    public function getIdDishType(): int
    {
        return $this->idDishType;
    }

    /**
     * @param int $iIdDishType
     * @return FoodDish
     */
    public function setIdDishType(int $iIdDishType): FoodDish
    {
        $oParam = new ParamInt($iIdDishType, self::Class . ' idDishType ', 1);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else  $this->idDishType = $iIdDishType;
        return $this;


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
     * @return FoodDish
     */
    public function setTitle(string $sTitle): FoodDish
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
     * @return FoodDish
     */
    public function setDescription(string $sDescription): FoodDish
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
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $sPrice
     * @return FoodDish
     */
    public function setPrice(float $fPrice): FoodDish
    {
        $oParam = new ParamFloat($fPrice, self::Class . ' price ', 1);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->price = $fPrice;
        return $this;
    }



}