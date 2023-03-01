<?php
require_once __DIR__ . '/../controller.php';
class EventController extends controller
{
    protected function getImageFullPath($imageName): string
    {
        return "/image/Festival/Dance/".$imageName;
    }
}