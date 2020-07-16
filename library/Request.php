<?php
  class Request {
    public $url_elements;
    public $verb;
    public $parameters;

    public function __construct() {
      if(isset($_SERVER['REQUEST_URI'])){
        $this->verb = $_SERVER['REQUEST_METHOD'];
        $this->url_elements = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));

        for($i = 0; $i < count($this->url_elements); $i++){
          if($this->url_elements[$i] != ""){
            $this->url_elements[$i] = current(explode('?', $this->url_elements[$i]));
          } else {
            array_splice($this->url_elements, $i, 1);
          }

        }

        $this->parseIncomingParams();
        // initialise json as default format
        $this->format = 'json';
        if(isset($this->parameters['format'])) {
            $this->format = $this->parameters['format'];
        }
        return true;
      } else {
        return false;
      }

    }

    public function parseIncomingParams() {
      $parameters = array();

      // first of all, pull the GET vars
      if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') {
        parse_str($_SERVER['QUERY_STRING'], $parameters);
      }

      // now how about PUT/POST bodies? These override what we got from GET
      $body = file_get_contents("php://input");
      $content_type = false;
      if(isset($_SERVER['CONTENT_TYPE'])) {
        $content_type = str_replace(';charset=UTF-8', '',  $_SERVER['CONTENT_TYPE']);
      }      switch($content_type) {
        case "application/json":
          $body_params = json_decode($body);
          if($body_params) {
            foreach($body_params as $param_name => $param_value) {
              $parameters[$param_name] = $param_value;
            }
          }
          $this->format = "json";
          break;
        case "application/x-www-form-urlencoded":
          parse_str($body, $postvars);
          foreach($postvars as $field => $value) {
            $parameters[$field] = $value;
          }
          if(isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] == "application/json, text/javascript, */*; q=0.01"){
            $this->format = "json";
          } else {
            $this->format = "html";
          }
          break;
        default:
          // we could parse other supported formats here
          break;
      }
      $this->parameters = $parameters;
    }
  }
?>
