<?php
  include_once 'library/functions.php';

  class ThreadsModel{
    public $searchTerm;

    public function search(){
      if(isset($this->searchTerm)) {
        $this->searchTerm = sanitizeString($this->searchTerm);
        $result = queryMySQL("SELECT name, address FROM threads WHERE name LIKE '$this->searchTerm'");
        $threads = array();
        if($result->num_rows != 0){
          while($row = $result->fetch_assoc()){
            $threads[] = array(
              'name' => $row['name'],
              'address' => $row['address']
            );
          }
        }
        return $threads;
      } else {
        throw new Exception('Parameters not set!');
      }
    }

    public function retrieve(){
      $result = queryMySQL("SELECT name, address FROM threads");
      $threads = array();
      if($result->num_rows != 0){
        while($row = $result->fetch_assoc()){
          $threads[] = array(
            'name' => $row['name'],
            'address' => $row['address']
          );
        }
      }
      return $threads;
    }
  }
?>
