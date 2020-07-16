<?php
  class ThreadsController
  {
    public function getAction($request){
      $data = $request->parameters;
      if(isset($data['search'])) {
        try {
          $threads = new ThreadsModel();
          $threads->searchTerm = $data['search'];
          $response['threads'] = $threads->search();
          $response['status'] = 'OK';
        } catch(Exception $e){
          $response['status'] = 'ERROR';
          $response['message'] = $e->getMessage();
        }
      } else {
        try {
          $threads = new ThreadsModel();
          $response['threads'] = $threads->retrieve();
          $response['status'] = 'OK';
        } catch(Exception $e){
          $response['status'] = 'ERROR';
          $response['message'] = $e->getMessage();
        }
      }
      return $response;
    }

    public function postAction($request){
      $data = $request->parameters;
      if(isset($data['name']) && isset($data['address'])) {
        try {
          $thread = new ThreadModel();
          $thread->name = $data['name'];
          $thread->address = $data['address'];
          $thread->add();
          if(isset($thread->id)){
            if(isset($data['hashtags'])){

            }
            $response['status'] = 'OK';
          } else {
            throw new Exception('Failed to post data!');
          }
        } catch(Exception $e){
          $response['status'] = 'ERROR';
          $response['message'] = $e->getMessage();
        }
      } elseif(isset($data['id'])){
        try {
          $thread = new ThreadsModel();
          $thread->id = $data['id'];
          if(isset($data['hashtags'])){

          }
        } catch(Exception $e){
          $response['status'] = 'ERROR';
          $response['message'] = $e->getMessage();
        }

      } else {
        $response['status'] = 'ERROR';
        $response['message'] = 'Parameters not set!';
      }
      return $response;
    }
  }
?>
