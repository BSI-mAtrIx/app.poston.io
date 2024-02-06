<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Notify\V1;

use Twilio\Options;
use Twilio\Values;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
abstract class ServiceOptions {
    /**
     * @param string $friendlyName A string to describe the resource
     * @param string $apnCredentialSid The SID of the Credential to use for APN
     *                                 Bindings
     * @param string $gcmCredentialSid The SID of the Credential to use for GCM
     *                                 Bindings
     * @param string $messagingServiceSid The SID of the Messaging Service to use
     *                                    for SMS Bindings
     * @param string $facebookMessengerPageId Deprecated
     * @param string $defaultApnNotificationProtocolVersion The protocol version to
     *                                                      use for sending APNS
     *                                                      notifications
     * @param string $defaultGcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending GCM
     *                                                      notifications
     * @param string $fcmCredentialSid The SID of the Credential to use for FCM
     *                                 Bindings
     * @param string $defaultFcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending FCM
     *                                                      notifications
     * @param boolean $logEnabled Whether to log notifications
     * @param string $alexaSkillId Deprecated
     * @param string $defaultAlexaNotificationProtocolVersion Deprecated
     * @return CreateServiceOptions Options builder
     */
    public static function create($friendlyName = Values::NONE, $apnCredentialSid = Values::NONE, $gcmCredentialSid = Values::NONE, $messagingServiceSid = Values::NONE, $facebookMessengerPageId = Values::NONE, $defaultApnNotificationProtocolVersion = Values::NONE, $defaultGcmNotificationProtocolVersion = Values::NONE, $fcmCredentialSid = Values::NONE, $defaultFcmNotificationProtocolVersion = Values::NONE, $logEnabled = Values::NONE, $alexaSkillId = Values::NONE, $defaultAlexaNotificationProtocolVersion = Values::NONE) {
        return new CreateServiceOptions($friendlyName, $apnCredentialSid, $gcmCredentialSid, $messagingServiceSid, $facebookMessengerPageId, $defaultApnNotificationProtocolVersion, $defaultGcmNotificationProtocolVersion, $fcmCredentialSid, $defaultFcmNotificationProtocolVersion, $logEnabled, $alexaSkillId, $defaultAlexaNotificationProtocolVersion);
    }

    /**
     * @param string $friendlyName The string that identifies the Service resources
     *                             to read
     * @return ReadServiceOptions Options builder
     */
    public static function read($friendlyName = Values::NONE) {
        return new ReadServiceOptions($friendlyName);
    }

    /**
     * @param string $friendlyName A string to describe the resource
     * @param string $apnCredentialSid The SID of the Credential to use for APN
     *                                 Bindings
     * @param string $gcmCredentialSid The SID of the Credential to use for GCM
     *                                 Bindings
     * @param string $messagingServiceSid The SID of the Messaging Service to use
     *                                    for SMS Bindings
     * @param string $facebookMessengerPageId Deprecated
     * @param string $defaultApnNotificationProtocolVersion The protocol version to
     *                                                      use for sending APNS
     *                                                      notifications
     * @param string $defaultGcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending GCM
     *                                                      notifications
     * @param string $fcmCredentialSid The SID of the Credential to use for FCM
     *                                 Bindings
     * @param string $defaultFcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending FCM
     *                                                      notifications
     * @param boolean $logEnabled Whether to log notifications
     * @param string $alexaSkillId Deprecated
     * @param string $defaultAlexaNotificationProtocolVersion Deprecated
     * @return UpdateServiceOptions Options builder
     */
    public static function update($friendlyName = Values::NONE, $apnCredentialSid = Values::NONE, $gcmCredentialSid = Values::NONE, $messagingServiceSid = Values::NONE, $facebookMessengerPageId = Values::NONE, $defaultApnNotificationProtocolVersion = Values::NONE, $defaultGcmNotificationProtocolVersion = Values::NONE, $fcmCredentialSid = Values::NONE, $defaultFcmNotificationProtocolVersion = Values::NONE, $logEnabled = Values::NONE, $alexaSkillId = Values::NONE, $defaultAlexaNotificationProtocolVersion = Values::NONE) {
        return new UpdateServiceOptions($friendlyName, $apnCredentialSid, $gcmCredentialSid, $messagingServiceSid, $facebookMessengerPageId, $defaultApnNotificationProtocolVersion, $defaultGcmNotificationProtocolVersion, $fcmCredentialSid, $defaultFcmNotificationProtocolVersion, $logEnabled, $alexaSkillId, $defaultAlexaNotificationProtocolVersion);
    }
}

