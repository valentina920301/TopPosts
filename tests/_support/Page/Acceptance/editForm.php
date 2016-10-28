<?php
namespace Page\Acceptance;

class editForm
{
    // include url of current page
    public static $URL = '/home';

    public static $sSubmitForm = "#editForm";

    //edit form elements
    public static $sAuthorField = 'input[name="author"]';
    public static $sTitleField = 'input[name="title"]';
    public static $sContentField = 'textarea[name="content"]';

    public static $sButtonClose = 'input[name="close"]';
    public static $sButtonClear = 'input[name="clear"]';
    public static $sButtonSubmit = 'input[name="submit"]';

    //response messages
    public static $sResponseMessageSuccess = '.responseMessage.success';
    public static $sResponseMessageError = '.responseMessage.error';

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

    public function getSubmitForm($iPostId = 0)
    {
        $sPostId = $iPostId == 0 ? '' : (string)$iPostId;
        return static::$sSubmitForm.$sPostId;
    }

    public function getElementByFormId($iPostId = 0, $sElement)
    {
        return $this->getSubmitForm($iPostId).' '.$sElement;
    }

}
