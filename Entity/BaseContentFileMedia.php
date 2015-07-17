<?php


namespace Iphp\ContentBundle\Entity;

use  Sonata\MediaBundle\Entity\BaseMedia as Media;

class BaseContentFileMedia
{


    /**
     * @var Media $file
     */
    protected $file;

    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var integer $pos
     */
    protected $pos;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \Application\Iphp\ContentBundle\Entity\Content
     */
    protected $content;

    /**
     * @var boolean
     */
    protected $published = true;

    protected $createdAt;

    protected $updatedAt;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Media
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param Media $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * @param int $pos
     */
    public function setPos($pos)
    {
        $this->pos = $pos;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Content $content
     */
    public function setContent($content = null)
    {
        $this->content = $content;
    }

    /**
     * @return boolean
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function __toString()
    {
        if ($this->getTitle()) return $this->getTitle();

        if ($this->file && isset($this->file['originalName']) && $this->file['originalName'])
            return  $this->file['originalName'];

        return '[No name]';
    }

    public function prePersist()
    {
        if (!$this->getCreatedAt()) $this->setCreatedAt(new \DateTime);
        if (!$this->getUpdatedAt()) $this->setUpdatedAt(new \DateTime);
    }


    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime);
    }
}