class CreateServiceOptions extends Options {
    /**
     * @param string $friendlyName A string to describe the resource
     * @param string $apnCredentialSid The SID of the Credential to use for APN
     *                                 Bindings
     * @param string $gcmCredentialSid The SID of the Credential to use for GCM
     *                                 Bindings
     * @param string $messagingServiceSid The SID of the Messaging Service to use
     *                                    for SMS Bindings
     * @param string $facebookMessengerPageId Deprecated
     * @param string $defaultApnNotificationProtocolVersion The protocol version to
     *                                                      use for sending APNS
     *                                                      notifications
     * @param string $defaultGcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending GCM
     *                                                      notifications
     * @param string $fcmCredentialSid The SID of the Credential to use for FCM
     *                                 Bindings
     * @param string $defaultFcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending FCM
     *                                                      notifications
     * @param boolean $logEnabled Whether to log notifications
     * @param string $alexaSkillId Deprecated
     * @param string $defaultAlexaNotificationProtocolVersion Deprecated
     */
    public function __construct($friendlyName = Values::NONE, $apnCredentialSid = Values::NONE, $gcmCredentialSid = Values::NONE, $messagingServiceSid = Values::NONE, $facebookMessengerPageId = Values::NONE, $defaultApnNotificationProtocolVersion = Values::NONE, $defaultGcmNotificationProtocolVersion = Values::NONE, $fcmCredentialSid = Values::NONE, $defaultFcmNotificationProtocolVersion = Values::NONE, $logEnabled = Values::NONE, $alexaSkillId = Values::NONE, $defaultAlexaNotificationProtocolVersion = Values::NONE) {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['apnCredentialSid'] = $apnCredentialSid;
        $this->options['gcmCredentialSid'] = $gcmCredentialSid;
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        $this->options['facebookMessengerPageId'] = $facebookMessengerPageId;
        $this->options['defaultApnNotificationProtocolVersion'] = $defaultApnNotificationProtocolVersion;
        $this->options['defaultGcmNotificationProtocolVersion'] = $defaultGcmNotificationProtocolVersion;
        $this->options['fcmCredentialSid'] = $fcmCredentialSid;
        $this->options['defaultFcmNotificationProtocolVersion'] = $defaultFcmNotificationProtocolVersion;
        $this->options['logEnabled'] = $logEnabled;
        $this->options['alexaSkillId'] = $alexaSkillId;
        $this->options['defaultAlexaNotificationProtocolVersion'] = $defaultAlexaNotificationProtocolVersion;
    }

