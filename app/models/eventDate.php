<?php

class eventDate
{
    private string $date;
    private string $day;
    private \Cassandra\Date $month;

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @param string $day
     */
    public function setDay(string $day): void
    {
        $this->day = $day;
    }
    
     public function getEventDay() : string
   {
        $date = $this->getDate();
        $day = date('l', strtotime($date));
        return $day;
   }

   public function getFormattedEventDate() : string
   {
     $date = $this->date;
     return date('d, F, Y', strtotime($date));
   }
    
    
    
    
    

}
