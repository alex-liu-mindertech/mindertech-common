<?php
/**
 * Created by PhpStorm.
 * User: alex.liu (alex.liu@mindertech.co.uk)
 * Date: 2020/7/1
 * Date: 19:28
 */

namespace MinderTech\Log\RecordSql;

use Illuminate\Support\Facades\Log;

class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {

        foreach ($event->bindings as $i => $binding) {
            if ($binding instanceof \DateTime) {
                $event->bindings[$i] = $binding->format("'Y-m-d H:i:s'");
            } else {
                if (is_string($binding)) {
                    $event->bindings[$i] = "'$binding'";
                }
            }
        }

        // Insert bindings into query
        $sql = str_replace(array('%', '?'), array('%%', '%s'), $event->sql);
        $sql = vsprintf($sql, $event->bindings);

        Log::debug($sql);
    }
}
