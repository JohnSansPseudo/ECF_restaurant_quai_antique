<?php


class FoodDish
{
    private int $id;
    private int $idDishType;
    private string $title;
    private string $description;
    private float $price;

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
        $this->setId($iId)
            ->setIdDishType($iIdDishType)
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
        $this->id = $iId;
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
        $this->idDishType = $iIdDishType;
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
     * @return FoodDish
     */
    public function setDescription(string $sDescription): FoodDish
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
     * @param float $sPrice
     * @return FoodDish
     */
    public function setPrice(float $fPrice): FoodDish
    {
        $this->price = $fPrice;
        return $this;
    }



}