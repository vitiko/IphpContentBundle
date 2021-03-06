<?php



namespace Iphp\ContentBundle\Model;


use Iphp\ContentBundle\Entity\BaseContentFileMedia as ContentFileMedia;
use Doctrine\Common\Collections\ArrayCollection;
use Iphp\ContentBundle\Entity\BaseContentFile;
use Iphp\ContentBundle\Entity\BaseContentImage;
use Iphp\ContentBundle\Entity\BaseContentImageMedia;
use Iphp\ContentBundle\Entity\BaseContentLink;
use Iphp\FileStoreBundle\Mapping\Annotation as FileStore;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @FileStore\Uploadable
 */
abstract class Content implements ContentInterface
{
    protected $title;

    protected $slug = null;

    protected $slugPrefix;

    protected $abstract;

    protected $content;

    protected $rawContent;

    protected $contentFormatter;


    protected $enabled;

    protected $publicationDateStart;

    protected $createdAt;

    protected $updatedAt;

    protected $commentsEnabled = true;

    protected $commentsCloseAt;

    protected $commentsDefaultStatus;

    protected $author;

    protected $images;


    /**
     * @var \Symfony\Component\Security\Core\User\UserInterface;
     */
    protected $updatedBy;

    /**
     * @var \Symfony\Component\Security\Core\User\UserInterface;
     */
    protected $createdBy;


    /**
     * @Assert\Image(
     *     maxSize="20M"
     * )
     * @FileStore\UploadableField(mapping="content_announceimage", fileDataProperty ="image"))
     *
     * @var File $image
     */
    protected $imageUpload;


    protected $image;

    protected $date;

    protected $rubric;

    protected $files;

    protected $redirectToFirstFile;

    protected $links;

    protected $redirectUrl;


    /**
     * @var ContentFileMedia[]
     */
    protected $filesMedia;

    /**
     * @var ContentImageMedia[]
     */
    protected $imagesMedia;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->links = new ArrayCollection();

