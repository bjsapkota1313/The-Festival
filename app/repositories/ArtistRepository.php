<?php
require_once __DIR__ . '/repository.php';
require_once __DIR__ . '/../models/artist.php';

class ArtistRepository extends Repository
{
    public function getAllArtists()
    {
        try {
            $stmt = $this->connection->prepare("SELECT artist.artistId, artist.artistName, artist.artistDescription, image.imageName FROM artist JOIN image ON artist.artistLogoId = image.imageId");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $artistRow) {
                $artists[] = $this->createArtistInstance($artistRow);
            }
            return $artists;
        } catch (PDOException|Exception $e) {
            echo $e;
        }

    }

    private function createArtistInstance($row): Artist
    {
        $artist = new Artist();
        $artist->setArtistId($row['artistId']);
        $artist->setArtistName($row['artistName']);
        $artist->setArtistDescription($row['artistDescription']);
        $artist->setArtistLogo($row['imageName']);
        $artist->setArtistImages($this->getAllImagesOfArtistByArtistId($row['artistId']));
        return $artist;
    }

    private function getAllImagesOfArtistByArtistId($artistId)
    {
        try {
            $images=null;
            $stmt = $this->connection->prepare("SELECT image.imageName,artistImage.Imagespecification as imageSpecification  From artistImage JOIN image ON artistImage.imageId = image.imageId WHERE artistImage.artistId = :artistId");
            $stmt->bindParam(':artistId', $artistId);
            $stmt->execute();
            $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $imageRow) {
                $images[] = $this->getImageArray($imageRow);
            }
            return $images;
        } catch (PDOException|Exception $e) {
            echo $e;
        }
    }

// getting image array TODO: image
    private function getImageArray($dbRow): array
    {
        return  array(
            'imageName' => $dbRow['imageName'],
            'imageSpecification' => $dbRow['imageSpecification'],
        );
    }

    public function getArtistByName($name)
    {
        try {
            $stmt = $this->connection->prepare("SELECT artist.artistId, artist.artistName, artist.artistDescription, image.imageName FROM artist JOIN image ON artist.artistLogoId = image.imageId WHERE artistName = :name");
            $stmt->bindParam(':name', $name);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                return $this->createArtistInstance($result);
            }
            return null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}