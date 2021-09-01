<?php
/**
 * FieldsFields
 *
 * PHP version 5
 *
 * @category Class
 * @package  ClickSend
 * @author   ClickSend Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * ClickSend v3 API
 *
 * This is an official SDK for [ClickSend](https://clicksend.com)  Below you will find a current list of the available methods for clicksend.  *NOTE: You will need to create a free account to use the API. You can register [here](https://dashboard.clicksend.com/#/signup/step1/)..*
 *
 * OpenAPI spec version: 3.1
 * Contact: support@clicksend.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * ClickSend Codegen version: 2.4.5-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace ClickSend\Model;

use \ArrayAccess;
use \ClickSend\ObjectSerializer;

/**
 * FieldsFields Class Doc Comment
 *
 * @category Class
 * @description From Email object.
 * @package  ClickSend
 * @author   ClickSend Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class FieldsFields implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Fields_fields';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'phone_number' => 'string',
        'custom_1' => 'string',
        'email' => 'string',
        'fax_number' => 'string',
        'first_name' => 'string',
        'address_line_1' => 'string',
        'address_line_2' => 'string',
        'address_city' => 'string',
        'address_state' => 'string',
        'address_postal_code' => 'string',
        'address_country' => 'string',
        'organization_name' => 'string',
        'custom_2' => 'string',
        'custom_3' => 'string',
        'custom_4' => 'string',
        'last_name' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'phone_number' => null,
        'custom_1' => null,
        'email' => null,
        'fax_number' => null,
        'first_name' => null,
        'address_line_1' => null,
        'address_line_2' => null,
        'address_city' => null,
        'address_state' => null,
        'address_postal_code' => null,
        'address_country' => null,
        'organization_name' => null,
        'custom_2' => null,
        'custom_3' => null,
        'custom_4' => null,
        'last_name' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'phone_number' => 'phone_number',
        'custom_1' => 'custom_1',
        'email' => 'email',
        'fax_number' => 'fax_number',
        'first_name' => 'first_name',
        'address_line_1' => 'address_line_1',
        'address_line_2' => 'address_line_2',
        'address_city' => 'address_city',
        'address_state' => 'address_state',
        'address_postal_code' => 'address_postal_code',
        'address_country' => 'address_country',
        'organization_name' => 'organization_name',
        'custom_2' => 'custom_2',
        'custom_3' => 'custom_3',
        'custom_4' => 'custom_4',
        'last_name' => 'last_name'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'phone_number' => 'setPhoneNumber',
        'custom_1' => 'setCustom1',
        'email' => 'setEmail',
        'fax_number' => 'setFaxNumber',
        'first_name' => 'setFirstName',
        'address_line_1' => 'setAddressLine1',
        'address_line_2' => 'setAddressLine2',
        'address_city' => 'setAddressCity',
        'address_state' => 'setAddressState',
        'address_postal_code' => 'setAddressPostalCode',
        'address_country' => 'setAddressCountry',
        'organization_name' => 'setOrganizationName',
        'custom_2' => 'setCustom2',
        'custom_3' => 'setCustom3',
        'custom_4' => 'setCustom4',
        'last_name' => 'setLastName'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'phone_number' => 'getPhoneNumber',
        'custom_1' => 'getCustom1',
        'email' => 'getEmail',
        'fax_number' => 'getFaxNumber',
        'first_name' => 'getFirstName',
        'address_line_1' => 'getAddressLine1',
        'address_line_2' => 'getAddressLine2',
        'address_city' => 'getAddressCity',
        'address_state' => 'getAddressState',
        'address_postal_code' => 'getAddressPostalCode',
        'address_country' => 'getAddressCountry',
        'organization_name' => 'getOrganizationName',
        'custom_2' => 'getCustom2',
        'custom_3' => 'getCustom3',
        'custom_4' => 'getCustom4',
        'last_name' => 'getLastName'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['phone_number'] = isset($data['phone_number']) ? $data['phone_number'] : null;
        $this->container['custom_1'] = isset($data['custom_1']) ? $data['custom_1'] : null;
        $this->container['email'] = isset($data['email']) ? $data['email'] : null;
        $this->container['fax_number'] = isset($data['fax_number']) ? $data['fax_number'] : null;
        $this->container['first_name'] = isset($data['first_name']) ? $data['first_name'] : null;
        $this->container['address_line_1'] = isset($data['address_line_1']) ? $data['address_line_1'] : null;
        $this->container['address_line_2'] = isset($data['address_line_2']) ? $data['address_line_2'] : null;
        $this->container['address_city'] = isset($data['address_city']) ? $data['address_city'] : null;
        $this->container['address_state'] = isset($data['address_state']) ? $data['address_state'] : null;
        $this->container['address_postal_code'] = isset($data['address_postal_code']) ? $data['address_postal_code'] : null;
        $this->container['address_country'] = isset($data['address_country']) ? $data['address_country'] : null;
        $this->container['organization_name'] = isset($data['organization_name']) ? $data['organization_name'] : null;
        $this->container['custom_2'] = isset($data['custom_2']) ? $data['custom_2'] : null;
        $this->container['custom_3'] = isset($data['custom_3']) ? $data['custom_3'] : null;
        $this->container['custom_4'] = isset($data['custom_4']) ? $data['custom_4'] : null;
        $this->container['last_name'] = isset($data['last_name']) ? $data['last_name'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets phone_number
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->container['phone_number'];
    }

    /**
     * Sets phone_number
     *
     * @param string $phone_number Your phone number in E.164 format. Must be provided if no fax number or email.
     *
     * @return $this
     */
    public function setPhoneNumber($phone_number)
    {
        $this->container['phone_number'] = $phone_number;

        return $this;
    }

    /**
     * Gets custom_1
     *
     * @return string
     */
    public function getCustom1()
    {
        return $this->container['custom_1'];
    }

    /**
     * Sets custom_1
     *
     * @param string $custom_1 
     *
     * @return $this
     */
    public function setCustom1($custom_1)
    {
        $this->container['custom_1'] = $custom_1;

        return $this;
    }

    /**
     * Gets email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->container['email'];
    }

    /**
     * Sets email
     *
     * @param string $email Your email. Must be provided if no phone number or fax number.
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->container['email'] = $email;

        return $this;
    }

    /**
     * Gets fax_number
     *
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->container['fax_number'];
    }

    /**
     * Sets fax_number
     *
     * @param string $fax_number Your fax number. Must be provided if no phone number or email.
     *
     * @return $this
     */
    public function setFaxNumber($fax_number)
    {
        $this->container['fax_number'] = $fax_number;

        return $this;
    }

    /**
     * Gets first_name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->container['first_name'];
    }

    /**
     * Sets first_name
     *
     * @param string $first_name Your first name.
     *
     * @return $this
     */
    public function setFirstName($first_name)
    {
        $this->container['first_name'] = $first_name;

        return $this;
    }

    /**
     * Gets address_line_1
     *
     * @return string
     */
    public function getAddressLine1()
    {
        return $this->container['address_line_1'];
    }

    /**
     * Sets address_line_1
     *
     * @param string $address_line_1 Your street address
     *
     * @return $this
     */
    public function setAddressLine1($address_line_1)
    {
        $this->container['address_line_1'] = $address_line_1;

        return $this;
    }

    /**
     * Gets address_line_2
     *
     * @return string
     */
    public function getAddressLine2()
    {
        return $this->container['address_line_2'];
    }

    /**
     * Sets address_line_2
     *
     * @param string $address_line_2 
     *
     * @return $this
     */
    public function setAddressLine2($address_line_2)
    {
        $this->container['address_line_2'] = $address_line_2;

        return $this;
    }

    /**
     * Gets address_city
     *
     * @return string
     */
    public function getAddressCity()
    {
        return $this->container['address_city'];
    }

    /**
     * Sets address_city
     *
     * @param string $address_city Your nearest city
     *
     * @return $this
     */
    public function setAddressCity($address_city)
    {
        $this->container['address_city'] = $address_city;

        return $this;
    }

    /**
     * Gets address_state
     *
     * @return string
     */
    public function getAddressState()
    {
        return $this->container['address_state'];
    }

    /**
     * Sets address_state
     *
     * @param string $address_state Your current state
     *
     * @return $this
     */
    public function setAddressState($address_state)
    {
        $this->container['address_state'] = $address_state;

        return $this;
    }

    /**
     * Gets address_postal_code
     *
     * @return string
     */
    public function getAddressPostalCode()
    {
        return $this->container['address_postal_code'];
    }

    /**
     * Sets address_postal_code
     *
     * @param string $address_postal_code Your current postcode
     *
     * @return $this
     */
    public function setAddressPostalCode($address_postal_code)
    {
        $this->container['address_postal_code'] = $address_postal_code;

        return $this;
    }

    /**
     * Gets address_country
     *
     * @return string
     */
    public function getAddressCountry()
    {
        return $this->container['address_country'];
    }

    /**
     * Sets address_country
     *
     * @param string $address_country Your current country
     *
     * @return $this
     */
    public function setAddressCountry($address_country)
    {
        $this->container['address_country'] = $address_country;

        return $this;
    }

    /**
     * Gets organization_name
     *
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->container['organization_name'];
    }

    /**
     * Sets organization_name
     *
     * @param string $organization_name Your organisation name
     *
     * @return $this
     */
    public function setOrganizationName($organization_name)
    {
        $this->container['organization_name'] = $organization_name;

        return $this;
    }

    /**
     * Gets custom_2
     *
     * @return string
     */
    public function getCustom2()
    {
        return $this->container['custom_2'];
    }

    /**
     * Sets custom_2
     *
     * @param string $custom_2 
     *
     * @return $this
     */
    public function setCustom2($custom_2)
    {
        $this->container['custom_2'] = $custom_2;

        return $this;
    }

    /**
     * Gets custom_3
     *
     * @return string
     */
    public function getCustom3()
    {
        return $this->container['custom_3'];
    }

    /**
     * Sets custom_3
     *
     * @param string $custom_3 
     *
     * @return $this
     */
    public function setCustom3($custom_3)
    {
        $this->container['custom_3'] = $custom_3;

        return $this;
    }

    /**
     * Gets custom_4
     *
     * @return string
     */
    public function getCustom4()
    {
        return $this->container['custom_4'];
    }

    /**
     * Sets custom_4
     *
     * @param string $custom_4 
     *
     * @return $this
     */
    public function setCustom4($custom_4)
    {
        $this->container['custom_4'] = $custom_4;

        return $this;
    }

    /**
     * Gets last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->container['last_name'];
    }

    /**
     * Sets last_name
     *
     * @param string $last_name Your last name
     *
     * @return $this
     */
    public function setLastName($last_name)
    {
        $this->container['last_name'] = $last_name;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


