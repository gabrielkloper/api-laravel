<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return InvoiceResource::collection(Invoice::with('user')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'user_id' => 'required',
            'type' => 'required|max:1',
            'value' => 'required|numeric|between:1,99999.99',
            'paid' => 'required|numeric|between:0,1',
            'payment_date' => 'nullable',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $created = Invoice::create($validator->validated());

        if($created) {
            
            // return new InvoiceResource($created);
            return response()->json(['message' => 'Invoice created', 'invoice' => new InvoiceResource($created)], 200);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return response()->json(['message' => 'Invoice loaded', 'invoice' => new InvoiceResource($invoice)], 200);



    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required|max:1|in:C,B,P',
            'paid' => 'required|numeric|between:0,1',
            'value' => 'required|numeric',
            'payment_date' => 'nullable|date_format:Y-m-d H:i:s'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $validated =  $validator->validated();

        $updated = Invoice::where('id', $id)->update($validated);

        if (!$updated) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
            return response()->json(['message' => 'Invoice updated', 'invoice' => new InvoiceResource(Invoice::find($id))], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = Invoice::where('id', $id)->delete();
        if (!$deleted) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }
        return response()->json(['message' => 'Invoice deleted'], 200);
    }
}
