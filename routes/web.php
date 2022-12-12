<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Agent\DashboardAgentController;
use App\Http\Controllers\Admin\StatController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('', [HomeController::class, 'index'])->name('index');
Route::get('admin/login', [HomeController::class, 'loginAdmin'])->name('admin.login');
Route::get('agent/login', [HomeController::class, 'loginAgent'])->name('agent.login');
Route::get('agent', [DashboardAgentController::class, 'index'])->name('agent.index');
Route::post('custom_login', [LoginController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [RegisterController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [RegisterController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [LoginController::class, 'signOut'])->name('signout');

Route::get('logout', [DashboardAgentController::class, 'logout'])->name('logout');
Route::get('change_status/{etatAgent}', [DashboardAgentController::class, 'ChangeStatus'])->name('change_status');
Route::get('change_status_ajax/{etatAgent}', [DashboardAgentController::class, 'ChangeStatusAjax'])->name('change_status_ajax');
Route::get('get_contact_informations', [DashboardAgentController::class, 'get_contact_informations'])->name('get_contact_informations');
Route::get('get_channel', [DashboardAgentController::class, 'getChannel'])->name('get_channel');
Route::get('refresh_incall', [DashboardAgentController::class, 'refreshIncall'])->name('refresh_incall');
Route::get('change_to_incall', [DashboardAgentController::class, 'ChangeIncall'])->name('change_to_incall');
Route::get('hangup', [DashboardAgentController::class, 'hangup'])->name('hangup');
Route::get('Update_dispo', [DashboardAgentController::class, 'UpdateDispo'])->name('Update_dispo');
Route::get('get_status', [DashboardAgentController::class, 'getAgentStatus'])->name('get_status');
Route::get('get_lead_info/{lead_id}', [DashboardAgentController::class, 'getLeadInfo'])->name('get_lead_info');
Route::post('update_qualif_contact', [DashboardAgentController::class, 'updateQualifContact'])->name('update_qualif_contact');

///// manual dial
Route::get('manual_dial', [DashboardAgentController::class, 'ManualDial'])->name('manual_dial');
//// get live callback
Route::get('get_live_callback', [DashboardAgentController::class, 'getLiveCallback'])->name('get_live_callback');

//// implemente pause code

Route::get('change_pause_code/{pause_code}', [DashboardAgentController::class, 'ChangePauseCode'])->name('change_pause_code');

////////////

Route::get('stat', [StatController::class, 'new_statistics'])->name('statistics');
Route::get('new_stat', [StatController::class, 'new_statistics'])->name('new_statistics');
Route::post('new_show_stat_agents', [StatController::class, 'new_show_stat_agents'])->name('new_show_stat_agents');

Route::post('ExportList', [StatController::class, 'ExportList'])->name('ExportList');
Route::post('ExportTimeAgent', [StatController::class, 'ExportTimeAgent'])->name('ExportTimeAgent');
Route::post('show_stat_agents', [StatController::class, 'showStatAgents'])->name('show_stat_agents');

////Action email sms

Route::get('msg_contact', [DashboardAgentController::class, 'MsgContact'])->name('msg_contact');
Route::post('send_msg', [DashboardAgentController::class, 'SendMsg'])->name('send_msg');
Route::post('send_msg_unicef', [DashboardAgentController::class, 'SendMsgUnicef'])->name('send_msg_unicef');

Route::get('send_msg_contact/{lead_id}', [DashboardAgentController::class, 'SendMsgContactByLeadId'])->name('send_msg_contact');

Route::get('activate_webphone', [DashboardAgentController::class, 'activateWebphone'])->name('activate_webphone');
Route::post('register_new_contact_info', [DashboardAgentController::class, 'RegisternewInfoContact'])->name('register_new_contact_info');
Route::post('register_new_contact_info_post', [DashboardAgentController::class, 'RegisternewInfoContactPost'])->name('register_new_contact_info_post');


//////get all channel live for agent connected 

Route::get('get_channel_live', [DashboardAgentController::class, 'getChannelLive'])->name('get_channel_live');
Route::get('get_time_incall/{lead_id}', [DashboardAgentController::class, 'getTimeIncall'])->name('get_time_incall');
Route::get('get_time_agent', [DashboardAgentController::class, 'getTimeAgent'])->name('get_time_agent');
Route::get('get_live_statistic_agent', [DashboardAgentController::class, 'getLiveStatisticAgent'])->name('get_live_statistic_agent');

