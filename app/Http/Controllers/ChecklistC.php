<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistC extends Controller
{
    public function index()
    {
        $checklists = Checklist::where("user_id",Auth::id())->get(); 
        
        return $this->sendResponse($checklists);
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string']);

        $checklist = Checklist::create([
            'title'   => $request->title,
            'user_id' => Auth::id()
        ]);

        return $this->sendResponse($checklist);
    }

    public function show($id)
    {
        $checklist = Checklist::with('items')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return $this->sendResponse($checklist);
    }

    public function destroy($id)
    {
        $checklist = Checklist::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $checklist->delete();

        return $this->sendResponse(['message' => 'Checklist deleted successfully']);
    }
}