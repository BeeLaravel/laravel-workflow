<?php
namespace Picr\LaravelWorkflow\Facades;

use Illuminate\Support\Facades\Facade;

class WorkflowFacade extends Facade {
    protected static function getFacadeAccessor() {
        return 'workflow';
    }
}
