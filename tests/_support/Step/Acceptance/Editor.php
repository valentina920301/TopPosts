<?php
namespace Step\Acceptance;

use \Page\Acceptance\post as post;
use \Page\Acceptance\editForm as editForm;

class Editor extends \AcceptanceTester
{
    public function assureFormHasFields($aFields, $iPostId = 0)
    {
        $I = $this;
        $oEditForm = new editForm($I);

        $I->seeElement($oEditForm->getSubmitForm($iPostId));
        if(array_key_exists('author', $aFields)){
            $I->seeElement($oEditForm->getElementByFormId($iPostId, $oEditForm::$sAuthorField));
        }
        if(array_key_exists('title', $aFields)){
            $I->seeElement($oEditForm->getElementByFormId($iPostId, $oEditForm::$sTitleField));
        }
        if(array_key_exists('content', $aFields)){
            $I->seeElement($oEditForm->getElementByFormId($iPostId, $oEditForm::$sContentField));
        }
        if(array_key_exists('submit-button', $aFields)){
            $I->seeElement($oEditForm->getElementByFormId($iPostId, $oEditForm::$sButtonSubmit));
        }
    }

    public function submitFormData($sAuthor, $sTitle, $sContent, $iPostId = 0)
    {
        $I = $this;
        $oEditForm = new editForm($I);
        $I->click($oEditForm->getElementByFormId($iPostId, $oEditForm::$sAuthorField)); //TODO make error message fade out
        $sSubmitForm = $oEditForm->getSubmitForm($iPostId);

        $I->submitForm(
            $sSubmitForm,
            array(
                'author' => $sAuthor,
                'title' => $sTitle,
                'content' => $sContent,
            ),
            $oEditForm::$sButtonSubmit
        );
    }

    public function assureDataIsValid($iPostId = 0)
    {
        $I = $this;
        $oEditForm = new editForm($I);
        $I->dontSeeElement($oEditForm->getElementByFormId($iPostId, $oEditForm::$sResponseMessageError));

    }

    public function assureDataIsNotValid($iPostId = 0)
    {
        $I = $this;
        $oEditForm = new editForm($I);
        $I->seeElement($oEditForm->getElementByFormId($iPostId, $oEditForm::$sResponseMessageError));

    }

    public function openEditForm($iPostId)
    {
        $I = $this;
        $oPost = new post($I);

        $I->seeElement($oPost->getElementByPostId($iPostId, $oPost::$sActionEdit));
        $I->click($oPost->getElementByPostId($iPostId, $oPost::$sActionEdit));

        $oEditForm = new editForm($I);
        $I->seeElement($oEditForm->getSubmitForm($iPostId));
    }

    public function deleteAllPosts()
    {
        //TODO add button for deleting all posts
    }

    public function deletePost($iPostId, $bConfirm = true)
    {
        $I = $this;
        $oPost = new post($I);

        $I->seeElement($oPost->getPostHolderByPostId($iPostId));
        $I->seeElement($oPost->getElementByPostId($iPostId, $oPost::$sActionDelete));
        $I->click($oPost->getElementByPostId($iPostId, $oPost::$sActionDelete));
        if ($bConfirm) {
            $I->acceptPopup();
//            $I->click($oPost::$sConfirmButtonAccept); //TODO customize confirmation popup
        } else {
            $I->cancelPopup();
//            $I->click($oPost::$sConfirmButtonReject); //TODO customize confirmation popup
        }

    }

    public function closeDeletedPostResponseMessage($iPostId)
    {
        $I = $this;
        $oPost = new post($I);

        $I->seeElement($oPost->getDeletedPostResponseMessage($iPostId));
        $I->click($oPost->getDeletedPostResponseMessage($iPostId).' i');
        $I->dontSeeElement($oPost->getDeletedPostResponseMessage($iPostId));
    }

}