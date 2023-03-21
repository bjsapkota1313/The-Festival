<?php
require_once __DIR__ . '/../repositories/AvailableEventRepository.php';
require_once __DIR__ . '/ArtistService.php';


class AvailableEventService
{
    private $availableEventRepository;

    private $artistService;

    public function __construct()
    {
        $this->availableEventRepository = new AvailableEventRepository();
        $this->artistService = new ArtistService();

    }
    public function getAvailableHistoryEvents()
    {
        return $this->availableEventRepository->getAvailableHistoryEvents();
    }

    public function getAvailableMusicEvents()
    {
        return $this->availableEventRepository->getAvailableMusicEvents();
    }
    
       public function  getAvailableEventByIdWithUrl($id)
    {
        return $this->availableEventRepository->getAvailableEventByIdWithUrl($id);

    }

    public function  retrieveParticipatingArtistsDataWithUrl($id)
    {
        return $this->availableEventRepository->retrieveParticipatingArtistsDataWithUrl($id);

    }


    public function getEventNameByEventTypeIdWithUrl($id){
        return $this->availableEventRepository->getEventNameByEventTypeIdWithUrl($id);
    }

    public function getAvailableMusicEventsData()
    {
        $newList = array();
        $availableEvents = $this->getAvailableMusicEvents();
        foreach ($availableEvents as $availableEvent) {
            $participatingArtistId = $availableEvent->getParticipatingArtistId();
            $participatingArtist = $this->artistService->getArtistNameByArtistId($participatingArtistId);

            array_push($newList, array('AvailableEvent' => $availableEvent, 'ParticipatingArtist' => $participatingArtist));

        }
        return $newList;
    }


    public function getAvailableHistoryEventsByDate($availableEvents, $date)
    {
        $newList = array();
        foreach ($availableEvents as $availableEvent) {
            if ($availableEvent->getEventDate() == $date) {
                array_push($newList, array('AvailableEvent' => $availableEvent));
            }
        }
        return $newList;
    }

    public function getAvailableMusicEventsByDate($availableEvents, $date)
    {
        $newList = array();
        foreach ($availableEvents as $availableEvent) {
            if ($availableEvent['AvailableEvent']->getEventDate() == $date) {
                array_push($newList, $availableEvent);
            }
        }
        return $newList;
    }

}
