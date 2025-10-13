<?php

namespace App\Actions\Checkouts;

use App\Models\Activity;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentProofUploadedMail;

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

            // Buat aktivitas user
            Activity::create([
                'user_id' => $user->id,
                'action' => 'upload payment proof',
                'model_type' => 'Order',
                'model_id' => $order->id,
            ]);

            // ==========================
            // Kirim email ke admin event
            // ==========================
            $event = $order->items->first()->product->event ?? null;
            if ($event && $event->user && $event->user->email) {
                Mail::to($event->user->email)->send(new PaymentProofUploadedMail($order, $user));
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment proof uploaded successfully and admin has been notified.',
        ]);
    }
}
