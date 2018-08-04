<?php namespace App\Infrastructure\Repositories;

use App\Infrastructure\Models\Charge as ChargeModel;

class ChargesRepository
{
    public function store($charge) {
        return (new ChargeModel())->create([
                'charge_id' => $charge->chargeId,
                'customer_id' => $charge->customerId,
                'amount' => $charge->amount,
                'request_id' => $charge->request->id
            ]
        );
    }
}