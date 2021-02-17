<?php

namespace App\Tests\Api;

/**
 * Class SchemaCrudTest
 * @package App\Tests\Api
 */

class SchemaCrudTest extends BaseTest
{
    /**
     * Create entity test
     * @return mixed
     */
    public function testCreate()
    {
        $schemaName = 'Schema test '.uniqid();

        //create schema to add to category creation
        list($response, $client) = $this->call('POST','/api/schema',  '{"name": "'.$schemaName.'"}');

        //asserts
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Schema created!', $response['message']);
        $this->assertNotEmpty($response['id']);

        //return entity id for next test
        return array($response['id'], $schemaName);
    }

    /**
     * Read entity test
     * @depends testCreate
     */
    public function testRead($parameters)
    {
        list($id, $schemaName) = $parameters;
        //do call and get response and client
        list($response, $client) = $this->call('GET','/api/schema/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['id']));
        $this->assertTrue(isset($response['name']));
        $this->assertEquals($schemaName, $response['name']);
        $this->assertNull($response['description']);
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
        list($response, $client) = $this->call('PUT','/api/schema/'.$id, '{"description": "Description schema test"}');

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Schema updated!', $response['message']);
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
        list($response, $client) = $this->call('DELETE','/api/schema/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Schema deleted!', $response['message']);
    }
}
