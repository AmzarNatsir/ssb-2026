<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearWorkhsopSettingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workshop_settings:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear workshop settings';

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
    public function handle()
    {
        try {
            Storage::delete('settings/workshop');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
