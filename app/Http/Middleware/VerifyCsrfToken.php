<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/custom_login',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/logout',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/update_status',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_status',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_campaigns_status',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/refresh',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_channel',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/refresh_incall',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_channel_live',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/hangup',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/change_to_incall',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/Update_dispo',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_callbacks',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_lead_info',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/agent_time_detail',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/export_list',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/activate_webphone',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/update_lead_info',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_time_incall',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_Qualif_Positive',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_Qualif_Argumenter',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_live_statistic_agent',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_call_logs',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_unique_id',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/update_qualif_contact',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_user_name',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/manual_dial',
        'https://call1.harmoniecrm.com/louanes/harmony_api/index.php/get_phone_info',
    

    ];
}
