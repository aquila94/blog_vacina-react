<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/routing.proto

namespace Google\Api;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specifies the routing information that should be sent along with the request
 * in the form of routing header.
 * **NOTE:** All service configuration rules follow the "last one wins" order.
 * The examples below will apply to an RPC which has the following request type:
 * Message Definition:
 *     message Request {
 *       // The name of the Table
 *       // Values can be of the following formats:
 *       // - `projects/<project>/tables/<table>`
 *       // - `projects/<project>/instances/<instance>/tables/<table>`
 *       // - `region/<region>/zones/<zone>/tables/<table>`
 *       string table_name = 1;
 *       // This value specifies routing for replication.
 *       // It can be in the following formats:
 *       // - `profiles/<profile_id>`
 *       // - a legacy `profile_id` that can be any string
 *       string app_profile_id = 2;
 *     }
 * Example message:
 *     {
 *       table_name: projects/proj_foo/instances/instance_bar/table/table_baz,
 *       app_profile_id: profiles/prof_qux
 *     }
 * The routing header consists of one or multiple key-value pairs. Every key
 * and value must be percent-encoded, and joined together in the format of
 * `key1=value1&key2=value2`.
 * In the examples below I am skipping the percent-encoding for readablity.
 * Example 1
 * Extracting a field from the request to put into the routing header
 * unchanged, with the key equal to the field name.
 * annotation:
 *     option (google.api.routing) = {
 *       // Take the `app_profile_id`.
 *       routing_parameters {
 *         field: "app_profile_id"
 *       }
 *     };
 * result:
 *     x-goog-request-params: app_profile_id=profiles/prof_qux
 * Example 2
 * Extracting a field from the request to put into the routing header
 * unchanged, with the key different from the field name.
 * annotation:
 *     option (google.api.routing) = {
 *       // Take the `app_profile_id`, but name it `routing_id` in the header.
 *       routing_parameters {
 *         field: "app_profile_id"
 *         path_template: "{routing_id=**}"
 *       }
 *     };
 * result:
 *     x-goog-request-params: routing_id=profiles/prof_qux
 * Example 3
 * Extracting a field from the request to put into the routing
 * header, while matching a path template syntax on the field's value.
 * NB: it is more useful to send nothing than to send garbage for the purpose
 * of dynamic routing, since garbage pollutes cache. Thus the matching.
 * Sub-example 3a
 * The field matches the template.
 * annotation:
 *     option (google.api.routing) = {
 *       // Take the `table_name`, if it's well-formed (with project-based
 *       // syntax).
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{table_name=projects/&#42;&#47;instances/&#42;&#47;&#42;*}"
 *       }
 *     };
 * result:
 *     x-goog-request-params:
 *     table_name=projects/proj_foo/instances/instance_bar/table/table_baz
 * Sub-example 3b
 * The field does not match the template.
 * annotation:
 *     option (google.api.routing) = {
 *       // Take the `table_name`, if it's well-formed (with region-based
 *       // syntax).
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{table_name=regions/&#42;&#47;zones/&#42;&#47;&#42;*}"
 *       }
 *     };
 * result:
 *     <no routing header will be sent>
 * Sub-example 3c
 * Multiple alternative conflictingly named path templates are
 * specified. The one that matches is used to construct the header.
 * annotation:
 *     option (google.api.routing) = {
 *       // Take the `table_name`, if it's well-formed, whether
 *       // using the region- or projects-based syntax.
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{table_name=regions/&#42;&#47;zones/&#42;&#47;&#42;*}"
 *       }
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{table_name=projects/&#42;&#47;instances/&#42;&#47;&#42;*}"
 *       }
 *     };
 * result:
 *     x-goog-request-params:
 *     table_name=projects/proj_foo/instances/instance_bar/table/table_baz
 * Example 4
 * Extracting a single routing header key-value pair by matching a
 * template syntax on (a part of) a single request field.
 * annotation:
 *     option (google.api.routing) = {
 *       // Take just the project id from the `table_name` field.
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{routing_id=projects/&#42;}/&#42;*"
 *       }
 *     };
 * result:
 *     x-goog-request-params: routing_id=projects/proj_foo
 * Example 5
 * Extracting a single routing header key-value pair by matching
 * several conflictingly named path templates on (parts of) a single request
 * field. The last template to match "wins" the conflict.
 * annotation:
 *     option (google.api.routing) = {
 *       // If the `table_name` does not have instances information,
 *       // take just the project id for routing.
 *       // Otherwise take project + instance.
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{routing_id=projects/&#42;}/&#42;*"
 *       }
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{routing_id=projects/&#42;&#47;instances/&#42;}/&#42;*"
 *       }
 *     };
 * result:
 *     x-goog-request-params:
 *     routing_id=projects/proj_foo/instances/instance_bar
 * Example 6
 * Extracting multiple routing header key-value pairs by matching
 * several non-conflicting path templates on (parts of) a single request field.
 * Sub-example 6a
 * Make the templates strict, so that if the `table_name` does not
 * have an instance information, nothing is sent.
 * annotation:
 *     option (google.api.routing) = {
 *       // The routing code needs two keys instead of one composite
 *       // but works only for the tables with the "project-instance" name
 *       // syntax.
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{project_id=projects/&#42;}/instances/&#42;&#47;&#42;*"
 *       }
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "projects/&#42;&#47;{instance_id=instances/&#42;}/&#42;*"
 *       }
 *     };
 * result:
 *     x-goog-request-params:
 *     project_id=projects/proj_foo&instance_id=instances/instance_bar
 * Sub-example 6b
 * Make the templates loose, so that if the `table_name` does not
 * have an instance information, just the project id part is sent.
 * annotation:
 *     option (google.api.routing) = {
 *       // The routing code wants two keys instead of one composite
 *       // but will work with just the `project_id` for tables without
 *       // an instance in the `table_name`.
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{project_id=projects/&#42;}/&#42;*"
 *       }
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "projects/&#42;&#47;{instance_id=instances/&#42;}/&#42;*"
 *       }
 *     };
 * result (is the same as 6a for our example message because it has the instance
 * information):
 *     x-goog-request-params:
 *     project_id=projects/proj_foo&instance_id=instances/instance_bar
 * Example 7
 * Extracting multiple routing header key-value pairs by matching
 * several path templates on multiple request fields.
 * NB: note that here there is no way to specify sending nothing if one of the
 * fields does not match its template. E.g. if the `table_name` is in the wrong
 * format, the `project_id` will not be sent, but the `routing_id` will be.
 * The backend routing code has to be aware of that and be prepared to not
 * receive a full complement of keys if it expects multiple.
 * annotation:
 *     option (google.api.routing) = {
 *       // The routing needs both `project_id` and `routing_id`
 *       // (from the `app_profile_id` field) for routing.
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{project_id=projects/&#42;}/&#42;*"
 *       }
 *       routing_parameters {
 *         field: "app_profile_id"
 *         path_template: "{routing_id=**}"
 *       }
 *     };
 * result:
 *     x-goog-request-params:
 *     project_id=projects/proj_foo&routing_id=profiles/prof_qux
 * Example 8
 * Extracting a single routing header key-value pair by matching
 * several conflictingly named path templates on several request fields. The
 * last template to match "wins" the conflict.
 * annotation:
 *     option (google.api.routing) = {
 *       // The `routing_id` can be a project id or a region id depending on
 *       // the table name format, but only if the `app_profile_id` is not set.
 *       // If `app_profile_id` is set it should be used instead.
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{routing_id=projects/&#42;}/&#42;*"
 *       }
 *       routing_parameters {
 *          field: "table_name"
 *          path_template: "{routing_id=regions/&#42;}/&#42;*"
 *       }
 *       routing_parameters {
 *         field: "app_profile_id"
 *         path_template: "{routing_id=**}"
 *       }
 *     };
 * result:
 *     x-goog-request-params: routing_id=profiles/prof_qux
 * Example 9
 * Bringing it all together.
 * annotation:
 *     option (google.api.routing) = {
 *       // For routing both `table_location` and a `routing_id` are needed.
 *       //
 *       // table_location can be either an instance id or a region+zone id.
 *       //
 *       // For `routing_id`, take the value of `app_profile_id`
 *       // - If it's in the format `profiles/<profile_id>`, send
 *       // just the `<profile_id>` part.
 *       // - If it's any other literal, send it as is.
 *       // If the `app_profile_id` is empty, and the `table_name` starts with
 *       // the project_id, send that instead.
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "projects/&#42;&#47;{table_location=instances/&#42;}/tables/&#42;"
 *       }
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{table_location=regions/&#42;&#47;zones/&#42;}/tables/&#42;"
 *       }
 *       routing_parameters {
 *         field: "table_name"
 *         path_template: "{routing_id=projects/&#42;}/&#42;*"
 *       }
 *       routing_parameters {
 *         field: "app_profile_id"
 *         path_template: "{routing_id=**}"
 *       }
 *       routing_parameters {
 *         field: "app_profile_id"
 *         path_template: "profiles/{routing_id=*}"
 *       }
 *     };
 * result:
 *     x-goog-request-params:
 *     table_location=instances/instance_bar&routing_id=prof_qux
 *
 * Generated from protobuf message <code>google.api.RoutingRule</code>
 */
