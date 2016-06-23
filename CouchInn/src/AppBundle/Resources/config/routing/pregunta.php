<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('pregunta_index', new Route(
    '/',
    array('_controller' => 'AppBundle:Pregunta:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('pregunta_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:Pregunta:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('pregunta_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:Pregunta:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('pregunta_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:Pregunta:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('pregunta_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:Pregunta:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
