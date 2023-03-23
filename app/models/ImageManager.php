<?php
require_once __DIR__ . '/../models/Exceptions/uploadFileFailedException.php';

trait ImageManager
{
    /**
     * @throws uploadFileFailedException
     */
    function moveImageToSpecifiedDirectory($image, $directory):void
    {
        if(!move_uploaded_file($image['tmp_name'], $directory)){
            throw new uploadFileFailedException("File upload Failed");
        }
    }

    function getUniqueImageNameByImageName($image): string
    {
        $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
        return uniqid() . '.' . $imageExtension;
    }

    /**
     * @throws uploadFileFailedException
     */
    function getImagesNameByMovingToDirectory($images, $pathToDir): array
    {
        try {
            $imageNames = [];
            foreach ($images as $key => $image) {
                $imageName = $this->getUniqueImageNameByImageName($image);
                $this->moveImageToSpecifiedDirectory($image, $pathToDir.$imageName);
                // Check if the key already exists in $imageNames
                if (isset($imageNames[$key])) {
                    // If the key exists, append the new value to the existing value in the array
                    if (is_array($imageNames[$key])) {
                        $imageNames[$key][] = $imageName;
                    } else {
                        $imageNames[$key] = [$imageNames[$key], $imageName];
                    }
                } else {
                    // If the key doesn't exist, add a new key-value pair to the array
                    $imageNames[$key] = $imageName;
                }
            }
            return $imageNames;
        } catch (Exception $exception) {
            throw new uploadFileFailedException($exception->getMessage());
        }

    }

}