<?php
class Room {
    public $id;
    public $description;
    public $picture;
    public $roomColor;
    public $price;
    public $postedBy;
    
    public function __construct($id, $description, $picture, $roomColor, $price, $postedBy){
        $this->id = $id;
        $this->description = $description;
        $this->picture = $picture;
        $this->roomColor = $roomColor;
        $this->price = $price;
        $this->postedBy = $postedBy;
    }
?>