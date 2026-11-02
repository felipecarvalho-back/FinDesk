<?php

test('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertOk();
    $response->assertSee('Acesso ao FinDesk');
});
