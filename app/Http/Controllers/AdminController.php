<?php

namespace App\Http\Controllers;

use App\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function reservations()
    {
        $reservations = Reservation::withTrashed()
                                    ->orderBy('created_at', 'desc')
                                    ->with('user')
                                    ->paginate(10);

        Carbon::setToStringFormat('d/m/Y');

        return view('admin.reservations', compact('reservations'));
    }

    public function reservation($reservation_id)
    {
        $reservation = Reservation::withTrashed()->findOrFail($reservation_id);

        Carbon::setToStringFormat('d/m/Y');

        return view('admin.reservation', compact('reservation'));
    }
}
