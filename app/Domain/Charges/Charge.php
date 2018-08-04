<?php namespace App\Domain\Charges;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use App\Infrastructure\Models\Charge as ChargeModel;

class Charge
{
    use PropertiesTrait, JsonableTrait;

    private $request;
    private $chargeId;
    private $customerId;
    private $amount;

    public function __construct($request, $chargeId, $customerId, $amount)
    {
        $this->request = $request;
        $this->chargeId = $chargeId;
        $this->customerId = $customerId;
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public static function makeFromModel(ChargeModel $charge) {

        return new self($charge->request, $charge->charge_id, $charge->customer_id, $charge->amount);
    }
}