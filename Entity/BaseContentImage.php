<?php

namespace Iphp\ContentBundle\Entity;

use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *  @FileStore\Uploadable
 */
abstract class BaseContentImage
{


    /**
     * @var string $title
     */
    protected $title;

    /**
     * @var integer $id
     */
    protected $id;
    /**
     * @var integer $pos
     */
    protected $pos;

    protected $description;
    /**
     * @var \Application\Iphp\ContentBundle\Entity\Content
     */
    protected $content;


    /**
     * @var boolean Show Content File
     */
    protected $published = true;


    /**
     * @Assert\Image (
     *     maxSize="20M"
     * )
     * @FileStore\UploadableField(mapping="content_image" )
     *
     * @var File $file
     */
    protected $file;


    protected $createdAt;

    protected $updatedAt;



    public function __toString()
    {
        if ($this->getTitle()) return $this->getTitle();

        if ($this->file && isset($this->file['originalName']) && $this->file['originalName'])
            return  $this->file['originalName'];

        return '[No name]';
    }



    /**
     * Set title
     *
     * @param string $title
     * @return BaseContentFile
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Application\Iphp\ContentBundle\Entity\Content $content
     * @return BaseContentFile
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \Application\Iphp\ContentBundle\Entity\Content
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function prePersist()
    {
        if (!$this->getCreatedAt()) $this->setCreatedAt(new \DateTime);
        if (!$this->getUpdatedAt()) $this->setUpdatedAt(new \DateTime);
    }


    function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime);
    }

    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param int $pos
     */
    public function setPos($pos)
    {
        $this->pos = $pos;
        return $this;
    }

    /**
     * @return int
     */
    public function getPos()
    {
        return $this->pos;
    }



    /**
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }



}