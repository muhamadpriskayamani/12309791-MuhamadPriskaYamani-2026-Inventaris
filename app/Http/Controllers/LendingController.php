<?php

namespace App\Http\Controllers;

use App\Exports\LendingsExport;
use App\Models\Item;
use App\Models\Lending;
use App\Models\LendingItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LendingController extends Controller
{
    public function index(Request $request)
    {
        $query = Lending::with('items.item')->latest();

        if ($request->filled('item_id')) {
            $query->whereHas('items', function ($query) use ($request) {
                $query->where('item_id', $request->item_id);
            });
        }

        $lendings = $query->get();
        return view('lendings.index', compact('lendings'));
    }

    public function export()
    {
        return Excel::download(new LendingsExport, 'lendings.xlsx');
    }

    public function create()
    {
        $items = Item::all()->map(function ($i) {
            return [
                'id'        => $i->id,
                'name'      => $i->name,
                'available' => $i->available, // pakai accessor yang sudah ada
            ];
        });

        return view('lendings.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrower_name'   => 'required|string|max:255',
            'items'           => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.total'   => 'required|integer|min:1',
            'description'     => 'nullable|string',
        ]);

        foreach ($request->items as $index => $row) {
            $item = Item::findOrFail($row['item_id']);

            if ($row['total'] > $item->available) {
                return redirect()->back()
                    ->withErrors([
                        "items.{$index}.total" => "Stok tidak cukup untuk \"{$item->name}\". Tersedia: {$item->available}, diminta: {$row['total']}."
                    ])
                    ->withInput();
            }
        }

        $itemIds = array_column($request->items, 'item_id');
        if (count($itemIds) !== count(array_unique($itemIds))) {
            return redirect()->back()
                ->withErrors(['items' => 'Item yang sama tidak boleh dipilih lebih dari satu kali.'])
                ->withInput();
        }

        $lending = Lending::create([
            'borrower_name' => $request->borrower_name,
            'description'   => $request->description,
            'date'          => now()->toDateString(),
            'status'        => 'Not Returned',
            'edited_by'     => Auth::user()->name,
        ]);

        foreach ($request->items as $row) {
            LendingItem::create([
                'lending_id' => $lending->id,
                'item_id'    => $row['item_id'],
                'total'      => $row['total'],
            ]);

            // Update kolom lending di tabel items
            Item::findOrFail($row['item_id'])->increment('lending', $row['total']);
        }

        return redirect()->route('lendings.index')->with('success', 'Berhasil tambah lending!');
    }

    public function returned(Lending $lending)
    {
        foreach ($lending->lendingItems as $lendingItem) {

            if ($lendingItem->status !== 'Returned') {

                // Update status item
                $lendingItem->update([
                    'status' => 'Returned'
                ]);

                // Kurangi jumlah lending
                $lendingItem->item->decrement('lending', $lendingItem->total);
            }
        }

        $lending->update([
            'status' => 'Returned',
            'return_date' => now(),
            'edited_by' => auth()->user()->name
        ]);

        return back()->with('success', 'All items returned successfully!');
    }

    // public function destroy(Lending $lending)
    // {
    //     if ($lending->status !== 'Returned') {
    //         foreach ($lending->items as $lendingItem) {
    //             $lendingItem->item->decrement('lending', $lendingItem->total);
    //         }
    //     }

    //     $lending->delete();
    //     return redirect()->back()->with('success', 'Lending data deleted successfully!');
    // }
    public function show($id)
    {
        $lending = Lending::with('items.item')->findOrFail($id);

        return view('lendings.show', compact('lending'));
    }

    public function lending()
    {
        $lendings = Lending::with('items.item')->get();
        $users = User::all();

        return view('admin.item.lending', compact('lendings', 'users'));
    }

    public function returnItem($id)
    {
        $lendingItem = LendingItem::findOrFail($id);

        if ($lendingItem->status === 'Returned') {
            return back()->with('error', 'Item already returned!');
        }

        // Update status item
        $lendingItem->update([
            'status' => 'Returned'
        ]);

        // Kurangi jumlah lending di item
        $lendingItem->item->decrement('lending', $lendingItem->total);

        // Cek apakah semua item sudah returned
        $lending = $lendingItem->lending;

        $allReturned = $lending->lendingItems->every(fn($li) => $li->status === 'Returned');

        if ($allReturned) {
            $lending->update([
                'status' => 'Returned',
                'return_date' => now(),
                'edited_by' => auth()->user()->name
            ]);
        }

        return back()->with('success', 'Item returned successfully!');
    }
}
