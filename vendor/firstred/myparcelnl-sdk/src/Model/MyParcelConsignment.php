<?php

/**
 * A model of a consignment
 *
 * If you want to add improvements, please create a fork in our GitHub:
 * https://github.com/myparcelnl
 *
 * @author      Reindert Vetter <reindert@myparcel.nl>
 * @copyright   2010-2017 MyParcel
 * @license     http://creativecommons.org/licenses/by-nc-nd/3.0/nl/deed.en_US  CC BY-NC-ND 3.0 NL
 * @link        https://github.com/myparcelnl/sdk
 * @since       File available since Release v0.1.0
 */
namespace MyParcelModule\MyParcelNL\Sdk\src\Model;

use MyParcelModule\MyParcelNL\Sdk\src\Model\Repository\MyParcelConsignmentRepository;
/**
 * A model of a consignment
 *
 * Class Consignment
 *
 * @package MyParcelNL\Sdk\Model
 */
class MyParcelConsignment
{
    /**
     * Regular expression used to make sure the date is correct.
     */
    const DATE_REGEX = '~(\\d{4}-\\d{2}-\\d{2})$~';
    const DATE_TIME_REGEX = '~(\\d{4}-\\d{2}-\\d{2}\\s\\d{2}:\\d{2}:\\d{2})$~';
    const STATUS_CONCEPT = 1;
    const MAX_STREET_LENGTH = 40;
    const CC_NL = 'NL';
    const CC_BE = 'BE';
    protected static $insurance_possibilities = array(0, 100, 250, 500, 1000, 1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000);
    /**
     * @var string
     */
    private $reference_id = null;
    /**
     * @var int
     */
    private $myparcel_consignment_id = null;
    /**
     * @var string
     */
    private $api_key;
    /**
     * @var null
     */
    private $barcode = null;
    /**
     * @var int
     */
    private $status = 0;
    /**
     * @var integer
     */
    private $shop_id;
    /**
     * @var string
     */
    private $cc = null;
    /**
     * @var string
     */
    private $city = null;
    /**
     * @var string
     */
    private $street = null;
    /**
     * @var string
     */
    private $street_additional_info = null;
    /**
     * @var integer
     */
    private $number = null;
    /**
     * @var string
     */
    private $number_suffix = '';
    /**
     * @var string
     */
    private $postal_code = null;
    /**
     * @var string
     */
    private $person = null;
    /**
     * @var string
     */
    private $company = '';
    /**
     * @var string
     */
    private $email = '';
    /**
     * @var string
     */
    private $phone = '';
    /**
     * @var integer
     */
    private $package_type = null;
    /**
     * @var integer
     */
    private $delivery_type = \MyParcelModule\MyParcelNL\Sdk\src\Model\Repository\MyParcelConsignmentRepository::DEFAULT_DELIVERY_TYPE;
    /**
     * @var string
     */
    private $delivery_date = null;
    /**
     * @var string
     */
    private $delivery_remark;
    /**
     * @var boolean
     */
    private $only_recipient;
    /**
     * @var boolean
     */
    private $signature;
    /**
     * @var boolean
     */
    private $cooled_delivery;
    /**
     * @var boolean
     */
    private $return;
    /**
     * @var boolean
     */
    private $age_check;
    /**
     * @var boolean
     */
    private $large_format;
    /**
     * @var string
     */
    private $label_description = '';
    /**
     * @var int
     */
    private $insurance = 0;
    /**
     * @var array
     */
    private $physical_properties = array();
    /**
     * @var int
     */
    private $contents;
    /**
     * @var string
     */
    private $invoice;
    /**
     * @var array
     */
    private $items = array();
    /**
     * @var string
     */
    private $pickup_postal_code = null;
    /**
     * @var string
     */
    private $pickup_street = null;
    /**
     * @var string
     */
    private $pickup_city = null;
    /**
     * @var string
     */
    private $pickup_number = null;
    /**
     * @var string
     */
    private $pickup_location_name = null;
    /**
     * @var string
     */
    private $pickup_location_code = '';
    /**
     * @var string
     */
    private $pickup_network_id = '';
    /**
     * @return string
     */
    public function getReferenceId()
    {
        return $this->reference_id;
    }
    /**
     * @param mixed $reference_id
     *
     * @return $this
     */
    public function setReferenceId($reference_id)
    {
        if ($reference_id !== null) {
            $this->reference_id = (string) $reference_id;
        }
        return $this;
    }
    /**
     * The id of the consignment
     *
     * Save this id in your database
     *
     * @return int
     */
    public function getMyParcelConsignmentId()
    {
        return $this->myparcel_consignment_id;
    }
    /**
     * @internal
     *
     * The id of the consignment
     *
     * @return $this
     *
     * @param int $id
     */
    public function setMyParcelConsignmentId($id)
    {
        $this->myparcel_consignment_id = $id;
        return $this;
    }
    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }
    /**
     * Set the api key for each shipment.
     *
     * The key must be given to each shipment. So you can create multiple shipments
     * in one time for different shops. This way you will not have to ask for the
     * shop ID. The field shop ID is therefore not necessary.
     * Required: Yes
     *
     * @param string $apiKey
     *
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->api_key = $apiKey;
        return $this;
    }
    /**
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }
    /**
     * @internal
     *
     * @param null $barcode
     *
     * @return $this
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;
        return $this;
    }
    /**
     * Get the status of the consignment
     *
     * Pattern: [1 – 99]<br>
     * Example:
     *          1 pending - concept
     *          2 pending - registered
     *          3 enroute - handed to carrier
     *          4 enroute - sorting
     *          5 enroute - distribution
     *          6 enroute - customs
     *          7 delivered - at recipient
     *          8 delivered - ready for pickup
     *          9 delivered - package picked up
     *          10 delivered - return shipment ready for pickup
     *          11 delivered - return shipment package picked up
     *          12 printed - letter
     *          13 credit
     *          30 inactive - concept
     *          31 inactive - registered
     *          32 inactive - enroute - handed to carrier
     *          33 inactive - enroute - sorting
     *          34 inactive - enroute - distribution
     *          35 inactive - enroute - customs
     *          36 inactive - delivered - at recipient
     *          37 inactive - delivered - ready for pickup
     *          38 inactive - delivered - package picked up
     *          99 inactive - unknown
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * @internal
     *
     * Status of the consignment
     *
     * @param int $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    /**
     * @return integer
     */
    public function getShopId()
    {
        return $this->shop_id;
    }
    /**
     * @internal
     *
     * The shop id to which this shipment belongs
     *
     * When the store ID is not specified, the API will look at the API key.
     * Required: No
     *
     * @param mixed $shop_id
     *
     * @return $this
     */
    public function setShopId($shop_id)
    {
        $this->shop_id = $shop_id;
        return $this;
    }
    /**
     * The address country code
     *
     * ISO3166-1 alpha2 country code<br>
     * <br>
     * Pattern: [A-Z]{2,2}<br>
     * Example: NL, BE, CW<br>
     * Required: Yes
     *
     * @param string $cc
     *
     * @return $this
     */
    public function setCountry($cc)
    {
        $this->cc = $cc;
        return $this;
    }
    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    /**
     * The address city
     *
     * Required: Yes
     *
     * @param string $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
    /**
     * @var bool
     * @return string
     */
    public function getStreet($useStreetAdditionalInfo = false)
    {
        if ($useStreetAdditionalInfo && strlen($this->street) >= self::MAX_STREET_LENGTH) {
            $streetParts = $this->getStreetParts();
            return $streetParts[0];
        }
        return $this->street;
    }
    /**
     * The address street name
     *
     * Required: Yes or use setFullStreet()
     *
     * @param string $street
     *
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = trim(str_replace('\\n', ' ', $street));
        return $this;
    }
    /**
     * Wraps a street to max street lenth
     *
     * @return array
     */
    private function getStreetParts()
    {
        $streetWrap = wordwrap($this->street, self::MAX_STREET_LENGTH, 'BREAK_LINE');
        $parts = explode("BREAK_LINE", $streetWrap);
        return $parts;
    }
    /**
     * Get additional information for the street that should not be included in the street field
     *
     * @return string
     */
    public function getStreetAdditionalInfo()
    {
        $streetParts = $this->getStreetParts();
        $result = '';
        if (isset($streetParts[1])) {
            $result .= $streetParts[1];
        }
        $result .= ' ' . (string) $this->street_additional_info;
        return trim($result);
    }
    /**
     * The street additional info
     * Required: No
     *
     * @param string $street_additional_info
     *
     * @return $this
     */
    public function setStreetAdditionalInfo($street_additional_info)
    {
        $this->street_additional_info = $street_additional_info;
        return $this;
    }
    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }
    /**
     * Street number
     *
     * Whole numeric value
     * Pattern: [0-9]+
     * Example: 10. 20. NOT 2,3
     * Required: Yes for NL
     *
     * @param int $number
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
    /**
     * @return string
     */
    public function getNumberSuffix()
    {
        return $this->number_suffix;
    }
    /**
     * Street number suffix.
     *
     * Required: no
     *
     * @param string $number_suffix
     *
     * @return $this
     */
    public function setNumberSuffix($number_suffix)
    {
        $this->number_suffix = $number_suffix;
        return $this;
    }
    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }
    /**
     * The address postal code
     *
     * Required: Yes for NL and EU destinations except for IE
     *
     * @param string $postal_code
     *
     * @return $this
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
        return $this;
    }
    /**
     * @return string
     */
    public function getPerson()
    {
        return $this->person;
    }
    /**
     * The person at this address
     *
     * Required: Yes
     *
     * @param string $person
     *
     * @return $this
     */
    public function setPerson($person)
    {
        $this->person = $person;
        return $this;
    }
    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }
    /**
     * Company name
     *
     * Required: no
     *
     * @param string $company
     *
     * @return $this
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }
    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * The address email
     *
     * Required: no
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * The address phone
     *
     * Required: no
     *
     * @param string $phone
     *
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    /**
     * @return int
     */
    public function getDeliveryType()
    {
        return $this->delivery_type;
    }
    /**
     * The delivery type for the package
     *
     * Required: Yes if delivery_date has been specified
     *
     * @param int  $delivery_type
     * @param bool $needDeliveryDate
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setDeliveryType($delivery_type, $needDeliveryDate = true)
    {
        if ($needDeliveryDate && $delivery_type !== 2 && $this->getDeliveryDate() == null) {
            throw new \InvalidArgumentException('If delivery type !== 2, first set delivery date with setDeliveryDate() before running setDeliveryType() for shipment: ' . $this->myparcel_consignment_id);
        }
        $this->delivery_type = $delivery_type;
        return $this;
    }
    /**
     * @return string
     */
    public function getDeliveryDate()
    {
        return $this->delivery_date;
    }
    /**
     * The delivery date time for this shipment
     * Pattern: YYYY-MM-DD | YYYY-MM-DD HH:MM:SS
     * Example: 2017-01-01 | 2017-01-01 00:00:00
     * Required: Yes if delivery type has been specified
     *
     * @param string $delivery_date
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setDeliveryDate($delivery_date)
    {
        $result = preg_match(self::DATE_REGEX, $delivery_date, $matches);
        if ($result) {
            $delivery_date = (string) $delivery_date . ' 00:00:00';
        } else {
            $result = preg_match(self::DATE_TIME_REGEX, $delivery_date, $matches);
            if (!$result) {
                throw new \InvalidArgumentException('Make sure the date (' . $delivery_date . ') is correct, like pattern: YYYY-MM-DD HH:MM:SS' . json_encode($matches));
            }
        }
        if (new \DateTime() > new \DateTime($delivery_date)) {
            $datetime = new \DateTime();
            $datetime->modify('+1 day');
            $delivery_date = $datetime->format('Y\\-m\\-d\\ h:i:s');
        }
        $this->delivery_date = (string) $delivery_date;
        return $this;
    }
    /**
     * @internal
     *
     * @param $fields
     *
     * @return $this
     */
    public function clearFields($fields)
    {
        foreach ($fields as $field => $default) {
            $this->{$field} = $default;
        }
        return $this;
    }
    /**
     * @internal
     *
     * @param array $data
     * @param array $methods
     *
     * @return $this
     */
    public function setByMethods($data, $methods)
    {
        foreach ($methods as $method => $value) {
            if (isset($data[$value])) {
                $this->{'set' . $method}($data[$value]);
            }
        }
        return $this;
    }
    /**
     * @return string
     */
    public function getDeliveryRemark()
    {
        return $this->delivery_remark;
    }
    /**
     * The delivery remark.
     *
     * Required: No
     *
     * @param string $delivery_remark
     *
     * @return $this
     */
    public function setDeliveryRemark($delivery_remark)
    {
        $this->delivery_remark = $delivery_remark;
        return $this;
    }
    /**
     * @return boolean
     */
    public function isOnlyRecipient()
    {
        return $this->only_recipient;
    }
    /**
     * Deliver the package to the recipient only
     *
     * Required: No
     *
     * @param boolean $only_recipient
     *
     * @return $this
     */
    public function setOnlyRecipient($only_recipient)
    {
        $this->only_recipient = $this->canHaveOption($only_recipient);
        return $this;
    }
    /**
     * Only package type 1 can have extra options
     *
     * @param $option
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    private function canHaveOption($option = true)
    {
        if ($this->getPackageType() === null) {
            throw new \InvalidArgumentException('Set package type before ' . $option);
        }
        return $this->getPackageType() == 1 ? $option : false;
    }
    /**
     * @return int
     */
    public function getPackageType()
    {
        return $this->package_type;
    }
    /**
     * The package type
     *
     * For international shipment only package type 1 is allowed
     * Pattern: [1 – 3]<br>
     * Example:
     *          1. package
     *          2. mailbox package
     *          3. letter
     * Required: Yes
     *
     * @param int $package_type
     *
     * @return $this
     */
    public function setPackageType($package_type)
    {
        $this->package_type = $package_type;
        return $this;
    }
    /**
     * @return boolean
     */
    public function isSignature()
    {
        return $this->signature;
    }
    /**
     * Package must be signed for
     *
     * Required: No
     *
     * @param boolean $signature
     *
     * @return $this
     */
    public function setSignature($signature)
    {
        $this->signature = $this->canHaveOption($signature);
        return $this;
    }
    /**
     * @return boolean
     */
    public function isCooledDelivery()
    {
        return $this->cooled_delivery;
    }
    /**
     * Package must be signed for
     *
     * Required: No
     *
     * @param boolean $cooledDelivery
     *
     * @return $this
     */
    public function setCooledDelivery($cooledDelivery)
    {
        $this->cooled_delivery = $this->canHaveOption($cooledDelivery);
        return $this;
    }
    /**
     * @return boolean
     */
    public function isReturn()
    {
        return $this->return;
    }
    /**
     * Return the package if the recipient is not home
     *
     * Required: No
     *
     * @param boolean $return
     *
     * @return $this
     */
    public function setReturn($return)
    {
        $this->return = $this->canHaveOption($return);
        return $this;
    }
    /**
     * @return boolean
     */
    public function hasAgeCheck()
    {
        return $this->age_check;
    }
    /**
     * Age check 18+
     *
     * Required: No
     *
     * @param boolean $ageCheck
     *
     * @return $this
     */
    public function setAgeCheck($ageCheck)
    {
        $this->age_check = $this->canHaveOption($ageCheck);
        return $this;
    }
    /**
     * @return boolean
     */
    public function isLargeFormat()
    {
        return $this->large_format;
    }
    /**
     * Large format package
     *
     * Required: No
     *
     * @param boolean $large_format
     *
     * @return $this
     */
    public function setLargeFormat($large_format)
    {
        $this->large_format = $this->canHaveOption($large_format);
        return $this;
    }
    /**
     * @return string
     */
    public function getLabelDescription()
    {
        return $this->label_description;
    }
    /**
     * This description will appear on the shipment label
     *
     * Note: This will be overridden for return shipment by the following: Retour – 3SMYPAMYPAXXXXXX
     *
     * Required: No
     *
     * @param string $label_description
     *
     * @return $this
     */
    public function setLabelDescription($label_description)
    {
        $this->label_description = (string) $label_description;
        return $this;
    }
    /**
     * @return int
     */
    public function getInsurance()
    {
        return $this->insurance;
    }
    /**
     * @return int[]
     */
    public static function getInsurancePossibilities()
    {
        return static::$insurance_possibilities;
    }
    /**
     * Insurance price for the package.
     *
     * Composite type containing integer and currency. The amount is without decimal
     * separators.
     * Pattern: [0, 50, 100, 250, 500, 1000, 1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000]
     * Required: No
     *
     * @param int $insurance
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setInsurance($insurance)
    {
        if (!in_array($insurance, static::$insurance_possibilities) && $this->getCountry() == self::CC_NL) {
            throw new \InvalidArgumentException('Insurance must be one of [' . implode(', ', array_map('strval', static::$insurance_possibilities)) . ']');
        }
        if (!$this->canHaveOption()) {
            $insurance = 0;
        }
        $this->insurance = $insurance;
        return $this;
    }
    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->cc;
    }
    /**
     * @return array
     */
    public function getPhysicalProperties()
    {
        return $this->physical_properties;
    }
    /**
     * Required: Yes for non-EU shipments and digital stamps
     *
     * @param array $physical_properties
     *
     * @return MyParcelConsignment
     */
    public function setPhysicalProperties($physical_properties)
    {
        $this->physical_properties = $physical_properties;
        return $this;
    }
    /**
     * @return integer
     */
    public function getContents()
    {
        return $this->contents;
    }
    /**
     * The type of contents in the package.
     *
     * The package contents are only needed in case of shipping outside EU,
     * this is mandatory info for customs form.
     * Pattern: [1 - 5]
     * Example: 1. commercial goods
     *          2. commercial samples
     *          3. documents
     *          4. gifts
     *          5. return shipment
     * Required: Yes for shipping outside EU
     *
     * @param int $contents
     *
     * @return $this
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
        return $this;
    }
    /**
     * @return string
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
    /**
     * The invoice number for the commercial goods or samples of package contents.
     *
     * Required: Yes for international shipments
     *
     * @param string $invoice
     *
     * @return $this
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
        return $this;
    }
    /**
     * @return MyParcelCustomsItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
    /**
     * A CustomsItem objects with description in the package.
     *
     * Required: Yes for international shipments
     *
     * @param MyParcelCustomsItem $item
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function addItem($item)
    {
        if ($item->isFullyFilledItem() == true) {
            $this->items[] = $item;
        }
        return $this;
    }
    /**
     * @return string
     */
    public function getPickupPostalCode()
    {
        return $this->pickup_postal_code;
    }
    /**
     * Pattern:  d{4}\s?[A-Z]{2}
     * Example:  2132BH
     * Required: Yes for pickup location
     *
     * @param string $pickup_postal_code
     *
     * @return MyParcelConsignment
     */
    public function setPickupPostalCode($pickup_postal_code)
    {
        $this->pickup_postal_code = $pickup_postal_code;
        return $this;
    }
    /**
     * @return string
     */
    public function getPickupStreet()
    {
        return $this->pickup_street;
    }
    /**
     * Pattern:  [0-9A-Za-z]
     * Example:  Burgemeester van Stamplein
     * Required: Yes for pickup location
     *
     * @param string $pickup_street
     *
     * @return MyParcelConsignment
     */
    public function setPickupStreet($pickup_street)
    {
        $this->pickup_street = $pickup_street;
        return $this;
    }
    /**
     * @return string
     */
    public function getPickupCity()
    {
        return $this->pickup_city;
    }
    /**
     * Pattern:  [0-9A-Za-z]
     * Example:  Hoofddorp
     * Required: Yes for pickup location
     *
     * @param string $pickup_city
     *
     * @return MyParcelConsignment
     */
    public function setPickupCity($pickup_city)
    {
        $this->pickup_city = $pickup_city;
        return $this;
    }
    /**
     * @return string
     */
    public function getPickupNumber()
    {
        return $this->pickup_number;
    }
    /**
     * Pattern:  [0-9A-Za-z]
     * Example:  270
     * Required: Yes for pickup location
     *
     * @param string $pickup_number
     *
     * @return MyParcelConsignment
     */
    public function setPickupNumber($pickup_number)
    {
        $this->pickup_number = (string) $pickup_number;
        return $this;
    }
    /**
     * @return string
     */
    public function getPickupLocationName()
    {
        return $this->pickup_location_name;
    }
    /**
     * Pattern:  [0-9A-Za-z]
     * Example:  Albert Heijn
     * Required: Yes for pickup location
     *
     * @param string $pickup_location_name
     *
     * @return MyParcelConsignment
     */
    public function setPickupLocationName($pickup_location_name)
    {
        $this->pickup_location_name = $pickup_location_name;
        return $this;
    }
    /**
     * @return string
     */
    public function getPickupLocationCode()
    {
        return $this->pickup_location_code;
    }
    /**
     * Pattern:  [0-9A-Za-z]
     * Example:  Albert Heijn
     * Required: Yes for pickup location
     *
     * @param string $pickup_location_code
     *
     * @return MyParcelConsignment
     */
    public function setPickupLocationCode($pickup_location_code)
    {
        $this->pickup_location_code = $pickup_location_code;
        return $this;
    }
    /**
     * @return string
     */
    public function getPickupNetworkId()
    {
        return $this->pickup_network_id;
    }
    /**
     * Pattern:  [0-9A-Za-z]
     * Example:  Albert Heijn
     * Required: Yes for pickup location
     *
     * @param string $pickup_network_id
     *
     * @return MyParcelConsignment
     */
    public function setPickupNetworkId($pickup_network_id)
    {
        $this->pickup_network_id = $pickup_network_id;
        return $this;
    }
}
