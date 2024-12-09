<?php

class BarangManager {
    private $dataFile = 'Data.json';
    private $barangList = [];

    public function __construct(){
        if (file_exists($this->dataFile)){
            $data = file_get_contents($this->dataFile);
            $this->barangList = json_decode($data,true) ??[];
        }
    }
// menambahkan barang
    public function tambahBarang($nama,$harga,$stok){
        $id = uniqid();
        $barang = new Barang($id, $nama, $harga, $stok);
        $this->barangList[]=$barang;
        $this->simpanData();
    }
//mendapatkan semua barang
    public function getBarang(){
     return $this->barangList;
    }
    //menghapus barang
    public function hapusBarang($id){
        $this->barangList= array_filter($this->barangList, function($barang) use($id){
            return $barang['id'] !== $id;
        });
        $this->simpanData();
    }
//menyimpan data
    private function simpanData(){
        file_put_contents($this->dataFile, json_encode($this->barangList, JSON_PRETTY_PRINT));
    }
}