<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\SendMail;
use Carbon;
use App\Models\Customer;
use App\Models\Warning;
use DB;
use App\Console\Kernel;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'warning:sendmail';

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
     * @return mixed
     */
    public function handle()
    {
        //Place warning condition here

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $now = Carbon::now();

        $warning = Warning::find(\Session::get('id'));

        $customers = DB::table('warnings')->where('created_customer_at', '<', $now->subDays($warning->duration)->addDays($warning->warning_before))->orWhere('duration', '>', $warning->duration)->pluck('name');
        
        foreach($customers as $customer)
        {
            if($warning->name == $customer)
            {
                $data = $warning->name;
            }
        }
        if(isset($data))
        {
            $email = new SendMail($data);
            Mail::to('gnoht1111@gmail.com')->send($email);
            return back()->with('success', 'Thanks for contacting us!');
        }

        //Place warning condition here
    }
}
