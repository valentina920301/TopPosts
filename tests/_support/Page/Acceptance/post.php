<?php
namespace Page\Acceptance;

class post
{
    // include url of current page
    public static $URL = '/home';

    //post elements
    public static $sHolder = '#post';
    public static $sHolderClass = '.postHolder';
//    public static $sPostContentHolder = '.postContentHolder';
    public static $sAuthor = '.postContentHolder .author';
    public static $sTitle = '.postContentHolder .title';
    public static $sContent = '.postContentHolder .body';
//    public static $sPostActionsHolder = '.postContentHolder .actionsHolder';
    public static $sActionEdit = '.postContentHolder .actionsHolder .edit';
    public static $sActionDelete = '.postContentHolder .actionsHolder .delete';

    //post colors
    public static $sFirstPostColor = 'pink';
    public static $sNotFirstPostColor = 'yellow';

    //delete confirm modal buttons
    public static $sConfirmButtonAccept = 'OK';
    public static $sConfirmButtonReject = 'Cancel';

    //response messages
    public static $sResponseMessageSuccess = '.responseMessage.success';
    public static $sResponseMessageError = '.responseMessage.error';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function getPostHolderByPostId($iPostId = 0)
    {
        $sPostId = $iPostId == 0 ? '' : (string)$iPostId;
        return static::$sHolder.$sPostId;
    }

    public function getPostHolderByOrderNumber($iOrderNumber = 1)
    {
        return static::$sHolderClass.':nth-of-type('.$iOrderNumber.')';
    }

    public function getDeletedPostResponseMessage($iPostId)
    {
        return static::$sResponseMessageSuccess.'[data-id="'.$iPostId.'"]';
    }

    public function getElementByPostId($iPostId = 0, $sElement)
    {
        return $this->getPostHolderByPostId($iPostId).' '.$sElement;
    }

}
