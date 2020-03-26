<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Application;
use App\Hit;

class HitApplications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hit:applications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Multiple application hits';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $apps=Application::where('enabled',true)->get();
        foreach($apps as $app){
            $host=$app->url;
            $ch = curl_init($host);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if($httpcode==200 ){
                $hit=new Hit();
                $hit->application_id=$app->id;
                $hit->status="Up";
                $hit->note="Response Code : 200";
                $hit->hit_by="Automatic";
                $hit->save();

                $app->status=true;
                $app->save();
            }else{
                $hit=new Hit();
                $hit->application_id=$app->id;
                $hit->status="Down";
                $hit->note="Response Code : ".$httpcode;
                $hit->hit_by="Automatic";
                $hit->save();

                $app->status=false;
                $app->save();
            }
        }
    }
}
