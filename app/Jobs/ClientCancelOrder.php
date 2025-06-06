<?php

namespace App\Jobs;

use App\Events\ClientCancelOrderEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClientCancelOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $obj;
    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new ClientCancelOrderEvent($this->obj));
    }
}
