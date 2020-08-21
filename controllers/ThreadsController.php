<?php
  class ThreadsController
  {
    public function getAction($request){
      $data = $request->parameters;
      if(isset($data['search'])) {
        try {
          $threads = new ThreadsModel();
          $threads->searchTerm = $data['search'];
          if (isset($data['context'])) {
            $threads->context = $data['context'];
          } else {
            $threads->context = 'global';
          }
          $response['threads'] = $threads->search();
          $response['status'] = 'OK';
        } catch(Exception $e){
          $response['status'] = 'ERROR';
          $response['message'] = $e->getMessage();
        }
      } else {
        try {
          $threads = new ThreadsModel();
          if (isset($data['context'])) {
            $threads->context = $data['context'];
          } else {
            $threads->context = 'global';
          }
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
      if(isset($data['name']) && isset($data['address']) && isset($data['firstModerator'])) {
        try {
          $thread = new ThreadModel();
          $thread->name = $data['name'];
          $thread->address = $data['address'];
          $thread->firstModerator = $data['firstModerator'];
          if (isset($data['context'])) {
            $thread->context = $data['context'];
          } else {
            $thread->context = 'global';
          }
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
