<?php


namespace entities;
class Place
{

    public $id;

    public $place;

    public $country;

    public function __construct(
        //private ?\classes\DatabaseTable $originalTextsTable,
        //private ?\classes\DatabaseTable $placesTable
    ) {
    }

/*    public function getOriginalTexts()
    {
        return $this->originalTextsTable->find('place_id', $this->id);
    }

    public function getPlaceById()
    {
        return $this->placesTable->find('id', $this->id)[0];
    }
    */
}
