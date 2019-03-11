<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 02.11.18
 * Time: 11:25
 */
return [
        'channels' => [
                'stack'   => [
                        'driver'   => 'stack',
                    // Add bugsnag to the stack:
                        'channels' => ['single', 'bugsnag'],
                ],

            // ...

            // Create a bugsnag logging channel:
                'bugsnag' => [
                        'driver' => 'bugsnag',
                ],
        ],
];