<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lending;
use App\Models\LendingItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    public function index()
    {
        $lendings = Lending::with(['lendingItems.item', 'user'])->get();
        $items = Item::all();
        return view('operator.lending.index', compact('lendings', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'borrow_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Cek available setiap item
        foreach ($request->items as $lendItem) {
            $item = Item::findOrFail($lendItem['item_id']);
            if ($lendItem['quantity'] > $item->available()) {
                return redirect()->back()
                    ->with('error', "Total item {$item->name} more than available!")
                    ->withInput();
            }
        }

        DB::transaction(function () use ($request) {
            $lending = Lending::create([
                'user_id' => Auth::id(),
                'borrower_name' => $request->borrower_name,
                'keterangan' => $request->keterangan,
                'borrow_date' => $request->borrow_date,
                'return_date' => null,
            ]);

            foreach ($request->items as $lendItem) {
                LendingItem::create([
                    'lending_id' => $lending->id,
                    'item_id' => $lendItem['item_id'],
                    'total' => $lendItem['quantity'],
                    'status' => 'Not Returned',
                ]);
            }
        });

        return redirect()->back()->with('success', 'Success add new lending item!');
    }

    public function returned(Lending $lending)
    {
        $lending->update([
            'return_date' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Item is returned!');
    }

    public function destroy(Lending $lending)
    {
        DB::transaction(function () use ($lending) {
            $lending->lendingItems()->delete();
            $lending->delete();
        });

        return redirect()->back()->with('success', 'Success deleted one data lending!');
    }

    // public function export()
    // {
    //     return Excel::download(new LendingsExport, 'lendings.xlsx');
    // }
    public function returnItem($id)
    {
        $item = LendingItem::findOrFail($id);

        // kalau sudah returned, skip
        if ($item->status === 'Returned') {
            return back()->with('error', 'Item already returned!');
        }

        // update status item
        $item->status = 'Returned';
        $item->save();

        // 🔥 update stok item (optional tapi bagus)
        $barang = Item::find($item->item_id);
        if ($barang) {
            $barang->total += $item->total;
            $barang->save();
        }

        // 🔥 cek semua item dalam lending
        $lending = $item->lending;

        $notReturned = $lending->lendingItems()
            ->where('status', 'Not Returned')
            ->count();

        if ($notReturned == 0) {
            $lending->update([
                'return_date' => now()->toDateString(),
            ]);
        }

        return back()->with('success', 'Item returned successfully');
    }
}
