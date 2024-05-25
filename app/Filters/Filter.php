<?php

namespace App\Filters;

use DeepCopy\Exception\PropertyException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;

abstract class Filter
{
    protected $allowedOperatorsFields = [
        
    ];

    protected $translateOperatorsFields = [
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'eq' => '=',
        'ne' => '!=',
        'in' => 'in'
    ];

    public function filter(HttpRequest $request)
    {
        $where = [];
        $whereIn = [];

        if(empty($this->allowedOperatorsFields)){
            throw new PropertyException('Property allowedOperatorsfields is empty');
        }

        foreach ($this->allowedOperatorsFields as $param => $operators) {
            $queryOperator = $request->query($param);
            if ($queryOperator) {
                foreach($queryOperator as $operator => $value){
                    if(!in_array($operator, $operators)){
                        throw new PropertyException('Property '.$param.' has not this operator '.$operator);
                    }

                    if(str_contains($value,'[')){
                        $whereIn[] = [
                            $param,
                            explode(',', str_replace(['[',']'], ['', ''], $value)),
                            $value
                        ];
                    } else {
                        $where[] = [$param, $this->translateOperatorsFields[$operator], $value];
                    }
                }
            }
            
        }

        if(empty($where) && empty($whereIn)){
            return [];
        }

        return [
            'where' => $where,
            'whereIn' => $whereIn
        ];
    }
}