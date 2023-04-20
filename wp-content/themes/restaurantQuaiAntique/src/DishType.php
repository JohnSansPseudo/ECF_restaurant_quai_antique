<?php


class DishType
{
    private int $id;
    private string $title;

    /**
     * DishType constructor.
     * @param int $iId
     * @param string $sTitle
     */
    public function __construct( string $sTitle, int $iId=0)
    {
        $this->setId($iId)->setTitle($sTitle);
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
     * @return DishType
     */
    public function setId(int $iId): DishType
    {
        $this->id = $iId;
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
     * @return DishType
     */
    public function setTitle(string $sTitle): DishType
    {
        $this->title = $sTitle;
        return $this;
    }
}
