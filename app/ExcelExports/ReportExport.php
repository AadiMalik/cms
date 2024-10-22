<?php

namespace App\ExcelExports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
      /**
       * @return \Illuminate\Support\Collection
       */
      protected $obj_rport;

      public function __construct($obj_rport)
      {
            $this->obj_rport = $obj_rport;
      }

      public function view(): View
      {
            $parms   = $this->obj_rport;
            switch ($parms->report_name) {
                  case 'ledger_report';
                        return view('reports/ledger/partials.report', compact('parms'));
                        break;
            }
      }
}