    /**
     * A descriptive string that you create to describe the resource. It can be up to 64 characters long.
     * 
     * @param string $friendlyName A string to describe the resource
     * @return $this Fluent Builder
     */
    public function setFriendlyName($friendlyName) {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    /**
     * The SID of the [Credential](https://www.twilio.com/docs/notify/api/credential-resource) to use for APN Bindings.
     * 
     * @param string $apnCredentialSid The SID of the Credential to use for APN
     *                                 Bindings
     * @return $this Fluent Builder
     */
    public function setApnCredentialSid($apnCredentialSid) {
        $this->options['apnCredentialSid'] = $apnCredentialSid;
        return $this;
    }

    /**
     * The SID of the [Credential](https://www.twilio.com/docs/notify/api/credential-resource) to use for GCM Bindings.
     * 
     * @param string $gcmCredentialSid The SID of the Credential to use for GCM
     *                                 Bindings
     * @return $this Fluent Builder
     */
    public function setGcmCredentialSid($gcmCredentialSid) {
        $this->options['gcmCredentialSid'] = $gcmCredentialSid;
        return $this;
    }

    /**
     * The SID of the [Messaging Service](https://www.twilio.com/docs/sms/send-messages#messaging-services) to use for SMS Bindings. This parameter must be set in order to send SMS notifications.
     * 
     * @param string $messagingServiceSid The SID of the Messaging Service to use
     *                                    for SMS Bindings
     * @return $this Fluent Builder
     */
    public function setMessagingServiceSid($messagingServiceSid) {
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        return $this;
    }

    /**
     * Deprecated.
     * 
     * @param string $facebookMessengerPageId Deprecated
     * @return $this Fluent Builder
     */
    public function setFacebookMessengerPageId($facebookMessengerPageId) {
        $this->options['facebookMessengerPageId'] = $facebookMessengerPageId;
        return $this;
    }

    /**
     * The protocol version to use for sending APNS notifications. Can be overridden on a Binding by Binding basis when creating a [Binding](https://www.twilio.com/docs/notify/api/binding-resource) resource.
     * 
     * @param string $defaultApnNotificationProtocolVersion The protocol version to
     *                                                      use for sending APNS
     *                                                      notifications
     * @return $this Fluent Builder
     */
    public function setDefaultApnNotificationProtocolVersion($defaultApnNotificationProtocolVersion) {
        $this->options['defaultApnNotificationProtocolVersion'] = $defaultApnNotificationProtocolVersion;
        return $this;
    }

    /**
     * The protocol version to use for sending GCM notifications. Can be overridden on a Binding by Binding basis when creating a [Binding](https://www.twilio.com/docs/notify/api/binding-resource) resource.
     * 
     * @param string $defaultGcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending GCM
     *                                                      notifications
     * @return $this Fluent Builder
     */
    public function setDefaultGcmNotificationProtocolVersion($defaultGcmNotificationProtocolVersion) {
        $this->options['defaultGcmNotificationProtocolVersion'] = $defaultGcmNotificationProtocolVersion;
        return $this;
    }

    /**
     * The SID of the [Credential](https://www.twilio.com/docs/notify/api/credential-resource) to use for FCM Bindings.
     * 
     * @param string $fcmCredentialSid The SID of the Credential to use for FCM
     *                                 Bindings
     * @return $this Fluent Builder
     */
    public function setFcmCredentialSid($fcmCredentialSid) {
        $this->options['fcmCredentialSid'] = $fcmCredentialSid;
        return $this;
    }

    /**
     * The protocol version to use for sending FCM notifications. Can be overridden on a Binding by Binding basis when creating a [Binding](https://www.twilio.com/docs/notify/api/binding-resource) resource.
     * 
     * @param string $defaultFcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending FCM
     *                                                      notifications
     * @return $this Fluent Builder
     */
    public function setDefaultFcmNotificationProtocolVersion($defaultFcmNotificationProtocolVersion) {
        $this->options['defaultFcmNotificationProtocolVersion'] = $defaultFcmNotificationProtocolVersion;
        return $this;
    }

    /**
     * Whether to log notifications. Can be: `true` or `false` and the default is `true`.
     * 
     * @param boolean $logEnabled Whether to log notifications
     * @return $this Fluent Builder
     */
    public function setLogEnabled($logEnabled) {
        $this->options['logEnabled'] = $logEnabled;
        return $this;
    }

    /**
     * Deprecated.
     * 
     * @param string $alexaSkillId Deprecated
     * @return $this Fluent Builder
     */
    public function setAlexaSkillId($alexaSkillId) {
        $this->options['alexaSkillId'] = $alexaSkillId;
        return $this;
    }

    /**
     * Deprecated.
     * 
     * @param string $defaultAlexaNotificationProtocolVersion Deprecated
     * @return $this Fluent Builder
     */
    public function setDefaultAlexaNotificationProtocolVersion($defaultAlexaNotificationProtocolVersion) {
        $this->options['defaultAlexaNotificationProtocolVersion'] = $defaultAlexaNotificationProtocolVersion;
        return $this;
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $options = array();
        foreach ($this->options as $key => $value) {
            if ($value != Values::NONE) {
                $options[] = "$key=$value";
            }
        }
        return '[Twilio.Notify.V1.CreateServiceOptions ' . implode(' ', $options) . ']';
    }
}

class ReadServiceOptions extends Options {
    /**
     * @param string $friendlyName The string that identifies the Service resources
     *                             to read
     */
    public function __construct($friendlyName = Values::NONE) {
        $this->options['friendlyName'] = $friendlyName;
    }

