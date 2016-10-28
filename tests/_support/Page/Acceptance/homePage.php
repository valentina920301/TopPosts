<?php
namespace Page\Acceptance;

class homePage
{
    // include url of current page
    public static $URL = '';

    public static $sLongestPostBlock = '#longestPost';
    public static $sLongestPostAuthor = '#longestPost span:nth-child(2)';
    public static $sDeleteAllPostsButton = ''; //TODO add delete all posts button
    public static $sElephantImage = '.imageHolder img';

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

}
