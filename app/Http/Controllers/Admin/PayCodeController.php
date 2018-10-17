<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\PayCodeRepository;
use Illuminate\Http\Request;

class PayCodeController extends BaseController
{
    public $menuActive = 'point';
    public $payCodeRepository;

    public function __construct(PayCodeRepository $payCodeRepository)
    {
        $this->payCodeRepository = $payCodeRepository;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status,$point)
    {
        $payCodeMenu = '';
        $payCodeActiveMenu = '';

        if($status == 1){
            $payCodeActiveMenu = 'active';
        }else{
            $payCodeMenu = 'active';
        }
        $data['status'] = $status;

        if($point > 0){
            $data['point_id'] = $point;
        }

        $codes = $this->payCodeRepository->wheresOrderByPaginate($data,'id','desc');
        return view('admin.paycode.index',compact(['payCodeMenu','codes','payCodeActiveMenu','status']));
    }


    public function search(Request $request)
    {
        $data = $request->only(['code','money','status']);

        if(empty($data['code']) && $data['money'] == ''){
            return redirect()->back();
        }

        $status = $data['status'];
        $codes = $this->payCodeRepository->wheresOrderByPaginate(array_filter($data),'id','desc');

        return view('admin.paycode.index',compact(['codes','status']));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('id') == false){
            return $this->errorMsg('id is empty',400);
        }
        $id = $request->get('id');

        if($id == ''){
            return $this->errorMsg('id is empty',400);
        }

        $code = $this->payCodeRepository->code();

        $items = [];
        $date = date('Y-m-d H:i:s');

        for ($i = 0; $i < 20; $i++){
            $items[$i]['code'] = $code[$i];
            $items[$i]['point_id'] = $id;
            $items[$i]['created_at'] = $date;
            $items[$i]['updated_at'] = $date;
        }

        if($this->payCodeRepository->insert($items)){
            return $this->msgJson(0,'新增成功',200,$code);
        }
        return $this->msgJson(500,'提交失败',500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $code = $this->payCodeRepository->find($id);

        if(empty($code)){
            return $this->msgJson(404,'支付码不存在',404);
        }

        if($this->payCodeRepository->destroy($code)){
            return $this->msgJson(0,'删除成功');
        }
        return $this->msgJson(500,'删除失败',500);
    }
}
