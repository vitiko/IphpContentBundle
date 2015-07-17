<?php

namespace Iphp\ContentBundle\Entity;

use Sonata\MediaBundle\Entity\BaseMedia as Media;
use Iphp\ContentBundle\Entity\BaseContent as Content;

class BaseContentImageMedia
{


    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $pos;

    /**
     * @var bool
     */
    protected $main;

    /**
     * @var Content
     */
    protected $content;

    /**
     * @var Media
     */
    protected $media;



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
     * @return Media
     */
    public function getMedia()
    {
        return $this->media;
    }


    function getMediaDisplay()
    {
        return $this->media;
    }

    /**
     * @param Media $media
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    /**
     * @return boolean
     */
    public function isMain()
    {
        return $this->main;
    }

    /**
     * @param boolean $main
     */
    public function setMain($main)
    {
        $this->main = $main;
    }
}