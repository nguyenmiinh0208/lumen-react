<?php
/**
 * Class TodoEventSubscriber
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Listeners;

use App\Events\TodoCreated;
use App\Events\TodoDeleted;
use App\Events\TodoUpdated;
use App\Jobs\AddTodoToSearch;
use Illuminate\Contracts\Cache\Repository as Cache;

/**
 * Class TodoEventSubscriber
 *
 * Subscribes to Todos events.
 */
class TodoEventSubscriber
{
    protected $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle todos created events.
     *
     * @param TodoCreated $event
     */
    public function onTodoCreated($event)
    {
        // Add to Elasticsearch index
        dispatch((new AddTodoToSearch($event->todo))->onQueue('low'));

        // Clear user's Todos caches
        $this->cache->forget('todosByUserId_' . $event->todo->user_id);
    }

    /**
     * Handle todos updated events.
     *
     * @param TodoUpdated $event
     */
    public function onTodoUpdated($event)
    {
        // Clear user's Todos caches
        $this->cache->forget('todosByUserId_' . $event->todo->user_id);
        // do something else
    }

    /**
     * Handle todos deleted events.
     *
     * @param TodoDeleted $event
     */
    public function onTodoDeleted($event)
    {
        // Clear user's Todos caches
        $this->cache->forget('todosByUserId_' . $event->todo->user_id);
        // do something else
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        // @codeCoverageIgnoreStart
        $events->listen(
            'App\Events\TodoCreated',
            'App\Listeners\TodoEventSubscriber@onTodoCreated'
        );

        $events->listen(
            'App\Events\TodoUpdated',
            'App\Listeners\TodoEventSubscriber@onTodoUpdated'
        );

        $events->listen(
            'App\Events\TodoDeleted',
            'App\Listeners\TodoEventSubscriber@onTodoDeleted'
        );
        // @codeCoverageIgnoreEnd
    }
}
