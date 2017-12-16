<?php

namespace App\Http\Controllers;

use App\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{
    public function sections()
    {
        $sections = Section::orderBy('created_at', 'desc')
                           ->paginate(10);

        Carbon::setToStringFormat('d/m/Y');

        return view('home.sections', compact('sections'));
    }

    public function addForm()
    {
        return view('admin.add-section');
    }


    public function add(Request $request)
    {
        $validator = \Validator::make($request->all(), Section::$rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        } else {
            $section = new Section();
            $section->title = $request->title;
            $section->content = $request->section_content;

            /*
             *  Upload image
             */
            if ($request->hasFile('image')) {
                $picture = $request->file('image');
                if ($picture->isValid()) {
                    //Check if the size is OK
                    $validator = \Validator::make($request->all(), [
                        'image' => 'mimes:jpeg,png|max:5000',
                    ]);

                    if($validator->fails()){
                        return redirect()->back()->withErrors($validator());
                    } else {
                        //Store the picture
                        $fileName = rand(11111,99999) . '.' . $picture->getClientOriginalExtension();
                        $picture->move('images/activites/', $fileName);

                        $section->image = $fileName;
                    }
                }
                else {
                    return redirect()->back()->withErrors(["L'image renseignée n'est pas valide"])->withInput();
                }
            }

            $section->save();

            Session::flash('success', 'La section a été ajoutée !');
            return redirect(url('activites'));
        }
    }

    public function updateForm($section_id)
    {
        $section = Section::findOrFail($section_id);

        return view('admin.update-section', compact('section'));
    }

    public function update(Request $request, $section_id)
    {
        $validator = \Validator::make($request->all(), Section::$rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        } else {
            $section = Section::findOrFail($section_id);
            $section->title = $request->title;
            $section->content = $request->section_content;

            /*
             *  Upload image
             */
            if ($request->hasFile('image')) {
                $picture = $request->file('image');
                if ($picture->isValid()) {
                    //Check if the size is OK
                    $validator = \Validator::make($request->all(), [
                        'image' => 'mimes:jpeg,png|max:5000',
                    ]);

                    if($validator->fails()){
                        return redirect()->back()->withErrors($validator());
                    } else {
                        //Store the picture
                        $fileName = rand(11111,99999) . '.' . $picture->getClientOriginalExtension();
                        $picture->move('images/activites/', $fileName);

                        $section->image = $fileName;
                    }
                }
                else {
                    return redirect()->back()->withErrors(["L'image renseignée n'est pas valide"])->withInput();
                }
            }

            $section->save();

            Session::flash('success', 'La section a été mise à jour !');
            return redirect(url('activites'));
        }
    }

    public function delete($section_id)
    {
        $section = Section::findOrFail($section_id);

        if(File::exists(public_path(). '/images/activites/'.$section->image)){
            File::delete(public_path(). '/images/activites/'.$section->image);
        }

        $section->delete();

        Session::flash('success', 'La section a été supprimée.');
        return redirect(url('activites'));
    }

}
