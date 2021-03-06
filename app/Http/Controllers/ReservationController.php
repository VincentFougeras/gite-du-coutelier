<?php

namespace App\Http\Controllers;

use App\Reservation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Input;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class ReservationController extends Controller
{

    const PRICE_CHALET_1_WEEK_SUMMER = 3800;
    const PRICE_CHALET_1_WEEK_END_SUMMER = 8300;
    const PRICE_CHALET_1_WEEK_WINTER = 2500;
    const PRICE_CHALET_1_WEEK_END_WINTER = 6700;

    const PRICE_CHALET_2_WEEK_SUMMER = 5000;
    const PRICE_CHALET_2_WEEK_END_SUMMER = 11700;
    const PRICE_CHALET_2_WEEK_WINTER = 3800;
    const PRICE_CHALET_2_WEEK_END_WINTER = 8300;

    const SMALLEST_DURATION = 2;

    const SUMMER_START_WEEK = 24;
    const SUMMER_END_WEEK = 37;

    /**
     * Display the reservation choice screen
     * @return \View
     */
    public function makeChoice(){
        Carbon::setLocale('fr');

        return view('reservation.choice', compact("reservedDays"));
    }

    /**
     * Send back the impossible dates (non-correct format, or already reserved) as a string array
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDates(){
        // Getting all post data
        if (\Request::ajax()) {
            Carbon::setToStringFormat('d/m/Y');

            $place = \Request::input('place');
            $reservedDaysArray = $this->reservedDays($place == 1);

            $reservedDays = '';
            foreach($reservedDaysArray as $day){
                $reservedDays .= '"' . $day . '", ';
            }

            return response()->json(array('msg' => $reservedDaysArray), 200);
        }
    }

    /**
     * Send back the price based on the dates given and the place. Sends 0 if the dates are impossible
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePrice(){
        // Getting all post data
        if (\Request::ajax()) {
            $data = \Request::all();

            $is_chalet = $data['place'] == 1;

            $beginning = Carbon::createFromFormat('d/m/Y', $data['begin_date']);
            $end = Carbon::createFromFormat('d/m/Y', $data['end_date']);

            $price = $this->getPrice($beginning, $end, $is_chalet);

            return response()->json(array('msg' => $price), 200);
        }
    }

    /**
     * Returns true if the date isn't already reserved
     *
     * @param $beginning a valid date
     * @param $end a valid date
     * @param $is_chalet
     * @return bool
     */
    public function isNotTaken($beginning, $end, $is_chalet){
        $reservations = Reservation::all();

        foreach($reservations as $reservation){
            if($is_chalet == $reservation->is_chalet && $end->gt($reservation->beginning) && $beginning->lt($reservation->end)){
                return false;
            }
        }
        return true;
    }


    /**
     * Returns an array containing the days that are already reserved for this place
     *
     * @param $is_chalet
     * @return array of strings
     */
    public function reservedDays($is_chalet){
        $reservations = Reservation::all();
        $takenDays = [];

        // Parcourir les réservations effectuées
        foreach($reservations as $reservation){

            if($is_chalet == $reservation->is_chalet){
                // Parcourir chaque jour réservé
                for($currDay = clone $reservation->beginning; $currDay->lte($reservation->end); $currDay->addDay()){
                    $takenDays[] = $currDay->__toString();
                }
            }
        }
        return $takenDays;
    }

    /**
     * Get the price of the reservation.
     *
     * @param $beginning
     * @param $end
     * @param $is_chalet
     * @return int the price of the reservation, or 0 if the dates are incorrect.
     */
    public function getPrice($beginning, $end, $is_chalet){
        $amount = 0;

        if($beginning->diffInDays($end, false) >= self::SMALLEST_DURATION) {
            for($currDay = clone $beginning; $currDay->lte($end); $currDay->addDay()) {
                if($is_chalet) {
                    if($currDay->weekOfYear >= self::SUMMER_START_WEEK && $currDay->weekOfYear <= self::SUMMER_END_WEEK) {
                        // Pleine saison
                        if($currDay->dayOfWeekIso < 5){
                            $amount += self::PRICE_CHALET_1_WEEK_SUMMER;
                        }
                        else {
                            $amount += self::PRICE_CHALET_1_WEEK_END_SUMMER;
                        }
                    }
                    else {
                        // Hors saison
                        if($currDay->dayOfWeekIso < 5){
                            $amount += self::PRICE_CHALET_1_WEEK_WINTER;
                        }
                        else {
                            $amount += self::PRICE_CHALET_1_WEEK_END_WINTER;
                        }
                    }
                }
                else {
                    if($currDay->weekOfYear >= self::SUMMER_START_WEEK && $currDay->weekOfYear <= self::SUMMER_END_WEEK) {
                        // Pleine saison
                        if($currDay->dayOfWeekIso < 5){
                            $amount += self::PRICE_CHALET_2_WEEK_SUMMER;
                        }
                        else {
                            $amount += self::PRICE_CHALET_2_WEEK_END_SUMMER;
                        }
                    }
                    else {
                        // Hors saison
                        if($currDay->dayOfWeekIso < 5){
                            $amount += self::PRICE_CHALET_2_WEEK_WINTER;
                        }
                        else {
                            $amount += self::PRICE_CHALET_2_WEEK_END_WINTER;
                        }
                    }
                }
            }
        }

        return $amount;
    }

    /**
     * validate the reservation, then make the customer pay, then create a user and reservation, then send an email
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function acceptReservation(Request $request){

        /*
        * Validation of the $request
        */
        $validator = \Validator::make($request->all(), [
            'place' => 'required|in:0,1',
            'nb_people' => ['required', 'integer' , ($request->place == 1 ? 'between:1,4' : 'between:1,6')],
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'address' => 'required|string',
            'beginning' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /*
         *  Upload image
         */
        if ($request->hasFile('id_scan')) {
            $picture = $request->file('id_scan');
            if ($picture->isValid()) {
                //Check if the size is OK
                $validator = \Validator::make($request->all(), [
                    'id_scan' => 'required|mimes:jpeg,png|max:5000',
                ]);

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator());
                } else {
                    //Store the picture
                    $strippedName = preg_replace('([^\w\d])', '', $request->name);
                    $fileName = $strippedName . rand(1111,9999) . '.' . $picture->getClientOriginalExtension();
                    $picture->move('images/id_scan/', $fileName);
                }
            }
            else {
                return redirect()->back()->withErrors(["L'image renseignée n'est pas valide [010]"])->withInput();
            }
        }
        else {
            return redirect()->back()->withErrors(["Le scan d'une pièce d'identité est requis [015]"])->withInput();
        }


        /*
         *  Vérifier les dates et créer la reservation
         */
        $is_chalet = $request->place == 1;
        $returnedObject = $this->verifyDatesAndCreateReservation($request->beginning, $request->end, $is_chalet, $request->nb_people);

        if(get_class($returnedObject) !== "App\Reservation"){
            return $returnedObject;
        }
        $reservation = $returnedObject;


        /*
         * Make a new user
         */
        $user = new User();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->id_scan = $fileName;
        $user->password = bcrypt($request->password);


        /*
         * Additional verifications
         */
        // Si l'utilisateur fait des retours en arrière
        if(! empty($reservation->stripe_transaction_id)){
            return redirect()->back()->withErrors(["Le paiement a déjà été effectué. [030]"]);
        }


        /*
         * Make the payment
         */

        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source'  => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount'   => $reservation->amount,
                'currency' => 'eur',
                'description' => 'Reservation du gite'
            ));

            $user->stripe_customer_id = $customer->id;
            $reservation->stripe_transaction_id = $charge->id;

        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(['message' => $ex->getMessage()])->withInput();
        }

        /* Finalize reservation */
        $user->save();
        $reservation->user()->associate($user);
        $reservation->save();

        try {
            if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                $this->sendMail($user, $reservation);

                return redirect(url('/reservation/done/' . $reservation->id));
            }
            else {
                // Normalement impossible
                return redirect()->back()->withErrors(["Le paiement et la réservation ont bien été effectués, mais une erreur a eu lieu lors de la connexion. Veuillez contacter les administrateurs du site. [035]"]);
            }
        }
        catch (\Exception $ex) {
            return redirect(url('/reservation/done/' . $reservation->id))->withErrors(['error' => "Le mail n'a pas pu être envoyé. [040]", 'message' => $ex->getMessage()]);
        }

    }




    public function acceptReservationLogged(Request $request){

        $user = Auth::user();

        /*
        * Validation of the $request
        */
        $validator = \Validator::make($request->all(), [
            'place' => 'required|in:0,1',
            'nb_people' => ['required', 'integer' , ($request->place == 1 ? 'between:1,4' : 'between:1,6')],
            'name' => 'required|string|max:255',
            'beginning' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($user->name != $request->name){
            return redirect()->back()->withErrors(["Une erreur a eu lieu. Veuillez contacter les administrateur du site. [045]"]);
        }


        /*
         *  Vérifier les dates et créer la reservation
         */
        $is_chalet = $request->place == 1;
        $returnedObject = $this->verifyDatesAndCreateReservation($request->beginning, $request->end, $is_chalet, $request->nb_people);

        if(get_class($returnedObject) !== "App\Reservation"){
            return $returnedObject;
        }
        $reservation = $returnedObject;


        /*
         * Additional verifications
         */
        // Si l'utilisateur fait des retours en arrière
        if(! empty($reservation->stripe_transaction_id)){
            return redirect()->back()->withErrors(["error" => "Le paiement a déjà été effectué. [060]"]);
        }


        /*
         * Make the payment
         */

        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source'  => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount'   => $reservation->amount,
                'currency' => 'eur',
                'description' => 'Reservation du gite'
            ));

            $user->stripe_customer_id = $customer->id;
            $reservation->stripe_transaction_id = $charge->id;


        } catch (\Exception $ex) {
            return redirect()->back()->withErrors(['message' => $ex->getMessage()])->withInput();
        }

        /* Finalize reservation */
        $user->save();
        $reservation->user()->associate($user);
        $reservation->save();

        try {
            $this->sendMail($user, $reservation);
        }
        catch (\Exception $ex) {
            return redirect(url('/reservation/done/' . $reservation->id))->withErrors(['error' => "Le mail de confirmation n'a pas pu être envoyé. [065]", 'message' => $ex->getMessage()]);
        }

        return redirect(url('/reservation/done/' . $reservation->id));

    }


    /**
     * display the final page after finishing the reservation
     *
     * @param $reservation_id
     * @return \Response
     */
    public function done($reservation_id){
        $reservation = Reservation::findOrFail($reservation_id);

        if($reservation->user_id === Auth::user()->id){
            Carbon::setToStringFormat('d/m/Y');

            return view('reservation.done', compact('reservation'));
        }
        else {
            return response('Unauthorized.', 401);
        }
    }

    /**
     * Send a mail to the new customer
     *
     * @param User $user
     * @param Reservation $reservation
     */
    private function sendMail(User $user, Reservation $reservation){
        $subject = "Votre réservation a été effectuée";
        $to = $user->email;
        $bcc = env('EMAIL_FRANCOIS');

        Carbon::setToStringFormat('d/m/Y');

        // Here a possibility of using queue with nohup
        Mail::send(['emails.reserved-html', 'emails.reserved-txt'], compact('user', 'reservation'), function($message)
            use ($to, $bcc, $subject){

            $message->to($to)
                ->bcc($bcc)
                ->subject($subject);
        });

    }


    /**
     * Display the fake reservation choice screen
     * @return \View
     */
    public function makeFake(){
        Carbon::setLocale('fr');

        return view('admin.make-fake', compact("reservedDays"));
    }

    /**
     * Validate the fake reservation
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function acceptFake(Request $request){

        $user = Auth::user();

        /*
        * Validation of the $request
        */
        $validator = \Validator::make($request->all(), [
            'place' => 'required|in:0,1',
            'name' => 'required|string|max:255',
            'beginning' => 'required',
            'end' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($user->name != $request->name){
            return redirect()->back()->withErrors(["Une erreur a eu lieu. Veuillez contacter les administrateur du site. [070]"]);
        }


        /*
         *  Vérifier les dates et créer la reservation
         */
        $is_chalet = $request->place == 1;
        $returnedObject = $this->verifyDatesAndCreateReservation($request->beginning, $request->end, $is_chalet, 0);

        if(get_class($returnedObject) !== "App\Reservation"){
            return $returnedObject;
        }
        $reservation = $returnedObject;

        /* Finalize reservation */
        $user->save();
        $reservation->user()->associate($user);
        $reservation->save();

        return redirect(url('/reservation/done/' . $reservation->id));

    }


    /**
     * Validate the dates, and returns either a Reservation or a RedirectResponse
     * @param $begString
     * @param $endString
     * @param $is_chalet
     * @param $nb_people
     * @return Reservation|\Illuminate\Http\RedirectResponse
     */
    private function verifyDatesAndCreateReservation($begString, $endString, $is_chalet, $nb_people){
        $reservation = new Reservation();

        try {
            $beginning = Carbon::createFromFormat('d/m/Y', $begString);
            $end = Carbon::createFromFormat('d/m/Y', $endString);

            // Vérifier que la date soit valide
            $price = $this->getPrice($beginning, $end, $is_chalet);

            if($price > 0){
                // Vérifier que la date ne soit pas déjà réservée
                if($this->isNotTaken($beginning, $end, $is_chalet)){
                    // Créer la réservation
                    $reservation->beginning = $beginning;
                    $reservation->end = $end;
                    $reservation->is_chalet = $is_chalet;
                    $reservation->amount = $price;
                    $reservation->number_of_people = $nb_people;
                }
                else {
                    return redirect()->back()->withErrors(['error' => "La date sélectionnée est déjà réservée [080]"])->withInput();
                }

            }
            else {
                return redirect()->back()->withErrors(['error' => "La date sélectionnée est invalide [085]"])->withInput();
            }

        }
        catch (\Exception $ex) {
            return redirect()->back()->withErrors(['message' => $ex->getMessage()])->withInput();
        }

        return $reservation;
    }

}
