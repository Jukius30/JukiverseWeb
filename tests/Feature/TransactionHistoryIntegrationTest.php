<?php

namespace Tests\Feature;

class TransactionHistoryIntegrationTest extends JukiverseIntegrationTestCase
{
  public function testtransactionhistoryintergration(): void
  {
    $this->createTransaction('success', 'ORDER-HISTORY');

    $response = $this
      ->withSession($this->playerSession())
      ->get('/store');

    $response->assertStatus(200);
    $response->assertSee('ORDER-HISTORY');
  }
}