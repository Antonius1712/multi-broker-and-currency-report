<?php

namespace App\Http\Controllers;

use App\Exports\MonthlyReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $date;
    
    public function __construct()
    {
        // $this->middleware('auth');
        $this->date = date('m/d/Y', strtotime(now()->firstOfMonth()->subDays(1)));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        ini_set('memory_limit', "4096M");
        ini_set('max_execution_time', 0);
        try {

            Log::info('MULAI...');

            //! SELECT DISTINCT ID_PROFILE
                $timeStartDistinct = now();
                $distinct =  collect(
                    DB::connection('sqlsrv')->select(
                        DB::raw("
                            Select distinct
                                a.Source 'idProfile'
                            From zzz_R_SL_22_001_EX('1/1/2000','12/28/2023','12/28/2023','DI.IC.CF.JP.BB.BA.BO.BD','Premium' ,'','','','','18%','%','%','%','') a 
                                Left Join Profile p on a.Source = p.id 
                                Left Join LOB on p.LOB = LOB.LOB 
                                Left Join (select max(AdmNo) AdmNo, Voucher From Admlink Group By Voucher) A2 on a.Voucher = A2.Voucher 
                                Left Join Admlink on a2.AdmNo = Admlink.AdmNo 
                                Left Join COB on substring(a.PolicyNo,3,2) = COB.COB 
                                Left Join Profile Insured on Admlink.ID = Insured.ID 
                            where a.Name <> 'TOTAL' and Substring(a.PolicyNo,3,2) Not In ('13')
                        ")
                    )
                );
                $timeEndDistinct = now();
                $selisihDistinct = $timeEndDistinct->diffForHumans($timeStartDistinct);
                Log::info('waktu distinct = '.$selisihDistinct);


            //! CREATE TEMP TABLE
            $timeStartCreateTempTable = now();
                DB::connection('sqlsrv')->unprepared(
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
                            a.GrossAmount, 
                            a.Administration, 
                            a.Tax, 
                            a.Vat, 
                            a.Payment, 
                            a.Outstanding, 
                            a.UnDue, 
                            a.[0<=Days<=30] as '0_30_days', 
                            a.[31<=days<=45] as '31_45_days', 
                            a.[46<=Days<=60] as '46_60_days', 
                            a.[61<=days<=90] as '61_90_days', 
                            a.[91<=days<=120] as '91_120_days', 
                            a.[121<=days<=180] as '121_180_days', 
                            a.[181<=days<=365] as '181_365_days', 
                            a.[365<=Days] as '365_days', 
                            admlink.AmountDue_1, 
                            admlink.AmountDue_2, 
                            admlink.AmountDue_3, 
                            admlink.AmountDue_4, 
                            admlink.AmountDue_5, 
                            admlink.AmountDue_6, 
                            admlink.AmountDue_7, 
                            admlink.AmountDue_8, 
                            admlink.AmountDue_9, 
                            admlink.AmountDue_10, 
                            admlink.AmountDue_11, 
                            admlink.AmountDue_12, 
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
                Log::info('waktu CreateTempTable = '.$selisihCreateTempTable);
            

            //! SELECT TEMP TABLE
                foreach( $distinct as $val ){

                    $timeStartSelectFromTempTable = now();
                    $filteredData = DB::connection('sqlsrv')->select(
                        DB::raw("
                            SELECT * FROM #temp_monthly_report where id_profile = '".$val->idProfile."'
                        ")
                    );
                    $timeEndSelectFromTempTable = now();
                    $selisihSelectFromTempTable = $timeEndSelectFromTempTable->diffForHumans($timeStartSelectFromTempTable);
                    Log::info('waktu SelectFromTempTable = '.$selisihSelectFromTempTable);

                    $this->MonthlyReportExport($filteredData, $val->idProfile);
                }
            

            //! DROP TEMP TABLE
                DB::connection('sqlsrv')->raw("
                    drop table #temp_monthly_report
                ");

                
            Log::info('BERENTI...');

        } catch(\Exception $e){
            dd('ADA ERROR NICH...', $e->getMessage());
        }

        return view('home');
    }

    public function MonthlyReportExport($filteredData, $idProfile){
        ini_set('memory_limit', "4096M");
        ini_set('max_execution_time', 0);

        $timeStart = now();
        $excel = Excel::store(new MonthlyReportExport($filteredData), strtotime(now()).'_monthly_report_'.$idProfile.'.xls');
        $timeEnd = now();
        $selisih = $timeEnd->diffForHumans($timeStart);
        Log::info('waktu generate = '.$selisih);

        return $excel;
    }
}
