<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\CardsCategory;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APICardsCategoryController extends Controller
{
    public function createCardsCategory (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cards_category_name' => 'required|string|max:255',
            'cards_category_description' => 'nullable|string|max:255'            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        CardsCategory::create([
            'cards_category_name' => $request->get('cards_category_name'),
            'cards_category_description' => $request->get('cards_category_description')            
        ]);
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Cards Category Created Successfully'            
        ));
    }
    
    public function updateCardsCategory (Request $request, CardsCategory $cardsCategory)
    {
       
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'cards_category_id' => 'exists:cards_category_master,cards_category_id',
            'cards_category_name' => 'required|string|max:255',
            'cards_category_description' => 'nullable|string|max:255'            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $cardsCategory->cards_category_id = $input['cards_category_id'];
        $cardsCategory->cards_category_name = $input['cards_category_name'];
        $cardsCategory->cards_category_description = $input['cards_category_description'];
        
        CardsCategory::where('cards_category_id',$cardsCategory->cards_category_id)->update($input);
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Cards Category Updated Successfully'            
        ));
    }
    
    public function listCardsCategory()
    {
        $cardsCategoryList = DB::table('cards_category_master')
                ->select('cards_category_master.*')
                ->where('cards_category_name','<>','USER UPLOADED')
                ->get();
       
        if (!count($cardsCategoryList)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Cards Category Not Found'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Cards Category List Retrieved Successfully',
            'output' => $cardsCategoryList->toArray()            
        ));
    }
    
    public function deleteCardsCategory(Request $request)
    {
        $input = $request->all();
        $cards_category_id = $input['cards_category_id'];
        $cards_category_name = $input['cards_category_name'];
        DB::table('users')
                ->where('cards_category_id', '=', $cards_category_id)
                ->where('cards_category_name','=', $cards_category_name)
                ->delete();
        
        $cardsCategory = DB::table('cards_category_master')
                    ->where('cards_category_id', '=', $cards_category_id)
                    ->select('cards_category_master.*')
                    ->get();
       
        if (!count($cardsCategory)) {
            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Cards Category Deleted Successfully'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 400,
            'status' => 'Failure',
            'message' => 'Unable to Delete Cards Category'         
        ));
    }
}
