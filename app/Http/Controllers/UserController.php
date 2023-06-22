<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function userList(){
        $qry = User::select('name','email')->orderBy('id','desc');
        $data = $qry->limit(15)->get();
        $dataCount = $qry->count();
        return view('user_list')->with(['data'=>$data,'datacount'=>$dataCount]);
    }

    public function userListData(Request $request){
        $sort = $request->order;

        $sortcol = $sort[0]['column'];
        $sortdir = $sort[0]['dir'];

        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;

        $searchkey = $request->search['value'];
        $total = User::count();
        $data = User::select('id','name','email');
        if($sort){
            if($sortcol == '1'){
                $data = $data->orderBy('name',$sortdir);
            }
            if($sortcol == '2'){
                $data = $data->orderBy('email',$sortdir);
            }
        }
        if($searchkey){
            $data = $data->orWhere('name','like',$searchkey.'%')->orWhere('email','like',$searchkey.'%');
        }
        $data = $data->skip($start)->take($length)->get();

        
        $filterdtotal = $searchkey ? count($data) : $total;

        $fdata = array();
        $sl = $start + 1;
        foreach($data as $key => $dataRow){
            $fdata[$key][] = $sl;
            $fdata[$key][] = $dataRow->name;
            $fdata[$key][] = $dataRow->email;
            $sl = $sl+1;
        }

        $dataArr = array(
            'draw'  => $draw,
            'recordsTotal'  =>$total,
            'recordsFiltered'  => $filterdtotal,
            'data'  => $fdata,
        );

        return response()->json($dataArr);
        

    }

}
