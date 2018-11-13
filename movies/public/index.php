<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;
$container = $app->getContainer();

//db setup
$container['db'] = function($c) {
    $database = $user = $password = "sakila";
    $host = "mysql";

    return new PDO("mysql:host={$host};dbname={$database};charset=utf8", $user, $password);
};

//movies routes
$app->get('/movies', function (Request $request, Response $response, array $args) {
  $db = $this->get('db');

  //sets variables from header info
  $title = ($request->getHeader('HTTP_TITLE'))[0];
  if ($request->hasHeader('HTTP_CATEGORIES')) {
    $categories = explode(',', $request->getHeaderLine('HTTP_CATEGORIES'));
  } else {
    $categories = array();
  }
  if ($request->hasHeader('HTTP_RATINGS')) {
    $ratings = explode(',', $request->getHeaderLine('HTTP_RATINGS'));
  } else {
    $ratings = array();
  }

  //creates base query
  $query = "SELECT * FROM nicer_but_slower_film_list WHERE title LIKE '%$title%'";

  //adds ? for escaped queries for catory and ratings then binding them
  if (count($categories)>0) {
    if (count($ratings)>0) {
      $cin = join(',', array_fill(0, count($categories), '?'));
      $rin = join(',', array_fill(0, count($ratings), '?'));

      $query = $query." AND category IN ($cin) AND rating IN ($rin)";
      $sth = $this->db->prepare($query);
      foreach ($categories as $key => $cat)
        $sth->bindValue(($key+1), $cat);
      foreach ($ratings as $key => $ratings)
        $sth->bindValue(($key+1+count($categories)), $ratings);
    } else {
      $cin = join(',', array_fill(0, count($categories), '?'));

      $query = $query." AND category IN ($cin)";
      $sth = $this->db->prepare($query);
      foreach ($categories as $key => $cat)
        $sth->bindValue(($key+1), $cat);
    }
  } elseif (count($ratings)>0) {
    $rin = join(',', array_fill(0, count($ratings), '?'));

    $query = $query." AND rating IN ($rin)";
    $sth = $this->db->prepare($query);
    foreach ($ratings as $key => $ratings)
      $sth->bindValue(($key+1), $ratings);
  } else {
    $sth = $this->db->prepare($query);
    $sth->execute();
    $list = $sth->fetchAll();
  }

  //returns final query
  $sth->execute();
  $list = $sth->fetchAll();

  return $response->withJson($list);
});

$app->get('/movies/{id}', function (Request $request, Response $response, array $args) {
    $db = $this->get('db');

    $sth = $this->db->prepare("SELECT * FROM nicer_but_slower_film_list WHERE FID=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $movie = $sth->fetchObject();

    return $response->withJson($movie);
});

$app->run();
