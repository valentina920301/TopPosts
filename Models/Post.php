<?php
namespace TopPosts\Models;

use TopPosts\Repositories\PostRepository;

class Post
{
    private $iId;

    private $sAuthor;

    private $sTitle;

    private $sContent;

    private $sDateUpdated;

    public function __construct($sAuthor, $sTitle, $sContent, $sDateUpdated, $iId = null)
    {
        $this->setAuthor($sAuthor);
        $this->setTitle($sTitle);
        $this->setContent($sContent);
        $this->setDateUpdated($sDateUpdated);
        $this->setId($iId);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->iId;
    }

    /**
     * @param mixed $iId
     */
    public function setId($iId)
    {
        $this->iId = $iId;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->sAuthor;
    }

    /**
     * @param mixed $sAuthor
     */
    public function setAuthor($sAuthor)
    {
        $this->sAuthor = $sAuthor;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->sTitle;
    }

    /**
     * @param mixed $sTitle
     */
    public function setTitle($sTitle)
    {
        $this->sTitle = $sTitle;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->sContent;
    }

    /**
     * @param mixed $sContent
     */
    public function setContent($sContent)
    {
        $this->sContent = $sContent;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->sDateUpdated;
    }

    /**
     * @param mixed $sDateUpdated
     */
    public function setDateUpdated($sDateUpdated)
    {
        $this->sDateUpdated = $sDateUpdated;
    }

    public function createPost()
    {
        PostRepository::create()->insertPost($this);
    }

    public function editPost()
    {
        PostRepository::create()->updatePost($this);
    }

    public function deletePost()
    {
        PostRepository::create()->deletePost($this);
    }

}