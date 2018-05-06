<?php

namespace App\Http\Controllers;

use App\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Stripe\Refund;
use Stripe\Stripe;

class ClientController extends Controller
{
    /**
     * Show the user's reservations
     *
     * @return \Illuminate\Http\Response
     */
    public function reservations()
    {
        $reservations = Reservation::where('user_id', Auth::user()->id)->get();
        Carbon::setToStringFormat('d/m/Y');

        return view('client.reservations', compact('reservations'));
    }

    public function reservation($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $is_cancellable = $this->is_cancellable($reservation);

        if($reservation->user_id === Auth::user()->id){
            Carbon::setToStringFormat('d/m/Y');

            return view('client.reservation', compact('reservation', 'is_cancellable'));
        }
        else {
            return response('Unauthorized.', 401);
        }
    }

    public function cancelReservation($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);

        if($reservation->user_id === Auth::user()->id){
            if($this->is_cancellable($reservation)){
                // Don't contact stripe if it's a fake reservation
                if(Auth::user()->is_admin && (!isset($reservation->stripe_transaction_id))){
                    $reservation->delete();
                    Session::flash('success', 'La (fausse) réservation a été annulée.');
                    return redirect(url('/my/reservations'));
                }

                // La réservation peut être annulée
                try {
                    Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                    Refund::create(array(
                        'charge' => $reservation->stripe_transaction_id,
                    ));
                } catch (\Exception $ex) {
                    return redirect()->back()->withErrors(['error' => 'Le remboursement n\'a pas pu être effectué. Veuillez contacter les administrateurs du site. [090]'])->withInput();
                }

                // Suppression de la réservation
                $reservation->delete();

                try {
                    $this->sendDeletionMail($reservation);
                    Session::flash('success', 'La réservation a été annulée.');
                    return redirect(url('/my/reservations'));
                }
                catch (\Exception $ex) {
                    return redirect(url('/my/reservations'))->withErrors(['error' => "La réservation a bien été annulée, mais le mail de confirmation n'a pas pu être envoyé. [093]", 'message' => $ex->getMessage()]);
                }




            }
            else {
                return redirect()->back()->withErrors(['error' => "La réservation ne peut plus être annulée. [095]"])->withInput();
            }
        }
        else {
            return response('Unauthorized.', 401);
        }
    }

    /**
     * Send a mail to the customer
     *
     * @param User $user
     * @param Reservation $reservation
     */
    private function sendDeletionMail(Reservation $reservation){
        $subject = "Votre réservation a été annulée";
        $user = Auth::user();
        $to = $user->email;

        $bcc = env('EMAIL_FRANCOIS');

        Carbon::setToStringFormat('d/m/Y');

        // Here a possibility of using queue with nohup
        Mail::send(['emails.delete-html', 'emails.delete-txt'], compact('user', 'reservation'), function($message)
        use ($to, $bcc, $subject){

            $message->to($to)
                ->bcc($bcc)
                ->subject($subject);
        });

    }

    public function is_cancellable($reservation)
    {
        if(Auth::check() && Auth::user()->is_admin){
            $cancellable = true;
        }
        else {
            $beginning = $reservation->beginning;

            $diffInDays = Carbon::now()->diffInDays($beginning, false);

            if($beginning->weekOfYear >= 18 && $beginning->weekOfYear <= 39){
                // Semaine pleine saison
                $cancellable = $diffInDays >= 14;
            }
            else if($beginning->dayOfWeek == 1) {
                // Semaine hors saison
                $cancellable = $diffInDays >= 7;
            }
            else {
                // Week-end hors saison
                $cancellable = $diffInDays >= 1;
            }
        }

        return $cancellable;
    }

    /**
     * Show the user's informations, and enable them to modify the infos
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function informations()
    {
        $user = Auth::user();

        return view('client.informations', compact('user'));
    }

    public function updateInformations(Request $request)
    {
        $user = Auth::user();

        /*
         * Validation of the $request
         */
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'required|string|min:6|confirmed',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /*
         * Update the informations
         */
        $user->fill(['name' => $request->name, 'address' => $request->address,
                     'email' => $request->email, 'password' => bcrypt($request->password)]);
        $user->save();

        Session::flash('success', 'Les informations ont été mises à jour !');
        return redirect('/my/informations');

    }
}
