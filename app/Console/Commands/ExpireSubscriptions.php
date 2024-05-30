<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ExpireSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire user subscriptions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        Log::info('Subscription expiration task started');

        $expiredUsers = User::where('subscription_expires_at', '<', now())->get();
        Log::info('Expired users count: ' . $expiredUsers->count());

        $expiredUsers->each(function($user) {
            Log::info('Expiring subscription for user ID: ' . $user->id);
            $user->update(['subscription_expires_at' => null]);
        });

        Log::info('Subscription expiration task completed');

        return 0;
    }
}
