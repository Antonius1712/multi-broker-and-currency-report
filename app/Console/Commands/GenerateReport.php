<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Exports\MonthlyReportExport;
use App\Models\CollectionEmail;
use App\Models\CollectionEmailInternal;
use App\Models\LogSendingCollection;
use App\Models\LogSendingCollectionInternal;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class GenerateReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:monthly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating Broker Monthly Report';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected $date, $RED, $GREEN, $LC, $NC;

    public function __construct()
    {
        parent::__construct();
        $this->date = date('m/d/Y', strtotime(now()->firstOfMonth()->subDays(1)));
        $this->RED = "\033[1;31m";
        $this->GREEN = "\033[1;32m";
        $this->LC = "\033[1;36m"; # Light Cyan
        $this->NC = "\033[0m"; # No Color
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', "4096M");
        ini_set('max_execution_time', 0);
        
        // $this->createZip(config('filesystems')['disks']['monthly_report']['root']);

        // dd('s');

        // dd(config('filesystems')['disks']['monthly_report']['root']);

        $this->info($this->GREEN."Starting Process... \n");

        try {
            $this->info($this->LC."Start to do Create Temp Table...");
            //! CREATE TEMP TABLE
                $timeStartCreateTempTable = now();
                DB::connection('SEA_REPORT')->unprepared(
                    DB::raw("

                        Select
                            a.Source as 'id_profile', 
                            p.Name as 'broker_name', 
                            a.Currency, 
                            cob.description as 'Class', 
                            a.Voucher, 
                            a.PolicyNo, 
                            convert(varchar(50),admlink.a_PolicyNo,101) as a_policyNo, 
                            a.ReffNo, 
                            replace(convert(varchar(20), a.BookingDate, 106),' ', '-') as 'BookingDate', 
                            replace(convert(varchar(20), a.DueDate, 106),' ', '-') as 'DueDate', 
                            replace(convert(varchar(20), a.[Starting Polis], 106),' ', '-') as 'starting_polis', 
                            replace(convert(varchar(20), a.[Ending Polis], 106),' ', '-') as 'ending_polis', 
                            a.WPC, 
                            a.Type, 
                            a.Name, 
                            round(a.GrossAmount, 2) as 'GrossAmount', 
                            round(a.Administration, 2) as 'Administration', 
                            round(a.Tax, 2) as 'Tax', 
                            round(a.Vat, 2) as 'Vat', 
                            round(a.Payment, 2) as 'Payment', 
                            round(a.Outstanding, 2) as 'Outstanding', 
                            round(a.UnDue, 2) as 'UnDue', 
                            round(a.[0<=Days<=30], 2) as '0_30_days', 
                            round(a.[31<=days<=45], 2) as '31_45_days', 
                            round(a.[46<=Days<=60], 2) as '46_60_days', 
                            round(a.[61<=days<=90], 2) as '61_90_days', 
                            round(a.[91<=days<=120], 2) as '91_120_days', 
                            round(a.[121<=days<=180], 2) as '121_180_days', 
                            round(a.[181<=days<=365], 2) as '181_365_days', 
                            round(a.[365<=Days], 2) as '365_days', 
                            round(admlink.AmountDue_1, 2) as 'AmountDue_1', 
                            round(admlink.AmountDue_2, 2) as 'AmountDue_2', 
                            round(admlink.AmountDue_3, 2) as 'AmountDue_3', 
                            round(admlink.AmountDue_4, 2) as 'AmountDue_4', 
                            round(admlink.AmountDue_5, 2) as 'AmountDue_5', 
                            round(admlink.AmountDue_6, 2) as 'AmountDue_6', 
                            round(admlink.AmountDue_7, 2) as 'AmountDue_7', 
                            round(admlink.AmountDue_8, 2) as 'AmountDue_8', 
                            round(admlink.AmountDue_9, 2) as 'AmountDue_9', 
                            round(admlink.AmountDue_10, 2) as 'AmountDue_10', 
                            round(admlink.AmountDue_11, 2) as 'AmountDue_11', 
                            round(admlink.AmountDue_12, 2) as 'AmountDue_12', 
                            convert(varchar(20),admlink.DueDate_1,101) as DueDate_1, 
                            convert(varchar(20),admlink.DueDate_2,101) as DueDate_2, 
                            convert(varchar(20),admlink.DueDate_3,101) as DueDate_3, 
                            convert(varchar(20),admlink.DueDate_4,101) as DueDate_4, 
                            convert(varchar(20),admlink.DueDate_5,101) as DueDate_5, 
                            convert(varchar(20),admlink.DueDate_6,101) as DueDate_6, 
                            convert(varchar(20),admlink.DueDate_7,101) as DueDate_7, 
                            convert(varchar(20),admlink.DueDate_8,101) as DueDate_8, 
                            convert(varchar(20),admlink.DueDate_9,101) as DueDate_9, 
                            convert(varchar(20),admlink.DueDate_10,101) as DueDate_10, 
                            convert(varchar(20),admlink.DueDate_11,101) as DueDate_11, 
                            convert(varchar(20),admlink.DueDate_12,101) as DueDate_12 
                            into #temp_monthly_report
                        From zzz_R_SL_22_001_EX('1/1/2000','".$this->date."','".$this->date."','DI.IC.CF.JP.BB.BA.BO.BD','Premium' ,'','','','','18%','%','%','%','') a 
                            Left Join Profile p on a.Source = p.id 
                            Left Join LOB on p.LOB = LOB.LOB 
                            Left Join (select max(AdmNo) AdmNo, Voucher From Admlink Group By Voucher) A2 on a.Voucher = A2.Voucher 
                            Left Join Admlink on a2.AdmNo = Admlink.AdmNo 
                            Left Join COB on substring(a.PolicyNo,3,2) = COB.COB 
                            Left Join Profile Insured on Admlink.ID = Insured.ID 
                        where a.Name <> 'TOTAL' and Substring(a.PolicyNo,3,2) Not In ('13')

                    ")
                );
                $timeEndCreateTempTable = now();
                $selisihCreateTempTable = $timeEndCreateTempTable->diffForHumans($timeStartCreateTempTable);
                $this->info($this->GREEN."Done Creating Temp Table ".$selisihCreateTempTable."...\n");
            

            //?-------------------------------------------------------------------------------------------------

            $this->info($this->LC."Start to do distinct by id_profile...");
            //! SELECT DISTINCT ID_PROFILE
                $timeStartDistinct = now();
                $distinct =  collect(
                    DB::connection('SEA_REPORT')->select(
                        DB::raw("
                            Select distinct
                                id_profile
                            From #temp_monthly_report
                        ")
                    )
                );
                $timeEndDistinct = now();
                $selisihDistinct = $timeEndDistinct->diffForHumans($timeStartDistinct);
                $this->info($this->GREEN."Done Distinct ".$selisihDistinct)."...\n";

            //?-------------------------------------------------------------------------------------------------
            
            //! CREATE LOG TO SEND EMAIL, THEN GENERATE REPORT IN EXCEL.
                $this->info($this->LC."Exporting Data...");
                $this->output->progressStart(COUNT($distinct));
                foreach( $distinct as $key => $val ){

                    $filteredDataCurrency = DB::connection('SEA_REPORT')->select(
                        DB::raw("
                            SELECT DISTINCT Currency FROM #temp_monthly_report where id_profile = '".$val->id_profile."'
                        ")
                    );

                    $DataLogSendingcollectionThisMonth = LogSendingCollection::
                        whereYear('created_at', date('Y', strtotime( now() )))
                        ->whereMonth('created_at', date('m', strtotime( now() )))
                        ->where('id_profile', $val->id_profile)
                        ->where('email_sent', null)
                    ->get();

                    if( count( $DataLogSendingcollectionThisMonth ) == 0 ){
                        $collection_email = CollectionEmail::where('id_profile', $val->id_profile)->first();

                        $broker_name = isset($collection_email->broker_name) ? $collection_email->broker_name : '';
                        $date = $this->date;

                        $LogSendingCollection = new LogSendingCollection();
                        $LogSendingCollection->id_profile = $val->id_profile;
                        $LogSendingCollection->email_subject = config('email.MAIL_SUBJECT_BROKER');
                        $LogSendingCollection->email_body = view('email.sent-monthly-report', compact('broker_name', 'date'))->render();
                        $LogSendingCollection->year = date('Y', strtotime( now() ));
                        $LogSendingCollection->month = date('m', strtotime( now() ));
                        $LogSendingCollection->date = date('D', strtotime( now() ));
                        $LogSendingCollection->day = date('d', strtotime( now() ));
                        $LogSendingCollection->time = date('H:i:s', strtotime( now() ));
                        $LogSendingCollection->save();
                    }

                    $this->MonthlyReportExport($val->id_profile, $filteredDataCurrency);

                    $this->output->progressAdvance();
                }

                $collection_email_internal = CollectionEmailInternal::all();

                $this->info($this->LC."Create Email for Internal...");
                $this->output->progressStart(COUNT($collection_email_internal));
                foreach( $collection_email_internal as $val ){
                    $DataLogSendingcollectionThisMonthToInternal = LogSendingCollectionInternal::
                        whereYear('created_at', date('Y', strtotime( now() )))
                        ->whereMonth('created_at', date('m', strtotime( now() )))
                        ->where('email', $val)
                        ->where('email_sent', null)
                    ->get();

                    if( count( $DataLogSendingcollectionThisMonthToInternal ) == 0 ){
                        $date = $this->date;

                        $LogSendingCollectionInternal = new LogSendingCollectionInternal();
                        $LogSendingCollectionInternal->email = $val->email;
                        $LogSendingCollectionInternal->email_subject = config('email.MAIL_SUBJECT_BROKER');
                        $LogSendingCollectionInternal->email_body = view('email.sent-monthly-report-internal', compact('date'))->render();
                        $LogSendingCollectionInternal->year = date('Y', strtotime( now() ));
                        $LogSendingCollectionInternal->month = date('m', strtotime( now() ));
                        $LogSendingCollectionInternal->date = date('D', strtotime( now() ));
                        $LogSendingCollectionInternal->day = date('d', strtotime( now() ));
                        $LogSendingCollectionInternal->time = date('H:i:s', strtotime( now() ));
                        $LogSendingCollectionInternal->save();
                    }
                    $this->output->progressAdvance();
                }

                $this->output->progressFinish();

                
            

            //?-------------------------------------------------------------------------------------------------
            

            $this->info($this->LC."Start to Drop Temp Table...");
            //! DROP TEMP TABLE
                DB::connection('SEA_REPORT')->raw("
                    drop table #temp_monthly_report
                ");
                $this->info($this->GREEN."Done Drop Temp Table...\n");
            //?-------------------------------------------------------------------------------------------------

            $this->createZip(config('filesystems')['disks']['monthly_report']['root']);
            // makeZipWithFiles(config('filesystem.monthly_report'), )

        } catch(\Exception $e){
            Log::info($e->getMessage());
            $this->info($this->RED."ADA ERROR NICH...\n\n". $e->getMessage());
            return false;
            // dd($this->RED.'ADA ERROR NICH...', $e->getMessage());
        }

        $this->info("Generating Broker Monthly Report Done...");
    }

    public function MonthlyReportExport($idProfile, $filteredDataCurrency){
        ini_set('memory_limit', "4096M");
        ini_set('max_execution_time', 0);

        $excel = Excel::store(
            new MonthlyReportExport($idProfile, $filteredDataCurrency), 
            $idProfile.'.xls', //? Nama File
            'monthly_report' //? config/filesystems.php
        );

        return $excel;
    }

     /**
     * @throws RuntimeException If the file cannot be opened
     */
    public function createZip($filePath)
    {
        $ZipRoot = config('filesystems')['disks']['monthly_report_zipped']['root'];
        $ZippedPath = $ZipRoot.'/Monthly_Report_Broker_'.date('Y', strtotime(now())).'_'.date('M', strtotime(now())).'.zip';


        // Get real path for our folder
        $filePathZip = realpath($filePath);

        // dd($filePathZip);

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($ZippedPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // dd($zip, $ZippedPath, $ZipRoot);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($filePathZip),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($filePathZip) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

        // Zip archive will be created only after closing object
        $zip->close();
    }
}
