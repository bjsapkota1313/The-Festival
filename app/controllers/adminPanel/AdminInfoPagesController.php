<?php
require_once __DIR__ . '/AdminPanelController.php';
require_once __DIR__ . '/../../services/PageService.php';
class AdminInfoPagesController extends AdminPanelController
{
    private $pageService;
    public function __construct()
    {
        parent::__construct();
        $this->pageService = new PageService();
    }
    public function index()
    {
        $title = 'Info Pages';
        $this->displaySideBar($title);
        require_once __DIR__ . '/../../views/AdminPanel/InfoPages/index.php';
    }
}