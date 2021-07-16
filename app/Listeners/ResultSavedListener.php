<?php

namespace App\Listeners;

use Exception;
use App\Events\ResultSavedEvent;
use App\Services\UserProgressService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResultSavedListener
{
    /**
     * @var UserProgressService
     */
    private UserProgressService $userProgressService;

    /**
     * ResultSavedListener constructor.
     *
     * @param UserProgressService $service
     */
    public function __construct(UserProgressService $service)
    {
        $this->userProgressService = $service;
    }

    /**
     * Handle the event.
     *
     * @param ResultSavedEvent $event
     *
     * @throws Exception
     */
    public function handle(ResultSavedEvent $event): void
    {
        $this->userProgressService->checkUserProgress($event);
    }
}
