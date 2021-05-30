<?php

namespace Database\Seeders;

use App\Addpost;
use App\Addstudent_sec;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10).'@gmail.com',
        //     'password' => Hash::make('password'),
        // ]);

        //create an account
            // $addseeduser = new User();
            // $addseeduser->firstname = "Ika";
            // $addseeduser->middlename = "Uhweeka";
            // $addseeduser->lastname ="Danjuma";
            // $addseeduser->email = 'admin@gmail.com';
            // $addseeduser->password = Hash::make('password');
            // $addseeduser->phonenumber = Str::random(11);
            // $addseeduser->save();

            // //add a school and get approved or declined
            // $addschool = new Addpost();
            // $addschool->schooltype = "Secondary";
            // $addschool->schoolname = "Federal Government College";
            // $addschool->schoolemail = "schoolemail2gmail.com";
            // $addschool->schoolstate = "Niger State";
            // $addschool->mobilenumber ="08134930676";
            // $addschool->schoolLogo = "";
            // $addschool->schoolwebsite = "school website";
            // $addschool->dateestablished = "1930";
            // $addschool->schooladdress = "School Address";
            // $addschool->schoolprincipalsignature = "";
            // $addschool->status = 'Approved';
            // $addschool->periodfrom = '2021-04-24';
            // $addschool->periodto = '2022-04-24';
            // $addschool->save();

            // // school setup
                
            // $addschoolInitials = Addpost::find($addschool->id);
            // $addschoolInitials->shoolinitial = "FGCW"; // adding school initials
            // $addschoolInitials->schoolsession = "2020/2021"; // adding school session
            // $addschoolInitials->term = 1;
            // $addschoolInitials->save();

            // //setup classlist
            // //note
            // //primary = 1
            // //secondary =2

            // $classesArray = ["JSS1", "JSS2", 'JSS3', 'SSS1', "SSS2", "SSS3"];

            // for ($i=0; $i < count($classesArray); $i++) { 


                
            // }

            





        for ($i=0; $i < 10; $i++) { 
            $addseeduser = new User();
            $addseeduser->firstname = Str::random(10);
            $addseeduser->middlename = Str::random(10);
            $addseeduser->lastname = Str::random(10);
            $addseeduser->email = Str::random(10).'@gmail.com';
            $addseeduser->password = Hash::make('password');
            $addseeduser->phonenumber = Str::random(11);
            $addseeduser->save();
    
            $rollNumberProcess = Addstudent_sec::where(['schoolid' =>"6", 'classid' => "18"])->get();
    
    
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
            $Addstudent->classid = "18";
            $Addstudent->schoolid = "6";
            $Addstudent->usernamesystem = $addseeduser->id;
            $Addstudent->renumberschoolnew = $newrolnumber;
            $Addstudent->nationality = "Nigerian";
            $Addstudent->studentsection = "6";
            $Addstudent->schoolsession = "2020/2021";
            $Addstudent->gender = "Male";
            $Addstudent->studenthouse = "2";
            $Addstudent->studentreligion = "Christian";
            $Addstudent->bloodgroup = "A+";
            $Addstudent->studentclub = "2";
            $Addstudent->studentshift = "Boarding";
            $Addstudent->studentfathername = "uiui";
            $Addstudent->studentfathernumber = "08134930676";
            $Addstudent->studentmothersname = "dsff dfsdfds";
            $Addstudent->studentmothersnumber = "08134930676";
            $Addstudent->studentpresenthomeaddress = "hghgh jghgh hghgh";
            $Addstudent->studentpermanenthomeaddress = "gfgfghfgh hghgh hghgh jgjgh";
            $Addstudent->dateOfBirth = "Date of birth";
            $Addstudent->sessionstatus = 0;
            $Addstudent->admission_no = Str::random(11);
            $Addstudent->save();
    
            //update schoolId field
            $schoolIdUpdate = User::find($addseeduser->id);
            $schoolIdUpdate->schoolid = "6";
            $schoolIdUpdate->role = "Student";
            $schoolIdUpdate->save();
    
            $user = User::find($addseeduser->id);
    
            $user->assignRole('Student');
        }


    }


}
