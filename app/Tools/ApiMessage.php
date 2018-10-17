<?php

namespace App\Tools;

trait ApiMessage
{
    /**
     * @param int $code 逻辑状态码
     * @param string $message 反馈信息
     * @param int $status   http状态码
     * @param array $data 反馈数据
     * @param array $header http设置
     * @return \Illuminate\Http\JsonResponse
     */
    public function msgJson(int $code, string $message, int $status = 200, array $data = [],$header = [])
    {
        $data = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
        return $this->json($data,$status,$header);
    }

    public function json(array $data, int $code, $header = [])
    {
        return response()->json($data,$code,$header);
    }
}