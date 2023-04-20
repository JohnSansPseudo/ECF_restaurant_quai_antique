<?php


class RestaurantMenu
{
    private int $id;
    private string $title;

    /**
     * RestaurantMenu constructor.
     * @param int $iId
     * @param string $sTitle
     */
    public function __construct(string $sTitle, int $iId=0)
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
     * @return RestaurantMenu
     */
    public function setId(int $iId): RestaurantMenu
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
     * @return RestaurantMenu
     */
    public function setTitle(string $sTitle): RestaurantMenu
    {
        $this->title = $sTitle;
        return $this;
    }
}