<?php
  namespace li3_airbrake\models;

  use SimpleXMLElement;

  class Payload {

    private $config;
    private $exception;

    public function __construct($exception,$config) {
      $this->exception = $exception;
      $this->config = $config;
    }

    public function toXML() {
      $doc = new SimpleXMLElement('<notice />');
      $doc->addAttribute('version', $this->config['version']);

      $doc->addChild('api-key', $this->config['apiKey']);

      $notifier = $doc->addChild('notifier');
      $notifier->addChild('name', $this->config['name']);
      $notifier->addChild('version', $this->config['version']);
      $notifier->addChild('url', $this->config['repo']);

      $error = $doc->addChild('error');
      $error->class = $this->exception->exception;
      $error->message = $this->exception->message;

      $backtrace = $error->addChild('backtrace');
      foreach($this->exception->trace as $trace) {
        $line = $backtrace->addChild('line');
        $line->addAttribute('file', $trace[0]);
        $line->addAttribute('number', $trace[1]);
        $line->addAttribute('method', $trace[2]);
      }

      $request = $doc->addChild('request');
      $request->addChild('url', $this->exception->url);
      $request->addChild('component',$this->exception->controller);
      $request->addChild('action',$this->exception->action);

      $cgi = $request->addChild('cgi-data');
      $server = $cgi->addChild('var',$this->exception->cgi['SERVER_NAME'])->addAttribute('key','SERVER_NAME');
      $agent = $cgi->addChild('var',$this->exception->cgi['HTTP_USER_AGENT'])->addAttribute('key','HTTP_USER_AGENT');

      $env = $doc->addChild('server-environment');
      $env->addChild('project-root',$this->exception->cgi['DOCUMENT_ROOT']);
      $env->addChild('environment-name','production');
      $env->addChild('app-version','1.0');

      $doc->asXML('/home/gary/xml.xml');

      return $doc->asXML();
    }
  }
?>
