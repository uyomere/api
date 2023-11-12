<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TransactionResource::collection(Transaction::with('category')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['required', Rule::exists('categories', 'id')->where('user_id', auth()->id())],
            'amount' => ['required'],
            'transaction_description' => ['required'],
            'transaction_date' => ['required', 'date'],
        ]);

        //get the id of the login user
        $id = auth()->user()->id;

        Transaction::create([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'transaction_description' => $request->transaction_description,
            'transaction_date' => $request->transaction_date,
            'created_at' => Carbon::now(),
            'user_id' => $id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        return new TransactionResource($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $transaction->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'transaction_description' => $request->transaction_description,
            'transaction_date' => $request->transaction_date,
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
    }
}
