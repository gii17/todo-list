<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemC extends Controller
{
    public function index($checklistId)
    {
        $checklist = Checklist::findOrFail($checklistId);
        return $this->sendResponse($checklist->items);
    }

    public function store(Request $request, $checklistId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $checklist = Checklist::findOrFail($checklistId);
        $item      = $checklist->items()->create([
            'content' => $request->content,
        ]);

        return $this->sendResponse($item);
    }

    public function updateStatus($checklistId, $itemId)
    {
        $item           = Item::where('checklist_id', $checklistId)->findOrFail($itemId);
        $item->is_done  = !$item->is_done;
        $item->save();

        return $this->sendResponse($item);
    }

    public function destroy($checklistId, $itemId)
    {
        $item = Item::where('checklist_id', $checklistId)->findOrFail($itemId);
        $item->delete();

        return $this->sendResponse(['message' => 'Item deleted']);
    }
}