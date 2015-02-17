<?php

/**
 * Class ExamplePlugin
 * @name Example Plugin
 * @version 1.0.1
 * @author creatorfromhell
 * @license GNU AGPL
 * @link http://examplepluginsite.com
 */
class ExamplePlugin extends Plugin {

    /**
     * @return mixed
     */
    public function enable()
    {
        // TODO: Implement enable() method.
    }

    /**
     * @return mixed
     */
    public function disable()
    {
        // TODO: Implement disable() method.
    }

    /**
     * @hook-callback
     * @hook user_login_hook
     * @priority 3
     */
    public function ExampleHookCallback($hook_arguments) {
        //TODO: Do something.
    }

    /**
     * @hook-callback
     * @hook task_created_hook
     * @priority 1
     */
    public function AnotherHookCallback($hook_arguments) {
        //TODO: Do something.
    }
}

?>