    /**
     * The string that identifies the Service resources to read.
     * 
     * @param string $friendlyName The string that identifies the Service resources
     *                             to read
     * @return $this Fluent Builder
     */
    public function setFriendlyName($friendlyName) {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $options = array();
        foreach ($this->options as $key => $value) {
            if ($value != Values::NONE) {
                $options[] = "$key=$value";
            }
        }
        return '[Twilio.Notify.V1.ReadServiceOptions ' . implode(' ', $options) . ']';
    }
}

class UpdateServiceOptions extends Options {
    /**
     * @param string $friendlyName A string to describe the resource
     * @param string $apnCredentialSid The SID of the Credential to use for APN
     *                                 Bindings
     * @param string $gcmCredentialSid The SID of the Credential to use for GCM
     *                                 Bindings
     * @param string $messagingServiceSid The SID of the Messaging Service to use
     *                                    for SMS Bindings
     * @param string $facebookMessengerPageId Deprecated
     * @param string $defaultApnNotificationProtocolVersion The protocol version to
     *                                                      use for sending APNS
     *                                                      notifications
     * @param string $defaultGcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending GCM
     *                                                      notifications
     * @param string $fcmCredentialSid The SID of the Credential to use for FCM
     *                                 Bindings
     * @param string $defaultFcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending FCM
     *                                                      notifications
     * @param boolean $logEnabled Whether to log notifications
     * @param string $alexaSkillId Deprecated
     * @param string $defaultAlexaNotificationProtocolVersion Deprecated
     */
    public function __construct($friendlyName = Values::NONE, $apnCredentialSid = Values::NONE, $gcmCredentialSid = Values::NONE, $messagingServiceSid = Values::NONE, $facebookMessengerPageId = Values::NONE, $defaultApnNotificationProtocolVersion = Values::NONE, $defaultGcmNotificationProtocolVersion = Values::NONE, $fcmCredentialSid = Values::NONE, $defaultFcmNotificationProtocolVersion = Values::NONE, $logEnabled = Values::NONE, $alexaSkillId = Values::NONE, $defaultAlexaNotificationProtocolVersion = Values::NONE) {
        $this->options['friendlyName'] = $friendlyName;
        $this->options['apnCredentialSid'] = $apnCredentialSid;
        $this->options['gcmCredentialSid'] = $gcmCredentialSid;
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        $this->options['facebookMessengerPageId'] = $facebookMessengerPageId;
        $this->options['defaultApnNotificationProtocolVersion'] = $defaultApnNotificationProtocolVersion;
        $this->options['defaultGcmNotificationProtocolVersion'] = $defaultGcmNotificationProtocolVersion;
        $this->options['fcmCredentialSid'] = $fcmCredentialSid;
        $this->options['defaultFcmNotificationProtocolVersion'] = $defaultFcmNotificationProtocolVersion;
        $this->options['logEnabled'] = $logEnabled;
        $this->options['alexaSkillId'] = $alexaSkillId;
        $this->options['defaultAlexaNotificationProtocolVersion'] = $defaultAlexaNotificationProtocolVersion;
    }

    /**
     * A descriptive string that you create to describe the resource. It can be up to 64 characters long.
     * 
     * @param string $friendlyName A string to describe the resource
     * @return $this Fluent Builder
     */
    public function setFriendlyName($friendlyName) {
        $this->options['friendlyName'] = $friendlyName;
        return $this;
    }

    /**
     * The SID of the [Credential](https://www.twilio.com/docs/notify/api/credential-resource) to use for APN Bindings.
     * 
     * @param string $apnCredentialSid The SID of the Credential to use for APN
     *                                 Bindings
     * @return $this Fluent Builder
     */
    public function setApnCredentialSid($apnCredentialSid) {
        $this->options['apnCredentialSid'] = $apnCredentialSid;
        return $this;
    }

    /**
     * The SID of the [Credential](https://www.twilio.com/docs/notify/api/credential-resource) to use for GCM Bindings.
     * 
     * @param string $gcmCredentialSid The SID of the Credential to use for GCM
     *                                 Bindings
     * @return $this Fluent Builder
     */
    public function setGcmCredentialSid($gcmCredentialSid) {
        $this->options['gcmCredentialSid'] = $gcmCredentialSid;
        return $this;
    }

