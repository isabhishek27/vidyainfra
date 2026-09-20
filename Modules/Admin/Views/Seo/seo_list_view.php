<!DOCTYPE html>
<html>

<head><?php echo view('Modules\Admin\Views\inc\top_head'); ?></head>

<body class="header-white sidebar-light">

    <?php echo view('Modules\Admin\Views\inc\header'); ?>

    <?php echo view('Modules\Admin\Views\inc\left'); ?>

    <div class="main-container">
        <div class="pd-ltr-20">

            <div class="page-header">
                <div class="row">
                    <div class="col-md-8 col-sm-6">
                        <div class="title">
                            <h4><?php echo $page_heading;?></h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo site_url('admin/dashboard');?>">Home</a>
                                </li>                               
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php echo $page_heading;?>                                    
                                </li>

                            </ol>
                        </nav>
                    </div>

                    <div class="col-md-4 col-sm-6 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal"><i
                                class="fa fa-filter"></i> Filter</button>
                        <a href="<?php echo site_url('admin/seo/add');?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>        


                    </div>


                </div>

               
                
            </div>
             <?php
             if (session()->getFlashdata('success') !== NULL){
             ?>   
             <div class="alert alert-success" role="alert"><?php echo session()->getFlashdata('success');?></div>
            <?php } ?>

            <?php
             if (session()->getFlashdata('error') !== NULL){
             ?>   
             <div class="alert alert-danger" role="alert"><?php echo session()->getFlashdata('error');?></div>
            <?php } ?>

            

            <div class="card-box mb-20 dataTables_wrapper dt-bootstrap4 pb-20 pt-20">


                <div class="row mb-20">
                    <div class="col-sm-12 col-md-6">

                        <div class="dt-buttons btn-group flex-wrap">

                            <button class="btn btn-outline-primary action" data-id="approve" tabindex="0" aria-controls="DataTables_Table_2" type="button" ><span>Approve</span></button>

                            <button class="btn  btn-outline-primary action" data-id="disapprove" tabindex="0" aria-controls="DataTables_Table_2"
                                type="button" ><span>Disapprove</span></button>

                            <button class="btn btn-outline-primary action" data-id='delete' tabindex="0" aria-controls="DataTables_Table_2"
                                type="button" ><span>Delete</span></button>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php echo form_open('admin/seo','method="get"');?>
                        <div id="DataTables_Table_3_filter" class="dataTables_filter">
                            <label>Search:<input type="search" name="keyword" value="<?php echo $keyword;?>" class="form-control form-control-sm" placeholder="Search"
                                    aria-controls="DataTables_Table_3">
                            </label>
                        </div>
                        <?php echo form_close();?>

                    </div>
                </div>
                <?php
                if(is_array($result) && count($result) > 0){
                ?>
                <?php echo form_open('admin/seo','id="form_listing"');?>
                <input type="hidden" id="action_type" name="action_type">
                <table class="table nowrap table-stripedt">
                    <thead>
                        <tr>
                            <th style="width: 10%;" class="dt-body-center sorting_disabled" rowspan="1" colspan="1"
                                aria-label="">
                                <div class="dt-checkbox">
                                    <input type="checkbox" name="arr_ids" value="1" id="example-select-all" onclick="$('input[name*=\'arr_ids\']').prop('checked', this.checked);">
                                    <span class="dt-checkbox-label"></span>
                                </div>
                            </th>
                            <th style="width: 20%;">Page name</th>
                            <th style="width: 40%;">Meta Title</th>                            
                            <th style="width:10%;">Status</th>
                            <th style="width: 20%;">Date</th>
                            <th style="width: 10%;">Action</th>
                        </tr>


                    </thead>
                    <tbody>
                        <?php
                        foreach($result as $k=>$row){
                            $meta_title = $row->meta_title;
                            if(strlen($meta_title)>100){
                                $meta_title = substr($meta_title,0,100).'...';
                            }
                            ?>
                            <tr>
                                <td class=" dt-body-center" tabindex="0">
                                    <div class="dt-checkbox">
                                        <input input type="checkbox" name="arr_ids[]" value="<?php echo  $row->id;?>" value=""><span class="dt-checkbox-label" ></span>
                                        
                                    </div>
                                </td>
                                <td><?php echo $row->page_name;?></td>
                                <td><?php echo $meta_title;?></td>
                                <td>
                                    <?php
                                    if($row->status==1){
                                    ?>
                                    <span class="badge badge-success">Approved</span>
                                    <?php
                                    }else{
                                        ?>
                                        <span class="badge badge-danger">Disapproved</span>
                                        <?php
                                    }
                                    ?>
                                </td>
                                 <td><h5 class="font-16"><?php echo $row->created_at;?></h5></td>
                                <td style="text-align: center;">
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#"
                                            role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">


                                            <!-- <a class="dropdown-item" href="javascript:;" data-toggle="modal"
                                                data-target="#modal-detail">
                                                <i class="dw dw-eye"></i>
                                                View Details</a> -->


                                            <a class="dropdown-item" href="<?php echo site_url('admin/seo/edit/'.$row->id);?><?php echo (($curr_paging)!=NULL)?'?page='.$curr_paging:'';?>">
                                                <i class="dw dw-pencil"></i>
                                                Edit</a>


                                            <a class="dropdown-item" href="<?php echo site_url('admin/seo/delete/'.$row->id);?>" onclick="return confirm('Are you sure? You want to delete this record?');"><i
                                                    class="icon-copy ion-ios-trash-outline"></i>
                                                Delete</a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>


                    </tbody>
                </table>
                <?php echo form_close();?>

                <hr>

                <?php echo $links;?>
               
                <?php
                }else{
                echo ' <div class="card-box mb-20 dataTables_wrapper dt-bootstrap4 pb-20 pt-20 text-center" style="min-height:300px; vertical-align:middle;">No record(s) found.</div>';
                }

                ?>

            </div>


            <!-- filter -->
            <?php echo form_open('admin/seo', 'method="GET"');?> 
            <div class="modal" id="modal">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">
                                Filter
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                data-toggle="tooltip" data-placement="bottom" title=""
                                data-original-title="Close Modal">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body pd-0">



                            <div class="task-list-form">
                                <ul>
                                    <li class="two">

                                        <form>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Keyword</label>
                                                        <div>
                                                            <input type="text" name="keyword" value="<?php echo $keyword;?>" class="form-control" placeholder="Page Name">
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <div>
                                                            <select class="form-control" name="status">

                                                                <option value=''>Select Status</option>
                                                                <option value='0' <?php echo ($status==0)?'selected':'';?>>Disapproved</option>
                                                                <option value='1' <?php echo ($status==1)?'selected':'';?>>Approved</option>
                                                                

                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>


                                            </div>





                                        </form>
                                    </li>

                                </ul>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <input type="submit" value="Search" class="btn btn-primary" />
                            <a href="<?php echo current_url();?>" class="btn btn-warning">Clear Filter</a>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            <?php echo form_close();?>

           
            <!-- <div class="modal" id="modal-detail">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">
                                About Us
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                data-toggle="tooltip" data-placement="bottom" title=""
                                data-original-title="Close Modal">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">



                            <div class="task-list-form">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.<br><br>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                                mollit anim id est laborum.
                            </div>


                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>

            </div> -->
            
               
           
            <?php echo view('Modules\Admin\Views\inc\footer'); ?>
        </div>
    </div>

    <?php echo view('Modules\Admin\Views\inc\bottom'); ?>

    <script>
    $('document').ready(function(){
        $('.action').click(function(){
            
            let section=$(this).attr('data-id');
            $('#action_type').val(section);
            let chk_lenght = $('input[name="arr_ids[]"]:checked').length;
            if(chk_lenght==0){
                alert('To '+section+' please select atleast one record!');
                return false;
            }else{
                let confirmed = confirm('Are you sure? You want to '+section+' the selected record(s)');
                if(confirmed){
                    $('#form_listing').submit();
                }
            }
           
        });
    });
    </script>

</body>

</html>