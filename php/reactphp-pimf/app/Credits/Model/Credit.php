<?php
namespace Credits\Model;

use Pimf\Model\AsArray;

/**
 * @SWG\Definition(required={"customer_id"}, @SWG\Xml(name="Credit"))
 */
class Credit extends AsArray
{
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    protected $balance_id;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    protected $customer_id;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    protected $website_id;
    /**
     * @SWG\Property(format="double")
     * @var number
     */
    protected $amount;
    /**
     * @SWG\Property
     * @var string
     */
    protected $base_currency_code;

    public function __construct($balanceId, $customerId, $websiteId, $amount, $baseCurrencyCode)
    {
        $this->balance_id = $balanceId;
        $this->customer_id = $customerId;
        $this->website_id = $websiteId;
        $this->amount = $amount;
        $this->base_currency_code = $baseCurrencyCode;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getBalanceId()
    {
        return $this->balance_id;
    }

    public function getWebsiteId()
    {
        return $this->website_id;
    }

    public function getCustomerId()
    {
        return $this->customer_id;
    }

    public function baseCurrencyCode()
    {
        return $this->base_currency_code;
    }
}
