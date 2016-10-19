<?php
namespace TopPosts\Repositories;

use TopPosts\Models\Post;

class PostRepository
{
    /**
     * @var \TopPosts\DB
     */
    private $oDB;

    /**
     * @var PostRepository;
     */
    private static $oInstance = null;

    private function __construct(\TopPosts\DB $oDB)
    {
        $this->oDB = $oDB;
    }

    /**
     * @return PostRepository
     */
    public static function create()
    {
        if (self::$oInstance == null) {
            self::$oInstance = new self(\TopPosts\DB::getInstance());
        }

        return self::$oInstance;
    }

    /**
     * @return Post[]
     */
    public function getAllPosts()
    {
        $sQuery = "SELECT * from posts ORDER BY date_created DESC";
        $this->oDB->query($sQuery, []);

        $aResult = $this->oDB->fetchAll();
        $aPosts = array();

        foreach ($aResult as $aPost) {
            $aPosts[] = new Post(
                $aPost['author'],
                $aPost['title'],
                $aPost['content'],
                $aPost['date_updated'],
                $aPost['date_created'],
                $aPost['id']
            );
        }

        return $aPosts;
    }

    /**
     * @param int $iId
     * @return bool|Post
     */
    public function getSinglePost($iId)
    {
        $sQuery = "SELECT * from posts WHERE id = ?";
        $this->oDB->query($sQuery, [$iId]);
        $aResult = $this->oDB->row();

        if (empty($aResult)) {
            return false;
        }

        return new Post(
            $aResult['author'],
            $aResult['title'],
            $aResult['content'],
            $aResult['date_updated'],
            $aResult['date_created'],
            $aResult['id']
        );
    }

    /**
     * @return bool|Post
     */
    public function getLongestPost()
    {
        $sQuery = "SELECT *, LENGTH(content) AS longest FROM posts ORDER BY longest DESC LIMIT 1";
        $this->oDB->query($sQuery, []);
        $aResult = $this->oDB->row();

        if (empty($aResult)) {
            return false;
        }

        return new Post(
            $aResult['author'],
            $aResult['title'],
            $aResult['content'],
            $aResult['date_updated'],
            $aResult['date_created'],
            $aResult['id']
        );
    }

    /**
     * @param Post $oPost
     * @return bool
     */
    public function insertPost(Post $oPost)
    {
        $sQuery = "
            INSERT INTO posts (author, title, content, date_updated, date_created)
            VALUES (?, ?, ?, ?, ?)
        ";
        $aParams = [
            $oPost->getAuthor(),
            $oPost->getTitle(),
            $oPost->getContent(),
            $oPost->getDateUpdated(),
            $oPost->getDateCreated()
        ];

        $this->oDB->query($sQuery, $aParams);

        return $this->oDB->getLastInsertId();
    }

    /**
     * @param Post $oPost
     * @return bool
     */
    public function updatePost(Post $oPost)
    {
        $sQuery = "
            UPDATE posts
            SET author = ?,
                title = ?,
                content = ?,
                date_updated = ?
            WHERE id = ?
        ";
        $aParams = [
            $oPost->getAuthor(),
            $oPost->getTitle(),
            $oPost->getContent(),
            $oPost->getDateUpdated(),
            $oPost->getId(),
        ];

        $this->oDB->query($sQuery, $aParams);

        return $this->oDB->rows() > 0;
    }

    /**
     * @param Post $oPost
     * @return bool
     */
    public function deletePost(Post $oPost)
    {
        $sQuery = "
            DELETE FROM posts
            WHERE id = ?
        ";
        $aParams = [
            $oPost->getId(),
        ];

        $this->oDB->query($sQuery, $aParams);

        return $this->oDB->rows() > 0;
    }

}