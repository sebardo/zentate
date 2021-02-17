<?php

namespace App\Tests\Api;

/**
 * Class SeatCrudTest
 * @package App\Tests\Api
 */

class SeatCrudTest extends BaseTest
{
    /**
     * Create entity test
     * @return mixed
     */
    public function testCreate()
    {
        //create schema to add to category creation
        list($response, $client) = $this->call('POST','/api/schema',  '{"name": "Schema test '.uniqid().'"}');
        $seatLabel = uniqid();
        //do call and get response and client
        list($response, $client) = $this->call('POST','/api/seat',  '{"label": "'.$seatLabel.'", "schema": "'.$response['id'].'"}', $client);

        //asserts
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Seat created!', $response['message']);
        $this->assertNotEmpty($response['id']);

        //return entity id for next test
        return array($response['id'], $seatLabel);
    }

    /**
     * Read entity test
     * @depends testCreate
     */
    public function testRead($parameters)
    {
        list($id, $seatLabel) = $parameters;
        //do call and get response and client
        list($response, $client) = $this->call('GET','/api/seat/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['id']));
        $this->assertTrue(isset($response['label']));
        $this->assertEquals($seatLabel, $response['label']);
        $this->assertNull($response['displayedLabel']);
        $this->assertNotEmpty($response['id']);
        $this->assertNotEmpty($response['label']);

        //return entity id for next test
        return $response['id'];
    }

    /**
     * Update entity test
     * @depends testRead
     */
    public function testUpdate($id)
    {
        //do call and get response and client
        list($response, $client) = $this->call('PUT','/api/seat/'.$id, '{"displayedLabel": "Label displayed test"}');

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Seat updated!', $response['message']);
        $this->assertNotEmpty($response['id']);

        //return entity id for next test
        return $response['id'];
    }

    /**
     * Delete entity test
     * @depends testUpdate
     */
    public function testDelete($id)
    {
        //do call and get response and client
        list($response, $client) = $this->call('DELETE','/api/seat/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Seat deleted!', $response['message']);
    }
}
