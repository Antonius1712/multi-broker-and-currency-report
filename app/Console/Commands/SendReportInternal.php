<?php

namespace App\Console\Commands;

use App\Models\CollectionEmailInternal;
use App\Models\LogSendingCollection;
use App\Models\LogSendingCollectionInternal;
use Illuminate\Console\Command;

class SendReportInternal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:monthly-report-internal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Monthly Report by e-email to Internal Lippo.';

    private $DataLogSendingcollectionInternalThisMonth, $date, $RED, $GREEN, $LC, $NC, $YELLOW, $CollectionEmailInternal, $CC;

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

        $this->CC = [
            'rinto@lippoinsurance.com', 
            'finance07.ho@lippoinsurance.com',
            'finance01.ho@lippoinsurance.com',
            'finance02.karawaci@lippoinsurance.com',
            'yekti@lippoinsurance.com'
        ];

        //! GET DATA LOG.
        //* FILTERED BY LAST MONTH, AND YEAR OF LAST MONTH. 
        $this->DataLogSendingcollectionInternalThisMonth = LogSendingCollectionInternal::
            // whereYear('created_at', date('Y', strtotime( now()->firstOfMonth()->subDays(1) )))
            // ->whereMonth('created_at', date('m', strtotime( now()->firstOfMonth()->subDays(1) )))
            // ->
            where('email_sent', null)
        ->get();

        $this->CollectionEmailInternal = CollectionEmailInternal::pluck('email');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //! DATA LOG IS ON CONSTRUCT.
        if( count( $this->DataLogSendingcollectionInternalThisMonth ) > 0 ){
            $this->info($this->LC."Sending Email...");
            $this->output->progressStart(COUNT( $this->DataLogSendingcollectionInternalThisMonth ));
        }else{
            $this->info($this->GREEN."All Email Sent, Nothing to Sent.");
        }

        $PARAM = '';
        foreach( $this->DataLogSendingcollectionInternalThisMonth as $val ){
            $emailTemplate = 'email.sent-monthly-report-internal';
            $destination_path = storage_path('app/public/report/monthly_report/zipped/Monthly_Report_Broker_'.date('Y', strtotime(now())).'_'.date('M', strtotime(now())).'.zip');

            $PARAM = [
                'body' => $val->email_body,
                'date' => $this->date
            ];

            \Mail::send($emailTemplate, 
                $PARAM,
                function ($mail) use ($val, $destination_path) {
                    $mail->from(config('app.NO_REPLY_EMAIL'), config('app.name'));
                    $mail->to($val->email);
                    // $mail->cc(['it-dba07@lippoinsurance.com']);
                    $mail->cc($this->CC);
                    $mail->bcc('it-dba01@lippoinsurance.com');
                    $mail->attach($destination_path);
                    // $mail->to($val->collection_email->pic_emailed_by_finance);
                    // $mail->cc('it-dba07@lippoinsurance.com');
                    $mail->subject($val->email_subject);
                }
            ); 

            $val->email_sent = 'yes';
            $val->save();

            if( count( $this->DataLogSendingcollectionInternalThisMonth ) > 0 ){
                $this->output->progressAdvance();
            }
        }
        if( count( $this->DataLogSendingcollectionInternalThisMonth ) > 0 ){
            $this->output->progressFinish();
            $this->info($this->GREEN."All Email Sent.");
        }
    }
}
