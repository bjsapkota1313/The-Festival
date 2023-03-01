<?php
require_once __DIR__ . '/../Models/EventPage.php';
require_once __DIR__ . '/../Models/Content.php';
require_once __DIR__ . '/../Models/SectionText.php';
require_once __DIR__ . '/../Models/Paragraph.php';
require_once __DIR__ . '/../Models/BodyHead.php';
require_once __DIR__ . '/repository.php';

class EventPageRepository extends Repository
{
    public function getEventPageByName($name)
    {
        try {
            $stmt = $this->connection->prepare("SELECT eventPageId,eventPageName,content,url,image,ticket  FROM eventpage WHERE eventPageName = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->createEventInstance($result);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function createEventInstance($result)
    {
        $eventPage = new EventPage();
        $eventPage->setEventPageId($result['eventPageId']);
        $eventPage->setEventPageName($result['eventPageName']);
        $contentId = $result['content'];
        $content = $this->getContent($contentId);
        $eventPage->setContent($content);
        $eventPage->setUrl($result['url']);
        $eventPage->setImage($result['image']);
        $eventPage->setTicket($result['ticket']);
        return $eventPage;
    }

    private function getContent($contentId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT contentId, bodyHead,h2,h3,p FROM content WHERE contentId = :contentId");
            $stmt->bindParam(':contentId', $contentId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->createContentInstance($result);


        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function createContentInstance($result)
    {
        $content = new Content();
        $content->setContentId($result['contentId']);
        $bodyHeadId = $result['bodyHead'];
        $bodyHead = $this->getBodyHead($bodyHeadId);
        $content->setBodyHead($bodyHead);
        $sectionText = $this->getSectionText($result['contentId']);
        $content->setSectionText($sectionText);
        return $content;

    }

    private function getBodyHead($bodyHeadId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT bodyHeadId,h1,h2,image FROM bodyhead WHERE bodyHeadId = :bodyHeadId");
            $stmt->bindParam(':bodyHeadId', $bodyHeadId);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'BodyHead');
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function getSectionText($contentId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT paragraph ,contentId FROM sectiontext WHERE contentId = :contentId");
            $stmt->bindParam(':contentId', $contentId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->createSectionTextInstance($result);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function createSectionTextInstance($result): SectionText
    {
        $sectionText = new SectionText();
        $contentId = $result['contentId'];
        $paragraphs = $this->getParagraphsByContentId($contentId);
        $sectionText->setParagraphs($paragraphs);
        return $sectionText;
    }

//    private function getParagraphs($paragraphId)
//    {
//        try {
//        $stmt=$this->connection->prepare("SELECT paragraphId,title,text FROM paragraph WHERE paragraphId = :paragraphId");
//        $stmt->bindParam(':paragraphId',$paragraphId);
//        $stmt->execute();
//        return $stmt->fetchAll(PDO::FETCH_CLASS,'Paragraph');
//        } catch (PDOException $e) {
//            echo $e->getMessage();
//        }
//
//    }
    private function getParagraphsByContentId($contentId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT  paragraph.paragraphId,  paragraph.title , paragraph.text  FROM sectiontext JOIN paragraph ON paragraph.paragraphId = sectiontext.paragraph WHERE sectiontext.contentId = :contentId");
            $stmt->bindParam(':contentId', $contentId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_CLASS, 'Paragraph');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

//    private function getSectionText($contentId)
//    {
//        try {
//            $stmt = $this->connection->prepare("SELECT  sectiontext.contentId, paragraph.paragraphId, paragraph.title AS paragraphTitle, paragraph.text AS paragraphText FROM sectiontext JOIN paragraph ON paragraph.paragraphId = sectiontext.paragraph WHERE sectiontext.contentId = :contentId");
//            $stmt->bindParam(':contentId', $contentId);
//            $stmt->execute();
//            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//            return $this->createSectionTextInstance($result);
//        } catch (PDOException $e) {
//            echo $e->getMessage();
//        }
//    }
//
//    private function createSectionTextInstance($result): SectionText
//    {
//        $sectionText = new SectionText();
//        $paragraphs = array();
//        foreach ($result as $row) { // reading result row by row
//            $paragraph = new Paragraph();
//            $paragraph->setParagraphId($row['paragraphId']);
//            $paragraph->setTitle($row['paragraphTitle']);
//            $paragraph->setText($row['paragraphText']);
//            $paragraphs[] = $paragraph;
//        }
//        $sectionText->setParagraphs($paragraphs);
//        return $sectionText;
//    }


}