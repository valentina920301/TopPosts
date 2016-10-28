<?php

use Step\Acceptance\Reader as Reader;
use Step\Acceptance\Editor as Editor;

class PostCest
{
    public static $aValidFormData = array(
        'sAuthor' =>'Miles',
        'sTitle' => 'Davis',
        'sContent' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ullamcorper lacus eget lectus aliquam finibus. Aliquam dapibus quis urna ac congue. Curabitur maximus malesuada quam, sed lacinia nisi placerat sit amet.',
    );
    public static $aAnotherValidFormData = array(
        'sAuthor' =>'Asdf',
        'sTitle' => 'Qwerty',
        'sContent' => 'Vivamus auctor nibh at diam volutpat, et iaculis arcu facilisis. Nullam pellentesque at nulla ut hendrerit. Vivamus id ipsum ante. Donec tincidunt, mauris eu condimentum laoreet, orci mi varius lorem, eu sodales nulla neque quis tortor. ',
    );
    public static $aInvalidFormData = array(
        'sAuthor' =>'<? Miles ?>',
        'sTitle' => '<% Davis %>',
        'sContent' => '<% Lorem ?> ipsum dolor sit $this->amet, consectetur adipiscing elit. ',
    );
    public static $aEditPostFormData = array(
        'sAuthor' => 'Some New Author',
        'sTitle' => 'New Android 7.1.1',
        'sContent' => 'Some news about Android ...',
    );

    public function testIfFrontPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('ensure that frontpage works');
        $I->amOnPage('/home');
    }

//    public function testDeleteAllPosts(Editor $I, Reader $User)
//    {
//        $I->deleteAllPosts(); //TODO: add delete all posts functionality
//        $User->assureNoPostsDisplayed();
//        $User->assureLongestPostAuthorNotDisplayed();
//    }

    public function testAvailableFormFields(Editor $I)
    {
        $I->assureFormHasFields(array('author', 'title', 'content', 'submit-button'));
    }

    public function testValidDataFormSubmission(Editor $I, Reader $User)
    {
        $I->submitFormData(self::$aValidFormData['sAuthor'], self::$aValidFormData['sTitle'], self::$aValidFormData['sContent']);
        $I->assureDataIsValid();
        $User->assurePostIsInList(self::$aValidFormData['sAuthor'], self::$aValidFormData['sTitle'], self::$aValidFormData['sContent']);
    }

    public function testInvalidDataFormSubmission(Editor $I, Reader $User)
    {
        $I->submitFormData(self::$aInvalidFormData['sAuthor'], self::$aInvalidFormData['sTitle'], self::$aInvalidFormData['sContent']);
        $I->assureDataIsNotValid();
        $User->assurePostIsNotInList(self::$aInvalidFormData['sAuthor'], self::$aInvalidFormData['sTitle'], self::$aInvalidFormData['sContent']);
    }

    public function testPostDisplayedData(Reader $I)
    {
        //title, content, author, buttons(edit, delete)
        $iPostId = $I->getPostIdByOrderNumber(1);
        $I->assurePostHasFields(array('author', 'title', 'content', 'edit-button', 'delete-button'), $iPostId);
    }

    public function testAddOneMorePost(Editor $I, Reader $User)
    {
        $I->submitFormData(self::$aAnotherValidFormData['sAuthor'], self::$aAnotherValidFormData['sTitle'], self::$aAnotherValidFormData['sContent']);
        $I->assureDataIsValid();
        $User->assurePostIsInList(self::$aAnotherValidFormData['sAuthor'], self::$aAnotherValidFormData['sTitle'], self::$aAnotherValidFormData['sContent']);
    }

    public function testBackgroundStyles(Reader $I)
    {
        //TODO:
//        $I->assurePostColor(1, 'pink');
//        $I->assurePostColor(2, 'yellow');

    }

    public function testDisplayingAuthorOfLongestPost(Reader $I)
    {
        $I->assureLongestPostAuthorDisplayed();
    }

    public function testDisplayingImageWithRandomPosition(Reader $I)
    {
        $I->reloadPage();
        $I->assureDisplayingImageWithRandomPosition();
    }

    public function testPostsOrder(Reader $I)
    {
        $iFistPostDateCreated = strtotime($I->getPostDateCreated(2));
        $iSecondPostDateCreated = strtotime($I->getPostDateCreated(1));
        //TODO: $iFistPostDateCreated < $iSecondPostDateCreated;
    }

    public function testEditPost(Editor $I, Reader $User)
    {
        $iPostId = $User->getPostIdByOrderNumber(1);
        $I->openEditForm($iPostId);
        $I->submitFormData(self::$aEditPostFormData['sAuthor'], self::$aEditPostFormData['sTitle'], self::$aEditPostFormData['sContent'], $iPostId);
        $User->assurePostIsInList(self::$aEditPostFormData['sAuthor'], self::$aEditPostFormData['sTitle'], self::$aEditPostFormData['sContent']);
    }

    public function testDeletePost(Editor $I, Reader $User)
    {
        $iPostId = $User->getPostIdByOrderNumber(1);

        $aDeletedPostData = array(
            'sAuthor' => $User->getFieldTextByPostId('author', $iPostId),
            'sTitle' => $User->getFieldTextByPostId('title', $iPostId),
            'sContent' => $User->getFieldTextByPostId('content', $iPostId),
        );

        $I->deletePost($iPostId);
        $User->assurePostIsNotInList($aDeletedPostData['sAuthor'], $aDeletedPostData['sTitle'], $aDeletedPostData['sContent']);
        $I->closeDeletedPostResponseMessage($iPostId);
        
    }
    
    public function testMobileVersion(AcceptanceTester $I)
    {
        
    }

}