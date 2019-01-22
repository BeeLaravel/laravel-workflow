<?php
namespace Picr\LaravelWorkflow\Events;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
use Event as LaravelEvent;

class EventDispatcher implements EventDispatcherInterface {
    public function dispatch($eventName, Event $event = null) {
        LaravelEvent::fire($eventName, $event);
    }
    public function addListener($eventName, $listener, $priority = 0) {}
    public function addSubscriber(EventSubscriberInterface $subscriber) {}
    public function removeListener($eventName, $listener) {
    }
    public function removeSubscriber(EventSubscriberInterface $subscriber) {}
    public function getListeners($eventName = null) {}
    public function hasListeners($eventName = null) {}
}