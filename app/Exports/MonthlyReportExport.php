<?php

namespace App\Exports;

use App\Exports\Sheets\MonthlyReportSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class MonthlyReportExport extends DefaultValueBinder implements WithMultipleSheets
{
    protected $idProfile;
    protected $filteredDataCurrency;

    public function __construct($idProfile, $filteredDataCurrency)
    {
        $this->idProfile = $idProfile;
        $this->filteredDataCurrency = $filteredDataCurrency;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach( $this->filteredDataCurrency as $data ){
            $reportWithTotal = DB::connection('SEA_REPORT')->select(
                DB::raw("
                    SELECT *
                    FROM #temp_monthly_report
                    WHERE id_profile = '".$this->idProfile."'
                    AND currency = '".$data->Currency."'
                        union all
                        SELECT '','','','','','','','','','','','','','','Total',
                            SUM(GrossAmount) GrossAmount, 
                            SUM(Administration) Administration, 
                            SUM(Tax) Tax, 
                            SUM(Vat) Vat, 
                            SUM(Payment) Payment, 
                            SUM(Outstanding) Outstanding, 
                            SUM(UnDue) UnDue,
                            SUM([0_30_days]) [0_30_days], 
                            sum([31_45_days]) [31_45_days], 
                            sum([46_60_days]) [46_60_days], 
                            sum([61_90_days]) [61_90_days], 
                            sum([91_120_days]) [91_120_days], 
                            sum([121_180_days]) [121_180_days], 
                            sum([181_365_days]) [181_365_days],
                            sum([365_days]) [365_days], '','','','','','','','','','','','', '','','','','','','','','','','',''
                        FROM #temp_monthly_report
                        WHERE id_profile = '".$this->idProfile."'
                        AND currency = '".$data->Currency."'
                ")
            );
            
            $sheets[] = new MonthlyReportSheet($reportWithTotal, $this->idProfile, $data->Currency);
        }

        return $sheets;
    }
}
