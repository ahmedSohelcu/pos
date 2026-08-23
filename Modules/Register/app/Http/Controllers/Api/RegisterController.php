<?php

namespace Modules\Register\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Register\App\Models\RegisterShift;
use Modules\Register\App\Services\RegisterService;

class RegisterController extends Controller
{
    protected $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
    }

    public function current()
    {
        $shift = $this->service->currentShift();

        return success_response('Current register state retrieved successfully', [
            'shift' => $shift,
            'stats' => $shift ? $this->service->liveStats($shift) : null,
            'movements' => $shift ? $shift->movements()->with('user:id,name')->limit(25)->get() : [],
        ]);
    }

    public function open(Request $request)
    {
        $data = $request->validate([
            'opening_float' => ['required', 'numeric', 'min:0'],
            'register_name' => ['nullable', 'string', 'max:60'],
        ]);

        return created_responses('Register opened successfully', [
            'shift' => $this->service->open($data)->fresh(['cashier:id,name']),
        ]);
    }

    public function close(Request $request)
    {
        $data = $request->validate([
            'closing_counted' => ['required', 'numeric', 'min:0'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $shift = RegisterShift::query()->open()->first();

        if (! $shift) {
            abort(422, 'No open register shift found');
        }

        return success_response('Register closed successfully', [
            'shift' => $this->service->close($shift, $data),
        ]);
    }

    public function movements(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', 'in:cash_in,cash_out'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $shift = RegisterShift::query()->open()->first();

        if (! $shift) {
            abort(422, 'No open register shift found');
        }

        $this->service->addMovement($shift, $data['type'], (float) $data['amount'], $data['reason'] ?? null);

        return created_responses('Cash movement recorded successfully', [
            'stats' => $this->service->liveStats($shift->refresh()),
            'movements' => $shift->movements()->with('user:id,name')->limit(25)->get(),
        ]);
    }

    public function history()
    {
        return success_response('Shift history retrieved successfully', $this->service->history());
    }
}
