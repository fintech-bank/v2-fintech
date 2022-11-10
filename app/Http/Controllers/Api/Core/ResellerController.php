<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Reseller\Reseller;
use App\Notifications\Customer\Customer\Customer\SendCodeNotification;
use App\Services\Twilio\Messaging\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ResellerController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Reseller::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function get($reseller_id)
    {
        $reseller = Reseller::find($reseller_id);
    }

    public function update(Request $request, $reseller_id)
    {
        $reseller = Reseller::find($reseller_id);

        switch ($request->get('action')) {
            case 'updateType':
                $reseller->dab->update([
                    'type' => $request->get('type')
                ]);
                break;

            case 'updateState':
                $reseller->dab->update([
                    'open' => $request->get('state')
                ]);
                break;
        }

        return response()->json($reseller);
    }

    public function delete($reseller_id)
    {
        $reseller = Reseller::find($reseller_id);

        try {
            $reseller->user->delete();
            $reseller->dab->delete();
            $reseller->delete();

            try {
                Storage::disk('public')->deleteDirectory('reseller/' . $reseller->user->id);
            } catch (\Exception $exception) {
                LogHelper::notify('critical', $exception->getMessage(), $exception);
                return response()->json(null, 500);
            }

            return response()->json();
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json(null, 500);
        }
    }

    public function sendCode(Request $request, $reseller_id, $withdraw_id)
    {
        $reseller = Reseller::find($reseller_id);

        if ($request->get('action') == 'withdraw') {
            try {
                $withdraw = $reseller->dab->withdraws()->find($withdraw_id);
                config('app.env') == 'local' ?
                    Whatsapp::sendNotification($withdraw->wallet->customer->info->mobile, "Votre code de retrait est: ".base64_decode($withdraw->code)) :
                    $withdraw->wallet->customer->info->notify(new SendCodeNotification('withdraw', $withdraw->code));
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception->getMessage(), $exception);
                return response()->json($exception, 500);
            }
        } else {
            try {
                $withdraw = $reseller->dab->moneys()->find($withdraw_id);
                config('app.env') == 'local' ?
                    Whatsapp::sendNotification($withdraw->wallet->customer->info->mobile, "Votre code de dépot est: ".base64_decode($withdraw->code)) :
                    $withdraw->wallet->customer->info->notify(new SendCodeNotification('withdraw', $withdraw->code));
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception->getMessage(), $exception);
                return response()->json($exception, 500);
            }
        }

        return response()->json();
    }
}
