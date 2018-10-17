<?php

namespace App\Http\Controllers;

use App\Repositories\ProgramRepository;
use App\Repositories\ProgramUserLogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class ProgramController extends Controller
{
    public function activeProgram(Request $request)
    {
        $request->validate([
            'token' => 'required|size:15'
        ],[
            'token.required' => 'token不能為空',
            'token.size' => '請輸入正確的token'
        ]);

        $program = (new ProgramRepository())->whereFirst([
            'id' => Hashids::decode($request->get('token'))
        ]);

        if(empty($program)){
            return $this->msgJson(404,'觀看方案不存在',404);
        }

        $point = ($program->sales > 0) ? $program->sales : $program->total ;

        $user = Auth::user();

        if($user->point < $point){
            return $this->msgJson(403,'您的點數不夠，請先儲值！',403);
        }

        $old_end_time = $user->vip_end_time;
        $old_program = $user->program;
        $old_is_vip = $user->is_vip;

        if($user->is_vip){
            $user->vip_end_time = date('Y-m-d',strtotime("{$user->vip_end_time}+{$program->time}day"));
        }else{
            $user->vip_end_time = date('Y-m-d',strtotime("{$program->time}day"));
        }

        $user->program_id = $program->id;
        $user->point = $user->point - $point;
        $user->is_vip = 1;

        if(!$user->save()){
            Log::alert('用戶購買觀看方案更新用戶表失敗');
            return $this->msgJson(500,'購買失敗！',500);
        }

        $result = (new ProgramUserLogRepository())->create([
            'user_id' => $user->id,
            'program' => $program->id,
            'money' => $point,
            'summary' => $program->summary
        ]);

        if($result){
            return $this->msgJson(0,'購買成功，請前往觀看視頻！');
        }

        $user->point = $user->point + $point;
        $user->program = $old_program;
        $user->vip_end_time = $old_end_time;
        $user->is_vip = $old_is_vip;

        $user->save();
        Log::alert('購買觀看方案，紀錄購買方案日誌出錯！');
        return $this->msgJson(500,'購買失敗，請重施！',500);

    }
}
