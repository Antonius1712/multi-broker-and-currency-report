<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MonthlyReportSheet extends DefaultValueBinder implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStyles, WithCustomValueBinder, WithPreCalculateFormulas, WithColumnFormatting
{
    protected $reportWithTotal, $idProfile, $Currency;
    
    public function __construct($reportWithTotal, $idProfile, $Currency)
    {
        $this->reportWithTotal = $reportWithTotal;
        $this->idProfile = $idProfile;
        $this->Currency = $Currency;
    }

    public function collection(){
        return collect($this->reportWithTotal);
    }

    public function title(): string {
        //! SHEET NAME.
        return $this->idProfile.' - '.$this->Currency;
    }

    public function headings(): array {
        //! TITLE CELL.
        return [
            'ID Profile',
            'Agent/Broker Name',
            'Currency',
            'Class',
            'Voucher',
            'PolicyNo',
            'a_PolicyNo',
            'RefNo',
            'BookingDate',
            'DueDate',
            'Starting Polis',
            'Ending Polis',
            'WPC',
            'Type',
            'Name',
            'Gross Amount',
            'Administration',
            'Tax',
            'Vat',
            'Payment',
            'Outstanding',
            'UnDue',
            '0<=Days<=30',
            '31<=days<=45',
            '45<=days<=60',
            '61<=days<=90',
            '91<=days<=120',
            '121<=days<=180',
            '181<=days<=365',
            '365<=days',
            'AmountDue_1',
            'AmountDue_2',
            'AmountDue_3',
            'AmountDue_4',
            'AmountDue_5',
            'AmountDue_6',
            'AmountDue_7',
            'AmountDue_8',
            'AmountDue_9',
            'AmountDue_10',
            'AmountDue_11',
            'AmountDue_12',
            'DueDate_1',
            'DueDate_2',
            'DueDate_3',
            'DueDate_4',
            'DueDate_5',
            'DueDate_6',
            'DueDate_7',
            'DueDate_8',
            'DueDate_9',
            'DueDate_10',
            'DueDate_11',
            'DueDate_12'
        ];
    }

    public function styles(Worksheet $sheet){
        return [
            // Style the first row as bold text.
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 16
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ]
        ];
    }

    public function bindValue(Cell $cell, $value){
        if ($cell->getColumn() == 'F' 
            || $cell->getColumn() == 'G' 
            || $cell->getColumn() == 'H'
        ) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // if( $cell->getColumn() == 'P'
        //     || $cell->getColumn() == 'Q'
        //     || $cell->getColumn() == 'R'
        //     || $cell->getColumn() == 'S'
        //     || $cell->getColumn() == 'T'
        //     || $cell->getColumn() == 'U'
        //     || $cell->getColumn() == 'V'
        //     || $cell->getColumn() == 'W'
        //     || $cell->getColumn() == 'X'
        //     || $cell->getColumn() == 'Y'
        //     || $cell->getColumn() == 'Z'
        //     || $cell->getColumn() == 'AA'
        //     || $cell->getColumn() == 'AB'
        //     || $cell->getColumn() == 'AC'
        //     || $cell->getColumn() == 'AD'
        //     || $cell->getColumn() == 'AE'
        //     || $cell->getColumn() == 'AF'
        //     || $cell->getColumn() == 'AG'
        //     || $cell->getColumn() == 'AH'
        //     || $cell->getColumn() == 'AI'
        //     || $cell->getColumn() == 'AJ'
        //     || $cell->getColumn() == 'AK'
        //     || $cell->getColumn() == 'AL'
        //     || $cell->getColumn() == 'AM'
        //     || $cell->getColumn() == 'AN'
        //     || $cell->getColumn() == 'AO'
        //     || $cell->getColumn() == 'AP'
        // ){
        //     $cell->setValueExplicit($value, DataType::TYPE_NUMERIC);
        //     return true;
        // }

        return parent::bindValue($cell, $value);
    }
    
    public function columnFormats(): array
    {
        return [
            'P:AP' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
