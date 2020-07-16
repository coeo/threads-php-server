<?php
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
spl_autoload_register('apiAutoload');
function apiAutoload($classname)
{
    if ($classname == 'Controller'){
      return false;
    } elseif (preg_match('/[a-zA-Z]+Controller$/', $classname)) {
        include __DIR__ . '/controllers/' . $classname . '.php';
        return true;
    } elseif (preg_match('/[a-zA-Z]+Model$/', $classname)) {
        include __DIR__ . '/models/' . $classname . '.php';
        return true;
    } elseif (preg_match('/[a-zA-Z]+View$/', $classname)) {
        include __DIR__ . '/views/' . $classname . '.php';
        return true;
    } else {
        include __DIR__ . '/library/' . str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
        return true;
    }
    return false;
}


$request = new Request();
try{
  // route the request to the right place
  $controllerElement = 0;
  if(isset($request->url_elements[$controllerElement])){
    $controller_name = ucfirst($request->url_elements[$controllerElement]) . 'Controller';
    if (class_exists($controller_name)) {
      http_response_code(200);
      //$data = $request->parameters;
      $controller = new $controller_name();
      $controller->element = $controllerElement+1;
      $action_name = strtolower($request->verb) . 'Action';
      if(method_exists($controller, $action_name)) {
        $result = $controller->$action_name($request);
      } else {
        $result = array(
          'status' => 'ERROR',
          'message' => 'Request method unavailable!'
        );
      }
      $view_name = ucfirst($request->format) . 'View';
      if(class_exists($view_name)) {
        $view = new $view_name();
        $view->render($result);
      }
    } else {
      http_response_code(404);
    }
  } else {
    http_response_code(404);
  }
} catch(Exception $e){
  $result['status'] = 'ERROR';
  $result['message'] = $e->getMessage();

  $view_name = ucfirst($request->format) . 'View';
  if(class_exists($view_name)) {
      $view = new $view_name();
      $view->render($result);
  }
}
?>
