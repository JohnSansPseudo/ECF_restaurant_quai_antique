<?php


class ImageGallery
{

    private int $id;
    private int $idAttachment;
    private string $title;
    private array $aErr=array();

    /**
     * @return array
     */
    public function getErrArray(): array
    {
        return $this->aErr;
    }

    /**
     * @param array $aErr
     * @return ImageGallery
     */
    public function setErrArray(array $aErr): ImageGallery
    {
        $this->aErr = $aErr;
        return $this;
    }


    /**
     * ImageGallery constructor.
     * @param int $idAttachement
     * @param string $title
     * @param int $id
     */
    public function __construct(int $idAttachement, string $title, int $id=0)
    {
        if($id) $this->setId($id);
        $this->setIdAttachment($idAttachement);
        $this->setTitle($title);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ImageGallery
     */
    public function setId(int $id): ImageGallery
    {
        //Il ne peut pas y avoir plus de 6 images et c'est forcément un id de 1 à 6
        $oParam = new ParamInt($id, self::Class . '$id', 1, 6);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdAttachment(): int
    {
        return $this->idAttachment;
    }

    /**
     * @param int $idAttachment
     * @return ImageGallery
     */
    public function setIdAttachment(int $idAttachment): ImageGallery
    {
        $oParam = new ParamInt($idAttachment, self::Class . '$idAttachement', 0);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->idAttachment = $idAttachment;
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
     * @param string $title
     * @return ImageGallery
     */
    public function setTitle(string $title): ImageGallery
    {
        $oParam = new ParamString($title, self::Class . ' $title', 0, 500);
        if($oParam->getStringError() !== ''){
            $this->aErr[] = $oParam->getStringError();
        }
        else $this->title = $title;
        return $this;
    }



}