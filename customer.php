<?php


class customer{
    public $id;
    public $nama;
    public $nomorTelepon;
   

    public function __construct($id,$nama,$nomorTelepon){
        $this->id = $id;
        $this->nama = $nama;
        $this->no = $nomorTelepon;
    }
}
?>