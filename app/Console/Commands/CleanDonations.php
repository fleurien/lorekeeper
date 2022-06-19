<?php

namespace App\Console\Commands;

use App\Services\ShopManager;
use Illuminate\Console\Command;

class CleanDonations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean-donations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if there are any donation shop items to delete.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
     public function handle()
    {
        (new ShopManager)->cleanDonations();
    }
}
