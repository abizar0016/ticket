<?php

namespace App\Actions\Checkouts;

use App\Models\Activity;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadPaymentProof
{
    public function handle(Request $request, $id)
    {
        $user = Auth::user();
        $order = $user->orders()->where('status', 'pending')->findOrFail($id);

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('payment_proofs');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);

            $order->update([
                'payment_proof' => 'payment_proofs/' . $fileName,
            ]);

            Activity::create([
                'user_id' => $user->id,
                'action' => 'pay order',
                'model_type' => 'Order',
                'model_id' => $order->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment proof uploaded successfully.',
        ]);
    }
}
