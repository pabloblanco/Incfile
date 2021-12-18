<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SendPost;
use App\Models\Log;

class SendPostsToQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'incfile:sendpoststoqueue {quantityOfPostsToSend}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command was developed to IncFile Interview Exercise';

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
        $quantityOfPostsToSend = $this->argument('quantityOfPostsToSend');
        $this->info("Was created $quantityOfPostsToSend posts, in batch process, these was sended to queue to be requested the server");
        $url = 'https://atomic.incfile.com/fakepost';
        // Create the batch process with high priority for the failed jobs 
        $highPrioritybatch = Bus::batch([])->name('high')->onQueue('high')->dispatch();
        $highPriorityBatchId = $highPrioritybatch->id;        
        //Create an empty work
        $jobs = [];
        //Create the quantity jobs that belong to this batch process indicated in the Artisan Command in the quantityOfPostToSend variable
        for ($count = 1; $count <= $quantityOfPostsToSend; $count++) {
            array_Push($jobs, new SendPost($url, $highPriorityBatchId));
        }
        // Create the normal priority batch process with jobs   
        $batch = Bus::batch($jobs)->then(function (Batch $batch) {
            $log = Log::insert([
                'batchId'   => $batch->id,
                'log'       => 'All jobs completed successfully',
                'help'      => ''
            ]); 
        })->catch(function (Batch $batch, Throwable $e) {
            $log = Log::insert([
                'batchId'   => $batch->id,
                'log'       => 'First batch job failure detected',
                'help'      => 'You can execute from console the command: php artisan queue:failed-table in order to process the failed jobs'
            ]);  
         })->finally(function (Batch $batch) {
            $log = Log::insert([
                'batchId'   => $batch->id,
                'log'       => 'The batch has finished executing',
                'help'      => ''
            ]);               
        })->name('low')->onQueue('low')->dispatch();
        $log = Log::insert([
            'batchId'   => $batch->id,
            'log'       => 'Starting batch process',
            'help'      => ''
        ]);         
        return Command::SUCCESS;
    }
} 
