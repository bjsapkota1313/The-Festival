<?php
require_once __DIR__ . '/../repositories/repository.php';
class ImageRepository extends Repository
{
    /**
     * @throws DatabaseQueryException
     */
    public function insertImageAndGetId($imageName){
        $query = "INSERT INTO image (imageName) VALUES (:imageName)";
        $executedResult = $this->executeQuery($query, array(':imageName' => $imageName), false, true);
        if (!is_numeric($executedResult)) { // if it is bools means that it was not inserted into the database
            throw new DatabaseQueryException("Error while inserting image into database");
        }
        return $executedResult; // it is going to return us the id of the date that we just inserted
    }

}