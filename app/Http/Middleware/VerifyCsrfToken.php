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
        'https://call3.harmoniecrm.com/harmony_api/index.php/custom_login',
        'https://call3.harmoniecrm.com/harmony_api/index.php/logout',
        'https://call3.harmoniecrm.com/harmony_api/index.php/update_status',
        'https://call3.harmoniecrm.com/harmony_api/index.php/get_status',
        'https://call3.harmoniecrm.com/harmony_api/index.php/get_campaigns_status',
        'https://call3.harmoniecrm.com/harmony_api/index.php/refresh',
        'https://call3.harmoniecrm.com/harmony_api/index.php/get_channel',
        'https://call3.harmoniecrm.com/harmony_api/index.php/refresh_incall',
        'https://call3.harmoniecrm.com/harmony_api/index.php/hangup',
        'https://call3.harmoniecrm.com/harmony_api/index.php/change_to_incall',
        'https://call3.harmoniecrm.com/harmony_api/index.php/Update_dispo',
        'https://call3.harmoniecrm.com/harmony_api/index.php/get_callbacks',
        'https://call3.harmoniecrm.com/harmony_api/index.php/get_lead_info',
        'https://call3.harmoniecrm.com/harmony_api/index.php/export_list',
        'https://call3.harmoniecrm.com/harmony_api/index.php/get_channel_live',
        'https://call3.harmoniecrm.com/harmony_api/index.php/get_time_incall',
        'https://call3.harmoniecrm.com/harmony_api/index.php/get_call_logs',

    ];
}
