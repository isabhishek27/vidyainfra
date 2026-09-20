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
                    <div class="col-sm-12 col-md-6"></div>
                    <div class="col-sm-12 col-md-6">
                        <?php echo form_open('admin/cms','method="get"');?>
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
                <?php echo form_open('admin/cms','id="form_listing"');?>
                <input type="hidden" id="action_type" name="action_type">
                <table class="table nowrap table-stripedt">
                    <thead>
                        <tr>
                            <th style="width: 10%;" class="dt-body-center sorting_disabled" rowspan="1" colspan="1"
                                aria-label="">SL No.</th>
                            <th style="width: 50%;">Name</th>
                            <th style="width:30%;">Category</th>
                            <th style="width: 10%;">Action</th>
                        </tr>


                    </thead>
                    <tbody>
                        <?php
                        $cnt=0;
                        foreach($result as $k=>$row){
                            $cnt++;
                            ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $cnt;?></td>
                                <td><h5 class="font-16"><?php echo $row->page_title;?></h5></td>
                                <td><?php echo $row->cat_name;?></td>
                                
                                <td style="text-align: center;">
                                    <div class="dropdown">
                                        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#"
                                            role="button" data-toggle="dropdown">
                                            <i class="dw dw-more"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">


                                            <a class="dropdown-item ViewInDetail" href="javascript:;" data-section="pageDetail" data-rec-id="<?php echo $row->page_id;?>"><i class="dw dw-eye"></i>View Details</a>


                                            <a class="dropdown-item" href="<?php echo site_url('admin/cms/edit_page/'.$row->page_id);?><?php echo (($curr_paging)!=NULL)?'?page='.$curr_paging:'';?>"><i class="dw dw-pencil"></i>Edit</a>

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
            <?php echo form_open('admin/cms', 'method="GET"');?> 
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
                                                        <label>Categories</label>
                                                        <div>
                                                            <select class="form-control" name="category_id">

                                                                <option value=''>Category</option>
                                                                <?php
                                                                foreach($categories as $ck=>$cv){
                                                                    $sel = ($cv->id == $category_id)?'selected':'';
                                                                    echo '<option value="'.$cv->id.'" '.$sel.'>'.$cv->cat_name.'</option>';
                                                                }
                                                                ?>
                                                                

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

           
            <div class="modal" id="modal-detail">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle"><span id="pageTitle">Page Name</span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                data-toggle="tooltip" data-placement="bottom" title=""
                                data-original-title="Close Modal">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="task-list-form" id="pageDesc">Page Content</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
               
           
            <?php echo view('Modules\Admin\Views\inc\footer'); ?>
        </div>
    </div>

    <?php echo view('Modules\Admin\Views\inc\bottom'); ?>
    

</body>

</html>