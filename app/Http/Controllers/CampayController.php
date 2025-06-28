<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use TypeError;

class CampayController extends Controller
{
    /**
     * @return void
     *
     * @throws MassAssignmentException
     * @throws BindingResolutionException
     * @throws TypeError
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function momoWebhook(Request $request)
    {
        $feedback = $request->all();
        File::put(__DIR__.'../../test.txt', json_encode($feedback));
        $newPayment = CampayController::initData($feedback);
        $oldPayment = Payments::query('reference', $feedback['reference'])->first();
        File::put(__DIR__.'../../payment.json', json_encode($oldPayment));
        $oldPayment->update($newPayment);

        Notification::make('payments success')
            ->success()
            ->title('Payment has been made successfully')
            ->send();
    }

    private static function initData($feedback): array
    {
        $result = [
            'transId' => $feedback['reference'],
            'status' => $feedback['status'],
            'code' => $feedback['code'],
            'currency' => $feedback['currency'],
            'amount' => $feedback['amount'],
            'operator' => $feedback['operator'],
            'operator_reference' => $feedback['operator_reference'],
            'endpoint' => $feedback['endpoint'],
            'signature' => $feedback['signature'],
            'external_user' => $feedback['external_user'],
            'app_amount' => $feedback['app_amount'],
            'phone_number' => $feedback['phone_number'],
        ];

        return $result;
    }
}
