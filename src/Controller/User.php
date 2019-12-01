<?php
namespace App\Controller;
use Vendor\UserService\UserService;
use Vendor\Imagine\Imagine;
use \DateTime;
use Carbon\Carbon;

class User extends UserService{    

    /**
     * @var data     
     */
    
    private $data;    

    public function getData(){
        return parent::getAllUsers();
    }

    public function showUserAction($filters = []){

        $users = $this->getData();
        
        $filtered_results = [];

        foreach($users as $user){
            
            if($filters['active'] !== "null"){                
                if($user->active != $filters['active']) continue;
            } 

            if($filters['name'] !== null){
                
                $haystack = $user->name . " ". $user->surname;                
                $needle = $filters['name'];                
                if(!stristr($haystack, $needle)) continue;
            } 

            if(!empty($filters['date'])){
                $last_login_string = Carbon::parse($user->last_login)->format('d/m/Y H:i:s');                
                $last_login = Carbon::createFromFormat('d/m/Y H:i:s', $last_login_string);

                if(!empty($filters['date']['from'])){                    
                    
                    $date_from_string = Carbon::parse($filters['date']['from'])->format('d-m-Y H:i:s');                    
                    $date_from = Carbon::createFromFormat('d-m-Y H:i:s', $date_from_string);                
                    
                    if(!empty($filters['date']['to'])){                                            
                        
                        $date_to_string = Carbon::parse($filters['date']['to'])->format('d-m-Y H:i:s');                    
                        $date_to = Carbon::createFromFormat('d-m-Y H:i:s', $date_to_string);                

                        if($date_to->greaterThan($date_from)){
                            if($last_login->lessThan($date_from) || $last_login->greaterThanOrEqualTo($date_to)) continue;
                        }
                        

                    } else {                        
                        if($last_login->lessThanOrEqualTo($date_from)) continue;
                    }   
                }
            }
            $filtered_results[] = $user;

        }
        return $filtered_results;        
    }    
}