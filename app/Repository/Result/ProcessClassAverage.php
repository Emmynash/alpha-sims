<?php

namespace App\Repository\Result;

use Illuminate\Http\Request;
use App\Addpost;
use App\Addsubject_sec;
use Illuminate\Support\Facades\Auth;
use App\Addmark_sec;
use App\ClassAverageMark;
use Illuminate\Support\Facades\DB;

class ProcessClassAverage{

    public function processresult(Request $request)
    {

        //-----------------------------------------------------------------------------------//
        //                                                                                   //
        //                        compute averages for each subject                          //
        //                                                                                   //
        //-----------------------------------------------------------------------------------//

        $classid = $request->classid;
        $schooldata = Addpost::where('id', Auth::user()->schoolid)->first();
        $term = $schooldata->term;
        $schoolsession = $schooldata->schoolsession;

        $subjectarray = Addsubject_sec::where('classid', $classid)->pluck('id');
                

        for ($i=0; $i < count($subjectarray); $i++) {

            $subjectidav = $subjectarray[$i];

            $addmarkcounter = Addmark_sec::where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav, 'session'=>$schoolsession])->get();

            $addmarkAverage = DB::table('addmark_secs') 
            ->where(['classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav, 'session'=>$schoolsession])->SUM('totalmarks');

            if (count($addmarkcounter) > 0) {
                $averagemark = $addmarkAverage/count($addmarkcounter);

                // return $addmarkAverage;

                // check if average has already been added.

                $averageCheck = ClassAverageMark::where(['session'=>$schoolsession, 'classid'=>$classid, 'term'=>$term, 'subjectid'=>$subjectidav])->get();

                if (count($averageCheck) > 0) {

                    $averageCheckid = $averageCheck[0]['id'];

                    $averagemarkupdate = ClassAverageMark::find($averageCheckid);
                    $averagemarkupdate->average = $averagemark;
                    $averagemarkupdate->save();
                    // return $averageCheck;
                    
                }else{

                    $addaverage = new ClassAverageMark();
                    $addaverage->subjectid = $subjectidav;
                    $addaverage->schoolid = Auth::user()->schoolid;
                    $addaverage->classid = $classid;
                    $addaverage->average = $averagemark;
                    $addaverage->term = $term;
                    $addaverage->session = $schoolsession;
                    $addaverage->save();

                }

            }
            
        }

        return "success";

        

        
    }
    
}