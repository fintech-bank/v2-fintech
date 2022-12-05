<?php

namespace App\Jobs\Customer\Transfer;

use App\Models\Core\Agency;
use App\Models\Customer\CustomerTransferAgency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteTransferAgencyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private CustomerTransferAgency $transferAgency)
    {
    }

    public function handle()
    {
        $this->transferAgency->delete();
    }
}
