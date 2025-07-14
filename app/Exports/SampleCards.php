<?php

namespace App\Exports;

use App\Models\Card;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class SampleCards  implements FromCollection , WithHeadings,ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ["Expand Your Mind", 
            "Dummy Card Sample", 
            "Join the headquarters of a party you identify with and participate in voluntary activities, such as distributing flyers, organizing events or campaigns on social networks", 
            "All", 
            "18+", 
            "Low", 
            "Challenging"]
        ]);
    }


    public function headings(): array
    {
        return [
            'Category',
            'Card Name',
            'Detail',
            'Gender',
            'Age',
            'Cost',
            'Type'
        ];  
    }

    public function registerEvents(): array
    {
    return [
        AfterSheet::class    => function(AfterSheet $event) 
            {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('Calibri');
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
   }
}
