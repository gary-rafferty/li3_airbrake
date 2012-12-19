<?php
  namespace li3_airbrake\models;

  class Error {

    public $exception;
    public $message;
    public $request;
    public $url;
    public $controller;
    public $action;
    public $trace = array();
    public $cgi = array();

    public function __construct($exception) {
      $this->exception = get_class($exception->exception);
      $this->message = $exception->message;
      $this->request = $exception->trace[0]['args'][0]->request;
      $this->url = $exception->trace[0]['args'][0]->request->url;
      $this->controller = $exception->trace[0]['args'][0]->request->controller;
      $this->action = $exception->trace[0]['args'][0]->request->action;
      foreach($exception->trace as $trace) {
        $this->trace[] = array(
          $trace['file'],
          $trace['line'],
          $trace['function']
        );
      }
      foreach($_SERVER as $key => $val) {
        $this->cgi[$key] = $val;
      }
    }
  }
?>
