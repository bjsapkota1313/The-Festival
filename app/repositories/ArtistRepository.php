<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/DanceEvent/artist.php';
require_once __DIR__ . '/../models/DanceEvent/Style.php';

class ArtistRepository extends Repository
{
    public function getAllArtists(): ?array
    {
        $query = "SELECT artist.artistId, artist.artistName, artist.artistDescription, image.imageName FROM artist JOIN image ON artist.artistLogoId = image.imageId";
        $result = $this->executeQuery($query);
        $artists = array();
        if (empty($result)) {
            return null;
        }
        foreach ($result as $artistRow) {
            $artists[] = $this->createArtistInstance($artistRow);
        }
        return $artists;
    }

    public function getAllArtistsParticipatingInEvent(): ?array
    {
        $query = "SELECT participatingartist.artistId,artist.artistDescription, artist.artistName, image.imageName
                FROM participatingartist
                JOIN artist ON participatingartist.artistId = artist.artistId
                JOIN image ON artist.artistLogoId = image.imageId
                GROUP BY participatingartist.artistId"; // gives all the artist participating in the event
        $result = $this->executeQuery($query);
        if (empty($result)) {
            return null;
        }
        $artists = array();
        foreach ($result as $artistRow) {
            $artists[] = $this->createArtistInstance($artistRow);
        }
        return $artists;
    }

    private function createArtistInstance($row): Artist
    {
        try {
            $artist = new Artist();
            $artist->setArtistId($row['artistId']);
            $artist->setArtistName($row['artistName']);
            $artist->setArtistDescription($row['artistDescription']);
            $artist->setArtistLogo($row['imageName']);
            $artist->setArtistImages($this->getAllImagesOfArtistByArtistId($row['artistId']));
            $artist->setArtistStyles($this->getArtistStylesByArtistID($row['artistId'])); // getting artist styles
            return $artist;
        } catch (Exception $e) {
            echo "Error while creating user instance: " . $e->getMessage();
        }
    }

    private function getAllImagesOfArtistByArtistId($artistId): ?array
    {
        $query = "SELECT image.imageName,artistImage.Imagespecification as imageSpecification  From artistImage JOIN image ON artistImage.imageId = image.imageId WHERE artistImage.artistId = :artistId";
        $result = $this->executeQuery($query, array(':artistId' => $artistId));
        if (!empty($result)) {
            return $this->getImagesWithKeyValue($result);
        }
        return null;
    }

    private function getImagesWithKeyValue($result): array
    {
        $images = array();
        foreach ($result as $imageRow) {
            $imageName = $imageRow['imageName'];
            $imageSpec = $imageRow['imageSpecification'];
            if (isset($images[$imageSpec])) { // storing images as key value pair in array
                $images[$imageSpec][] = $imageName;
            } else {
                $images[$imageSpec] = array($imageName);
            }
        }
        return $images;
    }

    public function getArtistByName($name)
    {
        $query = "SELECT artist.artistId, artist.artistName, artist.artistDescription, image.imageName FROM artist JOIN image ON artist.artistLogoId = image.imageId WHERE artistName = :name";
        $result = $this->executeQuery($query, array(':name' => $name), false);
        if (!empty($result)) {
            return $this->createArtistInstance($result);
        }
        return $result; // it is going to be null
    }

    public function getArtistByArtistID($artistID)
    {
        $query = "SELECT artist.artistId, artist.artistName, artist.artistDescription, image.imageName FROM artist JOIN image ON artist.artistLogoId = image.imageId WHERE artistId = :artistID";
        $result = $this->executeQuery($query, array(':artistID' => $artistID), false);
        if (!empty($result)) { // preventing null pointer exception
            return $this->createArtistInstance($result);
        }
        return $result;
    }

    public function getArtistStylesByArtistID($artistId)
    {
        $query = "SELECT style.styleName FROM artistStyle JOIN style ON artistStyle.styleId = style.styleId WHERE artistStyle.artistId = :artistID";
        $result = $this->executeQuery($query, array(':artistID' => $artistId));
        return array_column($result, 'styleName'); // making array of values of styles
    }

    public function deleteArtistById($artistId)
    {
        $stmt = $this->connection->prepare("DELETE FROM `artist` WHERE artistId = :artistId");
        $stmt->bindParam(':aristId', $artistId);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result = $stmt->fetch();

    }

    public function getAllParticipatingArtistsInPerformance($performanceId): ?array
    {
        $query = "SELECT artistId FROM participatingArtist WHERE PerformanceId = :PerformanceId";
        $result = $this->executeQuery($query, array(':PerformanceId' => $performanceId));
        if (empty($result)) {
            return null;
        }
        $artists = array();
        foreach ($result as $row) {
            $artists[] = $this->getArtistByArtistID($row['artistId']);
        }
        return $artists;
    }

    public function getArtistNameByArtistId($id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT artistName FROM artist WHERE artistId=:artistId");
            $stmt->bindParam(':artistId', $id);
            $stmt->execute();
            $result = $stmt->fetch();
            if ($result != 0) {
                return current($result);
            }

        } catch (PDOException $e) {
            echo $e;
        }
    }

    private function checkArtistExistence($stmt): bool
    {
        try {
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            $message = '[' . date("F j, Y, g:i a e O") . ']' . $e->getMessage() . $e->getCode() . $e->getFile() . ' Line ' . $e->getLine() . PHP_EOL;
            error_log("Database connection failed: " . $message, 3, __DIR__ . "/../Errors/error.log");
            http_response_code(500);
            exit();
        }
    }

    public function getArtistByIdWithUrl($id)
    {
        try {

            $stmt = $this->connection->prepare("SELECT * From artist WHERE artistId LIKE :id");
            $stmt->bindValue(':id', "%$id%");
            if ($this->checkArtistExistence($stmt)) {
                $stmt->execute();
                $result = $stmt->fetch();
                return $result;
            }

        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function getAllStyles(): ?array
    {
        $styles = array();
        $query = "SELECT styleId,styleName FROM style";
        $result = $this->executeQuery($query);
        if (empty($result)) {
            return null; // null pointer exception
        }
        foreach ($result as $row) {
            $styles[] = new Style($row['styleId'], $row['styleName']);
        }
        return $styles;
    }
    public function addArtist($data){
        $query= "INSERT INTO artist (artistName,artistDescription,artistLogoId) VALUES (:artistName,:artistDescription,:artistLogoId)";
        $result = $this->executeQuery($query, array(':artistName' => $data['artistName'], ':artistDescription' => $data['artistDescription'], ':artistLogoId' => $data['artistLogoId']), false,true);
        if(!is_numeric($result)){
            return false;
        }
    }
}
