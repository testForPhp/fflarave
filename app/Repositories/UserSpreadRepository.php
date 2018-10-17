<?php
namespace App\Repositories;

use App\Models\UserSpread;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Vinkla\Hashids\Facades\Hashids;

class UserSpreadRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new UserSpread();
    }

    public function isSource(Request $request)
    {
        $nowTotal = 40;
        $nowPoint = 1;

        $userId = Hashids::decode($request->get('token'));

        $user = (new UserRepository())->init()->find($userId);

        if(count($user) < 1){
            return false;
        }

        $ip = $request->ip();
        if($ip == ''){
            return false;
        }
        $date = date('Y-m-d');

        $star = Carbon::parse('today')->toDateTimeString();
        $stop = Carbon::parse('tomorrow')->toDateTimeString();

        $total = $this->model->where('user_id',$user[0]->id)
            ->whereBetween('created_at',[$star,$stop])
            ->sum('point');

        if($total >= $nowTotal){
            return false;
        }

        $isIp = $this->model->whereBetween('created_at',[$star,$stop])
            ->where('ip',$ip)->first();

        if($isIp){
            return false;
        }

        $this->model->create([
            'user_id' => $user[0]->id,
            'point' => $nowPoint,
            'ip' => $ip
        ]);

        (new PayCodeLogRepository())->create([
            'user_id' => $user[0]->id,
            'code_id' => 0,
            'code' => '',
            'money' => 0,
            'point' => $nowPoint,
            'summary' => '推廣贈送',
            'type' => 'spread'
        ]);
        $user[0]['point'] = $user[0]['point'] + $nowPoint;
        $user[0]->save();
    }

}