<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Excel;
use DB;
use Maatwebsite\Excel\Concerns\FromArray;

class UnadevListExport implements WithHeadings,FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function __construct($data)
    {
        $this->data = $data;
        //dd($this->data);
    }
    
   
    public function array(): array
    {
        return $this->data;
    }

    public function headings():array {
        return [
             'contact_date_fiche',
             'pour_centre',
             'date_chargement',
             'contact_qualif1',
             'id_total',
             'accord_montant',
             'contact_qualif2',
             'cas_particulier',
             'pa_montant',
             'pa_frequence',
             'adr1_civilite_abrv',
             'contact_nom',
             'contact_prenom',
             'adr2',
             'adr3',
             'adr4_libelle_voie',
             'adr5',
             'contact_cp',
             'contact_ville',
             'contact_email',
             'contact_tel',
             'contact_tel_port',
             'numero_appeler',
             'new_RAISON_SOCIALE',
             'duree',
             'code_marketing',
             'rf_pro',
             'id_client',
             'envoi_sms',
             'envoi_mail',
             'indice',
             'valid_coordonnees',
             'tel_joint',
             'agent',
             'Acceuil :: TELEPHONE_PORTABLE',
             'contact_email1',
             'CMK_S_FIELD_DMC_OUT',
             'Commentaire_call1',
        ];
    }
}

