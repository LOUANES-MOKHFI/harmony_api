<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;

class AgentTimeDetailExport implements WithHeadings,FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function __construct($agents1)
    {
        $this->agents1 = $agents1;
        //dd($this->agents1);
    }
    
   
    public function array(): array
    {
        return $this->agents1;
    }

    public function headings():array {
        return [
            'Agent',
            "Groupe d'agents",
            'Genre',
            'Matricule',
            'Code Externe',
            'Agent Login',
            'Debut',
            'Fin',
            'Debrief',
            'Pauses',
            'Pauses Productive',
            'Pause:Pause Formation',
            'Pause:Pause Brief',
            'Pause Non Productive',
            'Pause Cafe',
            'Pause:Pause Dej',
            'Pause:Pause Autre',
            'Menu',
            'Heure production',
            'Heure Presence',
            'Durée Conversation',
            'Durée Mise en Attente'
           ];   



               
}
}