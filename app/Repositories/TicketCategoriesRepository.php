<?php
namespace App\Repositories;

use App\Models\TicketCategory;

class TicketCategoriesRepository{
    public function getList(){
        return TicketCategory::orderBy('id');
    }

    public function store($data){
        TicketCategory::create([
            'name' => $data['name'],
            'status' => !empty($data['status']) ? $data['status'] : 0
        ]);
    }

    public function getTicketCategorybyId($id){
        $ticketCategory = TicketCategory::where('id', $id)->first();
        if($ticketCategory){
            return $ticketCategory;
        }
        return 'Invalid Id';
    }

    public function update($data){
        $ticketCategory = TicketCategory::where('id', $data['id'])->first();
        if($ticketCategory){
            $ticketCategory->update([
                'name' => $data['name'],
                'status' => !empty($data['status']) ? $data['status'] : 0,
            ]);
            return true;
        }
        return 'Not found';
    }

    public function deleteById($id){
        $ticketCategory = TicketCategory::where('id', $id)->with('tickets')->first();
        if(count($ticketCategory->tickets) == 0){
            $ticketCategory->delete();
            return true;
        }
        return false;
    }
}
