<?php
namespace TopPosts;

class Template
{
    private $sControllerName;
    private $sActionName;
    public $aParams;

    public function __construct($sControllerName, $sActionName)
    {
        $this->sControllerName = $sControllerName;
        $this->sActionName = $sActionName;
    }

    public function render()
    {
        require_once 'Templates/'.$this->sControllerName.'/'.$this->sActionName.'.php';
    }

    public function load($sFileName, $aParams = array()){
        $this->aParams = $aParams;
        require 'Templates/'.$this->sControllerName.'/'.$sFileName.'.php';
    }
}