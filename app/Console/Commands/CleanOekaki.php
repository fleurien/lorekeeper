<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanOekaki extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean-oekaki';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes temporary files.';

    /**
     * Create a new command instance.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //
        $this->info('*********************');
        $this->info('*   CLEAN OEKAKI    *');
        $this->info('*********************'."\n");

        $this->line("Cleaning oekaki files...\n");

        $files = glob(public_path('images/oekaki/*'));
        $now = Carbon::now();

        foreach ($files as $file) {
            $filetime = Carbon::createFromTimestamp(filemtime($file));
            $diff = $now->diffInMinutes($filetime);
            if ($diff > 5) {
                $this->line('Removing '.$file);
                unlink($file);
            }
        }
        $this->line("\nDone!");
    }
}
