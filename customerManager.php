<?php

class CustomerManager {
    private $dataFile = 'customerData.json'; // Change to the correct file for customers
    private $customerList = [];

    public function __construct(){
        if (file_exists($this->dataFile)){
            $data = file_get_contents($this->dataFile);
            $this->customerList = json_decode($data, true) ?? [];
        }
    

    // Other methods remain the same...
}

    // Menambahkan customer
    public function tambahCustomer($nama, $no){
        $id = uniqid(); // Generate a unique ID for the customer
        $customer = ['id' => $id, 'nama' => $nama, 'no' => $no]; // Create an associative array for the customer
        $this->customerList[] = $customer; // Add the customer to the list
        $this->simpanData(); // Save the updated list to the file
        return $id; // Return the new customer ID
    }

    // Mendapatkan semua customer
    public function getCustomer(){
        return $this->customerList;
    }

    // Menghapus customer
    public function hapusCustomer($id){
        $this->customerList = array_filter($this->customerList, function($customer) use($id){
            return $customer['id'] !== $id; // Filter out the customer with the given ID
        });
        $this->simpanData(); // Save the updated list to the file
    }

    // Menyimpan data
    private function simpanData(){
        file_put_contents($this->dataFile, json_encode($this->customerList, JSON_PRETTY_PRINT));
    }

    // Mendapatkan customer berdasarkan nama
    public function getCustomerByName($name) {
        foreach ($this->customerList as $customer) {
            if (strcasecmp($customer['nama'], $name) === 0) { // Case-insensitive comparison
                return $customer; // Return the customer if found
            }
        }
        return null; // Return null if no customer is found
    }
}
?>