<?php

namespace BBPay\Demo;

class BBPay
{
    protected object $config;

    public function __construct(object $config)
    {
        $this->config = $config;
    }

    /**
     * 支付下单
     * @param string $cp_order_id
     * @param int $money
     * @return mixed
     */
    public function pay(string $cp_order_id, int $money): mixed
    {
        $data = array(
            'currency_id' => $this->config->currency_id,
            'money' => $money,
            'callback_url' => $this->config->callback_url,
            'cp_order_id' => $cp_order_id,
            'app_id' => $this->config->app_id,
            'mch_id' => $this->config->mch_id,
            'time' => time(),
        );

        // 这里签名用支付密钥
        $data['sign'] = Utils::make_sign($data, $this->config->pay_key);
        fwrite(STDERR, json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL);

        return Utils::post($this->config->base_url . '/bobi_api/pay_independent', $data);
    }

    /**
     * 支付查单
     * @param $cp_order_id
     * @return mixed
     */
    public function pay_query($cp_order_id): mixed
    {
        $data = array(
            'cp_order_id' => $cp_order_id,
            'mch_id' => $this->config->mch_id,
        );
        // 这里签名用支付密钥
        $data['sign'] = Utils::make_sign($data, $this->config->pay_key);

        return Utils::post($this->config->base_url . '/bobi_api/query_pay', $data);
    }

    /**
     * 下单
     * @param string $user_address
     * @param string $cp_order_id
     * @param int $money
     * @return mixed
     */
    public function cash(string $user_address, string $cp_order_id, int $money): mixed
    {
        $data = array(
            'app_id' => $this->config->app_id,
            'mch_id' => $this->config->mch_id,
            'currency_id' => $this->config->currency_id,
            'money' => $money,
            'cp_order_id' => $cp_order_id,
            'user_adress' => $user_address,
            'callback_url' => $this->config->callback_url,
        );
        // 这里签名用提现密钥
        $data['sign'] = Utils::make_sign($data, $this->config->cash_key);

        return Utils::post($this->config->base_url . '/bobi_api/cash', $data);
    }

    /**
     * 查单
     * @param $cp_order_id
     * @return mixed
     */
    public function cash_query($cp_order_id): mixed
    {
        $data = array(
            'cp_order_id' => $cp_order_id,
            'mch_id' => $this->config->mch_id,
        );
        // 这里签名用支付密钥
        $data['sign'] = Utils::make_sign($data, $this->config->cash_key);

        return Utils::post($this->config->base_url . '/bobi_api/query_cash', $data);
    }

    /**
     * 支付回调
     * @return string
     */
    public function pay_notify(): string
    {
        return $this->__notify($_POST, $this->config->pay_key);
    }

    /**
     * 代付回调
     * @return string
     */
    public function cash_notify(): string
    {
        return $this->__notify($_POST, $this->config->cash_key);
    }

    private function __notify(array $req, string $key): string
    {
        try {
            $data = array(
                'cp_order_id' => $req['cp_order_id'] ?? throw new \Exception('缺少参数cp_order_id'),
                'mch_id' => $req['mch_id'] ?? throw new \Exception('缺少参数mch_id'),
                'sign' => $req['sign'] ?? throw new \Exception('缺少参数sign'),
                'msg' => $req['msg'] ?? throw new \Exception('缺少参数msg'),
                'status' => $req['status'] ?? throw new \Exception('缺少参数status'),
                'money' => $req['money'] ?? throw new \Exception('缺少参数money'),
            );

            // 商户号校验
            if ($data['mch_id'] != $this->config->mch_id) {
                throw new \Exception('商户号不匹配');
            }

            // 支付签名用支付密钥  提现签用提现密钥
            $sign = Utils::make_sign($data, $key);
            // 验证签名
            if ($sign != $data['sign']) {
                throw new \Exception('验签失败');
            }

            return 'ok';
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @return string
     */
    public function cash_confirm(): string
    {
        try {
            $data = array(
                'cp_order_id' => $_POST['cp_order_id'] ?? throw new \Exception('缺少参数cp_order_id'),
                'mch_id' => $_POST['mch_id'] ?? throw new \Exception('缺少参数mch_id'),
                'sign' => $_POST['sign'] ?? throw new \Exception('缺少参数sign'),
            );

            // 商户号校验
            if ($data['mch_id'] != $this->config->mch_id) {
                throw new \Exception('商户号不匹配');
            }

            // 这里签名使用提现密钥
            $sign = Utils::make_sign($data, $this->config->cash_key);
            // 验证签名
            if ($sign != $data['sign']) {
                throw new \Exception('验签失败');
            }

            return json_encode(array('code' => 0), JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return json_encode(array('code' => 500, 'msg' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
        }
    }
}