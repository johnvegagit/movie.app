<?php
declare(strict_types=1);
defined('ROOTPATH') or exit . 'Access Denied!';

class Subscribe
{

    use Controller;

    public function index()
    {
        $data = ['title' => 'Subscribe to Moovie.',];
        $this->header($data);
        $this->view('subscribe');
        $this->footer();
    }
}