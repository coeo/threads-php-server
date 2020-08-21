<?php
  include_once 'library/functions.php';

  class ThreadModel{
    public $id;
    public $name;
    public $address;
    public $firstModerator;
    public $context;

    public function add(){
      if(isset($this->name) && isset($this->address)) {
        $this->name = sanitizeString($this->name);
        $this->address = sanitizeString($this->address);
        $this->firstModerator = sanitizeString($this->firstModerator);
        $this->context = sanitizeString($this->context);
        queryMySQL("INSERT INTO threads(name, address, firstModerator, context) VALUES ('$this->name', '$this->address', '$this->firstModerator', '$this->context')");
        $this->id = insertID();
      } else {
        throw new Exception('Parameters not set!');
      }
    }

    public function retrieve(){
      if(isset($this->id)) {
        $result = queryMySQL("SELECT name, address, firstModerator FROM threads WHERE id='$this->id'");
        if($result->num_rows == 0){
          //Respond with an error
  				throw new Exception('Thread not found!');
        } else {
          while($row = $result->fetch_assoc()){
            $this->name = $row['name'];
            $this->address = $row['address'];
            $this->firstModerator = $row['firstModerator'];
          }
        }
      } else {
        throw new Exception('ID not set!');
      }
    }
  }
?>
