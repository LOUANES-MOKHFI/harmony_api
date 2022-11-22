<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\GsmMailController;
use App\Http\Controllers\FaxMobileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ActionAgentController;
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

Route::get('', [LoginController::class, 'index'])->name('login');
Route::post('custom_login', [LoginController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [RegisterController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [RegisterController::class, 'customRegistration'])->name('register.custom'); 
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('campaigns', [CampaignController::class, 'campaigns'])->name('campaigns');
Route::post('update_status', [ActionAgentController::class, 'PauseReady'])->name('update_status');
Route::post('refresh', [ActionAgentController::class, 'refresh'])->name('refresh');

Route::get('get_campaigns_status', [ActionAgentController::class, 'getCampaignStatus'])->name('get_campaigns_status');

Route::post('get_status', [ActionAgentController::class, 'getStatus'])->name('get_status');
Route::post('change_to_incall', [ActionAgentController::class, 'ChangeIncall'])->name('change_to_incall');
Route::post('get_channel', [ActionAgentController::class, 'getChannel'])->name('get_channel');
Route::post('refresh_incall', [ActionAgentController::class, 'refreshIncall'])->name('refresh_incall');
Route::post('hangup', [ActionAgentController::class, 'hangup'])->name('hangup');
Route::post('Update_dispo', [ActionAgentController::class, 'UpdateDispo'])->name('Update_dispo');
Route::post('get_callbacks', [ActionAgentController::class, 'getAgentCallBack'])->name('get_callbacks');
Route::post('get_lead_info', [ActionAgentController::class, 'getLeadInfo'])->name('get_lead_info');


Route::post('activate_webphone', [ActionAgentController::class, 'activateWebphone'])->name('activate_webphone');
Route::post('update_lead_info', [ActionAgentController::class, 'updateLeadInfo'])->name('update_lead_info');
Route::post('update_qualif_contact', [ActionAgentController::class, 'updateQualifContact'])->name('update_qualif_contact');

//////get all channel live for agent connected 

Route::post('get_channel_live', [ActionAgentController::class, 'getChannelLive'])->name('get_channel_live');
Route::post('get_time_incall', [ActionAgentController::class, 'getTimeIncall'])->name('get_time_incall');
//// get list Call log for agent
Route::post('get_call_logs', [ActionAgentController::class, 'getCallLogs'])->name('get_call_logs');
Route::post('get_unique_id', [ActionAgentController::class, 'getUniqueId'])->name('get_unique_id');

///// Manual Dial
Route::post('manual_dial', [ActionAgentController::class, 'ManualDial'])->name('manual_dial');
Route::post('get_phone_info', [ActionAgentController::class, 'getPhoneInfo'])->name('get_phone_info');






////stat
Route::post('agent_time_detail', [StatController::class, 'getAgentTimeDetail'])->name('agent_time_detail');
//Route::get('export_list', [StatController::class, 'ExportList'])->name('export_list');
Route::post('export_list', [StatController::class, 'ExportList'])->name('export_list');
Route::post('get_Qualif_Positive', [StatController::class, 'getQualifPositive'])->name('get_Qualif_Positive');
Route::post('get_Qualif_Argumenter', [StatController::class, 'getQualifArgummenter'])->name('get_Qualif_Argumenter');
Route::post('get_live_statistic_agent', [ActionAgentController::class, 'getLiveStatisticAgent'])->name('get_live_statistic_agent');
Route::post('get_user_name', [StatController::class, 'getUserName'])->name('get_user_name');


