<?php

class Router
{
  private $request;
  private $supportedHttpMethods = array(
    "GET",
    "POST"
  );

  function __construct(IRequest $request)
  {
    $this->request = $request;
  }

  function __call($name, $args)
  {
    list($route, $method) = $args;

    if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
      $this->invalidMethodHandler();
    }

    $this->{strtolower($name)}[$this->formatRoute($route)] = $method;
  }

  /**
   * Removes trailing forward slashes from the right of the route.
   * @param route (string)
   */
  private function formatRoute($route)
  {
    $result = explode('?', $route)[0];
    $result = rtrim($result, '/');
    $result = str_replace(BASEURL, '', $result);
    if ($result === '') {
      return '/';
    }
    return $result;
  }

  private function invalidMethodHandler()
  {
    header("{$this->request->serverProtocol} 405 Method Not Allowed");
    echo "{$this->request->serverProtocol} 405 Method Not Allowed";
  }

  private function defaultRequestHandler()
  {
    $formatedRoute = $this->formatRoute($this->request->requestUri);
    
    header("{$this->request->serverProtocol} 404 Not Found");
    echo "{$this->request->serverProtocol} 404 Not Found <br>{$formatedRoute}";
  }

  /**
   * Resolves a route
   */
  function resolve()
  {
    $methodDictionary = $this->{strtolower($this->request->requestMethod)};
    $formatedRoute = $this->formatRoute($this->request->requestUri);
    // var_dump($methodDictionary, $formatedRoute);
    // $method = $methodDictionary[$formatedRoute];
    
    if (!isset($methodDictionary[$formatedRoute]) || is_null($methodDictionary[$formatedRoute])) {
      $this->defaultRequestHandler();
      return;
    }

    echo call_user_func_array($methodDictionary[$formatedRoute], array($this->request));
  }

  function __destruct()
  {
    $this->resolve();
  }
}
