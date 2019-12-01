<?php
require dirname(__DIR__)."/vendor/autoload.php";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <base href="http://localhost/core/public/" />
<title>User Document</title>
<link rel="stylesheet" id="font-awesome-style-css" href="data/css/bootstrap.min.css" type="text/css" media="all">

<link rel="stylesheet" type="text/css" href="data/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="data/css/style.css">

<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <br/>
    <div class="container">
        <div class="row" style="border:1px solid #EDEDED; padding-top:15px; padding-bottom:15px;">
            <div class="col-sm-12">
                <form id="filterForm">                    
                    <div class="col-sm-2">
                        <label>View</label>
                        <select name="view" class="form-control">                            
                            <option value="table">Table</option>
                            <option value="thumb">Thumb</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>User Status</label>
                        <select name="active" class="form-control">
                            <option value="null">All Users</option>
                            <option value="1">Active</option>
                            <option value="0">In Active</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Name</label>
                        <input type="text" name="name" id="" class="form-control" placeholder="First name" />
                    </div> 
                    <div class="col-sm-2">
                        <div id="from_date" class="input-append date">
                            <label>Date From</label>
                            <input type="text" id="dateFrom" name="date[from]" class="form-control" />
                        </div>

                    </div> 
                    <div class="col-sm-2">                       
                       <div id="to_date" class="input-append date">
                       <label>Date To</label>
                        <input type="text" id="dateTo" name="date[to]" class="form-control" />
                        </div>
                    </div>                      
                    <div class="col-sm-2">     
                    <label>&nbsp;</label>                  
                        <div>
                        <button type="submit" class="btn">Filter</button>
                        <button type="button" class="btn">Reset</button>                                   
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <section class="filter-layout" style="padding:15px 0">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 text-right"> Select Layout </div>
                <div class="col-sm-4">
                    <select name="view" class="form-control" id="viewSelector">
                        <option value="">Select View</option>
                        <option value="table" selected>Tabular</option>
                        <option value="grid">Grid</option>
                    </select>
                </div>
            </div>
        </div>
    </section>
    <section class="page-body">
        <div class="container">
            <div class="row tabularView hidden">
                <div class="col-sm-12">
                    <div id="output_camnvas"></div>
                </div>
            </div>
        </div> 
    </section>

    <script type="text/javascript" charset="utf8" src="data/js/jquery.min.js"></script>
    <script type="text/javascript" src="data/js/jquery.dataTables.min.js"></script>
    <script src="data/js/moment.js"></script>
    <script src="data/js/jquery.datetimepicker-v2.js"></script>
    <script>
        $(document).ready(function(){

            $('#dateFrom, #dateTo').datetimepicker({
                format:'d-m-Y H:i:s'
            });

            function manageView(target){
                current_view = target.val();            
                if(current_view == 'grid'){
                    $(".gridView").removeClass('hidden');
                    $(".tabularView").addClass('hidden')
                } else {
                    $(".gridView").addClass('hidden');
                    $(".tabularView").removeClass('hidden')
                }
            }

            $("#viewSelector").on('change', function(){            
                manageView($(this));
            });
            
            manageView($("#viewSelector"));

            function loadData(){                
                $.ajax({
                    url : 'action.php',
                    type : 'POST',
                    dataType : 'HTML',
                    data : $("#filterForm").serialize(),
                    success : (data) => {
                        $("#output_camnvas").html(data);
                    }, complete : () => {
                        console.log('Completed');
                    }
                });
            }
            loadData();
            $("#filterForm").on('submit', function(e){
                loadData();
                e.preventDefault();
            })

        });
    </script>    
    </body>
</html>