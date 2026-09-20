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

                            <button class="btn btn-outline-primary action" data-id='delete' tabindex="0" aria-controls="DataTables_Table_2"
                                type="button" ><span>Delete</span></button>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-6">
                        <?php echo form_open('admin/workshop/waitinglist','method="get"');?>
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
                <?php echo form_open('admin/workshop/waitinglist','id="form_listing"');?>
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
                            <th style="width: 20%;">Name</th>
                            <th style="width: 10%;">Mobile</th>
                            <th style="width: 20%;">Email</th>
                            <th style="width: 10%;">Workshop</th>                            
                            <th style="width:10%;">Date</th>
                            <th style="width:10%;">Status</th>
                            <th style="width: 10%;">Action</th>
                        </tr>


                    </thead>
                    <tbody>
                        <?php
                        foreach($result as $k=>$row){
                            ?>
                            <tr>
                                <td class=" dt-body-center" tabindex="0">
                                    <div class="dt-checkbox">
                                        <input input type="checkbox" name="arr_ids[]" value="<?php echo  $row->id;?>" value=""><span class="dt-checkbox-label" ></span>
                                        
                                    </div>
                                </td>
                                <td><?php echo $row->name;?> </td>
                                <td><?php echo $row->phone;?></td>
                                <td><?php echo $row->email;?></td>
                                <td><?php echo $row->workshop_name;?></td>                                
                                <td><?php echo $row->created_at;?></td>
                                <td>
                                    <?php
                                    if($row->status==1){
                                    ?>
                                    <span class="badge badge-danger">Notify mail sent</span>
                                    <?php
                                    }elseif($row->status==0){
                                    ?>
                                    <span class="badge badge-success">In Waiting List</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                                
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
                                             <!-- <a class="dropdown-item ViewInDetail" href="javascript:;" data-section="requestQuoteDetail" data-rec-id="<?php echo $row->id;?>"><i class="dw dw-eye"></i>View Details</a>                                               -->


                                            <a class="dropdown-item" href="<?php echo site_url('admin/workshop/waitinglist_delete/'.$row->id);?>" onclick="return confirm('Are you sure? You want to delete this record?');"><i
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
            <?php echo form_open('admin/workshop/waitinglist', 'method="GET"');?> 
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
                                                            <input type="text" name="keyword" value="<?php echo $keyword;?>" class="form-control" placeholder="Name">
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <div>
                                                            <select class="form-control" name="status">

                                                                <option value=''>Select Status</option>
                                                                <option value='1' <?php echo ($status==1)?'selected':'';?>>Notify email sent</option>
                                                                <option value='0' <?php echo ($status==0)?'selected':'';?>>In Waiting List</option>

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