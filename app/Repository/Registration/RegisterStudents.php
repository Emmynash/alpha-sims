<?php   

namespace App\Repository\Registration;

use App\Addpost;
use App\Addstudent_sec;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterStudents{

    public function freshStudentRegistrationBySchool(Request $request)
    {
        
        $schooldetails = Addpost::find(Auth::user()->schoolid);

        try {
            $generatePassword = 'password';//rand(5, 10);

            $checkEmailExist = User::where('email', $request->email)->get();

            if (count($checkEmailExist) > 0) {
                return "exist";
            }

            $checkAdmmission_no = Addstudent_sec::where('admission_no', $request->admissionname)->get();

            if (count($checkAdmmission_no) > 0) {
                return "admission";
            }

            $createAccount = new User();
            $createAccount->firstname = $request->firstname;
            $createAccount->middlename = $request->middlename;
            $createAccount->lastname = $request->lastname;
            $createAccount->schoolid = Auth::user()->schoolid;
            $createAccount->email = $request->email;
            $createAccount->role = "Student";
            $createAccount->phonenumber = $request->phonenumber;
            $createAccount->password = Hash::make($generatePassword);
            $createAccount->save();



            $checkduplicate = Addstudent_sec::where('usernamesystem', $createAccount->id)->get();
    
            if (count($checkduplicate) > 0) {
                return back()->with('error', 'Student already added');
            }
    
    
            $rollNumberProcess = Addstudent_sec::where(['schoolid' => Auth::user()->schoolid, 'classid' => $request->input('studentclassallocated')])->get();
    
    
                $a = array();
    
                for ($i=0; $i < count($rollNumberProcess); $i++) {
                    
                    $rollnumber = $rollNumberProcess[$i]['renumberschoolnew'];
                    array_push($a, $rollnumber);
                }
    
                if (count($a) > 0) {
                    $maxrollnum = max($a);
                    $newrolnumber = $maxrollnum + 1;
                }else{
                    $newrolnumber = '1';
                }
    
    
            $Addstudent = new Addstudent_sec();
            $Addstudent->classid = $request->input('studentclassallocated');
            $Addstudent->schoolid = Auth::user()->schoolid;
            $Addstudent->usernamesystem = $createAccount->id;
            $Addstudent->renumberschoolnew = $newrolnumber;
            $Addstudent->nationality = $request->input('nationality');
            $Addstudent->studentsection = $request->input('studentsectionallocated');
            $Addstudent->schoolsession = $schooldetails->schoolsession;
            $Addstudent->gender = $request->input('studentgender');
            $Addstudent->studenthouse = $request->input('studenthouse');
            $Addstudent->studentreligion = $request->input('studentreligion');
            $Addstudent->bloodgroup = $request->input('bloodgroup');
            $Addstudent->studentclub = $request->input('studentclub');
            $Addstudent->studentshift = $request->input('studenttype');
            $Addstudent->studentfathername = $request->input('fathersname');
            $Addstudent->studentfathernumber = $request->input('fathersphonenumber');
            $Addstudent->studentmothersname = $request->input('mothersname');
            $Addstudent->studentmothersnumber = $request->input('mothersphonenumber');
            $Addstudent->studentpresenthomeaddress = $request->input('studentaddress_sec');
            $Addstudent->studentpermanenthomeaddress = $request->input('studentaddress_sec');
            $Addstudent->dateOfBirth = $request->input('dateofbirth');
            $Addstudent->sessionstatus = 0;
            $Addstudent->admission_no = $request->admissionname;
            $Addstudent->save();
    
            //asign student role
    
            $user = User::find($createAccount->id);
    
            $user->assignRole('Student');
            return "success";
            // return back()->with('success', 'Student added successfully');
        } catch (\Throwable $th) {
            //throw $th;
            
            return $th;
        }



    }

}