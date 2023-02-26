<?php
require_once __DIR__ . '/controller.php';
require_once __DIR__ . '/../services/pageService.php';
require_once __DIR__ . '/../models/page.php';

class HomeController extends Controller
{
    private $pageService;

    // initialize services
    function __construct()
    {
        $this->pageService = new PageService();
    }
    public function index()
    {
        require __DIR__ . '/../views/home/index.php';
    }


    public function editor($query) {
        parse_str($query, $parsedQuery);
        if(isset($parsedQuery["title"])) {
            $page = $this->pageService->getPageByTitle($parsedQuery["title"]);
            if($page != null) {
                $this->displayView($page);
            }
            else {
                // page not found
                $this->displayView(null);
            }
        }
        else {
            $this->displayView(null);
        }
    }
    public function editorSubmitted() {
        // $content = null;
        // submitting new page or updating an existing page
        if(isset($_POST["formSubmit"])) {
            // save to database
            $page = new Page();
            // comment: correct URI later.
            $page->setURI("home/page");
            $page->setTitle($_POST['pageTitle']);
            $page->setBodyContentHTML($_POST["tinyMCEform"]);
            // comment: creation time is set now by database
            // comment: correct userId later.
            $page->setCreatorUserId(1);
            // check if the page is a new page or updating existing page
            if(isset($_POST['pageID'])) {
                $this->pageService->updatePageById($_POST['pageID'], $page);
            }
            else {
                $this->pageService->createNewPage($page);                
            }

            // show the user result.
            $this->displayView($_POST["tinyMCEform"]);
        }
        if(isset($_POST["formDelete"])) {
            if(isset($_POST['pageID'])) {
                $this->pageService->deletePageById($_POST['pageID']);
                echo "deleted page with id " . $_POST['pageID'];
            }
            else {
                echo "page id is missing";
            }            
        }
    }

    public function show($query) {
        // echo $query;
        // parse_str turned the query string into a dictionary
        // title=Test1 becomes {title: Test1}
        parse_str($query, $parsedQuery);
        if(isset($parsedQuery["title"])) {
            $page = $this->pageService->getPageByTitle($parsedQuery["title"]);
            if($page != null) {
                $this->displayView($page->getBodyContentHTML());
            }
            else {
                echo "title not found";
            }
        }
        else {
            echo "title should be set";
        }
    }

    public function about()
    {
        require __DIR__ . '/../views/home/about.php';

    }

    public function test()
    {
        echo "this is a test";
    }
}
