<?php declare(strict_types=1);

namespace BBPay\Demo;

use PHPUnit\Framework\TestCase;

final class BBPayTest extends TestCase
{
    private static BBPay $obj;

    public static function setUpBeforeClass(): void
    {
        $config = parse_ini_file('../config.ini', true);
        self::$obj = new BBPay((object)$config);
    }

    public static function tearDownAfterClass(): void
    {
//        self::$obj = null;
    }

    public function testPay(): void
    {
        $cp_order_id = 'P' . time();
        $resp = self::$obj->pay($cp_order_id, 200);
        fwrite(STDERR, json_encode($resp, JSON_UNESCAPED_UNICODE) . PHP_EOL);
        fwrite(STDERR, $cp_order_id . PHP_EOL);

        $this->assertEquals(0, $resp['code']);
    }

    public function testPayQuery(): void
    {
        $cp_order_id = 'P1687766236';
        $resp = self::$obj->pay_query($cp_order_id);
        fwrite(STDERR, $cp_order_id . PHP_EOL);
        fwrite(STDERR, json_encode($resp, JSON_UNESCAPED_UNICODE) . PHP_EOL);
        $this->assertEquals(0, $resp['code']);
    }

    public function testCash(): string
    {
        $cp_order_id = 'C' . time();
        $resp = self::$obj->cash('B57f8d5ebe45563cae58ef5ab5dd85d63', $cp_order_id, 200);
        fwrite(STDERR, json_encode($resp, JSON_UNESCAPED_UNICODE) . PHP_EOL);
        $this->assertEquals(0, $resp['code']);
        return $cp_order_id;
    }

    /**
     * @depends testCash
     */
    public function testCashQuery($cp_order_id): void
    {
        $resp = self::$obj->cash_query($cp_order_id);
        fwrite(STDERR, $cp_order_id . PHP_EOL);
        fwrite(STDERR, json_encode($resp, JSON_UNESCAPED_UNICODE) . PHP_EOL);
        $this->assertEquals(0, $resp['code']);
    }

    public function testCashQuery1(): void
    {
        $cp_order_id = 'C1687767170';
        $resp = self::$obj->cash_query($cp_order_id);
        fwrite(STDERR, json_encode($resp, JSON_UNESCAPED_UNICODE) . PHP_EOL);
        $this->assertEquals(0, $resp['code']);
    }

}