    /**
     * The SID of the [Messaging Service](https://www.twilio.com/docs/sms/send-messages#messaging-services) to use for SMS Bindings. This parameter must be set in order to send SMS notifications.
     * 
     * @param string $messagingServiceSid The SID of the Messaging Service to use
     *                                    for SMS Bindings
     * @return $this Fluent Builder
     */
    public function setMessagingServiceSid($messagingServiceSid) {
        $this->options['messagingServiceSid'] = $messagingServiceSid;
        return $this;
    }

    /**
     * Deprecated.
     * 
     * @param string $facebookMessengerPageId Deprecated
     * @return $this Fluent Builder
     */
    public function setFacebookMessengerPageId($facebookMessengerPageId) {
        $this->options['facebookMessengerPageId'] = $facebookMessengerPageId;
        return $this;
    }

    /**
     * The protocol version to use for sending APNS notifications. Can be overridden on a Binding by Binding basis when creating a [Binding](https://www.twilio.com/docs/notify/api/binding-resource) resource.
     * 
     * @param string $defaultApnNotificationProtocolVersion The protocol version to
     *                                                      use for sending APNS
     *                                                      notifications
     * @return $this Fluent Builder
     */
    public function setDefaultApnNotificationProtocolVersion($defaultApnNotificationProtocolVersion) {
        $this->options['defaultApnNotificationProtocolVersion'] = $defaultApnNotificationProtocolVersion;
        return $this;
    }

    /**
     * The protocol version to use for sending GCM notifications. Can be overridden on a Binding by Binding basis when creating a [Binding](https://www.twilio.com/docs/notify/api/binding-resource) resource.
     * 
     * @param string $defaultGcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending GCM
     *                                                      notifications
     * @return $this Fluent Builder
     */
    public function setDefaultGcmNotificationProtocolVersion($defaultGcmNotificationProtocolVersion) {
        $this->options['defaultGcmNotificationProtocolVersion'] = $defaultGcmNotificationProtocolVersion;
        return $this;
    }

    /**
     * The SID of the [Credential](https://www.twilio.com/docs/notify/api/credential-resource) to use for FCM Bindings.
     * 
     * @param string $fcmCredentialSid The SID of the Credential to use for FCM
     *                                 Bindings
     * @return $this Fluent Builder
     */
    public function setFcmCredentialSid($fcmCredentialSid) {
        $this->options['fcmCredentialSid'] = $fcmCredentialSid;
        return $this;
    }

    /**
     * The protocol version to use for sending FCM notifications. Can be overridden on a Binding by Binding basis when creating a [Binding](https://www.twilio.com/docs/notify/api/binding-resource) resource.
     * 
     * @param string $defaultFcmNotificationProtocolVersion The protocol version to
     *                                                      use for sending FCM
     *                                                      notifications
     * @return $this Fluent Builder
     */
    public function setDefaultFcmNotificationProtocolVersion($defaultFcmNotificationProtocolVersion) {
        $this->options['defaultFcmNotificationProtocolVersion'] = $defaultFcmNotificationProtocolVersion;
        return $this;
    }

    /**
     * Whether to log notifications. Can be: `true` or `false` and the default is `true`.
     * 
     * @param boolean $logEnabled Whether to log notifications
     * @return $this Fluent Builder
     */
    public function setLogEnabled($logEnabled) {
        $this->options['logEnabled'] = $logEnabled;
        return $this;
    }

    /**
     * Deprecated.
     * 
     * @param string $alexaSkillId Deprecated
     * @return $this Fluent Builder
     */
    public function setAlexaSkillId($alexaSkillId) {
        $this->options['alexaSkillId'] = $alexaSkillId;
        return $this;
    }

    /**
     * Deprecated.
     * 
     * @param string $defaultAlexaNotificationProtocolVersion Deprecated
     * @return $this Fluent Builder
     */
    public function setDefaultAlexaNotificationProtocolVersion($defaultAlexaNotificationProtocolVersion) {
        $this->options['defaultAlexaNotificationProtocolVersion'] = $defaultAlexaNotificationProtocolVersion;
        return $this;
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $options = array();
        foreach ($this->options as $key => $value) {
            if ($value != Values::NONE) {
                $options[] = "$key=$value";
            }
        }
        return '[Twilio.Notify.V1.UpdateServiceOptions ' . implode(' ', $options) . ']';
    }
}