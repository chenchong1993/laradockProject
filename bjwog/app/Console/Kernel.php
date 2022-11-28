<?php

namespace App\Console;

use DB;
use App\Config;
use App\Device;
use App\Robot;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        /**
         * 维护设备下线状态
         */
        $schedule->call(function () {
            // for ($i=0; $i <30; $i++) { 
            //     // DB::table('users')->update(['status'=>0]);
            //     DB::table('devices')->update(['status'=>0]);
            //     sleep(2);
            // }
            // DB::table('users')->update(['status'=>0]);
            DB::table('devices')->update(['status'=>0]);
        })->everyMinute();  
        

        /**
         * 机器人存图
         */
        $schedule->call(function () {
            $ysy_token = Config::where('name','YSY_ACCESS_TOKEN')->first()->value;

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => YSY_GET_IMG_URL,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('accessToken' => $ysy_token,'deviceSerial' => YSY_DEVICE_ID_1),
            ));

            $output = curl_exec($curl);

            $robot = Robot::find(1);

            for ($i=0; $i <12 ; $i++) { 
               $output = curl_exec($curl);
        //        Log::info($output);
               if(json_decode($output,true)['code'] == 200){
                    $img_name = YSY_DEVICE_ID_1.date("Y-m-d-H:i:s").".jpg";
                    file_put_contents(public_path('storage/img/YYS/').$img_name, file_get_contents(json_decode($output,true)['data']['picUrl']));
                    $device = Device::where('device_id',$robot->device_id)->first();
                    DB::table('past_robot_imgs')->insert([
                            'robot_id'=>1,
                            'x' => $device->x,
                            'y' => $device->y,
                            'z' => $device->z,
                            'lng' => $device->lng,
                            'lat' => $device->lat,
                            'h' => $device->h,
                            'img_url' => $img_name,
                            'created_at' => date('Y-m-d H:i:s', time())
                        ]);
               }
                sleep(5);
            }
            curl_close($curl);

        })->everyMinute();      
        $schedule->call(function () {
            $ysy_token = Config::where('name','YSY_ACCESS_TOKEN')->first()->value;

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => YSY_GET_IMG_URL,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('accessToken' => $ysy_token,'deviceSerial' => YSY_DEVICE_ID_2),
            ));

            $output = curl_exec($curl);

            $robot = Robot::find(2);

            for ($i=0; $i <12 ; $i++) { 
               $output = curl_exec($curl);
     //           Log::info($output);
               if(json_decode($output,true)['code'] == 200){
                    $img_name = YSY_DEVICE_ID_2.date("Y-m-d-H:i:s").".jpg";
                    file_put_contents(public_path('storage/img/YYS/').$img_name, file_get_contents(json_decode($output,true)['data']['picUrl']));
                    $device = Device::where('device_id',$robot->device_id)->first();
                    DB::table('past_robot_imgs')->insert([
                            'robot_id'=>2,
                            'x' => $device->x,
                            'y' => $device->y,
                            'z' => $device->z,
                            'lng' => $device->lng,
                            'lat' => $device->lat,
                            'h' => $device->h,
                            'img_url' => $img_name,
                            'created_at' => date('Y-m-d H:i:s', time())
                        ]);
               }
                sleep(5);
            }
            curl_close($curl);

        })->everyMinute();  
        $schedule->call(function () {
            $ysy_token = Config::where('name','YSY_ACCESS_TOKEN')->first()->value;

            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => YSY_GET_IMG_URL,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('accessToken' => $ysy_token,'deviceSerial' => YSY_DEVICE_ID_3),
            ));

            $output = curl_exec($curl);

            $robot = Robot::find(3);

            for ($i=0; $i <12 ; $i++) { 
               $output = curl_exec($curl);
      //          Log::info($output);
               if(json_decode($output,true)['code'] == 200){
                    $img_name = YSY_DEVICE_ID_3.date("Y-m-d-H:i:s").".jpg";
                    file_put_contents(public_path('storage/img/YYS/').$img_name, file_get_contents(json_decode($output,true)['data']['picUrl']));
                    $device = Device::where('device_id',$robot->device_id)->first();
                    DB::table('past_robot_imgs')->insert([
                            'robot_id'=>3,
                            'x' => $device->x,
                            'y' => $device->y,
                            'z' => $device->z,
                            'lng' => $device->lng,
                            'lat' => $device->lat,
                            'h' => $device->h,
                            'img_url' => $img_name,
                            'created_at' => date('Y-m-d H:i:s', time())
                        ]);
               }
                sleep(5);
            }
            curl_close($curl);

        })->everyMinute();  
        /**
         * 维护电子围栏状态 
         */
		$schedule->call(function () {

		$now_time = date('Y-m-d h:i:s', time());

		$electric_fences = DB::table('electric_fences')->whereNotNull('time_list')->get();
		foreach ($electric_fences as $electric_fence){
		    $time_list = json_decode($electric_fence->time_list,TRUE);
		    if(!$time_list[0])
		        return err(1,"time list 为空！");
		    foreach ($time_list as $time){

		        if ($now_time >= $time[0] && $now_time <= $time[1]){
		            DB::table('electric_fences')
		                ->where('id',$electric_fence->id)
		                ->update(['status' => 1]);
                        break;
		        }else{
		            DB::table('electric_fences')
		                ->where('id',$electric_fence->id)
		                ->update(['status' => 0]);
			        }
			    }
			}	        	
         })->everyMinute();  
         

        /**
         * 更新YSY token
         */
     	$schedule->call(function () {
          	$curl = curl_init();

	        curl_setopt_array($curl, array(
	          CURLOPT_URL => YSY_GET_TOKEN,
	          CURLOPT_RETURNTRANSFER => true,
	          CURLOPT_ENCODING => '',
	          CURLOPT_MAXREDIRS => 10,
	          CURLOPT_TIMEOUT => 0,
	          CURLOPT_FOLLOWLOCATION => true,
	          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	          CURLOPT_CUSTOMREQUEST => 'POST',
	          CURLOPT_POSTFIELDS => array('appKey' => YSY_APP_KEY,'appSecret' => YSY_APP_SECRET),
	        ));

	        $output = curl_exec($curl);

	        curl_close($curl);

            Log::info($output);

	        $token = json_decode($output,true)['data']['accessToken'];
			       
        	Config::where('name','YSY_ACCESS_TOKEN')->update(['value'=>$token]);
			
         })->weekly();      
   
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
