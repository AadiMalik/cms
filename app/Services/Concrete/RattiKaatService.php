<?php

namespace App\Services\Concrete;

use App\Models\RattiKaat;
use App\Models\RattiKaatBead;
use App\Models\RattiKaatDiamond;
use App\Models\RattiKaatStone;
use App\Repository\Repository;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RattiKaatService
{
    protected $model_ratti_kaat;
    protected $model_ratti_kaat_bead;
    protected $model_ratti_kaat_stone;
    protected $model_ratti_kaat_diamond;

    protected $common_service;
    public function __construct()
    {
        // set the model
        $this->model_ratti_kaat = new Repository(new RattiKaat());
        $this->model_ratti_kaat_bead = new Repository(new RattiKaatBead());
        $this->model_ratti_kaat_stone = new Repository(new RattiKaatStone());
        $this->model_ratti_kaat_diamond = new Repository(new RattiKaatDiamond());

        $this->common_service = new CommonService();
    }
    //Ratti Kaat
    public function getRattiKaatSource()
    {
        $model = RattiKaat::with(['supplier_name','purchase_account_name','paid_account_name'])->where('is_deleted', 0);
        $data = DataTables::of($model)
            ->addColumn('supplier', function ($item) {
                return $item->supplier_name->name??'';
            })
            ->addColumn('purchase_account', function ($item) {
                return $item->purchase_account_name->code??''.'-'.$item->purchase_account_name->name??'';
            })
            ->addColumn('paid_account', function ($item) {
                return $item->paid_account_name->code??''.'-'.$item->paid_account_name->name??'';
            })
            ->addColumn('action', function ($item) {
                $action_column = '';
                $edit_column    = "<a class='text-success mr-2' id='editProduct' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='Edit'><i title='Add' class='nav-icon mr-2 fa fa-edit'></i>Edit</a>";
                $delete_column    = "<a class='text-danger mr-2'  id='deleteProduct' href='javascript:void(0)' data-toggle='tooltip'  data-id='" . $item->id . "' data-original-title='delete'><i title='Delete' class='nav-icon mr-2 fa fa-trash'></i>Delete</a>";
                if (Auth::user()->can('ratti_kaat_edit'))
                    $action_column .= $edit_column;
                if (Auth::user()->can('ratti_kaat_delete'))
                    $action_column .= $delete_column;

                return $action_column;
            })
            ->rawColumns(['supplier','purchase_account','paid_account', 'action'])
            ->make(true);
        return $data;
    }
    // save Ratti Kaat
    public function saveRattiKaat()
    {

        $obj['ratti_kaat_no']=$this->common_service->generateRattiKaatNo();
        $obj['createdby_id'] = Auth::User()->id;

        $saved_obj = $this->model_ratti_kaat->create($obj);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // update Ratti Kaat
    public function updateRattiKaat($obj)
    {

        $obj['updatedby_id'] = Auth::User()->id;
        $this->model_ratti_kaat->update($obj, $obj['id']);
        $saved_obj = $this->model_ratti_kaat->find($obj['id']);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // get by id
    public function getRattiKaatById($id)
    {
        $ratti_kaat = $this->model_ratti_kaat->getModel()::find($id);

        if (!$ratti_kaat)
            return false;

        return $ratti_kaat;
    }
    // status by id
    public function statusById($id)
    {
        $ratti_kaat = $this->model_ratti_kaat->getModel()::find($id);
        if ($ratti_kaat->is_active == 0) {
            $ratti_kaat->is_active = 1;
        } else {
            $ratti_kaat->is_active = 0;
        }
        $ratti_kaat->updatedby_id = Auth::user()->id;
        $ratti_kaat->update();

        if ($ratti_kaat)
            return true;

        return false;
    }
    // delete by id
    public function deleteRattiKaatById($id)
    {
        $ratti_kaat = $this->model_ratti_kaat->getModel()::find($id);
        $ratti_kaat->is_deleted = 1;
        $ratti_kaat->deletedby_id = Auth::user()->id;
        $ratti_kaat->update();

        if (!$ratti_kaat)
            return false;

        return $ratti_kaat;
    }

    // get beads weight
    public function getBeadWeight($ratti_kaat_id, $product_id){
        return $this->model_ratti_kaat_bead->getModel()::with(['ratti_kaat_name','product_name'])
        ->where('ratti_kaat_id',$ratti_kaat_id)
        ->where('product_id',$product_id)
        ->where('is_deleted',0)
        ->get();
    }
    public function saveBeadWeight($obj){

        $obj['createdby_id'] = Auth::User()->id;

        $saved_obj = $this->model_ratti_kaat_bead->create($obj);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // delete bead by id
    public function deleteBeadWeightById($id)
    {
        $ratti_kaat_bead = $this->model_ratti_kaat_bead->getModel()::find($id);
        $ratti_kaat_bead->is_deleted = 1;
        $ratti_kaat_bead->deletedby_id = Auth::user()->id;
        $ratti_kaat_bead->update();

        if (!$ratti_kaat_bead)
            return false;

        return $ratti_kaat_bead;
    }

    // get stones weight
    public function getStoneWeight($ratti_kaat_id, $product_id){
        return $this->model_ratti_kaat_stone->getModel()::with(['ratti_kaat_name','product_name'])
        ->where('ratti_kaat_id',$ratti_kaat_id)
        ->where('product_id',$product_id)
        ->where('is_deleted',0)
        ->get();
    }
    public function saveStoneWeight($obj){

        $obj['createdby_id'] = Auth::User()->id;

        $saved_obj = $this->model_ratti_kaat_stone->create($obj);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // delete stone by id
    public function deleteStoneWeightById($id)
    {
        $ratti_kaat_stone = $this->model_ratti_kaat_stone->getModel()::find($id);
        $ratti_kaat_stone->is_deleted = 1;
        $ratti_kaat_stone->deletedby_id = Auth::user()->id;
        $ratti_kaat_stone->update();

        if (!$ratti_kaat_stone)
            return false;

        return $ratti_kaat_stone;
    }


    // get diamonds Carat
    public function getDiamondCarat($ratti_kaat_id, $product_id){
        return $this->model_ratti_kaat_diamond->getModel()::with(['ratti_kaat_name','product_name'])
        ->where('ratti_kaat_id',$ratti_kaat_id)
        ->where('product_id',$product_id)
        ->where('is_deleted',0)
        ->get();
    }
    public function saveDiamondCarat($obj){

        $obj['createdby_id'] = Auth::User()->id;

        $saved_obj = $this->model_ratti_kaat_diamond->create($obj);

        if (!$saved_obj)
            return false;

        return $saved_obj;
    }

    // delete diamond by id
    public function deleteDiamondCaratById($id)
    {
        $ratti_kaat_diamond = $this->model_ratti_kaat_diamond->getModel()::find($id);
        $ratti_kaat_diamond->is_deleted = 1;
        $ratti_kaat_diamond->deletedby_id = Auth::user()->id;
        $ratti_kaat_diamond->update();

        if (!$ratti_kaat_diamond)
            return false;

        return $ratti_kaat_diamond;
    }
}
