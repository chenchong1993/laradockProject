<?php

namespace App\Jobs;

use App\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class FirmwareUpgrade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $devices = Device::all();
        $fu_data = json_decode($this->data);
        foreach ($devices as $device){
            DB::table('devices')->where('id',$device->id)->update(['fu_url'=>$fu_data->fu_url,'fu_md5'=>$fu_data->fu_md5,'updated_flag'=>2]);
        }
    }
}
