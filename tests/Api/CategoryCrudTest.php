<?php

namespace App\Tests\Api;

/**
 * Class CategoryCrudTest
 * @package App\Tests\Api
 */

class CategoryCrudTest extends BaseTest
{
    /**
     * Create entity test
     * @return mixed
     */
    public function testCreate()
    {
        //create schema to add to category creation
        list($response, $client) = $this->call('POST','/api/schema',  '{"name": "Schema test '.uniqid().'"}');

        $categoryName = "Category test ".uniqid();
        //do call and get response and client
        list($response, $client) = $this->call('POST','/api/category',  '{"label": "'.$categoryName.'", "schema": "'.$response['id'].'"}', $client);

        //asserts
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Category created!', $response['message']);
        $this->assertNotEmpty($response['id']);

        //return entity id for next test
        return array($response['id'], $categoryName);
    }

    /**
     * Read entity test
     * @depends testCreate
     */
    public function testRead($parameters)
    {
        list($id, $categoryName) = $parameters;
        //do call and get response and client
        list($response, $client) = $this->call('GET','/api/category/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['id']));
        $this->assertTrue(isset($response['label']));
        $this->assertEquals($categoryName, $response['label']);
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
        list($response, $client) = $this->call('PUT','/api/category/'.$id, '{"description": "Description category test"}');

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertTrue(isset($response['id']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Category updated!', $response['message']);
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
        list($response, $client) = $this->call('DELETE','/api/category/'.$id);

        //asserts
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertTrue(isset($response['status']));
        $this->assertTrue(isset($response['message']));
        $this->assertEquals('success', $response['status']);
        $this->assertEquals('Category deleted!', $response['message']);
    }
}
