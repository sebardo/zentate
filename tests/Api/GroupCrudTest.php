<?php

namespace App\Tests\Api;

/**
 * Class GroupCrudTest
 * @package App\Tests\Api
 */

class GroupCrudTest extends BaseTest
{
    /**
     * Create entity test
     * @return mixed
     */
    public function testCreate()
    {
        $groupName = "Group test ".uniqid();
        //do call and get response and client
        list($response, $client) = $this->call('POST','/api/group',  '{"label": "'.$groupName.'"}');

        //asserts
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Group created!', $response['message']);
        $this->assertNotEmpty($response['id']);

        //return entity id for next test
        return array($response['id'], $groupName);
    }

    /**
     * Read entity test
     * @depends testCreate
     */
    public function testRead($parameters)
    {
        list($id, $groupName) = $parameters;
        //do call and get response and client
        list($response, $client) = $this->call('GET','/api/group/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['id']));
        $this->assertTrue(isset($response['label']));
        $this->assertEquals($groupName, $response['label']);
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
        list($response, $client) = $this->call('PUT','/api/group/'.$id, '{"description": "Description group test"}');

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Group updated!', $response['message']);
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
        list($response, $client) = $this->call('DELETE','/api/group/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Group deleted!', $response['message']);
    }
}
