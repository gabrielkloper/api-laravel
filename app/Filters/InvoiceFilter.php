<?php

namespace App\Filters;

use DeepCopy\Exception\PropertyException;
use Illuminate\Http\Request;

class InvoiceFilter extends Filter
{
    protected $allowedOperatorsFields = [
        'value' => ['gt', 'lt', 'gte', 'lte', 'eq', 'ne'],
        'paid' => ['eq', 'ne'],
        'status' => ['in'],
        'type' => ['in', 'eq', 'ne'],
        'payment_date' => ['gt', 'lt', 'gte', 'lte', 'eq', 'ne']
    ];

    
   

}