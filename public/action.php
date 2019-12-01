<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) die('Invalid Request');
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest' )  return;

require dirname(__DIR__)."/vendor/autoload.php";

use App\Controller\User;
use App\Controller\ImageService;

$filters['view']    = isset($_POST['view'])? $_POST['view'] : 'table';
$filters['active']  = isset($_POST['active'])? $_POST['active'] : -1;

$filters['name']    = (isset($_POST['name']) && trim($_POST['name']))? $_POST['name'] : null;
$filters['date']    = isset($_POST['date'])? $_POST['date'] : null;

if(isset($_POST['date'])){
    if(isset($_POST['from'])){
        if(isset($_POST['to'])){
            $filters['date']['to'] = $_POST['date']['to'];
        }
        $filters['date']['from'] = $_POST['date']['from'];
    }
} else {
    $filters['date'] = [];
}


$user = new User();
$users = $user->showUserAction($filters); ?>
                <?php if($filters['view'] == 'table') : ?>
                    <table class="table table-stripped">
                        <thead>
                            <tr><th>ID</th><th>Image</th><th>Name</th><th>Surname</th><th>Rating</th><th>Active</th><th>Last Login</th></tr>
                        </thead>
                        <tbody> 
                            <?php if($users) : 
                                    foreach($users as $user):                                          
                                        ImageService::generate($user->picture, 100, 100);
                                    ?>                            
                                    <tr>                            
                                        <td><?php echo $user->id ?></td>
                                        <td><img src="<?php echo '../data/resize/' . basename($user->picture) ?>" alt="<?php echo $user->name ?>" class="img-thumb" /></td>
                                        <td><?php echo $user->name ?></td>
                                        <td><?php echo $user->surname; ?></td>
                                        <td><?php echo $user->rating; ?></td>
                                        <td><?php echo $user->active ?></td>
                                        <td><?php echo $user->last_login ?></td>                            
                                    </tr>
                                <?php endforeach ?>

                            <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center"> No Users Found :) </td>
                                    </tr>
                            <?php endif ?>
                        </tbody>
                    </table> 
                <?php else: ?>
                    <?php  if($users) : ?>
                    <?php    foreach($users as $user):                                          
                            ImageService::generate($user->picture, 100, 100);   ?>  
                    <div class="col-xs-3">
                        <img class="img-thumbnail" src="<?php echo '../data/resize/' . basename($user->picture) ?>" alt="<?php echo $user->name ?>" alt="a picture of a cat">
                        <div><b>Name:</b> <?php echo $user->name ?></div>
                        <div><b>Surname: </b><?php echo $user->surname; ?></div>
                        <div><b>Last Login:</b> <?php echo $user->last_login; ?></div>
                    </div>                                    
                    <?php   endforeach; ?>
                <?php   endif ?>
                <?php endif ?>