<?php

namespace App\Console\Commands;

use App\Models\CollectionEmail;
use App\Models\CollectionEmailInternal;
use App\Models\LogSendingCollection;
use Illuminate\Console\Command;

class SendReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:monthly-report-broker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Monthly Report by e-email to Broker.';

    private $DataLogSendingcollectionThisMonth, $date, $RED, $GREEN, $LC, $NC, $YELLOW, $CollectionEmailInternal;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->RED = "\033[1;31m";
        $this->GREEN = "\033[1;32m";
        $this->LC = "\033[1;36m"; # Light Cyan
        $this->NC = "\033[0m"; # No Color
        $this->YELLOW = "‘\033[1;33m";

        $this->date = date('m/d/Y', strtotime(now()->firstOfMonth()->subDays(1)));

        //! GET DATA LOG.
        //* FILTERED BY LAST MONTH, AND YEAR OF LAST MONTH. 
        $this->DataLogSendingcollectionThisMonth = LogSendingCollection::
            // whereYear('created_at', date('Y', strtotime( now()->firstOfMonth()->subDays(1) )))
            // ->whereMonth('created_at', date('m', strtotime( now()->firstOfMonth()->subDays(1) )))
            // ->
            where('email_sent', null)
            ->with('collection_email')
        ->get();

        $this->CollectionEmailInternal = CollectionEmailInternal::pluck('email');

        // dd($this->CollectionEmailInternal);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //! DATA LOG IS ON CONSTRUCT.
        if( count( $this->DataLogSendingcollectionThisMonth ) > 0 ){
            $this->info($this->LC."Sending Email...");
            $this->output->progressStart(COUNT( $this->DataLogSendingcollectionThisMonth ));
        }else{
            $this->info($this->GREEN."All Email Sent, Nothing to Sent.");
        }

        $PARAM = '';
        foreach( $this->DataLogSendingcollectionThisMonth as $val ){
            //! HANYA KIRIM KE BROKER DENGAN EMAIL YANG ADA DI COLLECTION EMAIL.
            if( isset($val->collection_email) ){

                $emailTemplate = 'email.sent-monthly-report';
                $destination_path = storage_path('app/public/report/monthly_report/'.date('Y', strtotime(now())).'/'.date('M', strtotime(now())).'/'.$val->id_profile.'.xls');

                $PARAM = [
                    'broker_name' => $val->collection_email->broker_name,
                    'date' => $this->date
                ];
    
                \Mail::send($emailTemplate, 
                    $PARAM,
                    function ($mail) use ($val, $destination_path) {
                        $mail->from(config('app.NO_REPLY_EMAIL'), config('app.name'));
                        $mail->to($this->CollectionEmailInternal);
                        $mail->attach($destination_path);
                        // $mail->to($val->collection_email->pic_emailed_by_finance);
                        // $mail->cc('it-dba07@lippoinsurance.com');
                        $mail->bcc('it-dba01@lippoinsurance.com');
                        $mail->subject('SOA Lippo General Insurance  Broker '.$val->collection_email->broker_name);
                    }
                ); 
    
                $val->email_sent = 'yes';
                $val->save();

                if( count( $this->DataLogSendingcollectionThisMonth ) > 0 ){
                    $this->output->progressAdvance();
                }
            }else{
                $this->info( $this->RED.' not in collection email table.' );
            }

        }
        if( count( $this->DataLogSendingcollectionThisMonth ) > 0 ){
            $this->output->progressFinish();
            $this->info($this->GREEN."All Email Sent.");
        }
    }
}
