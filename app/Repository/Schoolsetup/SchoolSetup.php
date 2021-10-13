<?php

namespace App\Repository\Schoolsetup;

use App\Addpost;
use App\Classlist_sec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolSetup{


    public function setupClasses(Request $request)
    {



        try {
            $schoolDetails = Addpost::find(Auth::user()->schoolid);

            if ($schoolDetails->schooltype == "Secondary") {
        
        
                        try {

                            $result = str_split(strtoupper($request->classname));

                            if($result[0] == "S"){
                                if($request->classtype != 2){
                                    return 'classtypeerror';
                                }
                            }else if($result[0] == "J"){
                                if($request->classtype != 1){
                                    return 'classtypeerror';
                                }
                            }else{
                                return 'invalidclass';
                            }

                            $addclasses_sec = Classlist_sec::updateOrCreate(
                                [
                                    'schoolid' => Auth::user()->schoolid, 
                                    'classname' => strtoupper($request->classname)],
                                [
                                    'schoolid' => Auth::user()->schoolid, 
                                    'classname' => strtoupper($request->classname), 
                                    'classtype'=>$request->classtype,
                                    'studentcount' => 0, 
                                    'status' => 1,
                                    'index' => $request->classindex
                                ]
                            );

                            return "success";

                        } catch (\Throwable $th) {
                            
                            return $th;

                        }

        
                
            }else{
    
                $classlistType = $request->classListType;
    
                if ($classlistType == 1) {
                    $classlist = array("Creche", "Playclass", "Nursery 1", "Nursery 2", "Primary 1", "Primary 2", "Primary 3", "Primary 4", "Primary 5", "Primary 6");
                }else{
                    $classlist = array("Reception", "Pre-elementary", "K1", "K2", "Grade 1", "Grade 2", "Grade 3", "Grade 4", "Grade 5", "Pre-School");
                }
    
                $classlistCheck = Classlist_sec::where(['schoolid' => Auth::user()->schoolid])->get();
    
                if ($classlistCheck->count() > 0) {
                    return "success";
                }
        
                for ($i=0; $i < count($classlist); $i++) { 
        
                    $classlistCheck = Classlist_sec::where(['classname' => strtoupper($classlist[$i]), 'schoolid' => Auth::user()->schoolid])->get();
        
                    if (count($classlistCheck) < 1) {
        
                        $addclasses_sec = new Classlist_sec();
                        $addclasses_sec->schoolid = Auth::user()->schoolid;
                        $addclasses_sec->classname = strtoupper($classlist[$i]);
                        $addclasses_sec->studentcount = 0;
                        $addclasses_sec->classtype = 1;
                        $addclasses_sec->status = 1;
                        $addclasses_sec->save();
                    }
        
                }
        
                return "success";
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }

    }


    
}