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

    }

    public function editor() {
        $this->displayView(null);
    }
    public function editorSubmitted() {
        // $content = null;
        // print_r($_POST);
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
            $this->pageService->createNewPage($page);

            // show the user result.
            $this->displayView($_POST["tinyMCEform"]);
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
        }
        echo "not found";
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