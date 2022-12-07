<?php

namespace App\Jobs\Customer\Card;

use App\Models\Customer\CustomerCreditCard;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LimitWithdrawJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected CustomerCreditCard $card, protected float $old_limit)
    {
    }

    public function handle()
    {
        $this->card->update(['limit_retrait' => $this->old_limit]);
    }
}
