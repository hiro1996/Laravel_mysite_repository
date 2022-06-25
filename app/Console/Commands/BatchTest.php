<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BatchTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batchtest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'バッチの実行テスト';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $msg = '['.date('Y-m-d H:i:s'). ']UserCount:';
        $this->info($msg);
        Log::setDefaultDriver('batch');
        Log::info($msg);
        echo date("YmdHis\n");
    }
}
