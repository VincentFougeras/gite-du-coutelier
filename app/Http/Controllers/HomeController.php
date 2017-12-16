<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{


    /**
     * Show the website's home
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('home.home');
    }

    /**
     * Show the visitor's book (the list of user comments)
     *
     * @return \Illuminate\View\View
     */
    public function visitorsBook()
    {
        $books = Book::orderBy('created_at', 'desc')
                     ->with('user')
                     ->paginate(10);

        return view('home.visitors-book', compact('books'));
    }

    public function addBook(Request $request)
    {
        $validator = \Validator::make($request->all(), Book::$rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        } else {
            $book = new Book();
            $book->content = $request->book_content;
            $book->user()->associate(Auth::user());
            $book->save();

            Session::flash('success', 'Votre avis a été ajouté !');
            return redirect(url('visitors-book'));
        }
    }

    public function deleteBook($book_id)
    {
        $book = Book::findOrFail($book_id);

        if($book->user->id === Auth::user()->id || Auth::user()->is_admin){
            $book->delete();

            Session::flash('success', 'L\'avis a été supprimé.');
            return redirect(url('visitors-book'));
        }
        else {
            return response('Forbidden', 403);
        }

    }

    public function contactForm(){
        if(Auth::check()){
            $name = Auth::user()->name;
            $email = Auth::user()->email;
        }
        else {
            $name = NULL;
            $email = NULL;
        }

        return view('home.contact', compact('name', 'email'));
    }

    public function contactSend(Request $request){
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $mes = $request->message;

        // Validate
        if(empty($name) || empty($email) || empty($mes) || empty($subject)){
            return redirect()->back()
                ->withInput()
                ->withErrors(['message' => 'Tous les champs requis doivent être remplis.']);
        }
        else {
            $dest = env('EMAIL_FRANCOIS');

            // Here a possibility of using queue with nohup
            Mail::send(['text' => 'emails.contact'], compact('mes'), function($message) use ($email, $name, $dest, $subject){
                $message->from($email, $name)
                    ->to($dest)
                    ->subject('[Contact] ' . $subject);
            });

            Session::flash('success', 'Le message a été envoyé.');
            return redirect(url('contact'));
        }
    }


}