        $this->filesMedia = new ArrayCollection();
        $this->imagesMedia = new ArrayCollection();
    }

    public function getSitePath()
    {
        return $this->getRedirectUrl() ? $this->getRedirectUrl() :
            $this->getRubric()->getFullPath() . ($this->getSlug() ? $this->getSlug() . '/' : '');
    }


    public function isIndex()
    {
        return $this->getSlug() == '';
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return (string)$this->title;
    }

    /**
     * Set abstract
     *
     * @param text $abstract
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
        return $this;
    }

    /**
     * Get abstract
     *
     * @return text $abstract
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return text $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set slug
     *
     * @param integer $slug
     */
    public function setSlug($slug)
    {
        if (is_null($slug)) $slug = '';
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get slug
     *
     * @return integer $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set publication_date_start
     *
     * @param \DateTime $publicationDateStart
     */
    public function setPublicationDateStart(\DateTime $publicationDateStart = null)
    {
        $this->publicationDateStart = $publicationDateStart;
    }

    /**
     * Get publication_date_start
     *
     * @return \DateTime $publicationDateStart
     */
    public function getPublicationDateStart()
    {
        return $this->publicationDateStart;
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return datetime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return datetime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    public function prePersist()
    {
        if (!$this->getPublicationDateStart()) {
            $this->setPublicationDateStart(new \DateTime);
        }

        if (!$this->getCreatedAt()) $this->setCreatedAt(new \DateTime);
        if (!$this->getUpdatedAt()) $this->setUpdatedAt(new \DateTime);

        $this->checkSlug();

    }

    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime);

        $this->checkSlug();

    }


    protected function checkSlug()
    {
        if ($this->slug === null)
            $this->slug = ($this->getSlugPrefix() ? $this->getSlugPrefix() . '-' : '') .
                \Iphp\CoreBundle\Util\Slugify::slugifyPreserveWords($this->getTitle(), 45);
        //substr (\Iphp\CoreBundle\Util\Translit :: translit($this->getTitle()),0,50);
    }

    /**
     * Set comments_enabled
     *
     * @param boolean $commentsEnabled
     */
    public function setCommentsEnabled($commentsEnabled)
    {
        $this->commentsEnabled = $commentsEnabled;
    }

    /**
     * Get comments_enabled
     *
     * @return boolean $commentsEnabled
     */
    public function getCommentsEnabled()
    {
        return $this->commentsEnabled;
    }

    /**
     * Set comments_close_at
     *
     * @param \DateTime|null $commentsCloseAt
     */
    public function setCommentsCloseAt(\DateTime $commentsCloseAt = null)
    {
        $this->commentsCloseAt = $commentsCloseAt;
    }

    /**
     * Get comments_close_at
     *
     * @return datetime $commentsCloseAt
     */
    public function getCommentsCloseAt()
    {
        return $this->commentsCloseAt;
    }

    /**
     * Set comments_default_status
     *
     * @param integer $commentsDefaultStatus
     */
    public function setCommentsDefaultStatus($commentsDefaultStatus)
    {
        $this->commentsDefaultStatus = $commentsDefaultStatus;
    }

    /**
     * Get comments_default_status
     *
     * @return integer $commentsDefaultStatus
     */
    public function getCommentsDefaultStatus()
    {
        return $this->commentsDefaultStatus;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return bool
     */
    public function isCommentable()
    {
        if (!$this->getCommentsEnabled() || !$this->getEnabled()) {
            return false;
        }

        if ($this->getCommentsCloseAt() instanceof \DateTime) {
            return $this->getCommentsCloseAt()->diff(new \DateTime)->invert == 1 ? true : false;
        }

        return true;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
    }

    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
        return $this;
    }

    public function getRawContent()
    {
        return $this->rawContent;
    }

    public function setImages($images)
    {
        $this->images = $images;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setRubric($rubric)
    {
        $this->rubric = $rubric;
        return $this;
    }

    public function getRubric()
    {
        return $this->rubric;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setFiles($files)
    {
        foreach ($files as $file) $file->setContent($this);

        foreach ($this->getFiles() as $file) {
            if (!$files->contains($file)) {
                $this->getFiles()->removeElement($file);
            }
        }

        $this->files = $files;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection;
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection;
     */
    public function getPublishedFiles()
    {
        $publishedFiles = $this->files;

        foreach ($publishedFiles as $file)
            if (!$file->getPublished()) $publishedFiles->removeElement($file);
        return $publishedFiles;
    }


    /**
     * @return \Doctrine\Common\Collections\ArrayCollection;
     */
    public function getPublishedImages()
    {
        $publishedImages = $this->images;

        foreach ($publishedImages as $image)
            if (!$image->getPublished()) $publishedImages->removeElement($image);
        return $publishedImages;
    }


    public function addFile(BaseContentFile $file)
    {
        $file->setContent($this);
        $this->files[] = $file;
    }

    public function removeFile(BaseContentFile $file)
    {

        $this->getFiles()->removeElement($file);
    }


    public function addImage(BaseContentImage $image)
    {
        $image->setContent($this);
        $this->images[] = $image;
    }

    public function removeImage(BaseContentImage $image)
    {

        $this->getImages()->removeElement($image);
    }


    public function setLinks($links)
    {
        foreach ($links as $link) $link->setContent($this);

        foreach ($this->getLinks() as $link) {
            if (!$links->contains($link)) {
                $this->getLinks()->removeElement($link);
            }
        }

        $this->links = $links;
        return $this;
    }


    /**
     * @return \Doctrine\Common\Collections\ArrayCollection;
     */
    public function getLinks()
    {
        return $this->links;
    }

    public function addLink(BaseContentLink $link)
    {
        $link->setContent($this);
        $this->links[] = $link;
    }


    public function removeLink($link)
    {
        $this->getLinks()->removeElement($link);
    }


    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    public function setSlugPrefix($slugPrefix)
    {
        $this->slugPrefix = $slugPrefix;
        return $this;
    }

    public function getSlugPrefix()
    {
        return $this->slugPrefix;
    }

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $updatedBy
     */
    public function setUpdatedBy(UserInterface $updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param mixed $redirectToFirstFile
     */
    public function setRedirectToFirstFile($redirectToFirstFile)
    {
        $this->redirectToFirstFile = $redirectToFirstFile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRedirectToFirstFile()
    {
        return $this->redirectToFirstFile;
    }


    /**
     * @return ContentFileMedia[]
     */
    public function getFilesMedia()
    {
        return $this->filesMedia;
    }

    /**
     * @param ContentFileMedia[] $filesMedia
     */
    public function setFilesMedia($filesMedia)
    {
        foreach ($this->filesMedia as $fileMedia) {
            $fileMedia->setContent(null);
        }

        $this->filesMedia = new ArrayCollection();

        foreach ($filesMedia as $file) {
            $this->addFilesMedia($file);
            $file->setContent($this);
        }
    }

    /**
     * @param ContentFileMedia $fileMedia
     */
    public function addFilesMedia(ContentFileMedia $fileMedia)
    {
        if (!$this->filesMedia->contains($fileMedia)) {
            $this->filesMedia->add($fileMedia);
        }
    }

    /**
     * @param ContentFileMedia $fileMedia
     */
    public function removeFilesMedia(ContentFileMedia $fileMedia)
    {
        $this->filesMedia->removeElement($fileMedia);
    }

    /**
     * @return BaseContentImageMedia[]
     */
    public function getImagesMedia()
    {
        return $this->imagesMedia;
    }

    /**
     * @param BaseContentImageMedia[] $imagesMedia
     */
    public function setImagesMedia($imagesMedia)
    {
        foreach ($this->imagesMedia as $imageMedia) {
            $imageMedia->setContent(null);
        }

        $this->imagesMedia = new ArrayCollection();

        foreach ($imagesMedia as $imageMedia) {
            $this->addImagesMedia($imageMedia);
        }
    }

    /**
     * @param BaseContentImageMedia $imageMedia
     */
    public function addImagesMedia(BaseContentImageMedia $imageMedia)
    {
        if (!$this->imagesMedia->contains($imageMedia)) {
            $this->imagesMedia->add($imageMedia);
            $imageMedia->setContent($this);
        }
    }

    /**
     * @param BaseContentImageMedia $imageMedia
     */
    public function removeImagesMedia(BaseContentImageMedia $imageMedia)
    {
        $this->imagesMedia->removeElement($imageMedia);
    }

    /**
     * @param \Iphp\ContentBundle\Model\File $imageUpload
     */
    public function setImageUpload($imageUpload)
    {
        $this->imageUpload = $imageUpload;
        return $this;
    }

    /**
     * @return \Iphp\ContentBundle\Model\File
     */
    public function getImageUpload()
    {
        return $this->imageUpload;
    }


}