class RoutingRule extends \Google\Protobuf\Internal\Message
{
    /**
     * A collection of Routing Parameter specifications.
     * **NOTE:** If multiple Routing Parameters describe the same key
     * (via the `path_template` field or via the `field` field when
     * `path_template` is not provided), "last one wins" rule
     * determines which Parameter gets used.
     * See the examples for more details.
     *
     * Generated from protobuf field <code>repeated .google.api.RoutingParameter routing_parameters = 2;</code>
     */
    private $routing_parameters;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Api\RoutingParameter[]|\Google\Protobuf\Internal\RepeatedField $routing_parameters
     *           A collection of Routing Parameter specifications.
     *           **NOTE:** If multiple Routing Parameters describe the same key
     *           (via the `path_template` field or via the `field` field when
     *           `path_template` is not provided), "last one wins" rule
     *           determines which Parameter gets used.
     *           See the examples for more details.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Api\Routing::initOnce();
        parent::__construct($data);
    }

    /**
     * A collection of Routing Parameter specifications.
     * **NOTE:** If multiple Routing Parameters describe the same key
     * (via the `path_template` field or via the `field` field when
     * `path_template` is not provided), "last one wins" rule
     * determines which Parameter gets used.
     * See the examples for more details.
     *
     * Generated from protobuf field <code>repeated .google.api.RoutingParameter routing_parameters = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRoutingParameters()
    {
        return $this->routing_parameters;
    }

    /**
     * A collection of Routing Parameter specifications.
     * **NOTE:** If multiple Routing Parameters describe the same key
     * (via the `path_template` field or via the `field` field when
     * `path_template` is not provided), "last one wins" rule
     * determines which Parameter gets used.
     * See the examples for more details.
     *
     * Generated from protobuf field <code>repeated .google.api.RoutingParameter routing_parameters = 2;</code>
     * @param \Google\Api\RoutingParameter[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRoutingParameters($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Api\RoutingParameter::class);
        $this->routing_parameters = $arr;

        return $this;
    }

}

