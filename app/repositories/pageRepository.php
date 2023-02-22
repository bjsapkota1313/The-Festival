<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/page.php';

class PageRepository extends Repository
{
    private function createPageInstance($dbRow): Page
    {
        try {
            $page = new Page();
            $page->setId($dbRow['id']);
            $page->setURI($dbRow['URI']);
            $page->setTitle($dbRow['title']);
            $page->setBodyContentHTML($dbRow['bodyContentHTML']);
            $page->setCreationTime(new DateTime($dbRow['creationTime']));
            $page->setCreatorUserId($dbRow['creatorUserId']);
            return $page;
        } catch (Exception $e) {
            echo "Error while creating user instance: " . $e->getMessage();
        }
    }

    public function getPageById(int $pageId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Page WHERE id = :id");
            $stmt->bindParam(':id', $pageId);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return null;
            }
            $result = $stmt->fetch();
            return $this->createPageInstance($result);
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

    public function getPageByTitle(string $pageTitle)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM Page WHERE title = :title");
            $stmt->bindParam(':title', $pageTitle);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                return null;
            }
            $result = $stmt->fetch();
            return $this->createPageInstance($result);
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

    public function createNewPage($newPage)
    {
        try {
            $stmt = $this->connection->prepare("INSERT into Page (URI, title, bodyContentHTML, creatorUserId) VALUES (:URI, :title, :bodyContentHTML, :creatorUserId)");

            $stmt->bindValue(':URI', $newPage->getURI());
            $stmt->bindValue(':title', $newPage->getTitle());
            $stmt->bindValue(':bodyContentHTML', $newPage->getBodyContentHTML());
            $stmt->bindValue(':creatorUserId', $newPage->getCreatorUserId());

            $stmt->execute();
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

    function updatePageContentById($id, $bodyContentHTML)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE User SET bodyContentHTML = :bodyContentHTML WHERE id = :id");

            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':bodyContentHTML', $bodyContentHTML);

            $stmt->execute();
            if($stmt->rowcount() == 0){
                return false;
            }
            return true;

        } catch (PDOException $e) {
            echo $e;
        }
    }
}

