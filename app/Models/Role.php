<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    protected $fillable= [
        'name'
    ];


    public function abilities(){
        return $this->hasMany(RoleAbility::class);
    }

    public static function createWithAbilities(Request $request){
        DB::beginTransaction();
        try {
            $role =Role::create([
                'name'=>$request->post('name')
            ]);
    
            foreach ($request->abilities as $key=>$type) {
                RoleAbility::create([
                    'role_id'=>$role->id,
                    'ability'=>$key,
                    'type'=>$type
                ]);
            }
            
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return $role;
    }
    public function updateWithAbilities(Request $request){
        DB::beginTransaction();
        try {
            $this->update([
                'name'=>$request->post('name')
            ]);
    
            foreach ($request->abilities as $key=>$type) {
                RoleAbility::updateorcreate([
                    'role_id'=>$this->id,
                    'ability'=>$key
                ],[
                    'type'=>$type
                ]);
            }
            
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return $this;
    }
}
