<?php
namespace TopPosts\Controllers;

use TopPosts\Models\Post;
use TopPosts\Repositories\PostRepository;

class PostsController extends Controller
{
    public function home()
    {
        $aAllPosts = PostRepository::create()->getAllPosts();
        $oLongestPost = PostRepository::create()->getLongestPost();
        $this->sTemplate->sLongestPostAuthor = $oLongestPost ? $oLongestPost->getAuthor() : "";
        $this->sTemplate->aAllPosts = $aAllPosts;
        $this->sTemplate->iImagePosition = rand(0, count($aAllPosts)-1);
    }

    public function post()
    {
        $iId = 0;

        if (isset($_POST['id'])) {
            $iId = $_POST['id'];
        }

        $sAuthor = $_POST['author'];
        $sTitle = $_POST['title'];
        $sContent = $_POST['content'];
        $sDateUpdated = date('Y-m-d H:i:s');

        $oPost = new Post($sAuthor, $sTitle, $sContent, $sDateUpdated);
        if( $iId > 0 ) {
            $oPost->setId($iId);
            PostRepository::create()->updatePost($oPost);
        } else {
            $oPost->setDateCreated(date('Y-m-d H:i:s'));
            $iPostId = PostRepository::create()->insertPost($oPost);
            $oPost->setId($iPostId);
        }
        $oLongestPost = PostRepository::create()->getLongestPost();
        $this->sTemplate->aParams = array(
            'sLongestPostAuthor' => $oLongestPost ? $oLongestPost->getAuthor() : "",
            'oPost' => $oPost,
            'iKey' => 0,
        );
    }

    public function editForm()
    {
        $iId = $_POST['id'];
        $this->sTemplate->aParams = array(
            'oPost' => PostRepository::create()->getSinglePost($iId),
            'sCallback' => 'editPostCallback',
        );
    }

    public function deletePost()
    {
        $iId = $_POST['id'];
        $oPost = PostRepository::create()->getSinglePost($iId);
        $this->sTemplate->iId = $iId;
        $this->sTemplate->bSuccess = PostRepository::create()->deletePost($oPost);
        $oLongestPost = PostRepository::create()->getLongestPost();
        $this->sTemplate->sLongestPostAuthor = $oLongestPost ? $oLongestPost->getAuthor() : "";
    }
}