<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v9/services/keyword_plan_idea_service.proto

namespace Google\Ads\GoogleAds\V9\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Keyword Seed
 *
 * Generated from protobuf message <code>google.ads.googleads.v9.services.KeywordSeed</code>
 */
class KeywordSeed extends \Google\Protobuf\Internal\Message
{
    /**
     * Requires at least one keyword.
     *
     * Generated from protobuf field <code>repeated string keywords = 2;</code>
     */
    private $keywords;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $keywords
     *           Requires at least one keyword.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V9\Services\KeywordPlanIdeaService::initOnce();
        parent::__construct($data);
    }

    /**
     * Requires at least one keyword.
     *
     * Generated from protobuf field <code>repeated string keywords = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Requires at least one keyword.
     *
     * Generated from protobuf field <code>repeated string keywords = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setKeywords($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->keywords = $arr;

        return $this;
    }

}

