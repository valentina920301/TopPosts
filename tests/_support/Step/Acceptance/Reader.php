<?php
namespace Step\Acceptance;

use \Page\Acceptance\post as post;
use Page\Acceptance\homePage as homePage;
use Helper\Acceptance as Acceptance;

class Reader extends \AcceptanceTester
{

    public function assureDisplayingPosts()
    {
        $I = $this;
        $oPost = new post($I);
        $I->canSeeElement($oPost::$sHolderClass);
    }

    public function assureLongestPostAuthorDisplayed()
    {
        $I = $this;
        $oHomePage = new homePage($I);
        $I->seeElement($oHomePage::$sLongestPostBlock);
        $sLongestPostAuthor = $I->grabTextFrom($oHomePage::$sLongestPostAuthor);
        $I->canSee($sLongestPostAuthor);
    }

    public function assurePostColor($iPostOrderNumber, $sColor)
    {
        $I = $this;
        $oPost = new post($I);
        $sPostColor = $I->executeJS('window.getComputedStyle( document.getElementsByClassName("'.$oPost::$sHolderClass.'") ,":nth-of-type('.$iPostOrderNumber.')").getPropertyValue("background-color");');
        //ToDo check equality of $sPostColor and $sColor
    }

    public function assureNoPostsDisplayed()
    {
        $I = $this;
        $oPost = new post($I);
        $I->cantSeeElement($oPost::$sHolderClass);
    }

    public function assureLongestPostAuthorNotDisplayed()
    {
        $I = $this;
        $oHomePage = new homePage($I);
        $I->dontSeeElement($oHomePage::$sLongestPostBlock);
    }

    public function assureDisplayingImageWithRandomPosition()
    {
        $I = $this;
        $oHomePage = new homePage($I);
        $I->seeElement($oHomePage::$sElephantImage);
    }

    public function assurePostIsInList($sAuthor, $sTitle, $sContent)
    {
        $I = $this;
        $I->waitForText($sTitle, 5);
        $I->see($sAuthor);
        $I->see($sTitle);
        $I->see($sContent);

    }

    public function assurePostIsNotInList($sAuthor, $sTitle, $sContent)
    {
        $I = $this;
        $I->wait(5);
        $I->dontSee($sAuthor);
        $I->dontSee($sTitle);
        $I->dontSee($sContent);
    }

    public function assurePostHasFields($aFields, $iPostId)
    {
        $I = $this;
        $oPost = new post($I);

        $I->seeElement($oPost->getPostHolderByPostId($iPostId));
        if(array_key_exists('author', $aFields)){
            $I->seeElement($oPost->getElementByPostId($iPostId, $oPost::$sAuthor));
        }
        if(array_key_exists('title', $aFields)){
            $I->seeElement($oPost->getElementByPostId($iPostId, $oPost::$sTitle));
        }
        if(array_key_exists('content', $aFields)){
            $I->seeElement($oPost->getElementByPostId($iPostId, $oPost::$sContent));
        }
        if(array_key_exists('edit-button', $aFields)){
            $I->seeElement($oPost->getElementByPostId($iPostId, $oPost::$sActionEdit));
        }
        if(array_key_exists('delete-button', $aFields)){
            $I->seeElement($oPost->getElementByPostId($iPostId, $oPost::$sActionDelete));
        }
    }

    public function getPostDateCreated($iOrderNumber)
    {
        $I = $this;
        $oPost = new post($I);
        return $this->grabAttributeFrom($oPost->getPostHolderByOrderNumber($iOrderNumber), 'data-date_created');

    }

    public function getPostIdByOrderNumber($iOrderNumber = 1)
    {
        $I = $this;
        $oPost = new post($I);
        return $this->grabAttributeFrom($oPost->getPostHolderByOrderNumber($iOrderNumber), 'data-id');
    }


    public function getFieldTextByPostId($sField, $iPostId)
    {
        $I = $this;
        $oPost = new post($I);

        $sText = '';
        if ($sField == 'author') {
            $sText = $I->grabTextFrom($oPost->getElementByPostId($iPostId, $oPost::$sAuthor));
        }
        if ($sField == 'title') {
            $sText = $I->grabTextFrom($oPost->getElementByPostId($iPostId, $oPost::$sTitle));
        }
        if ($sField == 'content') {
            $sText = $I->grabTextFrom($oPost->getElementByPostId($iPostId, $oPost::$sContent));
        }

        return $sText;
    }

}