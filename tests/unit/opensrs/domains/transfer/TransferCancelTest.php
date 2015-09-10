<?php

use OpenSRS\domains\transfer\TransferCancel;
/**
 * @group transfer
 * @group TransferCancel
 */
class TransferCancelTest extends PHPUnit_Framework_TestCase
{
    protected $func = 'transferAdd';

    protected $validSubmission = array(
        "data" => array(
            /**
             * Required: 1 of 2
             *
             * domain: domain to be cancelled
             * order_id: ID of the order to be
             *   cancelled
             *
             * MUST specify either domain or
             * order_id
             */
            "domain" => "",
            "order_id" => "",

            /**
             * Required
             *
             * reseller: reseller username
             */
            "reseller" => "",
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->order_id = time();

        $data->data->reseller = "phptest" . time();

        $ns = new TransferCancel( 'array', $data );

        $this->assertTrue( $ns instanceof TransferCancel );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing reseller' => array('reseller'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->order_id = time();

        $data->data->reseller = "phptest" . time();

        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new TransferCancel( 'array', $data );
    }
}
