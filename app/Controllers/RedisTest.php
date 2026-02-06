<?php

namespace App\Controllers;

use App\Libraries\RedisManager;

class RedisTest extends BaseController
{
  protected $redis;

  public function __construct()
  {
    $this->redis = new RedisManager();
  }

  public function setData()
  {
    $data = [
      'name' => 'John Doe',
      'email' => 'john@example.com'
    ];
    $this->redis->set('user', 'page_1', $data);

    return json_encode(['message' => 'Redis Data Saved']);
  }

  public function getData(){
    $data = $this->redis->get('user','page_1');
    return json_encode(['data' => $data]);
  }

  public function deleteData(){
    $this->redis->delete('user','page_1');
    return json_encode(['message' => 'Redis Data Deleted']);
  }

  public function flushAllData(){
    $this->redis->flushAll();
    return json_encode(['message' => 'All Redis Data Flushed']);
  }

  public function clearNamespace(){
    $this->redis->clearNamespace('user');
    return json_encode(['message' => 'Namespace Cleared']);
  }

}
