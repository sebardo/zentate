<?php

namespace App\Tests\Api;

/**
 * Class CategoryCrudTest
 * @package App\Tests\Api
 */

class EventCrudTest extends BaseTest
{
    /**
     * Create entity test
     * @return mixed
     */
    public function testCreate()
    {
        //create schema to add to event creation
        list($response, $client) = $this->call('POST','/api/schema',  '{"name": "Schema test '.uniqid().'"}');

        $eventName = "Event test ".uniqid();
        //do call and get response and client
        list($response, $client) = $this->call('POST','/api/event',  '{"name": "'.$eventName.'", "schema": "'.$response['id'].'"}', $client);

        //asserts
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Event created!', $response['message']);
        $this->assertNotEmpty($response['id']);

        //return entity id for next test
        return array($response['id'], $eventName);
    }

    /**
     * Read entity test
     * @depends testCreate
     */
    public function testRead($parameters)
    {
        list($id, $eventName) = $parameters;
        //do call and get response and client
        list($response, $client) = $this->call('GET','/api/event/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['id']));
        $this->assertTrue(isset($response['name']));
        $this->assertEquals($eventName, $response['name']);
        $this->assertNotEmpty($response['id']);
        $this->assertNotEmpty($response['name']);

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
        list($response, $client) = $this->call('PUT','/api/event/'.$id, '{"description": "Description event test"}');

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Event updated!', $response['message']);
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
        list($response, $client) = $this->call('DELETE','/api/event/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Event deleted!', $response['message']);
    }
}
