<?php namespace App\Domain\Globshoppers;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use App\Domain\Users\User;

class Globshopper
{
    use PropertiesTrait, JsonableTrait;

    private $id;
    private $user;
    private $stripePublicKey;
    private $stripeSecretKey;
    private $location;

    private $portfolio;

    /**
     * Globshopper constructor.
     * @param $user
     * @param $stripePublicKey
     * @param $stripeSecretKey
     * @param $location
     * @param $portfolio
     */
    public function __construct(
        $id,
        $user,
        $stripePublicKey,
        $stripeSecretKey,
        $location = null,
        $portfolio = null
    )
    {

        $this->id = $id;
        $this->user = $user;
        $this->stripePublicKey = $stripePublicKey;
        $this->stripeSecretKey = $stripeSecretKey;
        $this->location = $location;
        $this->portfolio = $portfolio;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getStripePublicKey()
    {
        return $this->stripePublicKey;
    }

    /**
     * @return mixed
     */
    public function getStripeSecretKey()
    {
        return $this->stripeSecretKey;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return mixed
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    public function changePortfolio($portfolio) {
        $this->portfolio = $portfolio;
    }

    public static function makeFromModel(\App\Infrastructure\Models\Globshopper $globshopper) {
        $globshopper->load(['user', 'location', 'portfolio']);

        $user = User::makeFromModel($globshopper->user);
        $location = ($globshopper->location) ?
            Location::makeFromModel($globshopper->location) : null;

        $portfolio = ($globshopper->portfolio) ?
            Portfolio::makeFromModel($globshopper->portfolio) : null;

        return new self(
            $globshopper->id,
            $user,
            $globshopper->stripe_public_key,
            $globshopper->stripe_secret_key,
            $location,
            $portfolio);
    }
}