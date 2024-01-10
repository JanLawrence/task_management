<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class DeleteTrashedTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $tasks = Task::onlyTrashed()->get();

        foreach($tasks as $each){
            $id = $each->id;
            $each->forceDelete();
            $this->info('Task id('.$id.') deleted');
        }

        $this->info('Tasks deleted permanently!');
    }
}
