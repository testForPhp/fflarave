<?php
namespace App\Repositories;

use App\Models\PayCode;

class PayCodeRepository
{
    public $model;

    public function __construct()
    {
        $this->model = new PayCode();
    }

    public function wheresOrderByPaginate(array $wheres,$order, $sort = 'ASC', $limit = 20)
    {
        $query = null;
        foreach ($wheres as $key=>$val){
            $query = $this->model->where($key,$val);
        }
        return $query->orderBy($order,$sort)->paginate($limit);
    }

    public function insert($data)
    {
        return \DB::table($this->model->getTable())->insert($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function whereFirst($where)
    {
        $query = null;
        foreach ($where as $key=>$value){
            $query = $this->model->where($key,$value);
        }
        return $query->first();
    }

    public function destroy(PayCode $payCode)
    {
        return $payCode->delete();
    }

    public function code($codes = [])
    {
        if($codes == ''){
            $codes = $this->createCode();
        }
        $data = $this->model->whereIn('code',$codes)->get(['code']);
        if($data->isEmpty() && count($codes) == 20){
            return $codes;
        }
        $items = array_diff($codes,collect($data)->pluck('code')->toArray());

        return $this->code(array_merge(
            $items,
            $this->createCode((20 - count($items)))
        ));

    }

    protected function createCode($length = 20)
    {
        $codes = [];
        for ($i = 0; $i < $length; $i++){
            $codes[$i] = $this->randCode();
        }
        return $codes;
    }

    protected function randCode()
    {
        $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
            't', 'u', 'v', 'w', 'x', 'y','z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
        );
        $length = 6;
        $keys = array_rand($chars,$length);
        $codes = '';

        for ($i = 0; $i < $length; $i++){
            $codes .= $chars[$keys[$i]];
        }
        return $codes;
    }
}