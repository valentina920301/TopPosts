<?php

namespace TopPosts\Controllers;

class Controller
{
    /**
     * @var \TopPosts\Template
     */
    protected $sTemplate;

    public function __construct(\TopPosts\Template $sTemplate)
    {
        $this->sTemplate = $sTemplate;
    }

}
